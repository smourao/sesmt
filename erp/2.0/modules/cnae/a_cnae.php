<?PHP
if($_POST[cnae] != ""){
	$query_alterar = "UPDATE cnae SET 
						cnae 		  = '$cnae'
						, descricao   = '$descricao'
						, grau_risco  = '$grau'
						, grupo_cipa  = '$grupo_cipa'
						WHERE cnae_id = ".$cnae_id;
	if(pg_query($connect, $query_alterar)){	
	     showmessage('CNAE Alterado com Sucesso!');
	}
}

$query="select * from cnae where cnae_id=".$cnae_id."";
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
        echo "<td align=center class='text roundborderselected'><b>Alterar CNAE - Classificação Nacional de Atividades Econômicas</b></td>";
        echo "</tr>";
        echo "</table>";
        
		echo "<form name=form1 method=post>";
	    echo "<table width=100% border=0 cellspacing=0 cellpadding=0 height=300>";
        echo "<tr class='text roundbordermix'>";
        echo "<td height=50 align=left class='text' width=100><b>CNAE:</b></td>";
        echo "<td align=left width=200><input id='cnae' type='text' name='cnae' value='{$row[cnae]}' size='10' maxlength='7' OnKeyPress=\"formatar(this, '##.##-#');\">
			  <input name=cnae_id type=hidden id=cnae_id value=$row[cnae_id]></td>";
        echo "</tr>";

        echo "<tr class='text roundbordermix'>";
        echo "<td height=50 align=left class='text' width=100><b>Grau de Risco:</b></td>";
        echo "<td align=left width=200><select name=grau id=grau>
              <option value=1"; if($row[grau_risco]==1){echo " selected ";} echo" >1</option>
			  <option value=2"; if($row[grau_risco]==2){echo " selected ";} echo" >2</option>
			  <option value=3"; if($row[grau_risco]==3){echo " selected ";} echo" >3</option>
			  <option value=4"; if($row[grau_risco]==4){echo " selected ";} echo" >4</option>			 
            </select></td>";
        echo "</tr>";

        echo "<tr class='text roundbordermix'>";
        echo "<td height=50 align=left class='text' width=100><b>Grupo:</b></td>";
        echo "<td align=left width=200><input id='grupo_cipa' type='text' name='grupo_cipa' size=40 value={$row[grupo_cipa]}></td>";
        echo "</tr>";

		echo "<tr class='text roundbordermix'>";
		echo "<td height=50 align=left class='text'><b>Descrição:</b></td>";
		echo "<td align=left><textarea cols=40 rows=3 id='descricao' type='text' name='descricao' size=40 >{$row[descricao]}</textarea></td>";
		echo "</tr>";

		echo "<tr class='text '>";
		echo "<td height=100 align=left class='text'></td>";
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