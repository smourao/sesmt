<?PHP
if($_POST[edificacao] != ""){
	$query_alterar = "UPDATE tipo_edificacao SET 
						tipo_edificacao 		 = '$edificacao'
						, descricao   			 = '$descricao'
						WHERE tipo_edificacao_id = ".$tipo_edificacao_id;
	if(pg_query($connect, $query_alterar)){	
	     showmessage('Edificação Alterado com Sucesso!');
	}
}

$query="select * from tipo_edificacao where tipo_edificacao_id=".$tipo_edificacao_id;
$result=pg_query($connect, $query);
$row=pg_fetch_array($result);

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
                    echo "<b>&nbsp;</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='text' height=30 align=left>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";

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
        echo "<td align=center class='text roundborderselected'><b>Alterar Tipo de Edificação</b></td>";
        echo "</tr>";
        echo "</table>";
        
		echo "<form name=form1 method=post>";
	    echo "<table width=100% border=0 cellspacing=0 cellpadding=0 height=300>";
        echo "<tr class='text roundbordermix'>";
        echo "<td height=50 align=left class='text' width=100><b>Nome:</b></td>";
        echo "<td align=left width=200><input id='edificacao' type='text' name='edificacao' value='{$row[tipo_edificacao]}' size='10' ></td>";
        echo "</tr>";

		echo "<tr class='text roundbordermix'>";
		echo "<td height=50 align=left class='text'><b>Descrição:</b></td>";
		echo "<td align=left><textarea cols=40 rows=3 id='descricao' type='text' name='descricao' size=40 >{$row[descricao]}</textarea></td>";
		echo "</tr>";

		echo "<tr class='text '>";
		echo "<td height=200 align=left class='text'></td>";
		echo "<td align=left></td>";
		echo "</tr>";

        echo "</table>";
		
		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
			echo "<tr>";
			echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
				echo "<tr>";
					echo "<td align=center class='text roundbordermix'>";
					echo "<input type='submit' class='btn' name='btnSave' value='Alterar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
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