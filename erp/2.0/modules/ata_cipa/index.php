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
     switch($_GET[sp]){
//[LISTA - DEFAULT]********************************************************************************/
         default:
         case 'lista':
             $sql = "SELECT * FROM site_ata_cipa";
             $rac = pg_query($sql);
             
             $sql = "SELECT * FROM site_ata_topic";
             $rto = pg_query($sql);
             
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
                        echo "<td class='text'>Nº de Atas:</td>";
                        echo "<td class='text curhand' width=150 align=right onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=1&st=1';\" title='Clique para exibir todas as atas criadas!' alt='Clique para exibir todas as atas criadas!'><b>".pg_num_rows($rac)."</b></td>";
                        echo "</tr><tr>";
                        echo "<td class='text'>Nº Tópicos:</td><td class='text' width=150 align=right>".pg_num_rows($rto)."</td>";
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
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=new_ata&cod_ata=new';\"  onmouseover=\"showtip('tipbox', '- Novo, permite a criação de uma nova ata.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
            break;
//[NEW_ATA]********************************************************************************/
            case 'new_ata':
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Busca para nova ata</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<form method=POST name='form2' action='?dir={$_GET[dir]}&p={$_GET[p]}&sp=new_ata'>";
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Clique em Busca para pesquisar.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
                        echo "&nbsp;";
                        echo "<input type='submit' class='btn' name='btnSearch' value='Busca'>";
                    echo "</td>";
                echo "</form>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
            break;
//[NEW_ATA_DONE]********************************************************************************/
            case 'new_ata_done':
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Nova ata</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
            break;
//[ATA_EDIT / New Topic]********************************************************************************/
            case 'edit_ata';
            case 'new_ata_topic':
            case 'edit_ata_topic':
            
                if($_GET[deltopic] && is_numeric($_GET[deltopic]) && $_GET[id] && is_numeric($_GET[id])){
                    $sql = "DELETE FROM site_ata_topic WHERE id = $_GET[deltopic] AND cod_ata = $_GET[id]";
                    if(pg_query($sql)){
                        showMessage('Tópico excluído com sucesso!');
                        makelog($_SESSION[usuario_id], "Tópico número $_GET[deltopic] excluído da ata número $_GET[id].", 401);
                    }else{
                        showMessage('Houve um erro ao excluir o tópico selecionado. Por favor, entre em contato com o setor de suporte!',1);
                        makelog($_SESSION[usuario_id], "Erro ao remover tópico número $_GET[deltopic] da ata número $_GET[id].", 402);
                    }
                }
            
                if(is_numeric($_GET[id])){
                    $sql = "SELECT * FROM site_ata_cipa WHERE id = $_GET[id]";
                    $res = pg_query($sql);
                    $atainfo = pg_fetch_array($res);

                    $sql = "SELECT * FROM site_ata_topic WHERE cod_ata = $_GET[id]";
                    $restop = pg_query($sql);
                    $topicos = pg_fetch_all($restop);

                    if(is_numeric($atainfo[cod_cliente])){
                        $sql = "SELECT * FROM cliente WHERE cliente_id = ".$atainfo[cod_cliente];
                        $cdata = pg_fetch_array(pg_query($sql));
                    }
                }
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

                        echo "<td class='text'>Nº Ata:</td>";
                        echo "<td class='text' width=150 align=right>$atainfo[d_atan]</td>";
                        echo "</tr><tr>";

                        echo "<td class='text' alt='$cdata[razao_social]' title='$cdata[razao_social]'>Cliente:</td>";
                        echo "<td class='text curhelp' alt='$cdata[razao_social]' title='$cdata[razao_social]' width=150 align=right>".str_pad($cdata[cliente_id], 4, "0", 0)."</td>";
                        echo "</tr><tr>";

                        echo "<td class='text'>Tópicos:</td><td class='text' width=150 align=right>".pg_num_rows($restop)."</td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                
                echo "<P>";
                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Editar ata</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left>";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Editar Ata' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=edit_ata&id=$_GET[id]';\"  onmouseover=\"showtip('tipbox', '- Editar Ata, exibe os dados da ata e permite a sua alteração.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo Tópico' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=new_ata_topic&id=$_GET[id]';\"  onmouseover=\"showtip('tipbox', '- Novo Tópico, permite a criação de um novo tópico para esta ata.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Editar Tópicos' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=edit_ata_topic&id=$_GET[id]';\"  onmouseover=\"showtip('tipbox', '- Editar Tópicos, exibe a lista com os tópicos criadas e permite sua edição.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Visualizar' onclick=\"window.open('".current_module_path."view_ata.php?id=$_GET[id]');\"  onmouseover=\"showtip('tipbox', '- Editar Tópicos, exibe a lista com os tópicos criadas e permite sua edição.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
                
            break;
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

