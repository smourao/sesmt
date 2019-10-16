<?PHP
//Seleciona todos os setores cadastrados
$sql = "SELECT
            s.*, c.*
        FROM
            setor s, cliente_setor c
        where
            c.cod_setor = s.cod_setor
        AND
            s.cod_setor = $_GET[cod_setor]
        AND
            c.id_ppra = $_GET[cod_cgrt]";
$res = pg_query($sql);
$set = pg_fetch_array($res);

/***************************************************************************************************/
// --> DEL SETOR - C�digo de dele��o no INDEX do m�dulo...
/***************************************************************************************************/
if($_POST && $_POST[btnDelSetor]){
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
    echo "<b>$cinfo[razao_social]</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    if($rds){
        showMessage('Setor exclu�do com sucesso!');
        makelog($_SESSION[usuario_id], "[CGRT] Setor exclu�do. cod_setor: $_GET[cod_setor], cod_cgrt: $_GET[cod_cgrt], cod_cliente: $_GET[cod_cliente].", 106);

        //- Ao excluir setor, remover o cod_setor dos funcion�rios do setor exclu�do.
        $sql = "UPDATE cgrt_func_list SET cod_setor = null WHERE cod_cgrt = ".(int)($_GET[cod_cgrt])." AND cod_setor = ".(int)($_GET[cod_setor]);
        @pg_query($sql);

        //- Ao excluir setor, excluir medidas preventivas para o setor exclu�do.
        $sql = "DELETE FROM sugestao WHERE cod_setor = ".(int)($_GET[cod_setor])." AND id_ppra = ".(int)($_GET[cod_cgrt])."";
        @pg_query($sql);
        
    }else{
        showMessage('Houve um problema ao tentar excluir o setor selecionado. Por favor, entre em contato com o setor de suporte!',1);
        makelog($_SESSION[usuario_id], "[CGRT] Eror ao excluir setor. cod_setor: $_GET[cod_setor], cod_cgrt: $_GET[cod_cgrt], cod_cliente: $_GET[cod_cliente].", 106);
    }
}else{
/***************************************************************************************************/
// --> FORM - CONFIRMA��O DE DELE��O
/***************************************************************************************************/
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
    echo "<b>$cinfo[razao_social]</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";

    echo "<form method='POST' name='frmDelSetor'>";
    
    echo "<td class='text'><b>Setor:</b></td>";
    echo "<td class='text' width=155><b>Posto de trabalho:</b></td>";
    echo "<td class='text' width=120><b>Tipo:</b></td>";
    echo "</tr>";
    
    echo "<tr class='text'>";
    echo "<td align=left class='text roundborderselected'>";
        echo $set[nome_setor];
    echo "</td>";
    echo "<td align=left class='text roundborderselected' width=120  onmouseover=\"showtip('tipbox', '- Selecione um dos setores listados e seu respectivo tipo.');\" onmouseout=\"hidetip('tipbox');\">";
        print $set[posto_trabalho] ? "Fora da empresa":"Dentro da empresa";
    echo "</td>";
    echo "<td align=center class='text roundborderselected' width=120  onmouseover=\"showtip('tipbox', '- Selecione um dos setores listados e seu respectivo tipo.');\" onmouseout=\"hidetip('tipbox');\">";
        echo $set[tipo_setor];
    echo "</td>";
    echo "</tr>";
    echo "</table>";

    echo "<p>";
    
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2 height=200>";
    echo "<tr>";
    echo "<td align=left class='text roundborderselectedred'>";
    echo "<center><b>ATEN��O</b></center>";
    echo "<BR><P><BR>";
    echo "Todos os dados gravados at� o momento para este setor ser�o exclu�dos e n�o poder�o ser recuperados.";
    echo "<p>";
    echo "Tem certeza que deseja <b>EXCLUIR</b> o setor selecionado?<BR>";
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
                echo "<input type='submit' class='btn' name='btnDelSetor' value='Excluir' onmouseover=\"showtip('tipbox', '- Excluir, excluir� todos os dados para o setor selecionado.');\" onmouseout=\"hidetip('tipbox');\">";
                echo "&nbsp;";
                echo "<input type='button' class='btn' name='btnCancelDelSetor' value='Cancelar' onmouseover=\"showtip('tipbox', '- Cancelar, retorna � lista de setores sem excluir o setor selecionado.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=6&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&cod_setor=$_GET[cod_setor]';\">";
            echo "</td>";
        echo "</tr>";
        echo "</table>";
    echo "<td>";
    echo "</tr>";
    echo "</table>";
    
    echo "</form>";
}
?>
