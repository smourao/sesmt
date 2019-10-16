<?php
if($_GET[remove]){
	$del = "DELETE FROM risco_setor WHERE id = {$_GET[remove]}";
	if(pg_query($connect, $del)){
		showmessage('Risco do setor excluido com sucesso!');
	}
}

if( $_POST['btnSaveAgen'] and !empty($_POST["cod_agente_risco"]) ){

	$sql = "INSERT INTO risco_setor
		   (cod_cliente, cod_setor, cod_agente_risco, fonte_geradora, cod_tipo_contato, cod_agente_contato, nivel, itensidade,
		   danos_saude, escala_acao, acao_necessaria, diagnostico, preventiva, acidente, corretiva, data, id_ppra, dsc_agente)
    	   VALUES 
		   ($_GET[cod_cliente], $_GET[cod_setor], $cod_agente_risco, '$fonte_geradora', $tipo_contato_id, $contato_com_agente_id,
		   '$nivel', '$itensidade', '$danos_saude', '$escala_acao', '$acao_necessaria', '$diagnostico', '$preventiva', '$acidente',
		   '$corretiva', '".date('Y/m/d')."', $_GET[cod_cgrt], '$dsc_agente')";
	$result = pg_query($sql);
	if($result){
		showmessage('Risco do setor cadastrado com sucesso!');
	}
}elseif($_POST['btnSaveAgen'] and empty($_POST["cod_agente_risco"])){
	showmessage('Selecione um <b>Tipo de Risco</b>!');
}

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Riscos do Setor:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
	echo "<form method=post name=frmagentes_nocivos id=frmagentes_nocivos action='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_agentes_nocivos' onsubmit=\"return agen_noci(this);\">";
		echo "<td align=center class='text roundborderselected'>";

		    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
			echo "<tr>";
				echo "<td align=left class='text' width=100>Risco:</td>";
				echo "<td algn=left class='text' width=150><select name=cod_tipo_risco id=cod_tipo_risco>";
					$sql_tipo_risco = "SELECT cod_tipo_risco, nome_tipo_risco, descricao_tipo_risco FROM tipo_risco ORDER BY cod_tipo_risco";
					$result_tipo_risco = pg_query($sql_tipo_risco);
					while($row_tipo_risco = pg_fetch_array($result_tipo_risco)){
						echo "<option value=\"$row_tipo_risco[cod_tipo_risco]\" > $row_tipo_risco[cod_tipo_risco] - $row_tipo_risco[nome_tipo_risco]</option>";
					}
				echo "</select>&nbsp;&nbsp;<input type=submit name=btn_ok value='OK' style=\"width:30px;\">";
				echo "</td>";
				if($_POST[btn_ok]=="OK"){
/**************************************************************************************************/
// - > verifica qual agente risco já está cadastrado e não o seleciona novamente
/**************************************************************************************************/	
				$sql_existe = "SELECT cod_agente_risco
								FROM risco_setor
								WHERE id_ppra = $_GET[cod_cgrt]
								AND cod_setor = $_GET[cod_setor]";
				$result_existe = pg_query($sql_existe);
				if(pg_num_rows($result_existe) > 0){
					while($row_existe = pg_fetch_array($result_existe)){
						$existe .= ",$row_existe[cod_agente_risco]";
					}
				}
				$sql_agente_risco = "SELECT cod_agente_risco, descricao_agente_risco, nome_agente_risco, cod_tipo_risco, num_agente_risco
									 FROM agente_risco
									 where cod_tipo_risco = $_POST[cod_tipo_risco]";
				if ( substr($existe,0,1)=="," ){
					$sql_agente_risco .= " AND cod_agente_risco not in (". substr($existe,1,50) .")";
				}
				
				$result_agente_risco = pg_query($sql_agente_risco);

				echo "<td align=left class='text' width=100>Agente:</td>";
				echo "<td algn=left class='text' width=150>";
					echo "<select name=cod_agente_risco id=cod_agente_risco style=\"width:250px;\">";
					echo "<option value=''></option>";
						while($row_agente_risco = pg_fetch_array($result_agente_risco)){
							echo "<option value=\"$row_agente_risco[cod_agente_risco]\">" . $row_agente_risco[num_agente_risco] . " - $row_agente_risco[nome_agente_risco] </option>";
						}
					echo "</select>";
				echo "</td>";
				}//BOTÃO OK
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Fonte Geradora:</td>";
				echo "<td class='text' ><textarea name=fonte_geradora id=fonte_geradora cols=28 rows=2></textarea></td>";
				echo "<td class='text' >Diagnóstico:</td>";
				echo "<td class='text' ><textarea name=diagnostico id=diagnostico cols=28 rows=2></textarea></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Exposição:</td>";
				echo "<td align=left class='text' >";
					echo "<select class='text' name='tipo_contato_id' id='tipo_contato_id' style=\"width:100px;\">";
						$sql_tipo_contato = "SELECT * FROM tipo_contato order by nome";
						$result_tipo_contato = pg_query($sql_tipo_contato);
						while($row_tipo_contato = pg_fetch_array($result_tipo_contato)){
							echo "<option value=\"$row_tipo_contato[tipo_contato_id]\"> $row_tipo_contato[nome]</option>";
						}
					echo "</select>";
				echo "</td>";
				echo "<td align=left class='text' >Contato:</td>";
				echo "<td align=left class='text' >";
					echo "<select class='text' name='contato_com_agente_id' id='contato_com_agente_id' style=\"width:100px;\">";
						$sql_tipo = "SELECT * FROM contato_com_agente order by nome";
						$result_tipo = pg_query($sql_tipo);
						while($row_tipo = pg_fetch_array($result_tipo)){
							echo "<option value=\"$row_tipo[contato_com_agente_id]\"> $row_tipo[nome]</option>";
						}
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Nível Ação:</td>";
				echo "<td align=left class='text' >";
					echo "<select name=nivel id=nivel onBlur=\"nivelRisco(this);\" style=\"width:35px;\">
						<option value='0'>0</option>
						<option value='I'>I</option>
						<option value='II'>II</option>
						<option value='III'>III</option>
						</select>";
				echo "</td>";
				echo "<td align=left class='text'>Itensidade:</td>";
				echo "<td align=left class='text' >";
					echo "<select name=itensidade id=itensidade style=\"width:100px;\">
						<option value='Curto Prazo'>Curto Prazo</option>
						<option value='Médio Prazo'>Médio Prazo</option>
						<option value='Longo Prazo'>Longo Prazo</option>
						</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text'>Dano:</td>";
				echo "<td align=left class='text' >";
					echo "<select name=danos_saude id=danos_saude style=\"width:100px;\">
						<option value='Não Grave'>Não Grave</option>
						<option value='Grave'>Grave</option>
						<option value='Gravíssimo'>Gravíssimo</option>
						</select>";
				echo "</td>";
				echo "<td align=left class='text'>Escala Ação:</td>";
				echo "<td align=left class='text' >";
					echo "<select name=escala_acao id=escala_acao style=\"width:35px;\">
						<option value='0'>0</option>
						<option value='I'>I</option>
						<option value='II'>II</option>
						<option value='III'>III</option>
						</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Medidas Preventivas:</td>";
				echo "<td class='text' ><textarea name=acao_necessaria id=acao_necessaria cols=28 rows=2></textarea></td>";
				echo "<td class='text' >Possibilidade de Acidentes:</td>";
				echo "<td class='text' ><textarea name=acidente id=acidente cols=28 rows=2></textarea></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Medidas Corretivas:</td>";
				echo "<td class='text' ><textarea name=corretiva id=corretiva cols=28 rows=2></textarea></td>";
				/*if($_POST[cod_tipo_risco] == 4){
					echo "<td class='text' >Descrição do Agente:</td>";
					echo "<td class='text' ><textarea name=dsc_agente id=dsc_agente cols=28 rows=2></textarea></td>";
				}*/	
			echo "</tr>";
			echo "</table>";
			
		echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
echo "<tr>";
echo "<td align=left class='text'>";
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
	echo "<tr>";
		echo "<td align=center class='text roundbordermix'>";
		echo "<input type='submit' class='btn' name='btnSaveAgen' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" ></td>";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/************************************************************************************************************/
// - > RISCO JÁ CADASTRADO
/************************************************************************************************************/
$sql_dados = "SELECT s.nome_setor, a.nome_agente_risco, a.num_agente_risco, a.cod_tipo_risco, t.nome, ca.nome as nome1, r.*
FROM setor s, risco_setor r, cliente_setor c, agente_risco a, tipo_contato t, contato_com_agente ca
WHERE r.cod_cliente = c.cod_cliente
AND r.cod_setor = c.cod_setor
AND r.cod_setor = s.cod_setor
AND r.cod_agente_risco = a.cod_agente_risco
AND r.cod_tipo_contato = t.tipo_contato_id
AND r.cod_agente_contato = ca.contato_com_agente_id
AND r.id_ppra = c.id_ppra
AND r.id_ppra = $_GET[cod_cgrt]
AND r.cod_setor = $_GET[cod_setor]";
$result_dados = pg_query($connect, $sql_dados);
$row_dados = pg_fetch_all($result_dados);
	
if($row_dados != ""){
echo "<table width=100% border=0 cellpadding=2 cellspacing=2 >
<tr>
	<td align=center class='text'><b>Risco Cadastrado</b></td>
</tr>";
	echo "</table>";
	echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
	echo "<tr>";
	echo "<td align=left class='text'>";

	echo "<table width=100% border=0 cellpadding=2 cellspacing=2 >";
	for($i=0;$i<pg_num_rows($result_dados);$i++){
	
		echo "<tr>
				<td colspan=4 class='text roundborderselected'>
				<b><u><a href='?dir=cgrt&p=index&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_agentes_nocivos&remove={$row_dados[$i]['id']}' alt='Excluir este risco' title='Excluir este risco'>Excluir</a></u>&nbsp; 
				<u><a href='?dir=cgrt&p=index&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_edit_agentes_nocivos&rid={$row_dados[$i]['id']}'>Editar</a></u></b></td>
			 </tr>";
		echo "<tr>
				<td width=25% class='text roundborderselected' align=right> Nome Setor:</td>
				<td width=25% class='text roundborderselected'><b> {$row_dados[$i][nome_setor]} </td>
			    <td width=25% class='text roundborderselected' align=right> Contato com Agente:</td>
				<td width=25% class='text roundborderselected'><b> {$row_dados[$i][nome1]} </td>
			 </tr>";
		echo "<tr>
				<td class='text roundborderselected' align=right> Agente do Risco:</td>
				<td class='text roundborderselected'><b> {$row_dados[$i][nome_agente_risco]} </td>
			    <td class='text roundborderselected' align=right> Nível de Ação:</td>
				<td class='text roundborderselected'><b> {$row_dados[$i][nivel]} </td>
			 </tr>";
		echo "<tr>
				<td class='text roundborderselected' align=right> Código do Agente:</td>
				<td class='text roundborderselected'><b> ". str_pad($row_dados[$i][num_agente_risco], 4, "0", STR_PAD_LEFT) . " </td>
			    <td class='text roundborderselected' align=right> Grau de Itensidade:</td>
				<td class='text roundborderselected'><b> {$row_dados[$i][itensidade]} </td>
			 </tr>";
		echo "<tr>
				<td class='text roundborderselected' align=right> Fonte do Risco:</td>
				<td class='text roundborderselected'><b> {$row_dados[$i][fonte_geradora]} </td>
			    <td class='text roundborderselected' align=right> Danos a Saúde:</td>
				<td class='text roundborderselected'><b> {$row_dados[$i][danos_saude]} </td>
			 </tr>";
		echo "<tr>
				<td class='text roundborderselected' align=right> Diagnóstico:</td>
				<td class='text roundborderselected'><b> {$row_dados[$i][diagnostico]} </td>
			    <td class='text roundborderselected' align=right> Escala de Ação:</td>
				<td class='text roundborderselected'><b> {$row_dados[$i][escala_acao]} </td>
			 </tr>";
		echo "<tr>
				<td class='text roundborderselected' align=right> Tipo de Exposição:</td>
				<td class='text roundborderselected'><b> {$row_dados[$i][nome]} </td>
			    <td class='text roundborderselected' align=right> Medidas Preventivas:</td>
				<td class='text roundborderselected'><b> {$row_dados[$i][acao_necessaria]} </td>
			 </tr>";
		echo "<tr>
				<td class='text roundborderselected' align=right> Possibilidades de Acidentes:</td>
				<td colspan=3 class='text roundborderselected'><b> {$row_dados[$i][acidente]} </td>
			 </tr>";
		echo "<tr>
				<td class='text roundborderselected' align=right> Medidas Corretivas:</td>
				<td colspan=3 class='text roundborderselected'><b> {$row_dados[$i][corretiva]} </td>
			 </tr>";
		/*if($row_dados[$i][cod_tipo_risco] == 4){
		echo "<tr>
				<td class='text roundborderselected' align=right> Descrição do Agente:</td>
				<td colspan=3 class='text roundborderselected'><b> {$row_dados[$i][dsc_agente]} </td>
			 </tr>";
		}*/
		echo "<tr>
				<td colspan=4> &nbsp; </td>
			 </tr>";
	}
}   
	echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
	
echo "</td>";
echo "</form>";
echo "</tr>";
echo "</table>";
?>