<?php
include "./config/connect.php";
include "sessao.php";

$vendedor_id = $_SESSION[usuario_id];

switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"
	case "administrador":
		if($razao=='' || $btn_voltar=='voltar'){
			$query_clientes="select * from cliente";
		}else{
			$query_clientes="select * from cliente 
							 where lower(razao_social) like '%". strtolower(addslashes($razao)) ."%' 
							 or lower(nome_fantasia) like '%" . strtolower(addslashes($razao)) ."%'" ;
		}
		$query_clientes.=" order by cliente_id";
	break;

	case "cliente":
	    $query_clientes.="where cliente_id=".$cliente_id."";
	break;

	case "funcionario":
	  if($_SESSION[usuario_id] == 30){
	  if($razao=='' || $btn_voltar=='voltar'){
			$query_clientes="select * from cliente";
		}else{
			$query_clientes="select * from cliente 
							 where lower(razao_social) like '%". strtolower(addslashes($razao)) ."%' 
							 or lower(nome_fantasia) like '%" . strtolower(addslashes($razao)) ."%'" ;
		}
		$query_clientes.=" order by cliente_id";	  
	  }else{ 
		if($razao!=''){
			$query_clientes="select * from cliente 
							 where lower(razao_social) like '%". strtolower(addslashes($razao)) ."%'
							 or lower(nome_fantasia) like '%" . strtolower(addslashes($razao)) ."%'
							 AND lower(status) = 'ativo'";
		}
	}
	break;

	case "contador":
	    $query_clientes.="where contador_id=".$contador_id."";
	break;
	
	case "vendedor":
	    if ($razao==''){
		    $query_clientes = "select * from cliente
						WHERE vendedor_id = $vendedor_id";
		}else{
		$query_clientes = "select * from cliente
						where lower(razao_social) like '%".strtolower(addslashes($razao))."%' 
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
<title>Cadastro de Cliente</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="ajax.js"></script>
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

<table width="700" border="0" align="center" cellpadding="4" cellspacing="0">
    <tr>
    <td height="26" colspan="5" class="linhatopodiresq"><div align="center" class="fontebranca22bold">
      <div align="center">
        <table width="136" border="0" cellspacing="0" cellpadding="0">
          <tr>
<?
	if($grupo=="administrador"){
?>
            <td width="61"><div align="center">
				<a href="cadastro_cliente.php?novo=new">
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
      <td height="26" colspan="5" class="linhatopodiresq"><form action="listagem.php" method="post" enctype="multipart/form-data" name="form1">
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
    <td colspan="5" class="linhatopodiresq"><div align="center" class="fontebranca22bold">
      <div align="center">Registros no Sistema </div>
    </div></td>
  </tr>
  <tr>
    <td width="20" class="linhatopodiresq"><div align="center" class="fontebranca12">Cod. Cliente </div></td>
    <!--
    <td width="20" class="linhatopodir"><div align="center" class="fontebranca12">Cod. Filial </div></td>
    -->
    <td class="linhatopodir"><div align="center" class="fontebranca12">Raz&atilde;o Social </div></td>
    <td width="120" class="linhatopodir"><div align="center" class="fontebranca12">Contato  </div></td>
    <td width="100" class="linhatopodir"><div align="center" class="fontebranca12">Telefone</div></td>
    <td width="75" class="linhatopodir"><div align="center" class="fontebranca12">Exibir no Site</div></td>
  </tr>
<?php
if (!empty($query_clientes)){
    $result_clientes = pg_query($query_clientes);
    if(pg_num_rows($result_clientes) > 0){
	    while($row=pg_fetch_array($result_clientes)){
            echo "<tr>";

            echo "<td class='linhatopodiresq'><div align=center class='linksistema'><a href='cadastro_cliente.php?cliente_id={$row[cliente_id]}&filial_id={$row[filial_id]}'>";
            echo str_pad($row[cliente_id], 03, "0", STR_PAD_LEFT)."</a></div></td>";

            echo "<td class='linhatopodir'><div align=left class='linksistema'><a href='cadastro_cliente.php?cliente_id={$row[cliente_id]}&filial_id={$row[filial_id]}'>";
            echo $row[razao_social]."</a></div></td>";

            echo "<td class='linhatopodir'><div align=left class='linksistema'><a href='cadastro_cliente.php?cliente_id={$row[cliente_id]}&filial_id={$row[filial_id]}'>";
            echo $row[nome_contato_dir]."</a></div></td>";

            echo "<td class='linhatopodir'><div align=left class='linksistema'><a href='cadastro_cliente.php?cliente_id={$row[cliente_id]}&filial_id={$row[filial_id]}'>";
            echo $row[telefone]."</a></div></td>";

            echo "<td class='linhatopodir'><div align=left id='dcont".$row[cliente_id]."' class='linksistema'>";
            echo "<input type='checkbox' disabled id='showsite".$row[cliente_id]."' name='showsite".$row[cliente_id]."'";
            print $row[showsite] ? " checked " : "";
            echo " onclick=\"show_in_website('".$row[cliente_id]."');\"> <a href=\"javascript:show_in_website('".$row[cliente_id]."');\">Exibir</a></div></td>";

            echo "</tr>";
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
</tr>
</table>
</body>
</html>
