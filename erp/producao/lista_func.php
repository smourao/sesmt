<?php
include "../sessao.php";
include "../config/connect.php";
//include "../config/funcoes.php";

$funcionario = $_POST[funcionario];

if($funcionario=="")// || $btn_voltar=='voltar')
{
	$query_func = "SELECT cod_func, nome_func, tel_func, endereco_func, bairro_func, cel_func, 
					   email_func, num_ctps_func, serie_ctps_func, cbo, cod_cidade, 
					   cod_status, cod_funcao, cod_setor, cod_cliente, cpf_func, sexo_func, 
					   data_nasc_func, data_admissao_func, data_desligamento_func
			  	   FROM funcionarios";
}else
{
	$query_func = "SELECT cod_func, nome_func, tel_func, endereco_func, bairro_func, cel_func, 
					   email_func, num_ctps_func, serie_ctps_func, cbo, cod_cidade, 
					   cod_status, cod_funcao, cod_setor, cod_cliente, cpf_func, sexo_func, 
					   data_nasc_func, data_admissao_func, data_desligamento_func
			  	   FROM funcionarios
					where lower(nome_func) like '%".addslashes(strtolower($funcionario))."%' ";
}

$query_func.=" order by nome_func";

$result_func = pg_query($connect, $query_func) 
	or die ("Erro na query: $query_func ==> ".pg_last_error($connect));

?>
<html>
<head>
<title>Produto</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="800" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="5" class="linhatopodiresq" bgcolor="#009966"><br>
    	TELA DE FUNCION&Aacute;RIOS <br>
    	&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="5">
			<br>&nbsp;
				<input name="btn_novo" type="button" id="btn_novo" onClick="MM_goToURL('parent','cad_func.php'); return document.MM_returnValue" value="Novo" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;
				<input name="btn_sair" type="button" id="btn_sair" onClick="MM_goToURL('parent','../adm/index.php'); return document.MM_returnValue" value="Sair" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>			
      <td height="26" colspan="5" class="linhatopodiresq">
	  <form action="lista_func.php" method="post" enctype="multipart/form-data" name="form1">
	  <br>
      <table width="400" border="0" align="center">
        <tr>
          <td width="25%"><strong>Funcion&aacute;rio:</strong></td>
          <td width="50%"><input name="funcionario" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%"><input type="submit" name="Submit" value="Pesquisar" class="inputButton" style="width:100;"></td>
        </tr>
      </table>
      </form>
	 </td>
    </tr>
  <tr>
    <th colspan="5" class="linhatopodiresq" bgcolor="#009966">
      <h3>Registros no Sistema</h3>
    </th>
  </tr>
  <tr>
    <td width="8%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Código</strong></div></td>
    <td width="30%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Nome Funcion&aacute;rio </strong></div></td>
    <td width="30%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Endere&ccedil;o</strong></div></td>
    <td width="20%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>E-mail</strong></div></td>
    <td width="12%" bgcolor="#009966" class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Telefone</strong></div></td>
  </tr>
<?php
  while($row = pg_fetch_array($result_func)){
?>
  <tr>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[cod_func];?></a>
	  </div>
	</td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[nome_func];?></a>
	  </div>
	</td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[endereco_func];?></a>
	  </div>
	</td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[email_func];?></a>
	  </div>
	</td>
    <td class="linhatopodiresq">
	  <div align="left" class="linksistema">
	   &nbsp;&nbsp;<a href="alt_func.php?id=<?php echo $row[cod_func];?>&cliente=<?php echo $row[cod_cliente];?>&setor=<?php echo $row[cod_setor];?>"><?php echo $row[tel_func];?></a>
	  </div>
	</td>
  </tr>
<?php
  }
  $fecha = pg_close($connect);
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
</body>
</html>
