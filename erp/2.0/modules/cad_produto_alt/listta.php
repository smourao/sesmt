<?PHP

/**************************************************************************************************/
// -->
/**************************************************************************************************/
/*
echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
echo "<tr>";
echo "<td class='text'>";
echo "<b>Lista:</b>";
echo "</td>";
echo "</tr>";
echo "</table>";
*/
echo "<center><font size=1>";
if(ceil($nitems/$rpp)>=5){
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
        echo "<input type=button value='Ir' style=\"height: 16px; width: 20px; font-size: 10px;\" onclick=\"location.href='?dir=cad_produto_alt&p=index&sp=lista&page='+document.getElementById('topagenum').value;\">";
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
if(is_resource($rsea)){
    if(pg_num_rows($rsea)){
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left class='text' width=20><b>Cód:</b></td>";
        echo "<td align=left class='text'><b>Descrição:</b></td>";
        echo "<td align=left class='text' width=20><b>Preço:</b></td>";
        echo "<td align=left class='text' width=70><b>Excluir:</b></td>";
		echo "<td align=left class='text' width=70><b>Duplicar:</b></td>";
        echo "</tr>";
        for($i=0;$i<@pg_num_rows($rsea);$i++){
            echo "<tr class='text roundbordermix'>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=edit_prod&page={$_GET[page]}&cod_prod={$buffer[$i][cod_prod]}';\">".str_pad($buffer[$i]['cod_prod'], 5, "0", 0)."</td>";
            echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=edit_prod&page={$_GET[page]}&cod_prod={$buffer[$i][cod_prod]}';\">{$buffer[$i]['desc_resumida_prod']}</td>";
             echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir={$_GET[dir]}&p={$_GET[p]}&sp=edit_prod&page={$_GET[page]}&cod_prod={$buffer[$i][cod_prod]}';\">{$buffer[$i]['preco_prod']}</td>";
            echo "<td align=center class='text roundborder'>";
                echo "<span onclick=\"if(confirm('Tem certeza que deseja excluir este produto?','')) location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]&cod_prod={$buffer[$i][cod_prod]}&del=1';\"><a href='javascript:;'>Excluir</a></span>";
            echo "</td>";
			
			echo "<td align=center class='text roundborder'>";
			
			echo "<span onclick=\"if(confirm('Tem certeza que deseja duplicar este produto?','')) location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=lista&page=$_GET[page]&cod_prod={$buffer[$i][cod_prod]}&duplicar=1';\"><a href='javascript:;'>Duplicar</a></span>";
            echo "</td>";
			
			
            echo "</tr>";
        }
        echo "</table>";
    }else{
        showMessage("Não foram encontrados resultados para o termo <b>\"{$_POST[search]}\"</b>!", 2);
    }
}

echo "<center><font size=1>";
if(ceil($nitems/$rpp)>=5){
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
        echo "<input type=button value='Ir' style=\"height: 16px; width: 20px; font-size: 10px;\" onclick=\"location.href='?dir=cad_produto_alt&p=index&sp=lista&page='+document.getElementById('topagenum').value;\">";
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



?>
