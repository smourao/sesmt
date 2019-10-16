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
   

   $sql = "INSERT INTO financeiro_info
   (cod_cliente, pc, titulo, valor_total, n_parcelas, forma_pagamento, status, data, dia, mes, ano,
   data_lancamento, data_entrada_saida, tipo_lancamento, historico)
   VALUES
   ('{$fatura_info[cod_cliente]}','{$fatura_info[pc]}',
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
      <TITLE>Cobrança de Fatura em Inadimplência</TITLE>
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
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=0 cellspacing=0>
	<tr>
		<td align=left><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width=\"333\" height=\"180\" /></td>
		<td align=\"left\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\"><span class=style18>Serviços Especializados de Segurança e <br>
		  Monitoramento de Atividades no Trabalho ltda.</span>
		  </font><br><br>
		  <p class=\"style18\">
		  <p class=\"style18\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\">Segurança do Trabalho e Higiene Ocupacional.</font><br><br><br><br>
		  <p>
</td>
	</tr>
</table></div>
<p>
<br>
<center><b>
<span style='background: #008000; color: #FFFFFF;'>
FCF - Ficha de Compensação de Fatura Nº ".STR_PAD($fatura, 4, '0', STR_PAD_LEFT)."/".date("Y", strtotime($fatura_info['data_vencimento']))."</span></b></center>
<p>
<center>
************************************************<br>
Mensagem Automática: Por favor, não responder   <br>
************************************************<br>
<p>
<br>
<!--
   <center><b>".$cliente['razao_social']."</b></center>
</center>
<br><p>
-->
<br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"70%\" align=\"center\" class=\"fontepreta12\"><br />
		  <span class=\"style2 fontepreta12\" style=\"font-size:14px;align: justify;\">
		  <p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<b>Prezado(ª) ".$cliente['nome_contato_dir']."</b>, comunicamos ter recebido e contabilizado o pagamento efetuado no dia
<b>"; if($fatura_info[data_pagamento]){$msg.= date("d/m/Y", strtotime($fatura_info[data_pagamento]));}else{ $msg.= date("d/m/Y");}
$msg .="
</b>, referente ao resumo de fatura número <b>".STR_PAD($fatura, 4, '0', STR_PAD_LEFT)."/".date("Y", strtotime($fatura_info['data_vencimento']))."</b>.
<br>
<p align=left>
";
//<b>Valor R$ ".number_format($total, 2, ',','.')."</b>
$msg .="<p>
<br>
<b><p align=left>
<i>SESMT VELANDO PELA SEGURANÇA NO TRABALHO<br>
E PELA SAÚDE OCUPACIONAL DA SUA EMPRESA <br></i></b>
<p>
<br><BR>
<p>
<br>
<p>
<b>Departamento Financeiro<br></b>
<i>SESMT Serviços Especializados de Segurança e<br>
Monitoramento de Atividades no Trabalho Ltda</i>

          </span>
           </td>
	</tr>
</table></div>
<p>
<br><p>
<center>
************************************************<br>
Mensagem Automática: Por favor, não responder   <br>
************************************************<br>
</center>
<p>
<br>

<br><p>
<br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
	<p>
		<tr>
		<td width=\"65%\" align=\"center\" class=\"fontepreta12 style2\">
		<br /><br /><br /><br /><br /><br />
		  <span class=\"style17\">Telefone: +55 (21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
		  Nextel: +55 (21) 7844-9394 &nbsp;&nbsp;ID:55*23*31368 </span>
          <p class=\"style17\">
		  faleprimeirocomagente@sesmt-rio.com / comercial@sesmt-rio.com<br />
          www.sesmt-rio.com / www.shoppingsesmt.com<br />

	    </td>
		<td width=\"35%\" align=\"right\">
        <img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=\"280\" height=\"200\" /></td>
	</tr>
</table></div>
   </BODY>
</HTML>  ";

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <financeiro@sesmt-rio.com> \n";

   mail("peteson89@hotmail.com", "Comunicado de recebimento de pagamento", $msg, $headers);
   
}else{
   echo "";
}

}else{
   echo "";
}

?>
