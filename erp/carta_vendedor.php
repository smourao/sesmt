<?php
include "sessao.php";
include "config/connect.php";

$funcionario = $_SESSION['usuario_id'];

	$query_razao = "select *
					from funcionario
					WHERE funcionario_id = $funcionario";
	
	$result = pg_query($connect, $query_razao);
	$row = pg_fetch_array($result);

if($row[grupo_id] == "2" || $row[grupo_id] == "7" || $row[grupo_id] == "1"){

}else{
	echo '<script>
		alert("Você não tem permissão para acessar aqui!");
		location.href="tela_principal.php";
		</script>';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ERP - SESMT</title>
<link href="css_js/css.css" rel="stylesheet" type="text/css" />
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#FFFFFF" >
<br />
<form id="form1" name="form1" method="post" action="">
	<table align="center" width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    	<tr>
			<td align="left" valign="top" width="305"><img src="./img/logo_sesmt.png" width="300" height="155"></td>
			<td align="center" width="290" valign="top" class="fontepreta12">
			Serviços Especializados de Segurança e<br>
			Monitoramento de Atividades no Trabalho<p>
			Assistência em Segurança e Higiene no Trabalho
			</td>
		</tr>
	</table>

  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
		<td align="justify" class="fontepreta12"><div align="justify" class="fontepreta12">
		&nbsp;&nbsp;&nbsp;Olá! Esse é nosso primeiro contato, mas não podiamos deixar de dividir essa novidade com você.<br>
		&nbsp;&nbsp;&nbsp;A SESMT empresa de Consultoria em Segurança e Higiene Ocupacional, esta disponibilizando em seu site uma série de oportunidades de pesquisas que vão desde: Obrigatoriedade de ter a CIPA ou não; Quando uma empresa precisa ter em sua folha de pagamento um Médico do Trabalho, Engenheiro do Trabalho, Enfermeiro do Trabalho, Técnico de Segurança do Trabalho e ou Auxiliar de Enfermagem do Trabalho; Calendário com as obrigações de datas da constituição da CIPA; Modelo de requerimento de registro da CIPA; Efetivo de Brigada de Incêndio; Modelo de ATA de Instalação e Posse da CIPA; Modelo de Protocolo de entrega de PPP Perfil Profissiográfico Previdênciario; Pesquisa de quando uma empresa deve manter um ambulatório Médico próprio, Jogos educativos de Prevenção de Acidentes e Doenças Ocupacionais.<br />
		&nbsp;&nbsp;&nbsp;Todas as nossas ferramentas de pesquisas são ofertadas sem custo algum, apenas você nosso convidado precisa efetuar um cadastro para gerar seu login e senha de acesso.<br />
		&nbsp;&nbsp;&nbsp;Como fazer isso? Clique em "Pesquisa" e escolha uma opção, abrirá uma caixa de diálogo para você digitar login e senha, caso não seja cadastrado, clique no link cadastre-se, em seguida será exibido um termo de responsabilidade de uso que após lido e aceito redirecionará a uma tela da cadastro onde você preencherá suas informações sem nenhum custo adicional, não esquecendo de cadastrar nele o código chave <b><?php echo $row[cod_vendedor]; ?></b>.<br />
		&nbsp;&nbsp;&nbsp;Uma vez enviado seu cadastro você receberá uma mensagem de boas vindas e ai é só começar a desfrutar de tudo o que a SESMT tem para lhe oferecer de comodidade, conecte-se agora: <b>www-sesmt-rio.com</b>
		</div></td>
    </tr>
  </table>
  	<table align="center" width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
    	<tr>
			<td align="left" width="390" class="fontepreta12"><br /><br /><br><br><br>
				Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>
				Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>
				faleprimeirocomagente@sesmt-rio.com / juridico@sesmt-rio.com<br>
				www.sesmt-rio.com / www.shoppingsesmt.com 
			</td>
			<td align="right" valign="bottom" width="210"><img src="./img/logo_sesmt2.png" width="207" height="135"></td>
		</tr>
	</table>
</form>
</body>
</html>