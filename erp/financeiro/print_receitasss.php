<?PHP
session_start();
include("include/db.php");
//    print_r($_POST);
if(isset($_GET['m'])){
    $mes = $_GET['m'];
}else{
    $mes = date("m");
}

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

?>
<table border=1 width=670 align=center>
<tr>
<td>
<b>Receitas</b>
</td>
</tr>
</table>
<p>

<?PHP

  if($mes >=12){
      $n_mes = 01;
      $n_ano = $ano+1;
  }elseif($mes <= 01){
     $p_mes = 12;
     $p_ano = $ano-1;
  }else{
      $n_mes = STR_PAD($mes+1, 2, "0", STR_PAD_LEFT);
      $n_ano = $ano;
      $p_mes = STR_PAD($mes-1, 2, "0", STR_PAD_LEFT);
      $p_ano = $ano;
  }
//   echo "<center><a href=\"javascript:location.href='?s=receitas&m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?s=receitas&m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></center>";
?>
<P>
<?PHP
if($_POST){

}
?>
<table border=1 width=670 align=center>
<tr>
   <td width=80 align=center><b>Vencimento</b></td>
   <td align=center><b>Título</b></td>
   <td align=center width=20><b>Forma de Pag.</b></td>
   <td align=center width=100><b>Valor</b></td>
   <!--<td align=center width=50><b>Pagamento</b></td>-->
</tr>
<?PHP

if(($mes == 1) OR ($mes == 3) OR ($mes == 5) OR ($mes == 7) OR ($mes == 8) OR ($mes == 10) OR ($mes == 12)){
	
	$dia = 31;
	
}elseif(($mes == 4) OR ($mes == 6) OR ($mes == 9) OR ($mes == 11)){
	
	$dia = 30;
	
}else{
	
	if(($ano % 4)==0){
	
		$dia = 29;
		
	}else{
	
		$dia = 28;	
		
	}
	
	
}


$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i,forma_pagamento, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.data_lancamento, f.status, f.pago, f.id as rec_id, f.numero_doc as n_doc
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   f.data_lancamento >= '{$ano}-{$mes}-01' AND f.data_lancamento <= '{$ano}-{$mes}-{$dia}' AND
   i.id = f.cod_fatura AND
   i.status = 0
   ORDER BY
   f.vencimento
";
$result = pg_query($sql);
$data = pg_fetch_all($result);
echo "<input type=hidden name=hmes id=hmes value='{$mes}'>";
echo "<input type=hidden name=hano id=hano value='{$ano}'>";
$total_mes = 0;
//$bg_color = array("#cfded2","#e5eae6");
$bg_color = array("#ffffff","#ffffff");
for($x=0;$x<pg_num_rows($result);$x++){
//echo ($x % 2);

echo"
<tr>
   <td bgcolor='".$bg_color[($x%2)]."' width=10 align=center><font color=black>".date("d/m/Y", strtotime($data[$x]['vencimento']))."</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=><font color=black>{$data[$x]['titulo']}</td>

   <td bgcolor='".$bg_color[($x%2)]."' align=center width=100>
   <font color=black>{$data[$x]['forma_pagamento']}</td>
   
   <td bgcolor='".$bg_color[($x%2)]."' align=right width=100><font color=black>R$ ".number_format($data[$x]['valor'], 2, ",",".")."</td>


</tr>";
if($data[$x]['pago'] > 0){
   $total_mes += $data[$x]['valor'];
}

}
echo"
<tr>
   <td align=center colspan=2>&nbsp;</td>
   <td align=right width=100><b>Total</b></td>
   <td align=right><div id='soma_receita'><b>R$ ".number_format($total_mes, 2, ",",".")."</b></div></td>
</tr>";

?>
</table>

<p>
<?PHP

  // echo "<center><a href=\"javascript:location.href='?s=receitas&m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?s=receitas&m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></center>";


?>


