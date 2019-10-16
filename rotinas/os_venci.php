<?php

include('../common/includes/database.php');

$data_hoje = date('Y-m-d');



$pegarossql = "SELECT * FROM os_info WHERE status = 0 AND data_conclusao < '".$data_hoje."'";
$pegarosquery = pg_query($pegarossql);
$pegaros = pg_fetch_all($pegarosquery);
$pegarosnum = pg_num_rows($pegarosquery);

for($x=0;$x<$pegarosnum;$x++){
	
	$cod_func = $pegaros[$x][para];
	$cod_setor = $pegaros[$x][setor];
	$assunto_os = $pegaros[$x]['assunto'];
	$cod_os = $pegaros[$x][id];
	$data_vencimento = $pegaros[$x]['data_conclusao'];
	$data_vencimento_barra = date("d/m/Y", strtotime($data_vencimento));
	
	
	
	if($cod_func == 0){
						
						
						$user_sqlss = "SELECT email FROM funcionario WHERE cod_setor = ".$cod_setor." AND status = 1";
   						$user_resultss = pg_query($user_sqlss);
    					$grupocad = pg_fetch_all($user_resultss);
						$grupocadnum = pg_num_rows($user_resultss);
						
						$emailgrupo = '';
						
						for($j=0;$j<$grupocadnum;$j++){
						$emailgrupo .= $grupocad[$j]['email'];
						$emailgrupo .= ';';
						}
						
						$manda_email = $emailgrupo;
					
					}else{
						
						$pegardadossql = "SELECT email FROM funcionario WHERE funcionario_id = ".$cod_func;
						$pegardadosquery = pg_query($pegardadossql);
						$pegardados = pg_fetch_array($pegardadosquery);
						
						$manda_email = $pegardados['email'];
						
					}
					
					




		$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
               <HTML>
               <HEAD>
                  <TITLE>OS Vencida</TITLE>
            <META http-equiv=Content-Type content=\"text/html; charset=utf-8\">
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
			   
            <table width='100%' border='0' cellpadding='0' cellspacing='0'>
		<tr>
			<td align='left'>
            <p><strong>
            <font size='6' face='Verdana, Arial, Helvetica, sans-serif'>SESMT<sup><font size=2>®</font></sup></font>&nbsp;&nbsp;
			<font size='1' face='Verdana, Arial, Helvetica, sans-serif'>SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>
            <td width=40% align=right>
            <font face='Verdana, Arial, Helvetica, sans-serif' size='3'>
            <b>Ordem de Serviço</b>
            </td>
	  </tr>
	</table>
			
			
			<br>
            <div align=\"center\">
            <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
            	<tr>
            		<td width=\"70%\" align=\"center\" class=\"fontepreta12\"><br />
            		  <span class=\"style2 fontepreta12\" style=\"font-size:14px;align: justify;\">
            		  <p align=justify>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            A O.S. <b>".$cod_os."</b>, com o assunto: <b>".$assunto_os."</b> esta vencida desde o dia: <b>".$data_vencimento_barra."</b>.
            <p align=left>
            <p>
            <br></span>
                       </td>
            	</tr>
            </table></div>
            <p>
            <br><p>
  <table width=100%>
  <tr>
     <td align=center>
     <font face='Verdana, Arial, Helvetica, sans-serif'>
    <b> Telefone: +55 (21) 3014 4304 &nbsp; Fax: Ramal 7<br>
     Nextel: +55 (21) 97003 1385 - Id 55*23*31641<P>
     <font face='Verdana, Arial, Helvetica, sans-serif' size=2>
     faleprimeirocomagente@sesmt-rio.com / financeiro@sesmt-rio.com<br>
     www.sesmt-rio.com</b>
     </td>
     <td width=130><font face='Verdana, Arial, Helvetica, sans-serif'><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
  </tr>
  </table>
               </BODY>
            </HTML>";
            
            $headers = "MIME-Version: 1.0\n";
            $headers .= "Content-type: text/html; charset=utf-8\n";
            $headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";
            mail($manda_email, 'Vencimento da Ordem de Serviço Nº '.$cod_os, $msg, $headers);



	
	echo "ok";
	
}


?>