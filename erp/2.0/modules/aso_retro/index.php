<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$_POST[search] = anti_injection($_POST[search]);
$_GET[o]       = anti_injection($_GET[o]);

if(is_numeric($_GET[cod_cliente])){
    $sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
    $r = pg_query($sql);
    $clinfo = pg_fetch_array($r);
}

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
         //só exibir caso seja pesquisa 
		 /*
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
                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=16 maxlength=500>";
                        echo "&nbsp;";
                        echo "<input type='submit' class='btn' name='btnSearch' value='Busca'>";
                    echo "</td>";
                echo "</form>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
         }		
		 		*/
                                
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
                        echo "<td class='text' align=center>
						<input type='button' class='btn' name='button' value='Novo' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=new1';\"  onmouseover=\"showtip('tipbox', '- Novo ASO.');\" onmouseout=\"hidetip('tipbox');\"><p/>
						<input type='button' class='btn' name='button' value='Lista' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista';\"  onmouseover=\"showtip('tipbox', '- Listar ASO\'s.');\" onmouseout=\"hidetip('tipbox');\"></td>";
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
            if($_GET[sp] == 'new'){
                echo "<b>Novo ASO Retroativo</b>";
            }elseif($_GET[sp] == 'new_enc_fl'){
                echo "<b>$clinfo[razao_social]</b>";
            }else{
                echo "<b>ASO Retroativo</b>";
            }
        echo "</td>";
        echo "</tr>";
        echo "</table>";
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

