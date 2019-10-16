<?php
if( $_POST['btnSaveAgen'] and !empty($_POST["cod_agente_risco"]) ){
    $sql = "UPDATE risco_setor SET
    cod_agente_risco   = $_POST[cod_agente_risco],
    fonte_geradora	   = '$_POST[fonte_geradora]',
    cod_tipo_contato   = $_POST[tipo_contato_id],
    cod_agente_contato = $_POST[contato_com_agente_id],
    nivel			   = '$_POST[nivel]',
    itensidade		   = '$_POST[itensidade]',
    danos_saude		   = '$_POST[danos_saude]',
    escala_acao		   = '$_POST[escala_acao]',
    acao_necessaria	   = '$_POST[acao_necessaria]',
    diagnostico		   = '$_POST[diagnostico]',
    preventiva		   = '$_POST[preventiva]',
    acidente		   = '$_POST[acidente]',
    corretiva		   = '$_POST[corretiva]',
	dsc_agente		   = '$_POST[dsc_agente]'
    WHERE id = $_GET[rid] AND id_ppra = $_GET[cod_cgrt]";
	if(pg_query($sql)){
		showmessage('Risco do setor alterado com sucesso!');
	}
}

/******************************************************************************************************/
// - > BUSCA OS RISCOS CADASTRADOS NA TABELA
/******************************************************************************************************/
$sql = "SELECT rs.*, tr.*, ar.*
		FROM risco_setor rs, tipo_risco tr, agente_risco ar
		WHERE rs.cod_agente_risco = ar.cod_agente_risco
		AND ar.cod_tipo_risco = tr.cod_tipo_risco
		AND rs.id = $_GET[rid]";
		$rsz = pg_query($sql);
		$rdata = pg_fetch_array($rsz);
		
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Editar Riscos do Setor:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
	echo "<form method=post name=frmedit_agentes_nocivos id=frmedit_agentes_nocivos >";
		echo "<td align=center class='text roundborderselected'>";

		    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
			echo "<tr>";
				echo "<td align=left class='text' width=100>Risco:</td>";
				echo "<td algn=left class='text' width=150><select name=cod_tipo_risco id=cod_tipo_risco>";
					$sql = "SELECT cod_tipo_risco, nome_tipo_risco, descricao_tipo_risco FROM tipo_risco";
					$result_tipo_risco = pg_query($sql);
					while($row_tipo_risco = pg_fetch_array($result_tipo_risco)){
						if($row_tipo_risco[cod_tipo_risco] <> $rdata[cod_tipo_risco]){
							//nothing to show
						}else{
							echo "<option value=\"$row_tipo_risco[cod_tipo_risco]\" selected> $row_tipo_risco[cod_tipo_risco] - $row_tipo_risco[nome_tipo_risco]</option>";
						}
					}
				echo "</select>";
				echo "</td>";
				$sql_agente_risco = "SELECT * FROM agente_risco where cod_tipo_risco = $rdata[cod_tipo_risco]";
    			$result_agente_risco = pg_query($sql_agente_risco);
				echo "<td align=left class='text' width=100>Agente Risco:</td>";
				echo "<td algn=left class='text' width=150>";
					echo "<select name=cod_agente_risco id=cod_agente_risco style=\"width:250px;\">";
						while($row_agente_risco = pg_fetch_array($result_agente_risco)){
							if($row_agente_risco[cod_agente_risco] == $rdata[cod_agente_risco])
								echo "<option value=\"$row_agente_risco[cod_agente_risco]\" selected>" . $row_agente_risco[num_agente_risco] . " - $row_agente_risco[nome_agente_risco] </option>";
							else
								echo "<option value=\"$row_agente_risco[cod_agente_risco]\">" . $row_agente_risco[num_agente_risco] . " - $row_agente_risco[nome_agente_risco] </option>";
						}
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Fonte Geradora:</td>";
				echo "<td class='text' ><textarea name=fonte_geradora id=fonte_geradora cols=28 rows=2>". $rdata[fonte_geradora] ."</textarea></td>";
				echo "<td class='text' >Diagnóstico:</td>";
				echo "<td class='text' ><textarea name=diagnostico id=diagnostico cols=28 rows=2>". $rdata[diagnostico] ."</textarea></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Exposição:</td>";
				echo "<td align=left class='text' >";
					echo "<select class='text' name='tipo_contato_id' id='tipo_contato_id' style=\"width:100px;\">";
						$sql_tipo_contato = "SELECT * FROM tipo_contato order by nome";
						$result_tipo_contato = pg_query($sql_tipo_contato);
						while($row_tipo_contato = pg_fetch_array($result_tipo_contato)){
							if($row_dados[cod_tipo_contato] <> $rdata[tipo_contato_id] ){
								echo "<option value=\"$row_tipo_contato[tipo_contato_id]\"> $row_tipo_contato[nome]</option>";
							}else{
								echo "<option value=\"$row_tipo_contato[tipo_contato_id]\" selected> $row_tipo_contato[nome]</option>";
							}
						}
					echo "</select>";
				echo "</td>";
				echo "<td align=left class='text' >Contato:</td>";
				echo "<td align=left class='text' >";
					echo "<select class='text' name='contato_com_agente_id' id='contato_com_agente_id' style=\"width:100px;\">";
						$sql_tipo = "SELECT * FROM contato_com_agente order by nome";
						$result_tipo = pg_query($sql_tipo);
						while($row_tipo = pg_fetch_array($result_tipo)){
							if($row_tipo[contato_com_agente_id] <> $rdata[cod_tipo_contato]){
								echo "<option value=\"$row_tipo[contato_com_agente_id]\"> $row_tipo[nome]</option>";
							}else{
								echo "<option value=\"$row_tipo[contato_com_agente_id]\" selected> $row_tipo[nome]</option>";
							}
						}
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Nível de Ação:</td>";
				echo "<td align=left class='text' >";
					echo "<select name=nivel id=nivel onBlur=\"nivelRisco(this);\" style=\"width:35px;\">
						<option value='0'"; if($rdata[nivel]=='0') echo " selected "; echo ">0</option>
						<option value='I'"; if($rdata[nivel]=='I') echo " selected "; echo ">I</option>
						<option value='II'"; if($rdata[nivel]=='II') echo " selected "; echo ">II</option>
						<option value='III'"; if($rdata[nivel]=='III') echo " selected "; echo ">III</option>
						</select>";
				echo "</td>";
				echo "<td align=left class='text'>Itensidade:</td>";
				echo "<td align=left class='text' >";
					echo "<select name=itensidade id=itensidade style=\"width:100px;\">
						<option value='Curto Prazo'"; if($rdata[itensidade]=='Curto Prazo') echo "' selected '"; echo ">Curto Prazo</option>
						<option value='Médio Prazo'"; if($rdata[itensidade]=='Médio Prazo') echo "' selected '"; echo ">Médio Prazo</option>
						<option value='Longo Prazo'"; if($rdata[itensidade]=='Longo Prazo') echo "' selected '"; echo ">Longo Prazo</option>
						</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text'>Danos:</td>";
				echo "<td align=left class='text' >";
					echo "<select name=danos_saude id=danos_saude style=\"width:100px;\">
						<option value='Não Grave'"; if($rdata[danos_saude]=='Não Grave') echo " selected "; echo ">Não Grave</option>
						<option value='Grave'"; if($rdata[danos_saude]=='Grave') echo " selected "; echo ">Grave</option>
						<option value='Gravíssimo'"; if($rdata[danos_saude]=='Gravíssimo') echo " selected "; echo ">Gravíssimo</option>
						</select>";
				echo "</td>";
				echo "<td align=left class='text'>Escala Ação:</td>";
				echo "<td align=left class='text' >";
					echo "<select name=escala_acao id=escala_acao style=\"width:35px;\">
						<option value='0'"; if($rdata[escala_acao]=='0') echo " selected "; echo ">0</option>
						<option value='I'"; if($rdata[escala_acao]=='I') echo " selected "; echo ">I</option>
						<option value='II'"; if($rdata[escala_acao]=='II') echo " selected "; echo ">II</option>
						<option value='III'"; if($rdata[escala_acao]=='III') echo " selected "; echo ">III</option>
						</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Medidas Preventivas:</td>";
				echo "<td class='text' ><textarea name=acao_necessaria id=acao_necessaria cols=28 rows=2>". $rdata[acao_necessaria] ."</textarea></td>";
				echo "<td class='text' >Possibilidade de Acidentes:</td>";
				echo "<td class='text' ><textarea name=acidente id=acidente cols=28 rows=2>". $rdata[acidente] ."</textarea></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Medidas Corretivas:</td>";
				echo "<td class='text' ><textarea name=corretiva id=corretiva cols=28 rows=2>". $rdata[corretiva] ."</textarea></td>";
			if($rdata[cod_tipo_risco] == 4){	
				echo "<td class='text' >Descrição do Agente:</td>";
				echo "<td class='text' ><textarea name=dsc_agente id=dsc_agente cols=28 rows=2>". $rdata[dsc_agente] ."</textarea></td>";
			}
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

echo "</td>";
echo "</form>";
echo "</tr>";
echo "</table>";
?>