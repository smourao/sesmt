<?PHP
if($_GET[remove]){
$del = "DELETE FROM viabilidade_localidade WHERE id = {$_GET[remove]}";
if(pg_query($connect, $del)){
showmessage('Localidade Excluido com Sucesso!');
}
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
                    echo "<b>Selecione uma opção</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='text' height=30 align=left>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Incluir' onclick=\"location.href='?dir=via_local&p=i_local';\"  onmouseover=\"showtip('tipbox', '- Permite incluir uma localidade.');\" onmouseout=\"hidetip('tipbox');\"></td>";  echo "</td>";
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
        echo "<td align=center class='text roundborderselected'><b>Viabilidade de Localidade</b></td>";
        echo "</tr>";
        echo "</table>";
        
	$query_via = "select * from viabilidade_localidade ORDER BY bairro";
	$result_via = pg_query($connect, $query_via);
	$list = pg_fetch_all($result_via);
	
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text' width=100><b>Bairro:</b></td>";
        echo "<td align=center class='text' width=150><b>Rua:</b></td>";
        echo "<td align=center class='text' width=20><b>Cidade/Estado:</b></td>";
		echo "<td align=center class='text' width=10><b>CEP:</b></td>";
		echo "<td align=center class='text' width=10><b>Lado:</b></td>";
		echo "<td align=center class='text' width=10><b>&nbsp;</b></td>";
        echo "</tr>";
        for($i=0;$i<pg_num_rows($result_via);$i++){
            echo "<tr class='text roundbordermix'>";
            echo "<td align=center class='text roundborder '>{$list[$i]['bairro']}&nbsp;</td>";
            echo "<td align=center class='text roundborder '>{$list[$i]['rua']}&nbsp;</td>";
			echo "<td align=center class='text roundborder '>{$list[$i]['cidade']}/{$list[$i]['estado']}&nbsp;</td>";
			echo "<td align=center class='text roundborder '>{$list[$i]['cep']}&nbsp;</td>";
			echo "<td align=center class='text roundborder '>"; print $list[$i]['lado'] == 0 ? "A" : "B"; echo"</td>";			
            echo "<td align=center class='text roundborder '><a href='?dir=via_local&p=index&remove={$list[$i]['id']}' >Excluir</a></td>";
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