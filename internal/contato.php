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
    $msg .= "Solicita��o de Contato<br>";
    $msg .= "Assunto: {$_POST[escolha]}<br>";
    $msg .= "Nome: {$_POST[nome]}<br>";
    $msg .= "E-mail: {$_POST[email]}<br>";
    $msg .= "Telefone: {$_POST[tel]}<br>";
    $msg .= "Mensagem: {$_POST[assunto]}<br>";
    $msg .= "</body></html>";
    
    $sbj = "Solicita��o de Contato";
    $name = "SESMT";
    $email = "sesmt@sesmt-rio.com";
    $headers  = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= "From: SESMT - Seguran�a do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";
    if($_POST['nome_fake'] == ''){ //VERIFICADOR DE SPAM
        if(mail($_POST[dpt], $sbj, $msg, $headers)){
            echo "<script>alert('Solicita��o enviada com sucesso!');</script>";
        }else{
            echo "<script>alert('Erro ao enviar solicita��o!');</script>";
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
	$msg2 .= "estamos recebemos sua solicita��o de atendimento.<br>";
    $msg2 .= "E nossos programadores j� est�o interagindo com a ferramenta para a corre��o nosso tempo estimado e de 72 horas no m�ximo para responderemos a sua solicita��o.<br>";
    $msg2 .= "</body></html>";
    
    $sbj2 = "Solicita��o de Contato";
    $name2 = "SESMT";
    $email2 = "sesmt@sesmt-rio.com";
    $headers2  = "MIME-Version: 1.0\n";
    $headers2 .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers2 .= "From: SESMT - Seguran�a do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";
    if(mail($email_cliente, $sbj2, $msg2, $headers2)){
        
    }else{
        echo "<script>alert('Erro ao enviar solicita��o!');</script>";
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
		<td align="left"><br>Todos os campos s�o de preenchimento obrigat�rio.</td>
	</tr>
</table>
<p>

<table width="100%" border="0" cellpadding="2" cellspacing="2">	
	<tr>
		<td align="left" width="25%">Escolha o Assunto:</td>
		<td align=left>
			<select class="required" name="escolha" id="escolha">
			<option value=""></option>
			<option value="D�vidas Comerciais">D�vidas Comerciais</option>
			<option value="Cr�ticas">Cr�ticas</option>
			<option value="Elogios">Elogios</option>
			<option value="Sugest�es">Sugest�es</option>
			</select>
		</td>
	</tr>
	<tr>
		<td align="left" width="25%">Departamento:</td>
	 	<td align=left>
			<input type="radio" value="financeiro@sesmt-rio.com" name="dpt" id="dpt">Financeiro
			<input type="radio" value="medicotrab@sesmt-rio.com" name="dpt" id="dpt">Sa�de Ocupacional
			<input type="radio" value="suporte@ti-seg.com" name="dpt" id="dpt">Chamado Acesso Internet
			<input type="radio" value="segtrab@sesmt-rio.com" name="dpt" id="dpt">Engenharia de Seguran�a
            <input type="radio" value="comercial.sesmt@sesmt-rio.com" name="dpt" id="dpt">Comercial
			<input type="radio" value="adm@sesmt-rio.com" name="dpt" id="dpt">SAC
		</td>
	</tr>
	<tr>
		<td align="left" width="25%">Nome:</td>
		<td align="left"><input class="required" type="nome" name="nome" id="nome" size="30"></td>
        <!-- este campo n�o dever� ser preenchido, mas provavelmente os bots tentar�o faz�-lo -->
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
	&nbsp;<b>Segunda � Quinta:</b>&nbsp;8:00 �s 18:00 Horas
    <BR>
	&nbsp;<b>Sexta-Feira:</b>&nbsp;8:00 �s 17:00 Horas
    <p>
    &nbsp;<b>Obs:</b>&nbsp;Na �ltima sexta-feira de cada m�s o funcionamento da empresa � de 8:00 �s 12:00 horas.
    <p>
    <hr>
    <br>
    <img src='images/sub-atendimento-medico.jpg' border=0>
    <BR>
    &nbsp;<b>Segunda � Sexta:</b> 8:00 �s 11:30 Horas
    <p>
    <hr>
    <br>
    <img src='images/sub-atendimento-laboratorio.jpg' border=0>
    <BR>
    &nbsp;<b>Segunda � Sexta:</b> 8:00 �s 11:00 Horas
    <p>
    <hr>
    <br>
    <img src='images/sub-endereco.jpg' border=0><BR>
    &nbsp;Rua George Bizet, 92 esquina com a Rua franz Liszt
    <br>
    &nbsp;Jardim Am�rica - Rio de Janeiro RJ
    <br>
    <p>
    <hr>
    <br>
    <img src='images/sub-telefones.jpg' border=0>
    <BR>
    &nbsp;(21) 3014-4304 | (21) 97036-4932 | (21) 97003-1385
</div>
