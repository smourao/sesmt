<?php 
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if(empty($_POST[dat])){
	$data = date("Y/m/d");
}else{
	$dt = explode("/", $_POST[dat]);
	$data = $dt[2]."/".$dt[1]."/".$dt[0];
}
$hora = date("H:i:s");

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

function coloca_zeros($numero){
echo str_pad($numero, 4, "0", STR_PAD_LEFT);
}

/******************** DADOS DO FUNCIONÁRIO **********************/
if (!empty($funcionario) and !empty($cliente) and !empty($setor)){
    /*
    $query_func = "SELECT cod_func, nome_func, num_ctps_func, serie_ctps_func, cbo, dinamica_funcao, f.cod_cliente, f.cod_setor, c.filial_id
					  FROM funcionarios f, cliente c, cliente_setor cs 
					  WHERE c.cliente_id = cs.cod_cliente
					  and f.cod_cliente = cs.cod_cliente
					  and f.cod_func = $funcionario
					  and f.cod_cliente = $cliente
					  and f.cod_setor = $setor";
	*/
	$query_func = "SELECT *
					  FROM funcionarios
					  WHERE cod_func = $funcionario
					  and cod_cliente = $cliente
					  and cod_setor = $setor";
					  
	$result_func = pg_query($query_func);
	$row_func = pg_fetch_array($result_func);
}

if(($cod_aso!="") and $_POST[btn_gravar] == "Gravar") {
    $query_insert = "INSERT INTO aso(cod_aso, cod_cliente, cod_setor, aso_data, cod_func, aso_resultado, aso_hora, risco_id, classificacao_atividade_id, tipo_exame, obs)
					 VALUES ($cod_aso, $cliente, $setor, '$data', $funcionario, '$aso_resultado', '$hora', $risco_id, $classificacao_atividade_id, '$tipo_exame', '$obs')";

	$result_insert = pg_query($connect, $query_insert) 
		or die ("Erro na query: $query_insert ==>".pg_last_error($connect));
		
	if ($result_insert) { // se os inserts foram corretos
			echo '<script> alert("Os dados foram cadastradas com sucesso!");
			location.href="editar_aso.php?funcionario='.$funcionario.'&setor='.$setor.'&cliente='.$cliente.'&aso='.$cod_aso.'";
			</script>';
	}
}	
if($_POST[btn_outros]=="Escolha os Exames"){
				header("location: http://www.sesmt-rio.com/erp/medico/exame_complementar.php?funcionario=$funcionario&setor=$setor&cliente=$cliente&aso=$cod_aso");
}
if($_GET[aso]){
    $risco = "SELECT * FROM aso WHERE funcionario = $_GET[funcionario] and aso = $_GET[aso] and cliente = $_GET[cliente]";
    $ris = pg_query($risco);
    $row_ris = pg_fetch_array($ris);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Gerar ASO</title>
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
<body bgcolor="#006633">&nbsp;
<form action="gerar_aso.php" name="frm_aso" method="post">
<div align="center" class="fontebranca22bold">
<table width="90%" border="0" cellpadding="0" cellspacing="0" >
	<tr>
	<td align="center" class="fontebranca22bold" bgcolor="#009966"><h2>Gerar ASO</h2></td>
	</tr>
</table><br /></div>
<div align="center">
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<?php
			if(empty($cod_aso)){
				$query_max = "SELECT max(cod_aso) as cod_aso FROM aso";
				
				$result_max = pg_query($query_max) or die
						("Erro na busca da tabela !" . pg_last_error($connect));
				
				$row_max = pg_fetch_array($result_max);
				
				$cod_aso = $row_max[cod_aso] + 1;
			}
			else if(!empty($cod_aso)){
				$cod_aso = $cod_aso;
			}
		?>
	<tr>
		<td width="20%" class="fontebranca10 style2" align="left">Cod. ASO</td>
		<td width="20%" class="fontebranca10 style2" align="left">Cod. Cliente</td>
		<td width="20%" class="fontebranca10 style2" align="left">Cod. Setor</td>
		<td width="20%" class="fontebranca10 style2" align="left">Data</td>
		<td width="20%" class="fontebranca10 style2" align="left">Hora</td>
	</tr>
	<tr>
		<td class="fontepreta10" align="left"><input type="text" name="cod_aso" size="10" value="<?php if(empty($funcionario)) {coloca_zeros($row_max[cod_aso]);} else {echo coloca_zeros($cod_aso);}?>" readonly="true"></td>
		<td class="fontebranca12" align="left"><?php if($row_func[cod_cliente]) {coloca_zeros($row_func[cod_cliente]);}?></td>
		<td class="fontebranca12" align="left"><?php if($row_func[cod_setor]) {coloca_zeros($row_func[cod_setor]);}?></td>
		<td class="fontebranca12" align="left"><input type="text" name="dat" size="10" value="<?php if($row_func[dat]){echo date("d/m/Y",strtotime($row_func[dat]));}else{echo date("d/m/Y",strtotime($data));} ?>" /></td>
		<td class="fontebranca12" align="left"><?php echo $hora; ?></td>
	</tr>
</table></div><br />
<div align="center">
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="70%" class="fontebranca10 style2" align="left">Colaborador</td>
		<td width="15%" class="fontebranca10 style2" align="left">CTPS</td>
		<td width="15%" class="fontebranca10 style2" align="left">Série</td>
	</tr>
	<tr>
		<td class="fontepreta10" align="left"><input type="text" name="funcionario" value="<?php echo $row_func[nome_func]?>" size="50">
		<td class="fontepreta10" align="left"><input type="text" name="num_ctps_func" value="<?php echo $row_func[num_ctps_func]?>" size="15" /></td>
		<td class="fontepreta10" align="left"><input type="text" name="serie_ctps_func" value="<?php echo $row_func[serie_ctps_func]?>" size="15" /></td>
	</tr>
</table></div><br />
<div align="center">
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="30%" class="fontebranca10 style2" align="left">CBO</td>
		<td width="30%" class="fontebranca10 style2" align="left">Dinâmica da Função</td>
	</tr>
	<tr>
		<td class="fontepreta10" align="left"><input type="text" name="cbo" value="<?php echo $row_func[cbo]?>" size="15" /></td>
		<td class="fontepreta10" align="left"><input type="text" name="dinamica_funcao" value="<?php echo $row_func[dinamica_funcao]?>" size="60" /></td>
	</tr>
	
</table></div><br />
<div align="center">
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td width="30%" class="fontebranca12" align="left">Classificação da Atividade:</td>
		<td width="20%" class="fontebranca12" align="left">Nível de Tolerância:</td>
		<td width="25%" class="fontebranca12" align="left">Tipo de Exame:</td>
		<td width="25%" class="fontebranca12" align="left">Resultado:</td>
	</tr>
	<tr>
		<td align="left">
        <select name="classificacao_atividade_id">
		<?php
			$query_ativ="SELECT * FROM classificacao_atividade";
			$result_ativ=pg_query($query_ativ);
			while($row_ativ=pg_fetch_array($result_ativ)){
				if($row_ris[classificacao_atividade_id]<>$row_ativ[classificacao_atividade_id]){
					echo "<option value='$row_ativ[classificacao_atividade_id]'>" . $row_ativ[nome_atividade] . "</option>";
				}else{
					echo "<option value='$row_ativ[classificacao_atividade_id]' selected>" . $row_ativ[nome_atividade] . "</option>";
				}
			}
			?>
			</select>
		</td>		
		<td class="fontepreta12" align="left"><select name="risco_id">
			<?php
				$query_clas="select risco_id, nome, descricao from risco_cliente";
				$result_clas=pg_query($query_clas) or die("Erro na query: $query_clas".pg_last_error($connect));
				while($row_clas=pg_fetch_array($result_clas)){
					if($row_ris[risco_id]<>$row_clas[risco_id]){
						echo "<option value=\"$row_clas[risco_id]\">" . $row_clas[nome] . "</option>";
					}else{
						echo "<option value=\"$row_clas[risco_id]\" selected>" . $row_clas[nome] . "</option>";
					} 
				}
				?>
			</select>
		</td>
		<td class="fontepreta12" align="left"><select name="tipo_exame" id="tipo_exame">
				<option value="Admissional" <?php if($row[tipo_exame]=="Admissional"){echo "selected";} ?>>Admissional</option>
				<option value="Periódico" <?php if($row[tipo_exame]=="Periodico"){echo "selected";} ?>>Periódico</option>
				<option value="Mudanca de Funcao" <?php if($row[tipo_exame]=="Mudanca de Funcao"){echo "selected";} ?>>Mudança de Função</option>
				<option value="Retorno ao Trabalho" <?php if($row[tipo_exame]=="Retorno ao Trabalho"){echo "selected";} ?>>Retorno Trabalho</option>
				<option value="Demissional" <?php if($row[tipo_exame]=="Demissional"){echo "selected";} ?>>Demissional</option>
				</select>
		</td>
		<td class="fontepreta12" align="left"><select name="aso_resultado" id="aso_resultado" onchange="apto(this.value);">
		        <option value="" <?php if($row[aso_resultado]==""){echo "selected";} ?>></option>
				<option value="__________" <?php if($row[aso_resultado]=="__________"){echo "selected";} ?>>__________</option>
				<option value="Apto" <?php if($row[aso_resultado]=="Apto"){echo "selected";} ?>>Apto</option>
				<option value="Apto à manipular alimentos" <?php if($row[aso_resultado]=="Apto à manipular alimentos"){echo "selected";} ?>>Apto à manipular alimentos</option>
				<option value="Apto para trabalhar em altura" <?php if($row[aso_resultado]=="Apto para trabalhar em altura"){echo "selected";} ?>>Apto para trabalhar em altura</option>
				<option value="Apto para operar empilhadeira" <?php if($row[aso_resultado]=="Apto para operar empilhadeira"){echo "selected";} ?>>Apto para operar empilhadeira</option>
				<option value="Apto para trabalhar em espaço confinado" <?php if($row[aso_resultado]=="Apto para trabalhar em espaço confinado"){echo "selected";} ?>>Apto para trabalhar em espaço confinado</option>
				<option value="Inapto" <?php if($row[aso_resultado]=="Inapto"){echo "selected";} ?>>Inapto</option>
				<option value="Apto com Restrição" <?php if($row[aso_resultado]=="Apto com Restrição"){echo "selected";} ?>>Apto com Restrição</option>
				</select>
		</td>
	</tr>
</table></div><br />
<div align="center" style="display:none;" id="ds">
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" class="fontepreta12"><textarea cols="110" rows="2" name="obs"><?php echo "OBS:{$row[obs]}"; ?></textarea></td>
	</tr>
</table>
</div>
<div align="center">
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td width="20%" class="fontebranca12" align="left">&nbsp;&nbsp;Riscos da Função:</td>
			<td width="30%" class="fontebranca12" align="left">&nbsp;&nbsp;Especificar Riscos da Função:</td>
			<td width="50%" class="fontebranca12" align="left">&nbsp;&nbsp;Exames Complementares:</td>
		</tr>
		<tr>
		<?php /*Seleção do Tipo de Risco.*/
			if( !empty($cliente) and !empty($setor) ){
			$query_risco="SELECT Distinct(nome_tipo_risco)
						  FROM tipo_risco tr, risco_setor rs, agente_risco ar, cliente c, setor s
						  WHERE ar.cod_agente_risco = rs.cod_agente_risco
						  AND ar.cod_tipo_risco = tr.cod_tipo_risco
						  AND c.cliente_id = rs.cod_cliente
						  AND s.cod_setor = rs.cod_setor 
						  AND rs.cod_setor = $setor
						  AND rs.cod_cliente = $cliente order by nome_tipo_risco";
						  
			$result_risco=pg_query($query_risco) 
			or die("Erro na query: $query_risco".pg_last_error($connect));
			
			echo "	<td align=\"left\" class=\"fontebranca10 style1\">";
			
				while($row_risco=pg_fetch_array($result_risco)){ 
			echo "<input type=\"checkbox\" name\"cod_tipo_risco\" value=\"$row_risco[cod_tipo_risco]\" checked >&nbsp; $row_risco[nome_tipo_risco] <br> ";
				}
			echo "	</td>";
			}
		?> <!-- Fim da Seleção -->
		
		<?php /*Resultado da Seleção de Agente de Risco.*/
			if( !empty($cliente) and !empty($setor) ){
			$query_agente="SELECT Distinct(nome_agente_risco)
						   FROM tipo_risco tr, risco_setor rs, agente_risco ar, cliente c, setor s
						   WHERE ar.cod_agente_risco = rs.cod_agente_risco
						   AND ar.cod_tipo_risco = tr.cod_tipo_risco
						   AND c.cliente_id = rs.cod_cliente
						   AND s.cod_setor = rs.cod_setor 
						   AND rs.cod_setor = $setor
						   AND rs.cod_cliente = $cliente order by nome_agente_risco";
						  
			$result_agente=pg_query($query_agente) 
			or die("Erro na query: $query_agente".pg_last_error($connect));

			echo "	<td align=\"left\" class=\"fontebranca10 style1\">";

				while($row_agente=pg_fetch_array($result_agente)){ 
			echo "<input type=\"checkbox\" name\"cod_agente_risco\" value=\"$row_agente[cod_agente_risco]\" readonly=true checked >&nbsp; $row_agente[nome_agente_risco] <br>";
				}
			echo "	</td>";
			}
		?> <!-- Fim da Seleção -->
		
		<?php /*Resultado da Seleção de Exames.*/
			if( !empty($aso) ){
			$query_exame="SELECT e.especialidade
						   FROM aso_exame ae, aso a, exame e, cliente c
						   WHERE ae.cod_exame = e.cod_exame
						   AND a.cod_cliente = c.cliente_id
						   AND ae.cod_aso = a.cod_aso
						   AND ae.cod_aso = $aso";
						  
			$result_exame=pg_query($query_exame) 
			or die("Erro na query: $query_exame".pg_last_error($connect));

			echo "	<td align=\"left\" class=\"fontebranca10 style1\">";

				while($row_exame=pg_fetch_array($result_exame)){ 
			          echo "	&nbsp;&nbsp;<input type=\"checkbox\" name\"cod_exame\" value=\"$row_exame[cod_exame]\" checked >&nbsp; $row_exame[especialidade] <br>";
				}
			echo "	</td>";
			}
		?> <!-- Fim da Seleção de Exames. -->
			<td align="left">
				<input type="submit" value="Escolha os Exames" name="btn_outros" style="width:150;">
				<input type="hidden" name="funcionario" value="<?php echo $funcionario; ?>" />
				<input type="hidden" name="cliente" value="<?php echo $cliente; ?>" />
				<input type="hidden" name="setor" value="<?php echo $setor; ?>" />
			</td>
		</tr>
		<tr>
			<td width="20%" class="fontebranca12" align="left">&nbsp;&nbsp;Clínica para os exames:</td>
			<td class="fontebranca12" align="left" colspan=2></td>
		</tr>
</table></div><br />

<div align="center">
<table width="90%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<th colspan="2" bgcolor="#009966"> <br>
		<input type="button" value="Sair" name="sair" onclick="MM_goToURL('parent','../medico/lista_aso.php'); return document.MM_returnValue" style="width:100;" />
		&nbsp;&nbsp;
        <input type="submit" value="Gravar" name="btn_gravar" style="width:100;">
 	    &nbsp;&nbsp;&nbsp;
		<input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="MM_goToURL('parent','../medico/lista_func_aso.php?cliente=<?php echo $_GET[cliente]; ?>&setor=<?php echo $_GET[setor];?>');return document.MM_returnValue" style="width:100;">
		<br>
		&nbsp; </th>		
	</tr>
</table>
</div>

</form>
</body>
</html>
