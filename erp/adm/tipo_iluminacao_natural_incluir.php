<?php
include "../sessao.php";
include "../config/connect.php";
include "../config/config.php";
include "../config/funcoes.php";

ob_start();

if($cod_luz_nat != ""){
$query = "SELECT * FROM luz_natural WHERE cod_luz_nat = $cod_luz_nat";
$res = pg_query($connect, $query);
$row = pg_fetch_array($res);
}

if($cod_luz_nat != ""){
$query_incluir="INSERT into luz_natural (cod_luz_nat, nome_luz_nat, descricao_luz_nat) values ($cod_luz_nat, '$tipo', '$descricao')";
pg_query($query_incluir) or die ("Erro na query:$query_incluir".pg_last_error($connect));

echo"<script>alert('Tipo Tipo Iluminação Natural Incluído com Sucesso!');</script>";
header("location: tipo_iluminacao_natural_adm.php");
}

?>
<html>
<header>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
</header>
<title>Cadastro de Tipo de Iluminação Natural</title><body bgcolor="#006633">
<form name="form1" method="post" action="tipo_iluminacao_natural_incluir.php">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="4" class="fontebranca12"><div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
          <div align="center"></div>
        <div align="center"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12"><div align="center" class="fontepreta14bold"><font color="#000000">Tipo Ilumina&ccedil;&atilde;o Artificial </font></div></td>
    </tr>
	<tr>
      <td colspan="4" class="fontebranca12"><table width="499" border="0" cellspacing="0" cellpadding="0">
      <?php 
	  	$query_max = "SELECT max(cod_luz_nat) as cod_luz_nat FROM luz_natural";
		
		$result_max = pg_query($connect, $query_max); //executa query
	
		$row_max = pg_fetch_array($result_max); // recebe o resultado da query (linhas)
	  ?>
          <tr>
		  	<td width"97" class="fontebranca12">Código</td>
			<td width="303"><input type="text" name="cod_luz_nat" value="<?php echo $row_max[cod_luz_nat] + 1; ?>" readonly="true" size="5"></td> 
		  </tr>
		  <tr>
            <td width="97" class="fontebranca12">Tipo</td>
            <td width="303"><input name="tipo" type="text" id="tipo" size="30"></td>
          </tr>
          <tr>
            <td class="fontebranca12">Descrição</td>
            <td><textarea name="descricao" cols="40" rows="5" class="camposform" id="descricao"></textarea></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
			<td colspan="4" class="fontebranca12">
			<table width="200" border="0" align="left" cellpadding="0" cellspacing="0">
			<tr>
            <td class="fontebranca12"><input type="submit" name="Submit" value="Incluir"></td>
			<td class="fontebranca12"><input name="btn_voltar" type="submit" id="btn_voltar" onClick="MM_goToURL('parent','tipo_iluminacao_natural_adm.php'); return document.MM_returnValue" &nbsp;&nbsp; value="&lt;&lt; Voltar"></td>
          </tr>
		  </table></td></tr>
      </table></td>
    </tr>
  </table>
</form>
</html>