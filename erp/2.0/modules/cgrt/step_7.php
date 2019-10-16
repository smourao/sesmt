<?PHP
    $sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
    $result = pg_query($sql);
    $cinfo = pg_fetch_array($result);
    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";
    echo "<td align=center class='text roundborderselected'>";
    echo "<b>$cinfo[razao_social]</b>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    

    switch($_GET[a]){
        /**********************************************************************************************/
        // --> SEARCH
        /**********************************************************************************************/
        case 's':
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td class='text'>";
            echo "<b>Resultado da busca por posto de trabalho:</b>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            
            if($_POST && $_POST[search]){
                if(is_numeric($_POST[search]))
                    $sql = "SELECT * FROM posto_trabalho WHERE cod_posto_trabalho = ".(int)($_POST[search]);
                else
                    $sql = "SELECT * FROM posto_trabalho WHERE lower(razao_social) LIKE '%".$_POST[search]."%'";

                $rpt = pg_query($sql);
                $ptlist = pg_fetch_all($rpt);

                echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";

                for($x=0;$x<pg_num_rows($rpt);$x++){
                    echo "<tr class='roundbordermix'>";
                    echo "<td align=left class='text ";
                    print $ptlist[$x][cod_posto_trabalho] == $cgrt_info[cod_posto_trabalho] ? "roundborderselected" : "roundborder";
                    echo " curhand'>{$ptlist[$x][razao_social]}</td>";
                    echo "</tr>";
                }

                echo "</table>";
                echo "<p>";
            }
        break;
        /**********************************************************************************************/
        // --> NEW
        /**********************************************************************************************/
        case 'n':
            //NOVO CADASTRO
            if($_POST && $_POST[btnSaveNewPT]){
                $sql = "SELECT MAX(cod_posto_trabalho) as max FROM posto_trabalho";
                $cod_pt = pg_fetch_array(pg_query($sql));
                $cod_pt = $cod_pt[max]+1;
                $sql = "INSERT INTO posto_trabalho
                (cod_posto_trabalho, razao_social, endereco, num_end, bairro, municipio, cep, cnpj, estado, cod_cliente, telefone, fax, celular, email, cnae, grau_de_risco)
                VALUES
                (".(int)($cod_pt).", '".anti_injection($_POST[razao_social])."', '".anti_injection($_POST[endereco])."'
                , '".(int)($_POST[num_end])."', '".anti_injection($_POST[bairro])."', '".anti_injection($_POST[municipio])."'
                , '".anti_injection($_POST[cep])."', '".anti_injection($_POST[cnpj])."', '".anti_injection($_POST[estado])."'
                , '".(int)($_GET[cod_cliente])."', '".anti_injection($_POST[telefone])."', '".anti_injection($_POST[fax])."'
                , '".anti_injection($_POST[celular])."', '".anti_injection($_POST[email])."', '".anti_injection($_POST[cnae])."', '".(int)($_POST[grau_de_risco])."')";

                if(pg_query($sql)){
                    makelog($_SESSION[usuario_id], "[CGRT] Novo posto de trabalho cadastrado para o cliente cliente: $cod_cliente, cód do posto de trabalho: $cod_pt", 112);
                    redirectme("?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&npt=1");
                }else{
                    showMessage('Houve um erro ao cadastrar o posto de trabalho. Por favor, entre em contato com o setor de suporte!',1);
                    makelog($_SESSION[usuario_id], "[CGRT] Erro ao cadastrar posto de trabalho. cod_cliente: $cod_cliente, cód_pt: $cod_pt", 113, $sql);
                }
            }
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td class='text'>";
            echo "<b>Cadastro de novo posto de trabalho:</b>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";

            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td align=center class='text roundborderselected'>";
                echo "<form method=post id='frmCadPT' name='frmCadPT' action='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&a=n' onsubmit=\"return cgrt_pt_cf(this);\">";
                
                echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

                echo "<tr>";
                echo "<td align=left class=text width='100'>Razão Social:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=razao_social id=razao_social value='$buffer[razao_social]'></td>";
                echo "<td align=left class=text width='100'>CNPJ:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTexto' size=18 name=cnpj id=cnpj value='$buffer[cnpj]' maxlength='18' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###/####-##');\" "; if(!is_numeric($_GET[cod_cliente])) echo ">&nbsp;<span id='verify_cnpj' class=''></span></td>";
                echo "</tr>";
		
				echo "<tr>";
                echo "<td align=left class=text width='100'>CNAE:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTexto' size=35 name=cnae id=cnae value='$buffer[cnae]'></td>";
                echo "<td align=left class=text width='100'>Grau de Risco:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTexto' size=35 name=grau_de_risco id=grau_de_risco value='$buffer[grau_de_risco]'></td>";
                echo "</tr>";
	
                echo "<tr>";
                echo "<td align=left class=text width='100'>CEP:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=10 name=cep id=cep value='$buffer[cep]' maxlength='9' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '#####-###');\" onblur=\"check_cep(this);\">&nbsp;<span id='verify_cep'></span></td>";
                echo "<td align=left class=text width='100'>Estado:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=estado id=estado value='$buffer[estado]'></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td align=left class=text width='100'>Endereço:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=endereco id=endereco value='$buffer[endereco]'></td>";
                echo "<td align=left class=text width='100'>Número:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=num_end id=num_end value='$buffer[num_end]' onkeydown=\"return only_number(event);\"></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td align=left class=text width='100'>Bairro:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=bairro id=bairro value='$buffer[bairro]'></td>";
                echo "<td align=left class=text width='100'>Município:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=municipio id=municipio value='$buffer[municipio]'></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td align=left class=text width='100'>Telefone:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=15 name=telefone id=telefone value='$buffer[telefone]' maxlength='14' onkeydown=\"return only_number(event);\" OnKeyPress=\"fone(this);\"></td>";
                echo "<td align=left class=text width='100'>Fax:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=fax id=fax value='$buffer[fax]' maxlength='14' onkeydown=\"return only_number(event);\" OnKeyPress=\"fone(this);\"></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td align=left class=text width='100'>Celular:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=celular id=celular value='$buffer[celular]' maxlength='14' onkeydown=\"return only_number(event);\" OnKeyPress=\"fone(this);\"></td>";
                echo "<td align=left class=text width='100'>E-Mail:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTexto' size=35 name=email id=email value='$buffer[email]'></td>";
                echo "</tr>";

                echo "</table>";
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
                        echo "<input type='submit' class='btn' name='btnSaveNewPT' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
                        echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                echo "</tr>";
            echo "</table>";

            echo "</form>";
        break;
        /**********************************************************************************************/
        // --> EDIT
        /**********************************************************************************************/
        case 'e':
            //NOVO CADASTRO
            if($_POST && $_POST[btnEditPT]){
                $sql = "UPDATE posto_trabalho
                SET
                razao_social = '".anti_injection($_POST[razao_social])."',
                endereco = '".anti_injection($_POST[endereco])."',
                num_end = '".(int)($_POST[num_end])."',
                bairro = '".anti_injection($_POST[bairro])."',
                municipio = '".anti_injection($_POST[municipio])."',
                cep = '".anti_injection($_POST[cep])."',
                cnpj = '".anti_injection($_POST[cnpj])."',
                estado = '".anti_injection($_POST[estado])."',
                telefone = '".anti_injection($_POST[telefone])."',
                fax = '".anti_injection($_POST[fax])."',
                celular = '".anti_injection($_POST[celular])."',
                email = '".anti_injection($_POST[email])."',
				cnae = '".anti_injection($_POST[cnae])."',
				grau_de_risco = '".anti_injection($_POST[grau_de_risco])."'
                WHERE id = ".(int)($_GET[id_pt]);

                if(@pg_query($sql)){
                    showMessage('Posto de trabalho atualizado!');
                    makelog($_SESSION[usuario_id], "[CGRT] Posto de trabalho atualizado. cod_cliente: $cod_cliente, id: $_GET[id_pt]", 116);
                }else{
                    showMessage('Houve um erro ao atualizar o posto de trabalho. Por favor, entre em contato com o setor de suporte!',1);
                    makelog($_SESSION[usuario_id], "[CGRT] Erro ao atualizar o posto de trabalho. cod_cliente: $cod_cliente, id: $_GET[id_pt]", 117, $sql);
                }
            }
            
            if(is_numeric($_GET[id_pt])){
                $sql = "SELECT * FROM posto_trabalho WHERE id = ".(int)($_GET[id_pt]);
                $buffer = pg_fetch_array(pg_query($sql));
            }
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td class='text'>";
            echo "<b>Cadastro de novo posto de trabalho:</b>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";

            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td align=center class='text roundborderselected'>";
                echo "<form method=post id='frmEditPT' name='frmEditPT' onsubmit=\"return cgrt_pt_cf(this);\">";

                echo "<table width=100% BORDER=0 align=center cellspacing=2 cellpadding=2>";

                echo "<tr>";
                echo "<td align=left class=text width='100'>Razão Social:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=razao_social id=razao_social value='$buffer[razao_social]'></td>";
                echo "<td align=left class=text width='100'>CNPJ:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTexto' size=18 name=cnpj id=cnpj value='$buffer[cnpj]' maxlength='18' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '##.###.###/####-##');\" "; if(!is_numeric($_GET[cod_cliente])) echo ">&nbsp;<span id='verify_cnpj' class=''></span></td>";
                echo "</tr>";
				
				echo "<tr>";
                echo "<td align=left class=text width='100'>CNAE:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTexto' size=35 name=cnae id=cnae value='$buffer[cnae]'></td>";
                echo "<td align=left class=text width='100'>Grau de Risco:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTexto' size=35 name=grau_de_risco id=grau_de_risco value='$buffer[grau_de_risco]'></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td align=left class=text width='100'>CEP:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=10 name=cep id=cep value='$buffer[cep]' maxlength='9' onkeydown=\"return only_number(event);\" OnKeyPress=\"formatar(this, '#####-###');\" onblur=\"check_cep(this);\">&nbsp;<span id='verify_cep'></span></td>";
                echo "<td align=left class=text width='100'>Estado:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=estado id=estado value='$buffer[estado]'></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td align=left class=text width='100'>Endereço:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=endereco id=endereco value='$buffer[endereco]'></td>";
                echo "<td align=left class=text width='100'>Número:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=5 name=num_end id=num_end value='$buffer[num_end]' onkeydown=\"return only_number(event);\"></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td align=left class=text width='100'>Bairro:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=bairro id=bairro value='$buffer[bairro]'></td>";
                echo "<td align=left class=text width='100'>Município:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=35 name=municipio id=municipio value='$buffer[municipio]'></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td align=left class=text width='100'>Telefone:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTextobr' size=15 name=telefone id=telefone value='$buffer[telefone]' maxlength='14' onkeydown=\"return only_number(event);\" OnKeyPress=\"fone(this);\"></td>";
                echo "<td align=left class=text width='100'>Fax:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=fax id=fax value='$buffer[fax]' maxlength='14' onkeydown=\"return only_number(event);\" OnKeyPress=\"fone(this);\"></td>";
                echo "</tr>";

                echo "<tr>";
                echo "<td align=left class=text width='100'>Celular:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputText' size=15 name=celular id=celular value='$buffer[celular]' maxlength='14' onkeydown=\"return only_number(event);\" OnKeyPress=\"fone(this);\"></td>";
                echo "<td align=left class=text width='100'>E-Mail:</td>";
                echo "<td align=left class=text width='220'><input type='text' class='inputTexto' size=35 name=email id=email value='$buffer[email]'></td>";
                echo "</tr>";

                echo "</table>";
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
                        echo "<input type='submit' class='btn' name='btnEditPT' value='Salvar' onmouseover=\"showtip('tipbox', '- Salvar, armazenará todos os dados selecionados até o momento no banco de dados.');\" onmouseout=\"hidetip('tipbox');\" >";//onclick=\"return confirm('Todos os dados serão salvos, tem certeza que deseja continuar?','');\"
                        echo "</td>";
                    echo "</tr>";
                    echo "</table>";
                echo "</tr>";
            echo "</table>";

            echo "</form>";
        break;
        /**********************************************************************************************/
        // --> DEFAULT
        /**********************************************************************************************/
        default:
            if($_GET[npt])
                showMessage('Posto de trabalho cadastrado com sucesso!');
                
            if(is_numeric($_GET[del])){
                $sql = "DELETE FROM posto_trabalho WHERE id = ".(int)($_GET[del]);
                if(pg_query($sql)){
                    showMessage('Posto de trabalho excluído com sucesso!');
                    makelog($_SESSION[usuario_id], "[CGRT] Posto de trabalho excluído. cod_cliente: $cod_cliente, cod_pt: $cod_pt", 114);
                }else{
                    showMessage('Houve um erro ao excluir o posto de trabalho. Por favor, entre em contato com o setor de suporte!',1);
                    makelog($_SESSION[usuario_id], "[CGRT] Erro ao excluir posto de trabalho. cod_cliente: $cod_cliente, cod_pt: $cod_pt", 115, $sql);
                }
            }
                
            echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
            echo "<td class='text'>";
            echo "<b>Postos de trabalho cadastrados:</b>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            
            $sql = "SELECT * FROM posto_trabalho WHERE cod_cliente = ".(int)($_GET[cod_cliente]);
            $rpt = pg_query($sql);
            $ptlist = pg_fetch_all($rpt);

                echo "<table width=100% border=0 cellspacing=2 cellpadding=2 align=center>";

                for($x=0;$x<pg_num_rows($rpt);$x++){
                    echo "<tr class='roundbordermix'>";
                    echo "<td align=left class='text roundborder curhand' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&a=e&id_pt={$ptlist[$x][id]}';\" alt='Clique aqui para editar este posto de trabalho.' title='Clique aqui para editar este posto de trabalho.'>{$ptlist[$x][razao_social]}</td>";
                    echo "<td align=center width=90 class='text roundborder'><a href='?dir=$_GET[dir]&p=$_GET[p]&step=$_GET[step]&cod_cliente=$_GET[cod_cliente]&cod_cgrt=$_GET[cod_cgrt]&del={$ptlist[$x][id]}'>Excluir</a></td>";
                    echo "</tr>";
                }

                echo "</table>";
                echo "<p>";

        break;
    }
?>
