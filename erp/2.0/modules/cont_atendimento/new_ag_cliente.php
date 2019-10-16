<?PHP
    switch($_GET[step]){
/******************************************************************************************************************/
// --> 1 : Seleção do cliente
/******************************************************************************************************************/
        case 1:
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td class='text'>";
            echo "<b>Resultado da busca:</b>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";

            if($_POST && $_POST[search]){
                $search = anti_injection($_POST[search]);
                if(is_numeric($search))
                    $sql = "SELECT * FROM cliente WHERE cliente_id = ".(int)($search);
                else
                    $sql = "SELECT * FROM cliente WHERE LOWER(razao_social) LIKE '%".strtolower($search)."%'";

                $res = pg_query($sql);
                if(pg_num_rows($res)>0){
                    $clist = pg_fetch_all($res);
                    
                    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                    for($x=0;$x<pg_num_rows($res);$x++){
                        echo "<tr class='text roundbordermix'>";
                        echo "<td align=center width=25 class='text roundborder' >".str_pad($clist[$x][cliente_id], 4, "0", 0)."</td>";
                        echo "<td align=left class='text roundborder curhand' width=100% onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=$_GET[sp]&step=2&cod_cliente={$clist[$x][cliente_id]}';\">";
                        echo $clist[$x][razao_social];
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            }
        break;
/******************************************************************************************************************/
// --> 2 : CRIAÇÃO DE DADOS NA TABELA
/******************************************************************************************************************/
        case 2:
            if(is_numeric($_GET[cod_cliente])){
                $sql = "SELECT MAX(cod_agendamento) as max FROM site_agendamento_aso";
                $max = pg_fetch_array(pg_query($sql));
                $max = $max[max] + 1;
                
                $sql = "INSERT INTO site_agendamento_aso
                (cod_agendamento, cod_cliente, data_criacao)
                VALUES
                ('$max','".(int)($_GET[cod_cliente])."','".date("Y-m-d")."')";
                if(pg_query($sql))
                    redirectme("?dir=$_GET[dir]&p=$_GET[p]&sp=$_GET[sp]&step=3&cod_agendamento=$max");
                else
                   showMessage('Não foi possível gerar o agendamento. Por favor, entre em contato com o setor de suporte!',2);
            }
        break;
/******************************************************************************************************************/
// --> 3 : SELEÇÂO DOS FUNCIONÁRIOS
/******************************************************************************************************************/
        case 3:
            if(is_numeric($_GET[cod_agendamento])){
                if($_POST && $_POST[btnSaveFuncList] && $_POST[funclist]){
                    //print_r($_POST);
                    showmessage("Aguarde, atualizando lista de funcionários...",2);
                    $error = array();
                    for($y=0;$y<count($_POST[funclist]);$y++){
                        if(is_numeric($_POST[funclist][$y])){
                            //get func data
                            $sql = "SELECT * FROM funcionarios WHERE cod_cliente = $aginfo[cod_cliente] AND cod_func = {$_POST[funclist][$y]}";
                            $fdata = @pg_fetch_array(@pg_query($sql));
                            //get exame data for the func function
                            $sql = "SELECT * FROM funcao_exame WHERE cod_exame = $fdata[cod_funcao]";
                            $rel = @pg_query($sql);
                            $exl = @pg_fetch_all($rel);
                            //loop to populate sql
                            for($i=0;$i<@pg_num_rows($rel);$i++){
                                $sql = "INSERT INTO site_agendamento_exame
                                (cod_agendamento, cod_cliente, cod_func, cod_exame)
                                VALUES
                                ('".(int)($_GET[cod_agendamento])."','$aginfo[cod_cliente]','$fdata[cod_func]','{$exl[$i][exame_id]}')";
                                if(@pg_query($sql)){

                                }else{
                                    $error[] = $fdata[cod_func];
                                }
                            }//for exame list
                        }//is_numeric
                    }//for funclist
                    redirectme("?dir=$_GET[dir]&p=$_GET[p]&sp=$_GET[sp]&step=$_GET[step]&cod_agendamento=$_GET[cod_agendamento]");
                }//post

                if($_POST && $_POST[btnSearchFunc]){
                    $sql = "SELECT * FROM funcionarios
                    WHERE
                        cod_cliente = {$aginfo[cod_cliente]}
                    AND
                        LOWER(nome_func) LIKE '%".strtolower(anti_injection($_POST[search]))."%'
                    AND
                         cod_func NOT IN (SELECT cod_func FROM site_agendamento_exame WHERE cod_agendamento = ".(int)($_GET[cod_agendamento]).")
                    ORDER BY nome_func";
                }else{
                    $sql = "SELECT * FROM funcionarios
                    WHERE
                        cod_cliente = {$aginfo[cod_cliente]}
                    AND
                        cod_func NOT IN (SELECT cod_func FROM site_agendamento_exame WHERE cod_agendamento = ".(int)($_GET[cod_agendamento]).")
                    ORDER BY nome_func";
                }
                $rfu = @pg_query($sql);
                $fli = @pg_fetch_all($rfu);
                
                echo "- Selecione os funcionários abaixo para gerar os agendamentos.<p>";
                
                echo "<form name='frmFuncList' method='post'>";
                
                echo "<div style=\"min-height:250px;height:auto !important;height:250px;\">";
                echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                echo "<tr>";
                echo "<td class='text'>";
                echo "<b>Lista de funcionários:</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
                
                echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                for($x=0;$x<@pg_num_rows($rfu);$x++){
                    //$fli[$x][nome_func] = str_replace(strtolower($_POST[search]), '<b>'.strtolower($_POST[search]).'</b>', strtolower($fli[$x][nome_func]));
                    echo "<tr class='text roundbordermix'>";
                    echo "<td align=left width=20 id='chk$x' class='text roundborder' valign=middle><input type=checkbox name='funclist[]' id='fnc$x' value='{$fli[$x][cod_func]}' onclick=\"if(this.checked == false){ document.getElementById('chk$x').className = 'roundborder text curhand';document.getElementById('name$x').className = 'roundborder text curhand';}else{document.getElementById('chk$x').className = 'roundborderselected text curhand';document.getElementById('name$x').className = 'roundborderselected text curhand';}\"></td>";
                    echo "<td align=left id='name$x' class='text roundborder curhand' onclick=\"if(document.getElementById('fnc$x').checked){ document.getElementById('fnc$x').checked = false; document.getElementById('chk$x').className = 'roundborder text curhand';document.getElementById('name$x').className = 'roundborder text curhand';}else{document.getElementById('fnc$x').checked = true; document.getElementById('chk$x').className = 'roundborderselected text curhand';document.getElementById('name$x').className = 'roundborderselected text curhand';}\">";
                    echo $fli[$x][nome_func];
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
                echo "<p>";

                echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
                    echo "<tr>";
                    echo "<td align=left class='text'>";
                        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                        echo "<tr>";
                            echo "<td align=center class='text roundbordermix'>";
                            echo "<input type='submit' class='btn' name='btnSaveFuncList' value='Selecionar' onmouseover=\"showtip('tipbox', '- Selecionar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";
                            echo "&nbsp;";
                            echo "<input type='button' class='btn' name='btnNext' value='Avançar' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=$_GET[sp]&step=4&cod_agendamento=$_GET[cod_agendamento]';\" onmouseover=\"showtip('tipbox', '- Continuar.');\" onmouseout=\"hidetip('tipbox');\" >";
                        echo "</td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</form>";
                    echo "</tr>";
                echo "</table>";
                
                echo "</form>";
            }
        break;
/******************************************************************************************************************/
// --> 4 : SELEÇÃO DE CLÍNICA
/******************************************************************************************************************/
        case 4:
            if(is_numeric($_GET[cod_agendamento])){
                /*
                echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                echo "<tr>";
                echo "<td class='text'>";
                echo "<b>Clínicas disponíveis:</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
                */
                $sql = "SELECT * FROM clinicas WHERE ativo = 1";
                $rcl = pg_query($sql);
                $clinicas = pg_fetch_all($rcl);
                
                $sql = "SELECT cod_exame FROM site_agendamento_exame WHERE cod_agendamento = ".(int)($_GET[cod_agendamento])." GROUP BY cod_exame";
                $rne = pg_query($sql);
                $exames = pg_fetch_all($rne);

                $fix = "";
                for($i=0;$i<pg_num_rows($rne);$i++){
                    $fix .= " cod_exame = {$exames[$i][cod_exame]}";
                    if($i < pg_num_rows($rne) -1)
                        $fix .= " OR ";
                }
                
                echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
                echo "<tr>";
                echo "<td align=left class='text'><b>Clínicas disponíveis:</b></td>";
                echo "<td align=left width=85 class='text'><b>Valor total: </b></td>";
                echo "</tr>";
                for($x=0;$x<pg_num_rows($rcl);$x++){
                    $sql = "SELECT * FROM clinica_exame WHERE cod_clinica = {$clinicas[$x][cod_clinica]} AND ";
                    $sql .= "($fix)";
                    $rai = pg_query($sql);
                    $exdetail = pg_fetch_all($rai);

                    //número de exames retornados da pesquisa acima = n items de exames
                    if(pg_num_rows($rai) == pg_num_rows($rne)){
                        //total dos exames
                        $sql = "SELECT SUM (CAST(ce.preco_exame as NUMERIC)) as soma FROM clinica_exame ce, site_agendamento_exame ae
                        WHERE ae.cod_exame = ce.cod_exame AND ce.cod_clinica = {$clinicas[$x][cod_clinica]}
                        AND
                        ae.cod_agendamento = ".(int)($_GET[cod_agendamento]);
                        $total = pg_fetch_array(pg_query($sql));
                        $total = $total[soma];

                        echo "<tr class='text roundbordermix'>";
                        //echo "<td align=center width=25 class='text roundborder' >".str_pad($clist[$x][cliente_id], 4, "0", 0)."</td>";
                        echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=$_GET[sp]&step=5&cod_agendamento=$_GET[cod_agendamento]&cod_clinica={$clinicas[$x][cod_clinica]}';\">";
                        echo $clinicas[$x][razao_social_clinica];
                        echo "</td>";
                        echo "<td align=right width=85 class='text roundborder' >R$ ".number_format($total, 2, ',','.')."</td>";
                        echo "</tr>";
                    }
                }
                echo "</table>";

            }
        break;
/******************************************************************************************************************/
// --> 5 : CONFIRMAÇÃO DE CLÍNICA E ATUALIZAçÃO DA TABELA
/******************************************************************************************************************/
        case 5:
            if(is_numeric($_GET[cod_agendamento])){
                //
                $sql = "UPDATE site_agendamento_aso SET cod_clinica = ".(int)($_GET[cod_clinica])." WHERE cod_agendamento = ".(int)($_GET[cod_agendamento]);
                if(pg_query($sql)){
                    $sql = "SELECT cod_exame FROM site_agendamento_exame WHERE cod_agendamento = ".(int)($_GET[cod_agendamento])." GROUP BY cod_exame";
                    $rne = pg_query($sql);
                    $exames = pg_fetch_all($rne);
                    $fix = "";
                    for($i=0;$i<pg_num_rows($rne);$i++){
                        $fix .= " cod_exame = {$exames[$i][cod_exame]}";
                        if($i < pg_num_rows($rne) -1)
                            $fix .= " OR ";
                    }
                    $sql = "SELECT * FROM clinica_exame WHERE cod_clinica = ".(int)($_GET[cod_clinica])." AND ";
                    $sql .= "($fix)";
                    $rai = pg_query($sql);
                    $exdetail = pg_fetch_all($rai);
                    $erros = 0;
                    for($x=0;$x<pg_num_rows($rai);$x++){
                        $sql = "UPDATE site_agendamento_exame SET preco_exame_agendado = '{$exdetail[$x][preco_exame]}' WHERE cod_agendamento = ".(int)($_GET[cod_agendamento])." AND cod_exame = {$exdetail[$x][cod_exame]}";
                        if(pg_query($sql)){
                        
                        }else{
                            $erros++;
                        }
                    }
                    if($erros == 0){
                        redirectme("?dir=$_GET[dir]&p=$_GET[p]&sp=$_GET[sp]&step=6&cod_agendamento=$_GET[cod_agendamento]");
                    }else{
                        //alguns exames não foram relacionados com os preços cadastrados
                    }
                }else{
                    showMessage('Não foi possível confirmar a clínica para este agendamento. Por favor, entre em contato com o setor de suporte!',1);
                }
            }
        break;
/******************************************************************************************************************/
// --> 6 :
/******************************************************************************************************************/
        case 6:
            if(is_numeric($_GET[cod_agendamento])){

            }
        break;

/******************************************************************************************************************/
// --> DEFAULT
/******************************************************************************************************************/
        default:

        break;
    }
?>
