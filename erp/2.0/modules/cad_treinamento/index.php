<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$_POST[search] = anti_injection($_POST[search]);
$_GET[o]       = anti_injection($_GET[o]);
$rpp = 100;

if(empty($_GET[page]) || $_GET[page] < 0 || !is_numeric($_GET[page])) $_GET[page] = 1;


echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
if(!$_GET[sp] || $_GET[sp] == 'lista'){
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
                
                $sql = "SELECT count(*) as max FROM site_treinamento_info";
                $maxtr = pg_fetch_array(pg_query($sql));
                $maxtr = $maxtr[max];
                $sql = "SELECT count(*) as max FROM bt_treinamento";
                $maxcert = pg_fetch_array(pg_query($sql));
                $maxcert = $maxcert[max];
                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left onmouseover=\"showtip('tipbox', '- Resumo.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text'>Número de treinamentos:</td>";
                        echo "<td class='text' width=45 align=right>$maxtr</td>";
                        echo "</tr><tr>";
                        echo "<td class='text'>Número de certificados:</td>";
                        echo "<td class='text' width=45 align=right>$maxcert</td>";
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
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=edit_prod&page=$_GET[page]&cod_prod=new';\"  onmouseover=\"showtip('tipbox', '- Novo.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
}

if($_GET[sp] == 'detail' || $_GET[sp] == 'participantes'){
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
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Detalhes' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=detail&cod_certificado=$_GET[cod_certificado]';\"  onmouseover=\"showtip('tipbox', '- Novo.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Participantes' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=participantes&cod_certificado=$_GET[cod_certificado]';\"  onmouseover=\"showtip('tipbox', '- Novo.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
}

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
            include('lista.php');
        }
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>

