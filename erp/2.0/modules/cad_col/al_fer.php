<?PHP
if($_POST && !empty($_GET[funcionario_id])){
	if($_POST[dti]){
            $tmp = explode("/", $_POST[dti]);
    	    $dti = $tmp[2]."/".$tmp[1]."/".$tmp[0];
	}
	
	if($_POST[dtt]){
            $tmp = explode("/", $_POST[dtt]);
    	    $dtt = $tmp[2]."/".$tmp[1]."/".$tmp[0];
	}
	
	$query_incluir = "INSERT INTO ferias_sesmt
					 (funcionario_id, periodo1, periodo2, dias, inicio, termino)
					 VALUES 
					 ($funcionario_id, '$periodo1', '$periodo2', '$dias', '$dti', '$dtt')";
		
	pg_query($connect, $query_incluir);
	showmessage('F?rias do Colaborador Inclu?do com Sucesso!');
}

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
                    echo "<b>Op??es</b>";
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
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnAlt' value='Alterar Sal?rio' onclick=\"location.href='?dir=cad_col&funcionario_id=$_GET[funcionario_id]&p=in_sal';\"  onmouseover=\"showtip('tipbox', '- Permite incluir/alterar o sal?rio do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnfer' value='F?rias' onclick=\"location.href='?dir=cad_col&funcionario_id=$_GET[funcionario_id]&p=in_fer';\"  onmouseover=\"showtip('tipbox', '- Permite visualizar as f?rias do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				
				echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnFrdf' value='Rela??o Doc.' onclick=\"window.open('./modules/cad_col/frdf.php?funcionario_id=$_GET[funcionario_id]&p=frdf', 'SESMT', 'height=1030, width=760, scrollbars = yes, status=yes, toolbar = yes, menubar=yes');\"  onmouseover=\"showtip('tipbox', '- Permite visualizar a rela??o de documentos necess?rios para admiss?o do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnAc' value='Inf. de Acesso' onclick=\"location.href='?dir=cad_col&p=i_ac&funcionario_id=$_GET[funcionario_id]';\"  onmouseover=\"showtip('tipbox', '- Informa??es de acesso do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				
                echo "</table>";
				echo "</td></tr></tbody></table><br />";
				
				
				$query_func = "SELECT f.*, u.* FROM funcionario f, usuario u WHERE f.funcionario_id = u.funcionario_id ORDER BY f.nome";
				$result_func = pg_query($connect, $query_func);
				$list = pg_fetch_all($result_func);
			
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
				echo "<td align=left class='text'><b>Lista de funcion?rios:</b></td>";
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
				echo "<p>";
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
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<form name=form1 method=post>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>Registrar F?rias</b></td>";
        echo "</tr>";
        echo "</table><p>";
	    
		/**************************************************************************************************/
		// --> DADOS DAS F?RIAS
		/**************************************************************************************************/
        
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Per?odo inicial:</b></td>";
        echo "<td align=left width=220><input id='periodo1' type='text' name='periodo1' size='32' ></td>";
		echo "<td align=left class='text' width=100><b>Per?odo final:</b></td>";
        echo "<td align=left width=220><input id='periodo2' type='text' name='periodo2' size='32' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Inicio:</b></td>";
        echo "<td align=left width=220><input id='dti' type='text' name='dti' size='32' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" ></td>";
		echo "<td align=left class='text' width=100><b>T?rmino:</b></td>";
        echo "<td align=left width=220><input id='dtt' type='text' name='dtt' size='32' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Dias:</b></td>";
        echo "<td align=left width=220><input id='dias' type='text' name='dias' size='32' ></td>";
        echo "</tr>";

		echo "</table>";
		echo "<p>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='button' class='btn' name='btnBack' value='Voltar' onclick=\"location.href='?dir=cad_col&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=in_fer';\"  onmouseover=\"showtip('tipbox', '- Voltar para listagem de f?rias do colaborador.');\" onmouseout=\"hidetip('tipbox');\">";//onclick=\"return confirm('Todos os dados ser?o salvos, tem certeza que deseja continuar?','');\"
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<input type='submit' class='btn' name='btnSave' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenar? todos os dados selecionados at? o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados ser?o salvos, tem certeza que deseja continuar?','');\"
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