<?PHP
if(!isset($_SESSION[mdes])){
    $_SESSION[mdes] = date("m");
}
if(!isset($_SESSION[ydes])){
    $_SESSION[ydes] = date("Y");
}

if(isset($_GET['m'])){
    $mes = $_GET['m'];
    $_SESSION[mdes] = $mes;
}else{
    if(isset($_SESSION[mdes])){
        $mes = $_SESSION[mdes];
    }else{
        $mes = date("m");
    }
}

if(isset($_GET['y'])){
    $ano = $_GET['y'];
    $_SESSION[ydes] = $ano;
}else{
    if(isset($_SESSION[ydes])){
        $ano = $_SESSION[ydes];
    }else{
        $ano = date("Y");
    }
}

$meses = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");

?>
<table border=0 width=100%>
<tr>
<td>
<form method=post>
<b>Despesas</b>&nbsp;
<input type=text name=search id=search value="<?PHP echo $_POST['search'];?>">&nbsp;
<input type=submit value="Pesquisar">
</form>


<div align=right>
<img src='imprimir.gif' border=0 width=20 height=20 onclick="window.open('print_despesas.php?m=<?PHP echo $mes;?>&y=<?PHP echo $ano;?>','Despesas', 'height = 500, width = 700, scrollbars=yes')" style="cursor:pointer;">
</div>
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


   echo "<center><a href=\"javascript:location.href='?s=despesas&m=$mes&y=".($ano-1)."'\" class=fontebranca12><<</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?s=despesas&m=$p_mes&y=$p_ano'\" class=fontebranca12><</a>&nbsp;&nbsp;&nbsp;&nbsp;<b>".$meses[ltrim($mes, "0")]."/{$ano}</b>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?s=despesas&m=$n_mes&y=$n_ano'\" class=fontebranca12>></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?s=despesas&m=$mes&y=".($ano+1)."'\" class=fontebranca12>>></a></center>";
?>

<P>
<?PHP
if($_POST){

}
?>
<table border=1 width=100%>
<tr>
   <td width=70 align=center><b>Venc.</b></td>
   <td align=center><b>Título</b></td>
   <td align=center width=30><b>Parcela</b></td>
   <td align=center width=100><b>Valor</b></td>
   <td align=center width=70><b>Pago</b></td>
   <td align="center" width=70><b>Nº Doc.</b></td>
   <td align=center width=50><b>Ação</b></td>
</tr>

<?PHP
if($_POST){
$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   --substr(f.vencimento, 6,2) = '{$mes}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   --substr(f.vencimento, 1,4) = '{$ano}' AND
   substr(i.data_entrada_saida, 6,2) = '{$mes}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   substr(i.data_entrada_saida, 1,4) = '{$ano}' AND
   (i.id = f.cod_fatura) AND
   i.status = 1 AND
   ( lower(i.historico) LIKE '%".strtolower($_POST['search'])."%' OR
     lower(f.titulo) LIKE '%".strtolower($_POST['search'])."%' OR
     lower(f.numero_doc) LIKE '%".strtolower($_POST['search'])."%'
   )
   ORDER BY
   f.vencimento
   --i.data_entrada_saida
";
}else{
$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   i.mes = '{$mes}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   i.ano = '{$ano}' AND
   (i.id = f.cod_fatura ) AND
   i.status = 1
   ORDER BY
   f.vencimento
   --i.data_entrada_saida
";
}
$result = pg_query($sql);
$data = pg_fetch_all($result);
echo "<input type=hidden name=hmes id=hmes value='{$mes}'>";
echo "<input type=hidden name=hano id=hano value='{$ano}'>";
$total_mes = 0;
$total_geral = 0;
$bg_color = array("#d8caca","#eadcdc");
for($x=0;$x<pg_num_rows($result);$x++){
//echo ($x % 2);

$msg = "<center><b>".$data[$x]['titulo']."</b></center><p>";
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
$msg .= "<b>Histórico: </b><br>".$data[$x]['historico']."<BR>";


echo"
<tr>
   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black>".date("d/m/Y", strtotime($data[$x]['vencimento']))."</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=left onMouseOver=\"return overlib('".addslashes($msg)."');\" onMouseOut=\"return nd();\"><font color=black>{$data[$x]['titulo']}</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black>{$data[$x]['parcela_atual']}/{$data[$x]['n_parcelas']}</td>
   <td bgcolor='".$bg_color[($x%2)]."' align=right><font color=black>R$ ".number_format($data[$x]['valor'], 2, ",",".")."</td>
<!--   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black>{$data[$x]['pago']}</td> -->
   <td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black><center><div id='d{$data[$x]['rec_id']}' onclick=\"javascript:setTimeout('despesa_total()', 1500);\">";
   print $data[$x]['pago'] == 0 ? "<a href=\"javascript:despesa_paga('{$data[$x]['rec_id']}');\" class=fontepreta12>Confirmar</a>" : "<b><font color=black>Pago!</b>";
   echo"</div></td>";

   echo "<td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black><center>
   <div id='dcn{$data[$x]['rec_id']}'><center>
   ";
      print $data[$x]['numero_doc'] != "" ? $data[$x]['numero_doc'] : "<a href=\"javascript:add_doc_number('{$data[$x]['rec_id']}',prompt('Digite o número do documento:',''));\" class=fontepreta12>Adicionar</a>";
   echo "</font></div></td>";
   
    echo "<td bgcolor='".$bg_color[($x%2)]."' align=center><font color=black>
   <a href='?s=editar&lan={$data[$x]['id']}' class=fontepreta12>Editar</a></td>";

echo "</tr>";
//$total_mes += $data[$x]['valor'];
if($data[$x]['pago'] > 0){
   $total_mes += $data[$x]['valor'];
}
$total_geral += $data[$x]['valor'];
}
echo"
<tr>
   <td align=right colspan=3>&nbsp;<b>Total Debitado</b></td>
   <td align=right colspan=4><div id='soma_receita'><b>R$ ".number_format($total_mes, 2, ",",".")."</b></div></td>
</tr>
<tr>
   <td align=right colspan=3>&nbsp;<b>Total Geral</b></td>
   <td align=right colspan=4><div><b>R$ ".number_format($total_geral, 2, ",",".")."</b></div></td>
</tr>
";

?>
</table>

<P>

<?PHP
   echo "<center><a href=\"javascript:location.href='?s=despesas&m=$mes&y=".($ano-1)."'\" class=fontebranca12><<</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?s=despesas&m=$p_mes&y=$p_ano'\" class=fontebranca12><</a>&nbsp;&nbsp;&nbsp;&nbsp;<b>".$meses[ltrim($mes, "0")]."/{$ano}</b>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?s=despesas&m=$n_mes&y=$n_ano'\" class=fontebranca12>></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?s=despesas&m=$mes&y=".($ano+1)."'\" class=fontebranca12>>></a></center>";
   //echo "<center><a href=\"javascript:location.href='?s=despesas&m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?s=despesas&m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></center>";
?>

