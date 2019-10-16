
<?php



$cod_cliente = $_GET[cod_cliente];
if($_GET[cod_fatura]){
	
	$data_vencimento = $_POST['data_vencimento'];
}else{
		
	$dt 					= 	explode('/', $_POST['data_vencimento']);
	$data_vencimento		=	$dt[2]."-".$dt[1]."-".$dt[0];
		
}

$regclientesql = "SELECT email FROM cliente WHERE cliente_id = $cod_cliente";
$regclientequery = pg_query($regclientesql);
$regcliente = pg_fetch_array($regclientequery);

$email = $regcliente['email'];


$nomedata = date("Y.m.d-H.i.s").".pdf";

$mes = idate('m');

$data_lancamento = date('Y-m-d');

$pathToSave = "pdf/".$cod_cliente."/";

                 /*Checa se a pasta existe - caso negativo ele cria*/
                if(!file_exists($pathToSave))
                {
                    mkdir($pathToSave);
                }

if( $_FILES ) 
                { // Verificando se existe o envio de arquivos.

                    if( $_FILES['txtArquivo'] ) 
                    { // Verifica se o campo não está vazio.

                        $dir = $pathToSave; // Diretório que vai receber o arquivo.
						$variavelnova= $dir.$nomedata ;
						
                        $tmpName = $_FILES['txtArquivo']['tmp_name']; // Recebe o arquivo temporário.

                        $name = $_FILES['txtArquivo']['name']; // Recebe o nome do arquivo.

                        preg_match_all('/\.[a-zA-Z0-9]+/', $name , $extensao);
                        if(!in_array(strtolower(current(end($extensao))), array('.txt','.pdf', '.doc', '.xls','.xlms')))
                        {
                             echo ('Permitido apenas arquivos doc,xls,pdf e txt.');
                            header('Location: ?dir=cad_cliente&p=detalhe_cliente&cod_cliente=$_GET[cod_cliente]&sp=cliente_boleto');
                           die;

                        }


                        // move_uploaded_file( $arqTemporário, $nomeDoArquivo )
                        if( move_uploaded_file( $tmpName, $variavelnova ) ) 
                        { // move_uploaded_file irá realizar o envio do arquivo.
						
							$boleto = $variavelnova;
							
							if($data_vencimento == '--'){
						
								$sqlup = "INSERT INTO cliente_boleto (cod_cliente,boleto,mes,data_lancamento)
								VALUES ($cod_cliente,'$boleto',$mes,'$data_lancamento')";
							
							}else{
								
								$sqlup = "INSERT INTO cliente_boleto (cod_cliente,boleto,mes,data_lancamento,data_vencimento)
								VALUES ($cod_cliente,'$boleto',$mes,'$data_lancamento','$data_vencimento')";
								
							}
							
							$queryup = pg_query($sqlup);
							
							
							
							
							
							$emailboletosql = "SELECT * FROM cliente_boleto WHERE cod_cliente = $cod_cliente ORDER BY id DESC ";
							$emailboletoquery = pg_query($emailboletosql);
							$emailboleto = pg_fetch_array($emailboletoquery);
							$dirboleto = "http://sesmt-rio.com/erp/2.0/".$emailboleto[boleto];
							
							
							
							
							
					$headers = "MIME-Version: 1.0\n";
   					$headers .= "Content-type: text/html; charset=UTF-8\r\n";
    				$headers .= 'From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <financeiro@sesmt-rio.com> ' . "\n" .
    				'Bcc: ' . "\n" .
    				'X-Mailer: PHP/' . phpversion();
							
							
					$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
                    <HTML><HEAD><TITLE>SESMT: Boleto Digitalizado</TITLE><META http-equiv=Content-type: text/html; charset=UTF-8\"><META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
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
                    <BODY>";

                    $msg .= "
                    <table width=100% border=0 cellpadding=0 cellspacing=0>
                   	<tr>
                  	<td width=100% class=fontepreta12><span class=style15>
					<font face='verdana,arial,sans-serif'>
                    <center><h1><strong>CORREIO ON-LINE</strong></h1></center>
					</font>
                    <p></p>
					<p>
					<font face='verdana,arial,sans-serif' size='3'>
                    A SESMT tem como objetivo, melhorar cada vez mais a excelência dos atendimentos a nossa carteira de clientes.<BR> Devido a esta nossa iniciativa, estamos disponibilizando em nosso site: <a href='http://www.sesmt-rio.com'>www.sesmt-rio.com</a>, o seu boleto de pagamento, onde você pode<BR> acessar nosso site e visualizar seus boletos, baixar como download ou imprimi-los.</p>
                    <p>
                    O seu carteiro on-line chegou <a href='$dirboleto'>clique aqui</a> para visualizar o seu boleto de pagamento.</p>
					<p>
					Acesse no site e dirigindo-se ao ambiente 'Opções do cliente' logo no sétimo link: Seu boleto de pagamento,<BR> clique nele e abrirá a página com o documento ao lado direito o botão de editar 2ª via do boleto.</p>
					</font>
                    </td>
                    </tr>
                    </table>";

                    $msg .= "
                    </BODY></HTML>";
                    // --> SEND EMAIL TO REGISTERED USER ------------------------------------------------
                    if(mail($email, "SESMT: Boleto Digitalizado", $msg, $headers))
                        $error = 0;
                    else
                        $error = 8;
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
							
						        
                            echo ('Arquivo adicionado com sucesso.');        
							
							if($_GET[cod_fatura]){
								
								echo "<script> 
									setTimeout('window.close()',2000); 
									</script>";
								
							
							}else{
								echo "<script>
									window.history.go(-2);
									</script>";
							}
							 
                        } else 
                        {           
                            echo ('Erro ao adicionar arquivo.');            
                        }

                    }

                }
?>