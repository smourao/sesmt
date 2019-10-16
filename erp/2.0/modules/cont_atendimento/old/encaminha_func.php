<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$_GET[cod_cliente] = anti_injection($_GET[cod_cliente]);

if(!empty($_GET[cod_cliente])){
    $sql = "SELECT * FROM cliente WHERE cliente_id = {$_GET[cod_cliente]}";
    $res = pg_query($sql);
    $buffer = pg_fetch_array($res);
}

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
    echo "<td width=250 class='text roundborder' valign=top>";
            echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
            echo "<tr>";
            echo "<td align=center class='text roundborderselected'>";
                echo "<b>Opções</b>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";

            echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
            echo "<tr>";
                echo "<td class='roundbordermix text' height=30 align=left>";
                    echo "<table width=100% border=0>";
                    echo "<tr>";
                    echo "<td class='text' align=left>";

                    echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                echo "</td>";
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
        echo "<td align=center class='text roundborderselected'>";
        echo "<b>Agendamento - {$buffer[razao_social]}</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";

        echo "<p>";
            echo "<b>Encaminhamento:</b><BR>";
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td class='text roundborderselected'>";
            echo "Deseja enviar os encaminhamentos para os funcionários abaixo?";
            echo "<p>";
            echo "<center>";
            echo "<input type=button value='Sim' class=btn>";
            echo "&nbsp;";
            echo "<input type=button value='Não' class=btn>";
            echo "</center>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "<p>";

        for($x=0;$x<count($_POST[funcid]);$x++){
            $sql = "SELECT fu.*, f.*
    				FROM funcionarios f, funcao fu
    				WHERE f.cod_cliente = {$_GET[cod_cliente]}
    				AND f.cod_func = {$_POST[funcid][$x]}
    				AND f.cod_funcao = fu.cod_funcao";
            $r   = pg_query($sql);
            $fun = pg_fetch_array($r);

            if(strlen($fun[$i]['nome_funcao'])> 40)
                    $nfuncres = substr($fun['nome_funcao'], 1, 40)."...";
                else
                    $nfuncres = $fun['nome_funcao'];
                    
                echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                echo "<tr>";
                echo "<td align=left class='text roundborder'>".str_pad(($i+1), 4, "0", 0)."</td>";
                echo "<td align=left class='text roundborder'>{$fun['nome_func']}</td>";
                echo "<td align=left class='text roundborder' title='{$fun['nome_funcao']}' alt='{$fun['nome_funcao']}'>".$nfuncres."</td>";
                echo "</tr>";
                echo "</table>";
        }
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>
