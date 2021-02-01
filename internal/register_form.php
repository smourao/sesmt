<?PHP
//style="background-color: #ff3700; border: 2px solid #9a0d00;"
//print_r($_POST);
/*****************************************************************************************************************/
// --> POST
/*****************************************************************************************************************/
if($_POST && $_POST[btnCriarConta]){
    // --> [TRATAMENTO DE VARIÁVEIS]:
    $email              = anti_injection($_POST[email]);
    $email2             = anti_injection($_POST[confemail]);
    $pass               = anti_injection($_POST[pass]);
    $pass2              = anti_injection($_POST[pass2]);
    $pessoa             = $_POST[pessoa];
    
    //-- PESSOA FISICA
    $nome               = anti_injection($_POST[nome]);
	$nome = ucwords(strtolower($nome));
    $sexo               = anti_injection($_POST[sexo]);
    $nascimento         = explode("/", anti_injection($_POST[nascimento]));
    $nascimento         = $nascimento[2]."-".$nascimento[1]."-".$nascimento[0];
    $cpf                = anti_injection($_POST[cpf]);
    $profissao          = anti_injection($_POST[profissao]);
    $instituicao        = anti_injection($_POST[instituicao]);
    
    //-- PESSOA JURÍDICA
    $razao_social       = anti_injection($_POST[razao_social]);
	$razao_social = ucwords(strtolower($razao_social));
    $nome_fantasia      = anti_injection($_POST[nome_fantasia]);
	$nome_fantasia = ucwords(strtolower($nome_fantasia));
    $cnpj               = anti_injection($_POST[cnpj]);
    $insc_estadual      = anti_injection($_POST[insc_estadual]);
    $insc_municipal     = anti_injection($_POST[insc_municipal]);
    $cnae               = anti_injection($_POST[cnae]);
    $classe             = anti_injection($_POST[classe]);
    $colaboradores      = (int)(anti_injection($_POST[colaboradores]));
    $responsavel        = anti_injection($_POST[responsavel]);
	$responsavel = ucwords(strtolower($responsavel));
    $cargo_responsavel  = anti_injection($_POST[cargo_responsavel]);
	$cargo_responsavel = ucwords(strtolower($cargo_responsavel));
    $email_responsavel  = anti_injection($_POST[email_responsavel]);
    $sexo_responsavel   = anti_injection($_POST[sexo_responsavel]);
    $nasc_responsavel   = explode("/", anti_injection($_POST[nascimento_responsavel]));
    $nasc_responsavel   = $nasc_responsavel[2]."-".$nasc_responsavel[1]."-".$nasc_responsavel[0];
    $escritorio_contab  = anti_injection($_POST[escritorio_contabilidade]);
    $nome_contador      = anti_injection($_POST[nome_contador]);
	$nome_contador = ucwords(strtolower($nome_contador));
    $tel_contador       = anti_injection($_POST[tel_contador]);
    $email_contador     = anti_injection($_POST[email_contador]);
    $crc_contador       = anti_injection($_POST[crc_contador]);

    //-- LOCALIZAÇÃO
    $cep                = anti_injection($_POST[cep]);
    $endereco           = anti_injection($_POST[endereco]);
    $num_end            = (int)(anti_injection($_POST[num_end]));
    $complemento        = anti_injection($_POST[complemento]);
    $bairro             = anti_injection($_POST[bairro]);
    $cidade             = anti_injection($_POST[cidade]);
    $estado             = anti_injection($_POST[estado]);
    $telefone           = anti_injection($_POST[telefone]);
    $tel_comercial      = anti_injection($_POST[tel_comercial]);
    $fax                = anti_injection($_POST[fax]);
    $tel_celular        = anti_injection($_POST[tel_celular]);
    $nextel             = anti_injection($_POST[nextel]);
    $msn                = anti_injection($_POST[msn]);
    $como_conheceu      = anti_injection($_POST[como_conheceu]);
	
	if(!empty($_POST[cod_chave])){
    $cod_chave          = (int)(anti_injection($_POST[cod_chave]));
	}else{
		$cod_chave = 5826;
	}
    
    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= 'From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> ' . "\n" .
    'Bcc: comercial@sesmt-rio.com; suporte@sesmt-rio.com' . "\n" .
    'X-Mailer: PHP/' . phpversion();
	
    $headers2 = "MIME-Version: 1.0\n";
    $headers2 .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers2 .= 'From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> ' . "\n" .
    'Bcc: comercial@sesmt-rio.com; adm@sesmt-rio.com;' . "\n" .
    'X-Mailer: PHP/' . phpversion();
	
	//**************************EMAIL COM DADOS******************************\\
	if($_POST[pessoa] == 'juridica'){
	$headers3 = "MIME-Version: 1.0\n";
		$headers3 .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers3 .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";
		$maill3 = "comercial@sesmt-rio.com";
		$msgg3 = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
                    <HTML><HEAD><TITLE>Seja bem-vindo(a) à SESMT</TITLE><META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\"><META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
                    <style type=\"text/css\">
                    td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
                    .style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
                    .style13 {font-size: 14px}
                    .style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
                    .style16 {font-size: 9px}
                    .style17 {font-family: Arial, Helvetica, sans-serif}
                    .style18 {font-size: 12px}
                    </style>
                    </HEAD>
                    <BODY>
                    <table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td align='left'>
            <p><strong>
            <font size='6' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=2>®</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>
            <td width=40% align=right>
            <font face='Verdana, Arial, Helvetica, sans-serif' size='3'>
            <b>Novo cadastro</b>
            </td>
	  </tr>
	</table><br><br>";
		$msgg3 .="<table width=100% border=0 cellpadding=0 cellspacing=0>
                   	<tr>
                  	<td width=100% class=fontepreta12><span class=style15>
                    <p>
                    ------------------------------------<BR>";
		$msgg3 .= "Responsavel: ".$responsavel."<br>";
		$msgg3 .= "Empresa: ".$razao_social."<br>";
		$msgg3 .= "CNPJ: ".$cnpj."<br>";
		$msgg3 .= "Email do Responsavel: ".$email_responsavel."<br>";
		$msgg3 .= "Email: ".$email."<br>";
		$msgg3 .= "Endereço: ".$endereco.", ".$bairro.", ".$cidade.", ".$estado."<br>";
		$msgg3 .= "Numero: ".$num_end."<br>";
		$msgg3 .= "Complemento: ".$complemento."<br>";
		$msgg3 .= "Telefone: ".$telefone."<br>";
		$msgg3 .="------------------------------------<BR>
					</td>
                    </tr>
                    </table>";
		$msgg3 .="<br><p>
  <table width=100%>
  <tr>
     <td align=center>
     <font face='Verdana, Arial, Helvetica, sans-serif'>
    <b> Telefone: +55 (21) 3014 4304 &nbsp; Fax: Ramal 7<br>
     Nextel: +55 (21) 97003 1385 - Id 55*23*31641<P>
     <font face='Verdana, Arial, Helvetica, sans-serif' size=2>
     faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com<br>
     www.sesmt-rio.com</b>
     </td>
     <td width=130><font face='Verdana, Arial, Helvetica, sans-serif'><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
  </tr>
  </table>
                    </BODY></HTML>";			
		mail($maill3, "Novo cadastro SESMT", $msgg3, $headers3);
	}
    // -- [ERROR TABLE]: -----------------------------------------------------------
    // 0 - No error found
    // 1 - Email already registered
    // 2 - Error in insert - pessoa fisica data
    // 3 - CNPJ already registered in reg_pessoa_juridica
    // 4 - invalid CNAE
    // 5 - Error in insert - pessoa juridica data
    // 6 - Update simulador failed
    // 7 - Insert simulador failed
    // 8 - Sendmail to user failed
    $error = 0;
    
    // --> [TESTES]: -----------------------------------------------------------
    //Testa e-mail de cadastro
    $sql = "SELECT email FROM reg_pessoa_fisica WHERE email='$email'
            UNION
            SELECT email FROM reg_pessoa_juridica WHERE email='$email'";
    $rem = pg_query($sql);
    if(pg_num_rows($rem))
        $error = 1;
        
    //email não cadastrado -> proceder com o cadastro
    if($error == 0){
        if($_POST[pessoa] == 'fisica'){
        // --> [CADASTRO DE PESSOA FÍSICA]: -----------------------------------------------------------
        
            $sql = "INSERT INTO reg_pessoa_fisica
            (email, senha, nome, sexo, nascimento, cpf, profissao, instituicao, cep, endereco, numero, complemento,
            bairro, cidade, estado, telefone, tel_comercial, tel_celular, como_soube, fax, nextel, msn, skype,
            grupo, representante_comercial, data_cadastro)
            VALUES
            ('$email', '".md5($pass)."', '$nome', '$sexo', '$nascimento', '$cpf', '$profissao', '$instituicao',
            '$cep', '$endereco', '$num_end', '$complemento', '$bairro', '$cidade', '$estado', '$telefone',
            '$tel_comercial', '$tel_celular', '$como_conheceu', '$fax', '$nextel', '$msn', '$skype', '0',
            '$cod_chave', '".date("Y/m/d")."')";
            if(pg_query($sql))
                $error = 0;
            else
                $error = 2;
                
            //SEND MAIL TO USER
            if($error == 0){
                $msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
                    <HTML><HEAD><TITLE>Seja bem-vindo(a) à SESMT</TITLE><META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\"><META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
                    <style type=\"text/css\">
                    td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
                    .style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
                    .style13 {font-size: 14px}
                    .style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
                    .style16 {font-size: 9px}
                    .style17 {font-family: Arial, Helvetica, sans-serif}
                    .style18 {font-size: 12px}
                    </style>
                    </HEAD>
                    <BODY>
                    table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td align='left'>
            <p><strong>
            <font size='6' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=2>®</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>
            <td width=40% align=right>
            <font face='Verdana, Arial, Helvetica, sans-serif' size='3'>
            <b>Bem Vindo</b>
            </td>
	  </tr>
	</table><br><br>";

                    $msg .= "
                    <table width=100% border=0 cellpadding=0 cellspacing=0>
                   	<tr>
                  	<td width=100% class=fontepreta12><span class=style15>
                    Olá $nome,<BR>
                    Seja bem-vindo(a) à SESMT<sup>®</sup>, este e-mail contém informações referente a sua conta,
                    por favor, guarde este e-mail para consultas posteriores.
                    <p>
                    ------------------------------------<BR>
                    <b>Login:</b> $email<BR>
                    <b>Senha:</b> $pass<BR>
                    ------------------------------------<BR>
                    <p>
                    A SESMT<sup>®</sup> agradece seu cadastro e se coloca a disposição para esclarecimentos de
                    qualquer dúvida relacionada ao seu cadastro.<BR>
                    </td>
                    </tr>
                    </table>";

                    $msg .= "
                    <br><p>
  <table width=100%>
  <tr>
     <td align=center>
     <font face='Verdana, Arial, Helvetica, sans-serif'>
    <b> Telefone: +55 (21) 3014 4304 &nbsp; Fax: Ramal 7<br>
     Nextel: +55 (21) 97003 1385 - Id 55*23*31641<P>
     <font face='Verdana, Arial, Helvetica, sans-serif' size=2>
     faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com<br>
     www.sesmt-rio.com</b>
     </td>
     <td width=130><font face='Verdana, Arial, Helvetica, sans-serif'><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
  </tr>
  </table>
                    </BODY></HTML>";
                    // --> SEND EMAIL TO REGISTERED USER ------------------------------------------------
                    if(mail("$email", "Bem-vindo à SESMT", $msg, $headers))
                        $error = 0;
                    else
                        $error = 8;
						
            }
            if($error == 0){
                $msg2 = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
                    <HTML><HEAD><TITLE>Seja bem-vindo(a) à SESMT</TITLE><META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\"><META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
                    <style type=\"text/css\">
                    td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
                    .style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
                    .style13 {font-size: 14px}
                    .style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
                    .style16 {font-size: 9px}
                    .style17 {font-family: Arial, Helvetica, sans-serif}
                    .style18 {font-size: 12px}
                    </style>
                    </HEAD>
                    <BODY>
                    table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td align='left'>
            <p><strong>
            <font size='6' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=2>®</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>
            <td width=40% align=right>
            <font face='Verdana, Arial, Helvetica, sans-serif' size='3'>
            <b>Novo Cadastro</b>
            </td>
	  </tr>
	</table><br><br>";

                    if($_POST[pessoa] == 'fisica'){
$msg2 .= "
                    <table width=100% border=0 cellpadding=0 cellspacing=0>
                   	<tr>
                  	<td width=100% class=fontepreta12><span class=style15>
                    <p>
                    ------------------------------------<BR>
                    <b>Login:</b> $email<BR>
					<b>Pessoa Física</b><BR><BR>	
					<b>Nome:</b> $nome<BR>
					<b>CPF:</b> $cpf<BR>
					<b>Profissão:</b> $profissao<BR>
					<b>Instituição:</b> $instituicao<BR>
					<BR>
					<b>Endereço:</b> $endereco <BR>
					<b>Cidade:</b> $cidade<BR>
					<b>Telefone:</b> $telefone<BR>
					<b>Telefone Comercial:</b> $tel_comercial<BR>
					<b>Telefone Celular</b> $tel_celular<BR>
                    ------------------------------------<BR>
                    </td>
                    </tr>
                    </table>";}
                    
                    $msg2 .= "
                    <br><p>
  <table width=100%>
  <tr>
     <td align=center>
     <font face='Verdana, Arial, Helvetica, sans-serif'>
    <b> Telefone: +55 (21) 3014 4304 &nbsp; Fax: Ramal 7<br>
     Nextel: +55 (21) 97003 1385 - Id 55*23*31641<P>
     <font face='Verdana, Arial, Helvetica, sans-serif' size=2>
     faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com<br>
     www.sesmt-rio.com</b>
     </td>
     <td width=130><font face='Verdana, Arial, Helvetica, sans-serif'><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
  </tr>
  </table>
                    </BODY></HTML>";
                    if(mail("suporte@ti-seg.com;", "Novo cadastro SESMT", $msg2, $headers2))
                        $error = 0;
                    else
                        $error = 8;
			}
        }else{
        // --> [CADASTRO DE PESSOA JURIDICA]: -----------------------------------------------------------
        include('register_form_functions.php');
            // Verifica se CNPJ já está cadastrado no reg_pessoa_juridica
            $sql = "SELECT * FROM reg_pessoa_juridica WHERE cnpj='$cnpj'";
            $rcj = pg_query($sql);
            if(pg_num_rows($rcj))
                $error = 3;
                
            // Verifica se CNAE existe na database
            $sql = "SELECT * FROM cnae WHERE cnae='$cnae'";
            $rcn = pg_query($sql);
            $cnae_info = pg_fetch_array($rcn);
            if(!pg_num_rows($rcn))
                $error = 4;

            $sql = "SELECT * FROM cliente WHERE cnpj = '$cnpj'";
            $rcl = pg_query($sql);
            $cliente = pg_fetch_array($rcl);
            if(pg_num_rows($rcl)){
                $cod_cliente = (int)($cliente[cliente_id]);
                $cod_filial  = (int)($cliente[filial_id]);
                $grupo       = 2;
            }else{
				//BRIGADA INFO
				$sql = "SELECT * FROM brigadistas WHERE classe = '$classe'";
				$rbr = pg_query($sql);
				$brigada = pg_fetch_array($rbr);
				$menor      = (int)($brigada[ate_10]);
				$maior      = (int)($brigada[mais_10]);
				$quantidade = $colaboradores;
				$calculo = 0;
				if($quantidade <= 10)
					$calculo = $quantidade*($menor/100);
				else
					$calculo = 10*($menor/100)+($quantidade-10)*($maior/100);
				if(round($calculo, 0) <= 0)
				   $membros = 0;
				else
				   $membros = round($calculo, 0);
					
				//CIPA INFO
				$sql = "SELECT * FROM cipa WHERE grupo = '$cnae_info[grupo_cipa]'";
				$rcp = pg_query($sql);
				while($row_cont = pg_fetch_array($rcp)){
					$numero = explode(" a ", $row_cont[numero_empregados]);
					if($colaboradores > $numero[0] && $numero[1] > $colaboradores || $colaboradores == $numero[0] || $colaboradores == $numero[1]){
						if($row_cont[numero_membros_cipa] >= 19){
							//$menor = true;
							$efetivo_empregador    = 1;
							$suplente_empregador   = 0;
							$efetivo_empregado     = 0;
							$suplente_empregado    = 0;
						}else{
							$necessidade           = $row_cont[numero_membros_cipa] + $row_cont[numero_representante_empregador] + $row_cont[suplente];
							$efetivo_empregador    = $row_cont[numero_membros_cipa];
							$suplente_empregador   = $row_cont[suplente];
							$efetivo_empregado     = $row_cont[numero_membros_cipa];
							$suplente_empregado    = $row_cont[suplente];
						}
					}
				}
				$total1   = $efetivo_empregador + $suplente_empregador;
				$total2   = $efetivo_empregado + $suplente_empregado;
				$num_rep  = (int)($total1)."|".(int)($total2);
				
				//----------------------------------------------------------
				
				$sql = "SELECT MAX(cliente_id) as cliente_id, MAX(substr(ano_contrato, 6)) as ano_contrato FROM cliente";
				$rcid = pg_query($sql);
				$cod = pg_fetch_array($rcid);
				$cod_s = (int)($cod[cliente_id]+1);
				
				$sqlchave = "SELECT * FROM funcionario WHERE cod_vendedor = '$cod_chave'";
				$querychave = pg_query($sqlchave);
				$arraychave = pg_fetch_array($querychave);
				$vendedor_id = $arraychave[funcionario_id];

				$sql = "INSERT INTO cliente
				(cliente_id, filial_id, razao_social, nome_fantasia, endereco, num_end, bairro, cep, municipio, estado, telefone, fax, celular,
				email, cnpj, insc_estadual, insc_municipal, cnae_id, descricao_atividade, numero_funcionarios, grau_de_risco, nome_contato_dir,
				cargo_contato_dir, tel_contato_dir, email_contato_dir, skype_contato_dir, msn_contato_dir, nextel_contato_dir, nextel_id_contato_dir,
				nome_cont_ind, cargo_cont_ind, email_cont_ind, skype_cont_ind, tel_cont_ind, escritorio_contador, tel_contador, msn_contador,
				skype_contador, nome_contador, email_contador, status, classe, vendedor_id, data, num_rep, membros_brigada, relatorio_de_atendimento,
				crc_contador, ano_contrato)
				VALUES
				($cod_s, 0, '$razao_social', '$nome_fantasia', '$endereco', '$num_end', '$bairro', '$cep', '$estado', '$estado - $cidade',
				'$tel_comercial', '$fax', '$tel_celular', '$email', '$cnpj', '$insc_estadual', '$insc_municipal', '$cnae_info[cnae_id]', '$cnae_info[descricao]',
				'$colaboradores', '$cnae_info[grau_risco]', '$responsavel', '$cargo_responsavel', '$tel_comercial', '$email_responsavel', '$skype',
				'$msn', '$nextel', '$_POST[nextel_id]', '$nome_cont_ind', '$cargo_cont_ind', '$email_cont_ind', '$skype_cont_ind', '$tel_cont_ind',
				'$escritorio_contab', '$tel_contador', '$msn_contador', '$skype_contador', '$nome_contador', '$email_contador', 'comercial', '$classe',
				'$vendedor_id', '".date("d/m/Y")."', '$num_rep', '$membros', '".date("d/m/Y")." - Cliente cadastrado pelo site, migrado automaticamento para o simulador.',
				'$crc_contador', '".date("Y")."/".($cod[ano_contrato]+1)."')";
				if(pg_query($sql))
					$error = 0;
				else
					$error = 7;
					
                $cod_cliente = (int)($cod_s);
                $cod_filial  = 0;
                $grupo       = 2;
            }

            if($error == 0){
                //insert reg_pessoa_juridica  -----------------------------------------------------------
                $sql = "INSERT INTO reg_pessoa_juridica
                (email, senha, razao_social, cnpj, nome_fantasia, inscricao_estadual, inscricao_municipal, cep, endereco, numero,
				 complemento, bairro, cidade, estado, telefone, tel_comercial, tel_celular, como_soube, colaboradores, fax, nextel,
				 msn, skype, grupo, cnae, responsavel, cargo, email_pessoal, sexo, representante_comercial, data_cadastro,
				 cod_cliente, cod_filial, escritorio_contabilidade, nome_contador, tel_contador, email_contador)
                VALUES
                 ('$email', '".md5($pass)."', '$razao_social', '$cnpj', '$nome_fantasia', '$insc_estadual', '$insc_municipal',
				 '$cep', '$endereco', '$numero', '$complemento', '$bairro', '$cidade', '$estado', '$telefone', '$tel_comercial',
				 '$tel_celular', '$como_conheceu', '$colaboradores', '$fax', '$nextel', '$msn', '$skype', '$grupo', '$cnae',
				 '$responsavel', '$cargo_responsavel', '$email_responsavel', '$sexo_responsavel', '$cod_chave', '".date("Y/m/d")."',
				 '$cod_cliente', '$cod_filial', '$escritorio_contab', '$nome_contador', '$tel_contador', '$email_contador')";
                if(pg_query($sql))
                    $error = 0;
                else
                    $error = 5;
                    
                //SITE REGISTER OK - SEND WELCOME EMAIL
                if(!$error){
                    $msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
                    <HTML><HEAD><TITLE>Seja bem-vindo(a) à SESMT</TITLE><META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\"><META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
                    <style type=\"text/css\">
                    td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
                    .style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
                    .style13 {font-size: 14px}
                    .style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
                    .style16 {font-size: 9px}
                    .style17 {font-family: Arial, Helvetica, sans-serif}
                    .style18 {font-size: 12px}
                    </style>
                    </HEAD>
                    <BODY>
                    <table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td align='left'>
            <p><strong>
            <font size='6' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=2>®</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>
            <td width=40% align=right>
            <font face='Verdana, Arial, Helvetica, sans-serif' size='3'>
            <b>Bem Vindo</b>
            </td>
	  </tr>
	</table><br><br>";

                    $msg .= "
                    <table width=100% border=0 cellpadding=0 cellspacing=0>
                   	<tr>
                  	<td width=100% class=fontepreta12><span class=style15>
                    Olá $responsavel,<BR>
                    Seja bem-vindo(a) à SESMT<sup>®</sup>, este e-mail contém informações referente a sua conta,
                    por favor, guarde este e-mail para consultas posteriores.
                    <p>
                    ------------------------------------<BR>
					<b>Razão Social:</b> $razao_social<BR>
                    <b>Login:</b> $email<BR>
                    <b>Senha:</b> $pass<BR>
                    ------------------------------------<BR>
                    <p>
                    O SIST - Sistema Integrado em Segurança no Trabalho é uma ferramenta desenvolvida pela
                    SESMT<sup>®</sup> que permite aos seus clientes realizar uma infinidade de pesquisas na área de
                    prevenção de acidentes e higiene ocupacional, solicitar serviços 24 horas por dia, entre outros
                    serviços.
                    <p>
                    A SESMT<sup>®</sup> disponibiliza uma consultoria diferenciada no mercado com uma carga
                    horária de 32 horas, 8 horas na sua filial e 24 horas online.
                    <p>
                    Agradecemos seu cadastro e nos colocamos à disposição para esclarecimentos de
                    qualquer dúvida relacionada ao seu cadastro.<BR>
                    </td>
                    </tr>
                    </table>";

                    $msg .= "
                    <br><p>
  <table width=100%>
  <tr>
     <td align=center>
     <font face='Verdana, Arial, Helvetica, sans-serif'>
    <b> Telefone: +55 (21) 3014 4304 &nbsp; Fax: Ramal 7<br>
     Nextel: +55 (21) 97003 1385 - Id 55*23*31641<P>
     <font face='Verdana, Arial, Helvetica, sans-serif' size=2>
     faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com<br>
     www.sesmt-rio.com</b>
     </td>
     <td width=130><font face='Verdana, Arial, Helvetica, sans-serif'><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
  </tr>
  </table>
                    </BODY></HTML>";

                    // --> SEND EMAIL TO REGISTERED USER ------------------------------------------------
                    if(mail($email, "Bem-vindo à SESMT", $msg, $headers))
                        $error = 0;
                    else
                        $error = 8;
                }
                     
                //continue the job...
                //register or update - simulador
                if($error == 0){
                    //verifica se a empresa ja está cadastrada no simulador
                    $sql = "SELECT * FROM cliente WHERE cnpj='$cnpj'";
                    $rcs = pg_query($sql);
                    $simulador = pg_fetch_array($rcs);

                    //BRIGADA INFO
                    $sql = "SELECT * FROM brigadistas WHERE classe = '$classe'";
                    $rbr = pg_query($sql);
                    $brigada = pg_fetch_array($rbr);
                	$menor      = (int)($brigada[ate_10]);
                	$maior      = (int)($brigada[mais_10]);
                	$quantidade = $colaboradores;
                	$calculo = 0;
                	if($quantidade <= 10)
                	    $calculo = $quantidade*($menor/100);
                	else
                	    $calculo = 10*($menor/100)+($quantidade-10)*($maior/100);
                	if(round($calculo, 0) <= 0)
                	   $membros = 0;
                	else
                       $membros = round($calculo, 0);
                        
                    //CIPA INFO
                    $sql = "SELECT * FROM cipa WHERE grupo = '$cnae_info[grupo_cipa]'";
	                $rcp = pg_query($sql);
                	while($row_cont = pg_fetch_array($rcp)){
                 	    $numero = explode(" a ", $row_cont[numero_empregados]);
                	    if($colaboradores > $numero[0] && $numero[1] > $colaboradores || $colaboradores == $numero[0] || $colaboradores == $numero[1]){
                	        if($row_cont[numero_membros_cipa] <= 19){
                			    //$menor = true;
                			    $efetivo_empregador    = 1;
                			    $suplente_empregador   = 0;
                				$efetivo_empregado     = 0;
                				$suplente_empregado    = 0;
                			}else{
                				$necessidade           = $row_cont[numero_membros_cipa] + $row_cont[numero_representante_empregador] + $row_cont[suplente];
                				$efetivo_empregador    = $row_cont[numero_membros_cipa];
                				$suplente_empregador   = $row_cont[suplente];
                				$efetivo_empregado     = $row_cont[numero_membros_cipa];
                				$suplente_empregado    = $row_cont[suplente];
                		    }
                	    }
                 	}
                    $total1   = $efetivo_empregador + $suplente_empregador;
                    $total2   = $efetivo_empregado + $suplente_empregado;
                    $num_rep  = (int)($total1)."|".(int)($total2);


                    if(pg_num_rows($rcs)){
                    // --> EMPRESA JÁ NO SIMULADOR, FAZER ATUALIZAÇÃO DOS DADOS -----------------------------------------------------------
                        $sql = "UPDATE cliente SET
                        razao_social                   = '$razao_social',
                        nome_fantasia                  = '$nome_fantasia',
                        endereco                       = '$endereco',
                        bairro                         = '$bairro',
                        cep                            = '$cep',
                        municipio                      = '$cidade',
                        estado                         = '$estado - $cidade',
                        telefone                       = '$telefone',
                        fax                            = '$fax',
                        celular                        = '$tel_celular',
                        email                          = '$email',
                        cnpj                           = '$cnpj',
                        insc_estadual                  = '$insc_estadual',
                        insc_municipal                 = '$insc_municipal',
                        descricao_atividade            = '$cnae_info[descricao]',
                        numero_funcionarios            = '$colaboradores',
                        grau_de_risco                  = '$cnae_info[grau_risco]',
                        cnae_id                        = '$cnae_info[cnae_id]',
                        tel_contato_dir                = '$telefone',
                        nome_contato_dir               = '$responsavel',
                        cargo_contato_dir              = '$cargo_responsavel',
                        email_contato_dir              = '$email_responsavel',
                        skype_contato_dir              = '$skype',
                        msn_contato_dir                = '$msn',
                        nextel_contato_dir             = '$nextel',
                        escritorio_contador            = '$escritorio_contab',
                        tel_contador                   = '$tel_contador',
                        email_contador                 = '$email_contador',
                        nome_contador                  = '$nome_contador',
                        classe                         = '$classe',
                        num_end                        = '$num_end',
                        num_rep                        = '$num_rep',
                        membros_brigada                = '$membros',
                        crc_contador                   = '$crc_contador'
                        status 		                   = 'comercial'
                        WHERE cliente_id               = $simulador[cliente_id]";
                        if(pg_query($sql))
                            $error = 0;
                        else
                            $error = 6;
                            
                    }else{
                    // --> CADASTRAR EMPRESA NO SIMULADOR -----------------------------------------------------------
                        $sql = "SELECT MAX(cliente_id) as max FROM cliente";
                        $rcid = pg_query($sql);
                        $cod_sim = pg_fetch_array($rcid);
                        $cod_sim = (int)($cod_sim[max]+1);

                        $sql = "INSERT INTO cliente
	                    (cliente_id, filial_id, razao_social, nome_fantasia, endereco, num_end, bairro, cep, municipio, estado, telefone, fax, celular,
						email, cnpj, insc_estadual, insc_municipal, cnae_id, descricao_atividade, numero_funcionarios, grau_de_risco, nome_contato_dir,
						cargo_contato_dir, tel_contato_dir, email_contato_dir, skype_contato_dir, msn_contato_dir, nextel_contato_dir, nextel_id_contato_dir,
						nome_cont_ind, cargo_cont_ind, email_cont_ind, skype_cont_ind, tel_cont_ind, escritorio_contador, tel_contador, msn_contador,
						skype_contador, nome_contador, email_contador, status, classe, vendedor_id, data, num_rep, membros_brigada, relatorio_de_atendimento,
                        crc_contador)
                        VALUES
                     	($cod_sim, 0, '$razao_social', '$nome_fantasia', '$endereco', '$num_end', '$bairro', '$cep', '$estado', '$estado - $cidade',
						'$tel_comercial', '$fax', '$tel_celular', '$email', '$cnpj', '$insc_estadual', '$insc_municipal', '$cnae_info[cnae_id]', '$cnae_info[descricao]',
						'$colaboradores', '$cnae_info[grau_risco]', '$responsavel', '$cargo_responsavel', '$tel_comercial', '$email_responsavel', '$skype',
						'$msn', '$nextel', '$_POST[nextel_id]', '$nome_cont_ind', '$cargo_cont_ind', '$email_cont_ind', '$skype_cont_ind', '$tel_cont_ind',
						'$escritorio_contab', '$tel_contador', '$msn_contador', '$skype_contador', '$nome_contador', '$email_contador', 'comercial', '$classe',
						'18', '".date("d/m/Y")."', '$num_rep', '$membros', '".date("d/m/Y")." - Cliente cadastrado pelo site, migrado automaticamento para o simulador.',
                        '$crc_contador')";
                        if(pg_query($sql))
                            $error = 0;
                        else
                            $error = 7;
                        //echo "teste".$sql;
                    }//if exist update in simulador else insert

                    //ATUALIZAR / GERAR ORCAMENTO -----------------------------------------------------------
                    //if existir no cliente
                    if($simulador[cliente_id]){
                        $sql = "SELECT * FROM site_orc_info WHERE cod_cliente = $simulador[cliente_id]";
                        $rfo = pg_query($sql);
                        if(pg_num_rows($rfo)){
                            $lorc = pg_fetch_array($rfo);
                            //delete and create again the orcamento
                            create_orcamento_simulador($simulador[cliente_id], $lorc[cod_orcamento]);
                        }else{
                            //create a new orcamento
                            create_orcamento_simulador($simulador[cliente_id]);
                        }
                    }else{
                        //create a new orcamento
                        create_orcamento_simulador($cod_sim);
                    }

                }//insert - update - simulador

                //Se o cliente existir no cadastro -----------------------------------------------------------
                if($cod_cliente > 0){
                    //atualiza o número de funcionários de acordo com o número informado no cadastro do cliente
                    //e armazena o número atual no campo 'old_funcnum' na tabela
                    $sql = "UPDATE cliente SET old_funcnum = ".(int)($cliente[numero_funcionarios]).", numero_funcionarios='$colaboradores' WHERE cliente_id = $cod_cliente";
                    if(pg_query($sql))
                        $error = 0;
                        
                    //----------------------------------------------------------------------------------------
                    // --> MIGRAR ORÇAMENTOS SIM -> CLI
                    //----------------------------------------------------------------------------------------
                    /*$sql = "SELECT * FROM orcamento WHERE cod_cliente = ".(int)($simulador[cliente_id]);
                    $ros = pg_query($sql);
                    $orc_sim = pg_fetch_all($ros);
                    $nitems = 0;
                    $firstorc = 0;
                    $firstorctotal = 0;
                    //se existirem orçamentos, todos são migrados.
                    if(pg_num_rows($ros)){
                        for($o=0;$o<pg_num_rows($ros);$o++){
                            $orcaisql = 0; //orcamento already in sql?
                            $sql = "SELECT * FROM site_orc_info WHERE cod_orcamento = {$orc_sim[$o][cod_orcamento]}";
                            if(!pg_num_rows(pg_query($sql))){
                                $orcaisql = 1;
                            }
                            $sql = "SELECT * FROM orcamento_produto WHERE cod_orcamento = '{$orc_sim[$o][cod_orcamento]}'";
                            $r = pg_query($sql);
                            $sim_prod = pg_fetch_all($r);
                            if(empty($nitems))
                                $nitems = (int)(pg_num_rows($r));
                            if(empty($firstorc))
                                $firstorc = (int)($orc_sim[$o]['cod_orcamento']);

                            $sql = "INSERT INTO site_orc_info
                            (cod_orcamento, cod_cliente, cod_filial, num_itens, data_criacao, data_aprovacao, aprovado,
                            orc_request_time, orc_request_time_sended, vendedor_id)
                            VALUES
                            ('{$orc_sim[$o]['cod_orcamento']}', '{$cod_cliente}', '1','".pg_num_rows($r)."',
                            '{$orc_sim[$o]['data']}', '".date("Y/m/d")."','1', '".date("h:i:s")."', '1',
                            '18')";
                            if($orcaisql)
                                $result_in = pg_query($sql);
                            $total = 0;
                            //SE FOI INSERIDO NO INFO, LOOP PARA INSERIR PRODUTOS
                            //if(pg_num_rows($result_in)){
                                for($x=0;$x<pg_num_rows($r);$x++){
                                    $total += $sim_prod[$x]['quantidade'] * $sim_prod[$x]['preco_unitario'];
                                    //INSERE OS PRODUTOS DO ORÇAMENTO NA TABELA DO SITE
                                    if($sim_prod[$x]['preco_unitario']){
                                        $sql = "INSERT INTO site_orc_produto
                                        (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda, preco_aprovado)
                                        VALUES
                                        ('{$orc_sim[$o]['cod_orcamento']}','{$cod_cliente}', '1',
                                        '{$sim_prod[$x]['cod_produto']}', '{$sim_prod[$x]['quantidade']}',
                                        '1','', '{$sim_prod[$x]['preco_unitario']}')";
                                    }else{
                                        $sql = "INSERT INTO site_orc_produto
                                        (cod_orcamento, cod_cliente, cod_filial, cod_produto, quantidade, aprovado, legenda)
                                        VALUES
                                        ('{$orc_sim[$o]['cod_orcamento']}','{$cod_cliente}', '1',
                                        '{$sim_prod[$x]['cod_produto']}', '{$sim_prod[$x]['quantidade']}',
                                        '1','')";
                                    }
                                    if($orcaisql)
                                        pg_query($sql);
                                }//for $x produtos
                                if(empty($firstorctotal))
                                    $firstorctotal = $total;
                            //}//if existirem produtos
                        }//for $o
                    }//end if existirem orçamentos
					*/
                    //----------------------------------------------------------------------------------------

                    //----------------------------------------------------------------------------------------
                    // --> MAKE THE CLIENTE CONTRACT
                    //----------------------------------------------------------------------------------------
                    //GET LAST ITEM IN resumo de fatura
                    $sql = "SELECT * FROM site_fatura_info WHERE cod_cliente = $cod_cliente AND data_vencimento is not null ORDER BY data_vencimento DESC";
                    $rza = pg_query($sql);
                    $din = pg_fetch_array($rza);

                    //se houver faturas criadas
                    if(pg_num_rows($rza)){
                        $vencimento = $din[data_vencimento];
                        if(!empty($din[tipo_contrato])){
                            $tipo_contrato = $din[tipo_contrato];
                        }else{
                            if($nitems >=10)
                                $tipo_contrato = 'fechado';
                            else
                                $tipo_contrato = 'especifico';
                        }
                    }else{
                        $dd = mmd_dd(450.00, 3, true);
                        if($dd[1] != ""){
                            $tmp = explode("/", $dd[1]);
                            $vencimento = $tmp[2]."/".$tmp[1]."/".$tmp[0];
                        }else
                            $vencimento = date("Y/m/d", mktime(0,0,0,date("m")+1, rand(1, 5), date("Y")));

                        if($nitems >= 10)
                            $tipo_contrato = 'fechado';
                        else
                            $tipo_contrato = 'específico';
                    }

                    //make the contract -----------------------------------------------------------
                    $sql = "INSERT INTO site_gerar_contrato
                    (cod_cliente, cod_filial, cod_orcamento, tipo_contrato, n_parcelas, validade, vencimento,
                    valor_contrato, ano_orcamento, atendimento_medico, status, email, data_criacao,
                    ultima_alteracao, resumo_gerado)
                    VALUES
                    ('$cod_cliente', '1', '{$firstorc}', '{$tipo_contrato}', '12', '12 Meses',
                    '$vencimento', '$firstorctotal', '".date("Y")."', 'Não', '0', '$email', '".date("Y/m/d")."',
                    '".date("Y/m/d")."', '0')";
                    if(pg_query($sql))
                        $error = 0;
                    
                    //get contract info
                    $sql = "SELECT * FROM site_gerar_contrato WHERE cod_cliente = $cod_cliente ORDER BY id DESC";
                    $rqw = pg_query($sql);
                    $cif = pg_fetch_array($rqw);
                    if(pg_num_rows($rqw)>0)
                        $url = "http://sesmt-rio.com/contratos/aberto.php?cod_cliente={$cif[cod_cliente]}&cid={$cif[cod_orcamento]}&tipo_contrato={$cif[tipo_contrato]}&sala={$cif[atendimento_medico]}&parcelas={$cif[n_parcelas]}&vencimento=".date("d/m/Y", strtotime($cif[vencimento]))."&rnd=".rand(10000, 99999);

                    //SEND EMAIL -----------------------------------------------------------
                   //EMAIL QUE TIRAMOS
				   /* 
                    $msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
                    <HTML><HEAD><TITLE>SESMT</TITLE><META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\"><META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
                    <style type=\"text/css\">
                    td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
                    .style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
                    .style13 {font-size: 14px}
                    .style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
                    .style16 {font-size: 9px}
                    .style17 {font-family: Arial, Helvetica, sans-serif}
                    .style18 {font-size: 12px}
                    </style>
                    </HEAD>
                    <BODY>
                    <table width=\"100%\" border=\"0\" cellpadding=0 cellspacing=0>
                    	<tr>
                    		<td align=left><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width=\"333\" height=\"180\" /></td>
                    		<td align=\"left\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\"><span class=style18>Serviços Especializados de Segurança e <br>
                    		  Monitoramento de Atividades no Trabalho ltda.</span>
                    		  </font><br><br><p class=\"style18\">
                    		  <p class=\"style18\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\">Segurança do Trabalho e Higiene Ocupacional.</font><br><br><br><br><p>
                            </td>
                    	</tr>
                    </table>";

                    $msg .= "
                    <table width=100% border=0 cellpadding=0 cellspacing=0 >
                   	    <tr>
                  		    <td width=100% class=fontepreta12><span class=style15>
                    Prezado(ª) {$cliente[nome_contato_dir]}, Solicito imprimir o contrato em duas vias, ler o contrato atentamente.
                    Rubricar cada folha, porém, a última deverá ser assinada e reconhecido firma da assinatura e
                    enviar a Sesmt via correios. <p>
                    Os anexos são normatização que dão validades as cláusulas em que se diz respeito cada um deles
                    sendo tão somente necessária a rubrica das primeiras páginas, a assinatura da última e o respectivo
                    reconhecimento de firma da assinatura.
                    <p>
                    ....continuação dos  anexos onde constam a razão social e o CNPJ da CONTRATANTE e o anexo 1 que é o
                    objetivo deste contrato.
                    <p>
                    Remeter junto com a nossa via do contrato e, cópia das primeira e últimas folhas do contrato social
                    ou estatuto, solicito ainda informar ao escritório de contabilidade quem presta serviços a sua
                    empresa sobre a celebração do contrato com a SESMT para que formalmente apresentados possamos
                    coletar-mos informações importante a prestação dos serviços.
                    <p>
                    Link para visualizar e imprimir o contrato:<br>
                    <a href='$url' target=_blank>$url</a>
                            </td>
                    	</tr>
                    </table>";

                    $msg .= "
                    <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
                    	<p>
                    		<tr>
                    		<td width=\"65%\" align=\"center\" class=\"fontepreta12 style2\">
                    		<br /><br /><br /><br /><br /><br />
                    		  <span class=\"style17\">Telefone: +55 (21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
                    		  Nextel: +55 (21) 7844-9394 &nbsp;&nbsp;ID:55*23*31368 </span>
                              <p class=\"style17\">
                    		  faleprimeirocomagente@sesmt-rio.com / comercial@sesmt-rio.com<br />
                              www.sesmt-rio.com / www.shoppingsesmt.com<br />

                    	    </td>
                    		<td width=\"35%\" align=\"right\">
                            <img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=\"280\" height=\"200\" /></td>
                    	</tr>
                    </table>
                    </BODY></HTML>";

                    $headers = "MIME-Version: 1.0\n";
                    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
                    $headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <juridico@sesmt-rio.com> \n";

*/ // troquei o Contrato - SESMT pelo Bem-vindo à SESMT
                   // $mail_list = explode(";", $email);
                   /* for($x=0;$x<count($mail_list);$x++){
                        if($mail_list[$x] != ""){
                           if(mail($mail_list[$x], "Bem-vindo à SESMT", $msg, $headers)){
                              $ok .= ", ".$mail_list[$x];
                           }else{
                              $er .= ", ".$mail_list[$x];
                           } 
                        } 
                    } */

                    //----------------------------------------------------------------------------------------
                }//END IF CLIENTE = TRUE

            }//insert reg_pessoa_juridica
        }//if - else - pessoa fisica or juridica
    }//email não cadastrado - fazer cadastro

    switch($error){
        case 0:
            echo "<div class='novidades_text'><p align=justify>Seu cadastro foi concluído com sucesso.<p>
            Foi enviado um e-mail para <b>$email</b> com a confirmação do cadastro, você receberá este e-mail
            em alguns minutos.
            <p align=justify>
            A SESMT<sup>®</sup> agradece seu cadastro e se coloca a disposição para esclarecimentos de qualquer
            dúvida relacionada ao seu cadastro!
            </div>";
        break;
        case 1:
            echo "<div class='novidades_text error'><p align=justify>O e-mail informado já está cadastrado em nosso banco
            de dados, se você esqueceu sua senha, acesse a opção
            <a href='?do=forgotpass' target=_blank>recuperar senha</a>.</div>";
        break;
        case 2: //error insert reg_pessoa_fisica
        case 5: //error insert reg_pessoa_juridica
        case 6: //update simulador failed
        case 7: //insert simulador failed
            echo "<div class='novidades_text error'>
            <p align=justify>
            Houve um erro ao realizar seu cadastro.
            <p align=justify>
            Este erro pode ter sido causado por diversos fatores, como indisponibilidade em nossos servidores,
            falha no acesso ao banco de dados, entre outros...<BR>
            Lamentamos o ocorrido, uma mensagem com informações sobre o problema foi enviada ao setor de
            suporte e será analisada em breve.
            <p align=justify>
            Adicionalmente, pedimos que entre em contato com nossa equipe de suporte clicando
            <a href='?do=contato' target=_blank>aqui</a>, ou,
            através de nossa <a href='?do=contato' target=_blank>central de atendimento</a>.
            </div>";
        break;
        case 3:
            echo "<div class='novidades_text error'>
            <p align=justify>
            Houve um erro ao realizar seu cadastro.
            <p align=justify>
            O CNPJ informado já está cadastrado em nosso banco de dados.
            </div>";
        break;
        case 4:
            echo "<div class='novidades_text error'>
            <p align=justify>
            Houve um erro ao realizar seu cadastro.
            <p align=justify>
            O CNAE informado não existe ou não está cadastrado em nosso banco de dados.<BR>
            Em caso de dúvidas, entre em contato com nossa <a href='?do=contato' target=_blank>central de atendimento</a>.
            </div>";
        break;
        case 8:
            echo "<div class='novidades_text'><p align=justify>Seu cadastro foi concluído com sucesso,
            porem, houve uma falha ao tentar enviar o e-mail de confirmação.
            Contudo, sua conta pode ser acessada normalmente.
            <p align=justify>
            A SESMT<sup>®</sup> agradece seu cadastro e se coloca a disposição para esclarecimentos de qualquer
            dúvida relacionada ao seu cadastro!
            </div>";
        break;
        default:
            echo "<div class='novidades_text'><p align=justify></div>";
        break;
    }

}//IF POST
/*****************************************************************************************************************/
// --> FORM
/*****************************************************************************************************************/
//se não for feito o post ou houver um erro no cadastro
if(!$_POST || ($error != 0 && $error != 8)){
?>
<div class='novidades_text'>
<p align=justify>
Ao criar sua conta, você terá acesso à várias ferramentas disponíveis apenas para usuários cadastrados. Se você já é
cliente SESMT<sup>®</sup>, também poderá acessar seus programas e ferramentas exclusivas!
</div>

<BR><p><BR>
<form method=post name='frmRegister' id='frmRegister' onsubmit="return check_register_form(this);">
<!--<b>Identificação no site:</b>-->
<img src='images/sub-ident-site.jpg' border=0><BR>
<table width=100% cellspacing=2 cellpadding=2 border=0>
<tr>
<td width=180>E-Mail:</td>
<td><input type=text id='email' name='email' value='<?=$_POST[email];?>' size=30 class='required' onkeyup="change_classname('email', 'required');">&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Este e-mail será seu login de acesso ao nosso site.' title='Este e-mail será seu login de acesso ao nosso site.'></td>
</tr>
<tr>
<td width=180>Confirmar e-mail:</td>
<td><input type=text id='confemail' name='confemail' value='<?=$_POST[confemail];?>' size=30 class='required' onkeyup="change_classname('confemail', 'required');">&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Redigite seu e-mail, este procedimento permite que seja feita uma checagem na digitação do e-mail.' title='Redigite seu e-mail, este procedimento permite que seja feita uma checagem na digitação do e-mail.'></td>
</tr>
<tr>
<td width=180>Senha:</td>
<td><input type=password id='pass' name='pass' class='required' onkeyup="change_classname('pass', 'required');">&nbsp;<!--<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Redigite seu e-mail para confirmar.' title='Redigite seu e-mail para confirmar.'>--></td>
</tr>
<tr>
<td width=180>Confirmar senha:</td>
<td><input type=password id='pass2' name='pass2' class='required' onkeyup="change_classname('pass2', 'required');">&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Redigite sua senha.' title='Redigite sua senha.'></td>
</tr>
<tr>
<td width=180>Tipo de cadastro:</td>
<td><input type=radio value='juridica' name='pessoa' id='pessoa_juridica' <?PHP if($_POST[pessoa] == 'juridica' || empty($_POST[pessoa])) echo "checked";?> onclick="change_tipo_pessoa();" onblur="change_tipo_pessoa(this);"> Pessoa Jurídica <input type=radio value='fisica' name='pessoa' id='pessoa_fisica' <?PHP print $_POST[pessoa] == 'fisica' ? "checked" : "";?> onclick="change_tipo_pessoa(this);" onblur="change_tipo_pessoa();"> Pessoa Física </td>
</tr>
</table>

<BR><p><BR>

<img src='images/sub-ident-fisica.jpg' border=0><BR>
<table width=100% cellspacing=2 cellpadding=2 border=0>
<tr>
<td width=180>Nome:</td>
<td><input onpaste="return false;" type=text id='nome' name='nome' value='<?=$_POST[nome];?>' size=30  class='required' onkeyup="change_classname('nome', 'required');"></td>
</tr>
<tr>
<td width=180>Sexo:</td>
<td><input type=radio value='masculino' name='sexo' id='sexo_m' <?PHP print $_POST[sexo] == 'masculino' ? "checked" : "";?>> Masculino <input type=radio value='feminino' name='sexo' id='sexo_f' <?PHP print $_POST[sexo] == 'feminino' ? "checked" : "";?>> Feminino </td>
</tr>
<tr>
<td width=180>Nascimento:</td>
<td><input onpaste="return false;" type=text id='nascimento' name='nascimento' value='<?=$_POST[nascimento];?>' size=10 maxlength=10 onkeypress="formatar(this, '##/##/####');" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('nascimento', 'required');"></td>
</tr>
<tr>
<td width=180>CPF:</td>
<td><input onpaste="return false;" type=text id='cpf' name='cpf' class='required' value='<?=$_POST[cpf];?>' maxlength="14" onkeypress="formatar(this, '###.###.###-##');" onkeydown="return only_number(event);" onkeyup="change_classname('cpf', 'required');"><!--&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Digite seu CPF sem pontos ou traços, apenas números.' title='Digite seu CPF sem pontos ou traços, apenas números.'>--></td>
</tr>
<tr>
<td width=180>Profissão:</td>
<td>
<!--<input type=text id='profissao' name='profissao' value='<?=$_POST[profissao];?>' class='required' onkeyup="change_classname('profissao', 'required');">-->
<select name="profissao" id="profissao" class='required' onchange="change_classname('profissao', 'required');">
        <option selected="selected">Selecione</option>

        <option value="75">
          [Outra]
          </option>

        <option value="Administrador">
          Administrador
          </option>

        <option value="Advogado">
          Advogado
          </option>

        <option value="Agicultor">
          Agricultor
          </option>


        <option value="Agrônomo">
          Agrônomo
          </option>

        <option value="Analista">
          Analista
          </option>

        <option value="Analista de Sistemas">
          Analista de Sistemas
          </option>

        <option value="Analista Financeiro">

          Analista Financeiro
          </option>

        <option value="Aposentado / Pensionista">
          Aposentado / Pensionista
          </option>

        <option value="Arquiteto">
          Arquiteto
          </option>

        <option value="Artista">
          Artista
          </option>


        <option value="Assistente Social">
          Assistente Social
          </option>

        <option value="Auditor">
          Auditor
          </option>

        <option value="Autônomo">
          Autônomo
          </option>

        <option value="Auxiliar Administrativo">

          Auxiliar Administrativo
          </option>

        <option value="Auxiliar de Consultório">
          Auxiliar de Consultório
          </option>

        <option value="Auxiliar de Enfermagem">
          Auxiliar de Enfermagem
          </option>

        <option value="Aviador">
          Aviador
          </option>


        <option value="Bancário">
          Bancário
          </option>

        <option value="Bibliotecário">
          Bibliotecário
          </option>

        <option value="Biólogo">
          Biólogo
          </option>

        <option value="Biomédico">

          Biomédico
          </option>

        <option value="Cabeleireiro">
          Cabeleireiro
          </option>

        <option value="Comerciante">
          Comerciante
          </option>

        <option value="Comunicador">
          Comunicador
          </option>


        <option value="Consultor">
          Consultor
          </option>

        <option value="Contador">
          Contador
          </option>

        <option value="Delegado">
          Delegado
          </option>

        <option value="Dentista / Odontologista">

          Dentista / Odontologista
          </option>

        <option value="Designer">
          Designer
          </option>

        <option value="Despachante">
          Despachante
          </option>

        <option value="Diretor">
          Diretor
          </option>


        <option value="Dona de Casa">
          Dona de Casa
          </option>

        <option value="Economista">
          Economista
          </option>

        <option value="Educador Físico">
          Educador Físico
          </option>

        <option value="Empresário">

          Empresário
          </option>

        <option value="Enfermeiro">
          Enfermeiro
          </option>

        <option value="Engenheiro">
          Engenheiro
          </option>

        <option value="Estagiário">
          Estagiário
          </option>


        <option value="Estatístico">
          Estatístico
          </option>

        <option value="Esteticista">
          Esteticista
          </option>

        <option value="Estudante">
          Estudante
          </option>

        <option value="Farmacêutico">

          Farmacêutico
          </option>

        <option value="Fiscal">
          Fiscal
          </option>

        <option value="Fisioterapeuta">
          Fisioterapeuta
          </option>

        <option value="Fonoaudiólogo">
          Fonoaudiólogo
          </option>


        <option value="Funcionário Público">
          Funcionário Público
          </option>

        <option value="Geógrafo">
          Geógrafo
          </option>

        <option value="Gerente">
          Gerente
          </option>

        <option value="Jornalista">

          Jornalista
          </option>

        <option value="Médico">
          Médico
          </option>

        <option value="Médico Veterinário">
          Médico Veterinário
          </option>

        <option value="Motorista">
          Motorista
          </option>


        <option value="Músico">
          Músico
          </option>

        <option value="Nutricionista">
          Nutricionista
          </option>

        <option value="Pedagogo">
          Pedagogo
          </option>

        <option value="Perito">

          Perito
          </option>

        <option value="Político">
          Político
          </option>

        <option value="Professor Ensino Médio">
          Professor Ensino Médio
          </option>

        <option value="Professor Ensino Primário">
          Professor Ensino Primário
          </option>


        <option value="Professor Universitário">
          Professor Universitário
          </option>

        <option value="Programador">
          Programador
          </option>

        <option value="Psicólogo">
          Psicólogo
          </option>

        <option value="Publicitário">

          Publicitário
          </option>

        <option value="Químico">
          Químico
          </option>

        <option value="Relações Públicas">
          Relações Públicas
          </option>

        <option value="Sacerdorte">
          Sacerdorte
          </option>


        <option value="Secretário">
          Secretário
          </option>

        <option value="Servidor Público">
          Servidor Público
          </option>

        <option value="Técnico de Enfermagem">
          Técnico de Enfermagem
          </option>

        <option value="Técnico em Química">

          Técnico em Química
          </option>

        <option value="Técnico em Segurança">

          Técnico em Segurança
          </option>

        <option value="Terapeuta">
          Terapeuta
          </option>

        <option value="Terapeuta Ocupacional">
          Terapeuta Ocupacional
          </option>

        <option value="Turismólogo">

          Turismólogo
          </option>


        <option value="Vendedor">
          Vendedor
          </option>

        <option value="Zootecnista">
          Zootecnista
          </option>

      </select>
</td>
</tr>
<tr>
<td width=180>Instituição:</td>
<td><input onpaste="return false;" type=text id='instituicao' name='instituicao' value='<?=$_POST[instituicao];?>' class='required' onkeyup="change_classname('instituicao', 'required');">&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Local em que trabalha ou estuda.' title='Local em que trabalha ou estuda.'></td>
</tr>
</table>

<BR><p><BR>

<img src='images/sub-ident-juridica.jpg' border=0><BR>
<table width=100% cellspacing=2 cellpadding=2 border=0>
<tr>
<td width=180>Razão social:</td>
<td><input onpaste="return false;" type=text id='razao_social' name='razao_social' value='<?=$_POST[razao_social];?>' size=30 class='required' onkeyup="change_classname('razao_social', 'required');"></td>
</tr>
<tr>
<td width=180>Nome fantasia:</td>
<td><input onpaste="return false;" type=text id='nome_fantasia' name='nome_fantasia' value='<?=$_POST[nome_fantasia];?>' size=30 class='required' onkeyup="change_classname('nome_fantasia', 'required');"></td>
</tr>
<tr>
<td width=180>CNPJ:</td>
<td><input onpaste="return false;" type=text id=cnpj name=cnpj class='required' value='<?=$_POST[cnpj];?>' maxlength="18" onkeydown="return only_number(event);" onkeypress="formatar(this, '##.###.###/####-##');" onkeyup="change_classname('cnpj', 'required');"></td>
</tr>
<tr>
<td width=180>Inscrição estadual:</td>
<td><input onpaste="return false;" type=text id='insc_estadual' name='insc_estadual' value='<?=$_POST[insc_estadual];?>' size=10 class='required' maxlength="10" onkeydown="return only_number(event);" onkeypress="formatar(this, '##.###.###');" onkeyup="change_classname('insc_estadual', 'required');"></td>
</tr>
<tr>
<td width=180>Inscrição municipal:</td>
<td><input onpaste="return false;" type=text id='insc_municipal' name='insc_municipal' value='<?=$_POST[insc_municipal];?>' size=10 class='required' maxlength="10" onkeydown="return only_number(event);" onkeypress="formatar(this, '###.###-##');" onkeyup="change_classname('insc_municipal', 'required');"><!--&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Digite seu CPF sem pontos ou traços, apenas números.' title='Digite seu CPF sem pontos ou traços, apenas números.'>--></td>
</tr>
<tr>
<td width=180>CNAE:</td>
<td><input onpaste="return false;" type=text id='cnae' name='cnae' class='required' value='<?=$_POST[cnae];?>' size=10 maxlength="7" onkeydown="return only_number(event);" onkeypress="formatar(this, '##.##-#');" onblur="check_cnae(this);" onkeyup="change_classname('cnae', 'required');">&nbsp;<span id='loading_cnae'></span><input type=hidden id='valid_cnae' name='valid_cnae' value=0>&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Se você não sabe qual o CNAE da sua empresa, clique em pesquisar ao lado e verifique o CNAE principal.' title='Se você não sabe qual o CNAE da sua empresa, clique em pesquisar ao lado e verifique o CNAE principal.'>&nbsp;<a href='http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/Cnpjreva_Solicitacao.asp' target=_blank>Pesquisar</a></td> <!-- http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/Cnpjreva_Solicitacao2.asp?cnpj=04722248000117 -->
</tr>
<tr>
<td width=180>Classe:</td>
<td>
<select name="classe" id="classe" class='required' onkeyup="change_classname('classe', 'required');">
		  		<option value="Centro Comercial">Centro Comercial</option>
				<option value="Cuidados Especiais">Cuidados Especiais</option>

				<option value="Depósito Baixo Porte">Depósito Baixo Porte</option>
				<option value="Depósito Grande Porte">Depósito Grande Porte</option>
				<option value="Depósito Médio Porte">Depósito Médio Porte</option>
				<option value="Educacional">Educacional</option>
				<option value="Escritório">Escritório</option>
				<option value="Estacionamento Grande Porte">Estacionamento Grande Porte</option>

				<option value="Estacionamento Médio Porte">Estacionamento Médio Porte</option>
				<option value="Estacionamento Pequeno Porte">Estacionamento Pequeno Porte</option>
				<option value="Industriais Inflamável Grande Porte">Industriais Inflamável Grande Porte</option>
				<option value="Industriais Inflamável Médio Porte">Industriais Inflamável Médio Porte</option>
				<option value="Industriais Não Inflamáveis">Industriais Não Inflamáveis</option>
				<option value="Locais de Reunião Pública">Locais de Reunião Pública</option>

				<option value="Residencial Comercial">Residencial Comercial</option>
				<option value="Residencial Multifamiliar">Residencial Multifamiliar</option>
				<option value="Restaurante">Restaurante</option>
				<option value="Saúde">Saúde</option>
				<option value="Transporte">Transporte</option>
</select>
&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Classe em que se enquadra a empresa.' title='Classe em que se enquadra a empresa.'>
</td>
</tr>
<tr>
<td width=180>Nº de colaboradores:</td>
<td><input onpaste="return false;" type=text id='colaboradores' name='colaboradores' value='<?=$_POST[colaboradores];?>' maxlength="4" onkeydown="return only_number(event);" size=30 class='required' onkeyup="change_classname('colaboradores', 'required');">&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Número de funcionários da empresa.' title='Número de funcionários da empresa.'></td>
</tr>
<tr>
<td width=180>Responsável:</td>
<td><input onpaste="return false;" type=text id='responsavel' name='responsavel' value='<?=$_POST[responsavel];?>' size=30 class='required' onkeyup="change_classname('responsavel', 'required');"></td>
</tr>
<tr>
<td width=180>Cargo do responsável:</td>
<td><input onpaste="return false;" type=text id='cargo_responsavel' name='cargo_responsavel' value='<?=$_POST[cargo_responsavel];?>' size=30 class='required' onkeyup="change_classname('cargo_responsavel', 'required');"></td>
</tr>
<tr>
<td width=180>E-Mail do responsável:</td>
<td><input onpaste="return false;" type=text id='email_responsavel' name='email_responsavel' value='<?=$_POST[email_responsavel];?>' size=30 class='required' onkeyup="change_classname('email_responsavel', 'required');"></td>
</tr>
<tr>
<td width=180>Sexo:</td>
<td><input type=radio id='sexo_responsavel_m' name='sexo_responsavel' value='masculino' <?PHP print $_POST[sexo_responsavel] == 'masculino' ? "checked" : "";?>> Masculino <input type=radio id='sexo_responsavel_f' name='sexo_responsavel' value='feminino'<?PHP print $_POST[sexo_responsavel] == 'feminino' ? "checked" : "";?>> Feminino</td>
</tr>
<tr>
<td width=180>Nascimento:</td>
<td><input onpaste="return false;" type=text id='nascimento_responsavel' name='nascimento_responsavel' value='<?=$_POST[nascimento_responsavel];?>' size=10 maxlength=10 onkeypress="formatar(this, '##/##/####');" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('nascimento_responsavel', 'required');"></td>
</tr>
<tr>
<td width=180>Escritório de contabilidade:</td>
<td><input type=text id='escritorio_contabilidade' name='escritorio_contabilidade' value='<?=$_POST[escritorio_contabilidade];?>' size=30 class='required' onkeyup="change_classname('escritorio_contabilidade', 'required');"></td>
</tr>
<tr>
<td width=180>Nome do contador:</td>
<td><input type=text id='nome_contador' name='nome_contador' size=30 class='required' value='<?=$_POST[nome_contador];?>' onkeyup="change_classname('nome_contador', 'required');"></td>
</tr>
<tr>
<td width=180>Telefone do contador:</td>
<td><input onpaste="return false;" type=text id='tel_contador' name='tel_contador' value='<?=$_POST[tel_contador];?>' maxlength=15 onkeypress="fone(this);" onkeydown="return only_number(event);" size=30 class='required' onkeyup="change_classname('tel_contador', 'required');"></td>
</tr>
<tr>
<td width=180>E-Mail do contador:</td>
<td><input type=text id='email_contador' name='email_contador' value='<?=$_POST[email_contador];?>' size=30 class='required' onkeyup="change_classname('email_contador', 'required');"></td>
</tr>
<tr>
<td width=180>CRC do contador:</td>
<td><input onpaste="return false;" type=text id='crc_contador' name='crc_contador' value='<?=$_POST[crc_contador];?>' size=30 class='required' maxlength=11 onkeypress="formatar(this, '## ######/#');" onkeyup="change_classname('crc_contador', 'required');">&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Digite o número do CRC como no exemplo: RJ 012345/6.' title='Digite o número do CRC como no exemplo: RJ 012345/6.'></td>
</tr>
</table>

<BR><p><BR>

<img src="images/sub-localizacao.jpg" border="0"><BR>
<table width="100%" cellspacing="2" cellpadding="2" border=0>
<tr>
<td width=180>CEP:</td>
<td><input onpaste="return false;" type="text" id='cep' name='cep' value='<?=$_POST[cep];?>' size=10 maxlength="9" onkeydown="return only_number(event);" onkeypress="formatar(this, '#####-###');" size=30 class='required' onblur="check_cep(this);" onkeyup="change_classname('cep', 'required');">&nbsp;<span id='loading_cep'></span></td>
</tr>
<tr>
<td width=180>Endereço:</td>
<td><input type=text id=endereco name=endereco value='<?=$_POST[endereco];?>'  class='required' onkeyup="change_classname('endereco', 'required');"> Nº <input type=text id=num_end name=num_end value='<?=$_POST[num_end];?>'  size=5 class='required' onkeydown="return only_number(event);" onkeyup="change_classname('email', 'required');"></td>
</tr>
<tr>
<td width=180>Complemento:</td>
<td><input type=text id='complemento' name='complemento' size=10 value='<?=$_POST[complemento];?>' ></td>
</tr>
<tr>
<td width=180>Bairro:</td>
<td><input type=text id='bairro' name='bairro' value='<?=$_POST[bairro];?>' class='required' onkeyup="change_classname('bairro', 'required');"></td>
</tr>
<tr>
<td width=180>Cidade:</td>
<td><input type=text id='cidade' name='cidade' value='<?=$_POST[cidade];?>' class='required' onkeyup="change_classname('cidade', 'required');"></td>
</tr>
<tr>
<td width=180>Estado:</td>
<td>
<select name="estado" id="estado" class='required' onkeyup="change_classname('estado', 'required');">
            <option value="">Selecione</option>
            <option value="AC">Acre</option>

            <option value="AM">Amazonas</option>
            <option value="AP">Amapá</option>
            <option value="AL">Alagoas</option>

            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>

            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>

            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MG">Minas Gerais</option>

            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>

            <option value="PE">Pernambuco</option>
            <option value="PR">Paraná</option>
            <option value="PI">Piauí</option>
            <option value="RJ" checked>Rio de Janeiro</option>

            <option value="RN">Rio Grande do Norte</option>
            <option value="RO">Rondônia</option>

            <option value="RS">Rio Grande do Sul</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SE">Sergipe</option>

            <option value="SP">São Paulo</option>
            <option value="TO">Tocantins</option>

</select>
</td>
</tr>
<tr>
<td width=180>Telefone:</td>
<td><input onpaste="return false;" type=text id='telefone' name='telefone' value='<?=$_POST[telefone];?>' maxlength=15 onkeypress="fone(this);" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('telefone', 'required');"></td>
</tr>
<tr>
<td width=180>Telefone comercial:</td>
<td><input onpaste="return false;" type=text id='tel_comercial' name='tel_comercial' value='<?=$_POST[tel_comercial];?>' maxlength=15 onkeypress="fone(this);" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('tel_comercial', 'required');"></td>
</tr>
<tr>
<td width=180>Fax:</td>
<td><input onpaste="return false;" type=text id='fax' name='fax' value='<?=$_POST[fax];?>' maxlength=15 onkeypress="fone(this);" onkeydown="return only_number(event);" ></td>
</tr>
<tr>
<td width=180>Telefone celular:</td>
<td><input onpaste="return false;" type=text id='tel_celular' name='tel_celular' value='<?=$_POST[tel_celular];?>' maxlength=15 onkeypress="fone(this);" onkeydown="return only_number(event);" ></td>
</tr>
<tr>
<td width=180>Nextel:</td>
<td><input onpaste="return false;" type=text id='nextel' name='nextel' value='<?=$_POST[nextel];?>' maxlength=15 onkeypress="fone(this);" onkeydown="return only_number(event);" ></td>
</tr>
<tr>
<td width=180>MSN:</td>
<td><input type=text id='msn' name='msn' value='<?=$_POST[msn];?>' ></td>
</tr>
<tr>
<td width=180>Como conheceu a SEMST<sup>®</sup>?</td>
<td>
<select name="como_conheceu" id="como_conheceu">
	<option value="">Selecione</option>
	<option value="E-mail Marketing">E-mail Marketing</option>
	<option value="Jornal SESMT">Jornal SESMT</option>
	<option value="Site de Busca de Preço">Site de Busca de Preço</option>
	<option value="Site de Busca">Site de Busca</option>
	<option value="Busca Pé">Busca Pé</option>
	<option value="Bom de Faro">Bom de Faro</option>
	<option value="Cota-Cota">Cota-Cota</option>
	<option value="Shopping Uol">Shopping Uol</option>
	<option value="Skype">Skype</option>
	<option value="Indicação de Amigo">Indicação de Amigo</option>
	<option value="Banner na Internet">Banner na Internet</option>
	<option value="Site da ABF ">Site da ABF </option>
	<option value="Google">Google</option>
	<option value="Ovem Ture">Ovem Ture</option>
	<option value="Uol">Uol</option>
	<option value="Twitter">Twitter</option>
	<option value="FaceBook">FaceBook</option>
	<option value="Orkut Blog">Orkut Blog</option>
	<option value="Outras Formas">Outras Formas</option>
</select>
</td>
</tr>
<tr>
<td width=180>Código chave:</td>
<td><input type=text id='cod_chave' name='cod_chave' value='<?=$_POST[cod_chave];?>' >&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Apenas preencha este campo caso seja orientado a fazê-lo, caso contrário, deixe-o em branco.' title='Apenas preencha este campo caso seja orientado a fazê-lo, caso contrário, deixe-o em branco.'></td>
</tr>
</table>
<BR><p><BR>
<center><input type=submit id='btnCriarConta' name='btnCriarConta' value='Criar minha conta'></center>
</form>
<script>
    change_tipo_pessoa();
</script>
<?PHP
}//END ELSE IF NOT POST
?>
