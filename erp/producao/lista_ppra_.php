<?php
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
//include "ppra_functions.php";

	$cliente = $_GET['cliente'];
	$setor = $_GET['setor'];

if($_GET[excluir]=="sim"){
	$cliente = $_GET[cliente];
	$setor = $_GET[setor];

	$sql_excluir = "delete from sugestao where cod_cliente = $cliente and cod_setor = $setor;";
	$sql_excluir = $sql_excluir . " delete from sugestao_setor where cod_cliente = $cliente and cod_setor = $setor;";
	$sql_excluir = $sql_excluir . " delete from mobilia where cod_cliente = $cliente and cod_setor = $setor;";
	$sql_excluir = $sql_excluir . " delete from aso_exame where cod_aso in (select cod_aso from aso where cod_cliente = $cliente and cod_setor = $setor);";
	$sql_excluir = $sql_excluir . " delete from aso where cod_cliente = $cliente and cod_setor = $setor;";
	$sql_excluir = $sql_excluir . " delete from funcionarios where cod_cliente = $cliente and cod_setor = $setor;";
	$sql_excluir = $sql_excluir . " delete from risco_setor where cod_cliente = $cliente and cod_setor = $setor;";
	$sql_excluir = $sql_excluir . " delete from cliente_setor where cod_cliente = $cliente and cod_setor = $setor;";
	$sql_excluir = $sql_excluir . " delete from extintor where cod_cliente = $cliente and cod_setor = $setor;";
	$sql_excluir = $sql_excluir . " delete from ppra_placas where cod_cliente = $cliente and cod_setor = $setor;";

	$result_excluir = pg_query($connect, $sql_excluir)
	or die ("Erro na query: $sql_excluir ==> " . pg_last_error($connect) );

	if ($result_excluir){
		echo "<script>alert('PPRA excluído com sucesso!');</script>";
	}
}

if(isset($_GET['cliente']) ){
$sql = "select c.razao_social, c.cliente_id, s.nome_setor, s.cod_setor
--, pp.progresso
		from cliente c, setor s, cliente_setor cs 
		--, progresso_ppra pp
		where cs.cod_cliente = c.cliente_id
		and cs.cod_setor = s.cod_setor
		and cs.cod_cliente <> 0
		--AND pp.cod_cliente = cs.cod_cliente
		--AND pp.cod_setor = cs.cod_setor
		AND c.cliente_id={$_GET['cliente']}
		order by c.razao_social";
}else{
$sql = "select distinct(c.razao_social), c.cliente_id
		from cliente c, setor s, cliente_setor cs
		where cs.cod_cliente = c.cliente_id
		and cs.cod_setor = s.cod_setor
		and cs.cod_cliente <> 0
		order by c.razao_social";
}

	$result_ppra = pg_query($connect, $sql)
		or die ("Erro na query: $sql ==> " . pg_last_error($connect) );

?>
<html>
<head>
<title>PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
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
		<!--input type="button"  name="continuar" value="Visualizar Todos" onClick="MM_goToURL('parent','lista_ppra.php');return document.MM_returnValue" style="width:100;"-->
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="btn1" type="submit" onClick="MM_goToURL('parent','../tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
		<br>&nbsp;
		</th>
	</tr>
  </tr>
    <th width="400"><br><h3 class="style2">CLIENTE</h3></th>
    <th width="300"><br><h3 class="style2">RELATÓRIOS</h3></th>
  </tr>
<?php
    if($_GET[y])
        $newrgdt = $_GET[y]+1;
    else
        $newrgdt = date("Y")+1;
    
	while($row = pg_fetch_array($result_ppra)){
		echo "<tr>";
		//echo "	<th class=linksistema width=40><a href=\"lista_ppra.php?cliente=$row[cliente_id]&setor=$row[cod_setor]&excluir=sim\" >Excluir</a> </th>";
		echo "	<td class=linksistema><a href='#' onclick=\"var dado = prompt('Informe o ano de referência para a duplicação:','{$newrgdt}');if(dado){alert('DONE: '+dado);}\">Duplicar</a> | <a href=\"ppra.php?cliente=$row[cliente_id]\">&nbsp;" . ucwords(strtolower($row[razao_social])) . "</a> </td>";
	    //echo "	<td class=linksistema><a href=\"ppra.php?cliente=$row[cliente_id]\">&nbsp;" . ucwords(strtolower($row[nome_setor])) . " - ".ppra_progress($row[cliente_id], $row[cod_setor])."% concluído </a></td>";
	    echo "	<td class=linksistema><a href=\"ppra_relatorio.php?cliente=$row[cliente_id]&sem_timbre=1\">&nbsp;PPRA</a> | <a href=\"lista_func_ppp.php?cliente=$row[cliente_id]\">PPP</a></td>";
		echo "</tr>";
	}
// encerrar conexão
pg_close($connect);
?>
</table>
</form>
</body>
</html>
