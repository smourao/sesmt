<?PHP
    $sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
    $result = pg_query($sql);
    $cliente = pg_fetch_array($result);
    
    $sql = "SELECT f.nome_func, t.*, c.curso FROM bt_treinamento t, bt_cursos c, funcionarios f
                WHERE
                t.data_inicio = '{$_GET[dti]}' AND
                t.cod_cliente = {$_GET[cod_cliente]} AND
                t.cod_filial = {$_GET[cod_filial]} AND
                t.livro = {$_GET[livro]} AND
                t.cod_curso = {$_GET[cod_curso]} AND
                t.cod_curso = c.id AND
                t.cod_funcionario = f.cod_func AND
                t.cod_cliente = f.cod_cliente";
    $r = pg_query($sql);
    $bt = pg_fetch_all($r);
        
    echo "<center><b>Certificados</b></center>";
    echo "<BR>";
    echo "<center><b>$cliente[razao_social]</b></center>";
    echo "<p>";
    echo "<center><font size=2>Certificado da empresa: <a href='cert_pdf_front_empresa.php?".$_SERVER[QUERY_STRING]."&tid={$bt[0][id]}' target=_blank class=fontebranca12><b>Frente</b></a><a href='cert_front_empresa__________sem_assin____.php?".$_SERVER[QUERY_STRING]."&tid={$bt[0][id]}' target=_blank class=fontebranca12>*</a> | <a href='cert_pdf_back_empresa.php?".$_SERVER[QUERY_STRING]."&tid={$bt[0][id]}' target=_blank class=fontebranca12><b>Verso</b></a></font></center>";
    echo "<P>";
    echo "<center><font size=2>Certificado dos funcionarios: <a href='cert_pdf_front.php?&mcid={$bt[0][cert_empresa]}' target=_blank class=fontebranca12><b>Frente</b></a> | <a href='cert_pdf_back.php?&mcid={$bt[0][cert_empresa]}' target=_blank class=fontebranca12><b>Verso</b></a></font></center>";
    echo "<P>";


        if(pg_num_rows($r)>0){
        echo "<table width=100% BORDER=1 align=center>";
        echo "<tr>";
        echo "<td align=center width=20 class=fontebranca12><a href='?action=list&o=livro' class=fontebranca12><b>Nº</b></a></td>";
        echo "<td align=center class=fontebranca12><a href='?action=list&o=empresa' class=fontebranca12><b>Nome</b></a></td>";
        echo "<td align=center width=100 class=fontebranca12><a href='?action=list&o=data' class=fontebranca12><b>Data Início</b></a></td>";
        echo "<td align=center width=100 class=fontebranca12><a href='?action=list&o=data' class=fontebranca12><b>Data Término</b></a></td>";
        echo "<td align=center width=100 class=fontebranca12><a href='?action=list&o=data' class=fontebranca12><b>Visualizar</b></a></td>";
        echo "</tr>";
            for($x=0;$x<pg_num_rows($r);$x++){
                $sql = "SELECT * FROM funcionarios WHERE cod_cliente = $_GET[cod_cliente] AND cod_func = {$bt[$x][cod_funcionario]}";
                $res = pg_query($sql);
                $funcionario = pg_fetch_array($res);
                echo "<tr>";
                echo "<td class=fontebranca12 align=center class=fontebranca12>"./*romano($bt[$x][numero_certificado])*/$bt[$x][numero_certificado]."</td>";
                echo "<td class=fontebranca12 align=left class=fontebranca12>{$funcionario[nome_func]}</td>";
                echo "<td class=fontebranca12 align=center class=fontebranca12>".date("d/m/Y", strtotime($bt[$x][data_inicio]))."</td>";
                echo "<td class=fontebranca12 align=center class=fontebranca12>".date("d/m/Y", strtotime($bt[$x][data_termino]))."</td>";
                echo "<td class=fontebranca12 align=center class=fontebranca12>
                <a href='cert_front.php?".$_SERVER[QUERY_STRING]."&tid={$bt[$x][id]}&a=".$bt[$x][nome_instrutor]."' target=_blank class=fontebranca12><b>Frente</b></a>
				<a href='cert_front__________sem_assin____.php?".$_SERVER[QUERY_STRING]."&tid={$bt[$x][id]}&a=".$bt[$x][nome_instrutor]."' target=_blank class=fontebranca12><b>*</b></a> |
                <a href='cert_back.php?".$_SERVER[QUERY_STRING]."&tid={$bt[$x][id]}&a=".$bt[$x][nome_instrutor]."' target=_blank class=fontebranca12><b>Verso</b></a>
                </td>";
            }
        echo "</table>";
        }else{
            echo "<center><span class=fontebranca12><b>Nenhum registro encontrado!</b></span></center>";
        }
?>
