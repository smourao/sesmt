<?php
include "sessao.php";
include "./config/connect.php";
include "./config/config.php";
include "./config/funcoes.php";

switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"

	case "administrador":
		if($razao=='' || $btn_voltar=='voltar'){
			$query_clientes="select * from clientes";
		}else{
			$query_clientes="select * from clientes where razao_social_cliente like '%".$razao."%'";
		}
		$query_clientes.=" order by cod_cliente";
	break;

	case "clientes":
	$query_clientes.="where cod_cliente=".$cod_cliente."";
	break;

	case "funcionario":
		if($razao!=''){
			$query_clientes="select * from clientes where razao_social_cliente like '%".$razao."%'";
		}
	break;

	case "contador":
	$query_clientes.="where cod_contador=".$cod_contador."";
	break;

	default:
	//header("location: index.php");
	break;

}

?>
<html>
<head>
<title>Sistema SESMT - Lista de Clientes</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript">
	function doNumber () 
	{
		var whichcode = window.event.keyCode;
		if (whichcode < 48) { whichcode = 0; }
		if (whichcode > 57) { whichcode = 0; }
		window.event.keyCode = whichcode;
	}
</script>
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td height="26" colspan="4" class="linhatopodiresq"><div align="center" class="fontebranca22bold">
      <div align="center">
        <table width="136" border="0" cellspacing="0" cellpadding="0">
          <tr>
<?
	if($grupo=="administrador")
	{
?>
            <td width="61"><div align="center">
				<a href="cadastro_cliente.php?novo=new">
				  <img src="img/icone_listagem_r3_c2.jpg" width="38" height="26" border="0">
				</a></div>
			</td>
<?
	}
	else
	{
?>
            <td width="61"><div align="center">&nbsp;</div></td>
<?  } ?>

            <td width="75"><div align="center"><a href="tela_principal.php"><img src="img/icone_listagem_r2_c4.jpg" width="32" height="42" border="0"></a></div></td>
          </tr>
        </table>
        </div>
    </div></td>
  </tr>
    <tr>
      <td height="26" colspan="4" class="linhatopodiresq"><form action="listagem.php" method="post" enctype="multipart/form-data" name="form1">
      <table width="75%" border="0" align="center">
        <tr>
          <td width="24%" align="right"><font color="#FFFFFF" size="-1" face="Arial, Helvetica, sans-serif">Raz&atilde;o</font></td>
          <td width="47%">
<?
	if($grupo!="administrador")
	{ 
?>
			<input name="razao" type="text" id="razao">
<?
	}
	else
	{
?>
			<input name="razao" type="text" id="razao">
<?  }?>
          </td>
          <td width="29%"><input type="submit" name="Submit" value="Pesquisar">
            <input name="btn_voltar" type="submit" id="btn_voltar" value="Voltar"></td>
        </tr>
      </table>
      </form></td>
    </tr>
  <tr>
    <td colspan="4" class="linhatopodiresq"><div align="center" class="fontebranca22bold">
      <div align="center">Registros no Sistema </div>
    </div></td>
  </tr>
  <tr>
    <td width="76" class="linhatopodiresq"><div align="left" class="fontebranca12">Cod. Cliente </div></td>
   <!-- <td width="60" class="linhatopodir"><div align="left" class="fontebranca12">Cod. Filial </div></td>-->
    <td width="148" class="linhatopodir"><div align="left" class="fontebranca12">Razão Social </div></td>
    <td width="138" class="linhatopodir"><div align="left" class="fontebranca12">Contato  </div></td>
    <td width="78" class="linhatopodir"><div align="left" class="fontebranca12">Telefone</div></td>
  </tr>
<?
/*
if($razao=='' || $btn_voltar=='voltar'){
	$query_clientes="select * from cliente";
}else{
	$query_clientes="select * from cliente where razao_social like '%".$razao."%' or filial_id like'%".$razao."%'";
}
*/

if (!empty($query_clientes))
{
	$result_clientes=pg_query($connect, $query_clientes) 
		or die ("Erro na query: $query_clientes".pg_last_error($connect));

  if (pg_num_rows($result_clientes) > 0 )
  {
  
	  while($row=pg_fetch_array($result_clientes))
	  {
?>
  <tr>
    <td class="linhatopodiresq"><div align="left" class="linksistema"><a href="cadastro_cliente.php?cod_cliente=<?=$row[cod_cliente]?>"><?=str_pad($row[cod_cliente], 03, "0", STR_PAD_LEFT)?></a>&nbsp;</div></td>
    <?php /*?><td class="linhatopodir"><div align="left" class="linksistema">
      <a href="cadastro_cliente.php?cod_cliente=<?=$row[cod_cliente]?>&filial_id=<?=$row[filial_id]?>"><?=str_pad($row[filial_id], 03, "0", STR_PAD_LEFT)?></a>
    &nbsp;</div></td><?php */?>
    <td class="linhatopodir"><div align="left" class="linksistema"><a href="cadastro_cliente.php?cod_cliente=<?=$row[cod_cliente]?>"><?=$row[razao_social_cliente]?></a></div></td>
    <td class="linhatopodir"><div align="left" class="linksistema"><a href="cadastro_cliente.php?cod_cliente=<?=$row[cod_cliente]?>"><?=$row[contato_ind_nome_cliente]?></a></div></td>
    <td class="linhatopodir"><div align="left" class="linksistema">
      <a href="cadastro_cliente.php?cod_cliente=<?=$row[cod_cliente]?>"> <?=$row[tel_cliente]?></a>&nbsp;</div></td>
  </tr>
<?php
	}
  }
  else
  { 
	echo "<script>alert('Não foi encontrado o cógido digitado.');</script>";
  }
}
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <!--<td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>-->
  </tr>
</table>
</body>
</html>