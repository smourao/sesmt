<?php
include "./config/connect.php";
include "sessao.php";
$vendedor_id = $_SESSION[usuario_id];
//echo $grupo;
switch($grupo){
	case "administrador":
		if($razao=='' || $btn_voltar=='voltar'){
			$query_clientes="select * from cliente_pc WHERE cnpj_contratante = ''";
		}else{
			$query_clientes="select * from cliente_pc
							 where
                              cnpj_contratante = '' AND
                             lower(razao_social) like '%". strtolower(addslashes($razao)) ."%'
							 or lower(nome_fantasia) like '%" . strtolower(addslashes($razao)) ."%'" ;
		}
		$query_clientes.=" order by cliente_id";
	break;

	case "cliente":
	$query_clientes.="where cliente_id=".$cliente_id."";
	break;

	case "funcionario":
		if($razao!=''){
			$query_clientes="select * from cliente_pc
							 where
                              cnpj_contratante = '' AND
                             lower(razao_social) like '%". strtolower(addslashes($razao)) ."%'
							 or lower(nome_fantasia) like '%" . strtolower(addslashes($razao)) ."%'
							 AND lower(status) = 'ativo'";
		}
	break;

	case "contador":
	$query_clientes.="where contador_id=".$contador_id."";
	break;
	
	case "vendedor":
	if ($razao==''){
		$query_clientes = "select * from cliente_pc
						WHERE vendedor_id = $vendedor_id AND cnpj_contratante = ''";
	}else{
		$query_clientes = "select * from cliente_pc
						where
                        cnpj_contratante = '' AND
                        lower(razao_social) like '%".strtolower(addslashes($razao))."%' 
						or lower(nome_fantasia) like '%".strtolower(addslashes($razao))."%'
						AND vendedor_id = $vendedor_id
						AND lower(status) = 'ativo'	";
		}
		$query_clientes.=" order by cliente_id";
	break;

	default:
	//header("location: index.php");
	break;

}

?>
<html>
<head>
<title>Parceria Comercial</title>
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

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td height="26" colspan="6" class="linhatopodiresq"><div align="center" class="fontebranca22bold">
      <div align="center">
        <table width="136" border="0" cellspacing="0" cellpadding="0">
          <tr>
<?
	if($grupo=="administrador"){
?>
            <td width="61"><div align="center">
				<a href="cadastro_cliente_pc.php?novo=new">
				  <img src="img/icone_listagem_r3_c2.jpg" width="38" height="26" border="0">
				</a></div>
			</td>
<?
	}else{
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
      <td height="26" colspan="6" class="linhatopodiresq"><form action="listagem_pc.php" method="post" enctype="multipart/form-data" name="form1">
      <table width="75%" border="0" align="center">
        <tr>
          <td width="24%" align="right"><font color="#FFFFFF" size="-1" face="Arial, Helvetica, sans-serif">Raz&atilde;o</font></td>
          <td width="47%">
<?
	if($grupo!="administrador"){
?>
			<input name="razao" type="text" id="razao">
<?
	}else{
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
    <td colspan="6" class="linhatopodiresq"><div align="center" class="fontebranca22bold">
      <div align="center">Parceria Comercial</div>
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#009966"  width="20" class="linhatopodiresq"><div align="center" class="fontebranca12"><b>Cod.</b></div></td>
    <!--
    <td bgcolor="#009966"  width="60" class="linhatopodir"><div align="left" class="fontebranca12">Cod. Filial </div></td>
    -->
    <td bgcolor="#009966"  colspan=2 class="linhatopodir"><div align="center" class="fontebranca12"><b>Raz&atilde;o Social </b></div></td>
    <td bgcolor="#009966"  class="linhatopodir"><div align="center" class="fontebranca12"><b>Contato</b></div></td>
    <td bgcolor="#009966"  class="linhatopodir"><div align="center" class="fontebranca12"><b>Telefone</b></div></td>
    <td bgcolor="#009966"  width="70" class="linhatopodir"><div align="center" class="fontebranca12"><b>Contratos</b></div></td>
  </tr>
<?php
if (!empty($query_clientes)){
	$result_clientes=pg_query($query_clientes);
  if (pg_num_rows($result_clientes) > 0 ){
	  while($row=pg_fetch_array($result_clientes)){
	  
	  $sql = "SELECT * FROM cliente_pc WHERE cnpj_contratante = '$row[cnpj]'";
	  $resultado = pg_query($sql);
	  $contratados = pg_fetch_all($resultado);
?>
  <tr>
    <td class="linhatopodiresq" align=center><div align="center" class="linksistema"><a href="cadastro_cliente_pc.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>">
		<?php echo str_pad($row[cliente_id], 03, "0", STR_PAD_LEFT)?></a>
    </div></td>
    <!--
    <td class="linhatopodir"><div align="center" class="linksistema"><a href="cadastro_cliente_pc.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>">
		<?php echo str_pad($row[filial_id], 03, "0", STR_PAD_LEFT)?></a>
    &nbsp;</div></td>
    -->
    <td colspan=2 class="linhatopodir"><div align="left" class="linksistema"><a href="cadastro_cliente_pc.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>">
		&nbsp;<?php echo $row[razao_social]?>
	</a></div></td>
    <td class="linhatopodir"><div align="left" class="linksistema"><a href="cadastro_cliente_pc.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>">
    	<?php echo $row[nome_contato_dir]?>
    </a></div></td>
    <td class="linhatopodir" align=center><div align="center" class="linksistema"><a href="cadastro_cliente_pc.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>">
		<?php echo $row[telefone]?></a>
    </div></td>
    <td class="linhatopodir" align=center><div align="center" class="linksistema">
    <a href="listagem_pc_contratados.php?cod_cliente=<?php echo $row[cliente_id]?>&cod_filial=<?php echo $row[filial_id]?>">
		<?php echo pg_num_rows($resultado);?> [Listar]</a>
    </div></td>
  </tr>
<?php
	}
  }else{
	echo "<script>alert('Não foi encontrado o cógido digitado.');</script>";
  }
}
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
</body>
</html>
