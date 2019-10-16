<?PHP
if($_GET[remove]){
$del = "DELETE FROM parede WHERE cod_parede = {$_GET[remove]}";
if(pg_query($connect, $del)){
showmessage('Parede Excluido com Sucesso!');
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
					echo "<td class='text' align=center><input type='button' class='btn' name='btnCad' value='Incluir' onclick=\"location.href='?dir=tipo_parede&p=i_parede';\"  onmouseover=\"showtip('tipbox', '- Permite incluir um tipo de parede.');\" onmouseout=\"hidetip('tipbox');\"></td>";  echo "</td>";
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
        echo "<td align=center class='text roundborderselected'><b>Característica da Parede</b></td>";
        echo "</tr>";
        echo "</table>";
        
	$query_par = "select * from parede ORDER BY nome_parede";
	$result_par = pg_query($connect, $query_par);
	$list = pg_fetch_all($result_par);
	
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=50><b>Nome:</b></td>";
        echo "<td align=left class='text' width=200><b>Descrição:</b></td>";
        echo "<td align=left class='text' width=10><b>&nbsp;</b></td>";
        echo "</tr>";
        for($i=0;$i<pg_num_rows($result_par);$i++){
            echo "<tr class='text roundbordermix'>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=tipo_parede&p=a_parede&cod_parede={$list[$i]['cod_parede']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>{$list[$i]['nome_parede']}</td>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=tipo_parede&p=a_parede&cod_parede={$list[$i]['cod_parede']}';\" alt='Clique aqui para editar' title='Clique aqui para editar'>{$list[$i]['decicao_parede']}</td>";			
            echo "<td align=center class='text roundborder '><a href='?dir=tipo_parede&p=index&remove={$list[$i]['cod_parede']}' >Excluir</a></td>";
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