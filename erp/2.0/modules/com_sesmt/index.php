<?PHP
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
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Voltar' onclick=\"location.href='?dir=com_sesmt&p=index';\"  onmouseover=\"showtip('tipbox', '- Voltar para lista de colaboradores.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                    echo "<td class='text' height=30 align=center><input type='button' class='btn' name='btnReg' value='Repasse CGRT' onclick=\"location.href='?dir=com_sesmt&p=cgrt';\"  onmouseover=\"showtip('tipbox', '- Permite alterar o registro do colaborador da SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
					echo "<td class='text' align=center></td>";

                echo "</tr>";
								
                echo "</table>";
				echo "</td></tr></tbody></table><br />";
				
				
				//$query_func = "SELECT f.*, u.* FROM funcionario f, usuario u WHERE f.funcionario_id = u.funcionario_id AND f.funcionario_id <> 18 AND u.funcionario_id <> 18 AND f.status = 1 AND f.associada_id = 1 AND f.grupo_id = 1 ORDER BY f.nome";
				
				$query_func = "SELECT f.*, u.* FROM funcionario f, usuario u WHERE f.funcionario_id = u.funcionario_id AND  f.status = 1 AND f.associada_id = 1 AND f.grupo_id = 1 ORDER BY f.nome";
				$result_func = pg_query($connect, $query_func);
				$list = pg_fetch_all($result_func);
			
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
				echo "<td align=left class='text'><b>Lista de funcionários:</b></td>";
				echo "</tr>";
				for($i=0;$i<pg_num_rows($result_func);$i++){
					if($list[$i][funcionario_id] == $_GET[funcionario_id]){
						$bg = "bgcolor=#228B22'";				
					}else{
						$bg = "";
					}
					echo "<tr class='text roundbordermix'>";
					echo "<td align=left $bg class='text roundborder curhand' onclick=\"location.href='?dir=com_sesmt&p=view&funcionario_id={$list[$i]['funcionario_id']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>{$list[$i]['nome']}&nbsp;</td>";
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
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>Relatório de repasse</b></td>";
        echo "</tr>";
        echo "</table>";

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>
