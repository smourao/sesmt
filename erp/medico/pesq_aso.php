<?php 
include "../sessao.php";
include "../config/config.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

$aso   		  = $_POST["cod_aso"];
$funcionario  = $_POST["cod_func"];

if( !empty($aso) and $_POST[btn_enviar]=="Enviar" ){
		header("location: http://www.sesmt-rio.com/erp/medico/aso_final.php?aso=$aso&funcionario=$funcionario");
}

?>
<html>
<head>
<title>Pesquisa de ASO</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="form1" method="post" action="pesq_aso.php">
<table align="center" width="700" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <th colspan="2" bgcolor="#009966" ><br>
        <h2>Pesquisa de ASO</h2>
        <p>
		Escolha o <U>ASO</U> :<br>
		&nbsp;
    </th>
  </tr>
  </tr>
    <td colspan="2">&nbsp;</td>
  </tr>
<?php
  /*****************
  	Parte destinada a erros!
   *****************/
  	if($_GET["erro"]==1){
		echo "<tr>
				<th colspan=2 bgcolor=#FFFFFF>
					<font color=#FF0000><b><br>Preencha todos os campos corretamente!</b><br>&nbsp;</font>
				</th>
			  </tr>
		      <tr>
				 <td colspan=2>&nbsp;</td>
			  </tr>";
	}
?>
  <tr>
  	<td width="150"><br><b>&nbsp; Código do ASO: <br>&nbsp;</td>
	<td width="550"> 
		<br>
		&nbsp;&nbsp;&nbsp;<input type="text" name="aso_pesq" size="5"> 
		&nbsp;&nbsp;&nbsp; <input type="submit" name="btn_busca" value="Buscar" style="width:100;"> <br>&nbsp;
	</td>
  </tr>
<?php
// trecho que realiza a busca dos clientes pelo que foi digitado
	if ( (!empty($_POST[aso_pesq]) and $_POST[btn_busca]=="Buscar") )
	{
		echo "  <tr>";
		echo "	<th class=\"style1\" colspan=2> Resultado da busca:</th>";
		echo "</tr>";
		echo "<tr>";
		echo "  <td colspan=2> <br>";

		$sql_busca = "select 
					  cod_aso, f.nome_func
					  from aso a, funcionarios f 
					  where a.cod_func = f.cod_func
					  AND a.cod_aso = $_POST[aso_pesq]
					  order by cod_aso";

		$consulta_busca = pg_query($connect, $sql_busca);
		
		if ($consulta_busca)
		{
			while($row_busca = pg_fetch_array($consulta_busca)){
				echo "&nbsp;&nbsp;&nbsp; <input type=\"radio\" name=\"cod_aso\" value=\"$row_busca[cod_aso]\" > $row_busca[nome_func] <br>";
			}
			
		}
		else if (pg_num_rows($consulta_busca)==0) {
			echo "<script>alert('A busca por \"$_POST[aso_pesq]\" não retornou resultado.');</script>";
		}
		echo "<br> &nbsp;	</td>";
		echo " </tr>";

	}
?>
  <tr>
    <th colspan="2" bgcolor="#009966"> <br>
        <input type="submit" value="Enviar" name="btn_enviar" style="width:100;">
      &nbsp;&nbsp;&nbsp;
      <input name="reset" type="reset" style="width:100;"  value="Limpar">
      &nbsp;&nbsp;&nbsp;
      <input type="button"  name="voltar" value="Sair" onClick="MM_goToURL('parent','tela_principal.php');return document.MM_returnValue" style="width:100;">
      <br>
	  <?php /* encerrar conexão */ pg_close($connect);?>	  
	</th>
  </tr>
  <tr>
    <td colspan="2" >&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>