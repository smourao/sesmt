<?php
include "../sessao.php";
include "../config/connect.php";

if($_GET){
$cod_aparelho  = $_GET["cod_aparelho"];
}
else{
$cod_aparelho = $_POST["cod_aparelho"];
}

if(!empty($cod_aparelho)){
	$query_aparelho = "SELECT cod_aparelho, nome_aparelho, marca_aparelho, modelo_aparelho, fabricante, tipo_aparelho
					 FROM aparelhos
					 WHERE cod_aparelho = $cod_aparelho";
	
	$result_aparelho = pg_query($connect, $query_aparelho) 
			or die ("Erro na query: $query_aparelho ==> ".pg_last_error($connect));

	$row_aparelho = pg_fetch_array($result_aparelho);
}

if (!empty($cod_aparelho) and $_POST[btn_gravar]=="Gravar"){
	$query_insert = "INSERT INTO aparelhos
					 (cod_aparelho, nome_aparelho, marca_aparelho, modelo_aparelho, fabricante, tipo_aparelho)
					 VALUES
					 ($cod_aparelho, '$nome_aparelho', '$marca_aparelho', '$modelo_aparelho', '$fabricante',
					 '$tipo_aparelho')";
					 
	$result_insert = pg_query($connect, $query_insert) or die
		("Erro no INSERT ==> $query_insert".pg_last_error($connect));
}	

?>
<head>
<title>::Sistema SESMT - Cadastro de Aparelhos::</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../css_js/css.css"></script>
<script language="javascript" src="../scripts.js"></script>
</head>

<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form action="cad_aparelho.php" name="form_aparelho" method="post">
    <table width="90%" border="0" cellpadding="0" align="center"><br>
	<tr>
      <td class="fontebranca22bold"><div align="center">Cadastro de Aparelhos de Medição </div></td>
    </tr>
	</table><p>
	<table width="500" border="1" align="center" cellpadding="0">
		  <?php
	  	
			$query_max = "SELECT max(cod_aparelho) as cod_aparelho FROM aparelhos";
		
			$result_max = pg_query($query_max) //executa query
				or die ("Erro na busca da tabela aparelhos. ==> " . pg_last_error($connect)); //mostra erro
		
			$row_max = pg_fetch_array($result_max); // recebe o resultado da query (linhas)
		
		//echo "jhdsfj".$row_max['cod_aparelho'];
		?>

	<tr>
		<td align="right">Código:&nbsp;</td>
		<td>&nbsp;<input name="cod_aparelho" value="<?php echo $row_max[cod_aparelho] + 1?>" readonly="true" type="text" size="7"></td>
	</tr>
	<tr>
		<td align="right">Nome:&nbsp;</td>
		<td>&nbsp;<input name="nome_aparelho" type="text" value="<?php echo $row_aparelho[nome_aparelho]?>" size="50"></td>
	</tr>
	<tr>
		<td align="right">Marca:&nbsp;</td>
		<td>&nbsp;<input name="marca_aparelho" type="text" value="<?php echo $row_aparelho[marca_aparelho]?>" size="50"></td>
	</tr>
	<tr>
		<td align="right">Modelo:&nbsp;</td>
		<td>&nbsp;<input name="modelo_aparelho" type="text" value="<?php echo $row_aparelho[modelo_aparelho]?>" size="50" ></td>
	</tr>
	<tr>    
		<td align="right">Fabricante:&nbsp;</td>
		<td>&nbsp;<input name="fabricante" type="text" value="<?php echo $row_aparelho[fabricante]?>" size="50"></td>
	</tr>
	<tr>
		<td align="right">Tipo de Aparelho:&nbsp;</td>
		<td>&nbsp;<select name="tipo_aparelho">
			<option>Selecione...</option>
			<option value="1" >1 - Verificar Conforto Térmico</option>
			<option value="2" >2 - Verificar Metragem Linear</option>
			<option value="3" >3 - Verificar Ruído</option>
			<option value="4" >4 - Verificar Iluminância</option>
			<option value="5" >5 - Verificar Poeiras</option>
			<option value="6" >6 - Verificar Vapores Orgânicos</option>
		</select></td>
	</tr>
	</table>
	<br><table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
	  <td align="center">
	  <input type="submit" name="btn_gravar" value="Gravar" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','../adm/aparelho_adm.php');return document.MM_returnValue" style="width:100;">
	  </td>
	</tr>
	</table>
</form>
</body>
</html>