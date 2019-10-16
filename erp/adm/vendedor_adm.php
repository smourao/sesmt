<?php
include "../sessao.php";
include "../config/connect.php";

$query="select * FROM funcionario ORDER BY funcionario_id";
$res = pg_query($connect, $query);
$fun = pg_fetch_all($res);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Controle de Vendedores</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<script language="javascript" src="../ajax.js"></script>
</head>
<body bgcolor="#006633" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="fontebranca12">
    <div align="center" class="fontebranca22bold">Painel de Controle do Sistema </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#FFFFFF" class="fontebranca12">
    <div align="center" class="fontepreta14bold">
    <font color="#000000">Controle de Vendedores</font>
    </div>
    </td>
  </tr>
  <tr>
    <td colspan="4" class="fontebranca12" align=center><br>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td class="fontebranca12" align=center>
        <input name="btn_voltar" type="button" id="btn_voltar" onClick="javascript:location.href='index.php'" value="&lt;&lt; Voltar">
 </td>
      </tr>
    </table>
      </td>
  </tr>
</table>   <br>
<table width="500" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td width="5" class="linhatopodiresq"><div align="center" class="fontebranca12">ID</div></td>
    <td width="300" class="linhatopodir"><div align="center" class="fontebranca12">Vendedor</div></td>
    <td width="10" class="linhatopodir"><div align="center" class="fontebranca12">Acessos</div></td>
    <td width="5" class="linhatopodir"><div align="center" class="fontebranca12">QTD. Clientes</div></td>
	<td width="100" class="linhatopodir"><div align="center" class="fontebranca12">Último Acesso</div></td>
  </tr>
<?PHP
  for($x=0;$x<pg_num_rows($res);$x++){
  $query="select DISTINCT(cc.funcionario_id), f.nome, count(cc.funcionario_id) as cliente
		from cliente_comercial cc, funcionario f 
		WHERE f.funcionario_id = cc.funcionario_id
		AND f.funcionario_id={$fun[$x][funcionario_id]}		
		GROUP BY cc.funcionario_id, f.nome";
	$ress = pg_query($connect, $query);
	$buffer = pg_fetch_array($ress);

  $pqp = "select count(usuario_id) from log where usuario_id = {$fun[$x][funcionario_id]}";
  $resul = pg_query($connect, $pqp);
  $row = pg_fetch_array($resul);  

  $pqp2 = "select data from log where usuario_id = {$fun[$x][funcionario_id]} ORDER BY data DESC";
  $resp = pg_query($connect, $pqp2);
  $r = pg_fetch_array($resp);

  echo '<tr>  
    <td align="center" class="fontebranca12">'.$fun[$x][funcionario_id].'&nbsp;</td>
	<td align="center" class="fontebranca12">'.$fun[$x][nome].'&nbsp;</td>
	<td align="center" class="fontebranca12">'.$row[count].'&nbsp;</td>
	<td align="center" class="fontebranca12">'.$buffer[cliente].'&nbsp;</td>
	<td align="center" class="fontebranca12">'.date("d/m/Y H:mm", strtotime($r[data])).'&nbsp;</td>
  </tr>';
  }
  ?>
</table>
</form>
</body>
</html>