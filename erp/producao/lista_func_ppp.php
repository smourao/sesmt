<?php
include "../sessao.php";
include "../config/connect.php";

$cliente = $_GET["cliente"];

if($_GET[cliente] != '' && !$_POST){
	 $query_razao = "select nome_func, cod_func, cod_cliente, cod_setor
	 				from funcionarios
					WHERE cod_cliente = $cliente";
}
else
{
   if(is_numeric($_POST[pesq])){
	  $query_razao = "select nome_func, cod_func, cod_cliente, cod_setor
					  from funcionarios
					  WHERE cod_cliente = $_POST[pesq]";
   }else{
	  $query_razao = "select f.nome_func, f.cod_func, f.cod_cliente, f.cod_setor
					  from funcionarios f, cliente c
					  WHERE f.cod_cliente = c.cliente_id
					  AND lower(razao_social) like '%".strtolower(addslashes($pesq))."%'";
   }
}
$query_razao.=" order by cod_func";

?>
<html>
<head>
<title> ..:: SESMT ::.. </title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form action="lista_func_ppp.php" method="post" enctype="multipart/form-data" name="form1"><br>
<table width="760" border="1" align="center" cellpadding="0" cellspacing="0">
	<tr>
	  <td width="130" class="fontebranca12" align="right">Razão ou Cód.</td>
	  <td width="130"><input name="pesq" type="text" size="30"></td>
	  <td width="130"><input type="submit" name="Submit" value="Pesquisar"></td>
	  <td width="130"><input name="btn1" type="button" onClick="MM_goToURL('parent', 'lista_ppra.php'); return document.ReturnValue" value="Sair" style="width:100;"></td>
	</tr>
  <tr>
    <td colspan="4" class="fontebranca22bold" align="center">Lista dos Funcionários</td>
  </tr>
  <tr>
    <td width="130" class="linhatopodiresq"><div align="center" class="fontebranca12">Código</div></td>
    <td colspan="3" width="260" class="linhatopodiresq"><div align="center" class="fontebranca12">Nome dos Funcionários</div></td>
    <!--td width="140" class="linhatopodiresq"><div align="center" class="fontebranca12">Contato  </div></td>
    <td width="70" class="linhatopodiresq"><div align="center" class="fontebranca12">Vendedor </div></td>
	<td width="100" class="linhatopodiresq"><div align="center" class="fontebranca12">Telefone</div></td>
    <td width="85" class="linhatopodiresq"><div align="center" class="fontebranca12">Status de Orçamento</div></td-->
  </tr>
<?php
if (!empty($query_razao)){
	$result_razao = pg_query($query_razao) or die
		("erro na query!" .pg_last_error($connect));

	while($row=pg_fetch_array($result_razao)){
	
	/*if($row[data_envio] != ""){
	   $dias = dateDiff(str_replace("/", "-", $row[data_envio]), date("d-m-Y"));
	   if($dias <0){$dias = $dias * -1;}
	}*/

?>
  <tr>
    <td class="linhatopodiresq"><div align="center" class="linksistema"><a href="ppp_relatorio.php?cliente=<?php echo $row[cod_cliente]?>&setor=<?php echo $row[cod_setor]?>&funcionario=<?php echo $row[cod_func]?>">&nbsp;<?php echo $row[cod_func]?>
	</a></div></td>
    <td colspan="3" class="linhatopodiresq"><div align="left" class="linksistema"><a href="ppp_relatorio.php?cliente=<?php echo $row[cod_cliente]?>&setor=<?php echo $row[cod_setor]?>&funcionario=<?php echo $row[cod_func]?>">&nbsp;<?php echo $row[nome_func];?>
	</a></div></td>
    <!--td class="linhatopodiresq"><div align="center" class="linksistema"><a href="simulador_cadastro_cliente.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&funcionario_id=<?php echo $row[funcionario_id]?>">&nbsp;<?php echo $row[nome_contato_dir]?>
    </a></div></td>
	<td class="linhatopodiresq"><div align="center" class="linksistema"><a href="simulador_cadastro_cliente.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&funcionario_id=<?php echo $row[funcionario_id]?>">&nbsp;<?php echo $row[funcionario_id]?>
    </a></div></td>
    <td class="linhatopodiresq"><div align="center" class="linksistema"><a href="simulador_cadastro_cliente.php?cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&funcionario_id=<?php echo $row[funcionario_id]?>">&nbsp;<?php echo $row[telefone]?></a>
    &nbsp;</div></td>
   <td class="linhatopodiresq"><div align="center" class="linksistema"><a href="orcamento.php?cod_orcamento=<?php echo $row[cod_orcamento]?>&cliente_id=<?php echo $row[cliente_id]?>&filial_id=<?php echo $row[filial_id]?>&funcionario_id=<?php echo $row[funcionario_id]?>">&nbsp;<?php print $row[data_envio] != "" ? "Enviado à ".$dias." dias" : "";//echo $row[data_envio]?></a>
    &nbsp;</div></td-->
  </tr>
<?php
	}
}
  $fecha = pg_close($connect);
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td colspan="3" bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <!--td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td-->
  </tr>
</table><br>
</form>
</body>
</html>