<?PHP
if($_GET[remove]){
$del = "DELETE FROM alt_sal WHERE id = {$_GET[remove]}";
pg_query($connect, $del);

showmessage('Sal�rio do Colaborador Excluido com Sucesso!');
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
                    echo "<b>Op��es</b>";
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
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnAlt' value='Alterar Sal�rio' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=in_sal';\"  onmouseover=\"showtip('tipbox', '- Permite incluir/alterar o sal�rio do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnfer' value='F�rias' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=in_fer';\"  onmouseover=\"showtip('tipbox', '- Permite visualizar as f�rias do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
				echo "<tr>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnFrdf' value='Rela��o Doc.' onclick=\"window.open('./modules/func_sesmt/frdf.php?funcionario_id=$_GET[funcionario_id]&p=frdf', 'SESMT', 'height=1030, width=760, scrollbars = yes, status=yes, toolbar = yes, menubar=yes');\"  onmouseover=\"showtip('tipbox', '- Permite visualizar a rela��o de documentos necess�rios para admiss�o do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCont' value='Contrato Public.' onclick=\"window.open('../../contratos/publicidade.php?fid=$_GET[funcionario_id]', 'SESMT', 'height=1030, width=760, scrollbars = yes, status=yes, toolbar = yes, menubar=yes');\" onmouseover=\"showtip('tipbox', '- Permite visualizar o contrato de publicidade do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                echo "</tr>";
                echo "</table>";
				
				echo "</td></tr></tbody></table>";
				echo "<p>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Alterar Sal�rio</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

				echo "<table border=0 cellpadding=2 cellspacing=3 width=100%><tbody>";
				echo "<tr><td class=roundbordermix text align=left height=30>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
				echo "<td class='text' align=center><input type='button' class='btn' name='btnAlt' value='Incluir' onclick=\"location.href='?dir=func_sesmt&p=a_reg&funcionario_id=$_GET[funcionario_id]&p=al_sal';\"  onmouseover=\"showtip('tipbox', '- Permite incluir/alterar o sal�rio do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
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
        echo "<td align=center class='text roundborderselected'><b>Altera��o de Sal�rio</b></td>";
        echo "</tr>";
        echo "</table>";
        
	$query_func = "SELECT * FROM alt_sal WHERE funcionario_id = {$_GET[funcionario_id]} ORDER BY data";
	$result_func = @pg_query($connect, $query_func);
	$list = @pg_fetch_all($result_func);
	
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=70><b>Data:</b></td>";
		echo "<td align=left class='text' width=300><b>Import�ncia:</b></td>";
        echo "<td align=left class='text' width=60><b>MDH:</b></td>";
		echo "<td align=left class='text' width=10><b>&nbsp;</b></td>";
        echo "</tr>";
        for($i=0;$i<@pg_num_rows($result_func);$i++){
            echo "<tr class='text roundbordermix'>";
            echo "<td align=left class='text roundborder curhand' >".date("d/m/Y", strtotime($list[$i][data]))."&nbsp;</td>";
			echo "<td align=left class='text roundborder curhand' >".number_format($list[$i][salario], 2,',','.')."&nbsp;</td>";
            echo "<td align=left class='text roundborder curhand' >{$list[$i]['mdh']}&nbsp;</td>";
            echo "<td align=center class='text roundborder '><a href='?dir=func_sesmt&p=a_reg&remove={$list[$i]['id']}&p=in_sal&funcionario_id={$_GET[funcionario_id]}' >Excluir</a></td>";
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