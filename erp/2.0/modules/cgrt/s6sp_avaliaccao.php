<?php
if($_GET[remove]){
	$del = "DELETE FROM medicao_ambiental WHERE id = {$_GET[remove]}";
	if(pg_query($connect, $del)){
		showmessage('Avaliação ambiental excluido com sucesso!');
	}
}

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

if( $_POST['btnSaveAgen'] ){

	$sql = "INSERT INTO medicao_ambiental
		   (id_ppra, cod_cliente, cod_setor, id_amostragem, avaliacao, vazao, volume, conclusao, equipamento, data_coleta, data_coleta2,
		   data_coleta3)
    	   VALUES 
		   ($_GET[cod_cgrt], $_GET[cod_cliente], $_GET[cod_setor], $coletor, '$avaliacao', '$vazao_m', '$volume', '$conclusao', '$equip',
		   '$dtc', '$dtc2', '$dtc3')";
	$result = pg_query($sql);
	if($result){
		showmessage('Avaliação ambiental cadastrado com sucesso!');
	}
}

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Avaliação Ambiental:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
	echo "<form method=post name=frmagentes_nocivos id=frmagentes_nocivos action='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_avaliacao' onsubmit=\"return ava_amb(this);\">";
		echo "<td align=center class='text roundborderselected'>";

		    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
			echo "<tr>";
				echo "<td class='text' >Houve Avaliação:</td>";
				echo "<td class='text' ><select name=avaliacao id=avaliacao onChange=\"avl(this);\">
						<option ></option>
						<option value='sim'>Sim</option>
						<option value='nao'>Não</option>
						</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Avaliação:</td>";
				echo "<td class='text' ><select name=analito id=analito style=\"width:250px;\" onChange=\"noci(this.value);\">";
					$anali = "SELECT distinct(analito) FROM amostragem";
					$re_anali = pg_query($connect, $anali);
					echo "<option></option>";
					while($r_anali = pg_fetch_array($re_anali)){
						echo "<option value='$r_anali[analito]'> $r_anali[analito] </option>";
					}
				echo "</select> </td>";
				echo "<td class='text' >Coletor:</td>";
				echo "<td class='text' ><select name=coletor id=coletor style=\"width:250px;\" onChange=\"clt(this.value);\">";
					echo "<option></option>";
				echo "</select> </td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Vazão:</td>";
				echo "<td class='text' ><select name=vazao_m id=vazao_m style=\"width:80px;\">";
					echo "<option></option>";
				echo "</select> </td>";
				echo "<td class='text' >Volume:</td>";
				echo "<td class='text' ><select name=volume id=volume style=\"width:80px;\">";
					echo "<option></option>";
				echo "</select> </td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Equipamento:</td>";
				echo "<td class='text' ><select name=equip id=equip style=\"width:250px;\">";
					echo "<option></option>";
					echo "<option value='e1'>Bomba de amostragem marca Gillian</option>";
					echo "<option value='e2'>Dosímetro DOS 500</option>";
				echo "</select> </td>";
				echo "<td class='text' >Data da 1ª coleta:</td>";
				echo "<td class='text' ><input id='dtc' type='text' name='dtc' size='18' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" ></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Conclusão:</td>";
				echo "<td class='text' colspan=3 ><select name=conclusao id=conclusao style=\"width:595px;\">";
					echo "<option></option>";
					echo "<option value=1>Há incidência de Metais no ambiente, contudo não foi encontrado nenhum nível acima do limite permitido, não caracterizando insalubridade por parte de metais encontrados no ambiente.</option>";
					echo "<option value=2>Há incidência de Metais no ambiente, e foi encontrado nível acima do limite permitido, caracterizando insalubridade por parte de metais encontrados no ambiente.</option>";
					echo "<option value=3>Não há incidência de Metais no ambiente.</option>";
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
$sql_dados = "SELECT m.*, a.analito, a.coletor
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