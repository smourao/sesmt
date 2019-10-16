<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$fatura = $_GET['fatura'];
$dias = $_GET['dias'];

if(is_numeric($fatura)){
   $a = 0;
   $sql = "SELECT * FROM site_fatura_info WHERE cod_fatura = '{$fatura}'";
   $fatura_info = pg_fetch_array(pg_query($sql));
   
   $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$fatura}'";
   $result = pg_query($sql);
   $fatura_produto = pg_fetch_all($result);
   $pegarprodutonum = pg_num_rows($result);
   
   if($fatura_info[pc]){
       $sql = "SELECT * FROM cliente_pc WHERE cliente_id = '{$fatura_info['cod_cliente']}' AND contratante = 1";
       $cliente = pg_fetch_array(pg_query($sql));
   }else{
       $sql = "SELECT * FROM cliente WHERE cliente_id = '{$fatura_info['cod_cliente']}'";
       $cliente = pg_fetch_array(pg_query($sql));
   }
   
   $total = 0;
   for($x=0;$x<pg_num_rows($result);$x++){
      //
      $total += $fatura_produto[$x]['quantidade'] * $fatura_produto[$x]['valor'];
   }
   $multa = ($total * 3)/100;
   $juros = ($total * 0.29)/100;
   $base = $total;
   if($dias >= 5){
      $total+= $multa + ($juros*$dias);
   }
   
   if($fatura_info['novo_valor'] > 0){
	   
	   $total = $fatura_info['novo_valor'];
	   
   }
   
   $cod_cliente = $fatura_info['cod_cliente'];
   $ano_contrato = $cliente['ano_contrato'];
   $contrato = $ano_contrato.".".$cod_cliente;
   
   $descricao_produtos = '';
   
   for($j=0;$j<$pegarprodutonum;$j++){
		
		$descricao = $fatura_produto[$j]['descricao'];
		
		$descricao_produtos .= $descricao."<br><br>";
		
	}
   
$query_fatura_max = "SELECT max(id) as cod_fatura FROM financeiro_info";
	$result_fatura_max = pg_query($query_fatura_max);
	$row_fatura_max = pg_fetch_array($result_fatura_max);
	
	$cod_faturamax = $row_fatura_max[cod_fatura] + 1;
   

   $sql = "INSERT INTO financeiro_info
   (id, cod_cliente, pc, titulo, valor_total, n_parcelas, forma_pagamento, status, data, dia, mes, ano,
   data_lancamento, data_entrada_saida, tipo_lancamento, historico)
   VALUES
   ('{$cod_faturamax}','{$fatura_info[cod_cliente]}','{$fatura_info[pc]}',
   '{$fatura_info['cod_cliente']} - ".addslashes($cliente['razao_social'])."',
   '{$total}',
   '1',
   'Dinheiro',
   '0',
   '".date("Y/m/d")."',
   '".date("d")."',
   '".date("m")."',
   '".date("Y")."',
   '".date("Y/m/d")."',
   '".date("Y/m/d")."',
   '0',
   'Informações migradas pela planilha de resumo de fatura nº {$fatura} no dia ".date("d-m-Y").".<BR><b>Valor:</b> R$ ".number_format($base, 2,',','.')."<BR><b>Multa:</b> R$ ".number_format($multa, 2,',','.')."<BR><b>Juros:</b> R$ ".number_format($juros, 2,',','.')."<BR><b>Valor Total:</b> R$ ".number_format($total, 2,',','.')."')";

   if(pg_query($sql)){
      $a++;
   }
   
   
   $sql = "SELECT MAX(id) FROM financeiro_info WHERE valor_total = '$total'";
   $result = pg_query($sql);
   $max = pg_fetch_array($result);
   
   $sql2 = "SELECT MAX(id) FROM financeiro_fatura";
   $result2 = pg_query($sql2);
   $max2 = pg_fetch_array($result2);
   
   $novaseq = $max2[0] + 1;
   
   $sql0 = "SELECT setval('financeiro_fatura_id_seq', '$novaseq', FALSE)";
   $result0 = pg_query($sql0);

if($a > 0){
   for($x=0;$x<1;$x++){
      $sql = "INSERT INTO financeiro_fatura
      (cod_fatura, titulo, valor, parcela_atual, vencimento, status, pago, data_lancamento)
      VALUES
      ('{$max[0]}',
      '{$fatura_info['cod_cliente']} - ".addslashes($cliente['razao_social'])."',
      '".number_format($total, 2,'.','')."',
      '".($x+1)."',
      '".date("Y/m/d", strtotime($fatura_info['data_vencimento']))."',
      '0', 1, '".date("Y/m/d")."')";
      if(pg_query($sql)){
         $a++;
      }else{
         die('Erro ao adicionar informações no banco de dados![fatura]');
      }
   }
}

if($a>0){
   $sql = "UPDATE site_fatura_info SET migrado = 1, data_pagamento='".date("Y-m-d")."' WHERE cod_fatura = '{$fatura}'";
   pg_query($sql);
   echo "Planilha migrada com sucesso!|{$fatura}";
  
$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
               <HTML>
               <HEAD>
                  <TITLE> Confirmação de pagamento</TITLE>
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

<font face='verdana,arial,sans-serif'><center><h1>Confirmação de pagamento</h1></center></font><p><p><br><br><font face='verdana,arial,sans-serif' size='3'>Olá, <b>".$cliente['razao_social'].". </b><br> <br>

Informamos que o pagamento do boleto com vencimento em <b>".date("d/m/Y", strtotime($fatura_info['data_vencimento']))."</b>, no valor de <b>R$ ".number_format($total, 2,',','.').")</b>, foi confirmado.<br>
O boleto é referente ao(s) seguinte(s) produto(s):<br><br><br>
<b>".$descricao_produtos."</b><br><br>
Você pode acessar o detalhamento desse boleto através da Central do Cliente.<br>
Em caso de dúvidas, acesse a opções do cliente, no site <a href='https://www.sesmt-rio.com'>www.sesmt-rio.com</a> e veja sobre detalhamento de faturas, ou entre em contato em um de nossos canais de atendimento.</font>

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

   </BODY>
</HTML>  ";

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <financeiro@sesmt-rio.com> \n";

   mail($cliente[email], "Confirmação de pagamento", $msg, $headers);
   
}else{
   echo "";
}

}else{
   echo "";
}

?>
