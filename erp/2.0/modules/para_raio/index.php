<?PHP
if($_GET[remove]){
$del = "DELETE FROM tipo_para_raio WHERE tipo_para_raio_id = {$_GET[remove]}";
if(pg_query($connect, $del)){
showmessage('Tipo de Para-raio Excluido com Sucesso!');
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
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Incluir' onclick=\"location.href='?dir=para_raio&p=i_raio';\"  onmouseover=\"showtip('tipbox', '- Permite incluir tipo de para-raio.');\" onmouseout=\"hidetip('tipbox');\"></td>";  echo "</td>";
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
        echo "<td align=center class='text roundborderselected'><b>Tipo de Para-raio</b></td>";
        echo "</tr>";
        echo "</table>";
        
	$query_raio = "select * from tipo_para_raio";
	$result_raio = pg_query($connect, $query_raio);
	$list = pg_fetch_all($result_raio);
	
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=80><b>Para-raio:</b></td>";
        echo "<td align=left class='text' width=200><b>Descri��o:</b></td>";
        echo "<td align=left class='text' width=10><b>&nbsp;</b></td>";
        echo "</tr>";
        for($i=0;$i<pg_num_rows($result_raio);$i++){
            echo "<tr class='text roundbordermix'>";
            echo "<td align=left class='text roundborder '>{$list[$i]['tipo_para_raio']}</td>";
            echo "<td align=left class='text roundborder '>{$list[$i]['descricao']}</td>";			
            echo "<td align=center class='text roundborder '><a href='?dir=para_raio&p=index&remove={$list[$i]['tipo_para_raio_id']}' >Excluir</a></td>";
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