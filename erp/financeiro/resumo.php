<?PHP
if(!isset($_SESSION[mres])){
    $_SESSION[mres] = date("m");
}
if(!isset($_SESSION[yres])){
    $_SESSION[yres] = date("Y");
}

if(isset($_GET['m'])){
    $mes = $_GET['m'];
    $_SESSION[mres] = $mes;
}else{
    if(isset($_SESSION[mres])){
        $mes = $_SESSION[mres];
    }else{
        $mes = date("m");
    }
}

if(isset($_GET['y'])){
    $ano = $_GET['y'];
    $_SESSION[yres] = $ano;
}else{
    if(isset($_SESSION[yres])){
        $ano = $_SESSION[yres];
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
<b>Resumo</b>&nbsp;
<input type=text name=search id=search value="<?PHP echo $_POST['search'];?>">&nbsp;
<input type=submit value="Pesquisar">
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

   echo "<center><a href=\"javascript:location.href='?s=resumo&m=$mes&y=".($ano-1)."'\" class=fontebranca12><<</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?s=resumo&m=$p_mes&y=$p_ano'\" class=fontebranca12><</a>&nbsp;&nbsp;&nbsp;&nbsp;<b>".$meses[ltrim($mes, "0")]."/{$ano}</b>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?s=resumo&m=$n_mes&y=$n_ano'\" class=fontebranca12>></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?s=resumo&m=$mes&y=".($ano+1)."'\" class=fontebranca12>>></a></center>";
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
$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago, f.id as rec_id
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   --i.mes = substr('2009-04-07', 7, 1) AND
   --substr(f.vencimento, 6,2) = '{$mes}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   --substr(f.vencimento, 1,4) = '{$ano}' AND
   substr(i.data_entrada_saida, 6,2) = '{$mes}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   substr(i.data_entrada_saida, 1,4) = '{$ano}' AND

   (i.id = f.cod_fatura) AND
   ( lower(i.historico) LIKE '%".strtolower($_POST['search'])."%' OR
     lower(f.titulo) LIKE '%".strtolower($_POST['search'])."%' OR
     lower(f.numero_doc) LIKE '%".strtolower($_POST['search'])."%'
   )
   ORDER BY
   f.vencimento
";
}else{
$sql = "
SELECT
   i.id, i.valor_total, i.n_parcelas, i.forma_pagamento, i.numero_cheque, i.data_lancamento,
   i.historico, f.numero_doc, f.numero_cheque, f.titulo, f.valor, f.parcela_atual, f.vencimento, f.status, f.pago
FROM
   financeiro_info i, financeiro_fatura f
WHERE
   i.mes = '{$mes}' AND -- SELECIONA APENAS O MES ESPECÍFICO
   i.ano = '{$ano}' AND
   (i.id = f.cod_fatura )
ORDER BY
   f.vencimento -- POR VENCIMENTO
";
}
$result = pg_query($sql);
$data = pg_fetch_all($result);
$total_mes = 0;
$total_geral = 0;
$total_pago = 0;

for($x=0;$x<pg_num_rows($result);$x++){
if($data[$x]['status'] == 0){
   $total_mes += $data[$x]['valor'];
   $bg_color = array("#cfded2","#e5eae6");
   if($data[$x]['pago'] > 0){
      $total_pago += $data[$x]['valor'];
   }
}else{
   $total_mes -= $data[$x]['valor'];
   $bg_color = array("#d8caca","#eadcdc");
   if($data[$x]['pago'] > 0){
      $total_pago -= $data[$x]['valor'];
   }
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
   <td align=right colspan=3>&nbsp;<font size=1><i>(apenas valores pagos/recebidos)</i></font> <b>Total Líquido</b></td>
   <td align=right colspan=2><b>R$ ".number_format($total_pago, 2, ",",".")."</b></td>
</tr>";
echo"
<tr>
   <td align=right colspan=3>&nbsp;<b>Total Bruto</b></td>
   <td align=right colspan=2><b>R$ ".number_format($total_mes, 2, ",",".")."</b></td>
</tr>";
?>
</table>
<P>
<?PHP
   echo "<center><a href=\"javascript:location.href='?s=resumo&m=$mes&y=".($ano-1)."'\" class=fontebranca12><<</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?s=resumo&m=$p_mes&y=$p_ano'\" class=fontebranca12><</a>&nbsp;&nbsp;&nbsp;&nbsp;<b>".$meses[ltrim($mes, "0")]."/{$ano}</b>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?s=resumo&m=$n_mes&y=$n_ano'\" class=fontebranca12>></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:location.href='?s=resumo&m=$mes&y=".($ano+1)."'\" class=fontebranca12>>></a></center>";
   //echo "<center><a href=\"javascript:location.href='?s=resumo&m=$mes&y=".($ano-1)."'\" class=fontebranca12><<</a>  <a href=\"javascript:location.href='?s=resumo&m=$p_mes&y=$p_ano'\" class=fontebranca12><</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?s=resumo&m=$n_mes&y=$n_ano'\" class=fontebranca12>></a>  <a href=\"javascript:location.href='?s=resumo&m=$mes&y=".($ano+1)."'\" class=fontebranca12>>></a></center>";
?>

