<?php 
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET){
	$funcionario = $_GET["funcionario"];
		  $setor = $_GET["setor"];
		$cliente = $_GET["cliente"];
	        $aso = $_GET["aso"];
} else {
	$funcionario = $_POST["funcionario"];
	      $setor = $_POST["setor"];
	    $cliente = $_POST["cliente"];
	        $aso = $_POST["aso"];
}

/*Parte que trata as sugestões que serão excluidas*/
if( !empty($_GET[exame]) )
{
	$exame = $_GET[exame];
	$query_excluir = $query_excluir . "DELETE FROM aso_exame WHERE cod_exame = $exame and cod_aso = $aso;";
	$result_excluir = pg_query($connect, $query_excluir)
		or die ("Erro na query: $query_excluir ==> " . pg_last_error($connect) );

	if ($result_excluir) {
		echo '<script> alert("O Exame foi EXCLUIDO com sucesso!");</script>';
	}
} 
/************ Fim da exclusão *************/
if(!empty($funcionario) and !empty($aso) and !empty($cliente) and $_POST[btn_gravar]=="Gravar"){
	if(isset($_POST["exame"])) // verifica se tem exames selecionados
	{
	$qua=0;
		foreach($_POST["exame"] as $exame) // recebe a lista de exames
		{
			$dt = explode("/", $_POST["data".$exame]);
			$data = $dt[2]."/".$dt[1]."/".$dt[0];

			$sql_verifica = "SELECT * FROM aso_exame WHERE cod_aso = $aso and cod_exame = $exame";
			
			$result_verifica = pg_query($connect, $sql_verifica)
				or die ("Erro na query: $sql_verifica ==> " . pg_last_error($connect) );

			if ( pg_num_rows($result_verifica)==0 ){
			// monta o insert no banco
			$query_aso_exame = $query_aso_exame . "INSERT INTO aso_exame(cod_aso, cod_exame, data)
												   VALUES 
												   ($aso, $exame, '$data');";
			}else{
				$sql_jatem = "SELECT especialidade FROM exame WHERE cod_exame = $exame";
				$result_jatem = pg_query($connect, $sql_jatem);
				$row_jatem = pg_fetch_array($result_jatem);
			 	echo '<script> alert("O exame $row_jatem[especialidade] já está cadastrada!");</script>';
			}
			$qua++;
		}
		$result_aso_exame = pg_query($connect, $query_aso_exame)
			or die ("Erro na query: $query_aso_exame ==> " . pg_last_error($connect) );

		if ($result_aso_exame) { // se os inserts foram corretos
			echo '<script> alert("Os dados foram cadastradas com sucesso!");</script>';
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Exame Complementar</title>
<script language="javascript" src="../scripts.js"></script>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<style type="text/css">

td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
.style1 {font-size: 14px}
.style2 {font-size: 12px}
.style3 {font-family: Arial, Helvetica, sans-serif}
.style4 {font-size: 12}
</style>
</head>

<body bgcolor="#006633">
<form action="exame_complementar.php" method="post" name="form1" class="fontebranca12">
	<?php
	$sql_exame = "SELECT ae.cod_aso, ae.data, e.especialidade, ae.cod_exame
				 FROM aso_exame ae, exame e, aso a
				 where ae.cod_exame = e.cod_exame
				 and ae.cod_aso = a.cod_aso
				 and ae.cod_aso = $aso
				 order by e.especialidade";

$result_exame = pg_query($connect, $sql_exame) 
	or die ("Erro na query: $sql_exame ==> ".pg_last_error($connect));

if(pg_num_rows($result_exame)>0){
	echo "	<tr>";
	echo "		<td colspan=2>";
	echo "			<table width=\"90%\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" align=\"center\">";
	echo "				<tr>";
	echo "					<th bgcolor=#009966>&nbsp;</th>";
	echo "					<th colspan=2 bgcolor=#009966 class=fontebranca12><h2>Exames já Cadastrados:</h2></th>";
	echo "				</tr>";
	$total = 0;
	while($row_exame = pg_fetch_array($result_exame))
	{
		echo "				<tr>";
		echo "					<th class=linksistema><a href=\"?aso=$aso&exame=$row_exame[cod_exame]&funcionario=$funcionario&setor=$setor&cliente=$cliente\"><u>Excluir</u></a></th>";
		echo "					<td class=fontebranca12>&nbsp;&nbsp; $row_exame[especialidade] </td>
								<td class=fontebranca12>&nbsp;&nbsp;".date("d/m/Y", strtotime($row_exame[data]))." </td>";
		echo "				</tr>";
		$exame_fora = $exame_fora . ", $row_exame[cod_exame]";
/***************************/
	}
	echo "			</table>";
	echo "		</td>";
	echo "	</tr>";
	echo "	<tr>";
	echo "		<th colspan=2>&nbsp;</th>";
	echo "	</tr>";
}//echo "aqui" . $row_exame;

	if (!empty($funcionario) and !empty($aso) and !empty($cliente) ) {

		$sql_tem_exame = "SELECT cod_exame, cod_aso FROM aso_exame WHERE cod_aso = $aso";

		$result_tem_exame = pg_query($connect, $sql_tem_exame)
				or die ("Erro na query: $sql_tem_exame ==> " . pg_last_error($connect) );

		if ( pg_num_rows($result_tem_exame)==0 ){ // se NÃO tiver nada cadastrado
			$query_exame = "SELECT cod_exame, especialidade FROM exame order by especialidade"; 
		}
		else{ // se tiver cadastrado
		
			while ( $exame_fora = pg_fetch_array($result_tem_exame) ){ // monta variável com valores que serão excluídos da consulta
				$row_fora = $row_fora . ", $exame_fora[cod_exame]";
			}
			$query_exame = "SELECT cod_exame, especialidade FROM exame where cod_exame not in (" . substr($row_fora,2,200) . ") order by especialidade"; /* como o primeiro caracter é vígula, pegar a partir do segundo para não dar erro na consulta*/
		}
		
		$result_exame = pg_query($connect, $query_exame) 
			or die ("Erro na query: $query_exame ==> ".pg_last_error($connect));

		echo "<table width=\"90%\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" align=\"center\">
			   <tr>
			 	<td colspan=2 bgcolor=\"#009966\" class=fontebranca12><center><h2>Exames Complementares</h2></center></td>
	 		  </tr><br>";
				
				while($row_exame=pg_fetch_array($result_exame)){ 
				echo "<tr>
				<td align=\"left\" class=\"fontebranca10 style1\">";
				echo "<input type=\"checkbox\" name=\"exame[]\" value=\"$row_exame[cod_exame]\">&nbsp;&nbsp;$row_exame[especialidade]";
				echo "</td><td>";
				echo "<input type=\"text\" name=\"data".$row_exame[cod_exame]."\" value=''>";
				echo "</td>";
				echo "</tr>";
				}
			echo "</table>";
	}	
	?><br />
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" align="center">
	<tr>
		<th>
			<input type="button"  name="finalizar" value="Finalizar" onClick="MM_goToURL('parent','../medico/lista_aso.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_gravar" value="Gravar" style="width:100;" >
			<input type="hidden" name="funcionario" value="<?php echo $funcionario; ?>" />
			<input type="hidden" name="cliente" value="<?php echo $cliente; ?>" />
			<input type="hidden" name="setor" value="<?php echo $setor; ?>" />
			<input type="hidden" name="aso" value="<?php echo $aso; ?>"/>
		</th>
	</tr>
</table>
</form>
</body>
</html>