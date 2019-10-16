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
	showmessage('Férias do Colaborador Incluído com Sucesso!');
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
                    echo "<b>Opções</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

				echo "<table border=0 cellpadding=2 cellspacing=3 width=100%><tbody>";
				echo "<tr><td class=roundbordermix text align=left height=30>";
				
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnReg' value='Registro' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]';\"  onmouseover=\"showtip('tipbox', '- Permite alterar o registro do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnReg' value='Complemento' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=i_com';\"  onmouseover=\"showtip('tipbox', '- Permite registrar/alterar um complemento no cadastro do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnAlt' value='Alterar Salário' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=in_sal';\"  onmouseover=\"showtip('tipbox', '- Permite incluir/alterar o salário do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnfer' value='Férias' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=in_fer';\"  onmouseover=\"showtip('tipbox', '- Permite visualizar as férias do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnFrdf' value='Relação Doc.' onclick=\"window.open('./modules/func_sesmt/frdf.php?funcionario_id=$_GET[funcionario_id]&p=frdf', 'SESMT', 'height=1030, width=760, scrollbars = yes, status=yes, toolbar = yes, menubar=yes');\"  onmouseover=\"showtip('tipbox', '- Permite visualizar a relação de documentos necessários para admissão do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCont' value='Contrato Public.' onclick=\"window.open('../../contratos/publicidade.php?fid=$_GET[funcionario_id]', 'SESMT', 'height=1030, width=760, scrollbars = yes, status=yes, toolbar = yes, menubar=yes');\" onmouseover=\"showtip('tipbox', '- Permite visualizar o contrato de publicidade do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
                echo "</table>";
				
				echo "</td></tr></tbody></table>";
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
        echo "<td align=center class='text roundborderselected'><b>Registrar Férias</b></td>";
        echo "</tr>";
        echo "</table><p>";
	    
		/**************************************************************************************************/
		// --> DADOS DAS FÉRIAS
		/**************************************************************************************************/
        
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 class='text roundborderselected'>";
        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Período inicial:</b></td>";
        echo "<td align=left width=220><input id='periodo1' type='text' name='periodo1' size='18' ></td>";
		echo "<td align=left class='text' width=100><b>Período final:</b></td>";
        echo "<td align=left width=220><input id='periodo2' type='text' name='periodo2' size='18' ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Inicio:</b></td>";
        echo "<td align=left width=220><input id='dti' type='text' name='dti' size='18' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" ></td>";
		echo "<td align=left class='text' width=100><b>Término:</b></td>";
        echo "<td align=left width=220><input id='dtt' type='text' name='dtt' size='18' maxlength=10 onkeypress=\"formatar(this, '##/##/####');\" ></td>";
        echo "</tr>";

        echo "<tr>";
		echo "<td align=left class='text' width=100><b>Dias:</b></td>";
        echo "<td align=left width=220><input id='dias' type='text' name='dias' size='18' ></td>";
        echo "</tr>";

		echo "</table>";
		echo "<p>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='button' class='btn' name='btnBack' value='Voltar' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=in_fer';\"  onmouseover=\"showtip('tipbox', '- Voltar para listagem de férias do colaborador.');\" onmouseout=\"hidetip('tipbox');\">";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
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