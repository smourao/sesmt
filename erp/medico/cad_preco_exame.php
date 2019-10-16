<?php 
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

$data = date("Y/m/d");

if($_GET){
	$cod_clinica = $_GET['cod_clinica'];
} else {
	$cod_clinica = $_POST['cod_clinica'];
}

/*Parte que trata os exames que serão excluidos*/
if( !empty($_GET[exame]) )
{
	$exame = $_GET[exame];

	$query_excluir = $query_excluir . "DELETE FROM clinica_exame WHERE cod_exame = $exame and cod_clinica = $cod_clinica;";
	
	$result_excluir = pg_query($connect, $query_excluir)
		or die ("Erro na query: $query_excluir ==> " . pg_last_error($connect) );

	if ($result_excluir) {
		echo '<script> alert("O Exame foi EXCLUIDO com sucesso!");</script>';
	}
} 
/************ Fim da exclusão *************/

if(!empty($cod_clinica) and $_POST[btn_gravar]=="Gravar"){
	if(isset($_POST["exame"])) // verifica se tem exames selecionados
	{
	$z = count($_POST['exame']);
		//foreach($_POST["exame"] as $exame) // recebe a lista de exames
		for($x=0;$x<$z-1;$x++) {
		if( empty($_POST["preco_exame"][$x]) ){
			$preco_exame = 0;
		}else{
			$preco_exame = str_replace(".","",$_POST["preco_exame"][$x]);
			$preco_exame = str_replace(",",".",$preco_exame);
		}
		$exame = $_POST['exame'][$x];
		//$preco = $_POST['preco_exame'][$x];
		//echo $x."->".$exame."<br>";
			$sql_verifica = "SELECT * FROM clinica_exame WHERE cod_clinica = $cod_clinica and cod_exame = $exame";
			$result_verifica = pg_query($connect, $sql_verifica)
				or die ("Erro na query: $sql_verifica ==> " . pg_last_error($connect) );
            $n = pg_num_rows($result_verifica);
            if($n==0 && $preco_exame!="" && $exame!=""){
			$query_exame = "INSERT INTO clinica_exame(cod_clinica, cod_exame, preco_exame, data)
							VALUES 
							($cod_clinica, $exame, $preco_exame, '$data');";
										   
            $result_exame = pg_query($connect, $query_exame)
               or die ("Erro na query: $query_exame ==> " . pg_last_error($connect) );

			}
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
<form action="cad_preco_exame.php" method="post" name="form1" class="fontebranca12">
	<?php
	$sql_exame = "SELECT DISTINCT ce.cod_clinica, ce.cod_exame, e.especialidade, ce.preco_exame
				 FROM clinica_exame ce, exame e, clinicas c
				 where ce.cod_exame = e.cod_exame
				 and ce.cod_clinica = c.cod_clinica
				 and ce.cod_clinica = $cod_clinica";

$result_exame = pg_query($connect, $sql_exame) 
	or die ("Erro na query: $sql_exame ==> ".pg_last_error($connect));

if(pg_num_rows($result_exame)>0){
	echo "	<tr>";
	echo "		<td colspan=2>";
	echo "			<table width=\"90%\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" align=\"center\">";
	echo "				<tr>";
	echo "					<th>&nbsp;</th>";
	echo "					<th>Exames já Cadastrados:</th>";
	echo "					<th>&nbsp;</th>";
	echo "				</tr>";
	$total = 0;
	while($row_exame = pg_fetch_array($result_exame))
	{
		echo "				<tr>";
		echo "					<th class=linksistema><a href=\"../medico/cad_preco_exame.php?cod_clinica=$cod_clinica&exame=$row_exame[cod_exame]\"><u>Excluir</u></a></th>";
		echo "					<td class=\"fontebranca10 style1\">&nbsp;&nbsp;&nbsp;&nbsp; $row_exame[especialidade]&nbsp;&nbsp;</td>";
echo "					        <td class=\"fontebranca10 style1\">R$ ".number_format($row_exame[preco_exame], 2, ',', '.')."</td>";
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

	if (!empty($cod_clinica) ) {

		$sql_tem_exame = "SELECT cod_exame, cod_clinica FROM clinica_exame WHERE cod_clinica = $cod_clinica";

		$result_tem_exame = pg_query($connect, $sql_tem_exame)
				or die ("Erro na query: $sql_tem_exame ==> " . pg_last_error($connect) );

		if ( pg_num_rows($result_tem_exame)==0 ){ // se NÃO tiver nada cadastrado
			$query_exame = "SELECT cod_exame, especialidade FROM exame"; 
		}
		else{ // se tiver cadastrado
		
			while ( $exame_fora = pg_fetch_array($result_tem_exame) ){ // monta variável com valores que serão excluídos da consulta
				$row_fora = $row_fora . ", $exame_fora[cod_exame]";
			}

			$query_exame = "SELECT cod_exame, especialidade FROM exame where cod_exame not in (" . substr($row_fora,2,200) . ")"; /* como o primeiro caracter é vígula, pegar a partir do segundo para não dar erro na consulta*/

		}
		
		$result_exame = pg_query($connect, $query_exame) 
			or die ("Erro na query: $query_exame ==> ".pg_last_error($connect));

		echo "<table width=\"90%\" border=\"1\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#FFFFFF\" align=\"center\">
			   <tr>
			 	<td bgcolor=\"#009966\" colspan=\"2\"><center><h2 class=\"style3\" >Cadastro de Preços dos Exames</h2></center></td>
	 		  </tr><br>";
			    //onKeyPress=\"return(FormataReais(this, '.', ',', event));\"
				while($row_exame=pg_fetch_array($result_exame)){ 
				echo "<tr>
						<td width=\"50%\" align=\"left\" class=\"fontebranca10 style1\">
							<input type=\"hidden\" name=\"exame[]\" value=\"$row_exame[cod_exame]\">&nbsp; $row_exame[especialidade]
						</td>
						<td width=\"50%\" align=\"left\" class=\"fontebranca10 style1\">
							R$&nbsp;<input type=\"text\" name=\"preco_exame[]\" size='18' onkeypress=\"return(moeda(this, event));\" ><br>
						</td>
					</tr>";
				}				
			echo " </table>";
	}	
	?><br />
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000" align="center">
	<tr>
		<th>
			<input type="button"  name="finalizar" value="Sair" onClick="MM_goToURL('parent','../medico/lista_clinicas.php');return document.MM_returnValue" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_gravar" value="Gravar" style="width:100;" >
			<input type="hidden" name="cod_clinica" value="<?php echo $cod_clinica; ?>" />
			<input type="hidden" name="exame[]" value="<?php echo $exame; ?>" />
		</th>
	</tr>
</table>
</form>
</body>
</html>
