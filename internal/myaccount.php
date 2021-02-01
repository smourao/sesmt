<center><img src='images/dados-cadastrais.jpg' border=0></center>
<p align=justify>
<div class='novidades_text'>
Mantenha seus dados cadastrais sempre atualizados, isto mantém a fidelidade de suas informações em nosso
sistema.
</div>
<?PHP
$myaccount_error = 0;
if($_POST && $_POST[btnUpdateMyAccount]){
    // --> [TRATAMENTO DE VARIÁVEIS]:
    $email              = strtolower(anti_injection($_POST[email]));

    //-- PESSOA FISICA
    $nome               = anti_injection($_POST[nome]);
    $sexo               = anti_injection($_POST[sexo]);
    $nascimento         = explode("/", anti_injection($_POST[nascimento]));
    $nascimento         = $nascimento[2]."-".$nascimento[1]."-".$nascimento[0];
    $cpf                = anti_injection($_POST[cpf]);
    $profissao          = anti_injection($_POST[profissao]);
    $instituicao        = anti_injection($_POST[instituicao]);

    //-- PESSOA JURÍDICA
    $razao_social       = anti_injection($_POST[razao_social]);
    $nome_fantasia      = anti_injection($_POST[nome_fantasia]);
    $cnpj               = anti_injection($_POST[cnpj]);
    $insc_estadual      = anti_injection($_POST[insc_estadual]);
    $insc_municipal     = anti_injection($_POST[insc_municipal]);
    $cnae               = anti_injection($_POST[cnae]);
    $classe             = anti_injection($_POST[classe]);
    $colaboradores      = (int)(anti_injection($_POST[colaboradores]));
    $responsavel        = anti_injection($_POST[responsavel]);
    $cargo_responsavel  = anti_injection($_POST[cargo_responsavel]);
    $email_responsavel  = anti_injection($_POST[email_responsavel]);
    $sexo_responsavel   = anti_injection($_POST[sexo_responsavel]);
    $nasc_responsavel   = explode("/", anti_injection($_POST[nascimento_responsavel]));
    $nasc_responsavel   = $nasc_responsavel[2]."-".$nasc_responsavel[1]."-".$nasc_responsavel[0];
    $escritorio_contab  = anti_injection($_POST[escritorio_contabilidade]);
    $nome_contador      = anti_injection($_POST[nome_contador]);
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
    /*
    $sql = "SELECT id FROM reg_pessoa_fisica WHERE email='$email'
        UNION
        SELECT id FROM reg_pessoa_juridica WHERE email='$email'";
    if(pg_num_rows(pg_query($sql))){
        echo "<div class='novidades_text'><p align=justify>O e-mail <b>$email</b> já está em uso. Por favor, tente novamente com outro e-mail, em caso de dúvidas, entre em contato com a nossa <a href='?do=contato'>central de atendimento</a>.</div>";
    }else{
    */
        //$sql = "";
        if($_POST[pessoa] == "fisica"){
            $sql = "UPDATE reg_pessoa_fisica SET
            --email = '$email',
            nome = '$nome',
            sexo = '$sexo',
            nascimento = '$nascimento',
            cpf = '$cpf',
            profissao = '$profissao',
            instituicao = '$instituicao',
            cep = '$cep',
            endereco = '$endereco',
            numero = '$num_end',
            complemento = '$complemento',
            bairro = '$bairro',
            cidade = '$cidade',
            estado = '$estado',
            telefone = '$telefone',
            tel_comercial = '$tel_comercial',
            tel_celular = '$tel_celular',
            fax = '$fax',
            nextel = '$nextel',
            msn = '$msn'
            WHERE
            lower(email) = '$_SESSION[user_id]'";
        }else{
            $sql = "UPDATE reg_pessoa_juridica SET
            --email = '$email',
            razao_social = '$razao_social',
            --cnpj = '$cnpj',
            nome_fantasia = '$nome_fantasia',
            inscricao_estadual = '$insc_estadual',
            inscricao_municipal = '$insc_municipal',
            cep = '$cep',
            endereco = '$endereco',
            numero = '$num_end',
            complemento = '$complemento',
            bairro = '$bairro',
nascimento = '$nasc_responsavel',
            cidade = '$cidade',
            estado = '$estado',
            telefone = '$telefone',
            tel_comercial = '$tel_comercial',
            tel_celular = '$tel_celular',
            colaboradores = '$colaboradores',
            fax = '$fax',
            nextel = '$nextel',
            msn = '$msn',
            cnae = '$cnae',
            responsavel = '$responsavel',
            cargo = '$cargo_responsavel',
            email_pessoal = '$email_responsavel',
            sexo = '$sexo_responsavel',
            escritorio_contabilidade = '$escritorio_contab',
            nome_contador = '$nome_contador',
            tel_contador = '$tel_contador',
            email_contador  = '$email_contador',
            crc_contador = '$crc_contador'
            WHERE lower(email) = '$_SESSION[user_id]'";
        }
//echo "glhkjds".$sql;
        if(pg_query($sql)){
            $myaccount_error = 1;
            if($_SESSION[user_id] != $email){
                unset($_SESSION[user_id]);
                unset($_SESSION[tipo_usuario]);
                unset($_SESSION[tipo_cliente]);
                unset($_SESSION[cod_cliente]);
                unset($_SESSION[tipo_acesso]);
                echo "<script>alert('É necessário que você refaça seu login utilizando o novo e-mail informado.');location.href='?do=myaccount';</script>";
            }else{
                echo "<div class='novidades_text'><p align=justify>Os dados de sua conta foram atualizados com sucesso.</div>";
            }
        }else{
            $myaccount_error = 2;
            echo "<div class='novidades_text'><p align=justify>Houve um erro ao tentar atualizar seu cadastro. Por favor, tente novamente em alguns instantes, se o problema persistir, entre em contato com a nossa <a href='?do=contato'>central de atendimento</a>.</div>";
        }
    //}

}

//consulta dados do cliente
if($_SESSION[tipo_cliente] == 1)
    $sql = "SELECT * FROM reg_pessoa_fisica WHERE lower(email) = '".strtolower($_SESSION[user_id])."'";
else
    $sql = "SELECT * FROM reg_pessoa_juridica WHERE lower(email) = '".strtolower($_SESSION[user_id])."'";
$rtp = pg_query($sql);
$accdata = pg_fetch_array($rtp);

?>
<BR><p><BR>
<form method=post name='frmMyAccount' id='frmMyAccount' onsubmit="return check_myaccount_form(this);">
<img src='images/sub-ident-site.jpg' border=0><BR>
<table width=100% cellspacing=2 cellpadding=2 border=0>
<tr>
<td width=180>E-Mail:</td>
<td><input type=text id='email' name='email' value='<?=$accdata[email];?>' size=30 class='required' onkeyup="change_classname('email', 'required');">&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Este e-mail é seu login de acesso ao nosso site, caso seja alterado, você deverá utilizar o novo e-mail cadastrado para logar-se.' title='Este e-mail é seu login de acesso ao nosso site, caso seja alterado, você deverá utilizar o novo e-mail cadastrado para logar-se.'></td>
</tr>
<tr>
<td width=180>Tipo de cadastro:</td>
<td>
<?PHP print $_SESSION[tipo_cliente] == 1 ? "Pessoa física" : "Pessoa jurídica";?>
<input type=hidden name='pessoa' id='pessoa' value='<?PHP if($_SESSION[tipo_cliente] == 1){ echo "fisica"; }else{ echo "juridica"; } ?>'>
</td>
</tr>
</table>

<BR><p><BR>
<?PHP
if($_SESSION[tipo_cliente] == 1){
?>
<img src='images/sub-ident-fisica.jpg' border=0><BR>
<table width=100% cellspacing=2 cellpadding=2 border=0>
<tr>
<td width=180>Nome:</td>
<td><input type=text id='nome' name='nome' value='<?=$accdata[nome];?>' size=30  class='required' onkeyup="change_classname('nome', 'required');"></td>
</tr>
<tr>
<td width=180>Sexo:</td>
<td><input type=radio value='masculino' name='sexo' id='sexo_m' <?PHP print strtolower($accdata[sexo]) == 'masculino' ? "checked" : "";?>> Masculino <input type=radio value='feminino' name='sexo' id='sexo_f' <?PHP print strtolower($accdata[sexo]) == 'feminino' ? "checked" : "";?>> Feminino </td>
</tr>
<tr>
<td width=180>Nascimento:</td>
<td><input type=text id='nascimento' name='nascimento' value='<?=date("d/m/Y", strtotime($accdata[nascimento]));?>' size=10 maxlength=10 onkeypress="formatar(this, '##/##/####');" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('nascimento', 'required');"></td>
</tr>
<tr>
<td width=180>CPF:</td>
<td><input type=text id='cpf' name='cpf' class='required' value='<?=$accdata[cpf];?>' maxlength="14" onkeypress="formatar(this, '###.###.###-##');" onkeydown="return only_number(event);" onkeyup="change_classname('cpf', 'required');"><!--&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Digite seu CPF sem pontos ou traços, apenas números.' title='Digite seu CPF sem pontos ou traços, apenas números.'>--></td>
</tr>
<tr>
<td width=180>Profissão:</td>
<td>
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
<td><input type=text id='instituicao' name='instituicao' value='<?=$accdata[instituicao];?>' class='required' onkeyup="change_classname('instituicao', 'required');">&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Local em que trabalha ou estuda.' title='Local em que trabalha ou estuda.'></td>
</tr>
</table>

<BR><p><BR>
<?PHP
}else{
?>
<img src='images/sub-ident-juridica.jpg' border=0><BR>
<table width=100% cellspacing=2 cellpadding=2 border=0>
<tr>
<td width=180>Razão social:</td>
<td><input type=text id='razao_social' name='razao_social' value='<?=$accdata[razao_social];?>' size=30 class='required' onkeyup="change_classname('razao_social', 'required');"></td>
</tr>
<tr>
<td width=180>Nome fantasia:</td>
<td><input type=text id='nome_fantasia' name='nome_fantasia' value='<?=$accdata[nome_fantasia];?>' size=30 class='required' onkeyup="change_classname('nome_fantasia', 'required');"></td>
</tr>
<tr>
<td width=180>CNPJ:</td>
<td><input type=text id=cnpj name=cnpj class='required' value='<?=$accdata[cnpj];?>' maxlength="18" onkeydown="return only_number(event);" onkeypress="formatar(this, '##.###.###/####-##');" onkeyup="change_classname('cnpj', 'required');"></td>
</tr>
<tr>
<td width=180>Inscrição estadual:</td>
<td><input type=text id='insc_estadual' name='insc_estadual' value='<?=$accdata[inscricao_estadual];?>' size=10 class='required' maxlength="10" onkeydown="return only_number(event);" onkeypress="formatar(this, '##.###.###');" onkeyup="change_classname('insc_estadual', 'required');"></td>
</tr>
<tr>
<td width=180>Inscrição municipal:</td>
<td><input type=text id='insc_municipal' name='insc_municipal' value='<?=$accdata[inscricao_municipal];?>' size=10 class='required' maxlength="10" onkeydown="return only_number(event);" onkeypress="formatar(this, '###.###-##');" onkeyup="change_classname('insc_municipal', 'required');"><!--&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Digite seu CPF sem pontos ou traços, apenas números.' title='Digite seu CPF sem pontos ou traços, apenas números.'>--></td>
</tr>
<tr>
<td width=180>CNAE:</td>
<td><input type=text id='cnae' name='cnae' class='required' value='<?=$accdata[cnae];?>' size=10 maxlength="7" onkeydown="return only_number(event);" onkeypress="formatar(this, '##.##-#');" onblur="check_cnae(this);" onkeyup="change_classname('cnae', 'required');">&nbsp;<span id='loading_cnae'></span><input type=hidden id='valid_cnae' name='valid_cnae' value=0>&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Se você não sabe qual o CNAE da sua empresa, clique em pesquisar ao lado e verifique o CNAE principal.' title='Se você não sabe qual o CNAE da sua empresa, clique em pesquisar ao lado e verifique o CNAE principal.'>&nbsp;<a href='http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/Cnpjreva_Solicitacao.asp' target=_blank>Pesquisar</a></td> <!-- http://www.receita.fazenda.gov.br/PessoaJuridica/CNPJ/cnpjreva/Cnpjreva_Solicitacao2.asp?cnpj=04722248000117 -->
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
<td><input type=text id='colaboradores' name='colaboradores' value='<?=$accdata[colaboradores];?>' maxlength="4" onkeydown="return only_number(event);" size=30 class='required' onkeyup="change_classname('colaboradores', 'required');">&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Número de funcionários da empresa.' title='Número de funcionários da empresa.'></td>
</tr>
<tr>
<td width=180>Responsável:</td>
<td><input type=text id='responsavel' name='responsavel' value='<?=$accdata[responsavel];?>' size=30 class='required' onkeyup="change_classname('responsavel', 'required');"></td>
</tr>
<tr>
<td width=180>Cargo do responsável:</td>
<td><input type=text id='cargo_responsavel' name='cargo_responsavel' value='<?=$accdata[cargo];?>' size=30 class='required' onkeyup="change_classname('cargo_responsavel', 'required');"></td>
</tr>
<tr>
<td width=180>E-Mail do responsável:</td>
<td><input type=text id='email_responsavel' name='email_responsavel' value='<?=$accdata[email_pessoal];?>' size=30 class='required' onkeyup="change_classname('email_responsavel', 'required');"></td>
</tr>
<tr>
<td width=180>Sexo:</td>
<td><input type=radio id='sexo_responsavel_m' name='sexo_responsavel' value='masculino' <?PHP print strtolower($accdata[sexo]) == 'masculino' ? "checked" : "";?>> Masculino <input type=radio id='sexo_responsavel_f' name='sexo_responsavel' value='feminino'<?PHP print strtolower($accdata[sexo]) == 'feminino' ? "checked" : "";?>> Feminino</td>
</tr>
<tr>
<td width=180>Nascimento:</td>
<td><input type=text id='nascimento_responsavel' name='nascimento_responsavel' value='<?=date("d/m/Y", strtotime($accdata[nascimento]));?>' size=10 maxlength=10 onkeypress="formatar(this, '##/##/####');" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('nascimento_responsavel', 'required');"></td>
</tr>
<tr>
<td width=180>Escritório de contabilidade:</td>
<td><input type=text id='escritorio_contabilidade' name='escritorio_contabilidade' value='<?=$accdata[escritorio_contabilidade];?>' size=30 class='required' onkeyup="change_classname('escritorio_contabilidade', 'required');"></td>
</tr>
<tr>
<td width=180>Nome do contador:</td>
<td><input type=text id='nome_contador' name='nome_contador' size=30 class='required' value='<?=$accdata[nome_contador];?>' onkeyup="change_classname('nome_contador', 'required');"></td>
</tr>
<tr>
<td width=180>Telefone do contador:</td>
<td><input type=text id='tel_contador' name='tel_contador' value='<?=$accdata[tel_contador];?>' maxlength=14 onkeypress="fone(this);" onkeydown="return only_number(event);" size=30 class='required' onkeyup="change_classname('tel_contador', 'required');"></td>
</tr>
<tr>
<td width=180>E-Mail do contador:</td>
<td><input type=text id='email_contador' name='email_contador' value='<?=$accdata[email_contador];?>' size=30 class='required' onkeyup="change_classname('email_contador', 'required');"></td>
</tr>
<tr>
<td width=180>CRC do contador:</td>
<td><input type=text id='crc_contador' name='crc_contador' value='<?=$accdata[crc_contador];?>' size=30 class='required' maxlength=11 onkeypress="formatar(this, '## ######/#');" onkeyup="change_classname('crc_contador', 'required');">&nbsp;<img src='images/ico-help.png' border=0 align=top style="cursor: help;" alt='Digite o número do CRC como no exemplo: RJ 012345/6.' title='Digite o número do CRC como no exemplo: RJ 012345/6.'></td>
</tr>
</table>

<BR><p><BR>
<?PHP
}
?>
<img src="images/sub-localizacao.jpg" border="0"><BR>
<table width=100% cellspacing=2 cellpadding=2 border=0>
<tr>
<td width=180>CEP:</td>
<td><input type=text id='cep' name='cep' value='<?=$accdata[cep];?>' size=10 maxlength="9" onkeydown="return only_number(event);" onkeypress="formatar(this, '#####-###');" size=30 class='required' onblur="check_cep(this);" onkeyup="change_classname('cep', 'required');">&nbsp;<span id='loading_cep'></span></td>
</tr>
<tr>
<td width=180>Endereço:</td>
<td><input type=text id=endereco name=endereco value='<?=$accdata[endereco];?>'  class='required' onkeyup="change_classname('endereco', 'required');"> Nº <input type=text id=num_end name=num_end value='<?=$accdata[numero];?>'  size=5 class='required' onkeydown="return only_number(event);" onkeyup="change_classname('email', 'required');"></td>
</tr>
<tr>
<td width=180>Complemento:</td>
<td><input type=text id='complemento' name='complemento' size=10 value='<?=$accdata[complemento];?>' ></td>
</tr>
<tr>
<td width=180>Bairro:</td>
<td><input type=text id='bairro' name='bairro' value='<?=$accdata[bairro];?>' class='required' onkeyup="change_classname('bairro', 'required');"></td>
</tr>
<tr>
<td width=180>Cidade:</td>
<td><input type=text id='cidade' name='cidade' value='<?=$accdata[cidade];?>' class='required' onkeyup="change_classname('cidade', 'required');"></td>
</tr>
<tr>
<td width=180>Estado:</td>
<td>
<select name="estado" id="estado" class='required' onkeyup="change_classname('estado', 'required');">
            <option value="">Selecione</option>
            <option value="AC" <?php if($accdata[estado] == "AC") echo " selected='selected' ";?> >Acre</option>

            <option value="AM" <?php if($accdata[estado] == "AM") echo " selected='selected' ";?> >Amazonas</option>
            <option value="AP" <?php if($accdata[estado] == "AP") echo " selected='selected' ";?> >Amapá</option>
            <option value="AL" <?php if($accdata[estado] == "AL") echo " selected='selected' ";?> >Alagoas</option>

            <option value="BA" <?php if($accdata[estado] == "BA") echo " selected='selected' ";?> >Bahia</option>
            <option value="CE" <?php if($accdata[estado] == "CE") echo " selected='selected' ";?> >Ceará</option>
            <option value="DF" <?php if($accdata[estado] == "DF") echo " selected='selected' ";?> >Distrito Federal</option>

            <option value="ES" <?php if($accdata[estado] == "ES") echo " selected='selected' ";?> >Espírito Santo</option>
            <option value="GO" <?php if($accdata[estado] == "GO") echo " selected='selected' ";?> >Goiás</option>

            <option value="MA" <?php if($accdata[estado] == "MA") echo " selected='selected' ";?> >Maranhão</option>
            <option value="MT" <?php if($accdata[estado] == "MT") echo " selected='selected' ";?> >Mato Grosso</option>
            <option value="MS" <?php if($accdata[estado] == "MS") echo " selected='selected' ";?> >Mato Grosso do Sul</option>
            <option value="MG" <?php if($accdata[estado] == "MG") echo " selected='selected' ";?> >Minas Gerais</option>

            <option value="PA" <?php if($accdata[estado] == "PA") echo " selected='selected' ";?> >Pará</option>
            <option value="PB" <?php if($accdata[estado] == "PB") echo " selected='selected' ";?> >Paraíba</option>

            <option value="PE" <?php if($accdata[estado] == "PE") echo " selected='selected' ";?> >Pernambuco</option>
            <option value="PR" <?php if($accdata[estado] == "PR") echo " selected='selected' ";?> >Paraná</option>
            <option value="PI" <?php if($accdata[estado] == "PI") echo " selected='selected' ";?> >Piauí</option>
            <option value="RJ" <?php if($accdata[estado] == "RJ") echo " selected='selected' ";?> >Rio de Janeiro</option>

            <option value="RN" <?php if($accdata[estado] == "RN") echo " selected='selected' ";?> >Rio Grande do Norte</option>
            <option value="RO" <?php if($accdata[estado] == "RO") echo " selected='selected' ";?> >Rondônia</option>

            <option value="RS" <?php if($accdata[estado] == "RS") echo " selected='selected' ";?> >Rio Grande do Sul</option>
            <option value="RR" <?php if($accdata[estado] == "RR") echo " selected='selected' ";?> >Roraima</option>
            <option value="SC" <?php if($accdata[estado] == "SC") echo " selected='selected' ";?> >Santa Catarina</option>
            <option value="SE" <?php if($accdata[estado] == "SE") echo " selected='selected' ";?> >Sergipe</option>

            <option value="SP" <?php if($accdata[estado] == "SP") echo " selected='selected' ";?> >São Paulo</option>
            <option value="TO" <?php if($accdata[estado] == "TO") echo " selected='selected' ";?> >Tocantins</option>

</select>
</td>
</tr>
<tr>
<td width=180>Telefone:</td>
<td><input type=text id='telefone' name='telefone' value='<?=$accdata[telefone];?>' maxlength=14 onkeypress="fone(this);" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('telefone', 'required');"></td>
</tr>
<tr>
<td width=180>Telefone comercial:</td>
<td><input type=text id='tel_comercial' name='tel_comercial' value='<?=$accdata[tel_comercial];?>' maxlength=14 onkeypress="fone(this);" onkeydown="return only_number(event);" class='required' onkeyup="change_classname('tel_comercial', 'required');"></td>
</tr>
<tr>
<td width=180>Fax:</td>
<td><input type=text id='fax' name='fax' value='<?=$accdata[fax];?>' maxlength=14 onkeypress="fone(this);" onkeydown="return only_number(event);" ></td>
</tr>
<tr>
<td width=180>Telefone celular:</td>
<td><input type=text id='tel_celular' name='tel_celular' value='<?=$accdata[tel_celular];?>' maxlength=14 onkeypress="fone(this);" onkeydown="return only_number(event);" ></td>
</tr>
<tr>
<td width=180>Nextel:</td>
<td><input type=text id='nextel' name='nextel' value='<?=$accdata[nextel];?>' maxlength=14 onkeypress="fone(this);" onkeydown="return only_number(event);" ></td>
</tr>
<tr>
<td width=180>MSN:</td>
<td><input type=text id='msn' name='msn' value='<?=$accdata[msn];?>' ></td>
</tr>
</table>
<BR><p><BR>
<center><input type=submit id='btnUpdateMyAccount' name='btnUpdateMyAccount' value='Atualizar minha conta' onclick="if(document.getElementById('email').value != '<?PHP echo $_SESSION[user_id];?>'){return confirm('Seu e-mail foi alterado, se você confirmar a alteração será necessário relogar-se com o novo e-mail informado.\nTem certeza que deseja continuar?','');};"></center>
</form>
