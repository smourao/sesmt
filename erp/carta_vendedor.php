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
		alert("Voc� n�o tem permiss�o para acessar aqui!");
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
			Servi�os Especializados de Seguran�a e<br>
			Monitoramento de Atividades no Trabalho<p>
			Assist�ncia em Seguran�a e Higiene no Trabalho
			</td>
		</tr>
	</table>

  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
		<td align="justify" class="fontepreta12"><div align="justify" class="fontepreta12">
		&nbsp;&nbsp;&nbsp;Ol�! Esse � nosso primeiro contato, mas n�o podiamos deixar de dividir essa novidade com voc�.<br>
		&nbsp;&nbsp;&nbsp;A SESMT empresa de Consultoria em Seguran�a e Higiene Ocupacional, esta disponibilizando em seu site uma s�rie de oportunidades de pesquisas que v�o desde: Obrigatoriedade de ter a CIPA ou n�o; Quando uma empresa precisa ter em sua folha de pagamento um M�dico do Trabalho, Engenheiro do Trabalho, Enfermeiro do Trabalho, T�cnico de Seguran�a do Trabalho e ou Auxiliar de Enfermagem do Trabalho; Calend�rio com as obriga��es de datas da constitui��o da CIPA; Modelo de requerimento de registro da CIPA; Efetivo de Brigada de Inc�ndio; Modelo de ATA de Instala��o e Posse da CIPA; Modelo de Protocolo de entrega de PPP Perfil Profissiogr�fico Previd�nciario; Pesquisa de quando uma empresa deve manter um ambulat�rio M�dico pr�prio, Jogos educativos de Preven��o de Acidentes e Doen�as Ocupacionais.<br />
		&nbsp;&nbsp;&nbsp;Todas as nossas ferramentas de pesquisas s�o ofertadas sem custo algum, apenas voc� nosso convidado precisa efetuar um cadastro para gerar seu login e senha de acesso.<br />
		&nbsp;&nbsp;&nbsp;Como fazer isso? Clique em "Pesquisa" e escolha uma op��o, abrir� uma caixa de di�logo para voc� digitar login e senha, caso n�o seja cadastrado, clique no link cadastre-se, em seguida ser� exibido um termo de responsabilidade de uso que ap�s lido e aceito redirecionar� a uma tela da cadastro onde voc� preencher� suas informa��es sem nenhum custo adicional, n�o esquecendo de cadastrar nele o c�digo chave <b><?php echo $row[cod_vendedor]; ?></b>.<br />
		&nbsp;&nbsp;&nbsp;Uma vez enviado seu cadastro voc� receber� uma mensagem de boas vindas e ai � s� come�ar a desfrutar de tudo o que a SESMT tem para lhe oferecer de comodidade, conecte-se agora: <b>www-sesmt-rio.com</b>
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