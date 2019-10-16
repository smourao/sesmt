<?PHP
if($_GET[remove]){
$del = "DELETE FROM risco_cliente WHERE risco_id = {$_GET[remove]}";
if(pg_query($connect, $del)){
showmessage('Risco de Tolerância Excluido com Sucesso!');
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
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Incluir' onclick=\"location.href='?dir=nivel_tolerancia&p=risco_incluir';\"  onmouseover=\"showtip('tipbox', '- Permite incluir uma tolerância de risco.');\" onmouseout=\"hidetip('tipbox');\"></td>";  echo "</td>";
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
        echo "<td align=center class='text roundborderselected'><b>Nível de Tolerância</b></td>";
        echo "</tr>";
        echo "</table>";
        
	$query_risco="select * from risco_cliente";
	$result_risco=pg_query($connect, $query_risco);
	$list=pg_fetch_all($result_risco);
	
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=80><b>Risco:</b></td>";
        echo "<td align=left class='text' width=200><b>Descrição:</b></td>";
        echo "<td align=left class='text' width=10><b>&nbsp;</b></td>";
        echo "</tr>";
        for($i=0;$i<pg_num_rows($result_risco);$i++){
            echo "<tr class='text roundbordermix'>";
            echo "<td align=left class='text roundborder '>{$list[$i]['nome']}</td>";
            echo "<td align=left class='text roundborder '>{$list[$i]['descricao']}</td>";			
            echo "<td align=center class='text roundborder '><a href='?dir=nivel_tolerancia&p=index&remove={$list[$i]['risco_id']}' >Excluir</a></td>";
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