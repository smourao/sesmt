<?php
include "../sessao.php";
include "../config/connect.php";

if($_GET){
   $cod_aparelho = $_GET["cod_aparelho"];
}else{
   $cod_aparelho = $_POST["cod_aparelho"];
}

if($cod_aparelho!="" and $_POST[btn_excluir] == "Excluir"){
	$query = "SELECT * FROM aparelhos WHERE cod_aparelho=$cod_aparelho";
	$result = pg_query($connect, $query) 
		or die ("Não foi possivel realizar a consulta!" . pg_last_error($connect));
	
	if(pg_num_rows($result) > 0) {
		$sql = "DELETE FROM aparelhos WHERE cod_aparelho=$cod_aparelho";
		
	$resultado = pg_query($sql) or die ("Não foi possível realizar a exclusão dos dados.");
	header("Location: aparelho_adm.php");

	}
}

if($cod_aparelho!="" and $_POST[btn_alterar] == "Alterar" ){
    $erro = 0;
	$nome_aparelho = $_POST["nome_aparelho"];
	$marca_aparelho = $_POST["marca_aparelho"];
	$modelo_aparelho = $_POST["modelo_aparelho"];
	$fabricante = $_POST["fabricante"];
	$tipo_aparelho = $_POST["tipo_aparelho"];
	
	$query_aparelho = "UPDATE aparelhos SET 
					 nome_aparelho = '$nome_aparelho',
					 marca_aparelho = '$marca_aparelho',
					 modelo_aparelho = '$modelo_aparelho',
					 fabricante = '$fabricante',
					 tipo_aparelho = '$tipo_aparelho'
					 WHERE cod_aparelho= $cod_aparelho";
	if(is_numeric($tipo_aparelho))
	    $result_aparelho = pg_query($query_aparelho);
	else
	    $erro = 1;
}

if($cod_aparelho!=""){
	$query_incluir="SELECT cod_aparelho, nome_aparelho, marca_aparelho, modelo_aparelho, fabricante, tipo_aparelho
					FROM aparelhos
					WHERE cod_aparelho = $cod_aparelho";
					
	$result = pg_query($query_incluir) or die 
		("Erro na query:$query_incluir".pg_last_error($connect));
	
	$row = pg_fetch_array($result);
}

?>
<html>
<head>
<title>Sistema SESMT - Cadastro de Aparelhos</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<script language="javascript" src="../css_js/css.css"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">

<form action="aparelho_alterar.php" method="post" enctype="multipart/form-data" name="form1">
<table width="90%" border="0" cellpadding="0" align="center"><br>
	<tr>
      <td class="fontebranca22bold"><div align="center">Cadastro de Aparelhos de Medição </div></td>
    </tr>
	</table><p>
	<table width="500" border="1" align="center" cellpadding="0">
	<tr>
		<td align="right">Código:&nbsp;</td>
		<td>&nbsp;<input name="cod_aparelho" value="<?php echo $row[cod_aparelho]?>" readonly="true" type="text" size="7"></td>
	</tr>
	<tr>
		<td align="right">Nome:&nbsp;</td>
		<td>&nbsp;<input name="nome_aparelho" type="text" value="<?php echo $row[nome_aparelho]?>" size="50"></td>
	</tr>
	<tr>
		<td align="right">Marca:&nbsp;</td>
		<td>&nbsp;<input name="marca_aparelho" type="text" value="<?php echo $row[marca_aparelho]?>" size="50"></td>
	</tr>
	<tr>
		<td align="right">Modelo:&nbsp;</td>
		<td>&nbsp;<input name="modelo_aparelho" type="text" value="<?php echo $row[modelo_aparelho]?>" size="50" ></td>
	</tr>
	<tr>    
		<td align="right">Fabricante:&nbsp;</td>
		<td>&nbsp;<input name="fabricante" type="text" value="<?php echo $row[fabricante]?>" size="50"></td>
	</tr>
	<tr>
		<td align="right">Tipo de Aparelho:&nbsp;</td>
		<td>&nbsp;<select name="tipo_aparelho" id="tipo_aparelho">
			<option>Selecione...</option>
			<option value="1" <?php if($row[tipo_aparelho] == 1) echo " selected ";?>>1 - Verificar Conforto Térmico</option>
			<option value="2" <?php if($row[tipo_aparelho] == 2) echo " selected ";?>>2 - Verificar Metragem Linear</option>
			<option value="3" <?php if($row[tipo_aparelho] == 3) echo " selected ";?>>3 - Verificar Ruído</option>
			<option value="4" <?php if($row[tipo_aparelho] == 4) echo " selected ";?>>4 - Verificar Iluminância</option>
			<option value="5" <?php if($row[tipo_aparelho] == 5) echo " selected ";?>>5 - Verificar Poeiras</option>
			<option value="6" <?php if($row[tipo_aparelho] == 6) echo " selected ";?>>6 - Verificar Vapores Orgânicos</option>
		</select></td>
	</tr>
	</table>
<?PHP
        switch($erro){
            case 0:
                echo "<center><font color=white size=2>Dados atualizados com sucesso!</font></center>";
            break;
            case 1:
                echo "<center><font color=red size=2>Selecione um tipo de aparelho!</font></center>";
            break;
            default:
            break;

        }

?>
	<br>

    <table width="90%" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
	  <td align="center">
	  <input type="submit" name="btn_excluir" value="Excluir" onClick="aviso_apa(['cod_aparelho']); return false;" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="submit" name="btn_alterar" value="Alterar" onClick="aviso_apar(['cod_aparelho']); return false;" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
	  <input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','../adm/aparelho_adm.php');return document.MM_returnValue" style="width:100;">
	  <input type="hidden" name="cod_aparelho" value="<?php echo $cod_aparelho; ?>">
	  </td>
	</tr>
	</table>
</form>
</body>
</html>
