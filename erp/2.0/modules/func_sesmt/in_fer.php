<?PHP
if($_GET[remove]){
$del = "DELETE FROM ferias_sesmt WHERE id = {$_GET[remove]}";
pg_query($connect, $del);

showmessage('Férias do Colaborador Excluido com Sucesso!');
}




$codfunc = $_GET[funcionario_id];


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

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Férias</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

				echo "<table border=0 cellpadding=2 cellspacing=3 width=100%><tbody>";
				echo "<tr><td class=roundbordermix text align=left height=30>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
				echo "<td class='text' align=center><input type='button' class='btn' name='btnAlt' value='Incluir' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=al_fer';\"  onmouseover=\"showtip('tipbox', '- Permite incluir/alterar as férias do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
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
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>Férias</b></td>";
        echo "</tr>";
        echo "</table>";
        
	$query_func = "SELECT * FROM ferias_sesmt WHERE funcionario_id = {$_GET[funcionario_id]}";
	$result_func = pg_query($connect, $query_func);
	$list = pg_fetch_all($result_func);
	
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=150><b>Relativas ao período:</b></td>";
		echo "<td align=left class='text' width=30><b>dias:</b></td>";
        echo "<td align=left class='text' width=150><b>Início e término:</b></td>";
		echo "<td align=left class='text' width=10><b>&nbsp;</b></td>";
        echo "</tr>";
        for($i=0;$i<pg_num_rows($result_func);$i++){
			
			
			$ipartes = explode("-", $list[$i][inicio]);
			$imes = $ipartes[1];
			$iano = $ipartes[0];
			
			$tpartes = explode("-", $list[$i][termino]);
			$tmes = $tpartes[1];
			$tano = $tpartes[0];
			
			
            echo "<tr class='text roundbordermix'>";
            echo "<td align=left class='text roundborder curhand' >{$list[$i]['periodo1']}/{$list[$i]['periodo2']}&nbsp;</td>";
			echo "<td align=left class='text roundborder curhand' >{$list[$i]['dias']}&nbsp;</td>";
            echo "<td align=left class='text roundborder curhand' ><a href='modules/func_sesmt/folhaponto/".$codfunc.".php?mes=".$imes."&ano=".$iano."'>".date("d/m/Y", strtotime($list[$i][inicio]))."</a> à <a href='modules/func_sesmt/folhaponto/".$codfunc.".php?mes=".$tmes."&ano=".$tano."'>".date("d/m/Y", strtotime($list[$i][termino]))."</a>&nbsp;</td>";
            echo "<td align=center class='text roundborder '><a href='?dir=func_sesmt&p=a_reg&remove={$list[$i]['id']}&p=in_fer' >Excluir</a></td>";
            echo "</tr>";
        }
        echo "</table>";

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>