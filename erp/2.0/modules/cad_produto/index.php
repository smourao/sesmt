<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$_POST[search] = anti_injection($_POST[search]);
$_GET[o]       = anti_injection($_GET[o]);
$rpp = 100;

/**************************************************************************************************/
// -->  EXCLUSÃO DE PRODUTO
/**************************************************************************************************/
if($_GET[sp] == "lista" || !$_GET[sp] && ($_GET[del] && $_GET[cod_prod])){
    if(is_numeric($_GET[cod_prod])){
        $sql = "SELECT * FROM produto WHERE cod_prod = $_GET[cod_prod]";
        $rtx = pg_query($sql);
        if(pg_num_rows($rtx)){
            $sql = "DELETE FROM produto WHERE cod_prod = $_GET[cod_prod]";
            if(pg_query($sql)){
                showMessage('Produto excluído com sucesso!');
                makelog($_SESSION[usuario_id], 'Exclusão de produto código: '.$_GET[cod_prod].'.', 305);
            }else{
                showMessage('Houve um erro ao excluir este produto do cadastro. Por favor, entre em contato com o setor de suporte!', 1);
                makelog($_SESSION[usuario_id], 'Erro ao excluir produto código: '.$_GET[cod_prod].'.', 306);
            }
        }else{
            showMessage('O produto que você está tentando excluir não existe.', 2);
            makelog($_SESSION[usuario_id], 'Erro ao excluir produto, código não existente no cadastro: '.$_GET[cod_prod].'.', 307);
        }
    }
}

/**************************************************************************************************/
// -->  CONSULTAS
/**************************************************************************************************/
if($_GET[sp] == "lista" || !$_GET[sp]){
    $sql = "";

    if(empty($_GET[page]) || $_GET[page] < 0) $_GET[page] = 1;
    
    if(!empty($_POST[search]) && $_POST && !$_GET[atividade]){
        $_POST[search] = anti_injection($_POST[search]);
        $c1 = 0;
        $c2 = 0;
        $tmp = str_replace(',', '', $_POST[search], $c1);
        $tmp = str_replace('.', '', $tmp, $c2);
        $_SESSION[last_search_prod][url] = $_POST[search];
        //COD_PROD
        if(is_numeric($_POST[search]) && $c1==0 && $c2==0){
            $sql = "SELECT * FROM produto WHERE cod_prod = {$_POST[search]}";
            $_SESSION[last_search_prod][type] = 1;
        }
        //Value
        elseif(is_numeric($tmp) && ($c1>0 || $c2 >0)){
            $n = str_replace('.', '', $_POST[search]);
            $n = str_replace(',', '.', $n);
            $sql = "SELECT * FROM produto WHERE preco_prod = '$n' ORDER BY cod_prod LIMIT $rpp OFFSET 0";
            $_SESSION[last_search_prod][type] = 2;
        }
        //Desc
        else{
            $atv = substr($_POST[search], 11, 1);
            if(substr($_POST[search], 0, 11) == "@atividade=" && is_numeric($atv)){
                $sql = "SELECT * FROM produto WHERE cod_atividade = '$atv' ORDER BY cod_prod LIMIT $rpp OFFSET ".(($_SESSION[last_search_prod][page]-1)*$rpp)."";
            }else{
                $sql = "SELECT * FROM produto
                WHERE
                lower(desc_detalhada_prod) LIKE '%".strtolower($_POST[search])."%'
                OR
                lower(desc_resumida_prod) LIKE '%".strtolower($_POST[search])."%'
                OR
                lower(cod_chave) LIKE '%".strtolower($_POST[search])."%'
                ORDER BY cod_prod LIMIT $rpp OFFSET 0";
            }
            $_SESSION[last_search_prod][type] = 3;
        }
    //PESQUISA POR ATIVIDADE
    }elseif($_GET[atividade] && is_numeric($_GET[atividade]) && $_GET[page] && is_numeric($_GET[page])){
        $_SESSION[last_search_prod][url] = "@atividade=$_GET[atividade]";
        $_SESSION[last_search_prod][page] = (int)$_GET[page];
        //if(empty($_GET[page])) $_SESSION[last_search_prod][page] = 1; else $_SESSION[last_search_prod][page] = (int)($_GET[page]);
        $_SESSION[last_search_prod][type] = 3;
        $_POST[search] = "@atividade=$_GET[atividade]";
        $sql = "SELECT * FROM produto WHERE cod_atividade = '$_GET[atividade]' ORDER BY cod_prod LIMIT $rpp OFFSET ".(($_SESSION[last_search_prod][page]-1)*$rpp)."";

    //CACHE - WITHOUT POST
    }elseif(!empty($_SESSION[last_search_prod][url]) && $_GET[page] && is_numeric($_GET[page])){
        $_SESSION[last_search_prod][page] = (int)$_GET[page];
        //if(empty($_GET[page])) $_SESSION[last_search_prod][page] = 1; else $_SESSION[last_search_prod][page] = (int)($_GET[page]);
        $_POST[search] = $_SESSION[last_search_prod][url];
        if($_SESSION[last_search_prod][type] == 2){
            //valor
            $n = str_replace('.', '', $_SESSION[last_search_prod][url]);
            $n = str_replace(',', '.', $n);
            $sql = "SELECT * FROM produto WHERE preco_prod = '$n' ORDER BY cod_prod LIMIT $rpp OFFSET ".(($_SESSION[last_search_prod][page]-1)*$rpp)."";
        }elseif($_SESSION[last_search_prod][type] == 3){
            //desc
            $atv = substr($_SESSION[last_search_prod][url], 11, 1);
            if(substr($_SESSION[last_search_prod][url], 0, 11) == "@atividade=" && is_numeric($atv)){
                $sql = "SELECT * FROM produto WHERE cod_atividade = '$atv' ORDER BY cod_prod LIMIT $rpp OFFSET ".(($_SESSION[last_search_prod][page]-1)*$rpp)."";
            }else{
                $sql = "SELECT * FROM produto
                WHERE lower(desc_detalhada_prod) LIKE '%".strtolower($_SESSION[last_search_prod][url])."%'
                ORDER BY cod_prod LIMIT $rpp OFFSET ".(($_SESSION[last_search_prod][page]-1)*$rpp)."";
            }
        }else{
            //cod_prod
            $sql = "SELECT * FROM produto WHERE cod_prod = {$_SESSION[last_search_prod][url]}";
        }
    }


    if(!empty($sql)){
        $rsea = pg_query($sql);
        $buffer = pg_fetch_all($rsea);

        //Páginação
        if($_GET[atividade]){
            $sql = "SELECT count(*) as n FROM produto WHERE cod_atividade = '$_GET[atividade]'";
        }elseif($_SESSION[last_search_prod][type] == 2){
            //valor
            $n = str_replace('.', '', $_POST[search]);
            $n = str_replace(',', '.', $n);
            $sql = "SELECT count(*) as n FROM produto WHERE preco_prod = '$n'";
        }elseif($_SESSION[last_search_prod][type] == 3){
            //desc
            $atv = substr($_SESSION[last_search_prod][url], 11, 1);
            if(substr($_SESSION[last_search_prod][url], 0, 11) == "@atividade=" && is_numeric($atv)){
                $sql = "SELECT count(*) as n FROM produto WHERE cod_atividade = $atv";
            }else{
                $sql = "SELECT count(*) as n FROM produto WHERE lower(desc_detalhada_prod) LIKE '%".strtolower($_POST[search])."%' OR lower(cod_chave) LIKE '%".strtolower($_POST[search])."%'";
            }
        }else{
            //cod_prod
            $sql = "SELECT count(*) as n FROM produto WHERE 1=2";//nothing
        }
        $respage = pg_query($sql);
        $nitems = pg_fetch_array($respage);
        $nitems = $nitems[n];
    }
}
/**************************************************************************************************/


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
                    echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o nome, código ou preço do produto no campo e clique em Busca para pesquisar.');\" onmouseout=\"hidetip('tipbox');\">";
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
                
                $sql = "SELECT p.cod_atividade, count(p.cod_prod) as n, a.dsc_atividade
                        FROM produto p, atividade a
                        WHERE p.cod_atividade = a.cod_atividade
                        GROUP BY p.cod_atividade, a.dsc_atividade ORDER BY p.cod_atividade";
                $rtv = pg_query($sql);
                $rstv = pg_fetch_all($rtv);
                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left onmouseover=\"showtip('tipbox', '- Resumo do cadastro de produtos.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text'>Atividades:</td>";
                        echo "<td class='text' width=150 align=right>";
                            for($x=0;$x<pg_num_rows($rtv);$x++){
                                echo "<span title='{$rstv[$x][dsc_atividade]} - {$rstv[$x][n]} produtos cadastrados' alt='{$rstv[$x][dsc_atividade]} - {$rstv[$x][n]} produtos cadastrados'>";
                                echo "<font size=1>";
                                echo "<a href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=1&atividade={$rstv[$x][cod_atividade]}'>";
                                echo $rstv[$x][cod_atividade];
                                echo "</a>";
                                echo "</font>";

                                echo "</span>";
                                if($x<pg_num_rows($rtv)-1)
                                    echo " | ";
                            }
                        echo "</td>";
                        echo "</tr><tr>";
                        
                        $sql = "SELECT count(*) as n FROM produto";
                        $rto = pg_query($sql);
                        $tp = pg_fetch_array($rto);
                        
                        echo "<td class='text'>Produtos:</td><td class='text' width=150 align=right><span title='Total de produtos cadastrados.' alt='Total de produtos cadastrados.'>{$tp[n]}</span></td>";
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
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=edit_prod&page=$_GET[page]&cod_prod=new';\"  onmouseover=\"showtip('tipbox', '- Novo, permite o cadastro de um novo produto.');\" onmouseout=\"hidetip('tipbox');\"></td>";
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
        if($_GET[sp] == "lista"){
            if($_SESSION[last_search_prod][type] == 1){
                echo "<b>Cadastro de Produtos - Busca por código do produto: {$_POST[search]}</b>";
            }elseif($_SESSION[last_search_prod][type] == 2){
                echo "<b>Cadastro de Produtos - Busca por preço: {$_POST[search]}</b>";
            }else{
                echo "<b>Cadastro de Produtos - Busca por descrição: {$_POST[search]}</b>";
            }
        }elseif($_GET[sp] == "edit_prod" && is_numeric($_GET[cod_prod])){
            echo "<b>Editar Produto</b>";
        }elseif($_GET[sp] == "edit_prod" && !is_numeric($_GET[cod_prod])){
            echo "<b>Cadastrar Novo Produto</b>";
        }else{
            echo "<b>Cadastro de Produtos</b>";
        }
        echo "</td>";
        echo "</tr>";
        echo "</table>";

        $sp = current_module_path.anti_injection($_GET[sp]).".php";
        if(file_exists($sp)){
            include($sp);
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

