<?PHP
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td align=center class='text roundborderselected'>";
    echo "<b>Lista de Treinamentos</b>";
echo "</td>";
echo "</tr>";
echo "</table>";

if($_POST && $_POST[search]){
    if(is_numeric($_POST[search])){
        $sql = "SELECT c.razao_social, ti.*, cur.* FROM site_treinamento_info ti, cliente c, bt_cursos cur
        WHERE
        c.cliente_id = $_POST[search]
        AND ti.cod_cliente = c.cliente_id AND ti.cod_curso = cur.id ORDER BY data_criacao";
    }else{
        $sql = "SELECT c.razao_social, ti.*, cur.* FROM site_treinamento_info ti, cliente c, bt_cursos cur
        WHERE
        lower(c.razao_social) LIKE '%".strtolower($_POST[search])."%'
        AND ti.cod_cliente = c.cliente_id AND ti.cod_curso = cur.id ORDER BY data_criacao";
    }
    $res = pg_query($sql);
    $ltr = pg_fetch_all($res);
}else{
    $sql = "SELECT c.razao_social, ti.*, cur.* FROM site_treinamento_info ti, cliente c, bt_cursos cur WHERE ti.cod_cliente = c.cliente_id AND ti.cod_curso = cur.id ORDER BY data_criacao LIMIT $rpp OFFSET ".(($_GET[page]-1)*$rpp)."";
    $res = pg_query($sql);
    $ltr = pg_fetch_all($res);
}




echo "<center><font size=1>";
if(ceil(pg_num_rows($res)/$rpp)>=5){
    echo "[ ";
    if($_GET[page] > 2){
        if($_GET[page]<=(ceil($nitems/$rpp)-2)){
            echo " <a href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=1'>Primeira</a> |";
            echo " <a href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".($_GET[page]-2)."'>".($_GET[page]-2)."</a> |";
            echo " <a href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".($_GET[page]-1)."'>".($_GET[page]-1)."</a> |";
            echo " <a class='roundborderselected' href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".($_GET[page])."'>".($_GET[page])."</a> | ";
            echo " <a href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".($_GET[page]+1)."'>".($_GET[page]+1)."</a> | ";
            echo " <a href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".($_GET[page]+2)."'>".($_GET[page]+2)."</a> | ";
            echo " <a href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".(ceil($nitems/$rpp))."'>Última</a>";
        }else{
            echo " <a href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=1'>Primeira</a> |";
            echo " <a"; print $_GET[page]== ceil($nitems/$rpp) - 4 ? " class='roundborderselected' ":""; echo " href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".(ceil($nitems/$rpp)-4)."'>".(ceil($nitems/$rpp)-4)."</a> |";
            echo " <a"; print $_GET[page]== ceil($nitems/$rpp) - 3 ? " class='roundborderselected' ":""; echo " href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".(ceil($nitems/$rpp)-3)."'>".(ceil($nitems/$rpp)-3)."</a> |";
            echo " <a"; print $_GET[page]== ceil($nitems/$rpp) - 2 ? " class='roundborderselected' ":""; echo " href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".(ceil($nitems/$rpp)-2)."'>".(ceil($nitems/$rpp)-2)."</a> |";
            echo " <a"; print $_GET[page]== ceil($nitems/$rpp) - 1 ? " class='roundborderselected' ":""; echo " href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".(ceil($nitems/$rpp)-1)."'>".(ceil($nitems/$rpp)-1)."</a> | ";
            echo " <a"; print $_GET[page]== ceil($nitems/$rpp) ? " class='roundborderselected' ":""; echo " href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".ceil($nitems/$rpp)."'>".ceil($nitems/$rpp)."</a> | ";
            echo " <a href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".(ceil($nitems/$rpp))."'>Última</a>";
        }
        //echo round($nitems/$rpp);
    }else{
        echo " <a href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=1'>Primeira</a> |";
        echo " <a"; print $_GET[page]== 1 ? " class='roundborderselected' ":""; echo " href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=1'>1</a> |";
        echo " <a"; print $_GET[page]== 2 ? " class='roundborderselected' ":""; echo " href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=2'>2</a> |";
        echo " <a"; print $_GET[page]== 3 ? " class='roundborderselected' ":""; echo " href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=3'>3</a> |";
        echo " <a"; print $_GET[page]== 4 ? " class='roundborderselected' ":""; echo " href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=4'>4</a> | ";
        echo " <a"; print $_GET[page]== 5 ? " class='roundborderselected' ":""; echo " href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=5'>5</a> | ";
        echo " <a href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".(ceil($nitems/$rpp))."'>Última</a>";
    }
    echo " ]";
    echo "<BR>";
    echo " <div style=\"display: inline;\">";
        echo "<span class='curhand' onclick=\"changeDivVis(document.getElementById('gotopage'), 2);\" alt='Permite que seja acessado uma página específica da busca.' title='Permite que seja acessado uma página específica da busca.'>
        <font size=1>Selecionar página</font></span>";
        echo "<div id='gotopage' style=\"display: none;\">";
        echo "<table border=0><tr><td valign=middle>";
        echo "<input type='text' name='topagenum' id='topagenum' value='$_GET[page]' size=4 style=\"height: 14px; font-size: 9px;\">";
        echo "</td><td valign=middle>";
        echo "<input type=button value='Ir' style=\"height: 16px; width: 20px; font-size: 10px;\" onclick=\"location.href='?dir=cad_produto&p=index&sp=lista&page='+document.getElementById('topagenum').value;\">";
        echo "</td></tr></table>";
        echo "</div>";
    echo "</div>";
}elseif(($nitems/$rpp)<=1){
   //nothing to show
}else{
    echo "[ ";
    echo " <a href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=1'>Primeira</a> |";
    for($x=1;$x<=ceil($nitems/$rpp);$x++){
        echo " <a"; print $_GET[page]== $x ? " class='roundborderselected' ":""; echo " href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=$x'>$x</a> |";//echo ($x+1)." | ";
    }
    echo " <a href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=lista&page=".(ceil($nitems/$rpp))."'>Última</a>";
    echo " ]";
}
echo "</font></center>";



echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
//echo "<td align=left class='text' width=20><b>Livro:</b></td>";
echo "<td align=left class='text'><b>Empresa:</b></td>";
echo "<td align=left class='text'><b>Curso:</b></td>";
echo "<td align=left class='text' width=70><b>Data início:</b></td>";
echo "</tr>";
for($x=0;$x<pg_num_rows($res);$x++){
    echo "<tr class='roundbordermix'>";
//    echo "<td align=center class='text roundborder' width=20>{$ltr[$x][livro]}</td>";
    echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=detail&cod_certificado={$ltr[$x][cod_certificado]}';\"><b>{$ltr[$x][razao_social]}</b></td>";
    echo "<td align=left class='text roundborder' width=200>{$ltr[$x][curso]}</td>";
    echo "<td align=center class='text roundborder' width=100>".date("d/m/Y", strtotime($ltr[$x][data_inicio]))."</td>";
    echo "</tr>";
}
echo "</table>";
?>
