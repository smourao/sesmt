<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");
include ("../../functions.php");

$fatura = $_GET['fatura'];

if(is_numeric($fatura)){
    $sql = "SELECT * FROM site_fatura_info
            WHERE cod_fatura = $fatura";
            $r = pg_query($sql);
            $fat1 = pg_fetch_all($r);

    $sql = "SELECT * FROM cliente WHERE cliente_id = '{$fat1[0]['cod_cliente']}'";
    $cliente = pg_fetch_array(pg_query($sql));

    //Verifica items na tabela...
    $sql = "SELECT * FROM site_fatura_produto WHERE cod_fatura = '{$fat1[0]['cod_fatura']}'";
    $pr = pg_query($sql);
    $pt = pg_fetch_all($pr);
    $dias = dateDiff(date("d-m-Y", strtotime($fat1[0]['data_vencimento'])), date("d-m-Y"));
    $total = 0;
    for($x=0;$x<pg_num_rows($pr);$x++){
        $total += $pt[$x]['quantidade'] * $pt[$x]['valor'];
    }
    $multa = ($total * 3)/100;
    $juros = ($total * 0.29)/100;
    $base = $total;
    if($dias >= 5){
        $total+= $multa + ($juros*$dias);
    }

        $msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
               <HTML>
               <HEAD>
                  <TITLE> Confirma��o de pagamento</TITLE>
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
            <font size='7' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=3>�</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVI�OS ESPECIALIZADOS DE SEGURAN�A<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
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
        <center><b>
        <span style='background: #008000; color: #FFFFFF;'>
        FCFI - Ficha de Cobran�a de Fatura em Inadimpl�ncia N� ".STR_PAD($fat1[0]['cod_fatura'], 4, '0', STR_PAD_LEFT)."/".date("Y", strtotime($fat1[0]['data_vencimento']))."</span></b></center>
        <p>
        <center>
        ************************************************<br>
        Mensagem Autom�tica: Por favor, n�o responder   <br>
        ************************************************<br>
        <p>
        <br>
            <center><b>".$cliente['razao_social']."</b></center>
        </center>
        <br><p>
        <br>
        <div align=\"center\">
        <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
        	<tr>
        		<td width=\"70%\" align=\"left\" class=\"fontepreta12\"><br />
        		  <span class=\"style2 fontepreta12\" style=\"font-size:14px;align: justify;\">
        		  <p align=justify>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>Prezado(�) ".$cliente['nome_contato_dir']."</b>, comunicamos n�o ter recebido e contabilizado o
        pagamento que deveria ser efetuado no dia <b>";
            $msg.= date("d/m/Y", strtotime($fat1[0][data_vencimento]));
        $msg .="
        </b>, referente ao resumo de fatura n�mero <b>".STR_PAD($fat1[0][cod_fatura], 4, '0', STR_PAD_LEFT)."/".date("Y", strtotime($fat1[0]['data_vencimento']))."</b>.
        <br>
        <p align=left>
        <b>Valor R$ ".number_format($total, 2, ',','.')."</b>
        <p>
        <br>
        <b>Informamos que ap�s 20 dias de atraso e duas mensagens de notifica��o de pagamento, referente
        ao resumo de fatura ".STR_PAD($fat1[0][cod_fatura], 4, '0', STR_PAD_LEFT)."/".date("Y", strtotime($fat1[0]['data_vencimento'])).",
        mesmo que compelidos estamos encaminhando a documenta��o de cobran�a ao nosso corpo jur�dico,
        Dr. Alo�sio Benevides Associados, para tomar as providencias de regulariza��o de cr�dito junto a
        SESMT ou negativa��o junto aos org�os de cr�dito.</b>
        <p>
        <b>Por favor, desconsiderar caso o pagamento j� tenha sido efetuado.</b>
        <br>
        <b><p align=left>
        <i>SESMT VELANDO PELA SEGURAN�A NO TRABALHO<br>
        E PELA SA�DE OCUPACIONAL DA SUA EMPRESA <br></i></b>
        <p>
        <br><BR>
        <p>
        <br>
        <p>
        <b>Departamento Financeiro<br></b>
        <i>SESMT Servi�os Especializados de Seguran�a e<br>
        Monitoramento de Atividades no Trabalho Ltda</i>

                  </span>
                   </td>
        	</tr>
        </table></div>
        <p>
        <br><p>
        <center>
        ************************************************<br>
        Mensagem Autom�tica: Por favor, n�o responder   <br>
        ************************************************<br>
        </center>
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
</HTML>";

        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        $headers .= "From: SESMT - Seguran�a do Trabalho e Higiene Ocupacional. <financeiro@sesmt-rio.com> \n";

       if(mail($cliente[email], "Cobran�a de Fatura em Inadimpl�ncia", $msg, $headers)){
           $sql = "UPDATE site_fatura_info SET data_3_notificacao = '".date("Y/m/d")."' WHERE cod_fatura = '{$fatura}'";
           pg_query($sql);
           echo "Cliente notificado com sucesso!|$fatura";
       }
}else{
   echo "";
}

?>
