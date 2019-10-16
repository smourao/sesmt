<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$_POST[search] = anti_injection($_POST[search]);
$_GET[o]       = anti_injection($_GET[o]);



echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Pesquisa</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form1' action='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=1'>";
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Clique em Busca para pesquisar.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
                        echo "&nbsp;";
                        echo "<input type='submit' class='btn' name='btnSearch' value='Busca'>";
                    echo "</td>";
                echo "</form>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Resumo</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left onmouseover=\"showtip('tipbox', '- Resumo.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text'>xxx:</td>";
                        echo "<td class='text' width=150 align=right></td>";
                        echo "</tr><tr>";
                        echo "<td class='text'>xxx:</td><td class='text' width=150 align=right></td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
                
                

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
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Logs Hoje' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=logs_today&page=$_GET[page]';\"  onmouseover=\"showtip('tipbox', '- Novo.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        //echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=edit_prod&page=$_GET[page]&cod_prod=new';\"  onmouseover=\"showtip('tipbox', '- Novo.');\" onmouseout=\"hidetip('tipbox');\"></td>";
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
        $sp = current_module_path.anti_injection($_GET[sp]).".php";
        if(file_exists($sp)){
            @include($sp);
        }else{
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td align=center class='text roundborderselected'>";
                echo "<b>Logs do Sistema</b>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            //include('lista.php');
        }

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>

