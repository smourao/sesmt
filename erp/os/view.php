<?
$osn = $_GET[os];
if(!$osn || !is_numeric($osn)){
    echo "<center>Número de O.S. Inválida.</center>";
}else{
    $sql = "SELECT status, para, readed, aberto_por, readed_owner FROM os_info WHERE id='{$_GET[os]}'";
    $result = pg_query($sql);
    $st = pg_fetch_array($result);
    if(pg_num_rows($result)<=0){
       die('O.S. Selecionada não está disponível ou não existe!');
    }
    if($_GET[s]>=0 && is_numeric($_GET[s])){
        $sql = "UPDATE os_info SET status='{$_GET[s]}' WHERE id='{$_GET[os]}'";
        $result = pg_query($sql);
        
        //atualiza como não lida quando msg postada
        if($_SESSION[usuario_id] != $st[para] && $st[readed] != 0){
            $sql = "UPDATE os_info SET readed = 0 WHERE id = '$osn'";
            pg_query($sql);
        }
        if($_SESSION[usuario_id] != $st[aberto_por]){
            $sql = "UPDATE os_info SET readed_owner = 0 WHERE id = '$osn'";
            pg_query($sql);
        }

        switch($_GET[s]){
            case  0:
                if($st[status] != 0){
                    $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
                    VALUES
                    ('{$_GET[os]}', '<font color=\"#66000c\"><i>O.S. marcada como Aberta.</i></font>',
                    '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 1)";
                    pg_query($sql);
                }
                header('Location: ?action=view&os='.$_GET[os].'');
            break;
            case  1:
                if($st[status] != 1){
                    $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
                    VALUES
                    ('{$_GET[os]}', '<font color=\"#19cb72\"><i>O.S. marcada como Finalizada.</i></font>',
                    '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 1)";
                    pg_query($sql);
                }
                header('Location: ?action=view&os='.$_GET[os].'');
            break;
            case  2:
                if($st[status] != 2){
                    $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
                    VALUES
                    ('{$_GET[os]}', '<font color=\"#cbb819\"><i>O.S. marcada como Em Execução.</i></font>',
                    '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 1)";
                    pg_query($sql);
                }
                header('Location: ?action=view&os='.$_GET[os].'');
            break;
            case  3:
                if($st[status] != 3){
                    $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
                    VALUES
                    ('{$_GET[os]}', '<font color=\"#868580\"><i>O.S. marcada como Cancelada.</i></font>',
                    '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 1)";
                    pg_query($sql);
                }
                header('Location: ?action=view&os='.$_GET[os].'');
            break;
            case  4:
                if($st[status] != 4){
                    $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
                    VALUES
                    ('{$_GET[os]}', '<font color=\"#868580\"><i>O.S. marcada como Excluída.<p>Esta mensagem ficará disponível apenas para o administrador!</i></font>',
                    '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 1)";
                    pg_query($sql);
                }
                //header('Location: ?action=view&os='.$_GET[os].'');
                header('Location: ?action=list');
            break;
            case  5:
                if($st[status] != 5){
                    $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
                    VALUES
                    ('{$_GET[os]}', '<font color=\"#cbb819\"><i>O.S. marcada como Pendente.</i></font>',
                    '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 1)";
                    pg_query($sql);
                }
                header('Location: ?action=view&os='.$_GET[os].'');
                //header('Location: ?action=list');
            break;
        }
    }
    
    if($_POST){
        $sql = "INSERT INTO os_msg (cod_os, msg, data_postagem, postado_por, ip, onlyread)
        VALUES
        ('{$_GET[os]}', '".addslashes($_POST[msg])."', '".date("r")."', '{$_SESSION[usuario_id]}', '{$_SERVER[REMOTE_ADDR]}', 0)";
        $postado = pg_query($sql);
        
        //atualiza como não lida quando msg postada pelo owner
        if($_SESSION[usuario_id] != $st[para] && $st[readed] != 0){
            $sql = "UPDATE os_info SET readed = 0 WHERE id = '$osn'";
            pg_query($sql);
        }
        //atualiza como não lida quando msg postada pelo executor
        if($_SESSION[usuario_id] != $st[aberto_por]){
            $sql = "UPDATE os_info SET readed_owner = 0 WHERE id = '$osn'";
            pg_query($sql);
        }
    }
    

    $sql = "SELECT i.*, s.nome_setor FROM os_info i, setor_sesmt s
    WHERE
    i.id = '$osn'
    AND
    i.setor = s.id";
    $result = pg_query($sql);
    $info = pg_fetch_array($result);
    
                $status = "";
                $prioridade = "";
                switch($info[status]){
                    case 0:
                        $status = "Aberto";
                    break;
                    case 1:
                        $status = "Finalizado";
                    break;
                    case 2:
                        $status = "Em Execução";
                    break;
                    case 3:
                        $status = "Cancelado";
                    break;
                    case 4:
                        $status = "Excluído";
                    break;
                    case 5:
                        $status = "Pendente";
                    break;
                    default:
                        $status = "Indefinido";
                    break;
                }
                switch($info[prioridade]){
                    case 0:
                        $prioridade = "Indefinido";
                    break;
                    case 1:
                        $prioridade = "Alta";
                    break;
                    case 2:
                        $prioridade = "Média";
                    break;
                    case 3:
                        $prioridade = "Baixa";
                    break;
                    default:
                        $prioridade = "Indefinido";
                    break;
                }
    
                $sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$info[para]}'";
                $result = pg_query($sql);
                $para = pg_fetch_array($result);

                //Update
                //atualiza como lida quando dono de PARA entrar para ler
                if(($_SESSION[usuario_id] == $info[para] && $st[readed] != 1)){
                    $sql = "UPDATE os_info SET readed = 1 WHERE id = '$osn'";
                    pg_query($sql);
                }
                if(($_SESSION[usuario_id] == $info[aberto_por] && $st[readed_owner] != 1)){
                    $sql = "UPDATE os_info SET readed_owner = 1 WHERE id = '$osn'";
                    pg_query($sql);
                }
                
        echo "<table width=100% BORDER=0 align=center>";
        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Setor:</b></td>";
        echo "<td class=fontebranca12>{$info[nome_setor]}";
        if($para[nome]){
            echo " - $para[nome]";
        }else{
            //echo " - Qualquer funcionário do setor";
        }
        echo "</td>";
        echo "<td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Data:</b></td>";
        echo "<td class=fontebranca12>".date("d/m/Y H:i", strtotime($info[data_abertura]))."</td>";
        echo "<td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Término:</b></td>";
        echo "<td class=fontebranca12>";
        if($info[data_conclusao])
        echo date("d/m/Y H:i", strtotime($info[data_conclusao]));
        else
        echo "Prazo para término não especificado.";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Assunto:</b></td>";
        echo "<td class=fontebranca12>{$info[assunto]} <a href='#' onclick=\"var tt = prompt('Digite o novo título:','{$info[assunto]}'); if(tt!=null && tt!=''){edit_title('{$_GET[os]}', tt);}\"><img src='edit.png' border=0 width=16 height=16 title='Editar' alt='Editar'></a></td>";
        echo "<td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Status:</b></td>";
        echo "<td class=fontebranca12>$status</td>";
        echo "<td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Prioridade:</b></td>";
        echo "<td class=fontebranca12>$prioridade</td>";
        echo "<td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Marcar como:</b></td>";
        echo "<td class=fontebranca12>
        <a href='?action=view&os={$_GET[os]}&s=0' class=fontebranca12><b>Aberto</b></a> |
        <a href='?action=view&os={$_GET[os]}&s=1' class=fontebranca12><b>Finalizado</b></a> |
        <a href='?action=view&os={$_GET[os]}&s=2' class=fontebranca12><b>Em Execução</b></a> |
        <a href='?action=view&os={$_GET[os]}&s=5' class=fontebranca12><b>Pendente</b></a> |
        <a href='?action=view&os={$_GET[os]}&s=3' class=fontebranca12><b>Cancelado</b></a> |
        <a href='?action=view&os={$_GET[os]}&s=4' class=fontebranca12><b>Excluída</b></a>
        </td>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";
        echo "<div id=editmsg style=\"display: none;\">";
            echo "<span id=original name=original></span>";
            echo "<br>";
            echo "<center><font size=2><b>Editar Mensagem</b></font></center>";
            echo "<table width=100% BORDER=0 align=center cellspacing=0 cellpadding=0  class=tmsg>";
            echo "<tr>";
            echo "<td width=100% height=60 align=center>
            <textarea style=\"width:100%;\" rows=6 id=edittxt name=edittxt></textarea>
            <input type=button value='Alterar' onclick=\"save_edit('{$_GET[os]}');\">
            </td>";
            echo "</tr>";
            echo "</table>";
            echo "<input type=hidden name=msgid id=msgid value=''>";
        echo "</div>";
        
        echo "<p>";
        
        $sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$info[aberto_por]}'";
        $r = pg_query($sql);
        $por = pg_fetch_array($r);
        
        if($postado){
            echo "<center>Mensagem adicionada!</center>";
            echo "<P>";
        }
        //MENSAGEMS
        /*
        echo "<table width=100% BORDER=0 align=center cellspacing=0 cellpadding=0 class=tmsg>";
        echo "<tr>";
        echo "<td width=80% align=left class='por'><b>$por[nome]</b></td>";
        echo "<td align=right class='fontebranca12 por'><b>".date("d/m/Y H:i", strtotime($info[data_abertura]))."</b></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width=100% height=65 valign=top colspan=2 align=left class='osmsgpor'>".nl2br($info[msg])."</td>";
        echo "</tr>";
        echo "</table>";
        echo "<p>";
        */
        $sql = "SELECT o.*, f.nome FROM os_msg o, funcionario f
        WHERE cod_os = '{$osn}'
        AND
        o.postado_por = f.funcionario_id
        ORDER BY data_postagem
        ";
        $result = pg_query($sql);
        $msg = pg_fetch_all($result);
        for($x=0;$x<pg_num_rows($result);$x++){
            echo "<table width=100% BORDER=0 align=center cellspacing=0 cellpadding=0  class=tmsg>";
            echo "<tr>";
            echo "<td width=80% align=left";
            print $msg[$x][postado_por] == $info[aberto_por] ? " class='por' " : " class='por2' ";
            echo "><b>&nbsp;&nbsp;{$msg[$x][nome]}</b>";
            print $msg[$x][postado_por] == $info[aberto_por] ? " [Solicitante]" : " [Executor do Serviço]";
            echo "</td>";
            echo "<td align=right "; print $msg[$x][postado_por] == $info[aberto_por] ? " class='por fontebranca12' " : " class='por2 fontebranca12' "; echo "><b>".date("d/m/Y H:i", strtotime($msg[$x][data_postagem]))."</b></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td width=100% ";
            print $msg[$x][postado_por] == $info[aberto_por] ? " class='msg1' " : " class='msg2' ";

            $ttx = htmlentities(nl2br($msg[$x][msg]));
            
            echo " height=65 valign=top colspan=2 align=left><p><br>".nl2br($msg[$x][msg])."
            <p>
            --------------<br>
            <table width=100% width=100% border=0>
            <tr>
            <td align=left>
            {$msg[$x][ip]}
            </td>
            <td width=10% align=center>
            ";
            if(/*(empty($msg[$x][onlyread]) && $msg[$x][postado_por] == $_SESSION[usuario_id]) || */(empty($msg[$x][onlyread]) && $_SESSION[grupo]=="administrador")){
                echo "<a href='#' onclick=\"open_edit('{$msg[$x][id]}');document.getElementById('msgid').value='{$msg[$x][id]}';\">
                <img src='edit.png' border=0 width=16 height=16 title='Editar' alt='Editar'>
                </a>";
            }else{
                echo "&nbsp;";
            }
            echo "
            </td>
            </tr>
            </table>
            </td>";
            //document.getElementById('msgid').value='{$msg[$x][id]}';document.getElementById('edittxt').value='".$ttx."';document.getElementById('editmsg').style.display='block';
            echo "</tr>";
            echo "</table>";
            echo "<P>";
        }
        echo "<P>";
        if($info[status] == 0 || $info[status] == 2 || $info[status] == 5){
            echo "<form method=post>";
            echo "<table width=100% BORDER=0 align=center cellspacing=0 cellpadding=0>";
            echo "<tr>";
            echo "<td align=left class=fontebranca12><b>Resposta:</b></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td align=center><textarea rows=5 name=msg style=\"width: 100%;\"></textarea></td>";
            echo "<td>";
            echo "</tr>";
            echo "</table>";
            echo "<center>";
            echo "<input type=submit value='Responder'>";
            echo "</center>";
            echo "</form>";
        }
}
?>
