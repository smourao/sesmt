<?php
include "../sessao.php";
include "../config/config.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET) {
	$cliente     = $_GET[cliente];
	$funcionario = $_GET[funcionario];
	$setor       = $_GET[setor];
}
else{
	$cliente     = $_POST[cliente];
	$funcionario = $_POST[funcionario];
	$setor       = $_POST[setor];
}
if($_POST["btn_enviar"] == "Enviar"){
	header("location: http://www.sesmt-rio.com/erp/medico/gerar_aso.php?funcionario=$cod_func&cliente=$cliente&setor=$setor");
}
?>
<html>
<head>
<title>Lista de Funcionários</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="800" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="5" class="linhatopodiresq" bgcolor="#009966"><br>TELA DE FUNCIONÁRIOS <br>	&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="5">
			<br>&nbsp;
				<input name="btn_sair" type="button" id="btn_sair" onClick="MM_goToURL('parent','../medico/pesq_cli.php?cliente=<?php echo $_GET[cliente]; ?>'); return document.MM_returnValue" value="<< Voltar" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
<form method="post" name="form1">
	  <tr>
	<td width="490" align=center>
		<br>
		&nbsp;&nbsp;&nbsp;<input type="text" name="func_name" size="50">
		&nbsp;&nbsp;&nbsp;<input type="submit" name="btn_busca" value="Buscar" style="width:100;"> <br>&nbsp;
	</td>
  </tr>
	<tr>			
      <td height="26" colspan="5" class="linhatopodiresq">
<?php
	echo "<tr>";
	echo "	<th class=\"style1\" colspan=2> Resultado da Pesquisa:</th>";
	echo "</tr>";
	echo "<tr>";
	echo "  <td colspan=2> <br>";
//if(!empty($_POST[func_name])){
	
    $query_func = "SELECT cod_func, nome_func, f.cod_cliente, f.cod_setor
			  	   FROM funcionarios f, setor s, cliente c
				   WHERE f.cod_cliente = c.cliente_id
				   and f.cod_setor = s.cod_setor 
				   --and f.cod_func = $funcionario
				   and f.cod_cliente = $cliente
				   and f.cod_setor = $_GET[setor]";
    
    /*$query_func = "SELECT *
			  	   FROM funcionarios
				   WHERE cod_cliente = $cliente
				   and lower(nome_func) LIKE '%".strtolower($_POST[func_name])."%'";*/
   $result_func = pg_query($query_func);
	
	if(is_resource($result_func)){
			while($row = pg_fetch_array($result_func)){
				echo "&nbsp;<input type=\"radio\" name=\"cod_func\" value=\"$row[cod_func]\">$row[nome_func]<br>";
			}
	echo "<br> &nbsp;	</td>";
	echo " </tr>";
?>
	
	<tr>
		<td align="center" colspan="2">
			<br>&nbsp;
			<input type="submit" name="btn_enviar" value="Enviar" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="reset" name="btn_limpar" value="Limpar" style="width:100px;">
			<br>&nbsp;
		  <input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
		  <input type="hidden" name="setor" value="<?php echo $setor; ?>">
		</td>
	</tr>
<?php
    }
//}
?>  
</form>
</table>
</body>
</html>
