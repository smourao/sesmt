<?php
include "sessao.php";
include "./config/connect.php";
include "./config/config.php";
include "./config/funcoes.php";

switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"

	case "administrador":

		if ($fornecedores == '' )
		{
			$query_fornecedores = "select fornecedor_id, segmento, razao_social, nome_responsavel, 
								   telefone1, fax, id_nextel, email from fornecedores";
		}else
		{
			$query_fornecedores = "select fornecedor_id, segmento, razao_social, nome_responsavel, 
								   telefone1, fax, id_nextel, email from fornecedores 
								   where segmento like '%".ucwords(addslashes($fornecedores))."%' 
								   or razao_social like '%".ucwords(addslashes($fornecedores))."%' 
								   or nome_responsavel like '%".ucwords(addslashes($fornecedores))."%'";
		}
			$query_fornecedores.= " order by razao_social";						   
		break;
		
		case "cliente":
		$query_fornecedores.="where cliente_id=".$cliente_id."";
		break;
	
		case "funcionario":
			if($fornecedores!=''){
				$query_fornecedores="select fornecedor_id, segmento, razao_social, nome_responsavel, telefone1,
								     fax, id_nextel, email from fornecedores 
								     where segmento like '%".ucwords(addslashes($fornecedores))."%' 
								     or razao_social like '%".ucwords(addslashes($fornecedores))."%' 
								     or nome_responsavel like '%".ucwords(addslashes($fornecedores))."%'";
			}
		break;
	
		case "contador":
		$query_fornecedores.="where contador_id=".$contador_id."";
		break;
	
		default:
		//header("location: index.php");
		break;
}

?>
<html>
<head>
<title>Sistema SESMT - Lista de Fornecedores</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="scripts.js"></script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho</h2></center>
<p>&nbsp;</p>
<table width="500" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <th class="linhatopodiresq" bgcolor="#009966"><br>TELA FORNECEDORES<BR>&nbsp;</th>
	</tr>
		<tr>
	    <tr>
            <th bgcolor="#009966">
			<br>&nbsp;
			<?php
				if($grupo=="administrador")
				{
			?>
			<input name="btn_novo" type="button" id="btn_novo" onClick="MM_goToURL('parent','cadastro_fornecedores.php'); return document.MM_returnValue" value="Novo" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
			<?php
				}
				else
				{
			?>
						&nbsp;
			<?php  } ?>
			
			<input name="btn_sair" type="button" id="btn_sair" onClick="MM_goToURL('parent','tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;"> 
			<br>&nbsp;
            </th>
			</tr>
          </tr>
  <tr>
  	<td height="26" class="linhatopodiresq">
	<form action="listagem_fornecedores.php" method="post" enctype="multipart/form-data" name="form1">
	<br>
	<table width="400" border="0" align="center">
		<tr>
			<td width="25%"><strong>Produto/Serviço:</strong></td>
			<td width="50%">
			<?php
				if($grupo!="administrador")
				{ 
			?>
			<input name="fornecedores" type="text" size="30" style="background:#FFFFCC">
			<?php
				}
				else
				{
			?>
				<input name="fornecedores" type="text" size="30" style="background:#FFFFCC">
			<?php
				}
			?>
			</td>
			<td width="25%"><input type="submit" name="submit" value="Pesquisar" class="InputButton" style="width:100;"></td>
		</tr>
	</table>
	</form>	
	</td>
   </tr>
</table>
   <?php
echo "<table width=\"90%\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" border=\"0\">
	<tr><th><h3>Registros no Sistema </h3></th></tr>";
	
	if (!empty($query_fornecedores)) {
		$result_fornecedores=pg_query($query_fornecedores) 
			or die ("Erro na query: $query_fornecedores".pg_last_error($connect));
	
	if (pg_num_rows($result_fornecedores) > 0 )  {
	
	while($row=pg_fetch_array($result_fornecedores)){
	
	echo "<table width=\"90%\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" border=\"1\">
		<tr>
			<td class=\"fontebranca12\">Produto/Serviço</td>
			<td class=\"fontebranca12\">Razão Social</td>
		</tr>
		<tr>
			<td class=\"linksistema\"><a href=\"cadastro_fornecedores.php?cod_fornecedor=$row[fornecedor_id]\"> $row[segmento] </a>&nbsp;</td>
			<td class=\"linksistema\"><a href=\"cadastro_fornecedores.php?cod_fornecedor=$row[fornecedor_id]\"> $row[razao_social]</a>&nbsp;</td>
		</tr>
		</table>
		<table width=\"90%\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" border=\"1\">
		<tr>
			<td class=\"fontebranca12\">Contato</td>
			<td class=\"fontebranca12\">E-mail</td>
		</tr>
		<tr>
		    <td class=\"linksistema\"><a href=\"cadastro_fornecedores.php?cod_fornecedor=$row[fornecedor_id]\"> $row[nome_responsavel]</a>&nbsp;</td>
	        <td class=\"linksistema\"><a href=\"cadastro_fornecedores.php?cod_fornecedor=$row[fornecedor_id]\"> $row[email]</a>&nbsp;</td>
		</tr>
		</table>
		<table width=\"90%\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" border=\"1\">
		<tr>
			<td class=\"fontebranca12\">Telefone</td>
			<td class=\"fontebranca12\">FAX</td>
			<td class=\"fontebranca12\">Nextel</td>
		</tr>
		<tr>
		    <td class=\"linksistema\"><a href=\"cadastro_fornecedores.php?cod_fornecedor=$row[fornecedor_id]\"> $row[telefone1]</a>&nbsp;</td>
			<td class=\"linksistema\"><a href=\"cadastro_fornecedores.php?cod_fornecedor=$row[fornecedor_id]\"> $row[fax]</a>&nbsp;</td>
			<td class=\"linksistema\"><a href=\"cadastro_fornecedores.php?cod_fornecedor=$row[fornecedor_id]\"> $row[id_nextel]</a>&nbsp;</td>
		</tr>
		</table><br>";
  	}
  }
  else
  { 
	echo "<script>alert('Não foi encontrado o cógido digitado.');</script>";
  }
}
echo "<tr>
		<td bgcolor=\"#009966\" class=\"linhatopodiresqbase\"><font color=\"#FFFFFF\"></font>&nbsp;</td>
		<td bgcolor=\"#009966\" class=\"linhatopodirbase\"><font color=\"#FFFFFF\"></font>&nbsp;</td>
		<td bgcolor=\"#009966\" class=\"linhatopodirbase\"><font color=\"#FFFFFF\"></font>&nbsp;</td>
		<td bgcolor=\"#009966\" class=\"linhatopodirbase\"><font color=\"#FFFFFF\"></font>&nbsp;</td>
		<td bgcolor=\"#009966\" class=\"linhatopodirbase\"><font color=\"#FFFFFF\"></font>&nbsp;</td>
		<td bgcolor=\"#009966\" class=\"linhatopodirbase\"><font color=\"#FFFFFF\"></font>&nbsp;</td>
		<td bgcolor=\"#009966\" class=\"linhatopodirbase\"><font color=\"#FFFFFF\"></font>&nbsp;</td>
    </tr>
</table>";
  ?>
</body>
</html>