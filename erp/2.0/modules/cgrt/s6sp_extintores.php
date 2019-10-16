<?php
if($_GET[remove]){
	$del = "DELETE FROM extintor WHERE cod_extintor = {$_GET[remove]}";
	if(pg_query($connect, $del)){
		showmessage('Cadastro do extintor excluido com sucesso!');
	}
}

if(  $_POST['btnSaveExt']){
	$antes = "SELECT desc_resumida_prod FROM produto WHERE cod_prod = {$_POST[cod_produto]}";
	$r_antes = pg_query($connect, $antes);
	$rr = pg_fetch_array($r_antes);
	if($_POST['extintor'] == "existente"){
		$sql = "INSERT INTO extintor(extintor, tipo_extintor, cod_produto, qtd_extintor, data_recarga, numero_cilindro, cod_cliente, cod_setor,
			vencimento_abnt, proxima_carga, placa_sinalizacao_id, demarcacao_solo_id, tipo_instalacao_id, empresa_prestadora, f_inspecao, id_ppra)
			VALUES
			('$extintor', '$rr[desc_resumida_prod]', $cod_produto, '$qtd_extintor', '$data_recarga', '$numero_cilindro', $_GET[cod_cliente], $_GET[cod_setor],
			'$vencimento_abnt', '$proxima_carga', $placa_sinalizacao_id, $demarcacao_solo_id, $tipo_instalacao_id, '$empresa_prestadora', '$f_inspecao', $_GET[cod_cgrt])";
	}else{
		$sql = "INSERT INTO extintor(extintor, tipo_extintor, cod_produto, qtd_extintor, data_recarga, numero_cilindro, cod_cliente, cod_setor,
			vencimento_abnt, proxima_carga, placa_sinalizacao_id, demarcacao_solo_id, tipo_instalacao_id, empresa_prestadora, f_inspecao, id_ppra)
			VALUES
			('$extintor', '$rr[desc_resumida_prod]', $cod_produto, '$qtd_extintor', '$data_recarga', '$numero_cilindro', $_GET[cod_cliente], $_GET[cod_setor],
			'$vencimento_abnt', '$proxima_carga', 0, 0, 0, '$empresa_prestadora', '$f_inspecao', $_GET[cod_cgrt])";
	}
	if(pg_query($connect, $sql)){
		showmessage("Informações Cadastradas com Sucesso!");
	}
}

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Dados do Extintor:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
	echo "<form method=post name=frmExtintor id=frmExtintor action='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_extintores' onsubmit=\"return extin(this);\">";
		echo "<td align=center class='text roundborderselected'>";

		    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
			echo "<tr>";
				echo "<td align=left class='text' width=150>Extintor:</td>";
					echo "<td align=left class='text'><select name='extintor' id='extintor' onBlur=\"sugerir(this);\">";
					echo "<option value=''></option>";
					echo "<option value='existente' onBlur=\"existente();\">Existente</option>";
					echo "<option value='sugerido' onBlur=\"sugerido();\">Sugerido</option>";
				echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' width=350>Tipo:</td>";
					echo "<td align=left class='text'><select name='cod_produto' id='cod_produto'>";
					$extintor = "select cod_prod, desc_resumida_prod from produto
								where (cod_atividade = 1 and desc_resumida_prod like '%Extintor%') OR cod_atividade = 6 order by desc_resumida_prod";
					$result_extintor = pg_query($extintor);
					echo "<option value=''></option>";
					while($row_extintor = pg_fetch_array($result_extintor)) {
						echo "<option value=\"$row_extintor[cod_prod]\">". ucwords(strtolower($row_extintor[desc_resumida_prod]))."</option>";
					}
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Quantidade:</td>";
				echo "<td class='text' ><input type=text name='qtd_extintor' id='qtd_extintor' size=5></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Data da Recarga:</td>";
				echo "<td class='text' ><input type=text name='data_recarga' id='data_recarga' size=10 maxlength=10 onChange=\"dataRecarga();\" OnKeyPress=\"formatar(this, '##/##/####')\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td class='text' >Nº do Cilindro:</td>";
				echo "<td class='text' ><input type=text name='numero_cilindro' id='numero_cilindro' size=10></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Venc. ABNT:</td>";
				echo "<td class='text' ><input type=text name='vencimento_abnt' id='vencimento_abnt' size=5 OnKeyPress=\"formatar(this, '##/####')\"></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Próx. Carga:</td>";
				echo "<td class='text' ><input type=text name='proxima_carga' id='proxima_carga' size=10></td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Placa de Sinalização:</td>";
				echo "<td class='text' ><select name='placa_sinalizacao_id' id='placa_sinalizacao_id'>";
					$placa = "SELECT * FROM placa_sinalizacao order by placa_sinalizacao";
					$result_placa = pg_query($placa);
					echo "<option value=''></option>";
					while($row_placa = pg_fetch_array($result_placa)) {
						echo "<option value=\"$row_placa[placa_sinalizacao_id]\">". ucwords(strtolower($row_placa[placa_sinalizacao]))."</option>";
					}
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Demarcação de Solo:</td>";
				echo "<td align=left class='text'><select name='demarcacao_solo_id' id='demarcacao_solo_id'>";
					$solo = "SELECT * FROM demarcacao_solo order by demarcacao_solo_id";
					$result_solo = pg_query($solo);
					echo "<option value=''></option>";
					while($row_solo = pg_fetch_array($result_solo)) {
						echo "<option value=\"$row_solo[demarcacao_solo_id]\">". $row_solo[demarcacao_solo]."</option>";
					} 
					echo "</select>"; 
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Tipo de Instalação:</td>";
				echo "<td align=left class='text'><select name='tipo_instalacao_id' id='tipo_instalacao_id'>";
					$instal = "SELECT * FROM tipo_instalacao order by tipo_instalacao_id";
					$result_instal = pg_query($instal);
					echo "<option value=''></option>";
					while($row_instal = pg_fetch_array($result_instal)) {
						echo "<option value=\"$row_instal[tipo_instalacao_id]\">". $row_instal[tipo_instalacao]."</option>";
					}  
					echo "</select>";
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >Ficha de Inspeção:</td>";
				echo "<td align=left class='text'><select name='f_inspecao' id='f_inspecao'>";
					echo "<option value=''></option>";
					echo "<option value='sim'>Sim</option>";
					echo "<option value='nao'>Não</option>";
					echo "</select>"; 
				echo "</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=left class='text' >";
					echo "Empresa Prestadora dos Serviços:</td>";
					echo "<td align=left class='text'><input type=text name='empresa_prestadora' id='empresa_prestadora' size=50>";
				echo "</td>";
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
		echo "<input type='submit' class='btn' name='btnSaveExt' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" ></td>";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

/************************************************************************************************************/
// - > EXTINTOR JÁ CADASTRADO
/************************************************************************************************************/
$query_func = "SELECT * FROM extintor 
			  WHERE id_ppra = $_GET[cod_cgrt] 
			  AND cod_setor = $_GET[cod_setor]";
$result_func = pg_query($connect, $query_func);
$r=pg_fetch_all($result_func);

if($r != ""){
echo "<table width=100% border=0 cellpadding=2 cellspacing=2 >
<tr>
	<td align=center class='text'><b>Extintor Cadastrado</b></td>
</tr>";
	echo "</table>";
	echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
	echo "<tr>";
	echo "<td align=left class='text'>";

	echo "<table width=100% border=0 cellpadding=2 cellspacing=2 >";
	for($i=0;$i<pg_num_rows($result_func);$i++){
		echo "<tr>
			<td class='text roundborderselected'>Tipo:<b> {$r[$i][tipo_extintor]}</b></td>
			<td class='text roundborderselected'>Qtd:<b> {$r[$i][qtd_extintor]}</b></td>
			<td class='text roundborderselected'>Dt da Recarga:<b> {$r[$i][data_recarga]}</b></td>
			<td align=center class='text roundborderselectedred '><a href='?dir=cgrt&p=index&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]&sp=s6sp_extintores&remove={$r[$i]['cod_extintor']}' alt='Excluir este cadastro' title='Excluir este cadastro'><span style=\"font-size: 8px;\">X</span></a></td>
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