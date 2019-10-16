<?PHP
/**************************************************************************************************/
// --> IF _POST && COD_CLIENTE = 'new' THEN: DO THE [REGISTER]
/**************************************************************************************************/
if($_POST[btnSave] && $_GET[cod_cliente]=='new'){
    foreach($_POST as $k => $v){
        $_POST[$k] = addslashes($v);//echo $k." -> ".$v."<BR>";
    }
    //get the cnae_id
    $sql = "SELECT cnae_id FROM cnae WHERE cnae = '{$_POST[cnae]}'";
    $res = pg_query($sql);
    $rcn = pg_fetch_array($res);

    //get cod_cliente and contract number
    $sql = "SELECT MAX(c.cliente_id)+1 as cliente_id, MAX(substr(c.ano_contrato, 6)) as ano_contrato FROM cliente c";
    $res = pg_query($sql);
    $data = pg_fetch_array($res);
    $data[ano_contrato] = date("Y")."/".($data[ano_contrato]+1);
	
      $sql = "INSERT INTO cliente
      (razao_social, nome_fantasia, endereco, bairro, cep, municipio, estado, telefone, fax, celular, email, cnpj, insc_estadual,
	  insc_municipal, descricao_atividade, numero_funcionarios, grau_de_risco, vendedor_id, cnae_id, cliente_id, filial_id,
      tel_contato_dir, nome_contato_dir, cargo_contato_dir, email_contato_dir, skype_contato_dir, msn_contato_dir,
	  nextel_contato_dir, nextel_id_contato_dir, escritorio_contador, tel_contador, email_contador, skype_contador, nome_contador,
	  nome_cont_ind, email_cont_ind, cargo_cont_ind, tel_cont_ind, msn_contador, skype_cont_ind, status, classe, ano_contrato,
	  num_end, num_rep, membros_brigada, nextel_contador, nextel_id_contador, data, relatorio_de_atendimento, crc_contador, cnpj_contratante,
	  contratante)
      VALUES
      ('{$_POST[razao_social]}','{$_POST[nome_fantasia]}','{$_POST[endereco]}','{$_POST[bairro]}','{$_POST[cep]}','{$_POST[municipio]}',
	  '{$_POST[estado]}','{$_POST[telefone]}','{$_POST[fax]}','{$_POST[celular]}','{$_POST[email]}','{$_POST[cnpj]}',
	  '{$_POST[insc_estadual]}','{$_POST[insc_municipal]}','{$_POST[descricao_atividade]}','{$_POST[numero_funcionarios]}',
      '{$_POST[grau_risco]}','{$_SESSION[usuario_id]}','{$rcn[cnae_id]}','{$data[cliente_id]}','1','{$_POST[tel_contato_dir]}',
	  '{$_POST[nome_contato_dir]}','{$_POST[cargo_contato_dir]}','{$_POST[email_contato_dir]}','{$_POST[skype_contato_dir]}',
	  '{$_POST[msn_cont_dir]}','{$_POST[nextel_cont_dir]}', '{$_POST[nextel_id_contato_dir]}','{$_POST[escritorio_contador]}',
      '{$_POST[tel_contador]}','{$_POST[email_contador]}','{$_POST[skype_contador]}','{$_POST[nome_contador]}','{$_POST[nome_cont_ind]}',
	  '{$_POST[email_cont_ind]}','{$_POST[cargo_cont_ind]}','{$_POST[tel_cont_ind]}','{$_POST[msn_contador]}','{$_POST[skype_cont_ind]}',
	  'comercial','{$_POST[classe]}','{$data[ano_contrato]}','{$_POST[num_end]}','{$_POST[membros_cipa]}','{$_POST[membros_brigada]}',
      '{$_POST[nextel_contador]}','{$_POST[nextel_id_contador]}','{$dat}','{$_POST[relatorio]}','{$_POST[crc_contador]}','{$_POST[cnpj_contratante]}','1')";
	  $regresult = @pg_query($sql);

	  if($regresult){
		  makelog($_SESSION[usuario_id], 'Novo cadastro de cliente, '.$data[cliente_id].' - '.$_POST[razao_social], 201);
	  }else{
		  foreach($_POST as $k => $v){
			  $buffer[$k] = addslashes($v);//echo $k." -> ".$v."<BR>";
		  }
		  makelog($_SESSION[usuario_id], 'Erro ao cadastrar cliente, '.$data[cliente_id].' - '.$_POST[razao_social], 202);
		  showMessage('<p align=justify>Não foi possível realizar este cadastro. Por favor, verifique se todos os campos obrigatórios foram preenchidos corretamente.<BR>Em caso de dúvidas, entre em contato com o setor de suporte!</p>', 1);
	  }
}

/**************************************************************************************************/
// --> IF _POST && COD_CLIENTE IS NUMERIC THEN: DO THE [UPDATE]
/**************************************************************************************************/
if($_POST[btnSave] && is_numeric($_GET[cod_cliente])){
    foreach($_POST as $k => $v){
        $_POST[$k] = addslashes($v);//echo $k." -> ".$v."<BR>";
    }
    //get the cnae_id
    $sql = "SELECT cnae_id FROM cnae WHERE cnae = '{$_POST[cnae]}'";
    $res = pg_query($sql);
    $rcn = pg_fetch_array($res);

      $sql = "UPDATE cliente SET
      razao_social 			= '{$_POST[razao_social]}',
      nome_fantasia 		= '{$_POST[nome_fantasia]}',
      endereco 				= '{$_POST[endereco]}',
      bairro 				= '{$_POST[bairro]}',
      cep 					= '{$_POST[cep]}',
      municipio 			= '{$_POST[municipio]}',
      estado 				= '{$_POST[estado]}',
      telefone 				= '{$_POST[telefone]}',
      fax 					= '{$_POST[fax]}',
      celular 				= '{$_POST[celular]}',
      email 				= '{$_POST[email]}',
      cnpj 					= '{$_POST[cnpj]}',
      insc_estadual 		= '{$_POST[insc_estadual]}',
      insc_municipal 		= '{$_POST[insc_municipal]}',
      descricao_atividade 	= '{$_POST[descricao_atividade]}',
      numero_funcionarios 	= '{$_POST[numero_funcionarios]}',
      grau_de_risco 		= '{$_POST[grau_risco]}',
      vendedor_id 			= '{$_SESSION[usuario_id]}',
      cnae_id 				= '{$rcn[cnae_id]}',
      tel_contato_dir 		= '{$_POST[tel_contato_dir]}',
      nome_contato_dir 		= '{$_POST[nome_contato_dir]}',
      cargo_contato_dir 	= '{$_POST[cargo_contato_dir]}',
      email_contato_dir 	= '{$_POST[email_contato_dir]}',
      skype_contato_dir 	= '{$_POST[skype_contato_dir]}',
      msn_contato_dir 		= '{$_POST[msn_cont_dir]}',
      nextel_contato_dir 	= '{$_POST[nextel_cont_dir]}',
      nextel_id_contato_dir = '{$_POST[nextel_id_contato_dir]}',
      escritorio_contador 	= '{$_POST[escritorio_contador]}',
      tel_contador 			= '{$_POST[tel_contador]}',
      email_contador 		= '{$_POST[email_contador]}',
      skype_contador 		= '{$_POST[skype_contador]}',
      nome_contador 		= '{$_POST[nome_contador]}',
      nome_cont_ind 		= '{$_POST[nome_cont_ind]}',
      email_cont_ind 		= '{$_POST[email_cont_ind]}',
      cargo_cont_ind 		= '{$_POST[cargo_cont_ind]}',
      tel_cont_ind 			= '{$_POST[tel_cont_ind]}',
      msn_contador 			= '{$_POST[msn_contador]}',
      skype_cont_ind 		= '{$_POST[skype_cont_ind]}',
      --status 				= 'ativo',
      classe 				= '{$_POST[classe]}',
      num_end 				= '{$_POST[num_end]}',
      num_rep 				= '{$_POST[membros_cipa]}',
      membros_brigada 		= '{$_POST[membros_brigada]}',
      nextel_contador 		= '{$_POST[nextel_contador]}',
      nextel_id_contador 	= '{$_POST[nextel_id_contador]}',
	  crc_contador 			= '{$_POST[crc_contador]}',
	  cnpj_contratante		= '{$_POST[cnpj_contratante]}',
	  relatorio_de_atendimento = '{$_POST[relatorio]}'
      WHERE cliente_id = {$_GET[cod_cliente]}";
	  $updresult = @pg_query($sql);

      if($updresult){
          showMessage('<p align=justify>Cadastro atualizado com sucesso.</p>');
          makelog($_SESSION[usuario_id], 'Atualização de cadastro de cliente, '.$_GET[cod_cliente].' - '.$_POST[razao_social], 203);
      }else{
          foreach($_POST as $k => $v){
              $buffer[$k] = addslashes($v);//echo $k." -> ".$v."<BR>";
          }
          makelog($_SESSION[usuario_id], 'Erro ao atualizar cadastro de cliente, '.$data[cliente_id].' - '.$_POST[razao_social], 204);
          showMessage('<p align=justify>Não foi possível atualizar este cadastro. Por favor, verifique se todos os campos obrigatórios foram preenchidos corretamente.<BR>Em caso de dúvidas, entre em contato com o setor de suporte!</p>', 1);
      }
}

//SE FOR PASSADO cod_cliente, SENÃO, NOVO CADASTRO
if(is_numeric($_GET[cod_cliente])){
    //Get client
    $sql = "SELECT * FROM cliente WHERE cliente_id = '{$_GET[cod_cliente]}'";
    $res = pg_query($sql);
    $buffer = pg_fetch_array($res);
	
	//Busca nome de vendedor
	$sql = "SELECT * FROM funcionario WHERE funcionario_id = {$buffer[vendedor_id]}";
	$rf = pg_query($sql);
	$ff = pg_fetch_array($rf);
	
	//cnae info
	$sql = "SELECT n.cnae, n.grau_risco, n.grupo_cipa, c.* FROM cliente c, cnae n WHERE cliente_id = '{$_GET[cod_cliente]}' AND c.cnae_id = n.cnae_id";
    $res = pg_query($sql);
    $buf = pg_fetch_array($res);
	
	if(!empty($buffer[data])){
	$d = $buffer[data];
	}elseif(!empty($dat)){
	$d = $dat;
	}else{
	$d = date("d/m/Y");
	}

    if($buffer[nome_contato_dir] == '') $buffer[nome_contato_dir] = 'Sr.(ª)';
    if($buffer[nome_cont_ind] == '')    $buffer[nome_cont_ind]    = 'Sr.(ª)';
    if($buffer[nome_contador] == '')    $buffer[nome_contador]    = 'Sr.(ª)';

    //Cálculo para membros de brigada de incêndio -> return $membros
    if($buffer[classe]!=""){
        $sql = "SELECT * FROM brigadistas WHERE classe = '$buffer[classe]'";
        $res = pg_query($sql);
        $row_calc = pg_fetch_array($res);
        $menor = $row_calc[ate_10];
        $maior = $row_calc[mais_10];
        if($buffer[numero_funcionarios]<=10)
            $calculo = $buffer[numero_funcionarios]*($menor/100);
        else
            $calculo = 10*($menor/100)+($buffer[numero_funcionarios]-10)*($maior/100);

        if($membros = round($calculo, 0) <= 0){
            $membros = "Não necessária";
        }else{
            $membros = round($calculo, 0);
        }
    }

    //Cálculo para participantes da CIPA
    if($buf[cnae_id] != ""){
    	$sql = "SELECT * FROM cipa WHERE grupo = '{$buf[grupo_cipa]}'";
        $res_cont = pg_query($sql);
        //$row_cont = pg_fetch_array($res_cont);
        while($row_cont=pg_fetch_array($res_cont)){
    	    $numero = explode(" a ", $row_cont[numero_empregados]);
    		if($buffer[numero_funcionarios] > $numero[0] && $numero[1] > $buffer[numero_funcionarios] || $buffer[numero_funcionarios] == $numero[0] || $buffer[numero_funcionarios] == $numero[1]){
                if($row_cont[numero_membros_cipa] >= "19"){
    		 		$menor = true;
    				$efetivo_empregador  = 1;
    				$suplente_empregador = 0;
    				$efetivo_empregado   = 0;
    				$suplente_empregado  = 0;
    			}else{
    		 		$necessidade         = $row_cont[numero_membros_cipa] + $row_cont[numero_representante_empregador] + $row_cont[suplente];
    				$efetivo_empregador  = $row_cont[numero_membros_cipa];
    				$suplente_empregador = $row_cont[suplente];
    				$efetivo_empregado   = $row_cont[numero_membros_cipa];
    				$suplente_empregado  = $row_cont[suplente];
    			}
    	    }
        }
        $total1 = $efetivo_empregador + $suplente_empregador;
        $total2 = $efetivo_empregado + $suplente_empregado;
        $membros_cipa = $total1." | ".$total2;
    }
}else{
    $sql = "SELECT MAX(c.cliente_id)+1 as cliente_id, MAX(substr(c.ano_contrato, 6)) as ano_contrato FROM cliente c";
    $res = pg_query($sql);
    $buffer = pg_fetch_array($res);
    $buffer[ano_contrato] = date("Y")."/".($buffer[ano_contrato]+1);
    if($buffer[nome_contato_dir] == '') $buffer[nome_contato_dir] = 'Sr.(ª) ';
    if($buffer[nome_cont_ind] == '')    $buffer[nome_cont_ind]    = 'Sr.(ª) ';
    if($buffer[nome_contador] == '')    $buffer[nome_contador]    = 'Sr.(ª) ';
}

//Lista de classes de brigada
$sql = "SELECT * FROM brigadistas ORDER BY classe";
$res_brig = pg_query($sql);
$classes_brigada = pg_fetch_all($res_brig);

/**************************************************************************************************/
if(is_numeric($_GET[cod_cliente])){
    $sql = "SELECT fi.cod_fatura, fi.cod_cliente, fi.cod_filial FROM site_fatura_info fi, cliente c
    WHERE
    c.cliente_id = '$_GET[cod_cliente]'
    AND
    fi.cod_cliente = c.cliente_id
    AND
    fi.cod_filial = c.filial_id
    AND
    (
    (
    EXTRACT(year FROM fi.data_vencimento) < '".date("Y")."'
    )OR(
    EXTRACT(day FROM fi.data_vencimento) < '".date("d")."'
    AND
    EXTRACT(month FROM fi.data_vencimento) = '".date("m")."'
    AND
    EXTRACT(year FROM fi.data_vencimento) = '".date("Y")."'
    )OR(
    EXTRACT(month FROM fi.data_vencimento) < '".date("m")."'
    AND
    EXTRACT(year FROM fi.data_vencimento) = '".date("Y")."'
    )
    )
    AND
    fi.migrado = 0
    GROUP BY fi.cod_fatura, fi.cod_cliente, fi.cod_filial
    ORDER BY fi.cod_fatura ASC";
    $rfat = pg_query($sql);
    $fat = pg_fetch_all($rfat);
}

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                // RESUMO DO CLIENTE
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Resumo</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left onmouseover=\"showtip('tipbox', '- Exibe opções resumidas relativas ao cliente selecionado.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text' width=160>Cód. Cliente:</td><td class='text' width=80 align=right><b>".str_pad($buffer[cliente_id], 4, "0", 0)."</b><input type=hidden name='cod_cliente' value='{$buffer[cliente_id]}'></td>";
                        echo "</tr><tr>";
                        echo "<td class='text' width=160>Ano/Contrato:</td><td class='text' width=80 align=right><b>{$buffer[ano_contrato]}</b><input type=hidden name='ano_contrato' value='{$buffer[ano_contrato]}'></td>";
                        echo "</tr><tr>";
                        //link abrir faturas vencidas (controle de inadimplentes)
                        echo "<td class='text' width=160>Faturas Vencidas:</td><td class='text' width=80 align=right><a href='#' onclick=\"alert('Em desenvolvimento!');\">".@pg_num_rows($rfat)."</a></td>";
                        echo "</tr><tr>";
                        //link abrir próxima fatura (próxima não vencida - Gerar resumo de fatura)
                        echo "<td class='text' width=160>Próximo Vencimento:</td><td class='text' width=80 align=right><a href='#' onclick=\"alert('Em desenvolvimento!');\">".date("d/m/y")."</a></td>";
                        echo "</tr>";
                        if(is_numeric($_GET[cod_cliente])){
                            echo "<tr>";
                            echo "<td class='text' width=160>Status:</td><td class='text' width=80 align=right>";
                            echo "<select id='chstatus' name='chstatus' style=\"width: 90px;\" onblur=\"cad_cliente_change_status('".$_GET[cod_cliente]."');\">";
                            echo "<option value='ativo' "; print $buffer[status]=="ativo" ? " selected " : ""; echo ">Ativo</option>";
                            echo "<option value='comercial' "; print $buffer[status]=="comercial" ? " selected " : ""; echo ">Comercial</option>";
							echo "<option value='parceria' "; print $buffer[status]=="parceria" ? " selected " : ""; echo ">Parceria</option>";
                            echo "</select>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";

                // OPÇÕES DO CLIENTE
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Opções</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left>";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Res. Contrato'  onmouseover=\"showtip('tipbox', '- Resumo de Contrato, exibe um resumo das cláusulas do contrato deste cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Funcionarios' onclick=\"location.href='?dir=cad_cliente&p=cadastro_func&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Funcionários, exibe a lista de funcionários da empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr><tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Certificado'  onmouseover=\"showtip('tipbox', '- Certificado, exibe o certificado da empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Localizar'  onmouseover=\"showtip('tipbox', '- Localizar, permite que seja executada uma busca por outros clientes.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr><tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=new';\"  onmouseover=\"showtip('tipbox', '- Novo, permite o cadastro de um novo cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Mapa' onclick=\"location.href='?dir=cad_cliente&p=detalhe_cliente&cod_cliente=$_GET[cod_cliente]&sp=mapa';\" onmouseover=\"showtip('tipbox', '- Mapa, exibe um mapa com a localização da empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr><tr>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Rel. Atend.' onclick=\"location.href='?dir=cad_cliente&p=rel_atendimento&cod_cliente=$_GET[cod_cliente]';\"  onmouseover=\"showtip('tipbox', '- Relatório, permite o cadastro de relacionamento com o cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Comentário' onclick=\"location.href='?dir=cad_cliente&p=add_coment&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Comentário, permite adicionar um comentário relevante no cadastro do cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr><tr>";
                        echo "<td class='text' align=center><a href=\"http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/Cnpjreva_Solicitacao.asp\" target=\"_blank\"><input type='button' class='btn' name='button' value='Receita Federal' onmouseover=\"showtip('tipbox', '- Receita Federal, permite consultar o cliente na receita federal.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        //echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Comentário' onclick=\"location.href='?dir=cad_cliente&p=add_coment&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Comentário, permite adicionar um comentário relevante no cadastro do cliente.');\" onmouseout=\"hidetip('tipbox');\"></td>";
                        echo "</tr>";
                        echo "</table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";


                // --> TIPBOX
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
        echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
        if($_GET[cod_cliente] == "new"){
            echo "<b>Novo Cadastro</b>";
		}else{
            echo "<b>{$buffer[razao_social]}</b>";
        }
        echo "</td>";
        echo "</tr>";
        echo "</table>";

        $sp = current_module_path.anti_injection($_GET[sp]).".php";
        if(file_exists($sp)){
            include($sp);
        }else{
            include('cadastro.php');
        }
        
        
    echo "</td>";
echo "</tr>";
echo "</table>";
    
?>