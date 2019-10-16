<?PHP


//***********************************************************************************************
//                                 ***  MAIL  ***
//***********************************************************************************************


if(!empty($_GET[mail])){
           //
           $sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
           $res = pg_query($sql);
           $cliente = pg_fetch_array($res);
           
           $url = "http://sesmt-rio.com/contratos/aberto.php?cod_cliente={$_GET[cod_cliente]}&cid={$_GET[cid]}&tipo_contrato={$_GET[tipo_contrato]}&sala={$_GET[sala]}&parcelas={$_GET[parcelas]}&vencimento={$_GET[vencimento]}&rnd=".rand(10000, 99999);
           //echo $url;
           
           
           $msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
           <HTML>
           <HEAD>
              <TITLE>SESMT</TITLE>
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
            <b>Contrato</b>";
			
        $msg.= "
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
		
<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 >
	<tr>
		<td width=100% class=fontepreta12><span class=style15>
Prezado(ª) {$cliente[nome_contato_dir]}, Solicito imprimir o contrato em duas vias, ler o contrato atentamente.
Rubricar cada folha, porém, a última deverá ser assinada e reconhecido firma da assinatura e
enviar a Sesmt via correios. <p>
Os anexos são normatização que dão validades as cláusulas em que se diz respeito cada um deles
sendo tão somente necessária a rubrica das primeiras páginas, a assinatura da última e o respectivo
reconhecimento de firma da assinatura.<p>

....continuação dos  anexos onde constam a razão social e o CNPJ da CONTRATANTE e o anexo 1 que é o
objetivo deste contrato.<p>

Remeter junto com a nossa via do contrato e, cópia das primeira e últimas folhas do contrato social
ou estatuto, solicito ainda informar ao escritório de contabilidade quem presta serviços a sua
empresa sobre a celebração do contrato com a SESMT para que formalmente apresentados possamos
coletar-mos informações importante a prestação dos serviços.<p>

Clique para visualizar e imprimir o contrato:<br>
<a href='$url' target=_blank>CLIQUE AQUI</a>
        </td>
	</tr>
</table></div>
";

$msg .= "<br>
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
        <td align=left width=88%><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9700 31385 - Id 55*23*31641</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / juridico@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=12%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
       </tr>
        </table>
   </BODY>
</HTML>  ";

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <juridico@sesmt-rio.com> \n";

$mail_list = explode(";", $_GET['mail']);
$ok = "";
$er = "";

for($x=0;$x<count($mail_list);$x++){
    if($mail_list[$x] != ""){
       if(mail($mail_list[$x], "Contrato - SESMT", $msg, $headers)){
          $ok .= ", ".$mail_list[$x];
       }else{
          $er .= ", ".$mail_list[$x];
       }
    }
}

echo "<script>alert('E-Mails enviado para".$ok."');location.href='?dir=adm_contrato&p=index';</script>";


}


?>
<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1">
<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>
<tr>
<td width=250 class='text roundborder' valign=top>




				<table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                <td align=center class='text roundborderselected'>
                    <b>Administração de Contrato</b>
                </td>
                </tr>
                </table>
                
                
                
                
                <table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                    <td class="roundbordermix text" height=30 align=center onmouseover=\"showtip('tipbox', '');\" onmouseout=\"hidetip('tipbox');\">
                       <table border=0 width=100% align=center>
                        <tr>
                        
						<td align=center class="text">
                        <input type="submit" class="btn" value="Lista" onclick="location.href='<?php echo "?dir=$_GET[dir]&p=$_GET[p]&lista=true" ?>'">
                        </td>
                        
                        <td align=center class="text">
                        <input type="submit" class="btn" value="Cancelados" onclick="location.href='<?php echo "?dir=$_GET[dir]&p=index&action=cancelados" ?>'">
                        </td>
						
                        </tr>
                        
                        <tr>
                        
						<td align=center class="text">
                        <input type="submit" class="btn" value="Destratos" onclick="location.href='<?php echo "?dir=$_GET[dir]&p=index&action=destratos" ?>'">
                        </td>
                        
                        
                        <?php
                        
						if($_GET['action']){
							
						?>
                        
                        <td align=center class="text">
                        <input type="submit" class="btn" value="Voltar" onclick="location.href='<?php echo "?dir=$_GET[dir]&p=index&lista=true" ?>'">
                        </td>
							
						<?php
						}else{
						
						$url = "http://" . $_SERVER['HTTP_HOST'] . "/erp/2.0/";
                        ?>
                        <td align=center class="text">
                        <input type="submit" class="btn" value="Voltar" onclick="location.href='<?php echo "$url" ?>'">
                        </td>
						
                        <?php
						}
                        ?>
                        
                        
                        </tr>
						
						

                        </table>
						
						
                        
                    </td>
                </tr>
                </table>
                
                <P>
                
                <?php
                // --> TIPBOX
				?>
                <table width=250 border=0 cellspacing=3 cellpadding=2>
                <tr>
                    <td class=text height=30 valign=top align=justify>
                        <div id="tipbox" class="roundborderselected text" style="display: none;">&nbsp;</div>
                    </td>
                </tr>
                </table>
		</td>
				
				
		 <td class="text roundborder" valign=top>
        <table width=100% border=0 cellspacing=2 cellpadding=2>
        <tr>
        <td align=center class="text roundborderselected">
            <b>Administração de Contrato</b>
            
        </td>
        </tr>
        <tr>
        <td>
        <?php
		if($_GET[action] == 'cancelados'){
			include("cancelados.php");
			
		}else if($_GET[action] == 'destratos'){
			include("destratos.php");
			
		}else if($_GET[action] == 'propriedade'){
			include("propriedade_de_contrato.php");
			
		}else{
			include("lista_contrato.php");
			
		}
		?>
        </table>
				
				
</tr>
</table>