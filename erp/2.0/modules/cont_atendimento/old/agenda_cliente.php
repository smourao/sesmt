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
/***************************************************************************************************/
// --> POST
/***************************************************************************************************/
if($_POST && $_POST[btnConfirmFunc]){
    //new_agendamento
    //$sql = "INSERT INTO site_aso_agendamento (cod_cliente, ";
    for($x=0;$x<count($_POST[funcid]);$x++){
        if(is_numeric($_POST[funcid][$x])){
            $sql = "SELECT fu.*, f.*
    				FROM funcionarios f, funcao fu
    				WHERE f.cod_cliente = {$_GET[cod_cliente]}
    				AND f.cod_func = {$_POST[funcid][$x]}
    				AND f.cod_funcao = fu.cod_funcao";
            $r   = pg_query($sql);
            $fun = pg_fetch_array($r);
            //get next cod_aso
            $sql = "SELECT MAX(cod_aso) as max FROM aso";
            $cod_max = pg_fetch_array(pg_query($sql));
            $cod_max = $cod_max[max] + 1;
            $sql = "INSERT INTO aso (cod_aso, cod_cliente";
        }
    }
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

        $sql = "SELECT fu.*, f.* FROM funcionarios f, funcao fu WHERE f.cod_cliente = {$_GET[cod_cliente]} AND f.cod_funcao = fu.cod_funcao";
        $r   = pg_query($sql);
        $fun = pg_fetch_all($r);
        //echo "<form method='post' action='?dir=cont_atendimento&p=encaminha_func&cod_cliente={$_GET[cod_cliente]}'>";
        echo "<form method='post'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=20><b>Nº:</b></td>";
        echo "<td align=left class='text' width=40><b>Sel:</b></td>";
        echo "<td align=left class='text'><b>Funcionário:</b></td>";
        echo "<td align=left class='text' width=260><b>Função:</b></td>";
        echo "</tr>";
        for($i=0;$i<pg_num_rows($r);$i++){
            if(strlen($fun[$i]['nome_funcao'])> 40){
                $nfuncres = substr($fun[$i]['nome_funcao'], 1, 40)."...";
            }else{
                $nfuncres = $fun[$i]['nome_funcao'];
            }
            echo "<tr class='text roundbordermix'>";
            echo "<td align=left class='text roundborder curhand'>".str_pad(($i+1), 4, "0", 0)."</td>";
            echo "<td align=center class='text roundborder curhand'><input type=checkbox name=funcid[] id=funcid value='{$fun[$i]['cod_func']}'></td>";
            echo "<td align=left class='text roundborder curhand'>{$fun[$i]['nome_func']}</td>";
            echo "<td align=left class='text roundborder curhand' title='{$fun[$i]['nome_funcao']}' alt='{$fun[$i]['nome_funcao']}'>".$nfuncres."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p>";

        echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
            echo "<tr>";
            echo "<td align=left class='text'>";
                echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                echo "<tr>";
                    echo "<td align=center class='text roundbordermix'>";
                    echo "<input type='submit' class='btn' name='btnConfirmFunc' value='Confirmar' onclick=\"\" onmouseover=\"showtip('tipbox', '- Selecionar, selecionará os funcionários para agendamento.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
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
