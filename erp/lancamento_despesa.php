<?php
session_start();
//print_r($_SESSION);
include "sessao.php";
include "config/connect.php";

if($_POST){
   $valor = str_replace(".", "", $_POST['valor']);
   $valor = str_replace(",", ".", $valor);
   $a=0;
   $sql = "INSERT INTO financeiro_info
   (titulo, valor_total, n_parcelas, forma_pagamento, status, data, dia, mes, ano,
   data_lancamento, data_entrada_saida, tipo_lancamento, historico, funcionario_id)
   VALUES
   ('".addslashes($_POST['cliente'])."',
   '{$valor}',
   '1',
   'Dinheiro',
   '1',
   '".date("Y/m/d")."',
   '".date("d")."',
   '".date("m")."',
   '".date("Y")."',
   '".date("Y/m/d")."',
   '".date("Y/m/d")."',
   '0',
   '".addslashes($_POST['historico'])."',
   '{$_SESSION['usuario_id']}'
   )";

   if(pg_query($sql)){
      $a++;
   }

   $sql = "SELECT MAX(id) FROM financeiro_info WHERE valor_total = '$valor'";
   $result = pg_query($sql);
   $max = pg_fetch_array($result);

if($a > 0){
   for($x=0;$x<1;$x++){
      $sql = "INSERT INTO financeiro_fatura
      (cod_fatura, titulo, valor, parcela_atual, vencimento, status, pago, data_lancamento)
      VALUES
      ('{$max[0]}',
      '".addslashes($_POST['cliente'])."',
      '".number_format($valor, 2,'.','')."',
      '".($x+1)."',
      '".date("Y/m/d")."',
      '1', 1, '".date("Y/m/d")."')";
      if(pg_query($sql)){
         $a++;
         echo "<script>alert('Despesa cadastrada com sucesso!');</script>";
      }else{
         die('Erro ao adicionar informações no banco de dados![fatura]');
      }
   }
}
}

   if($_SESSION['grupo'] == "administrador"){
	$query_cli = "SELECT * FROM site_orc_info
				  WHERE vendedor_id <> 0 ORDER BY data_criacao DESC";
   }else{
   $query_cli = "SELECT * FROM site_orc_info
				  WHERE vendedor_id <> 0  AND
                  vendedor_id = '{$_SESSION['usuario_id']}' ORDER BY data_criacao DESC";
   }

    $result_cli = pg_query($connect, $query_cli)
	or die ("Erro na cunsulta!==>$query_cli" .pg_last_error($connect));

?>
<html>
<head>
<title>Lançamento de Despesa</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="orc.js"></script>
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
    	<th colspan="7" class="linhatopodiresq" bgcolor="#009966">
        <br>TELA DE LANÇAMENTO DE DESPESA<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="7">
			<br>&nbsp;
				<input name="btn_sair" type="button" id="btn_sair" onClick="MM_goToURL('parent','./tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
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
          <td width="25%" align=left class=fontebranca12 valign=top><b>Título do lançamento:</b></td>
          <td width="50%" align=left>
             <input name="cliente" id="cliente" type="text" size="30" style="background:#FFFFCC">
          </td>
        </tr>
        <tr>
          <td width="25%" align=left class=fontebranca12 valign=top><b>Valor:</b></td>
          <td width="50%" align=left>
             <input name="valor" id="valor" type="text" size="10" style="background:#FFFFCC" onkeypress="return FormataReais(this, '.', ',', event);" >
          </td>
        </tr>
        <tr>
          <td width="25%" align=left class=fontebranca12 valign=top><b>Data de lançamento:</b></td>
          <td width="50%" align=left>
             <input name="data" id="data" type="text" size="10" style="background:#FFFFCC" value="<?PHP echo date("d/m/Y");?>" disabled>
          </td>
        </tr>
        <tr>
          <td width="25%" align=left class=fontebranca12 valign=top><b>Histórico:</b></td>
          <td width="50%" align=left>
             <textarea name="historico" id="historico" cols="35" style="background:#FFFFCC"></textarea>
          </td>
        </tr>
      </table>
      <center><input type="submit" name="Submit" value="Enviar" class="inputButton" style="width:100;">
          <!--
          <td width="25%" align=left><input type="button" onclick="select_cliente();" name="Submit" value="Pesquisar" class="inputButton" style="width:100;"></td>
          -->
    </form>
     <!-- CONTEÚDO -->
     <table width="500" border="0" align="center">
        <tr>
          <td width="100%" align=right>
              <div id="lista_orcamentos">
              </div>
          </td>
        </tr>
     </table>
	 </td>
    </tr>
  <tr>
    <td bgcolor="#009966" colspan=7 class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
</body>
</html>
