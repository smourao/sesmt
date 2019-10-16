<?PHP
//print_r($_SERVER);
if($_GET['act'] == "del"){
   if(is_numeric($_GET['lan'])){
      //
      $sql = "DELETE FROM financeiro_fatura WHERE cod_fatura = {$_GET['lan']}";
      if(pg_query($sql)){
         $sql = "DELETE FROM financeiro_info WHERE id={$_GET['lan']}";
         if(pg_query($sql)){
            //alert executado com sucesso;
            echo "<script>alert('Lançamento nº {$_GET['lan']} excluído!');</script>";
         }
      }else{
         //erro ao remover faturas
         echo "<script>alert('Erro ao excluir lançamento!');</script>";
      }
   }
}

//print_r($_POST);
if($_POST['Salvar']){
   if(is_numeric($_GET['lan'])){
      $sql = "SELECT * FROM financeiro_info WHERE id = {$_GET['lan']}";
      $result = pg_query($sql);
      $buffer = pg_fetch_all($result);

      $sql = "SELECT * FROM financeiro_fatura WHERE cod_fatura = {$_GET['lan']}";
      $r = pg_query($sql);
      $ret = pg_fetch_all($r);
      $pago = 0;
      for($x=0;$x<pg_num_rows($r);$x++){
         if($ret[$x]['pago'] > 0)$pago++;
      }
   }
   if($_POST[titulo] == $buffer[0][titulo] &&
   $_POST[parcelas] == $buffer[0][n_parcelas] &&
   $_POST[total] == $buffer[0][valor_total] &&
   $_POST[vencimento] == date("d/m/Y", strtotime($buffer[0]['data'])) &&
   $_POST[data_es] == date("d/m/Y", strtotime($buffer[0]['data_entrada_saida'])) &&
   $_POST[tipo_pagamento] == $buffer[0][tipo_lancamento] &&
   $_POST[forma_pagamento] == $buffer[0][forma_pagamento] &&
   $_POST[slan] == $buffer[0][status] &&
   $_POST[historico] == $buffer[0][historico]){
      //NÃO ALTERAR NADA
   }else{
      //ALTERA STATUS SE DIFERENTE DA DATABASE
      if($_POST[slan] != $buffer[0][status]){
          $sql = "UPDATE financeiro_fatura SET status='$_POST[slan]'
                  WHERE cod_fatura = '{$_GET['lan']}'";
          pg_query($sql);
      }
      //SE NUMERO DE PARCELAS NAO FOI ALTERADO
      if($_POST[parcelas] == $buffer[0][n_parcelas]){
         $date = explode("/", $_POST['vencimento']);
         $date[0] = STR_PAD($date[0], 2, "0", STR_PAD_LEFT);
         $date[1] = STR_PAD($date[1], 2, "0", STR_PAD_LEFT);
         $es = explode("/",$_POST['data_es']);
         $es[0] = STR_PAD($es[0], 2, "0", STR_PAD_LEFT);
         $es[1] = STR_PAD($es[1], 2, "0", STR_PAD_LEFT);
         
         if(strlen($_POST['total'])>6){
            $valor = str_replace(".", "", $_POST['total']);
            $valor = str_replace(",", ".", $valor);
         }else{
            $valor = str_replace(",", ".", $_POST['total']);
            //$valor = $_POST['total'];//VER ISSO AMANHÃ, TA ENVIANDO SEM . e SEM ,
         }
         $valor_parcela = round(($valor/$_POST['parcelas']), 2);

         //SE VALOR TOTAL NAO FOI ALTERADO E PARCELAS TBM, NAO MEXE NAS FATURAS
         if($_POST[total] == $buffer[0]['valor_total']){
            $sql = "UPDATE financeiro_info SET titulo='".addslashes($_POST['titulo'])."',
            valor_total='{$valor}', forma_pagamento='{$_POST['forma_pagamento']}',
            data='".date("Y/m/d", strtotime($date[2]."/".$date[1]."/".$date[0]))."',
            data_entrada_saida='".date("Y/m/d", strtotime($es[2]."/".$es[1]."/".$es[0]))."',
            tipo_lancamento='{$_POST['tipo_pagamento']}',
            historico='".addslashes($_POST['historico'])."',
            status='$_POST[slan]'
            WHERE id='{$_GET['lan']}'";
            //echo $sql;
            if(pg_query($sql)){
               //echo "Dados atualizados sem alteração no valor e nº de parcelas, sem mecher na tabela de faturas.";
            }else{
               echo "Erro ao atualizar dados na database. [Cod. 69]";
            }
         }else{
            #PRECISA REFAZER AS FATURAS, PQ O VALOR FOI ALTERADO
            $sql = "UPDATE financeiro_info SET titulo='".addslashes($_POST['titulo'])."',
            valor_total='{$valor}', forma_pagamento='{$_POST['forma_pagamento']}',
            data='".date("Y/m/d", strtotime($date[2]."/".$date[1]."/".$date[0]))."',
            data_entrada_saida='".date("Y/m/d", strtotime($es[2]."/".$es[1]."/".$es[0]))."',
            tipo_lancamento='{$_POST['tipo_pagamento']}',
            historico='".addslashes($_POST['historico'])."',
            status='$_POST[slan]'
            WHERE id='{$_GET['lan']}'";
            //echo $sql;
            if(pg_query($sql)){
               //
               $sql = "SELECT * FROM financeiro_fatura WHERE cod_fatura='{$_GET['lan']}'";
               $re = pg_query($sql);
               $fd = pg_fetch_all($re);
               
               for($x=0;$x<pg_num_rows($re);$x++){
                  $sql = "UPDATE financeiro_fatura SET valor='{$valor_parcela}',
                  titulo='".addslashes($_POST['titulo'])."',
                  vencimento='".date("Y/m/d", mktime(0,0,0,$date[1]+$x, $date[0], $date[2]))."'
                  WHERE cod_fatura = '{$_GET['lan']}' AND id = '{$fd[$x]['id']}'
                  ";
                  pg_query($sql);
               }
            }else{
               //
            }
         }
      }else{
         if($pago > 0){
            //Não pode alterar os valores por que o número de parcelas não é o mesmo
            echo "[Se alguma foi paga]Não pode alterar pq as parcelas estão diferentes";
         }else{
            //NENHUMA FOI PAGA, DELETAR AS FATURAS E REFAZÊ-LAS!!!
         }
      }
   }
}
//PEGA DADOS ATUALIZADOS CASO SEJA FEITO O POST PARA MOSTRAR ABAIXO
//MESMO QUERY NO INICIO UTILIZADO PARA O UPDATE
if(is_numeric($_GET['lan'])){
   $sql = "SELECT * FROM financeiro_info WHERE id = {$_GET['lan']}";
   $result = pg_query($sql);
   $buffer = pg_fetch_all($result);
   
   if(pg_num_rows($result) <= 0){
      echo "<script>location.href='?s=resumo';</script>";
   }

   $sql = "SELECT * FROM financeiro_fatura WHERE cod_fatura = {$_GET['lan']}";
   $r = pg_query($sql);
   $ret = pg_fetch_all($r);
   $pago = 0;
   for($x=0;$x<pg_num_rows($r);$x++){
      if($ret[$x]['pago'] > 0)$pago++;
   }
}



?>
<table border=0 width=100%>
<tr>
<td>
<b>Editar Lançamento Nº:</b> <?PHP echo $_GET['lan'];?>
</td>
</tr>
</table>
<p>
<form method="POST">
<table border=1 width=100%>
<tr>
<td width=170 >Título do Lançamento</td>
<td><input type=text name=titulo size=50 value="<?PHP echo $buffer[0]['titulo'];?>"></td>
</tr>
<tr>
<td width=170 >Número de Parcelas</td>
<td><input type=text name=parcelas value="<?PHP echo $buffer[0]['n_parcelas'];?>"></td>
</tr>

<tr>
<td width=170 >Valor Total</td>
<td><input type=text name=total value="<?PHP echo $buffer[0]['valor_total'];?>"  onkeypress="return FormataReais(this, '.', ',', event);"></td>
</tr>


<tr>
<td width=170 >Data de Vencimento</td>
<td><input type=text name=vencimento value="<?PHP echo date("d/m/Y", strtotime($buffer[0]['data']));?>"></td>
</tr>



<tr>
<td width=170 >Data de Entrada/Saída</td>
<td><input type=text name=data_es value="<?PHP echo date("d/m/Y", strtotime($buffer[0]['data_entrada_saida']));?>"></td>
</tr>

<tr>
<td width=170 >Lançamento</td>
<td>
    <select name='slan' id='slan'>
        <option value='0' <?PHP if(!$buffer[0][status]){echo " selected ";}?>>Receita</option>
        <option value='1' <?PHP if($buffer[0][status]){echo " selected ";}?>>Despesa</option>
    </select>
</td>
</tr>


<tr>
<td width=170 >Tipo de Lançamento</td>
<td>
    <?PHP
       $sql = "SELECT * FROM financeiro_identificacao ORDER BY sigla";
       $r = pg_query($sql);
       $id = pg_fetch_all($r);
       echo '<select name="tipo_pagamento" id="tipo_pagamento">';
       for($x=0;$x<pg_num_rows($r);$x++){
          echo "<option value='{$id[$x]['id']}' "; print $id[$x]['id'] == $buffer[0][tipo_lancamento] ? " selected ":" "; echo" >{$id[$x]['sigla']}</option>";
       }
       echo '</select>';
    ?>

</td>
</tr>

<tr>
<td width=170 >Forma de Pagamento</td>
<td>

    <select name="forma_pagamento" id=forma_pagamento>
       <option value="Dinheiro" <?PHP print $buffer[0][forma_pagamento] == "Dinheiro" ? " selected ": "";?> >Dinheiro</option>
       <option value="Boleto" <?PHP print $buffer[0][forma_pagamento] == "Boleto" ? " selected ": "";?> >Boleto</option>
       <option value="Cheque" <?PHP print $buffer[0][forma_pagamento] == "Cheque" ? " selected ": "";?> >Cheque</option>
       <option value="Cheque pré-datado" <?PHP print $buffer[0][forma_pagamento] == "Cheque pré-datado" ? " selected ": "";?> >Cheque pré-datado</option>
       <option value="Cartão de crédito" <?PHP print $buffer[0][forma_pagamento] == "Cartão de crédito" ? " selected ": "";?> >Cartão de crédito</option>
       <option value="Débito automático" <?PHP print $buffer[0][forma_pagamento] == "Débito automático" ? " selected ": "";?> >Débito automático</option>
       <option value="Recíbo" <?PHP print $buffer[0][forma_pagamento] == "Recíbo" ? " selected ": "";?> >Recíbo</option>
       <option value="Duplicata" <?PHP print $buffer[0][forma_pagamento] == "Duplicata" ? " selected ": "";?> >Duplicata</option>
       <option value="Nota de Crédito" <?PHP print $buffer[0][forma_pagamento] == "Nota de Crédito" ? " selected ": "";?> >Nota de Crédito</option>
    </select>


</td>
</tr>

<tr>
<td width=170 >Histórico</td>
<td>
<textarea name=historico>
<?PHP echo $buffer[0]['historico'];?>
</textarea>
</td>
</tr>
</table>
<p>
<center>
<input type=submit name="Salvar" value="Salvar"> <input type=button name="Excluir" value="Excluir" onClick="if(confirm('Tem certeza que deseja excluir?')){location.href='?s=editar&lan=<?PHP echo $_GET['lan'];?>&act=del';}">
</center>
<p>

<?PHP
echo "<center><b>Parcelas</b></center><br>";
$sql = "SELECT * FROM financeiro_fatura WHERE  cod_fatura='{$_GET['lan']}' ORDER BY vencimento";
$result = pg_query($sql);
$data = pg_fetch_all($result);
echo "<table width=100% border=1 >";
echo "<tr>";
echo "   <td align=center><b>Título</b></td>";
echo "   <td align=center width=90><b>Vencimento</b></td>";
echo "   <td align=center width=50><b>Parcela</b></td>";
echo "   <td align=center width=150><b>Valor</b></td>";
echo "   <td align=center width=100><b>Ação</b></td>";
echo "</tr>";
for($x=0;$x<pg_num_rows($result);$x++){
echo "<tr>";
echo "   <td><input type=text name='titulo{$data[$x]['id']}' id='titulo{$data[$x]['id']}' value='{$data[$x]['titulo']}' size=45></td>";
echo "   <td align=center><input size=10 type=text name='data{$data[$x]['id']}' id='data{$data[$x]['id']}' value='".date("d/m/Y", strtotime($data[$x]['vencimento']))."'></td>";
echo "   <td align=center>{$data[$x]['parcela_atual']}/".pg_num_rows($result)."</td>";
echo "   <td align=right>R$ <input size=10 type=text name='valor{$data[$x]['id']}' id='valor{$data[$x]['id']}' value='".number_format($data[$x]['valor'], 2, ".",",")."' onkeypress=\"return FormataReais(this, '.', ',', event);\"></td>";
echo "   <td align=center><a href='javascript:update_parcela({$data[$x]['id']});' class='fontebranca12'>Atualizar</a></td>";
echo "</tr>";
}
//onkeypress="return FormataReais(this, '.', ',', event);"
echo "</table>";
?>
<input type=hidden value='' id=temp name=temp>

<p>

</form>

