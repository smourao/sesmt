<?php
if( $_POST['btnSaveEpc'] ){
	$epc_existente 	= $_POST["epc_existente"];
	$epc_sugerido 	= $_POST["epc_sugerido"];
	$epc_eficaz		= $_POST["epc_eficaz"];
	$ca				= $_POST["ca"];
	$h_melhoria		= $_POST["h_melhoria"];
	$h_acidente		= $_POST["h_acidente"];
	//$pic			= $_POST["foto"];
	$equip_util		= $_POST["equip_util"];
	$fer_util		= $_POST["fer_util"];
	$carga_manu		= $_POST["carga_manu"];
	$ativ_rotina	= $_POST["ativ_rotina"];
	$verba			= $_POST["verba"];
	$sql = "UPDATE cliente_setor
			SET epc_existente  = '$epc_existente'
				, epc_sugerido = '$epc_sugerido'
				, epc_eficaz   = '$epc_eficaz'
				, ca		   = '$ca'
				, h_melhoria   = '$h_melhoria'
				, h_acidente   = '$h_acidente'
				, foto		   = '$pic'
				, equip_util   = '$equip_util'
				, fer_util	   = '$fer_util'
				, carga_manu   = '$carga_manu'
				, ativ_rotina  = '$ativ_rotina'
				, verba		   = '$verba'
			WHERE id_ppra      = $_GET[cod_cgrt] AND cod_setor = $_GET[cod_setor]";
	if(pg_query($sql)){
		showmessage('Dados do setor cadastrado com sucesso!');
	}
}

/*****************************************************************************************************/
// - > BUSCA OS DADOS DA TABELA CLIENTE_SETOR
/*****************************************************************************************************/
$cli = "SELECT epc_existente, epc_sugerido, epc_eficaz, ca, h_melhoria, h_acidente, foto, equip_util, fer_util, carga_manu, ativ_rotina, verba
        FROM cliente_setor cs, cliente c, setor s
        where cs.cod_cliente = c.cliente_id
        and cs.cod_setor = s.cod_setor
        and cs.id_ppra = $_GET[cod_cgrt]
        and cs.cod_setor = $_GET[cod_setor]";
$res_cli = pg_query($cli);
$row = pg_fetch_array($res_cli);
		
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Equipamento de Proteção Coletiva:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
	echo "<form method=post name=frmEpc id=frmEpc enctype='multipart/form-data'>";
		echo "<td align=center class='text roundborderselected'>";

			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
				echo "<td class='text' width=50%>EPC Existente:</td>";
				echo "<td class='text' width=50%>EPC Sugerido:</td>";
			echo "</tr>";
			echo "</table>";

			echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
			echo "<tr>";
				echo "<td class='text' width=50%><textarea name=epc_existente id=epc_existente cols=40 rows=2>". $row[epc_existente] ."</textarea></td>";
				echo "<td class='text' width=50%><textarea name=epc_sugerido id=epc_sugerido cols=40 rows=2>". $row[epc_sugerido] ."</textarea></td>";
			echo "</tr>";
			echo "</table>";
			
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
				echo "<td align=left class='text' width=15%>";
					echo "EPC é Eficaz?";
				echo "</td>";
				echo "<td align=left class='text' width=35%>";
					echo "<select name=epc_eficaz id=epc_eficaz style=\"width:50px;\">
						<option value=''></option>
						<option value='Sim'"; if($row[epc_eficaz] == "Sim") echo "selected"; echo ">Sim</option>
						<option value='Não'"; if($row[epc_eficaz] == "Não") echo "selected"; echo ">Não</option>
						</select>";
				echo "</td>";
				echo "<td align=left class='text' width=35%>";
					echo "Existe Certificado de Aprovação?";
				echo "</td>";
				echo "<td align=left class='text' width=15%>";
					echo "<select name=ca id=ca style=\"width:50px;\">
						<option value=''></option>
						<option value='Sim'"; if($row[ca] == "Sim") echo "selected"; echo ">Sim</option>
						<option value='Não'"; if($row[ca] == "Não") echo "selected"; echo ">Não</option>
						</select>";
				echo "</td>";
			echo "</tr>";
			echo "</table>";
		echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Histórico(APGRE):</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";			

			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
				echo "<td class='text' width=50%>Histórico de Melhoria:</td>";
				echo "<td class='text' width=50%>Histórico de Acidente:</td>";
			echo "</tr>";
			echo "</table>";

			echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
			echo "<tr>";
				echo "<td class='text' width=50%><textarea name=h_melhoria id=h_melhoria cols=40 rows=1>". $row[h_melhoria] ."</textarea></td>";
				echo "<td class='text' width=50%><textarea name=h_acidente id=h_acidente cols=40 rows=1>". $row[h_acidente] ."</textarea></td>";
			echo "</tr>";
			echo "</table>";
			
		echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Avaliação Preliminar(APGRE):</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";			

			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
				echo "<td class='text' width=50%>Máquina\Equip. Utilizado:</td>";
				echo "<td class='text' width=50%>Ferramentas Utilizadas:</td>";
			echo "</tr>";
			echo "</table>";

			echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
			echo "<tr>";
				echo "<td class='text' width=50%><textarea name=equip_util id=equip_util cols=40 rows=1>". $row[equip_util] ."</textarea></td>";
				echo "<td class='text' width=50%><textarea name=fer_util id=fer_util cols=40 rows=1>". $row[fer_util] ."</textarea></td>";
			echo "</tr>";
			echo "</table>";
			
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
				echo "<td class='text' width=50%>Material\Carga Manuseada:</td>";
				echo "<td class='text' width=50%>Atividade Não Rotineira:</td>";
			echo "</tr>";
			echo "</table>";

			echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
			echo "<tr>";
				echo "<td class='text' width=50%><textarea name=carga_manu id=carga_manu cols=40 rows=1>". $row[carga_manu] ."</textarea></td>";
				echo "<td class='text' width=50%><textarea name=ativ_rotina id=ativ_rotina cols=40 rows=1>". $row[ativ_rotina] ."</textarea></td>";
			echo "</tr>";
			echo "</table>";
			
			echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
				echo "<td class='text' width=50%>Verbalização:</td>";
				echo "<td class='text' width=50%>&nbsp;</td>";
			echo "</tr>";
			echo "</table>";

			echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
			echo "<tr>";
				echo "<td class='text' width=50%><textarea name=verba id=verba cols=40 rows=1>". $row[verba] ."</textarea></td>";
				echo "<td class='text' width=50%>&nbsp;</td>";
			echo "</tr>";
			echo "</table>";
			
		echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Incluir Foto do Posto de Trabalho(APGRE):</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";			

echo "<table width=30% border=1 >";
		//echo "<form name=form1 method=post enctype='multipart/form-data'>";
		echo "<tr>";
		echo "<td onclick=\"window.open('common/ajax_upload_apgre_pic.php', 'upload_pic', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=yes,width=350,height=250')\" style=\"cursor: pointer;\" align=center width=200 height=200>";
		if(empty($row[foto])){
			echo "<div id=foto name=foto><b>imagem</b><p><font size=1>Clique para inserir!</font></p></div>";
		}else{
			echo "<div id=foto name=foto><img src='$row[foto]' border=0 width=200 height=200></div>";
		}
		echo "</td></tr></table>";
		echo "<input name=pic id=pic value='$row[foto]' type=hidden>";
		
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
		echo "<input type='submit' class='btn' name='btnSaveEpc' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" ></td>";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
echo "</td>";
echo "</tr>";
echo "</table>";
	
echo "</td>";
echo "</form>";
echo "</tr>";
echo "</table>";

?>