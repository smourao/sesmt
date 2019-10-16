<?php
session_start();
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../../sessao.php";
include "config/connect.php";

if($_POST){
   //
//   print_r($_POST);
   $sql = "SELECT * FROM site_fatura_propaganda";
   $result = pg_query($sql);
   $n = pg_fetch_all($result);
   
   if(pg_num_rows($result)>0){
      $sql = "UPDATE site_fatura_propaganda SET texto = '".addslashes($_POST['texto'])."' WHERE id='{$n[0]['id']}'";
   }else{
      $sql = "INSERT INTO site_fatura_propaganda (texto) values ('".addslashes($_POST['texto'])."')";
   }
   if(pg_query($sql)){
      echo "<script>alert('Propaganda atualizada.');</script>";
   }else{
      echo "<script>alert('Erro ao adicionar propaganda.');</script>";
   }
}

$sql = "SELECT * FROM site_fatura_propaganda";
$buffer = pg_fetch_array(pg_query($sql));
?>
<html>
<head>
<title>Resumo de Fatura - Cadastro de Propaganda</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="res_fat.js"></script>
<script language="javascript" src="scripts.js"></script>
</head>
<style>
#loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}

#loading_done{
position: relative;
display: none;
}
</style>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="7" class="linhatopodiresq" bgcolor="#009966"><br>RESUMO DE FATURA - Cadastro de Propaganda<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="7">
			<br>&nbsp;
               <input name="btn_sair" type="button" id="btn_sair" onClick="location.href='resumo_de_fatura_index.php';" value="Voltar" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="7" class="linhatopodiresq">
<!--	  <form action="lista_orcamento.php" method="post" enctype="multipart/form-data" name="form1">-->
	  <br>
	  <form method=post>
      <table width="500" border="0" align="center">
        <tr>
          <td width="25%" align=right><strong>Propaganda:</strong></td>
          <td align=center><textarea name="texto" id="texto" style="background:#FFFFCC" cols=60 rows=5><?PHP echo $buffer['texto'];?></textarea></td>
        </tr>
      </table>
      <center>
      <input type=submit value="Gravar" style="width:100px;">
      </center>
      </form>
</body>
</html>
