<?PHP
if($_GET[action] == "del"){
    //$sql = "DELETE FROM funcionarios WHERE id = $_GET[id_func]";
    $sql = "UPDATE funcionarios SET cod_status = 0 WHERE id = ".(int)($_GET[id_func]);
    //$result = pg_query($sql);
    if(@pg_query($sql)){
        echo "<script>
        alert('Funcionário marcado como inativo com sucesso!');
        location.href='?cod_cliente=$_GET[cod_cliente]&cod_filial=$_GET[cod_filial]';
        </script>";
    }else{
        echo "<script>alert('Erro ao alterar status do funcionário!');</script>";
    }
}
        echo "<FORM method='post'>";
        echo "<table BORDER=0 align=center width=100%>";
        echo "<tr>";
        echo "<td width=150 align=left class=fontebranca12><b>Funcionários:</b></td>";
        $sql = "SELECT * FROM funcionarios WHERE cod_cliente = $_GET[cod_cliente]";
        $result = pg_query($sql);
        echo "<td class=fontebranca12>";
        echo pg_num_rows($result);
        echo "</td>";
        echo "</tr>";

        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Consulta:</b></td>";
        echo "<td class=fontebranca12><input type=text value='{$_POST[search]}' name=search size=30> <input type=submit value='Pesquisar'> </td>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";
        echo "<table BORDER=0 align=center width=100%>";
        echo "<tr>";
        echo "<td class=fontebranca12 width=100><b>Legenda:</b></td>";
        echo "<td class=fontebranca12 width=20 bgcolor='#D75757'>&nbsp;</td>";
        echo "<td class=fontebranca12>Dados incompletos</td>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";

        echo "</FORM>";
        
        echo "<br>";
        
        if($_POST){

        }else{
           /*
            $sql = "SELECT f.*, fun.nome_funcao FROM funcionarios f, funcao fun
            WHERE cod_cliente = $_GET[cod_cliente] AND f.cod_funcao = fun.cod_funcao
            ORDER BY f.cod_func";
            */
            $sql = "SELECT f.* FROM funcionarios f
            WHERE cod_cliente = $_GET[cod_cliente]
            ORDER BY f.cod_func";
        }

        $r = pg_query($sql);
        $funcionarios = pg_fetch_all($r);

        if(pg_num_rows($r)>0){
        echo "<table width=100% BORDER=1 align=center>";
        echo "<tr>";
        //echo "<td align=center width=20 class=fontebranca12><b>Nº</b></td>";
        echo "<td align=center width=20 class=fontebranca12><b>Cód.</b></td>";
        echo "<td align=center class=fontebranca12><b>Nome</b></td>";
        //echo "<td align=center class=fontebranca12><b>Cargo</b></td>";
        echo "<td align=center width=60 class=fontebranca12><b>CTPS</b></td>";
        echo "<td align=center width=40 class=fontebranca12><b>Série</b></td>";
        echo "<td align=center width=40 class=fontebranca12><b>Excluir</b></td>";
        echo "</tr>";
            for($x=0;$x<pg_num_rows($r);$x++){
                if(empty($funcionarios[$x][num_ctps_func]) || empty($funcionarios[$x][serie_ctps_func])
                || empty($funcionarios[$x][cbo]) || empty($funcionarios[$x][cod_funcao]) ||
                empty($funcionarios[$x][sexo_func]) || empty($funcionarios[$x][data_nasc_func]) ||
                empty($funcionarios[$x][data_admissao_func])){
                    $bg = '#D75757';
                }else{
                    $bg = '#006633';
                }
                echo "<tr>";
                //echo "<td class=fontebranca12 align=center><font size=1>".($x+1)."</td>";
                echo "<td class=fontebranca12 align=center bgcolor='$bg'><font size=1>".$funcionarios[$x][cod_func]."</td>";
                echo "<td class=fontebranca12 align=left bgcolor='$bg'><font size=1><b><a class=fontebranca12 href='?action=detail&cod_cliente=$_GET[cod_cliente]&cod_filial=$_GET[cod_filial]&cod_func={$funcionarios[$x][cod_func]}'>"; print $funcionarios[$x][cod_status] ? "":"<i>[Inativo]</i> "; echo "<b>".$funcionarios[$x][nome_func]."</b></a></b></font></td>";
                //echo "<td class=fontebranca12 align=left bgcolor='$bg'><font size=1>{$funcionarios[$x][nome_funcao]}</td>";
                echo "<td class=fontebranca12 align=center bgcolor='$bg'>".$funcionarios[$x][num_ctps_func]."</td>";
                echo "<td class=fontebranca12 align=center bgcolor='$bg'><font size=1>{$funcionarios[$x][serie_ctps_func]}</td>";
                echo "<td class=fontebranca12 align=center bgcolor='$bg'><font size=1><a class=fontebranca12 href='#' onclick=\"if(confirm('Tem certeza que deseja marcar este funcionário como inativo?','')){location.href='?action=del&cod_cliente=$_GET[cod_cliente]&cod_filial=$_GET[cod_filial]&id_func={$funcionarios[$x][id]}';}\">Inativar</a></td>";
            }
        echo "</table>";
        }else{
            echo "<center><span class=fontebranca12><b>Nenhum registro encontrado!</b></span></center>";
        }
?>
