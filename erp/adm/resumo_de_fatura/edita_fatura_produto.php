<?php
session_start();
include "../../sessao.php";
include "config/connect.php";
$orc = $_GET['orcamento'];

function convertwords($text){
$siglas = array("ppp", "ppra", "pcmso", "aso", "cipa", "apgre", "ltcat", "epi", //Siglas normais
				"ppp,", "ppra,", "pcmso,", "aso,", "cipa,", "apgre,", "ltcat,", "epi,", //Siglas com v�rgula
				"(ppp)", "(ppra)", "(pcmso)", "(aso)", "(cipa)", "(apgre)", "(ltcat)", "(epi)", //Siglas entre par�nteses
				"nr", "nr.", "mr", "mr.", "in", "in.", "nbr", "nbr.", "a0", "a3", "a4", "(a4)"); //Siglas diversas
$at = explode(" ", $text);
$temp = "";
for($x=0;$x<count($at);$x++){
   $at[$x] = strtolower($at[$x]);

  if(in_array($at[$x], $siglas)){
     $at[$x] = strtoupper($at[$x]);
  }elseif(strlen($at[$x])>3){
        $at[$x] = ucwords($at[$x]);
    }

    $temp .= $at[$x]." ";
}
return $temp;
}

if($_POST){

$_POST['valor'] = str_replace(".", "", $_POST['valor']);
$_POST['valor'] = str_replace(",", ".", $_POST['valor']);

   $sql = "UPDATE site_fatura_produto SET descricao = '".addslashes($_POST['descricao'])."',
   quantidade = '{$_POST['quantidade']}', parcelas = '{$_POST['parcelas']}', valor = '{$_POST['valor']}'
   WHERE id = {$_GET['id']}";
   
   if(pg_query($sql)){
      echo "<script>location.href=location.href='cria_resumo_de_fatura.php?act=edit&cod_cliente={$_GET['cod_cliente']}&cod_filial={$_GET['cod_filial']}&fatura={$_GET['fatura']}&pc={$_GET[pc]}';</script>";
   }else{
      echo "Erro ao atualizar dados!";
   }
}
?>
<html>
<head>
<title>Resumo de Fatura</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="res_fat.js"></script>
<script language="javascript" src="scripts.js"></script>
<style type="text/css" title="mystyles" media="all">
<!--
loading{
display: block;
position: relative;
left: 0px;
top: 60px;
width:0px;
height:0px;
color: #888000;
z-index:1;
}

loading_done{
position: relative;
display: none;
}

.dia {font-family: helvetica, arial; font-size: 8pt; color: #FFFFFF}
.data {font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#191970}
.data:hover{font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#000000; font-weight:bold;}
.mes {font-family: helvetica, arial; font-size: 8pt}
.Cabecalho_Calendario {font-family: helvetica, arial; font-size: 10pt; color: #000000; text-decoration:none; font-weight:bold}
.Cabecalho_Calendario:hover{font-family: helvetica, arial; font-size: 10pt; color: #000000; text-decoration:none; font-weight:bold}
.mes {font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#191970}
.mes:hover {font-family: helvetica, arial; font-size: 8pt; text-decoration:none; color:#191970; font-weight:bold}

-->
</style>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
      <input type=hidden name=fatid id=fatid value="<?PHP echo $_GET['fatura'];?>">
      <input type=hidden name=cod_cliente id=cod_cliente value="<?PHP echo $_GET['cod_cliente'];?>">
      <input type=hidden name=cod_filial id=cod_filial value="<?PHP echo $_GET['cod_filial'];?>">
<p>
<center><h2> SESMT - Seguran�a do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="700" border="2" align="center" cellpadding="0" cellspacing="0">
    <tr>
    	<th colspan="5" class="linhatopodiresq" bgcolor="#009966"><br>TELA DE CRIA��O DE OR�AMENTO<br>&nbsp;</th>
    </tr>
    <tr>
		<tr>
			<th bgcolor="#009966" colspan="5">
			<br>&nbsp;
				<input name="btn_sair" type="button" id="btn_sair" onClick="location.href='cria_resumo_de_fatura.php?act=edit&&cod_cliente=<?PHP echo $_GET['cod_cliente'];?>&cod_filial=<?PHP echo $_GET['cod_filial'];?>&fatura=<?PHP echo $_GET['fatura'];?>'" value="Voltar" style="width:100;">
			<br>&nbsp;
			</th>
		</tr>
	</tr>
	<tr>
      <td height="26" colspan="5" class="linhatopodiresq">
<form name=frm id=frm method=post>
<span class=fontebranca12><b>Edi��o de Item do Resumo da Fatura:</b></span><br>

<?PHP
   $sql = "SELECT * FROM site_fatura_produto WHERE id = '{$_GET['id']}'";
   $result = pg_query($sql);
   $data = pg_fetch_array($result);
?>
<table border=1 width=100%>
<tr>
   <td width=180 class=fontebranca12><b>C�digo do Item:</b></td>
   <td  class=fontebranca12><?PHP echo $_GET['id'];?></td>
</tr>
<tr>
   <td width=180 class=fontebranca12><b>Descri��o:</b></td>
   <td  class=fontebranca12><textarea name='descricao' style="width:100%;" rows=5><?PHP echo $data['descricao'];?></textarea></td>
</tr>
<tr>
   <td width=180 class=fontebranca12><b>Quantidade</b></td>
   <td  class=fontebranca12>
   <input type=text name=quantidade value=<?PHP echo $data['quantidade'];?>>
   </td>
</tr>
<tr>
   <td width=180 class=fontebranca12><b>Parcelas</b></td>
   <td  class=fontebranca12>
   <input type=text name=parcelas value=<?PHP echo $data['parcelas'];?>>
   </td>
</tr>

<tr>
   <td width=180 class=fontebranca12><b>Valor</b></td>
   <td  class=fontebranca12>
   <input type=text name=valor onkeypress="return FormataReais(this, '.', ',', event);" value=<?PHP echo number_format($data['valor'], 2, ',','.');?>>
   </td>
</tr>
<tr>
   <td colspan=2 class=fontebranca12 align=center>
   <input type=submit value="Atualizar">
   </td>
</tr>
</table>
</form>
	 </td>
    </tr>
</table>
</body>
</html>
