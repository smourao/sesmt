<?php
include "../sessao.php";
include "../config/connect.php";

switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"

	case "administrador":
		if($razao=='' || $btn_voltar=='voltar')
		{
			$query_fatura="select * from fatura";
		}
		else
		{
			$query_fatura="select * from fatura 
							 where lower(natureza_servico) like '%". strtolower(addslashes($razao)) ."%'" ;
		}
		$result_fatura=pg_query($query_fatura) 
			or die ("Erro na query: $query_fatura".pg_last_error($connect));
		
		$query_fatura.=" order by natureza_servico";
	break;

	case "cliente":
	$query_fatura.="where cliente_id=".$cliente_id."";
	break;

	case "funcionario":
	$query_fatura.="where funcionario_id=".$funcionario_id."";
	break;

	case "contador":
	$query_fatura.="where contador_id=".$contador_id."";
	break;

	default:
	//header("location: index.php");
	break;

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lista de Clientes da Fatura</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css" />
<style type="text/css">
td img {display: block;}
</style>

</head>

<body bgcolor="#006633" >
<form action="lista_fatura.php" method="post" enctype="multipart/form-data" name="cadastro" target="_self" id="cadastro">
  <table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    <tr>
      <td colspan="3" align="center" class="fontebranca22bold"><br />Lista de Clientes <br />&nbsp;</td>
    </tr>
        <tr>
          <td width="24%" align="right"><font color="#FFFFFF" size="-1" face="Arial, Helvetica, sans-serif">Cliente</font></td>
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
    <tr>
      <td class="fontebranca12" colspan="2">Cliente </td>
      <td class="fontebranca12">Data </td>
    </tr>
	<?php
	while($row=pg_fetch_array($result_fatura)){
	?>
    <tr>
      <td class="fontebranca12" colspan="2"><div class="linksistema"><a href="fatura_servico.php?cod_fatura=<?=$row[cod_fatura]?>&cod_cliente=<?=$row[cod_cliente]?>"> <?=$row[natureza_servico]?> </a></div></td>
      <td class="fontebranca12"><div class="linksistema"><a href="fatura_servico.php?cod_fatura=<?=$row[cod_fatura]?>&cod_cliente=<?=$row[cod_cliente]?>"> <?=$row[data_compra]?> </a></div></td>
	</tr>
	<?php
	}
	?>
  </table>
</form>
</body>
</html>
