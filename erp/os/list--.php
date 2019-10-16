<?PHP
        if($_GET[o]){
            $ord = $_GET[o];
        }else{
            $ord = "data_abertura";
        }

        //$sql = "SELECT count(*) as n FROM os_info WHERE status = 0";
        $sql = "SELECT status, count(*) as n FROM os_info GROUP BY status ORDER BY status";
        $result = pg_query($sql);
        $status = pg_fetch_all($result);

        echo "<FORM method='post'>";
        echo "<table BORDER=0 align=center width=100%>";
        echo "<tr>";
        echo "<td width=150 align=center class=fontebranca12><b>Estatística</b></td>";
        echo "<td class=fontebranca12>&nbsp;</td>";
        echo "<td>";
        echo "</tr>";
        for($x=0;$x<pg_num_rows($result);$x++){
            switch($status[$x][status]){
                case 0:
                    echo "<tr>";
                    echo "<td width=150 align=left class=fontebranca12><b>O.S. Abertas:</b></td>";
                    echo "<td class=fontebranca12>{$status[$x][n]}</td>";
                    echo "<td>";
                    echo "</tr>";
                break;
                case 1:
                    echo "<tr>";
                    echo "<td width=150 align=left class=fontebranca12><b>O.S. Finalizadas:</b></td>";
                    echo "<td class=fontebranca12>{$status[$x][n]}</td>";
                    echo "<td>";
                    echo "</tr>";
                break;
                case 2:
                    echo "<tr>";
                    echo "<td width=150 align=left class=fontebranca12><b>O.S. em Execução:</b></td>";
                    echo "<td class=fontebranca12>{$status[$x][n]}</td>";
                    echo "<td>";
                    echo "</tr>";
                break;
                case 3:
                    echo "<tr>";
                    echo "<td width=150 align=left class=fontebranca12><b>O.S. Canceladas:</b></td>";
                    echo "<td class=fontebranca12>{$status[$x][n]}</td>";
                    echo "<td>";
                    echo "</tr>";
                break;
                case 4:
                    echo "<tr>";
                    echo "<td width=150 align=left class=fontebranca12><b>O.S. Excluídas:</b></td>";
                    echo "<td class=fontebranca12>{$status[$x][n]}</td>";
                    echo "<td>";
                    echo "</tr>";
                break;
                case 5:
                    echo "<tr>";
                    echo "<td width=150 align=left class=fontebranca12><b>O.S. Pendentes:</b></td>";
                    echo "<td class=fontebranca12>{$status[$x][n]}</td>";
                    echo "<td>";
                    echo "</tr>";
                break;
            }
        }

        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Consulta:</b></td>";
        echo "<td class=fontebranca12><input type=text value='{$_POST[search]}' name=search size=30> <input type=submit value='Pesquisar'> </td>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";
        echo "</FORM>";

        echo "<BR>";
        echo "<center><font size=2><a href=\"javascript:location.href='?action=list&m=$p_mes&y=$p_ano'\" class=fontebranca12><<</a>  <b>".$meses[ltrim($mes, "0")]."/{$ano}</b>  <a href=\"javascript:location.href='?action=list&m=$n_mes&y=$n_ano'\"  class=fontebranca12>>></a></font>    </center>";
        echo "<br>";

        $sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$_SESSION[usuario_id]}'";
        $result = pg_query($sql);
        $user_data = pg_fetch_array($result);


        if($_POST){
            if($user_data[cod_setor] && $user_data[funcionario_id] != 18){
                $sql = "SELECT os.*, ss.nome_setor FROM os_info os, setor_sesmt ss
                WHERE
                os.setor = ss.id
                AND
                os.setor = $user_data[cod_setor]
                AND
                (
                    lower(os.assunto) LIKE '%".strtolower($_POST[search])."%'
                OR
                    lower(os.msg) LIKE '%".strtolower($_POST[search])."%'
                 )
                ORDER by {$ord}";
            }else{
                $sql = "SELECT os.*, ss.nome_setor FROM os_info os, setor_sesmt ss
                WHERE
                os.setor = ss.id
                AND
                (
                    lower(os.assunto) LIKE '%".strtolower($_POST[search])."%'
                OR
                    lower(os.msg) LIKE '%".strtolower($_POST[search])."%'
                 )
                ORDER by {$ord}";
            }
        }else{
            //se funcionario for de determinado setor
            if($user_data[cod_setor] && $user_data[funcionario_id] != 18 && $user_data[funcionario_id] != 33){
                if($user_data[funcionario_id] == 10){ //10 = Luciana
                    $sql = "SELECT os.*, ss.nome_setor
                    FROM os_info os, setor_sesmt ss
                    WHERE
                    os.setor = ss.id
                    AND
                    (os.setor = $user_data[cod_setor]
                    OR os.setor = 2)
                    AND
                    (
                        EXTRACT(month FROM os.data_abertura) = '{$mes}'
                        AND
                        EXTRACT(year FROM os.data_abertura) = '{$ano}'
                    )
                    ORDER by {$ord} DESC";
                }else{
                    $sql = "SELECT os.*, ss.nome_setor
                    FROM os_info os, setor_sesmt ss
                    WHERE
                    os.setor = ss.id
                    AND
                    os.setor = $user_data[cod_setor]
                    AND
                    (
                        EXTRACT(month FROM os.data_abertura) = '{$mes}'
                        AND
                        EXTRACT(year FROM os.data_abertura) = '{$ano}'
                    )
                    ORDER by {$ord} DESC";
                }
            }else{
                $sql = "SELECT os.*, ss.nome_setor
                FROM os_info os, setor_sesmt ss
                WHERE
                os.setor = ss.id
                AND
                (
                    EXTRACT(month FROM os.data_abertura) = '{$mes}'
                    AND
                    EXTRACT(year FROM os.data_abertura) = '{$ano}'
                )
                ORDER by {$ord} DESC";
            }
        }
        $r = pg_query($sql);
        $os = pg_fetch_all($r);

        if(pg_num_rows($r)>0){
        echo "<table width=100% BORDER=1 align=center>";
        echo "<tr>";
        echo "<td align=center width=50 class=fontebranca12><a href='?action=list&o=id' class=fontebranca12><b>O.S.</b></a></td>";
        echo "<td align=center width=100 class=fontebranca12><a href='?action=list&o=data_abertura' class=fontebranca12><b>Data Abertura</b></a></td>";
        echo "<td align=center class=fontebranca12><a href='?action=list&o=assunto' class=fontebranca12><b>Assunto</b></a></td>";
        echo "<td align=center width=120 class=fontebranca12><a href='?action=list&o=setor' class=fontebranca12><b>Setor</b></a></td>";
        echo "<td align=center width=70 class=fontebranca12><a href='?action=list&o=status' class=fontebranca12><b>Status</b></a></td>";
        echo "<td align=center width=70 class=fontebranca12><a href='?action=list&o=prioridade' class=fontebranca12><b>Prioridade</b></a></td>";
        echo "</tr>";
            for($x=0;$x<pg_num_rows($r);$x++){
                /*
                $dia = date("d", strtotime($os[$x][data_abertura]));
                $mes = date("m", strtotime($os[$x][data_abertura]));
                $ano = date("Y", strtotime($os[$x][data_abertura]));
                $hora = date("H", strtotime($os[$x][data_abertura]));
                $minuto = date("i", strtotime($os[$x][data_abertura]));
                $segundo = date("s", strtotime($os[$x][data_abertura]));
                $abertura = mktime($hora, $minuto, $segundo, $mes, $dia, $ano);
                */
                $dia = date("d");
                $mes = date("m");
                $ano = date("Y");
                $hora = date("H");
                $minuto = date("i");
                $segundo = date("s");
                $abertura = mktime($hora, $minuto, $segundo, $mes, $dia, $ano);
               
                $dia = date("d", strtotime($os[$x][data_conclusao]));
                $mes = date("m", strtotime($os[$x][data_conclusao]));
                $ano = date("Y", strtotime($os[$x][data_conclusao]));
                $hora = date("H", strtotime($os[$x][data_conclusao]));
                $minuto = date("i", strtotime($os[$x][data_conclusao]));
                $segundo = date("s", strtotime($os[$x][data_conclusao]));
                $prazo_termino = mktime($hora, $minuto, $segundo, $mes, $dia, $ano);
            
            //echo $prazo_termino-$abertura;
                $prazo = $prazo_termino-$abertura;
            
            //1 dia = 86400 segundos
            //echo "<BR>";
                if($os[$x][status] != 4 || $_SESSION[grupo]=="administrador"){
                $status = "";
                $prioridade = "";
                switch($os[$x][status]){
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

                if($os[$x][status] == 0 && $prazo <0 && !empty($os[$x][data_conclusao])){
                    $status = "Pendente";
                    $os[$x][status] = 5;
                    $sql = "UPDATE os_info SET status=5 WHERE id = '{$os[$x][id]}'";
                    pg_query($sql);
                }
                
                switch($os[$x][prioridade]){
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
                
                $sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$os[$x][para]}'";
                $result = pg_query($sql);
                $para = pg_fetch_array($result);
                
                if($para[nome]){
                $n = explode(" ", $para[nome]);
                if(strlen($n[1])>3){
                    $nome = $n[0]." ".$n[1];
                }else{
                    $nome = $n[0]." ".$n[1]." ".$n[2];
                }
                }
                
                $sql = "SELECT * FROM funcionario WHERE funcionario_id = '{$os[$x][aberto_por]}'";
                $result = pg_query($sql);
                $by = pg_fetch_array($result);

                if($by[nome]){
                $n = explode(" ", $by[nome]);
                if(strlen($n[1])>3){
                    $por = $n[0]." ".$n[1];
                }else{
                    $por = $n[0]." ".$n[1]." ".$n[2];
                }
                }
                
                echo "<tr>";
                echo "<td class=fontebranca12 align=center>".STR_PAD($os[$x][id], 4, "0", STR_PAD_LEFT)."/".date("Y", strtotime($os[$x][data_abertura]) )."</td>";
                echo "<td class=fontebranca12 align=center>".date("d/m/Y H:i", strtotime($os[$x][data_abertura]) )."</td>";

                $sql = "SELECT o.*, f.nome FROM os_msg o, funcionario f
                WHERE cod_os = '{$os[$x][id]}'
                AND
                o.postado_por = f.funcionario_id
                ORDER BY o.data_postagem
                ";
                $rmsg = pg_query($sql);
                $lmsg = pg_fetch_all($rmsg);
                $l = pg_num_rows($rmsg)-1;
                
                //if($os[$x][aberto_por] == $lmsg[$l][postado_por]){
                
                //exibir cartinha se tiver msg de outro usuário como última
                if($_SESSION[usuario_id] != $lmsg[$l][postado_por] && $_SESSION[usuario_id] == $os[$x][para] && $os[$x][readed] == 0){
                    //se for pra qualquer 1 ou pra mim
                    if($_SESSION[usuario_id] == $os[$x][para] || $os[$x][para] == 0){
                        //se não tiver finalizado nem cancelado
                        if($os[$x][status] == 0 || $os[$x][status] == 2){
                            $new = "<img src='new.gif' borer=0 width=21 height=12>";
                        }else{
                            $new = "<img src='nonew.gif' width=21 height=12 border=0>";
                        }
                    }else{
                        $new = "<img src='nonew.gif' width=21 height=12 border=0>";
                    }
                }else{
                    //Se owner logado
                    if($_SESSION[usuario_id] == $os[$x][aberto_por]){
                        if($os[$x][readed_owner]){
                            $new = "<img src='nonew_readed.png' border=0 width=21 height=16>";
                        }else{
                            $new = "<img src='new.gif' border=0 width=21 height=12>";
                        }
                        /*
                        if(($os[$x][status] == 0 || $os[$x][status] == 2 ||$os[$x][status] == 5)){
                            if($lmsg[$l][postado_por] == $os[$x][aberto_por]){
                                $new = "<img src='nonew_readed.png border=0 width=21 height=16>'";
                            }else{
                                $new = "<img src='new.gif border=0 width=21 height=12>'";
                            }
                        }else{
                        }
                        */
                    //Se usuário diferente de owner
                    }else{
                        //if($lmsg[$l][postado_por] == $os[$x][aberto_por] && ($os[$x][status] == 0 || $os[$x][status] == 2 ||$os[$x][status] == 5)){
                        //    $new = "<img src='new.gif' width=21 height=12 border=0>";
                        //}else{
                            if($os[$x][readed]){
                                $new = "<img src='nonew_readed.png' width=21 height=16 border=0>";
                            }else{
                                $new = "<img src='nonew.gif' width=21 height=12 border=0>";
                            }
                        //}
                    }
                    /*
                    if($lmsg[$l][postado_por] == $os[$x][aberto_por] && ($os[$x][status] == 0 || $os[$x][status] == 2 ||$os[$x][status] == 5)){
                        $new = "<img src='new.gif' width=21 height=12 border=0>";
                    }else{
                        if($os[$x][readed]){
                            $new = "<img src='nonew_readed.png' width=21 height=16 border=0>";
                        }else{
                            $new = "<img src='nonew.gif' width=21 height=12 border=0>";
                        }
                    }
                    */
                }
                $lnome = explode(" ", $lmsg[$l][nome]);
                if(strlen($lnome[1])>3){
                    $nomecurto = $lnome[0]." ".$lnome[1];
                }else{
                    $nomecurto = $lnome[0]." ".$lnome[1]." ".$lnome[2];
                }
                
                if($os[$x][status] == 4){
                    $new = "<img src='deleted.png' width=21 height=12 border=0 alt='O.S. Deletada! Só disponível para Administradores.' title='O.S. Deletada! Só disponível para Administradores.'>";
                    echo "<td class=fontebranca12>$new &nbsp;<b>
                    <a href='?action=view&os={$os[$x][id]}' class=fontebranca12><i>{$os[$x][assunto]}</i></a></b>
                    <BR><font size=1><i><b>Última mensagem:</b> {$nomecurto}</i></font></td>";
                }else{
                    echo "<td class=fontebranca12>$new &nbsp;<b>
                    <a href='?action=view&os={$os[$x][id]}' class=fontebranca12><b>{$os[$x][assunto]}</b></a></b>
                    <BR><font size=1><b>Última mensagem: </b>{$nomecurto}</font></td>";
                }
                echo "<td class=fontebranca12 align=center><font size=1>Por: {$por}</font><BR>{$os[$x][nome_setor]}"; print $para[nome] ? "<br><font size=1>Para: $nome</font>" : "<br><font size=1>&nbsp;</font>"; echo "</td>";
                echo "<td class=fontebranca12 align=center ";
                switch($os[$x][status]){
                    case 0:
                        echo " bgcolor='#66000c' ";
                    break;
                    case 1:
                        echo " bgcolor='#19cb72' ";
                    break;
                    case 2:
                        echo " bgcolor='#cbb819' ";
                    break;
                    case 3:
                        echo " bgcolor='#868580' ";
                    break;
                    case 4:
                        echo " bgcolor='#868580' ";
                    break;
                    case 5:
                        echo " bgcolor='#cbb819' ";
                    break;
                    default:
                        echo " bgcolor='#006633' ";
                    break;
                }
                echo " >$status</td>";
                echo "<td class=fontebranca12 align=center>$prioridade</td>";
                echo "</tr>";
            }
            }

        echo "</table>";
        }else{
            echo "<center><span class=fontebranca12><b>Nenhuma O.S. encontrada!</b></span></center>";
        }
        
        echo "<table BORDER=0 align=center width=100%>";
        echo "<tr>";
        echo "<td width=150 align=center class=fontebranca12><b>Legenda:</b></td>";
        echo "<td class=fontebranca12>&nbsp;</td>";
        echo "<td>";
        echo "</tr>";
        
        echo "<tr>";
        echo "<td width=150 align=left class=fontebranca12><b>Nova Mensagem:</b></td>";
        echo "<td class=fontebranca12><img src='new.gif' border=0 width=21 height=12></td>";
        echo "<td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width=150 align=left class=fontebranca12><b>Mensagem lida:</b></td>";
        echo "<td class=fontebranca12><img src='nonew_readed.png' border=0 width=21 height=16></td>";
        echo "<td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td width=150 align=left class=fontebranca12><b>Mensagem p/ setor:</b></td>";
        echo "<td class=fontebranca12><img src='nonew.gif' border=0 width=21 height=12></td>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";

?>
