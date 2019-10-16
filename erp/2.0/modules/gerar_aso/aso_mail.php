<?php
define('_MPDF_PATH', '../../common/MPDF45/');
define('_IMG_PATH', '../../images/');
$aso = $_GET[aso];
function coloca_zeros($numero){
   return str_pad($numero, 4, "0", STR_PAD_LEFT);
}

$sql = "SELECT * FROM aso a, funcionarios f, cliente c WHERE a.cod_aso = $aso AND a.cod_func = f.cod_func AND a.cod_cliente = f.cod_cliente AND a.cod_cliente = c.cliente_id";
$query = pg_query($sql);
$arr = pg_fetch_array($query);

$msg = "
<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
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
		<br>";
$msg.="<center><h2><b>CORREIO ON-LINE</b></h2></center><p><p>";
$msg.="Olá! Prezado cliente, servimo-nos desta para informa-los por meio desde e-mail que o ASO Atestado de Saúde Ocupacional de Nº ";
$msg.=coloca_zeros($aso);
$msg.=" encontra-se disponível no seu painel de acesso do site, <b>Opções de Cliente!</b>";
$msg.= "<p><a href='http://sesmt-rio.com/?do=aso_pdf'>Acesse agora e faça login no site para visualizar-lo</a>";
$msg .= "<p>Funcionário: ".$arr[nome_func]."<p>Empresa: ".$arr[razao_social]."<p>Tipo de exame:: ".$arr[tipo_exame]."<p>Data: ".$arr[aso_data];
$msg.="<br>
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
        <td align=left width=88%><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9700 31385 - Id 55*23*31641</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / medicotrab@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=12%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>
       </tr>
        </table>





               </body></html>";
if (!empty($funcionario) and !empty($aso)){
        $query_func = "SELECT 
		f.*
        , a.*
        , c.*
        , ca.*
        , cl.*
        , rc.*
        , fu.*

        FROM

        funcionarios f,
        aso a,
        cliente c,
        cnae ca,
        classificacao_atividade cl,
        risco_cliente rc,
        funcao fu,
        cliente_setor cs

        WHERE
            f.cod_func = {$funcionario}
        AND a.cod_aso = {$aso}
        AND a.cod_func = f.cod_func
        AND a.cod_cliente = f.cod_cliente
        AND c.cliente_id = f.cod_cliente
        AND c.cnae_id = ca.cnae_id
        AND cl.classificacao_atividade_id = a.classificacao_atividade_id
        AND rc.risco_id = a.risco_id
        AND fu.cod_funcao = f.cod_funcao
        AND cs.cod_setor = f.cod_setor
        AND cs.cod_cliente = f.cod_cliente";
		$result_func = pg_query($query_func);
		$row_func = pg_fetch_array($result_func);
}

//BUSCAR DADOS DA TABELA ASO
if (!empty($funcionario) and !empty($aso)){
	$affs = "select * from aso where cod_aso = {$aso} and cod_func = {$funcionario}";
	$aff = pg_query($affs);
	$fdp = pg_fetch_array($aff);
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*****************************************************************************************************************/
$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";

//PARA -> $row[email]
$mail_list = explode(";", $_GET['email']);
$ok = "";
$er = "";

for($x=0;$x<count($mail_list);$x++){
if($mail_list[$x] != ""){
	
	
	if($x ==0){
		
		
   if(mail($mail_list[$x].";financeiro@sesmt-rio.com", "SESMT - ASO Nº: ".$row_func[cod_aso], $msg, $headers)){
      $ok .= ", ".$mail_list[$x];
	  $m = 1;
	  
	  
   }else{
      $er .= ", ".$mail_list[$x];
   }
   
   
   
	}else{
		
		if(mail($mail_list[$x], "SESMT - ASO Nº: ".$row_func[cod_aso], $msg, $headers)){
      $ok .= ", ".$mail_list[$x];
	  $m = 1;
	  
	  
   }else{
      $er .= ", ".$mail_list[$x];
   }
		
		
	}
   
   
}
}
echo "<script>('E-Mails enviado para".$ok."');</script>";
if($er != ""){
    echo "<script>('Erro ao enviar E-mail para".$er."');</script>";
}
    if($ok != ""){
        $sql = "UPDATE aso SET data_envio = '".date("r")."', enviado=1 WHERE cod_aso = $row_func[cod_aso]";
        $resu = pg_query($sql);
    }

echo "<script>location.href='?dir=gerar_aso&p=lista_aso&pq=$aso&m=$m';</script>";
?>
