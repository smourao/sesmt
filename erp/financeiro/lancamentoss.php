<?PHP
if($_POST){
$a = 0;
$today = date("Y/m/d");
$hoje = date("Y-m-d");
$semana = date("W");
$ano = date("Y");


$valor = str_replace(".", "", $_POST['valor']);
$valor = str_replace(",", ".", $valor);

$date = explode("/", $_POST['data']);
$date[0] = STR_PAD($date[0], 2, "0", STR_PAD_LEFT);
$date[1] = STR_PAD($date[1], 2, "0", STR_PAD_LEFT);

$es = explode("/",$_POST['entsai']);
$es[0] = STR_PAD($es[0], 2, "0", STR_PAD_LEFT);
$es[1] = STR_PAD($es[1], 2, "0", STR_PAD_LEFT);


$tipo_debito = $_POST[tipo_debito];

/*********************************************************************************************/
//VERIFICA SE PAGAMENTO INSERI OU NÃO Nº DO CHEQUE
/*********************************************************************************************/

	$query_fatura_max = "SELECT max(id) as cod_fatura FROM financeiro_info";
	$result_fatura_max = pg_query($query_fatura_max);
	$row_fatura_max = pg_fetch_array($result_fatura_max);
	
	$query_relatorio_max = "SELECT max(id) as cod_relatorio FROM financeiro_relatorio";
	$result_relatorio_max = pg_query($query_relatorio_max);
	$row_relatorio_max = pg_fetch_array($result_relatorio_max);
	
	$cod_faturamax = $row_fatura_max[cod_fatura] + 1;
	$cod_relatoriomax = $row_relatorio_max[cod_relatorio] + 1;



if($_POST['forma_pagamento'] == "Cheque" || $_POST['forma_pagamento'] == "Cheque pré-datado"){
   $sql = "INSERT INTO financeiro_info
   (id, titulo, valor_total, n_parcelas, forma_pagamento, status, data, dia, mes, ano,
   data_lancamento, data_entrada_saida, tipo_lancamento, historico, numero_cheque)
   VALUES
   ('{$cod_faturamax}', '".addslashes($_POST['titulo'])."', '{$valor}', '".addslashes($_POST['parcelas'])."',
   '".addslashes($_POST['forma_pagamento'])."',
   '{$_POST['lancamento']}', '".date("Y/m/d", strtotime($date[2]."/".$date[1]."/".$date[0]))."', '{$date[0]}','{$date[1]}','{$date[2]}',
   '{$today}', '".date("Y/m/d", strtotime($es[2]."/".$es[1]."/".$es[0]))."', '{$_POST['tipo_pagamento']}', '".addslashes($_POST['historico'])."', '{$_POST['numero_do_cheque']}')";
}else{
   $sql = "INSERT INTO financeiro_info
   (id, titulo, valor_total, n_parcelas, forma_pagamento, status, data, dia, mes, ano,
   data_lancamento, data_entrada_saida, tipo_lancamento, historico)
   VALUES
   ('{$cod_faturamax}', '".addslashes($_POST['titulo'])."', '{$valor}', '".addslashes($_POST['parcelas'])."',
   '".addslashes($_POST['forma_pagamento'])."',
   '{$_POST['lancamento']}', '".date("Y/m/d", strtotime($date[2]."/".$date[1]."/".$date[0]))."', '{$date[0]}','{$date[1]}','{$date[2]}',
   '{$today}', '".date("Y/m/d", strtotime($es[2]."/".$es[1]."/".$es[0]))."', '{$_POST['tipo_pagamento']}', '".addslashes($_POST['historico'])."')";
}
if(pg_query($sql)){
   $a++;
}else{
   die('Erro ao adicionar informações no banco de dados![info]');
}

$sql = "SELECT MAX(id) FROM financeiro_info WHERE valor_total = '$valor'";
$result = pg_query($sql);
$max = pg_fetch_array($result);
$valor_parcela = round(($valor/$_POST['parcelas']), 2);

for($x=0;$x<$_POST['parcelas'];$x++){
   //MARCAR COMO JA PAGO CASO SEJA: DEBITO EM DINHEIRO, CHEQUE, DEBITO AUTOMATICO E 1 PARCELA
   if($_POST['parcelas']==1 && $_POST['lancamento']==1 && ($_POST['forma_pagamento']=="Dinheiro" || $_POST['forma_pagamento']=="Cheque" || $_POST['forma_pagamento']=="Débito automático")){
        $pago = 1;
   }else{
        $pago = 0;
   }
/*********************************************************************************************/
//SQL PARA INSERT DE LANÇAMENTO NAS FATURAS
/*********************************************************************************************/
   if($_POST['lancamento'] == 1 || $_POST['parcelas'] == 1){
         $sql = "INSERT INTO financeiro_fatura
         (cod_fatura, titulo, valor, parcela_atual, vencimento, status, pago, data_lancamento,
         numero_doc, numero_cheque)
         VALUES
         ('{$max[0]}','".addslashes($_POST['titulo'])."', '{$valor_parcela}',
         '".($x+1)."', '".date("Y/m/d", mktime(0,0,0,$date[1]+$x, $date[0], $date[2]))."',
         '{$_POST['lancamento']}', {$pago}, '{$today}', '{$_POST['doc_num']}', '{$_POST['numero_do_cheque']}')";
   }else{
      $sql = "INSERT INTO financeiro_fatura
      (cod_fatura, titulo, valor, parcela_atual, vencimento, status, pago, data_lancamento, numero_cheque)
      VALUES
      ('{$max[0]}','".addslashes($_POST['titulo'])."', '{$valor_parcela}',
      '".($x+1)."', '".date("Y/m/d", mktime(0,0,0,$date[1]+$x, $date[0], $date[2]))."',
      '{$_POST['lancamento']}', {$pago}, '{$today}', '{$_POST['numero_do_cheque']}')";
   }
   if(pg_query($sql)){
     $a++;
   }else{
      die('Erro ao adicionar informações no banco de dados![fatura]');
   }
}

if($tipo_debito == 0){
	
	$relatoriosql = "INSERT INTO financeiro_relatorio (id, cod_fatura,titulo,valor,status,pago,historico,data_lancamento,semana,ano)VALUES ('{$cod_relatoriomax}','{$max[0]}','".addslashes($_POST['titulo'])."',$valor,1,1,'".addslashes($_POST['historico'])."','$hoje','$semana','$ano');";
	$relatorioquery = pg_query($relatoriosql);
	
	
}



if($a >= 2){
   echo "<script>alert('Lançamento efetuado com sucesso!');</script>";
}else{
   echo "<script>alert('Inconsistência de dados, verifique se os dados foram cadastrados corretamente!');</script>";
}
}
?>
<table border=0 width=100%>
<tr>
<td>
<b>Inclusão de Lançamento</b>
</td>
</tr>
</table>
<p>
<form method="POST" action="?s=lancamentos" name=frm>
<table border=0 width=100%>
<tr>
    <td>
    <input type=radio id=lancamento name=lancamento value="1" onclick="change_es(this);j_parcelas(document.getElementById('parcelas').value);tipo_de_debito();" <?PHP print $_POST[lancamento] == "1" ? " checked ":"";if(!isset($_POST[lancamento])) echo " checked ";?>>Débito
    <input type=radio id=lancamento name=lancamento value="0" onclick="change_es(this);j_parcelas(document.getElementById('parcelas').value);tipo_de_debito();" <?PHP print $_POST[lancamento] == "0" ? " checked ":"";?>>Crédito
    </td>
</tr>
<table border=0 width=100%>
<tr>
    <td width=160>Título do Lançamento</td>
    <td>
    <input type=text size=50 name="titulo" id="titulo" value="<?PHP //echo $_POST['titulo'];?>" style="z-index:1;" onkeyup="autocomplete(this);">
       <div id=autocomplete style="width: 278px;border: 1px dotted; border-color:#FFFFFF;position: absolute;z-index: 2;background-color:#006633;float: left;/*left: -100px;*/ display: none;">
          <table width=100% border=0>
          <tr><td align=right>
             <a href="javascript:close_autocomplete();" class=fontebranca12>Fechar [X]</a>
          </td></tr>
          </table>
       </div>
    </td>
</tr>
<tr>
    <td>Número de Parcelas</td>
    <td>
        <input type=text size=10 name="parcelas" id="parcelas" value="<?PHP //echo $_POST['parcelas'];?>" onchange="j_parcelas(this.value);"  style="z-index:1;">
    </td>
</tr>
<tr>
    <td>Valor Total</td>
    <td><input type=text size=10 name="valor" id="valor" value="<?PHP //echo $_POST['valor'];?>" onkeypress="return FormataReais(this, '.', ',', event);"></td>
</tr>

<tr>
    <td>Data de Vencimento</td>
    <td>
    <!--
    <input type=text size=10 name="data" id="data" onkeypress="formataDataDigitada(this);">
    -->

    <?PHP
       $dat = explode("/", $_POST['data']);
       if($dat[1] > 0 && $dat[2]>0){
          echo "<input type=text size=10 name=\"data\" id=\"data\" value=\"{$_POST['data']}\" onkeypress=\"formataDataDigitada(this);\"  Onclick=\"javascript:popdate('document.frm.data','pop1','150',document.frm.data.value, {$dat[1]}, {$dat[2]})\">";
          echo "<input type=image src='calendario.gif' width=15 height=15 Onclick=\"javascript:popdate('document.frm.data','pop1','150',document.frm.data.value, {$dat[1]}, {$dat[2]}); return false;\">";
          //echo "<img src=\"calendario.jpg\" width=\"30\" height=30 border=0 Onclick=\"javascript:popdate('document.frm.data','pop1','150',document.frm.data.value, {$dat[1]}, {$dat[2]})\">";
       }else{
          echo "<input type=text size=10 name=\"data\" id=\"data\" value=\"\" onkeypress=\"formataDataDigitada(this);\"  Onclick=\"popdate('document.frm.data','pop1','150',document.frm.data.value);return false; \">";
          echo "<input type=image src='calendario.gif' width=15 height=15 Onclick=\"javascript:popdate('document.frm.data','pop1','150',document.frm.data.value); return false;\">";
          //echo "<img src=\"calendario.jpg\" width=\"30\" height=30 border=0 Onclick=\"javascript:popdate('document.frm.data','pop1','150',document.frm.data.value)\">";
       }
    ?>

    <span id="pop1" style="position:absolute"></span>
<!--    <input TYPE="button" NAME="btnData1" VALUE="..." Onclick="javascript:popdate('document.frm.data','pop1','150',document.frm.data.value)"> -->
    </td>
</tr>

<tr>
    <td>Data de <span id=es>Saída</span></td>
    <td>
    <!--
    <input type=text size=10 name="data" id="data" onkeypress="formataDataDigitada(this);">
    -->

    <?PHP
       $dates = explode("/", $_POST['entsai']);
       if($dates[1] > 0 && $dates[2]>0){
          echo "<input type=text size=10 name=\"entsai\" id=\"entsai\" value=\"{$_POST['entsai']}\" onkeypress=\"formataDataDigitada(this);\"  Onclick=\"javascript:popdate('document.frm.entsai','pop2','150',document.frm.entsai.value, {$dates[1]}, {$dates[2]})\">";
          echo "<input type=image src='calendario.gif' width=15 height=15 Onclick=\"javascript:popdate('document.frm.entsai','pop2','150',document.frm.entsai.value, {$dat[1]}, {$dat[2]}); return false;\">";
          //echo "<img src=\"calendario.jpg\" width=\"30\" height=30 border=0 Onclick=\"javascript:popdate('document.frm.data','pop1','150',document.frm.data.value, {$dat[1]}, {$dat[2]})\">";
       }else{
          echo "<input type=text size=10 name=\"entsai\" id=\"entsai\" value=\"\" onkeypress=\"formataDataDigitada(this);\"  Onclick=\"popdate('document.frm.entsai','pop2','150',document.frm.entsai.value);return false; \">";
          echo "<input type=image src='calendario.gif' width=15 height=15 Onclick=\"javascript:popdate('document.frm.entsai','pop2','150',document.frm.entsai.value); return false;\">";
          //echo "<img src=\"calendario.jpg\" width=\"30\" height=30 border=0 Onclick=\"javascript:popdate('document.frm.data','pop1','150',document.frm.data.value)\">";
       }
    ?>

    <span id="pop2" style="position:absolute"></span>
<!--    <input TYPE="button" NAME="btnData1" VALUE="..." Onclick="javascript:popdate('document.frm.data','pop1','150',document.frm.data.value)"> -->
    </td>
</tr>
<tr>
    <td>Número do Documento</td>
    <td>
        <span id=docn style="display: inline;">
          <input type=text size=10 name="doc_num" id="doc_num" value="<?PHP //echo $_POST['parcelas'];?>" onchange=""  style="z-index:1;">
        </span>
    </td>
</tr>
<tr>
    <td>Tipo de Lançamento</td>
    <td>
    <?PHP
       $sql = "SELECT * FROM financeiro_identificacao";
       $r = pg_query($sql);
       $id = pg_fetch_all($r);
       echo '<select name="tipo_pagamento" id="tipo_pagamento">';
       for($x=0;$x<pg_num_rows($r);$x++){
          echo "<option value='{$id[$x]['id']}' "; print $id[$x]['id'] == $_POST[tipo_pagamento] ? " selected ":" "; echo" >{$id[$x]['sigla']}</option>";
       }
       echo '</select>';
    ?>
    </td>
</tr>
<tr>
    <td>Forma de Pagamento</td>
    <td>
    <!--
    <input type=text size=10 name="forma_pagamento" value="<?PHP //echo $_POST['forma_pagamento'];?>" id="forma_pagamento" onchange="">
    -->
    <select name="forma_pagamento" id=forma_pagamento onchange="payment_method(this);">
       <option value="Dinheiro" <?PHP print $_POST[forma_pagamento] == "Dinheiro" ? " selected ": "";?> >Dinheiro</option>
       <option value="Boleto" <?PHP print $_POST[forma_pagamento] == "Boleto" ? " selected ": "";?> >Boleto</option>
       <option value="Cartão de crédito" <?PHP print $_POST[forma_pagamento] == "Cartão de crédito" ? " selected ": "";?> >Cartão de crédito</option>
       <option value="Cheque" <?PHP print $_POST[forma_pagamento] == "Cheque" ? " selected ": "";?> >Cheque</option>
       <option value="Cheque pré-datado" <?PHP print $_POST[forma_pagamento] == "Cheque pré-datado" ? " selected ": "";?> >Cheque pré-datado</option>
       <option value="Débito automático" <?PHP print $_POST[forma_pagamento] == "Débito automático" ? " selected ": "";?> >Débito automático</option>
       <option value="Duplicata" <?PHP print $_POST[forma_pagamento] == "Duplicata" ? " selected ": "";?> >Duplicata</option>
       <option value="Nota de Crédito" <?PHP print $_POST[forma_pagamento] == "Nota de Crédito" ? " selected ": "";?> >Nota de Crédito</option>
       <option value="Recíbo" <?PHP print $_POST[forma_pagamento] == "Recíbo" ? " selected ": "";?> >Recíbo</option>
       <option value="RioCard" <?PHP print $_POST[forma_pagamento] == "RioCard" ? " selected ": "";?> >RioCard</option>
    </select>
    <span id=cheque_number style="display: none;">Nº Cheque <input type=text size=8 name=numero_do_cheque id=numero_do_cheque></span>
    <script>payment_method(document.getElementById("forma_pagamento"));</script>
    </td>
</tr>

<tr>
    <td>Histórico</td>
    <td>
    <textarea name=historico id=historico cols=38></textarea>
    </td>
</tr>
<tr>
	<td>Tipo de Débito</td>
    <td>
    <span id="esconde_tipo" style="display: inline;">
    <select name="tipo_debito" required>
    	<option value="">
        </option>
    	<option value="0">
        Interno
        </option>
        <option value="1">
        Externo
        </option>
    </select>
    </span>
    </td>
</tr>
</table>
<center>  <p>
<input type=submit class=button value="Incluir Lançamento" onclick="return check_lan();">
</form>
