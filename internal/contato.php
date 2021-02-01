<?php
if($_POST['email']){
	$email_cliente = $_POST['email'];
}


if($_POST and $_POST['agendamento']){
    $msg = '
    <html>
    <head>
     <title>SESMT</title>
    </head>
    <body>';
    $msg .= "Solicitação de Contato<br>";
    $msg .= "Assunto: {$_POST[escolha]}<br>";
    $msg .= "Nome: {$_POST[nome]}<br>";
    $msg .= "E-mail: {$_POST[email]}<br>";
    $msg .= "Telefone: {$_POST[tel]}<br>";
    $msg .= "Mensagem: {$_POST[assunto]}<br>";
    $msg .= "</body></html>";
    
    $sbj = "Solicitação de Contato";
    $name = "SESMT";
    $email = "sesmt@sesmt-rio.com";
    $headers  = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";
    if($_POST['nome_fake'] == ''){ //VERIFICADOR DE SPAM
        if(mail($_POST[dpt], $sbj, $msg, $headers)){
            echo "<script>alert('Solicitação enviada com sucesso!');</script>";
        }else{
            echo "<script>alert('Erro ao enviar solicitação!');</script>";
        }
    }else{
      
    }
	
	if($_POST[dpt] == "suporte@ti-seg.com" ){
	
	$msg2 = '
    <html>
    <head>
     <title>SESMT</title>
    </head>
    <body>';
    $msg2 .= "Prezado(a) cliente,<br>";
	$msg2 .= "estamos recebemos sua solicitação de atendimento.<br>";
    $msg2 .= "E nossos programadores já estão interagindo com a ferramenta para a correção nosso tempo estimado e de 72 horas no máximo para responderemos a sua solicitação.<br>";
    $msg2 .= "</body></html>";
    
    $sbj2 = "Solicitação de Contato";
    $name2 = "SESMT";
    $email2 = "sesmt@sesmt-rio.com";
    $headers2  = "MIME-Version: 1.0\n";
    $headers2 .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers2 .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";
    if(mail($email_cliente, $sbj2, $msg2, $headers2)){
        
    }else{
        echo "<script>alert('Erro ao enviar solicitação!');</script>";
    }
	}
}
?>
<center><img src="images/contato.jpg" border="0"></center>
<p>
<center>
<span onclick="contato('contact');" id='menuContato' style="cursor: pointer;"><img src='images/sub-contact-email.jpg' border=0></span>&nbsp;
<span onclick="contato('atend');" id='menuAtend' styFle="cursor: pointer;"><img src='images/sub-info-atendimento.jpg' border=0></span>&nbsp;
</center>

<p>
<form name="form1" method="post" onsubmit="return fuc(this);">
<div id="contact" style="display:none">
<table width="100%" border="0">
	<tr>
		<td align="left"><br>Todos os campos são de preenchimento obrigatório.</td>
	</tr>
</table>
<p>

<table width="100%" border="0" cellpadding="2" cellspacing="2">	
	<tr>
		<td align="left" width="25%">Escolha o Assunto:</td>
		<td align=left>
			<select class="required" name="escolha" id="escolha">
			<option value=""></option>
			<option value="Dúvidas Comerciais">Dúvidas Comerciais</option>
			<option value="Críticas">Críticas</option>
			<option value="Elogios">Elogios</option>
			<option value="Sugestões">Sugestões</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="left" width="25%">Departamento:</td>
	 	<td align=left>
			<input type="radio" value="financeiro@sesmt-rio.com" name="dpt" id="dpt">Financeiro
			<input type="radio" value="medicotrab@sesmt-rio.com" name="dpt" id="dpt">Saúde Ocupacional
			<input type="radio" value="suporte@ti-seg.com" name="dpt" id="dpt">Chamado Acesso Internet
			<input type="radio" value="segtrab@sesmt-rio.com" name="dpt" id="dpt">Engenharia de Segurança
            <input type="radio" value="comercial.sesmt@sesmt-rio.com" name="dpt" id="dpt">Comercial
			<input type="radio" value="adm@sesmt-rio.com" name="dpt" id="dpt">SAC
		</td>
	</tr>
	<tr>
		<td align="left" width="25%">Nome:</td>
		<td align="left"><input class="required" type="nome" name="nome" id="nome" size="30"></td>
        <!-- este campo não deverá ser preenchido, mas provavelmente os bots tentarão fazê-lo -->
        <input type="text" id="nao_humano" name="nome_fake" style="display: none;" />
	</tr>
	<tr>
		<td align="left" width="25%">E-mail:</td>
		<td align="left"><input class="required" type="email" name="email" id="email" size="30"></td>
	</tr>
	<tr>
		<td align="left" width="25%">Telefone:</td>
		<td align="left"><input class="required" type="tel" name="tel" id="tel" size="11" maxlength="14" OnKeyPress="fone(this);"></td>
	</tr>
	<tr>
		<td align="left" width="25%">Mensagem:</td>
		<td align="left"><textarea class="required" name="assunto" id="assunto" cols="40" rows="5"></textarea></td>
	</tr>
</table>
<p>

<table width="100%" border="0" cellpadding="2" cellspacing="2">	
	<tr>
		<td align="center"><input class="button" type="submit" name="agendamento" value="Enviar e-mail" /></td>
	</tr>
</table>
</div>
</form>

<!-- ATENDIMENTO -->
<div id="atend" style="display:none">
    <img src='images/sub-horario-atendimento.jpg' border=0>
    <BR>
	&nbsp;<b>Segunda à Quinta:</b>&nbsp;8:00 às 18:00 Horas
    <BR>
	&nbsp;<b>Sexta-Feira:</b>&nbsp;8:00 às 17:00 Horas
    <p>
    &nbsp;<b>Obs:</b>&nbsp;Na última sexta-feira de cada mês o funcionamento da empresa é de 8:00 às 12:00 horas.
    <p>
    <hr>
    <br>
    <img src='images/sub-atendimento-medico.jpg' border=0>
    <BR>
    &nbsp;<b>Segunda à Sexta:</b> 8:00 às 11:30 Horas
    <p>
    <hr>
    <br>
    <img src='images/sub-atendimento-laboratorio.jpg' border=0>
    <BR>
    &nbsp;<b>Segunda à Sexta:</b> 8:00 às 11:00 Horas
    <p>
    <hr>
    <br>
    <img src='images/sub-endereco.jpg' border=0><BR>
    &nbsp;Rua George Bizet, 92 esquina com a Rua franz Liszt
    <br>
    &nbsp;Jardim América - Rio de Janeiro RJ
    <br>
    <p>
    <hr>
    <br>
    <img src='images/sub-telefones.jpg' border=0>
    <BR>
    &nbsp;(21) 3014-4304 | (21) 97036-4932 | (21) 97003-1385
</div>
