<?php

include('../common/includes/database.php');

$data_hoje = date('Y-m-d');

$data_antesontem = date('Y-m-d', strtotime('+2 days', strtotime($data_hoje)));
$data_antesontem_barra = date('d/m/Y', strtotime('+2 days', strtotime($data_hoje)));

$pegarfaturasql = "SELECT cod_cliente, cod_fatura, data_criacao FROM site_fatura_info WHERE data_vencimento = '".$data_antesontem."' AND migrado = 0 ";

$pegarfaturaquery = pg_query($pegarfaturasql);

$pegarfatura = pg_fetch_all($pegarfaturaquery);

$pegarfaturanum = pg_num_rows($pegarfaturaquery);

for($x=0;$x<$pegarfaturanum;$x++){

	$cod_cliente = $pegarfatura[$x][cod_cliente];
	$cod_fatura = $pegarfatura[$x][cod_fatura];
	$data_criacao = $pegarfatura[$x]['data_criacao'];
	$ano_criacao = date('Y', strtotime($data_criacao));
	
	$pegarclientesql = "SELECT razao_social, ano_contrato, email FROM cliente WHERE cliente_id = ".$cod_cliente."";

	$pegarclientequery = pg_query($pegarclientesql);

	$pegarcliente = pg_fetch_array($pegarclientequery);
	
	$razao_social = $pegarcliente['razao_social'];
	$ano_contrato = $pegarcliente['ano_contrato'];
	$email_cliente = $pegarcliente['email'];
	$contrato = $ano_contrato.".".$cod_cliente;
	
	
	$email = $email_cliente.";financeiro@sesmt-rio.com;suporte@ti-seg.com";
	
	$titulo = "SESMT: Comunicado sobre o vencimento da Fatura";
	
	
	
	$pegarprodutosql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = ".$cod_fatura." ORDER BY id";
	
	$pegarprodutoquery = pg_query($pegarprodutosql);

	$pegarproduto = pg_fetch_all($pegarprodutoquery);

	$pegarprodutonum = pg_num_rows($pegarprodutoquery);
	
	$preco = 0;
	$descricao_produtos = '';
	
	for($j=0;$j<$pegarprodutonum;$j++){
		
		$valor = $pegarproduto[$j][valor];
		$quantidade = $pegarproduto[$j][quantidade];
		$descricao = $pegarproduto[$j]['descricao'];
		
		$valortotal = $valor * $quantidade;
		
		$preco += $valortotal;
		
		$descricao_produtos .= $descricao."<br><br>";
		
	}
		$valor_formatado = number_format($preco, 2, ',', '.');
	
	
		
		$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
               <HTML>
               <HEAD>
                  <TITLE>Comunicado sobre o vencimento da Fatura</TITLE>
            <META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
            <META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
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
			   
			   
			   <table width=100% border=0>
        <tr>
        <td align='left'>
            <p><strong>
            <font size='7' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=3>®</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>
			 <td width=40% align='right'>
            <font face='Verdana, Arial, Helvetica, sans-serif' size='4'>
            <b>&nbsp;</b>
            </td>
       
        </tr>
        </table>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
			   
			   
            <font face='verdana,arial,sans-serif'><center><h1>Notificação de pagamento</h1></center></font><p><p><br><br><font face='verdana,arial,sans-serif' size='3'>Olá, <b>".$razao_social.". </b><br> <br>

Informamos que o seu pagamento do boleto esta programado para ocorrer em <b>".$data_antesontem_barra."</b>, no valor de <b>R$ ".$valor_formatado."</b>.<br>
O boleto é referente a fatura nº ".$cod_fatura."/".$ano_criacao." constantes ao(s) seguinte(s) produto(s):<br><br><br>
<b>".$descricao_produtos."</b><br><br>
Você pode acessar o detalhamento desse boleto através da Central do Cliente.<br>
Em caso de dúvidas, acesse a opções do cliente, no site <a href='https://www.sesmt-rio.com'>www.sesmt-rio.com</a> e veja sobre detalhamento de faturas, ou entre em contato em um de nossos canais de atendimento.<br>
Evite pagar com atraso e gerar encargos com multas, correções monetárias, bloqueio da sua senha de acesso e consequentemente suspensão dos serviços e protestos.</font>

		<br>
		<br>
		<br>
		<br>

Atenciosamente,<br>
<b>SESMT Serviços Especializados de Segurança e Monitoramento de Atividades no Trabalho.</b><br>

		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>


		<table width=100% border=0>
        <tr>
        <td align=left width=88%><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9700 31385 - Id 55*23*31641</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=12%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
       </tr>
        </table>





               </body>
</html>";

	
	
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=charset=iso-8859-1\n";
		$headers .= "From: SESMT - Seguranca do Trabalho e Higiene Ocupacional. <financeiro@sesmt-rio.com> " . "\n" . "X-Mailer: PHP/" . phpversion();
					

		if(mail($email, $titulo, $msg, $headers)){
		
			echo "ok";
		}
	
	
		
	}
	
	

////////////////// 1 DIA ////////////////





$data_amanha = date('Y-m-d', strtotime('-1 days', strtotime($data_hoje)));
$data_amanha_barra = date('d/m/Y', strtotime('-1 days', strtotime($data_hoje)));



$faturaatrasaosql = "SELECT cod_cliente, cod_fatura, data_criacao FROM site_fatura_info WHERE data_vencimento = '".$data_amanha."' AND migrado = 0";

$faturaatrasaoquery = pg_query($faturaatrasaosql);

$faturaatrasao = pg_fetch_all($faturaatrasaoquery);

$faturaatrasaonum = pg_num_rows($faturaatrasaoquery);






for($x=0;$x<$faturaatrasaonum;$x++){

	$cod_cliente = $faturaatrasao[$x][cod_cliente];
	$cod_fatura = $faturaatrasao[$x][cod_fatura];
	$data_criacao = $faturaatrasao[$x]['data_criacao'];
	$ano_criacao = date('Y', strtotime($data_criacao));
	
	$pegarclientesql = "SELECT razao_social, ano_contrato, email FROM cliente WHERE cliente_id = ".$cod_cliente."";

	$pegarclientequery = pg_query($pegarclientesql);

	$pegarcliente = pg_fetch_array($pegarclientequery);
	
	$razao_social = $pegarcliente['razao_social'];
	$ano_contrato = $pegarcliente['ano_contrato'];
	$email_cliente = $pegarcliente['email'];
	$contrato = $ano_contrato.".".$cod_cliente;
	
	
	$email = $email_cliente.";financeiro@sesmt-rio.com;suporte@ti-seg.com";
	
	$titulo = "SESMT: Comunicado sobre o vencimento da Fatura";
	
	
	
	$pegarprodutosql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = ".$cod_fatura." ORDER BY id";
	
	$pegarprodutoquery = pg_query($pegarprodutosql);

	$pegarproduto = pg_fetch_all($pegarprodutoquery);

	$pegarprodutonum = pg_num_rows($pegarprodutoquery);
	
	$preco = 0;
	$descricao_produtos = '';
	
	for($j=0;$j<$pegarprodutonum;$j++){
		
		$valor = $pegarproduto[$j][valor];
		$quantidade = $pegarproduto[$j][quantidade];
		$descricao = $pegarproduto[$j]['descricao'];
		
		$valortotal = $valor * $quantidade;
		
		$preco += $valortotal;
		
		$descricao_produtos .= $descricao."<br><br>";
		
	}
		$valor_formatado = number_format($preco, 2, ',', '.');
	
	
		
		$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
               <HTML>
               <HEAD>
                  <TITLE>Comunicado sobre o vencimento da Fatura</TITLE>
            <META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
            <META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
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
			   
			   <table width=100% border=0>
        <tr>
        <td align='left'>
            <p><strong>
            <font size='7' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=3>®</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>
			 <td width=40% align='right'>
            <font face='Verdana, Arial, Helvetica, sans-serif' size='4'>
            <b>&nbsp;</b>
            </td>
       
        </tr>
        </table>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
			   
			   
            <font face='verdana,arial,sans-serif'><center><h1>Notificação de pagamento</h1></center></font><p><p><br><br><font face='verdana,arial,sans-serif' size='3'>Olá, <b>".$razao_social.". </b><br> <br>

Informamos que ainda não contabilizamos o pagamento do boleto com vencimento em <b>".$data_amanha_barra."</b>, no valor de <b>R$ ".$valor_formatado."</b>.<br>
O boleto é referente a fatura nº ".$cod_fatura."/".$ano_criacao." constantes ao(s) seguinte(s) produto(s):<br><br><br>
<b>".$descricao_produtos."</b><br><br>
Você pode acessar o detalhamento desse boleto através da Central do Cliente.<br>
Em caso de dúvidas, acesse a opções do cliente, no site <a href='https://www.sesmt-rio.com'>www.sesmt-rio.com</a> e veja sobre detalhamento de faturas, ou entre em contato em um de nossos canais de atendimento.<br>
Evite a suspensão dos seus serviços e o bloqueio de sua senha de acesso.<br>
Caso seu boleto já tenha sido pago queira desconsiderar este aviso.</font>


<br>
		<br>
		<br>
		<br>

Atenciosamente,<br>
<b>SESMT Serviços Especializados de Segurança e Monitoramento de Atividades no Trabalho.</b><br>

		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>


		<table width=100% border=0>
        <tr>
        <td align=left width=88%><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9700 31385 - Id 55*23*31641</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=12%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
       </tr>
        </table>



               </body>
</html>";

	
	
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=charset=iso-8859-1\n";
		$headers .= "From: SESMT - Seguranca do Trabalho e Higiene Ocupacional. <financeiro@sesmt-rio.com> " . "\n" . "X-Mailer: PHP/" . phpversion();
					

		if(mail($email, $titulo, $msg, $headers)){
		
			echo "ok";
		}
	
	
		
	}
	
	
	
////////////////// 5 DIA ////////////////





$data_cinco = date('Y-m-d', strtotime('-5 days', strtotime($data_hoje)));
$data_cinco_barra = date('d/m/Y', strtotime('-5 days', strtotime($data_hoje)));



$faturaatrasaosql = "SELECT cod_cliente, cod_fatura, data_criacao FROM site_fatura_info WHERE data_vencimento = '".$data_cinco."' AND migrado = 0";

$faturaatrasaoquery = pg_query($faturaatrasaosql);

$faturaatrasao = pg_fetch_all($faturaatrasaoquery);

$faturaatrasaonum = pg_num_rows($faturaatrasaoquery);






for($x=0;$x<$faturaatrasaonum;$x++){

	$cod_cliente = $faturaatrasao[$x][cod_cliente];
	$cod_fatura = $faturaatrasao[$x][cod_fatura];
	$data_criacao = $faturaatrasao[$x]['data_criacao'];
	$ano_criacao = date('Y', strtotime($data_criacao));
	
	$pegarclientesql = "SELECT razao_social, ano_contrato, email FROM cliente WHERE cliente_id = ".$cod_cliente."";

	$pegarclientequery = pg_query($pegarclientesql);

	$pegarcliente = pg_fetch_array($pegarclientequery);
	
	$razao_social = $pegarcliente['razao_social'];
	$ano_contrato = $pegarcliente['ano_contrato'];
	$email_cliente = $pegarcliente['email'];
	$contrato = $ano_contrato.".".$cod_cliente;
	
	
	$email = $email_cliente.";financeiro@sesmt-rio.com;suporte@ti-seg.com";
	
	$titulo = "SESMT: Comunicado sobre o vencimento da Fatura";
	
	
	
	$pegarprodutosql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = ".$cod_fatura." ORDER BY id";
	
	$pegarprodutoquery = pg_query($pegarprodutosql);

	$pegarproduto = pg_fetch_all($pegarprodutoquery);

	$pegarprodutonum = pg_num_rows($pegarprodutoquery);
	
	$preco = 0;
	$descricao_produtos = '';
	
	for($j=0;$j<$pegarprodutonum;$j++){
		
		$valor = $pegarproduto[$j][valor];
		$quantidade = $pegarproduto[$j][quantidade];
		$descricao = $pegarproduto[$j]['descricao'];
		
		$valortotal = $valor * $quantidade;
		
		$preco += $valortotal;
		
		$descricao_produtos .= $descricao."<br><br>";
		
	}
		$valor_formatado = number_format($preco, 2, ',', '.');
	
	
		
		$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
               <HTML>
               <HEAD>
                  <TITLE>Comunicado sobre o vencimento da Fatura</TITLE>
            <META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
            <META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
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
			   
			   
			   <table width=100% border=0>
        <tr>
        <td align='left'>
            <p><strong>
            <font size='7' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=3>®</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>
			 <td width=40% align='right'>
            <font face='Verdana, Arial, Helvetica, sans-serif' size='4'>
            <b>&nbsp;</b>
            </td>
       
        </tr>
        </table>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
			   
			   
			   
            <font face='verdana,arial,sans-serif'><center><h1>Notificação de pagamento</h1></center></font><p><p><br><br><font face='verdana,arial,sans-serif' size='3'>Olá, <b>".$razao_social.". </b><br> <br>

Informamos que ainda não contabilizamos o pagamento do boleto com vencimento em <b>".$data_cinco_barra."</b>, no valor de <b>R$ ".$valor_formatado."</b>.<br>
O boleto é referente a fatura nº ".$cod_fatura."/".$ano_criacao." constantes ao(s) seguinte(s) produto(s):<br><br><br>
<b>".$descricao_produtos."</b><br><br>
Você pode acessar o detalhamento desse boleto através da Central do Cliente.<br>
Em caso de dúvidas, acesse a opções do cliente, no site <a href='https://www.sesmt-rio.com'>www.sesmt-rio.com</a> e veja sobre detalhamento de faturas, ou entre em contato em um de nossos canais de atendimento.<br>
Evite a suspensão dos seus serviços e o bloqueio de sua senha de acesso.<br>
Caso seu boleto já tenha sido pago queira desconsiderar este aviso.</font>

<br>
		<br>
		<br>
		<br>

Atenciosamente,<br>
<b>SESMT Serviços Especializados de Segurança e Monitoramento de Atividades no Trabalho.</b><br>

		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>


		<table width=100% border=0>
        <tr>
        <td align=left width=88%><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9700 31385 - Id 55*23*31641</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=12%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
       </tr>
        </table>



               </body>
</html>";

	
	
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=charset=iso-8859-1\n";
		$headers .= "From: SESMT - Seguranca do Trabalho e Higiene Ocupacional. <financeiro@sesmt-rio.com> " . "\n" . "X-Mailer: PHP/" . phpversion();
					

		if(mail($email, $titulo, $msg, $headers)){
		
			echo "ok";
		}
	
	
		
	}
	
	
	
	

////////////////// 15 DIA ////////////////





$data_quinze = date('Y-m-d', strtotime('-15 days', strtotime($data_hoje)));
$data_quinze_barra = date('d/m/Y', strtotime('-15 days', strtotime($data_hoje)));



$faturaatrasaosql = "SELECT cod_cliente, cod_fatura, data_criacao FROM site_fatura_info WHERE data_vencimento = '".$data_quinze."' AND migrado = 0";

$faturaatrasaoquery = pg_query($faturaatrasaosql);

$faturaatrasao = pg_fetch_all($faturaatrasaoquery);

$faturaatrasaonum = pg_num_rows($faturaatrasaoquery);






for($x=0;$x<$faturaatrasaonum;$x++){

	$cod_cliente = $faturaatrasao[$x][cod_cliente];
	$cod_fatura = $faturaatrasao[$x][cod_fatura];
	$data_criacao = $faturaatrasao[$x]['data_criacao'];
	$ano_criacao = date('Y', strtotime($data_criacao));
	
	$pegarclientesql = "SELECT razao_social, ano_contrato, email FROM cliente WHERE cliente_id = ".$cod_cliente."";

	$pegarclientequery = pg_query($pegarclientesql);

	$pegarcliente = pg_fetch_array($pegarclientequery);
	
	$razao_social = $pegarcliente['razao_social'];
	$ano_contrato = $pegarcliente['ano_contrato'];
	$email_cliente = $pegarcliente['email'];
	$contrato = $ano_contrato.".".$cod_cliente;
	
	
	$email = $email_cliente.";financeiro@sesmt-rio.com;suporte@ti-seg.com";
	
	$titulo = "SESMT: Comunicado sobre o vencimento da Fatura";
	
	
	
	$pegarprodutosql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = ".$cod_fatura." ORDER BY id";
	
	$pegarprodutoquery = pg_query($pegarprodutosql);

	$pegarproduto = pg_fetch_all($pegarprodutoquery);

	$pegarprodutonum = pg_num_rows($pegarprodutoquery);
	
	$preco = 0;
	$descricao_produtos = '';
	
	for($j=0;$j<$pegarprodutonum;$j++){
		
		$valor = $pegarproduto[$j][valor];
		$quantidade = $pegarproduto[$j][quantidade];
		$descricao = $pegarproduto[$j]['descricao'];
		
		$valortotal = $valor * $quantidade;
		
		$preco += $valortotal;
		
		$descricao_produtos .= $descricao."<br><br>";
		
	}
		$valor_formatado = number_format($preco, 2, ',', '.');
	
	
		
		$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
               <HTML>
               <HEAD>
                  <TITLE>Comunicado sobre o vencimento da Fatura</TITLE>
            <META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
            <META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
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
			   
			   
			   <table width=100% border=0>
        <tr>
        <td align='left'>
            <p><strong>
            <font size='7' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=3>®</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>
			 <td width=40% align='right'>
            <font face='Verdana, Arial, Helvetica, sans-serif' size='4'>
            <b>&nbsp;</b>
            </td>
       
        </tr>
        </table>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
			   
			   
            <font face='verdana,arial,sans-serif'><center><h1>Notificação de pagamento</h1></center></font><p><p><br><br><font face='verdana,arial,sans-serif' size='3'>Olá, <b>".$razao_social.". </b><br> <br>

Informamos que ainda não contabilizamos o pagamento do boleto com vencimento em <b>".$data_quinze_barra."</b>, no valor de <b>R$ ".$valor_formatado."</b>.<br>
O boleto é referente a fatura nº ".$cod_fatura."/".$ano_criacao." constantes ao(s) seguinte(s) produto(s):<br><br><br>
<b>".$descricao_produtos."</b><br><br>
Você pode acessar o detalhamento desse boleto através da Central do Cliente.<br>
Em caso de dúvidas, acesse a opções do cliente, no site <a href='https://www.sesmt-rio.com'>www.sesmt-rio.com</a> e veja sobre detalhamento de faturas, ou entre em contato em um de nossos canais de atendimento.<br>
Evite a suspensão dos seus serviços e o bloqueio de sua senha de acesso.<br>
Caso seu boleto já tenha sido pago queira desconsiderar este aviso.</font>


<br>
		<br>
		<br>
		<br>

Atenciosamente,<br>
<b>SESMT Serviços Especializados de Segurança e Monitoramento de Atividades no Trabalho.</b><br>

		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>


		<table width=100% border=0>
        <tr>
        <td align=left width=88%><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9700 31385 - Id 55*23*31641</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=12%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
       </tr>
        </table>


               </body>
</html>";

	
	
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=charset=iso-8859-1\n";
		$headers .= "From: SESMT - Seguranca do Trabalho e Higiene Ocupacional. <financeiro@sesmt-rio.com> " . "\n" . "X-Mailer: PHP/" . phpversion();
					

		if(mail($email, $titulo, $msg, $headers)){
		
			echo "ok";
		}
	
	
		
	}






exit;



?>