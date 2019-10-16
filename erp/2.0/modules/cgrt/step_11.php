<?PHP
    $sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
    $result = pg_query($sql);
    $cinfo = pg_fetch_array($result);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
    echo "<b>$cinfo[razao_social]</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
/***************************************************************************************************/
// --> DEL CGRT
/***************************************************************************************************/
if($_POST && $_POST[btnConfirmDelCGRT]){
    //print_r($_SESSION);
    $sql = "SELECT * FROM funcionario WHERE funcionario_id = ".(int)($_SESSION[usuario_id]);
    $rfa = @pg_query($sql);
    $fin = @pg_fetch_array($rfa);
    if(@pg_num_rows($rfa)>0 && $fin[is_coord]){
        //deletar funcionários no cgrt_func_list
        //deletar cliente_setor
        //deletar deletar iluminacao_ppra
        //deletar risco_setor
        //deletar sugestao
        //deletar cgrt_info
        /*
        --DELETE FROM cgrt_func_list WHERE cod_cgrt = 106
        --DELETE FROM cliente_setor WHERE id_ppra = 106
        --DELETE FROM iluminacao_ppra WHERE id_ppra = 106
        --DELETE FROM risco_setor WHERE id_ppra = 106
        --DELETE FROM sugestao WHERE id_ppra = 106
        --DELETE FROM cgrt_info WHERE cod_cgrt = 106
        */
        $sql = "DELETE FROM cgrt_func_list WHERE cod_cgrt = ".(int)($_GET[cod_cgrt]);
        
        $sql = "DELETE FROM cliente_setor WHERE id_ppra = ".(int)($_GET[cod_cgrt]);
        
        $sql = "DELETE FROM iluminacao_ppra WHERE id_ppra = ".(int)($_GET[cod_cgrt]);
        
        $sql = "DELETE FROM risco_setor WHERE id_ppra = ".(int)($_GET[cod_cgrt]);
        
        $sql = "DELETE FROM sugestao WHERE id_ppra = ".(int)($_GET[cod_cgrt]);
        
        $sql = "DELETE FROM cgrt_info WHERE cod_cgrt = ".(int)($_GET[cod_cgrt]);
        
        
    }else{
        showmessage('Você não tem permissão para excluir este cadastro.',1);
    }
    //$value = 25 / 0.2;
    //echo "<BR>------>$value / 60 = ".floor($value/60);
    //echo "h".($value%60)."min";
}else{
/***************************************************************************************************/
// --> FORM - CONFIRMAÇÃO DE DELEÇÃO
/***************************************************************************************************/
    echo "<form method='POST' name='frmDelCGRT'>";

    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 height=200>";
    echo "<tr>";
    echo "<td align=left class='text roundborderselectedred'>";
    echo "<center><b>ATENÇÃO</b></center>";
    echo "<BR><P><BR>";
    echo "Todos os dados gravados até o momento, como setores e suas respectivas medições, serão excluídos e não poderão ser recuperados.";
    echo "<p>";
    echo "Tem certeza que deseja <b>EXCLUIR</b> este relatório?<BR>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<p>";

    echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
    echo "<tr>";
    echo "<td align=left class='text'>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
            echo "<td align=center class='text roundbordermix'>";
                echo "<input type='submit' class='btn' name='btnConfirmDelCGRT' value='Excluir' onmouseover=\"showtip('tipbox', '- Excluir, excluirá todos os dados para o relatório selecionado.');\" onmouseout=\"hidetip('tipbox');\">";
                echo "&nbsp;";
                echo "<input type='button' class='btn' name='btnCancelDelSetor' value='Cancelar' onmouseover=\"showtip('tipbox', '- Cancelar, retorna à tela anterior sem excluir o relatório selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=10&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]';\">";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "<td>";
    echo "</tr>";
    echo "</table>";

    echo "</form>";
}
?>
