<?PHP
if($_POST && !empty($_GET[funcionario_id])){
	
	$query_alterar_usuario = "UPDATE usuario SET
								grupo_id = '$grupo_id'
								, login = '$login'
								, senha = '$senha'
								WHERE funcionario_id = ".$_GET[funcionario_id];
	pg_query($connect, $query_alterar_usuario);
	
	$alterar_usuario = "UPDATE funcionario SET
								comissao = '$comissao'
								, cargo_id = '$cargo_id'
								WHERE funcionario_id = ".$_GET[funcionario_id];
	pg_query($connect, $alterar_usuario);

}
echo $grupo_id.'SDSDS';
echo "<script>
function calcula_horas(){
	if(document.getElementById('hora1').value != '' && document.getElementById('hora2').value != '' && document.getElementById('hora3').value != ''){
		var h1 = document.getElementById('hora1').value;
		var h2 = document.getElementById('hora2').value;
		var h3 = document.getElementById('hora3').value;
		h1 = h1.split(':');
		h2 = h2.split(':');
		h3 = h3.split(':');
		var ha = (((h2[0] * 60) + parseInt(h2[1])) - ((h1[0] * 60) + parseInt(h1[1])))-((h3[0]*60) + parseInt(h3[1]));
		
		//document.write(((ha*5)/60));
		var tt = ((ha)*5);
		document.getElementById('hora4').value = Math.floor((tt-60)/60) + ':' + (tt%60);
	}
}
</script>";

/***************************************************************************************************/
// --> BUSCA DA TABELA DE REGISTRO DE EMPREGADOS
/***************************************************************************************************/
$busca = "SELECT * FROM comp_reg_emp WHERE funcionario_id = ".$_GET[funcionario_id];
$bus = pg_query($connect, $busca);
$row_bus = pg_fetch_array($bus);

/***************************************************************************************************/
// --> BUSCA DA TABELA ALTERAÇÃO DE SALÁRIOS
/***************************************************************************************************/
$busca = "SELECT * FROM alt_sal WHERE funcionario_id = ".$_GET[funcionario_id]." ORDER BY id desc";
$alt = pg_query($busca);
$row_alt = pg_fetch_array($alt);

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Selecione uma opção</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
				
				echo "<table border=0 cellpadding=2 cellspacing=3 width=100%><tbody>";
				echo "<tr><td class=roundbordermix text align=left height=30>";
				
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Voltar' onclick=\"location.href='?dir=cad_col&p=index';\"  onmouseover=\"showtip('tipbox', '- Voltar para lista de colaboradores.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					
					echo "<td class='text' align=center></td>";

                echo "</tr>";
								
                echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnReg' value='Registro' onclick=\"location.href='?dir=cad_col&p=a_reg&funcionario_id=$_GET[funcionario_id]';\"  onmouseover=\"showtip('tipbox', '- Permite alterar o registro do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnReg' value='Complemento' onclick=\"location.href='?dir=cad_col&funcionario_id=$_GET[funcionario_id]&p=i_com';\"  onmouseover=\"showtip('tipbox', '- Permite registrar/alterar um complemento no cadastro do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnAlt' value='Alterar Salário' onclick=\"location.href='?dir=cad_col&funcionario_id=$_GET[funcionario_id]&p=in_sal';\"  onmouseover=\"showtip('tipbox', '- Permite incluir/alterar o salário do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnfer' value='Férias' onclick=\"location.href='?dir=cad_col&funcionario_id=$_GET[funcionario_id]&p=in_fer';\"  onmouseover=\"showtip('tipbox', '- Permite visualizar as férias do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				
				echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnFrdf' value='Relação Doc.' onclick=\"window.open('./modules/cad_col/frdf.php?funcionario_id=$_GET[funcionario_id]&p=frdf', 'SESMT', 'height=1030, width=760, scrollbars = yes, status=yes, toolbar = yes, menubar=yes');\"  onmouseover=\"showtip('tipbox', '- Permite visualizar a relação de documentos necessários para admissão do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnAc' value='Inf. de Acesso' onclick=\"location.href='?dir=cad_col&p=i_ac&funcionario_id=$_GET[funcionario_id]';\"  onmouseover=\"showtip('tipbox', '- Informações de acesso do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				
                echo "</table>";
				echo "</td></tr></tbody></table><br />";
				
				
				$query_func = "SELECT f.*, u.* FROM funcionario f, usuario u WHERE f.funcionario_id = u.funcionario_id ORDER BY f.nome";
				$result_func = pg_query($connect, $query_func);
				$list = pg_fetch_all($result_func);
			
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
				echo "<td align=left class='text'><b>Lista de funcionários:</b></td>";
				echo "</tr>";
				for($i=0;$i<pg_num_rows($result_func);$i++){
					if($list[$i][status] == 0){
						$bg = "bgcolor=#CD0000'";				
					}else{
						$bg = "";	
					}
					echo "<tr class='text roundbordermix'>";
					echo "<td align=left $bg class='text roundborder curhand' onclick=\"location.href='?dir=cad_col&p=a_reg&funcionario_id={$list[$i]['funcionario_id']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>{$list[$i]['nome']}&nbsp;</td>";
					echo "</tr>";
				}
				echo "</table>";


                // --> TIPBOX
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
        echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
	
	$sql = "SELECT * FROM usuario u, funcionario f WHERE u.funcionario_id = ".$_GET[funcionario_id]." AND f.funcionario_id = ".$_GET[funcionario_id]."";
	$query = pg_query($sql);
	$row = pg_fetch_array($query);
	
		echo "<form name=form1 method=post enctype='multipart/form-data'>";
		/**************************************************************************************************/
		// --> DADOS COMPLEMENTARES
		/**************************************************************************************************/
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text'>";
		echo "<b>Dados de Acesso:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";

	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		
		echo "<td align=left class='text' width=100><b>Cargo:</b></td>";
        echo "<td align=left width=220><select class=inputTextobr name=cargo_id id=cargo_id style=\"width: 220px\">
			 <option value=''>Cargo</option>";
			 $query_cargo="SELECT * FROM cargo ORDER BY nome";
			 $result_cargo=pg_query($connect, $query_cargo);
			 while($row_cargo=pg_fetch_array($result_cargo)){ 
			 	if($row_cargo[cargo_id]<>$row[cargo_id]){
			 		echo "<option value='{$row_cargo[cargo_id]}'> $row_cargo[nome] </option>";
				}else{
					echo "<option value='{$row_cargo[cargo_id]}' selected> $row_cargo[nome] </option>";
				}
			 }
		echo "</select></td>";
        echo "<td align=left class='text' width=100><b>Grupo:</b></td>";
        echo "<td align=left width=220><select class=inputTextobr name=grupo_id id=grupo_id style=\"width: 200px\">
			 <option value=''>Grupo</option>";
			 $query_grupo="SELECT * FROM grupo ORDER BY nome";
			 $result_grupo=pg_query($connect, $query_grupo);
			 while($row_grupo=pg_fetch_array($result_grupo)){ 
			 	if($row_grupo[grupo_id]==$row[grupo_id]){
			 		echo "<option value='{$row_grupo[grupo_id]}' selected> $row_grupo[nome] </option>";
				}else{
					echo "<option value='{$row_grupo[grupo_id]}'> $row_grupo[nome] </option>";
				}
			 }
		echo "</select></td>";
        echo "</tr>";

        echo "<tr>";

		
        echo "<td align=left class='text' width=100><b>Cod. Chave:</b></td>";
        echo "<td align=left width=220><input disabled='disabled' id='cod' type='text' name='cod' value='{$row[cod_vendedor]}' size='31'></td>";

        echo "<td align=left class='text' width=100><b>Comissão(%):</b></td>";
        echo "<td align=left width=220><input id='comissao' type='text' name='comissao' value='{$row[comissao]}' size='27'></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Login:</b></td>";
        echo "<td align=left class='text' width=220><input class='' id='login' type='text' name='login' value='{$row[login]}' size='31'></td>";
        echo "<td align=left class='text' width=100><b>Senha:</b></td>";
        echo "<td align=left class='text' width=220><input class='' id='senha' type='text' name='senha' value='{$row[senha]}' size='27' ></td>";
        echo "</tr>";
		
        echo "</table>";

		echo "<p>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='button' class='btn' name='btnBack' value='Voltar' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]';\"  onmouseover=\"showtip('tipbox', '- Voltar para tela de alteração de registro de colaboradores.');\" onmouseout=\"hidetip('tipbox');\">";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<input type='submit' class='btn' name='btnSave' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
					echo "</td>";
				echo "</tr>";
				echo "</table>";
			echo "</tr>";
		echo "</table>";

		echo "</form>";

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>