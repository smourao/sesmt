<?php
include "sessao.php";
include "./config/connect.php";
include "functions.php";

switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"

	case "administrador":
		if($razao==''){
             $query_razao = "select cc.* from cliente_comercial cc";
		}
		else
		{
		   if(is_numeric($razao)){
		      $query_razao = "select cc.* from cliente_comercial cc
              WHERE cc.cliente_id = '$razao'";
		   }else{
		      $query_razao = "select cc.* from cliente_comercial cc
              WHERE lower(cc.razao_social) like '%".strtolower(addslashes($razao))."%'
			  or lower(cc.nome_contato_dir) like '%".strtolower(addslashes($razao))."%'";
           }
		}
		$query_razao.=" order by cc.cliente_id";

	break;

	case "cliente":
	$query_razao.="where cliente_id=".$cliente_id."";
	break;

	case "funcionario":
	  if($_SESSION[usuario_id] == 30){
	  	if($razao==''){
             $query_razao = "select cc.* from cliente_comercial cc";
		}
		else
		{
		   if(is_numeric($razao)){
		      $query_razao = "select cc.* from cliente_comercial cc
              WHERE cc.cliente_id = '$razao'";
		   }else{
		      $query_razao = "select cc.* from cliente_comercial cc
              WHERE lower(cc.razao_social) like '%".strtolower(addslashes($razao))."%'
			  or lower(cc.nome_contato_dir) like '%".strtolower(addslashes($razao))."%'";
           }
		}
		$query_razao.=" order by cc.cliente_id";
	  
	  }else{  
		if($razao!=''){
           if(is_numeric($razao)){
		      $query_razao = "select cc.* from cliente_comercial cc
              WHERE cc.cliente_id = '$razao'";
		   }else{
			  $query_razao = "select cc.* from cliente_comercial cc
                             WHERE lower(cc.razao_social) like '%".strtolower(addslashes($razao))."%'
							or lower(cc.nome_contato_dir) like '%".strtolower(addslashes($razao))."%'";
           }
		}
	}
	break;

	case "vendedor":
	if ($razao==''){
		$query_razao = "select cc.* from cliente_comercial cc
                             WHERE cc.funcionario_id = '{$_SESSION['usuario_id']}'";
		}
	else
		{
		$query_razao = "select cc.* from cliente_comercial cc
                             WHERE
                             cc.funcionario_id = '{$_SESSION['usuario_id']}' AND
							(lower(cc.razao_social) like '%".strtolower(addslashes($razao))."%'
							or lower(cc.nome_contato_dir) like '%".strtolower(addslashes($razao))."%')";

		}
		$query_razao.=" order by cc.cliente_id";
	break;

	case "autonomo":
	if ($razao==''){
		$query_razao = "select cc.* from cliente_comercial cc
                             WHERE
                             cc.funcionario_id = '{$_SESSION['usuario_id']}'";
		}
	else
		{
		$query_razao = "select cc.* from cliente_comercial cc
                             WHERE
                             cc.funcionario_id = '{$_SESSION['usuario_id']}' AND
							(lower(cc.razao_social) like '%".strtolower(addslashes($razao))."%'
							or lower(cc.nome_contato_dir) like '%".strtolower(addslashes($razao))."%')";

		}
		$query_razao.=" order by cc.cliente_id";
	break;

	case "contador":
	$query_razao.=" where contador_id=".$contador_id."";
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
<br>
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td height="26" colspan="6" class="linhatopodiresq"><div align="center" class="fontebranca22bold">
      <div align="center">
        <table width="136" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="61"><div align="center">
				<a href="simulador_cadastro_cliente.php?var_novo=novo">
				  <img src="img/icone_listagem_r3_c2.jpg" width="38" height="26" border="0">
				</a></div>
			</td>
			<td width="75"><div align="center"><a href="tela_principal.php"><img src="img/icone_listagem_r2_c4.jpg" width="32" height="42" border="0"></a></div></td>
          </tr>
        </table>
        </div>
    </div></td>
  </tr>
    <tr>
      <td height="26" colspan="6" class="linhatopodiresq"><form action="simulador_listagem.php" method="post" enctype="multipart/form-data" name="form1">
      <table width="75%" border="0" align="center">
        <tr>
          <td width="24%" align="right"><font color="#FFFFFF" size="-1" face="Arial, Helvetica, sans-serif">Raz&atilde;o</font></td>
          <td width="47%"><input name="razao" type="text" size="30"></td>
          <td width="29%"><input type="submit" name="Submit" value="Pesquisar"></td>
        </tr>
      </table>
      </form></td>
    </tr>
  <tr>
    <td colspan="6" class="linhatopodiresq"><div align="center" class="fontebranca22bold">
      <div align="center">Registros no Sistema Simulador</div>
    </div></td>
  </tr>
  <tr>
    <td width="45" class="linhatopodiresq"><div align="center" class="fontebranca12">Cod.</div></td>
    <td width="260" class="linhatopodiresq"><div align="center" class="fontebranca12">Razão Social </div></td>
    <td width="140" class="linhatopodiresq"><div align="center" class="fontebranca12">Contato  </div></td>
    <td width="70" class="linhatopodiresq"><div align="center" class="fontebranca12">Vendedor </div></td>
	<td width="100" class="linhatopodiresq"><div align="center" class="fontebranca12">Telefone</div></td>
    <td width="85" class="linhatopodiresq"><div align="center" class="fontebranca12">Status de Orçamento</div></td>
  </tr>
<?php
if (!empty($query_razao)){
	$result_razao = pg_query($query_razao) or die
		("erro na query!" .pg_last_error($connect));

	while($row=pg_fetch_array($result_razao)){
	
	if($row[data_envio] != ""){
	   $dias = dateDiff(str_replace("/", "-", $row[data_envio]), date("d-m-Y"));
	   if($dias <0){$dias = $dias * -1;}
	}

?>
    <td class="linhatopodiresq"><div align="center" class="linksistema"><a href="simulador_cadastro_cliente.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&funcionario_id=<?php echo $row[funcionario_id]?>">&nbsp;<?php echo $row[cliente_id]?>
	</a></div></td>
    <td class="linhatopodiresq"><div align="left" class="linksistema"><a href="simulador_cadastro_cliente.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&funcionario_id=<?php echo $row[funcionario_id]?>">&nbsp;<?php echo convertwords($row[razao_social]);?>
	</a></div></td>
    <td class="linhatopodiresq"><div align="center" class="linksistema"><a href="simulador_cadastro_cliente.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&funcionario_id=<?php echo $row[funcionario_id]?>">&nbsp;<?php echo $row[nome_contato_dir]?>
    </a></div></td>
	<td class="linhatopodiresq"><div align="center" class="linksistema"><a href="simulador_cadastro_cliente.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&funcionario_id=<?php echo $row[funcionario_id]?>">&nbsp;<?php echo $row[funcionario_id]?>
    </a></div></td>
    <td class="linhatopodiresq"><div align="center" class="linksistema"><a href="simulador_cadastro_cliente.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&funcionario_id=<?php echo $row[funcionario_id]?>">&nbsp;<?php echo $row[telefone]?></a>
    &nbsp;</div></td>
   <td class="linhatopodiresq"><div align="center" class="linksistema"><a href="orcamento.php?cod_orcamento=<?php echo $row[cod_orcamento]?>&cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&funcionario_id=<?php echo $row[funcionario_id]?>">&nbsp;<?php print $row[data_envio] != "" ? "Enviado à ".$dias." dias" : "";//echo $row[data_envio]?></a>
    &nbsp;</div></td>
  </tr>
<?php
	}
}
  $fecha = pg_close($connect);
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
<table align="center" width="90%" border="0" cellspacing="0" cellpadding="0">
  <tr>
	<td width="75"><div align="center"><a href="tela_principal.php"><img src="img/icone_listagem_r2_c4.jpg" width="32" height="42" border="0"></a></div></td>
  </tr>
</table><br>
</body>
</html>
