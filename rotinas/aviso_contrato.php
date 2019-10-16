<?php

include('../common/includes/database.php');

$data_hoje = date('Y-m-d');

$pegarcontratosql = "SELECT c.ano_contrato, ci.cod_cliente, c.razao_social, c.email, ci.status, ci.data_criacao FROM site_gerar_contrato ci, cliente c WHERE c.cliente_id = ci.cod_cliente AND ci.status = 0 ORDER BY ci.data_criacao";

$pegarcontratoquery = pg_query($pegarcontratosql);

$pegarcontrato = pg_fetch_all($pegarcontratoquery);

$pegarcontratonum = pg_num_rows($pegarcontratoquery);

for($x=0;$x<$pegarcontratonum;$x++){

	$ano_contrato = $pegarcontrato[$x][ano_contrato];
	$email_cliente = $pegarcontrato[$x]['email'];
	$data_criacao = $pegarcontrato[$x]['data_criacao'];
	$razao_social = $pegarcontrato[$x]['razao_social'];
	
	$d = str_replace('-', '/', $data_criacao);
	$dia_envio = date('d/m/Y', strtotime($d));
	
	$email = $email_cliente."financeiro@sesmt-rio.com;comercial@sesmt-rio.com;suporte@ti-seg.com";
	
	$titulo = "SESMT: Comunicado sobre o reenvio do Contrato";
	
	
	$time_inicial = strtotime($data_criacao);
	$time_final = strtotime($data_hoje);
	
	$diferenca = $time_final - $time_inicial;
	
	$dias = (int)floor( $diferenca / (60 * 60 * 24));
	
	if(($dias % 7) == 0){
		
		$msg = "<!doctype html>
				<html>
				<head>
				<meta charset='utf-8'>
                  <title>Comunicado sobre o reenvio do Contrato</title>
               	</head>
               <body>
            <font face='verdana,arial,sans-serif'><center><h1>CORREIO ON-LINE</h1></center></font><p><p><font face='verdana,arial,sans-serif' size='3'>Prezado cliente <b>".$razao_social."</b>, aguardamos o envio do contrato de nº <b>".$ano_contrato."</b> enviado no dia <b>".$dia_envio."</b> devidamente assinado em suas página que constam o CNPJ de sua empresa e as demais folhas rubricada com firma reconhecida, esse procedimento é importante para ativação do seu cadastro como cliente em nosso sistema.<br>
Isto facilitara o seu acesso, dando a facilidade de agendar ASO dos seus colaboradores, visitas técnicas, aprovar orçamentos, visualizar seus relatórios técnicos a distância sem ter que estar no seu escritório e se a sua empresa presta serviço a uma outra empresa como um posto de trabalho e essa exige cópia dos seus programa basta criar uma senha de acesso e enviar para quantos postos de trabalho tiver que eles terão acesso a visualização dos relatórios técnicos sem ter que ficar tirando cópias e autenticando as paginas para enviar ao seu cliente.<br><br>

O não envio do contrato assinado manterá o seus cadastro em nosso sistema apenas como cliente avulso onde serão praticado a cobrança de cliente avulso e não de contrato garantindo não só as comodidades que o sistema lhe oferece de acesso como os preços diferenciados para um cliente de contrato.</font>
               </body>
            </html>";
	
	
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; utf-8\n";
		$headers .= "From: SESMT - Seguranca do Trabalho e Higiene Ocupacional. <comercial@sesmt-rio.com> " . "\n" . "X-Mailer: PHP/" . phpversion();
					

		if(mail($email, $titulo, $msg, $headers)){
		
			echo "ok";
		}
	
	
		
	}
	
	
}


?>