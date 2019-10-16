<?PHP
function anti_injection($sql){
    // remove palavras que contenham sintaxe sql
    $sql = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"),"",$sql);
    $sql = trim($sql);//limpa espaços vazio
    $sql = strip_tags($sql);//tira tags html e php
    $sql = addslashes($sql);//Adiciona barras invertidas a uma string
    return $sql;
}

function redirectme($url){
    echo "<script>location.href='{$url}';</script>";
}

//EXIBE MENSAGEM NO TOPO DA PÁGINA POR UM TEMPO DETERMINADO
function showMessage($msg, $icon=0, $refresh=0, $time=3600, $obj='sysmsg'){
    $time *= 1000;
    switch($icon){
        case 0: //ok
            if($refresh)
                echo "<script>showMSG('".$obj."', '<table width=100% height=100% border=0 align=center><tr><td class=msgh align=left><table width=100%><tr><td width=25 height=25 align=center><img src=\"images/done-tip.png\" border=0 align=baseline></td><td class=text><font color=white>Mensagem do sistema</font></td><td width=60><a href=\"javascript:hideMsg(\'$obj\');\"><img src=\"images/imclose-tip.png\" border=0></a></td></tr></table></td></tr><tr><td align=left class=btext>".$msg."</td></tr><tr><td valign=bottom align=center><input type=button class=btn value=Ok name=btnsmok onclick=\"javascript:location.href=\'?{$_SERVER[QUERY_STRING]}&redirected=1\';\"></td></tr></table>', ".$time.");</script>";
            else
                echo "<script>showMSG('".$obj."', '<table width=100% height=100% border=0 align=center><tr><td class=msgh align=left><table width=100%><tr><td width=25 height=25 align=center><img src=\"images/done-tip.png\" border=0 align=baseline></td><td class=text><font color=white>Mensagem do sistema</font></td><td width=60><a href=\"javascript:hideMsg(\'$obj\');\"><img src=\"images/imclose-tip.png\" border=0></a></td></tr></table></td></tr><tr><td align=left class=btext>".$msg."</td></tr><tr><td valign=bottom align=center><input type=button class=btn value=Ok name=btnsmok onclick=\"javascript:hideMsg(\'$obj\');\"></td></tr></table>', ".$time.");</script>";
        break;
        case 1: //error
            echo "<script>showMSG('".$obj."', '<table width=100% height=100% border=0 align=center><tr><td class=msgh align=left><table width=100%><tr><td width=25 height=25 align=center><img src=\"images/restricted-tip.png\" border=0 align=baseline></td><td class=text><font color=white>Mensagem do sistema</font></td><td width=60><a href=\"javascript:hideMsg(\'$obj\');\"><img src=\"images/imclose-tip.png\" border=0></a></td></tr></table></td></tr><tr><td align=left class=btext>".$msg."</td></tr><tr><td valign=bottom align=center><input type=button class=btn value=Ok name=btnsmok onclick=\"javascript:hideMsg(\'$obj\');\"></td></tr></table>', ".$time.");</script>";
        break;
        case 2: //Alert
            echo "<script>showMSG('".$obj."', '<table width=100% height=100% border=0 align=center><tr><td class=msgh align=left><table width=100%><tr><td width=25 height=25 align=center><img src=\"images/alert-tip.png\" border=0 align=baseline></td><td class=text><font color=white>Mensagem do sistema</font></td><td width=60><a href=\"javascript:hideMsg(\'$obj\');\"><img src=\"images/imclose-tip.png\" border=0></a></td></tr></table></td></tr><tr><td align=left class=btext>".$msg."</td></tr><tr><td valign=bottom align=center><input type=button class=btn value=Ok name=btnsmok onclick=\"javascript:hideMsg(\'$obj\');\"></td></tr></table>', ".$time.");</script>";
        break;
    }
}

function makelog($uname, $msg, $action=0, $sql=""){
    @include('database/conn.php');
    $sql = "INSERT INTO log
    (usuario_id, data, detalhe, action_id, sql)
    values
    ('{$uname}', '".date('m/d/Y H:i:s')."', '{$msg}', '{$action}', '".addslashes($sql)."')";
    @pg_query($sql);
}

function dateDiff($sDataInicial, $sDataFinal){
    $sDataI = explode("-", $sDataInicial);
    $sDataF = explode("-", $sDataFinal);

    $nDataInicial = mktime(0, 0, 0, $sDataI[1], $sDataI[0], $sDataI[2]);
    $nDataFinal = mktime(0, 0, 0, $sDataF[1], $sDataF[0], $sDataF[2]);

    return ($nDataInicial > $nDataFinal) ?
    floor(($nDataFinal - $nDataInicial)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
       //floor(($nDataInicial - $nDataFinal)/86400) : floor(($nDataFinal - $nDataInicial)/86400);
}
/**************************************************************************************************************/
// -> FUNCTION - cgrt_setor_progress
// Parâmetros:
// cod_cgrt  (integer) -> Código do relatório
// cod_setor (integer) -> Código do setor a ser calculado
//
// Obtém % de conclusão de um setor de um cadastro de relatórios.
/**************************************************************************************************************/
function cgrt_setor_progress($cod_cgrt, $cod_setor){
    if(is_numeric($cod_cgrt) && is_numeric($cod_setor)){
        @include('database/conn.php');
        $sql = "SELECT * FROM cgrt_info WHERE cod_cgrt = ".(int)($cod_cgrt)."";
        $res = pg_query($sql);
        $info = pg_fetch_array($res);
        
        //Se o cod cgrt existir, continua...
        if(pg_num_rows($res)>0){
            $sql = "SELECT * FROM cliente_setor WHERE id_ppra = ".(int)($cod_cgrt)." AND cod_setor = ".(int)($cod_setor);
            $rse = pg_query($sql);
            $set = pg_fetch_array($rse);
            
            $progress = 0;
            
            //verificar: Informações do relatório  [4]
            //Jornada, Ano, Elaboradores
            if($info[jornada])
                $progress++;
            if($info[ano])
                $progress++;
            if($info[id_resp_ppra])
                $progress++;
            if($info[id_resp_pcmso])
                $progress++;

            //verificar: Dados complementares [6]
            //Pé direito, Frente, Comprimento, Aparelho de medição, Pavimentos, data e hora avaliação

            if($info[pe_direito])
                $progress++;
            if($info[frente])
                $progress++;
            if($info[comprimento])
                $progress++;
            if($info[aparelho_medicao_metragem])
                $progress++;
            if($info[n_pavimentos])
                $progress++;
            if($info[data_avaliacao])
                $progress++;


            //verificar: Lista de funcionários [??????]
            

            //verificar: Posto de trabalho (se houver)  [1]
            //Pelo menos 1 posto de trabalho cadastrado
            if($set[is_posto_trabalho] && $set[id_pt]){
                //$sql = "SELECT * FROM posto_trabalho WHERE cod_cliente = ".(int)($info[cod_cliente]);
                //if(pg_num_rows(pg_query($sql)))
                    $progress++;
            }

            //verificar:Edificação
            //14 ou 15 items (se houver posto de trabalho)
            if($set[cod_luz_nat])
                $progress++;
            if($set[cod_luz_art])
                $progress++;
            if($set[cod_vent_nat])
                $progress++;
            if($set[cod_vent_art])
                $progress++;
            if($set[cod_edificacao])
                $progress++;
            if($set[cod_piso])
                $progress++;
            if($set[cod_parede])
                $progress++;
            if($set[cod_cobertura])
                $progress++;
            if($set[ruido_fundo_setor])
                $progress++;
            if($set[ruido_operacao_setor])
                $progress++;
            if($set[ruido])
                $progress++;
            if($set[temperatura])
                $progress++;
            if($set[umidade])
                $progress++;
            if($set[termico])
                $progress++;
            if($set[id_pt])
                $progress++;

            //verificar: Iluminância
            //pelo menos 1 cadastrado
            $sql = "SELECT * FROM iluminacao_ppra WHERE id_ppra = ".(int)($cod_cgrt)." AND cod_setor = ".(int)($cod_setor);
            if(pg_num_rows(pg_query($sql)))
                $progress++;

            //verificar: Agentes nocivos
            //pelo menos 1 cadastrado
            $sql = "SELECT * FROM risco_setor WHERE id_ppra = ".(int)($cod_cgrt)." AND cod_setor = ".(int)($cod_setor);
            if(pg_num_rows(pg_query($sql)))
                $progress++;

            //verificar: Medidas preventivas
            //Se existirem medidas preventivas para o setor/função, verificar se foi gravado.
            $sql = "
            SELECT id, descricao, cod_produto, 1 as t FROM funcao_epi WHERE cod_epi IN (SELECT cod_funcao FROM cgrt_func_list WHERE cod_cgrt = ".(int)($cod_cgrt)." AND cod_setor = ".(int)($cod_setor)." GROUP BY cod_funcao ORDER BY cod_funcao)
            UNION
            SELECT id, descricao, cod_produto, 2 as t FROM setor_epi WHERE cod_setor = ".(int)($cod_setor)."
            UNION
            SELECT id, descricao, cod_produto, 1 as t FROM funcao_curso WHERE cod_curso IN (SELECT cod_funcao FROM cgrt_func_list WHERE cod_cgrt = ".(int)($cod_cgrt)." AND cod_setor = ".(int)($cod_setor)." GROUP BY cod_funcao ORDER BY cod_funcao)
            UNION
            SELECT id, descricao, cod_produto, 2 as t FROM setor_curso WHERE cod_setor = ".(int)($cod_setor)."
            UNION
            SELECT id, descricao, cod_produto, 1 as t FROM funcao_ambiental WHERE cod_funcao IN (SELECT cod_funcao FROM cgrt_func_list WHERE cod_cgrt = ".(int)($cod_cgrt)." AND cod_setor = ".(int)($cod_setor)." GROUP BY cod_funcao ORDER BY cod_funcao)
            UNION
            SELECT id, descricao, cod_produto, 2 as t FROM setor_ambiental WHERE cod_setor = ".(int)($cod_setor)."
            UNION
            SELECT id, descricao, cod_produto, 1 as t FROM funcao_programas WHERE cod_funcao IN (SELECT cod_funcao FROM cgrt_func_list WHERE cod_cgrt = ".(int)($cod_cgrt)." AND cod_setor = ".(int)($cod_setor)." GROUP BY cod_funcao ORDER BY cod_funcao)
            UNION
            SELECT id, descricao, cod_produto, 2 as t FROM setor_programas WHERE cod_setor = ".(int)($cod_setor);
            $rmp = pg_query($sql);
            if(pg_num_rows($rmp)){
                $sql = "SELECT * FROM sugestao WHERE id_ppra = ".(int)($cod_cgrt)." AND cod_setor = ".(int)($cod_setor);
                if(pg_num_rows(pg_query($sql)))
                $progress++;
            }

            $itotal = 26;

            //if($info[have_posto_trabalho])
            if($set[is_posto_trabalho] && $set[id_pt])
                $itotal += 2;//se pt +2
                
            if(pg_num_rows($rmp))
                $itotal++;//se medidas preventivas + 1

            $rval = round((($progress*100)/$itotal));//(($progress * $itotal) / 100);
            if($rval > 100) $rval = 100;
            return $rval;
        }else{//if exist cgrt_info
            return 0;
        }
    }else{//if is_numeric cod_cgrt and cod_setor
        return 0;
    }
}//end function

/*************************************************************************************************/
//EXIBE DIAS DISPONÍVEIS PARA AGENDAR CURSO DE DESIGNADO
/*************************************************************************************************/
function next_days($num_days){
   global $conn;
   $mes = date("n");
   $ano = date("Y");
   $tdias = date("t", mktime(0, 0, 0, $mes, 1, $ano));
   $diah =  date("d");
   $d = date("d");
   $dias = array();
   $sql = "SELECT participantes FROM agenda_cipa_config";
   $result = pg_query($sql);
   $config = pg_fetch_array($result);

       while(count($dias) < $num_days){
          if(date("w", mktime(0, 0, 0, $mes, $d, $ano)) == 1){
             $sql = "SELECT * FROM agenda_cipa_part WHERE data_realizacao = '".$ano."-".$mes."-".$d."'";
             $result = pg_query($sql);
             if(pg_num_rows($result)<$config[participantes]){
                $dias[] = $ano."/".$mes."/".$d;//date("d", mktime(0, 0, 0, $mes, $d, $ano));
             }
          }

          $d++;

          if($d > $tdias){
              //break;
              $d = 1;
              if($mes<=11){$mes++;}else{$mes=1;$ano++;}
              $tdias = date("t", mktime(0, 0, 0, $mes, 1, $ano));
          }
       }//end while
   return $dias;
}

?>
