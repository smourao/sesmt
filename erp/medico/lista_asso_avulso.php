<?php
session_start();
include "../sessao.php";
include "../config/connect.php";

$funcionario_id = $_SESSION[usuario_id];
$grupo_id = $_SESSION[grupo];
/*************************************************************************************************/
// --> ESCLUSÃO DE ASO
/*************************************************************************************************/
if($_GET[act] == "del"){
    if(!empty($_GET[id]) && is_numeric($_GET[id])){
        $sql = "DELETE FROM aso_avulso WHERE cod_aso = {$_GET[id]}";
        if(pg_query($sql)){
            echo "<script>alert('ASO excluído!');</script>";
        }else{
            echo "<script>alert('Erro ao excluir ASO!');</script>";
        }
    }
}

switch($grupo){ // "$grupo" é a variável global de sessão, criada no "auth.php"

	case "administrador":
	if($avulso=='' && $grupo_id != 'clinica')
	{
		$query_avulso = "select cod_aso, razao_social_cliente, nome_func 
						 from aso_avulso";
	}else
	{
		$query_avulso = "select cod_aso, razao_social_cliente, nome_func 
						 from aso_avulso 
						 where lower(razao_social_cliente) like '%".addslashes(strtolower($avulso))."%'
						 OR lower(nome_func) like '%".addslashes(strtolower($avulso))."%'";
	}
	$query_avulso.=" order by cod_aso DESC";
	break;

	case "funcionario":
	if($avulso=='' && $grupo_id != 'clinica')
	{
		$query_avulso = "select cod_aso, razao_social_cliente, nome_func
						 from aso_avulso";
	}else
	{
		$query_avulso = "select cod_aso, razao_social_cliente, nome_func
						 from aso_avulso 
						 where lower(razao_social_cliente) like '%".addslashes(strtolower($avulso))."%'
						 OR lower(nome_func) like '%".addslashes(strtolower($avulso))."%'";
	}
	$query_avulso.=" order by cod_aso DESC";
	break;
	
	case "clinica":
	if($avulso=='')
	{
		$query_avulso = "select cod_aso, razao_social_cliente, nome_func 
						 from aso_avulso 
						 where lower(razao_social_cliente) like '%".addslashes(strtolower($avulso))."%'
						 OR lower(nome_func) like '%".addslashes(strtolower($avulso))."%'
						 AND funcionario_id = $funcionario_id";
	}
	$query_avulso.="order by cod_aso DESC";
	break;
}
?>
<html>
<head>
<title>SESMT - ASO AVULSO</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
</head>

<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" text="#FFFFFF">
<p>
<center><h2> SESMT - Segurança do Trabalho </h2></center>
<p>&nbsp;</p>
<table width="750" border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="4"><br>TELA DE ASO AVULSO<br></th>
	</tr>
	   <tr>
	   <tr>
		<th colspan="4" bgcolor="#009966">
		<br>&nbsp;
		<input name="btn_novo" type="submit" id="btn_novo" onClick="MM_goToURL('parent','aso_avulso.php'); return document.MM_returnValue" value="Novo" style="width:100;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="btn1" type="submit" onClick="MM_goToURL('parent','../tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
		<br>&nbsp;
		</th>
		</tr>
    </tr>
  
    <tr>
      <td height="26" colspan="5" class="linhatopodiresq">
	  <form action="lista_aso_avulso.php" method="post" enctype="multipart/form-data" name="form1">
	  <br>
      <table width="400" border="0" align="center">
        <tr>
          <td width="10%"><strong>Razão Social:</strong></td>
          <td width="50%"><input name="avulso" type="text" size="30" style="background:#FFFFCC"></td>
          <td width="25%"><input type="submit" name="Submit" value="Pesquisar" style="width:100;">	</td>
        </tr>
      </table>
	 </form>	
	  </td>
    </tr>
  <tr>
    <th colspan="4" bgcolor="#009966" class="linhatopodiresq">
      <h3>Registros no Sistema - ASO AVULSO </h3>
    </th>
  </tr>
  <tr>
    <td bgcolor="#009966" width=50 class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Cód. ASO </strong></div></td>
    <td bgcolor="#009966" width=270 class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Nome do Cliente </strong></div></td>
	<td bgcolor="#009966" width=300 class="linhatopodiresq"><div align="center" class="fontebranca12"><strong>Nome do Funcionário </strong></div></td>
 	<td bgcolor="#009966" class="linhatopodiresq" align=center><div align="center" class="fontebranca12"><strong>Ações</strong></div></td>
 </tr>
<?php
if (!empty($query_avulso))
{

	$result_avulso=pg_query($query_avulso) 
		or die ("Erro na query: $query_avulso".pg_last_error($connect));

  if (pg_num_rows($result_avulso) > 0 )
  {
	  while($row=pg_fetch_array($result_avulso))
	  {
?>
  <tr>
    <td class="linhatopodiresq" align="center">
	  <div class="linksistema">
	   <a href="aso_avulso.php?cod_aso=<?php echo $row[cod_aso]?>"><?php echo $row[cod_aso]?></a>	  </div>	</td>
    <td class="linhatopodir" >
	  <div align="left" class="linksistema">
	  &nbsp;&nbsp;<a href="aso_avulso.php?cod_aso=<?php echo $row[cod_aso]?>"><?php echo $row[razao_social_cliente]?></a>	  </div>	</td>
    <td class="linhatopodir" >
	  <div align="left" class="linksistema">
	  &nbsp;&nbsp;<a href="aso_avulso.php?cod_aso=<?php echo $row[cod_aso]?>"><?php echo $row[nome_func]?></a>	  </div>	</td>
    <td class="linhatopodir" >
	  <div align="center" class="linksistema">
      <a href="aso_avulso_alterar.php?cod_aso=<?php echo $row[cod_aso]?>">Editar</a> |
      <a href="#" onClick="if(confirm('Tem certeza que deseja excluir este ASO?','')){location.href='?act=del&id=<?php echo $row[cod_aso]?>';}">Excluir</a></div></td>

  </tr>
<?php
  }
 }
}
  $fecha = pg_close($connect);
?>
  <tr>
    <th bgcolor="#009966" class="linhatopodiresqbase" colspan="4"><br>
	</tr>
</table>
<br>
</body>
</html>
