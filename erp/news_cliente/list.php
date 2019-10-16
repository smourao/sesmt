<?PHP

if($_GET[action]=='del' && $_GET[id]){
    $sql = "DELETE FROM site_newsletter_msg WHERE id = $_GET[id]";
    pg_query($sql);
    $sql = "DELETE FROM site_newsletter_mail WHERE noticia_id = $_GET[id]";
    pg_query($sql);
    echo "<script>location.href='?action=list';</script>";
}

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
            $sql = "SELECT *
            FROM site_newsletter_msg
            WHERE lower(titulo) LIKE '%".strtolower($_POST[search])."%'";
        }else{
            $sql = "SELECT * FROM site_newsletter_msg";
        }

        $r = pg_query($sql);
        $bt = pg_fetch_all($r);

        if(pg_num_rows($r)>0){
        echo "<table width=100% BORDER=1 align=center>";
        echo "<tr>";
        echo "<td align=center width=20 class=fontebranca12><b>Nº</b></td>";
        echo "<td align=center class=fontebranca12><b>Título</b></td>";
        echo "<td align=center width=100 class=fontebranca12><b>Criação</b></td>";
        echo "<td align=center width=130 class=fontebranca12><b>Criado por</b></td>";
        echo "<td align=center width=80 class=fontebranca12><b>E-mails</b></td>";
        echo "<td align=center width=80 class=fontebranca12><b>Excluir</b></td>";
        echo "</tr>";
            for($x=0;$x<pg_num_rows($r);$x++){
                $sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$bt[$x][enviado_por]}'";
                $rf = pg_query($sql);
                $func = pg_fetch_array($rf);
                $nf = explode(" ", $func[nome]);
                if(strlen($nf[1]) > 2){
                    $nome = $nf[0]." ".$nf[1];
                }else{
                    $nome = $nf[0]." ".$nf[1]." ".$nf[2];
                }
                
                $sql = "select * FROM site_newsletter_mail WHERE noticia_id = '{$bt[$x][id]}'";
                $rmt = pg_query($sql);
                $mt = pg_fetch_all($rmt);
                $sql = "select * FROM site_newsletter_mail WHERE noticia_id = '{$bt[$x][id]}' AND status = 1";
                $rmr = pg_query($sql);
                $mr = pg_fetch_all($rmr);

                
                
                echo "<tr>";
                echo "<td class=fontebranca12 align=center><font size=1>".($x+1)."</td>";
                echo "<td class=fontebranca12 align=left>".$bt[$x][titulo]."</td>";
                echo "<td class=fontebranca12 align=center><font size=1>".date("d/m/Y", strtotime($bt[$x][data_criacao]))."</td>";
                echo "<td class=fontebranca12 align=center>".$nome."</td>";
                echo "<td class=fontebranca12 align=center>".pg_num_rows($rmr)."/".pg_num_rows($rmt)."</td>";
                echo "<td class=fontebranca12 align=center><input type=button  value='Excluir' onclick=\"if(confirm('Tem certeza que deseja excluir esta mensagem? Todos os emails na fila para envio serão cancelados!','')){location.href='?action=del&id={$bt[$x][id]}';}\"></td>";
                echo "</tr>";
            }
        echo "</table>";
        }else{
            echo "<center><span class=fontebranca12><b>Nenhuma notícia encontrada!</b></span></center>";
        }
?>
