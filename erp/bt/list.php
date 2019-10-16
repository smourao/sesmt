<?PHP
        if($_GET[o]){
            $ord = $_GET[o];
        }else{
            $ord = "data DESC";
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
        echo "<td width=150 align=center class=fontebranca12><b>Estatística</b></td>";
        echo "<td class=fontebranca12>&nbsp;</td>";
        echo "<td>";
        echo "</tr>";
        
            echo "<tr>";
            echo "<td width=150 align=left class=fontebranca12><b>Cursos:</b></td>";
            echo "<td class=fontebranca12>";
            for($x=0;$x<pg_num_rows($result);$x++){
                echo "<a href='?action=list&c={$cursos[$x][id]}' class=fontebranca12><b>{$cursos[$x][curso]}</b></a>";
                if($x < pg_num_rows($result)-1){
                    echo " | ";
                }
            }
            echo "</td>";
            echo "</tr>";

        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Consulta:</b></td>";
        echo "<td class=fontebranca12><input type=text value='{$_POST[search]}' name=search size=30> <input type=submit value='Pesquisar'> </td>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";
        echo "</FORM>";

        echo "<br>";

        if($_POST){
            $sql = "SELECT b.* FROM bt_info b
            WHERE ";
            if($_GET[c]){
                $sql .= " b.curso = $_GET[c] AND ";
            }
            $sql .="
            (
            lower(b.participante) LIKE '%".strtolower($_POST[search])."%'
            OR
            lower(b.empresa) LIKE '%".strtolower($_POST[search])."%'
            OR
            lower(b.ctps) LIKE '%".strtolower($_POST[search])."%'
            )
            ";
            if($ord){
                $sql .= " ORDER by b.{$ord} ";
            }
        }else{
            $sql = "SELECT b.*, c.curso as cn FROM bt_info b, bt_cursos c";
            $sql .= " WHERE ";
            $sql .= " c.id = b.curso ";
            if($_GET[c]){
                $sql .= " AND b.curso = $_GET[c] ";
            }

            if($ord){
                $sql .= " ORDER by b.{$ord} ";
            }
        }
        

        $r = pg_query($sql);
        $bt = pg_fetch_all($r);

        if(pg_num_rows($r)>0){
        echo "<table width=100% BORDER=1 align=center>";
        echo "<tr>";
        echo "<td align=center width=20 class=fontebranca12><a href='?action=list&o=livro' class=fontebranca12><b>Livro</b></a></td>";
        echo "<td align=center width=20 class=fontebranca12><a href='?action=list&o=folha' class=fontebranca12><b>Folha</b></a></td>";
        echo "<td align=center width=50 class=fontebranca12><a href='?action=list&o=reg_certificado' class=fontebranca12><b>Certificado</b></a></td>";
        echo "<td align=center width=120 class=fontebranca12><a href='?action=list&o=empresa' class=fontebranca12><b>Empresa</b></a></td>";
        echo "<td align=center width=120 class=fontebranca12><a href='?action=list&o=participante' class=fontebranca12><b>Participante</b></a></td>";
        echo "<td align=center width=50 class=fontebranca12><a href='?action=list&o=ctps' class=fontebranca12><b>CTPS</b></a></td>";
        echo "<td align=center width=50 class=fontebranca12><a href='?action=list&o=serie' class=fontebranca12><b>Série</b></a></td>";
        echo "<td align=center width=50 class=fontebranca12><a href='?action=list&o=curso' class=fontebranca12><b>Curso</b></a></td>";
        echo "<td align=center width=50 class=fontebranca12><a href='?action=list&o=data' class=fontebranca12><b>Data</b></a></td>";

        echo "</tr>";
            for($x=0;$x<pg_num_rows($r);$x++){
                echo "<tr>";
                echo "<td class=fontebranca12 width=20 align=center><font size=1>".romano($bt[$x][livro])."</td>";
                echo "<td class=fontebranca12 width=20 align=center><font size=1>".str_pad($bt[$x][folha], 2, "0", 0)."</td>";
                echo "<td class=fontebranca12 width=50 align=center><font size=1>".str_pad($bt[$x][reg_certificado], 5, "0", 0)."</td>";
                echo "<td class=fontebranca12 align=center><font size=1>{$bt[$x][empresa]}</td>";
                echo "<td class=fontebranca12 align=left>{$bt[$x][participante]}</td>";
                echo "<td class=fontebranca12 align=center><font size=1>{$bt[$x][ctps]}</td>";
                echo "<td class=fontebranca12 align=center><font size=1>{$bt[$x][serie]}</td>";
                echo "<td class=fontebranca12 align=center><font size=1>{$bt[$x][cn]}</td>";
                echo "<td class=fontebranca12 align=center><font size=1>".date("d/m/Y", strtotime($bt[$x][data]))."</td>";
            }
        echo "</table>";
        }else{
            echo "<center><span class=fontebranca12><b>Nenhum registro encontrado!</b></span></center>";
        }
?>
