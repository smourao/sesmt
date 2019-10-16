<?php

include('../common/includes/database.php');

$data_hoje = date('Y-m-d');

$data_antesontem = date('Y-m-d', strtotime('-2 days', strtotime($data_hoje)));
$data_antesontem_barra = date('d/m/Y', strtotime('-2 days', strtotime($data_hoje)));

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
		
		$descricao_produtos .= $descricao." ".$contrato."<br><br>";
		
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
            <font face='verdana,arial,sans-serif'><center><h1>CORREIO ON-LINE</h1></center></font><p><p><br><br><font face='verdana,arial,sans-serif' size='3'>Olá, <b>".$razao_social.". </b><br> <br>

Informamos que o seu pagamento do boleto esta programado para ocorrer em <b>".$data_antesontem_barra."</b>, no valor de <b>R$ ".$valor_formatado."</b>.<br>
O boleto é referente a fatura nº ".$cod_fatura."/".$ano_criacao." constantes ao(s) seguinte(s) produto(s):<br><br><br>
<b>".$descricao_produtos."</b><br><br>
Você pode acessar o detalhamento desse boleto através da Central do Cliente.<br>
Em caso de dúvidas, acesse a opções do cliente, no site <a href='https://www.sesmt-rio.com'>www.sesmt-rio.com</a> e veja sobre detalhamento de faturas, ou entre em contato em um de nossos canais de atendimento.<br>
Evite pagar com atraso e gerar encargos com multas, correções monetárias, bloqueio da sua senha de acesso e consequentemente suspensão dos serviços e protestos.</font>
               </body>
</html>";

	
	
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=charset=iso-8859-1\n";
		$headers .= "From: SESMT - Seguranca do Trabalho e Higiene Ocupacional. <financeiro@sesmt-rio.com> " . "\n" . "X-Mailer: PHP/" . phpversion();
					

		if(mail($email, $titulo, $msg, $headers)){
		
			echo "ok";
		}
	
	
		
	}
	
	


?>