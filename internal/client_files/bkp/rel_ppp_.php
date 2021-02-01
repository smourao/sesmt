<center><img src='images/colaboradores.jpg' border=0></center>
<p align=justify>
<table width=100% border=0 cellspacing=2 cellpadding=2>
<?php
$sql = "SELECT
			i.*, c.*
		FROM
			cgrt_info i, cliente c
		WHERE
			i.cod_cliente = ".(int)($_SESSION[cod_cliente])."
		AND
			lower(c.razao_social) LIKE '%".strtolower($searchtxt)."%'
		ORDER BY i.ano desc";
$result = pg_query($sql);
$clist = pg_fetch_all($result);

if (!empty($query_razao)){
	$result_razao = pg_query($query_razao) or die
		("erro na query!" .pg_last_error($connect));

	while($row=pg_fetch_array($result_razao)){

echo "<tr>
   <td  class='text roundbordermix curhand' align=left  onclick=\"newWindow('".current_module_path."relatorios/ppp/?cliente=".base64_encode((int)($row[cod_cliente]))."&setor=".base64_encode((int)($row[cod_setor]))."&funcionario=".base64_encode((int)($row[cod_func]))."&cod_cgrt=".base64_encode((int)($clist[0][cod_cgrt]))."');\">&nbsp;$row[nome_func]</td>
	 </tr>";
	}
}
  $fecha = pg_close($connect);
?>
</table>
