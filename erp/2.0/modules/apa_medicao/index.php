<?PHP
if($_GET[remove]){
$del = "DELETE FROM aparelhos WHERE cod_aparelho = {$_GET[remove]}";
if(pg_query($connect, $del)){
showmessage('Aparelho de Medi��o Excluido com Sucesso!');
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
                    echo "<b>Selecione uma op��o</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='text' height=30 align=left>";
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Incluir' onclick=\"location.href='?dir=apa_medicao&p=i_aparelho';\"  onmouseover=\"showtip('tipbox', '- Permite incluir um aparelho de medi��o.');\" onmouseout=\"hidetip('tipbox');\"></td>";  echo "</td>";
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
        echo "<td align=center class='text roundborderselected'><b>Aparelhos de Medi��o</b></td>";
        echo "</tr>";
        echo "</table>";
        
	$query_apa = "select * from aparelhos ORDER BY nome_aparelho";
	$result_apa = pg_query($connect, $query_apa);
	$list = pg_fetch_all($result_apa);
	
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=200><b>Nome:</b></td>";
        echo "<td align=left class='text' width=50><b>Marca:</b></td>";
        echo "<td align=left class='text' width=10><b>&nbsp;</b></td>";
        echo "</tr>";
        for($i=0;$i<pg_num_rows($result_apa);$i++){
            echo "<tr class='text roundbordermix'>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=apa_medicao&p=a_aparelho&cod_aparelho={$list[$i]['cod_aparelho']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>&nbsp;{$list[$i]['nome_aparelho']}</td>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=apa_medicao&p=a_aparelho&cod_aparelho={$list[$i]['cod_aparelho']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>&nbsp;{$list[$i]['marca_aparelho']}</td>";			
            echo "<td align=center class='text roundborder '><a href='?dir=apa_medicao&p=index&remove={$list[$i]['cod_aparelho']}' >Excluir</a></td>";
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