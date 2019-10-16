<?php
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.
include "../sessao.php";
include "ppra_functions.php";

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

if($_GET){
	$cliente = $_GET["cliente"];
	$setor = $_GET["setor"];
	$fid = $_GET["fid"];
}
else{
	$cliente = $_POST["cliente"];
	$setor = $_POST["setor"];
	$fid = $_POST["fid"];
}

/* IDENTIFICA SE O USUÁRIO QUE CONTINUAR INSERINDO DADOS OU PARAR */
$continuar = $_POST["btn_mais"]; // CONTINUA

/*************** ESTE PEDAÇO É SÓ PRA TRAZER O NOME DO CLIENTE ***********************/
if( !empty($g_cliente) & !empty($g_setor) ){
	$query_cli = "SELECT razao_social, bairro, telefone, email, endereco
				  FROM cliente where cliente_id = $g_cliente";
	$result_cli = pg_query($query_cli);
}elseif( !empty($cliente) & !empty($setor) ){
	$query_cli = "SELECT razao_social, bairro, telefone, email, endereco
				  FROM cliente where cliente_id = $cliente";
	$result_cli = pg_query($query_cli);
}
/******************* FIM PEDAÇO PRA TRAZER O NOME DO CLIENTE ***************************/

if( $continuar == "Gravar" and !empty($_POST["cod_agente_risco"]) ){ //CONTINUA
ppra_progress_update($cliente, $setor);
	$cod_agente_risco = $_POST["cod_agente_risco"];
	$fonte_geradora   = $_POST["fonte_geradora"];

	$sql = "INSERT INTO risco_setor
		   (cod_cliente, cod_setor, cod_agente_risco, fonte_geradora, cod_tipo_contato, cod_agente_contato, nivel, itensidade,
		   danos_saude, escala_acao, acao_necessaria, diagnostico, preventiva, acidente, corretiva, data, id_ppra)
    	   VALUES 
		   ($cliente, $setor, $cod_agente_risco, '$fonte_geradora', $tipo_contato_id, $contato_com_agente_id, '$nivel', '$itensidade',
		   '$danos_saude', '$escala_acao', '$acao_necessaria', '$diagnostico', '$preventiva', '$acidente', '$corretiva', '".date('Y/m/d')."', $_GET[id_ppra])";
	$result = pg_query($sql);
	if($result){
		echo "<script>alert('Risco do Setor cadastrado com sucesso!');</script>";
		$sql = "";
		$cod_agente_risco = "";
		$fonte_geradora = "";
	}
}elseif($continuar == "Gravar" and empty($_POST["cod_agente_risco"])){
	echo "<script>alert('Selecione um TIPO DE RISCO!');</script>";
}

/*********************** Exclusão **********************/
if ($_POST["btn_excluir"] == "Excluir"){
	if(isset($_POST["risco_agente"])){
		foreach($_POST["risco_agente"] as $risco_agente){
			$excluir .= "delete from risco_setor
						 where id_ppra = $_GET[id_ppra]
						 and cod_setor = $setor
						 and cod_agente_risco = $risco_agente;";
		}
		$result_excluir = pg_query($excluir);
		if ($result_excluir){
			echo '<script> alert("Agentes de Risco excluidos com sucesso!");</script>';
		}
	}
}
/*********************** FIM Exclusão **********************/
?>
<html>
<head>
<title>PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_ppra3" method="POST">
<table align="center" width="100%" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
<th colspan="4" bgcolor="#009966" ><p align="left">
	<br>&nbsp;&nbsp;&nbsp;RECONHECIMENTO E AVALIAÇÕES AMBIENTAIS<br>
	<br>
	&nbsp;&nbsp; COLETA DE DADOS DA EXPOSIÇÃO DO TRABALHADOR AOS AGENTES:<br>
	<br> <center>IDENTIFICAÇÃO QUALITATIVA AGENTE NOCIVO <br>&nbsp;</center></th>
</tr>
	<?php
	if($result_cli){
		$row_cli = pg_fetch_array($result_cli);
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> Nome do Cliente: </td> <td colspan=\"3\" class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[razao_social]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> Endereço: </td>        <td colspan=\"3\" class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[endereco]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> Bairro: </td>          <td colspan=\"3\" class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[bairro]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> Telefone: </td>        <td colspan=\"3\" class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[telefone]</b> </td> </tr>";
			echo "<tr bgcolor=#FFFFFF > <td class=\"fontepreta12\" align=right> E-mail: </td>          <td colspan=\"3\" class=\"fontepreta12\"> <b>&nbsp;&nbsp;&nbsp; $row_cli[email]</b> </td> </tr>";
	}
	?>
	<tr> <td colspan="4">&nbsp;</td> </tr>
	<?php
	  if(!empty($cliente) and !empty($setor)){
			/*
            $sql_dados = "select s.nome_setor, a.nome_agente_risco, a.num_agente_risco, t.nome, ca.nome as nome1, r.*
						 from setor s, risco_setor r, cliente_setor c, agente_risco a, tipo_contato t, contato_com_agente ca
						 where r.cod_cliente = c.cod_cliente
								and r.cod_setor = c.cod_setor
								and r.cod_setor = s.cod_setor
								and r.cod_agente_risco = a.cod_agente_risco
								and r.cod_tipo_contato = t.tipo_contato_id
								and r.cod_agente_contato = ca.contato_com_agente_id
								AND EXTRACT(year FROM data_criacao) = EXTRACT(year FROM data)
								and r.cod_cliente = $cliente
								and r.cod_setor = $setor
								AND EXTRACT(year FROM c.data_criacao) = {$ano}";
            */
            $sql_dados = "select s.nome_setor, a.nome_agente_risco, a.num_agente_risco, t.nome, ca.nome as nome1, r.*
            from setor s, risco_setor r, cliente_setor c, agente_risco a, tipo_contato t, contato_com_agente ca
            where r.cod_cliente = c.cod_cliente
            and r.cod_setor = c.cod_setor
            and r.cod_setor = s.cod_setor
            and r.cod_agente_risco = a.cod_agente_risco
            and r.cod_tipo_contato = t.tipo_contato_id
            and r.cod_agente_contato = ca.contato_com_agente_id
            AND r.id_ppra = c.id_ppra
            AND r.id_ppra = $_GET[id_ppra]
            and r.cod_setor = $_GET[setor]";
            $result_dados = pg_query($sql_dados);
			while($row_dados = pg_fetch_array($result_dados)){
			
				echo "<tr bgcolor=#FFFFFF> <td width=\"20%\" class=\"fontepreta12\" align=right> <input name=\"risco_agente[]\" type=\"checkbox\" value=\"$row_dados[cod_agente_risco]\">&nbsp; &nbsp;  </td> <td width=\"30%\" colspan=3 class=\"fontepreta12\">&nbsp; <b> <u> Excluir </u> &nbsp; <b> <u> <a href='editar_risco.php?cliente=$_GET[cliente]&id_ppra=$_GET[id_ppra]&setor=$_GET[setor]&fid=$_GET[fid]&y=$_GET[y]&rid=$row_dados[id]'><font color=black>Editar</font></a> </u></td> </tr>";
				echo "<tr bgcolor=#FFFFFF> <td class=\"fontepreta12\" align=right> Nome Setor: &nbsp;</td> 					<td class=\"fontepreta12\">&nbsp; <b> $row_dados[nome_setor] </td>
					  <td width=\"20%\" class=\"fontepreta12\" align=right> Contato com Agente: &nbsp;</td> 				<td width=\"30%\" class=\"fontepreta12\">&nbsp; <b> $row_dados[nome1] </td> </tr>";
				echo "<tr bgcolor=#FFFFFF> <td class=\"fontepreta12\" align=right> Agente do Risco: &nbsp;</td> 			<td class=\"fontepreta12\">&nbsp; <b> $row_dados[nome_agente_risco] </td>
					  <td class=\"fontepreta12\" align=right> Nível de Ação: &nbsp;</td> 									<td class=\"fontepreta12\">&nbsp; <b> $row_dados[nivel] </td> </tr>";
				echo "<tr bgcolor=#FFFFFF> <td class=\"fontepreta12\" align=right> Código do Agente: &nbsp;</td> 			<td class=\"fontepreta12\">&nbsp; <b> ". str_pad($row_dados[num_agente_risco], 4, "0", STR_PAD_LEFT) . " </td>
					  <td class=\"fontepreta12\" align=right> Grau de Itensidade: &nbsp;</td> 								<td class=\"fontepreta12\">&nbsp; <b> $row_dados[itensidade] </td> </tr>";
				echo "<tr bgcolor=#FFFFFF> <td class=\"fontepreta12\" align=right> Fonte do Risco: &nbsp;</td> 				<td class=\"fontepreta12\">&nbsp; <b> $row_dados[fonte_geradora] </td>
					  <td class=\"fontepreta12\" align=right> Danos a Saúde: &nbsp;</td> 									<td class=\"fontepreta12\">&nbsp; <b> $row_dados[danos_saude] </td> </tr>";
				echo "<tr bgcolor=#FFFFFF> <td class=\"fontepreta12\" align=right> Diagnóstico: &nbsp;		</td> 			<td class=\"fontepreta12\">&nbsp; <b> $row_dados[diagnostico] </td>
					  <td class=\"fontepreta12\" align=right> Escala de Ação: &nbsp;</td> 									<td class=\"fontepreta12\">&nbsp; <b> $row_dados[escala_acao] </td> </tr>";
				echo "<tr bgcolor=#FFFFFF> <td class=\"fontepreta12\" align=right> Tipo de Exposição: &nbsp;</td> 			<td class=\"fontepreta12\">&nbsp; <b> $row_dados[nome] </td>
					  <td class=\"fontepreta12\" align=right> Medidas Preventivas: &nbsp;</td> 								<td class=\"fontepreta12\">&nbsp; <b> $row_dados[acao_necessaria] </td> </tr>";
				//echo "<tr bgcolor=#FFFFFF> <td class=\"fontepreta12\" align=right> Medidas Preventivas: &nbsp;</td> 		<td colspan=3 class=\"fontepreta12\">&nbsp; <b> $row_dados[preventiva] </td> </tr>";
				echo "<tr bgcolor=#FFFFFF> <td class=\"fontepreta12\" align=right> Possibilidades de Acidentes: &nbsp;</td>	<td colspan=3 class=\"fontepreta12\">&nbsp; <b> $row_dados[acidente] </td> </tr>";
				echo "<tr bgcolor=#FFFFFF> <td class=\"fontepreta12\" align=right> Medidas Corretivas: &nbsp;</td> 			<td colspan=3 class=\"fontepreta12\">&nbsp; <b> $row_dados[corretiva] </td> </tr>";
				echo "<tr bgcolor=#FFFFFF> <td colspan=4> &nbsp; </td> </tr>";
			}
		}
	?>
</table>
<table align="center" width="100%" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td width="300" class="fontebranca12" align="right"><b>Riscos do Setor: &nbsp;</b></td>
		  <td colspan="3" width="500">
			<table width="500" border="2">
				<tr>
					<td width="170" class="fontebranca12">Tipo de Risco:</td>
					<td width="312" class="fontebranca12">
						&nbsp;&nbsp;
						<select name="cod_tipo_risco">
<?php
	$sql_tipo_risco = "SELECT cod_tipo_risco, nome_tipo_risco, descricao_tipo_risco FROM tipo_risco";
	$result_tipo_risco = pg_query($sql_tipo_risco);
	while($row_tipo_risco = pg_fetch_array($result_tipo_risco)){
		if($row_tipo_risco[cod_tipo_risco] <> $_POST[cod_tipo_risco]){
			echo "<option value=\"$row_tipo_risco[cod_tipo_risco]\"> $row_tipo_risco[cod_tipo_risco] - $row_tipo_risco[nome_tipo_risco]</option>";
		}else{
			echo "<option value=\"$row_tipo_risco[cod_tipo_risco]\" selected> $row_tipo_risco[cod_tipo_risco] - $row_tipo_risco[nome_tipo_risco]</option>";
		}
	}
?>
						</select> &nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="submit" name="btn_ok" value="OK" style="width:30px;">				  </td>
				</tr>
<?php
	if($_POST[btn_ok]=="OK"){
/************************ verifica qual agente risco já está cadastrado e não o seleciona novamente ************************/	
		$sql_existe = "SELECT cod_agente_risco
                        FROM risco_setor
                        WHERE id_ppra = $_GET[id_ppra]
                        AND cod_setor = $_GET[setor]";
		$result_existe = pg_query($sql_existe);
		if(pg_num_rows($result_existe) > 0){
			while($row_existe = pg_fetch_array($result_existe)){
				$existe .= ",$row_existe[cod_agente_risco]";
			}
		}
		$sql_agente_risco = "SELECT cod_agente_risco, descricao_agente_risco, substr(nome_agente_risco,1,40) as nome_agente_risco, cod_tipo_risco, num_agente_risco
							 FROM agente_risco
							 where cod_tipo_risco = $_POST[cod_tipo_risco]";
		if ( substr($existe,0,1)=="," ){
			$sql_agente_risco .= " AND cod_agente_risco not in (". substr($existe,1,50) .")";
		}

/************************************************************************************************************************/
		$result_agente_risco = pg_query($sql_agente_risco);
		echo "<tr>
				<td class=\"fontebranca12\">Agente Risco:</td>";

/*************** Início COMBO ********************/
		echo "	<td class=\"fontepreta12\">";
		echo "		&nbsp; <select name=\"cod_agente_risco\" style=\"background:#FFFFCC;\">";
		while($row_agente_risco = pg_fetch_array($result_agente_risco)){
			echo "<option value=\"$row_agente_risco[cod_agente_risco]\">" . $row_agente_risco[num_agente_risco] . " - $row_agente_risco[nome_agente_risco] </option>";
		}
		echo "		</select>";
/*************** Final COMBO ********************/
		echo "	</td>";
		echo "</tr>";
	}
?>
			</table>
		</td>
	</tr>
	<tr>
		<td class="fontebranca12" align="right"><b>Fonte Geradora: &nbsp;</b></td>
		<td colspan="3"><br>&nbsp;<textarea name="fonte_geradora" cols=50 rows=2 style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"></textarea><br>&nbsp;</td>
	</tr>
	<tr>
		<td class="fontebranca12" align="right"><b>Diagnóstico: &nbsp;</b></td>
		<td colspan="3"><br>&nbsp;<textarea name="diagnostico" cols=50 rows=2 style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"></textarea><br>&nbsp;</td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12"><b>Tipo de Exposição: &nbsp;</b></td>
		<td class="fontebranca12">
			&nbsp;&nbsp;
			<select name="tipo_contato_id">
			<?php
				$sql_tipo_contato = "SELECT * FROM tipo_contato order by nome";
				$result_tipo_contato = pg_query($sql_tipo_contato);
				while($row_tipo_contato = pg_fetch_array($result_tipo_contato)){
					if($row_dados[cod_tipo_contato] <> $row_tipo_contato[tipo_contato_id] ){
						echo "<option value=\"$row_tipo_contato[tipo_contato_id]\"> $row_tipo_contato[nome]</option>";
					}else{
						echo "<option value=\"$row_tipo_contato[tipo_contato_id]\" selected> $row_tipo_contato[nome]</option>";
					}
				}
			?>
			</select>
		</td>
		<td align="right" class="fontebranca12"><b>Grau de Itensidade:</b> &nbsp;</td>
		<td class="fontebranca12">
		&nbsp;&nbsp;
		<select name="itensidade" id="itensidade">
		<option value="Curto Prazo">Curto Prazo</option>
		<option value="Médio Prazo">Médio Prazo</option>
		<option value="Longo Prazo">Longo Prazo</option>
		</select></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12"><b>Contato com Agente: &nbsp;</b></td>
		<td class="fontebranca12">
			&nbsp;&nbsp;
			<select name="contato_com_agente_id">
			<?php
				$sql_tipo = "SELECT * FROM contato_com_agente order by nome";
				$result_tipo = pg_query($sql_tipo);
				while($row_tipo = pg_fetch_array($result_tipo)){
					if($row_tipo[contato_com_agente_id] <> $_POST[contato_com_agente_id]){
						echo "<option value=\"$row_tipo[contato_com_agente_id]\"> $row_tipo[nome]</option>";
					}else{
						echo "<option value=\"$row_tipo[contato_com_agente_id]\" selected> $row_tipo[nome]</option>";
					}
				}
			?>
			</select>
		</td>
		<td align="right" class="fontebranca12"><b>Danos a Saúde:</b> &nbsp;</td>
		<td class="fontebranca12">
		&nbsp;&nbsp;
		<select name="danos_saude" id="danos_saude">
		<option value="Não Grave">Não Grave</option>
		<option value="Grave">Grave</option>
		<option value="Gravíssimo">Gravíssimo</option>
		</select></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12"><b>Nível de Ação:</b> &nbsp;</td>
		<td class="fontebranca12">&nbsp;&nbsp;
		<select name="nivel" id="nivel" onBlur="nivelRisco(this);">
		<option value="0">0</option>
		<option value="I">I</option>
		<option value="II">II</option>
		<option value="III">III</option>
		</select></td>
		<td align="right" class="fontebranca12"><b>Escala de Ação:</b> &nbsp;</td>
		<td class="fontebranca12">
		&nbsp;&nbsp;
		<select name="escala_acao" id="escala_acao">
		<option value="0">0</option>
		<option value="I">I</option>
		<option value="II">II</option>
		<option value="III">III</option>
		</select></td>
	</tr>
	<tr>
		<td class="fontebranca12" align="right"><b>Medidas Preventivas: &nbsp;</b></td>
		<td colspan="3"><br>&nbsp;<textarea name="acao_necessaria" cols=50 rows=2  style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"></textarea><br>&nbsp;</td>
	</tr>
	<!--
    <tr>
		<td class="fontebranca12" align="right"><b>Medidas Preventivas:&nbsp;</b></td>
		<td colspan="3"><br>&nbsp;<textarea name="preventiva" cols=50 rows=2 style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"></textarea><br>&nbsp;</td>
	</tr>
	-->
	<tr>
		<td class="fontebranca12" align="right"><b>Possibilidades de Acidentes:&nbsp;</b></td>
		<td colspan="3"><br>&nbsp;<textarea name="acidente" cols=50 rows=2 style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"></textarea><br>&nbsp;</td>
	</tr>
	<tr>
		<td class="fontebranca12" align="right"><b>Medidas Corretivas:&nbsp;</b></td>
		<td colspan="3"><br>&nbsp;<textarea name="corretiva" cols=50 rows=2  style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"></textarea><br>&nbsp;</td>
	</tr>
	<tr>
		<td align="center" colspan="4">
			<br><input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="location.href='iluminacao.php?cliente=<?PHP echo $_GET[cliente];?>&id_ppra=<?php echo $_GET[id_ppra];?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>&y=<?php echo $_GET['y']; ?>';" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_excluir" value="Excluir" title="Excluir itens selecionados" style="width:100px;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btn_mais" value="Gravar" style="width:100px;" >
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button"  name="btn_voltar" value="Cancelar" onClick="location.href='lista_ppra.php';" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" name="btn_concluir" value="Avançar &gt;&gt;" style="width:100px;" onClick="location.href='ppra3_sugestao.php?cliente=<?PHP echo $_GET[cliente];?>&id_ppra=<?php echo $_GET[id_ppra];?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>&y=<?php echo $ano; ?>';" title="Clique aqui para avançar">
			<br>&nbsp;
			<input type="hidden" name="p_cliente" value="<?php echo $g_cliente; /*RECEBE AS VARIÁVEIS NA PRIMEIRA VEZ*/?>">
			<input type="hidden" name="p_setor" value="<?php echo $g_setor; /*RECEBE AS VARIÁVEIS NA PRIMEIRA VEZ*/?>">
			<input type="hidden" name="cliente" value="<?php echo $cliente; ?>">
			<input type="hidden" name="setor" value="<?php echo $setor; ?>">
			<input type="hidden" name="alterar" value="<?php echo $alterar; ?>">
		</td>
	</tr>
</table>
</form>
</body>
</html>
