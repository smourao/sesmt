<?PHP
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

$func = $_POST['f'];
$risco = $_POST['risco'];

   if($func >= 50 && $func <=100){
      $table = 1;
   }elseif($func >= 101 && $func <=250){
      $table = 2;
   }elseif($func >= 251 && $func <=500){
      $table = 3;
   }elseif($func >= 501 && $func <=1000){
      $table = 4;
   }elseif($func >= 1001 && $func <=2000){
      $table = 5;
   }elseif($func >= 2001 && $func <=3500){
      $table = 6;
   }elseif($func >= 3501 && $func <=5000){
      $table = 7;
   }elseif($func > 5000){
      $table = 8;
   }else{
   
   }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Dimensionamento do SESMT</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
<body bgcolor="#006633">
<form action="cons_risco.php" method="post">
<table align="center" border="0">
<tr>
<td align="center" class="fontebranca22bold">Dimensionamento do SESMT</td>
</tr>
</table><br />

<table align="center" width="500" border="1" bordercolor="#FFFFFF">
	<tr>
		<td align="right" width="50%" class="fontebranca12">Nº de Colaboradores:&nbsp;</td>
		<td width="50%">&nbsp;<input type="text" name="f" size="5"  ></td>
	</tr>
	<tr>
		<td align="right" width="50%" class="fontebranca12">Grau de Risco:&nbsp;</td>
		<td width="50%">&nbsp;<input type="text" name="risco" size="5" ></td>
	</tr>
	<tr>
		<th><input type="submit" value="Buscar" name="btn_enviar"></th>
		<th><input type="button" value="<< Voltar" name="btn_voltar" onClick="MM_goToURL('parent','../adm/index.php');return document.MM_returnValue" style="width:100;"></th>
	</tr>
</table>
<?php
if($risco != ""){
	$sql = "SELECT * FROM cons_dim WHERE risco=".$risco;
	$result = pg_query($connect, $sql);
	$row = pg_fetch_all($result);
echo "<br><table align=\"center\" width=\"500\" border=\"0\" cellpadding=\"1\" cellspacing=\"1\">";
	for($x=0;$x<pg_num_rows($result);$x++){
	   $t = "fun".$table;
		echo "<tr>
			<td width=\"50%\" class=\"fontebranca12\" bgcolor=\"#009966\">";
	   if($row[$x][$t]!=""){
		  echo $row[$x]['tecnicas']."</td>
		  	<td width=\"50%\" class=\"fontebranca12\" bgcolor=\"#009966\">".$row[$x][$t]."</td>";
	   }else{
		  echo $row[$x]['tecnicas']."</td>
		  	<td width=\"50%\" class=\"fontebranca12\" bgcolor=\"#009966\"> Não necessário.</td>";
	   }
echo "</td></tr>";
	}
echo "</table>";

echo "<br><table align=\"center\" width=\"90%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
		<tr>
			<td class=\"fontebranca12\">(*) Tempo parcial (mínimo de três horas).<br>&nbsp;</td>
		</tr>
		<tr>
			<td class=\"fontebranca12\">(**) O dimensionamento total deverá ser feito levando-se em consideração o dimensionamento de faixas de 3501 a 5000 mais o dimensionamento do(s) grupo(s) de 4000 ou fração acima de 2000.<br>&nbsp;</td>
		</tr>
		<tr>
			<td class=\"fontebranca12\">OBS: Hospitais, Ambulatórios, Maternidade, Casas de Saúde e Repouso, Clínicas e estabelecimentos similares com mais de 500 (quinhentos) empregados deverão contratar um Enfermeiro em tempo integral.</td>
		</tr>
	</table>";
}
?>
</form>
</body>
</head>