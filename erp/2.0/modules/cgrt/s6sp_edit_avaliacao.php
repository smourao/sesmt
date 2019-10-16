<?php
if( $_POST['btnSaveAgen'] ){
if($_POST[dtc]){
	$tmp = explode("/", $_POST[dtc]);
	$dtc = $tmp[2]."/".$tmp[1]."/".$tmp[0];	
}
$dtc = date("Y/m/d", strtotime($dtc));

if($_POST[dtc2]){
	$tmp = explode("/", $_POST[dtc2]);
	$dtc2 = $tmp[2]."/".$tmp[1]."/".$tmp[0];	
}
$dtc2 = date("Y/m/d", strtotime($dtc2));

if($_POST[dtc3]){
	$tmp = explode("/", $_POST[dtc3]);
	$dtc3 = $tmp[2]."/".$tmp[1]."/".$tmp[0];	
}
$dtc3 = date("Y/m/d", strtotime($dtc3));

	$sql = "UPDATE medicao_ambiental SET
	conclusao 	  = '$_POST[conclusao]',
	equipamento   = '$_POST[equip]',
	data_coleta   = '$dtc',
	data_coleta2  = '$dtc2',
	data_coleta3  = '$dtc3'
	WHERE id = $_GET[rid] AND id_ppra = $_GET[cod_cgrt]";
	if(pg_query($sql)){
		showmessage('Avaliação ambiental alterado com sucesso!');
	}
}

/***********************************************************************/
// BUSCA AS AVALIAÇÕES CADASTRADAS
/***********************************************************************/
$sql_dados = "SELECT m.*, a.analito, a.coletor
			FROM medicao_ambiental m, amostragem a
			WHERE m.id = $_GET[rid]
			AND m.id_amostragem = a.id";
$result_dados = pg_query($connect, $sql_dados);
$row_dados = pg_fetch_array($result_dados);

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Editar Avaliação Ambiental:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
	echo "<form method=post name=frmedit_avaliacao id=frmedit_avaliacao >";
		echo "<td align=center class='text roundborderselected'>";

		    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
			echo "<tr>";
				echo "<td class='text' >Houve Avaliação:</td>";
				echo "<td class='text' ><select name=avaliacao id=avaliacao onChange=\"avl(this);\">
						<option ></option>
						<option value='sim'"; if($row_dados[avaliacao] == 'sim') echo " 'selected' "; echo ">Sim</option>
						<option value='nao'"; if($row_dados[avaliacao] == 'nao') echo " 'selected' "; echo ">Não</option>
						</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Avaliação:</td>";
				echo "<td class='text' ><select name=analito id=analito style=\"width:250px;\" onChange=\"noci(this.value);\">";
					$anali = "SELECT id, analito FROM amostragem";
					$re_anali = pg_query($connect, $anali);
					//echo "<option></option>";
					while($r_anali = pg_fetch_array($re_anali)){
						if($r_anali[id] <> $row_dados[id_amostragem]){
							//echo "<option value='$r_anali[analito]'> $r_anali[analito] <option>"; 
						}else{
							echo "<option value='$r_anali[analito]' selected> $r_anali[analito] </option>";
						}
					}
				echo "</select> </td>";
				$coleta = "SELECT * FROM amostragem WHERE id = $row_dados[id_amostragem]";
				$col = pg_query($connect, $coleta);
				echo "<td class='text' >Coletor:</td>";
				echo "<td class='text' ><select name=coletor id=coletor style=\"width:250px;\" onChange=\"clt(this.value);\">";
					while($row = pg_fetch_array($col)){
						if($row[id] == $row_dados[id_amostragem])
							echo "<option value=\"$row[id]\" selected> $row[coletor] </option>";
						else
							echo "<option value=\"$row[id]\"> $row[coletor] </option>";
					}
				echo "</select> </td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Vazão:</td>";
				echo "<td class='text' ><input type=text size=5 readonly=true value='$row_dados[vazao]'></td>";
				echo "<td class='text' >Volume:</td>";
				echo "<td class='text' ><input type=text size=5 readonly=true value='$row_dados[volume]'></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Equipamento:</td>";
				echo "<td class='text' ><select name=equip id=equip style=\"width:250px;\">";
					echo "<option value='e1'"; if($row_dados[equip] == 'e1') echo " 'selected' "; echo ">Bomba de amostragem marca Gillian</option>";
					echo "<option value='e2'"; if($row_dados[equip] == 'e2') echo " 'selected' "; echo ">Dosímetro DOS 500</option>";
				echo "</select> </td>";
				echo "<td class='text' >Data da 1ª coleta:</td>";
				echo "<td class='text' ><input id='dtc' type='text' name='dtc' size='18' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" value='".date("d/m/Y", strtotime($row_dados[data_coleta]))."' ></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Data da 2ª coleta:</td>";
				echo "<td class='text' ><input id='dtc2' type='text' name='dtc2' size='18' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" value='";if($row_dados[data_coleta2] != '1969-12-31'){ echo date("d/m/Y", strtotime($row_dados[data_coleta2])); }else{ echo '';} echo "' ></td>";
				echo "<td class='text' >Data da 3ª coleta:</td>";
				echo "<td class='text' ><input id='dtc3' type='text' name='dtc3' size='18' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" value='";if($row_dados[data_coleta3] != '1969-12-31'){ echo date("d/m/Y", strtotime($row_dados[data_coleta3])); }else{ echo '';} echo "'></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Conclusão:</td>";
				echo "<td class='text' colspan=3 ><select name=conclusao id=conclusao style=\"width:595px;\">";
					echo "<option></option>";
					echo "<option value='1'"; if($row_dados[conclusao] == '1') echo " 'selected' "; echo ">Há incidência de Metais no ambiente, contudo não foi encontrado nenhum nível acima do limite permitido, não caracterizando insalubridade por parte de metais encontrados no ambiente.</option>";
					echo "<option value='2'"; if($row_dados[conclusao] == '2') echo " 'selected' "; echo ">Há incidência de Metais no ambiente, e foi encontrado nível acima do limite permitido, caracterizando insalubridade por parte de metais encontrados no ambiente.</option>";
					echo "<option value='3'"; if($row_dados[conclusao] == '3') echo " 'selected' "; echo ">Não há incidência de Metais no ambiente.</option>";
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
/*$sql_dados = "SELECT m.*, a.analito, a.coletor
FROM medicao_ambiental m, amostragem a
WHERE id_ppra = $_GET[cod_cgrt]
AND cod_setor = $_GET[cod_setor]
AND m.id_amostragem = a.id";
$result_dados = pg_query($connect, $sql_dados);
$row_dados = pg_fetch_all($result_dados);
	
if($row_dados != ""){
echo "<table width=100% border=0 cellpadding=2 cellspacing=2 >
<tr>
	<td align=center class='text'><b>Avaliação Ambiental cadastrado</b></td>
</tr>";
	echo "</table>";
	echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
	echo "<tr>";
	echo "<td align=left class='text'>";

	echo "<table width=100% border=0 cellpadding=2 cellspacing=2 >";
	for($i=0;$i<pg_num_rows($result_dados);$i++){
	
		echo "<tr>
				<td colspan=4 class='text roundborderselected'>
				<b><u><a href='?dir=cgrt&p=index&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_avaliacao&remove={$row_dados[$i]['id']}' alt='Excluir esta avaliação ambiental' title='Excluir esta avaliação ambiental'>Excluir</a></u>&nbsp; 
				<u><a href='?dir=cgrt&p=index&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_edit_avaliacao&rid={$row_dados[$i]['id']}'>Editar</a></u></b></td>
			 </tr>";
		echo "<tr>
				<td width=15% class='text roundborderselected' align=right> Analito:</td>
				<td width=35% class='text roundborderselected'><b> {$row_dados[$i][analito]} </td>
			    <td width=15% class='text roundborderselected' align=right> Coletor:</td>
				<td width=35% class='text roundborderselected'><b> {$row_dados[$i][coletor]} </td>
			 </tr>";
		echo "<tr>
				<td class='text roundborderselected' align=right> Vazão:</td>
				<td class='text roundborderselected'><b> {$row_dados[$i][vazao]} </td>
			    <td class='text roundborderselected' align=right> Volume:</td>
				<td class='text roundborderselected'><b> {$row_dados[$i][volume]} </td>
			 </tr>";
		echo "<tr>
				<td class='text roundborderselected' align=right> Equipamento:</td>
				<td class='text roundborderselected'><b> ";
				if($row_dados[$i][equipamento] == 'e1'){
					echo "Bomba de amostragem marca Gillian";
				}else{
					echo "Dosímetro DOS 500";
				}
				echo " </td>
			    <td class='text roundborderselected' align=right> 1ª coleta:</td>
				<td class='text roundborderselected'><b> ".date("d/m/Y", strtotime($row_dados[$i][data_coleta]))." </td>
			 </tr>";
		echo "<tr>
				<td class='text roundborderselected' align=right> 2ª coleta:</td>
				<td class='text roundborderselected'><b> ";
				if($row_dados[$i][data_coleta2] == "1969-12-31"){
					echo "&nbsp;";
				}else{
					echo date("d/m/Y", strtotime($row_dados[$i][data_coleta2]));
				}
				echo "</td>
			    <td class='text roundborderselected' align=right> 3ª coleta:</td>
				<td class='text roundborderselected'><b> ";
				if($row_dados[$i][data_coleta3] == "1969-12-31"){
					echo "&nbsp;";
				}else{
					echo date("d/m/Y", strtotime($row_dados[$i][data_coleta3]));
				}
				echo "</td>
			 </tr>";
		echo "<tr>
				<td class='text roundborderselected' align=right> Conclusão:</td>
				<td colspan=3 class='text roundborderselected'><b>";
				if($row_dados[$i][conclusao] == 1){
					echo "Há incidência de Metais no ambiente, contudo não foi encontrado nenhum nível acima do limite permitido, não caracterizando insalubridade por parte de metais encontrados no ambiente.";
				}elseif($row_dados[$i][conclusao] == 2){
					echo "Há incidência de Metais no ambiente, e foi encontrado nível acima do limite permitido, caracterizando insalubridade por parte de metais encontrados no ambiente.";
				}else{
					echo "Não há incidência de Metais no ambiente.";
				}
				echo "</td>
			 </tr>";
		echo "<tr>
				<td colspan=4> &nbsp; </td>
			 </tr>";
	}
}  */ 
	echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";
	
echo "</td>";
echo "</form>";
echo "</tr>";
echo "</table>";
?>