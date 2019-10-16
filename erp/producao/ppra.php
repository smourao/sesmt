<?php
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "ppra_functions.php";

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

$cliente = $_GET['cliente'];
$setor = $_GET['setor'];

if($_GET[excluir]=="sim"){
	$sql_excluir = "DELETE FROM sugestao WHERE id_ppra = $_GET[id_ppra] AND cod_setor = $_GET[setor];";
	//$sql_excluir = $sql_excluir . "DELETE FROM aso_exame where cod_aso in (select cod_aso from aso where cod_cliente = $cliente and cod_setor = $setor AND EXTRACT(year FROM data) = {$ano});";
	//$sql_excluir = $sql_excluir . " delete from aso where cod_cliente = $cliente and cod_setor = $setor AND EXTRACT(year FROM aso_data) = {$ano};";
	$sql_excluir .= " DELETE FROM risco_setor WHERE id_ppra = $_GET[id_ppra] AND cod_setor = $_GET[setor];";
	$sql_excluir .= " DELETE FROM cliente_setor WHERE id_ppra = $_GET[id_ppra] AND cod_setor = $_GET[setor];";
	$sql_excluir .= " DELETE FROM extintor WHERE id_ppra = $_GET[id_ppra] AND cod_setor = $_GET[setor];";
	$sql_excluir .= " DELETE FROM ppra_placas WHERE id_ppra = $_GET[id_ppra] AND cod_setor = $_GET[setor];";
	$sql_excluir .= " DELETE FROM iluminacao_ppra WHERE id_ppra = $_GET[id_ppra] AND cod_setor = $_GET[setor];";
	$result_excluir = pg_query($sql_excluir);
	if ($result_excluir){
		echo "<script>alert('PPRA excluído com sucesso!');</script>";
	}
}

//GET PPRA DATA
if(isset($_GET['id_ppra']) ){
    $sql = "SELECT c.razao_social, c.cliente_id, s.nome_setor, s.cod_setor, cs.id_ppra
    FROM cliente c, setor s, cliente_setor cs
    WHERE cs.cod_cliente = c.cliente_id
    AND cs.cod_setor = s.cod_setor
    AND cs.id_ppra = {$_GET['id_ppra']}
    ORDER BY c.razao_social";
}
$result_ppra = pg_query($sql);
?>
<html>
<head>
<title>PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
<style type="text/css">
<!--
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_lista" method="post" action="ppra1.php">
<table align="center" width="700" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td colspan="4" bgcolor="#009966" align="center">
		<br>
        <h2 >CGRT</h2>
        <h2 >Cadastro Geral de Relatórios Técnicos</h2>
	</td>
  </tr>
   <tr>
		<th colspan="4" bgcolor="#009966">
		<br>&nbsp;
		<input name="btn_novo" type="submit" id="btn_novo" onClick="MM_goToURL('parent','ppra1.php'); return document.MM_returnValue" value="Novo" style="width:100;" onClick="confirmar();" title="Criar novo registro de PPRA" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="btn1" type="submit" onClick="MM_goToURL('parent','lista_ppra.php'); return document.MM_returnValue" value="Voltar" style="width:100;">
		<br>&nbsp;
		</th>
	</tr>
  </tr>
    <th colspan="2" width="400"><br><h3 class="style2">CLIENTE</h3></th>
    <th width="300"><br><h3 class="style2">SETOR</h3></th>
  </tr>
<?php
	while($row = pg_fetch_array($result_ppra)){
		echo "<tr>";
		echo "	<th class=linksistema width=40><a href=\"ppra.php?cliente=$row[cliente_id]&id_ppra=$row[id_ppra]&setor=$row[cod_setor]&excluir=sim&y=$ano\" >Excluir</a> </th>";
		echo "	<td class=linksistema><a href=\"ppra2_alt.php?cliente=$row[cliente_id]&id_ppra=$row[id_ppra]&setor=$row[cod_setor]&y=$ano\">&nbsp;" . ucwords(strtolower($row[razao_social])) . "</a> </td>";
	    echo "	<td class=linksistema><a href=\"ppra2_alt.php?cliente=$row[cliente_id]&id_ppra=$row[id_ppra]&setor=$row[cod_setor]&y=$ano\">&nbsp;" . ucwords(strtolower($row[nome_setor])) . " - ".ppra_progress($row[cliente_id], $row[cod_setor])."% concluído </a></td>";
		echo "</tr>";
	}
// encerrar conexão
pg_close($connect);
?>
</table>
</form>
</body>
</html>
