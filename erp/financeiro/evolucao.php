<?PHP
//MES
if(isset($_GET['m'])){
    $mes = $_GET['m'];
}else{
    $mes = date("m");
}
//ANO
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
<b>Evolução Financeira Trienal</b>
</td>
</tr>
</table>
<p>
<?PHP
   echo "<center><a href=\"javascript:location.href='?s=evolucao&y=".($ano-1)."'\" class=fontebranca12><<</a>  <b>".($ano-2)."/{$ano}</b>  <a href=\"javascript:location.href='?s=evolucao&y=".($ano+1)."'\" class=fontebranca12>>></a></center>";
?>
<P>
<table border=1 width=100%>
<tr>
   <td width=80 align=center><b>Mês</b></td>
   <td align=center width=100><b><a href="javascript:graph_m(<?PHP echo $ano-2;?>);"  class=fontebranca12><?PHP echo $ano-2;?></a></b></td>
   <td align=center width=100><b><a href="javascript:graph_m(<?PHP echo $ano-1;?>);"  class=fontebranca12><?PHP echo $ano-1;?></a></b></td>
   <td align=center width=100><b><a href="javascript:graph_m(<?PHP echo $ano-0;?>);"  class=fontebranca12><?PHP echo $ano;?>  </a></b></td>
   <td align=center><b>Variação <?PHP echo substr($ano-2, 2,2)?>/<?PHP echo substr($ano-1, 2,2)?></b></td>
   <td align=center><b>Variação <?PHP echo substr($ano-1, 2,2)?>/<?PHP echo substr($ano, 2,2)?></b></td>
</tr>
<?PHP
$val = array();
for($y=0;$y<3;$y++){
$val[$y] = array();
for($x=0;$x<12;$x++){
   $sql = "
   SELECT
      i.id, i.valor_total, i.n_parcelas, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago
   FROM
      financeiro_info i, financeiro_fatura f
   WHERE
      --i.mes = substr('2009-04-07', 7, 1) AND
      --substr(f.vencimento, 6,2) = '".STR_PAD(($x+1), 2, "0", STR_PAD_LEFT)."' AND -- SELECIONA APENAS O MES ESPECÍFICO 2 DIGITOS
      --substr(f.vencimento, 1,4) = '".(($ano-2)+$y)."' AND
      i.mes = '".STR_PAD(($x+1), 2, "0", STR_PAD_LEFT)."' AND -- SELECIONA APENAS O MES ESPECÍFICO 2 DIGITOS
      i.ano = '".(($ano-2)+$y)."' AND
      (i.id = f.cod_fatura )
   ORDER BY
      f.vencimento";
   $result = pg_query($sql);
   $data = pg_fetch_all($result);
   for($z=0;$z<pg_num_rows($result);$z++){
      if($data[$z]['status'] == 0){
         $val[$y][$x+1] += $data[$z]['valor'];
      }else{
         $val[$y][$x+1] -= $data[$z]['valor'];
      }
   }
}//MESES
}//ANO
for($x=0;$x<12;$x++){
   if($data[$x]['status'] == 0){
      $total_mes += $data[$x]['valor'];
      $bg_color = array("#cfded2","#e5eae6");
   }else{
      $total_mes -= $data[$x]['valor'];
      $bg_color = array("#d8caca","#eadcdc");
   }
$total_ano1 += $val[0][$x+1];
$total_ano2 += $val[1][$x+1];
$total_ano3 += $val[2][$x+1];
echo"
<tr>
   <td align=left><b>".$meses[$x+1]."</b></td>
   <td bgcolor='".$bg_color[($x%2)]."' align=left><font color=black>R$ "; print $val[0][$x+1] >= 0 ? "<font color=black>" : "<font color=red>"; echo number_format($val[0][$x+1], 2, ",",".")."</font></td>
   <td bgcolor='".$bg_color[($x%2)]."' align=left><font color=black>R$ "; print $val[1][$x+1] >= 0 ? "<font color=black>" : "<font color=red>"; echo number_format($val[1][$x+1], 2, ",",".")."</font></td>
   <td bgcolor='".$bg_color[($x%2)]."' align=left><font color=black>R$ "; print $val[2][$x+1] >= 0 ? "<font color=black>" : "<font color=red>"; echo number_format($val[2][$x+1], 2, ",",".")."</font></td>
   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black>";
   if($val[0][$x+1] != 0){
      $tmp1 = round(((($val[1][$x+1]-$val[0][$x+1])/$val[0][$x+1])*100), 2);
   }else{
      $tmp1 = round(((($val[1][$x+1]-$val[0][$x+1])/1)*100), 2);
   }
   if($tmp1 >= 0){
      echo $tmp1."%";
   }else{
      echo "<font color=red>$tmp1%</font>";
   }
   echo "</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black>";
   if($val[1][$x+1] != 0){
      $tmp2 = round(((($val[2][$x+1]-$val[1][$x+1])/$val[1][$x+1])*100), 2);
   }else{
      $tmp2 = round(((($val[2][$x+1]-$val[1][$x+1])/1)*100), 2);
   }
   if($tmp2 >= 0){
      echo $tmp2."%";
   }else{
      echo "<font color=red>$tmp2%</font>";
   }
   echo "</td>
</tr>";
}//END FOR
   //TOTAL PRIMEIRO ANO
   if($total_ano1 != 0){
      $tmp1 = round(((($total_ano2-$total_ano1)/$total_ano1)*100), 2);
   }else{
      $tmp1 = round(((($total_ano2-$total_ano1)/1)*100), 2);
   }
   if($tmp1 >= 0){
      $tmp1 = $tmp1."%";
   }else{
      $tmp1 = "<font color=red>$tmp1%</font>";
   }
   //TOTAL SEGUNDO ANO
   if($total_ano2 != 0){
      $tmp2 = round(((($total_ano3-$total_ano2)/$total_ano2)*100), 2);
   }else{
      $tmp2 = round(((($total_ano3-$total_ano2)/1)*100), 2);
   }
   if($tmp2 >= 0){
      $tmp2 = $tmp2."%";
   }else{
      $tmp2 = "<font color=red>$tmp2%</font>";
   }

echo"
<tr>
   <td width=80 align=center><b>Total</b></td>
   <td align=left width=100><b>R$ ".number_format($total_ano1, 2, ",",".")."</b></td>
   <td align=left width=100><b>R$ ".number_format($total_ano2, 2, ",",".")."</b></td>
   <td align=left width=100><b>R$".number_format($total_ano3, 2, ",",".")."</b></td>
   <td align=center><b>$tmp1</b></td>
   <td align=center><b>$tmp2</b></td>
</tr>";
?>
</table>
<p>
<center>
<div id="grafico">
   <img src="graph.php?ano=<?PHP echo $ano;?>&type=bar&cache=<?PHP echo rand(10000, 99999);?>">
</div>
</center>
