<?php
include "../config/connect.php";
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

if($_POST && $_POST[btnSave]){
    $cod_agente_risco = $_POST["cod_agente_risco"];
    $fonte_geradora   = $_POST["fonte_geradora"];
    $sql = "UPDATE risco_setor SET
    cod_agente_risco=$_POST[cod_agente_risco],
    fonte_geradora='$_POST[fonte_geradora]',
    cod_tipo_contato=$_POST[tipo_contato_id],
    cod_agente_contato = $_POST[contato_com_agente_id],
    nivel='$_POST[nivel]',
    itensidade='$_POST[itensidade]',
    danos_saude='$_POST[danos_saude]',
    escala_acao='$_POST[escala_acao]',
    acao_necessaria='$_POST[acao_necessaria]',
    diagnostico='$_POST[diagnostico]',
    preventiva='$_POST[preventiva]',
    acidente='$_POST[acidente]',
    corretiva='$_POST[corretiva]'
    WHERE
    id = $_GET[rid] AND id_ppra = $_GET[id_ppra]";

    $result = pg_query($sql);
	if($result){
		echo "<script>alert('Risco do Setor alterado com sucesso!');</script>";
	}
}

?>
<html>
<head>
<title>PPRA</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js"></script>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">

<table align="center" width="100%" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
<th colspan="4" bgcolor="#009966" ><p align="left">
	<br>&nbsp;&nbsp;&nbsp;RECONHECIMENTO E AVALIAÇÕES AMBIENTAIS<br>
	<br>
	&nbsp;&nbsp; COLETA DE DADOS DA EXPOSIÇÃO DO TRABALHADOR AOS AGENTES:<br>
	<br> <center>EDIÇÃO DE AGENTE NOCIVO <br>&nbsp;</center></th>
</tr>
	<?php
	$sql = "SELECT * FROM cliente where cliente_id = $cliente";
	$result_cli = pg_query($sql);
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
	/*
	  if(!empty($cliente) and !empty($setor)){
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
		*/
	?>
</table>

<?PHP
    //$sql = "SELECT * FROM risco_setor WHERE id = $_GET[rid]";
    $sql = "SELECT rs.*, tr.*, ar.* FROM risco_setor rs, tipo_risco tr, agente_risco ar
    WHERE
    rs.cod_agente_risco = ar.cod_agente_risco
    AND
    ar.cod_tipo_risco = tr.cod_tipo_risco
    AND
    rs.id = $_GET[rid]";
    $rsz = pg_query($sql);
    $rdata = pg_fetch_array($rsz);
?>

<form method="POST">
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
		if($row_tipo_risco[cod_tipo_risco] <> $rdata[cod_tipo_risco]){
			//echo "<option value=\"$row_tipo_risco[cod_tipo_risco]\"> $row_tipo_risco[cod_tipo_risco] - $row_tipo_risco[nome_tipo_risco]</option>";
		}else{
			echo "<option value=\"$row_tipo_risco[cod_tipo_risco]\" selected> $row_tipo_risco[cod_tipo_risco] - $row_tipo_risco[nome_tipo_risco]</option>";
		}
	}
?>
						</select> &nbsp;&nbsp;&nbsp;&nbsp;
						<!--
                        <input type="submit" name="btn_ok" value="OK" style="width:30px;">
                        -->
                        </td>
                        
				</tr>
<?php

    $sql_agente_risco = "SELECT * FROM agente_risco where cod_tipo_risco = $rdata[cod_tipo_risco]";
    $result_agente_risco = pg_query($sql_agente_risco);
		echo "<tr>
				<td class=\"fontebranca12\">Agente Risco:</td>";

/*************** Início COMBO ********************/
		echo "	<td class=\"fontepreta12\">";
		echo "		&nbsp; <select name=\"cod_agente_risco\" style=\"background:#FFFFCC;\">";
		while($row_agente_risco = pg_fetch_array($result_agente_risco)){
		    if($row_agente_risco[cod_agente_risco] == $rdata[cod_agente_risco])
    			echo "<option value=\"$row_agente_risco[cod_agente_risco]\" selected>" . $row_agente_risco[num_agente_risco] . " - $row_agente_risco[nome_agente_risco] </option>";
			else
				echo "<option value=\"$row_agente_risco[cod_agente_risco]\">" . $row_agente_risco[num_agente_risco] . " - $row_agente_risco[nome_agente_risco] </option>";
			
		}
		echo "		</select>";
/*************** Final COMBO ********************/
		echo "	</td>";
		echo "</tr>";

?>
			</table>
		</td>
	</tr>
	<tr>
		<td class="fontebranca12" align="right"><b>Fonte Geradora: &nbsp;</b></td>
		<td colspan="3"><br>&nbsp;<textarea name="fonte_geradora" cols=50 rows=2 style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"><?PHP echo $rdata[fonte_geradora];?></textarea><br>&nbsp;</td>
	</tr>
	<tr>
		<td class="fontebranca12" align="right"><b>Diagnóstico: &nbsp;</b></td>
		<td colspan="3"><br>&nbsp;<textarea name="diagnostico" cols=50 rows=2 style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"><?PHP echo $rdata[diagnostico];?></textarea><br>&nbsp;</td>
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
					if($row_dados[cod_tipo_contato] <> $rdata[tipo_contato_id] ){
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
		<option value="Curto Prazo" <?PHP if($rdata[itensidade]=='Curto Prazo') echo ' selected ';?>>Curto Prazo</option>
		<option value="Médio Prazo"<?PHP if($rdata[itensidade]=='Médio Prazo') echo ' selected ';?>>Médio Prazo</option>
		<option value="Longo Prazo"<?PHP if($rdata[itensidade]=='Longo Prazo') echo ' selected ';?>>Longo Prazo</option>
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
					if($row_tipo[contato_com_agente_id] <> $rdata[cod_tipo_contato]){
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
		<option value="Não Grave"<?PHP if($rdata[danos_saude]=='Não Grave') echo ' selected ';?>>Não Grave</option>
		<option value="Grave"<?PHP if($rdata[danos_saude]=='Grave') echo ' selected ';?>>Grave</option>
		<option value="Gravíssimo"<?PHP if($rdata[danos_saude]=='Gravíssimo') echo ' selected ';?>>Gravíssimo</option>
		</select></td>
	</tr>
	<tr>
		<td align="right" class="fontebranca12"><b>Nível de Ação:</b> &nbsp;</td>
		<td class="fontebranca12">&nbsp;&nbsp;
		<select name="nivel" id="nivel" onBlur="nivelRisco(this);">
		<option value="0"<?PHP if($rdata[nivel]=='0') echo ' selected ';?>>0</option>
		<option value="I"<?PHP if($rdata[nivel]=='I') echo ' selected ';?>>I</option>
		<option value="II"<?PHP if($rdata[nivel]=='II') echo ' selected ';?>>II</option>
		<option value="III"<?PHP if($rdata[nivel]=='III') echo ' selected ';?>>III</option>
		</select></td>
		<td align="right" class="fontebranca12"><b>Escala de Ação:</b> &nbsp;</td>
		<td class="fontebranca12">
		&nbsp;&nbsp;
		<select name="escala_acao" id="escala_acao">
		<option value="0"<?PHP if($rdata[escala_acao]=='0') echo ' selected ';?>>0</option>
		<option value="I"<?PHP if($rdata[escala_acao]=='I') echo ' selected ';?>>I</option>
		<option value="II"<?PHP if($rdata[escala_acao]=='II') echo ' selected ';?>>II</option>
		<option value="III"<?PHP if($rdata[escala_acao]=='III') echo ' selected ';?>>III</option>
		</select></td>
	</tr>
	<tr>
		<td class="fontebranca12" align="right"><b>Medidas Preventivas: &nbsp;</b></td>
		<td colspan="3"><br>&nbsp;<textarea name="acao_necessaria" cols=50 rows=2  style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"><?PHP echo $rdata[acao_necessaria];?></textarea><br>&nbsp;</td>
	</tr>
	<tr>
		<td class="fontebranca12" align="right"><b>Possibilidades de Acidentes:&nbsp;</b></td>
		<td colspan="3"><br>&nbsp;<textarea name="acidente" cols=50 rows=2 style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"><?PHP echo $rdata[acidente];?></textarea><br>&nbsp;</td>
	</tr>
	<tr>
		<td class="fontebranca12" align="right"><b>Medidas Corretivas:&nbsp;</b></td>
		<td colspan="3"><br>&nbsp;<textarea name="corretiva" cols=50 rows=2  style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12;"><?PHP echo $rdata[corretiva];?></textarea><br>&nbsp;</td>
	</tr>
	

<tr>
		<td align="center" colspan="4">
			<br><input type="button"  name="voltar" value="&lt;&lt; Voltar" onClick="location.href='ppra3.php?cliente=<?PHP echo $_GET[cliente];?>&id_ppra=<?php echo $_GET[id_ppra];?>&setor=<?php echo $setor; ?>&fid=<?PHP echo $_GET[fid];?>&y=<?php echo $_GET['y']; ?>';" style="width:100;">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="submit" name="btnSave" value="Gravar" style="width:100px;" >
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
