<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema SESMT - Tela de Verifia&ccedil;&atilde;o de Dados</title>
</head>

<body>
<form action="fatura.php" enctype="multipart/form-data" name="verifica" method="post">
<?php
include "sessao.php";
include "./config/connect.php";
include "./config/config.php";
include "./config/funcoes.php";

if($cod_cliente!='' && $cod_filial!='' || $razao_social!=''){

  if($razao_social!=''){
    $query="select cliente_id, filial_id, razao_social from cliente where razao_social like '%".$razao_social."%' ";
  }else{
  	$query="select cliente_id, filial_id, razao_social  from cliente where cliente_id=".$cod_cliente." and filial_id=".$cod_filial."";
  }
  
  $result=pg_query($query)or die("Erro na consulta: $query".pg_last_error($connect));
  echo "<table>";
  fecha();  
  while($row=pg_fetch_array($result)){
  echo "<tr>";
  echo "<td>";
  echo "<input type='radio' name='cliente_id' value='".$row['cliente_id']."'>";
  echo "<input type='hidden' name='filial_id' value='".$row['filial_id']."'>";
  
  echo "</td>";
  echo "<td>";
  echo "<b>Razão Social:</b> ".$row['razao_social']."";
  echo "-<b> Codigo Filial:</b> ".$row['filial_id']."";
  echo "</td>";
  echo "</tr>";
  }
 echo "<tr><td colspan=2><input type='submit' name='btn_submit' value='Gerar Fatura'></td></tr>";
  echo"</table>";
}

?>
</form>
</body>
</html>
