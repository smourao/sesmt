<?PHP
//CHECA MÊS
if(isset($_GET['m'])){
    $mes = $_GET['m'];
}else{
    $mes = date("m");
}
//CHECA ANO
if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}
$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
?>
<table border=0 width=100%>
<tr>
<td>
<form method=post>
<b>Pesquisa de Lançamento</b>&nbsp;
<br>
<table border=0>
<tr>
   <td>Nome</td>
   <td colspan=2><input type=text name=razao id=razao <?PHP if($_POST){echo " value='{$_POST['razao']}' ";}?> ></td>
</tr>
<tr>
   <td>Ano</td>
   <td><input type=text size=4 maxlength=4 name=ano <?PHP if($_POST){echo " value='{$_POST['ano']}' ";}else{echo " value='".date("Y")."' ";}?> onkeyup="if(this.value.length>=4){document.getElementById('mes').focus();}"></td>
   <td>
   <input type=radio name=lancamento value=1 <?PHP if(!$_POST || $_POST['lancamento'] == 1){echo ' checked ';};?>>Despesa<br>
   <input type=radio name=lancamento value=0 <?PHP if($_POST && $_POST['lancamento'] == 0){echo ' checked ';};?>>Receita
   </td>
</tr>
<tr>
   <td>Mês</td>
   <td><input type=text size=4 name=mes maxlength=2 id=mes <?PHP if($_POST){echo " value='{$_POST['mes']}' ";}else{echo " value='".date("m")."' ";}?>></td>
   <td size=50 align=center><input type=submit value="Pesquisar"></td>
</tr>
</table>
<!--
<input type=text name=search id=search value="<?PHP echo $_POST['search'];?>">&nbsp;
<input type=submit value="Pesquisar">
-->
</form>

</td>
</tr>
</table>
<p>
<?PHP
   if($mes >= 12){
      $n_mes = 01;
      $n_ano = $ano+1;
      $p_mes = $mes-1;
      $p_ano = $ano;
   }elseif($mes <= 01){
     $n_mes = $mes+1;
     $n_ano = $ano;
     $p_mes = 12;
     $p_ano = $ano-1;
   }else{
      $n_mes = STR_PAD($mes+1, 2, "0", STR_PAD_LEFT);
      $n_ano = $ano;
      $p_mes = STR_PAD($mes-1, 2, "0", STR_PAD_LEFT);
      $p_ano = $ano;
   }
   
   $p_ano = STR_PAD($p_ano, 2, "0", STR_PAD_LEFT);
   $p_mes = STR_PAD($p_mes, 2, "0", STR_PAD_LEFT);
   $n_ano = STR_PAD($n_ano, 2, "0", STR_PAD_LEFT);
   $n_mes = STR_PAD($n_mes, 2, "0", STR_PAD_LEFT);

//   echo "<center><a href=\"javascript:location.href='?s=resumo&m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?s=resumo&m=$n_mes&y=$n_ano'\" class=fontebranca12>>></a></center>";
?>
<P>
<table border=1 width=100%>
<tr>
   <td width=70 align=center><b>Venc.</b></td>
   <td align=center><b>Título</b></td>
   <td align=center width=20><b>Parcela</b></td>
   <td align=center width=100><b>Valor</b></td>
   <td align=center width=50><b>Ação</b></td>
</tr>
<?PHP
if($_POST){
if(empty($_POST[razao])){
$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   --i.mes = substr('2009-04-07', 7, 1) AND
   substr(f.vencimento, 6,2) = '{$_POST['mes']}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   substr(f.vencimento, 1,4) = '{$_POST['ano']}' AND
   (i.id = f.cod_fatura) AND
   i.status = '".$_POST['lancamento']."'
--   AND
--   ( lower(i.historico) LIKE '%".strtolower($_POST['search'])."%' OR
--     lower(f.titulo) LIKE '%".strtolower($_POST['search'])."%' OR
--     lower(f.numero_doc) LIKE '%".strtolower($_POST['search'])."%' )
   ORDER BY
   f.vencimento
";
}else{
$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   substr(f.vencimento, 6,2) >= '01' AND -- SELECIONA APENAS O MES ESPECÍFICO
   substr(f.vencimento, 1,4) = ".date("Y")." AND
   (i.id = f.cod_fatura) AND
   i.status = '".$_POST['lancamento']."'  AND
   ( lower(i.historico) LIKE '%".strtolower($_POST['razao'])."%' OR
     lower(f.titulo) LIKE '%".strtolower($_POST['razao'])."%' OR
     lower(f.numero_doc) LIKE '%".strtolower($_POST['razao'])."%' )
   ORDER BY
   f.vencimento
";

}
}else{

$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   --i.mes = substr('2009-04-07', 7, 1) AND
   substr(f.vencimento, 6,2) = '{$mes}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   substr(f.vencimento, 1,4) = '{$ano}' AND -- SELECIONA APENAS O ANO ESPECÍFICO
   (i.id = f.cod_fatura )
ORDER BY
   f.vencimento -- POR VENCIMENTO
";
$sql = "SELECT * FROM financeiro_info WHERE 1=2";
}
$result = pg_query($sql);
$data = pg_fetch_all($result);

$total_mes = 0;
for($x=0;$x<pg_num_rows($result);$x++){
if($data[$x]['status'] == 0){
   $total_mes += $data[$x]['valor'];
   $bg_color = array("#cfded2","#e5eae6");
}else{
   $total_mes -= $data[$x]['valor'];
   $bg_color = array("#d8caca","#eadcdc");
}

$msg = "<center><b>".addslashes($data[$x]['titulo'])."</b></center><p>";
$msg .= "<b>Data de Lançamento: </b>".date("d/m/Y", strtotime($data[$x]['data_lancamento']))."<br>";
$msg .= "<b>Data de Vencimento: </b>".date("d/m/Y", strtotime($data[$x]['vencimento']))."<br>";
$msg .= "<b>Forma de Pagamento: </b>".$data[$x]['forma_pagamento']."<br>";
if($data[$x]['forma_pagamento'] == "Cheque" || $data[$x]['forma_pagamento'] == "Cheque pré-datado"){
   if($data[$x]['numero_cheque']!= ""){
      $msg .= "<b>Nº Cheque: </b>".$data[$x]['numero_cheque']."<p>";
   }else{
      $msg .= "<b>Nº Cheque: </b>Não inserido<p>";
   }
}
$msg .= "<b>Histórico: </b><br>".addslashes($data[$x]['historico'])."<BR>";

echo"
<tr>
   <td bgcolor='".$bg_color[($x%2)]."'align=center><font color=black>".date("d/m/Y", strtotime($data[$x]['vencimento']))."</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=left onMouseOver=\"return overlib('{$msg}');\" onMouseOut=\"return nd();\"><font color=black>{$data[$x]['titulo']}</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black>{$data[$x]['parcela_atual']}/{$data[$x]['n_parcelas']}</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=right><font color=black>R$ ".number_format($data[$x]['valor'], 2, ",",".")."</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black>
   <a href='?s=editar&lan={$data[$x]['id']}' class=fontepreta12>Editar</a></td>
</tr>";
} //END FOR

echo"
<tr>
   <td align=right colspan=3>&nbsp;<b>Total</b></td>
   <td align=right colspan=2><b>R$ ".number_format($total_mes, 2, ",",".")."</b></td>
</tr>";
?>
</table>
<P>
<?PHP

 //  echo "<center><a href=\"javascript:location.href='?s=resumo&m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?s=resumo&m=$n_mes&y=$n_ano'\" class=fontebranca12>>></a></center>";
?>

