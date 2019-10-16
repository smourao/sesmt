<?PHP
if($_GET[remove]){
	//$del = "DELETE FROM funcionario WHERE funcionario_id = {$_GET[remove]}";
	//pg_query($connect, $del);
	
	$del2 = "UPDATE funcionario SET status=0 WHERE funcionario_id = {$_GET[remove]}";
	pg_query($connect, $del2);
	
	showmessage('Colaborador desativado com Sucesso!');
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
                    echo "<b>Selecione uma opção:</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

				echo "<table border=0 cellpadding=2 cellspacing=3 width=100%><tbody>";
				echo "<tr><td class=roundbordermix text align=left height=30>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
				
                echo "<tr>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Sair' onclick=\"location.href='index.php';\"  onmouseover=\"showtip('tipbox', '- Voltar para página inicial.');\" onmouseout=\"hidetip('tipbox');\"></td>";

					echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Novo' onclick=\"location.href='?dir=cad_col&p=i_reg';\"  onmouseover=\"showtip('tipbox', '- Permite registrar um colaborador na SESMT.');\" onmouseout=\"hidetip('tipbox');\"></td>";
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
        echo "<td align=center class='text roundborderselected'><b>Registro de Colaboradores</b></td>";
        echo "</tr>";
        echo "</table>";
        
		$query_func = "SELECT f.*, u.* FROM funcionario f, usuario u WHERE f.funcionario_id = u.funcionario_id ORDER BY f.nome";
		$result_func = pg_query($connect, $query_func);
		$list = pg_fetch_all($result_func);
	
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=40%><b>Nome:</b></td>";
		echo "<td align=left class='text' width=20%><b>Login:</b></td>";
        echo "<td align=left class='text' width=20%><b>CPF:</b></td>";
        echo "<td align=left class='text' width=10%><b>N° Vendedor:</b></td>";
		echo "<td align=left class='text' width=10%><b>&nbsp;</b></td>";
        echo "</tr>";
        for($i=0;$i<pg_num_rows($result_func);$i++){
			if($list[$i][status] == 0){
				$bg = "bgcolor=#CD0000'";				
			}else{
				$bg = "";	
			}
            echo "<tr class='text roundbordermix'>";
            echo "<td align=left $bg class='text roundborder curhand' onclick=\"location.href='?dir=cad_col&p=a_reg&funcionario_id={$list[$i]['funcionario_id']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>{$list[$i]['nome']}&nbsp;</td>";
			echo "<td align=left $bg class='text roundborder curhand' onclick=\"location.href='?dir=cad_col&p=a_reg&funcionario_id={$list[$i]['funcionario_id']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>{$list[$i]['login']}&nbsp;</td>";
            echo "<td align=left $bg class='text roundborder curhand' onclick=\"location.href='?dir=cad_col&p=a_reg&funcionario_id={$list[$i]['funcionario_id']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>{$list[$i]['cpf']}&nbsp;</td>";
			echo "<td align=left $bg class='text roundborder curhand' onclick=\"location.href='?dir=cad_col&p=a_reg&funcionario_id={$list[$i]['funcionario_id']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>{$list[$i]['cod_vendedor']}&nbsp;</td>";
            echo "<td align=center $bg class='text roundborder '><a href='?dir=cad_col&p=index&remove={$list[$i]['funcionario_id']}' >Inativar</a></td>";
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