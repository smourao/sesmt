<?PHP
        if($_GET[o]){
            $ord = $_GET[o];
        }else{
            $ord = "data_inicio DESC";
        }

        //$sql = "SELECT count(*) as n FROM os_info WHERE status = 0";
        $sql = "SELECT c.id, c.curso FROM bt_cursos c, bt_info i
        WHERE
        i.curso = c.id
        GROUP BY c.id, i.curso, c.curso
        ORDER BY i.curso
        ";
        $result = pg_query($sql);
        $cursos = pg_fetch_all($result);

        echo "<FORM method='post'>";
        echo "<table BORDER=0 align=center width=100%>";
        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Consulta:</b></td>";
        echo "<td class=fontebranca12><input type=text value='{$_POST[search]}' name=search size=30> <input type=submit value='Pesquisar'> </td>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";
        echo "</FORM>";

        echo "<br>";

        if($_POST){
            $sql = "SELECT cod_cliente, cod_filial, data_inicio, livro, empresa, cod_curso
            FROM bt_treinamento
            WHERE lower(empresa) LIKE '%".strtolower($_POST[search])."%'
            GROUP BY cod_cliente, cod_filial, data_inicio, livro, empresa, cod_curso";
        }else{
            $sql = "SELECT cod_cliente, cod_filial, data_inicio, livro, empresa, cod_curso FROM bt_treinamento GROUP BY cod_cliente, cod_filial, data_inicio, livro, empresa, cod_curso";
        }

        $r = pg_query($sql);
        $bt = pg_fetch_all($r);

        if(pg_num_rows($r)>0){
        echo "<table width=100% BORDER=1 align=center>";
        echo "<tr>";
        echo "<td align=center width=20 class=fontebranca12><a href='?action=list&o=livro' class=fontebranca12><b>Livro</b></a></td>";
        //echo "<td align=center width=20 class=fontebranca12><a href='?action=list&o=folha' class=fontebranca12><b>Folha</b></a></td>";
        echo "<td align=center class=fontebranca12><a href='?action=list&o=empresa' class=fontebranca12><b>Empresa</b></a></td>";
        echo "<td align=center width=50 class=fontebranca12><a href='?action=list&o=participante' class=fontebranca12><b>Participantes</b></a></td>";
        echo "<td align=center width=130 class=fontebranca12><a href='?action=list&o=curso' class=fontebranca12><b>Curso</b></a></td>";
        echo "<td align=center width=50 class=fontebranca12><a href='?action=list&o=data' class=fontebranca12><b>Data Início</b></a></td>";
        echo "</tr>";
            for($x=0;$x<pg_num_rows($r);$x++){
                $sql = "SELECT t.*, c.curso FROM bt_treinamento t, bt_cursos c
                WHERE
                t.data_inicio = '{$bt[$x][data_inicio]}' AND
                t.cod_cliente = {$bt[$x][cod_cliente]} AND
                t.cod_filial = {$bt[$x][cod_filial]} AND
                t.livro = {$bt[$x][livro]} AND
                t.cod_curso = {$bt[$x][cod_curso]} AND
                t.cod_curso = c.id";
                $rst = pg_query($sql);
                $cinfo = pg_fetch_all($rst);
                
                echo "<tr>";
                echo "<td class=fontebranca12 align=center><font size=1>".romano($bt[$x][livro])."</td>";
                //echo "<td class=fontebranca12 align=center><font size=1>".str_pad($bt[$x][folha], 2, "0", 0)."</td>";
                echo "<td class=fontebranca12 align=left><font size=1><a href='?action=cert_list&cod_cliente={$bt[$x][cod_cliente]}&cod_filial={$bt[$x][cod_filial]}&dti={$bt[$x][data_inicio]}&cod_curso={$bt[$x][cod_curso]}&livro={$bt[$x][livro]}' class=fontebranca12><b>{$bt[$x][empresa]}</b></a></td>";
                echo "<td class=fontebranca12 align=center>".pg_num_rows($rst)."</td>";
                echo "<td class=fontebranca12 align=left><font size=1>{$cinfo[0][curso]}</td>";
                echo "<td class=fontebranca12 align=center><font size=1>".date("d/m/Y", strtotime($bt[$x][data_inicio]))."</td>";
            }
        echo "</table>";
        }else{
            echo "<center><span class=fontebranca12><b>Nenhum registro encontrado!</b></span></center>";
        }
?>
