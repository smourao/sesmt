<?php 
include "../sessao.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

if($_GET){
	$funcionario = $_GET["funcionario"];
	$setor = $_GET["setor"];
	$cliente = $_GET["cliente"];
	$filial = $_GET["filial"];
	$aso = $_GET["aso"];
} else {
	$funcionario = $_POST["funcionario"];
	$setor = $_POST["setor"];
	$cliente = $_POST["cliente"];
	$filial = $_POST["filial"];
	$aso = $_POST["aso"];
}

function coloca_zeros($numero){
   return str_pad($numero, 4, "0", STR_PAD_LEFT);
}

/******************** DADOS **********************/
if (!empty($funcionario) and !empty($aso))
{
		$query_func = "SELECT f.cod_func, f.nome_func, f.num_ctps_func, f.serie_ctps_func, f.cbo, f.dinamica_funcao -- funcionário
						   , a.cod_aso, a.cod_setor, a.tipo_exame, a.aso_resultado, a.aso_data, a.obs -- aso 
						   , c.cliente_id, c.razao_social, c.num_end, c.bairro, c.endereco, c.cep, c.cnpj -- cliente
						   , ca.cnae_id, ca.cnae, ca.grau_risco -- cnae
						   , cl.classificacao_atividade_id, cl.nome_atividade -- classificacao_atividade
						   , rc.risco_id, rc.nome -- risco cliente
						   , ar.cod_agente_risco, ar.nome_agente_risco -- agente risco
						   , tr.cod_tipo_risco, tr.nome_tipo_risco -- tipo_risco
						   , fu.cod_funcao, fu.nome_funcao -- funcao
						
						FROM funcionarios f, aso a, cliente c, cliente_setor cs, cnae ca
							 , classificacao_atividade cl, risco_cliente rc, risco_setor rs
							 , agente_risco ar, tipo_risco tr, funcao fu
						
						WHERE  f.cod_func = $funcionario
						   AND a.cod_aso = $aso
						   AND f.cod_funcao = fu.cod_funcao
						   AND a.cod_func = f.cod_func
						   AND a.cod_cliente = c.cliente_id
						   AND f.cod_cliente = c.cliente_id
						   AND c.cliente_id = cs.cod_cliente
						   AND f.cod_setor = cs.cod_setor
						   AND c.cnae_id = ca.cnae_id
						   AND a.classificacao_atividade_id = cl.classificacao_atividade_id
						   AND a.risco_id = rc.risco_id
						   AND rs.cod_setor = cs.cod_setor AND rs.cod_cliente = cs.cod_cliente
						   AND rs.cod_agente_risco = ar.cod_agente_risco
						   AND ar.cod_tipo_risco = tr.cod_tipo_risco";

		$result_func = pg_query($connect, $query_func);

		$row_func = pg_fetch_array($result_func);
}
?>

<?PHP
$msg = "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
<title>ASO</title>
<link href=\"../css_js/css.css\" rel=\"stylesheet\" type=\"text/css\">
<style type=\"text/css\">

td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
.style1 {font-size: 14px}
.style2 {font-size: 12px}
.style3 {font-family: Arial, Helvetica, sans-serif}
.style4 {font-size: 12}
.style5 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #006633;
}
</style>
</head>
<body text=\"#000000\">&nbsp;
<table border=0 width=760 height=900>
<tr>
<td>
<form action=\"aso_final.php\" name=\"frm_aso\" method=post>
<a href=\"http://www.sesmt-rio.com/erp/medico/aso_final.php?funcionario=$row_func[cod_func]&aso=$row_func[cod_aso]&cliente=$row_func[cliente_id]&setor=$row_func[cod_setor]\" >Versão para impressão</a>
<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td width=50% align=left><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width=333 height=180></td>
		<td width=50% align=left><p align=center><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\"><span class=style2>Serviços Especializados de Segurança e <br>
		  Monitoramento de Atividades no Trabalho Ltda.<br />
		  CNPJ:04.722.248/0001-17 Insc. Mun.311.213-6</span></font></p>
		  <p align=center><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\">
	            <span class=style2>Segurança do Trabalho e Higiene Ocupacional</span></font></p>
		  <p align=center class=style2><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\">Médico Coordenador do PCMSO:<br />
		  Maria de Lourdes Fernandes Magalhães<br />
	      CRMEJ 52.33.471-0 Reg. MTE 13.320 </font></p><br /><br />
	    <p class=style2>		</td>
	</tr>
</table></div>
<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 bordercolor=\"#000000\">
	<tr>
	<td><center><h2 class=style3>ASO - Atestado de Saúde Ocupacional</h2>
		<h6 class=style3>Conforme NR 7.4.1</h6></center></td>
	</tr>
</table></div>
<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 bordercolor=\"#000000\">
	<tr>
		<td width=14% align=left class=\"fontepreta12 style2\"><b>Nº ASO:</b></td>
		<td width=12% align=left class=\"fontepreta12 style2\"><b>Cod.Cli:</b></td>
		<td width=74% align=left class=\"fontepreta12 style2\"><b>Razão Social:</b></td>
	</tr>
	<tr>
		<td class=fontepreta12 align=left>";
        if($row_func[cod_aso]){
            $msg.= coloca_zeros($row_func[cod_aso]);
        }
        $msg.= "</td>
		<td class=fontepreta12 align=left>";
        if($row_func[cliente_id]){$msg.=coloca_zeros($row_func[cliente_id]);}
        $msg.= "</td>
		<td class=fontepreta12 align=left>";
        $msg.= $row_func[razao_social];
        $msg.= "</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 bordercolor=\"#000000\">
	<tr>
		<td width=70% align=left class=\"fontepreta12 style2\"><b>End.:</b>&nbsp;".$row_func[endereco].", ".$row_func[num_end]." - ".$row_func[bairro]."</td>
		<td width=30% align=left class=\"fontepreta12 style2\"><b>CEP:</b>&nbsp;".$row_func[cep]."</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 bordercolor=\"#000000\">
	<tr>
		<td width=25% align=left class=\"fontepreta12 style2\"><b>CNPJ:</b></td>
		<td width=20% align=left class=\"fontepreta12 style2\"><b>CNAE:</b></td>
		<td width=20% align=left class=\"fontepreta12 style2\"><b>Grau de Risco:</b></td>
		<td width=35% align=left class=\"fontepreta12 style2\"><b>Tipo de Exame:</b></td>
	</tr>
	<tr>
		<td class=\"fontepreta12\" align=\"left\">".$row_func[cnpj]."</td>
		<td class=\"fontepreta12\" align=\"left\">".$row_func[cnae]."</td>
		<td class=\"fontepreta12\" align=\"left\">".$row_func[grau_risco]."</td>
		<td class=\"fontepreta12\" align=\"left\">".$row_func[tipo_exame]."</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
	<tr>
		<td width=\"18%\" align=\"left\" class=\"fontepreta12 style2\"><b>Cod.Func:</b></td>
		<td width=\"82%\" align=\"left\" class=\"fontepreta12 style2\"><b>Nome do Funcionário:</b></td>
	</tr>
	<tr>
		<td class=\"fontepreta12\" align=\"left\">"; if($row_func[cod_func]) {$msg.=coloca_zeros($row_func[cod_func]);} $msg.= "</td>
		<td class=\"fontepreta12\" align=\"left\">".$row_func[nome_func]."</td>
	</tr>
</table></div>
<div align=center>
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
<br />
	<tr>
		<td width=\"15%\" align=\"left\" class=\"fontepreta12 style2\"><b>CTPS:</b>&nbsp;".$row_func[num_ctps_func]."</td>
		<td width=\"15%\" align=\"left\" class=\"fontepreta12 style2\"><b>Série:</b>&nbsp;".$row_func[serie_ctps_func]."</td>
		<td width=\"15%\" align=\"left\" class=\"fontepreta12 style2\"><b>CBO:</b>&nbsp;".$row_func[cbo]."</td>
		<td width=\"65%\" align=\"left\" class=\"fontepreta12 style2\"><b>Função:</b>&nbsp;".$row_func[nome_funcao]."</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 bordercolor=\"#000000\">
	<tr>
		<td width=\"100%\" align=\"left\" class=\"fontepreta12 style2\"><b>Atividade Laborativa:</b>&nbsp;".$row_func[dinamica_funcao]."</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 bordercolor=\"#000000\">
	<tr>
		<td width=50% align=left class=\"fontepreta12 style2\"><b>Classificação da Atividade:</b>&nbsp;".$row_func[nome_atividade]."</td>
		<td width=50% align=left class=\"fontepreta12 style2\"><b>Nível de Tolerância:</b>&nbsp;".$row_func[nome]."</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table></div>
<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 bordercolor=\"#000000\">
	<tr>
		<td width=20% align=left class=\"fontepreta12 style2\"><b>Riscos da Função:</b></td>
		<td width=30% align=left class=\"fontepreta12 style2\"><b>Especificar Riscos da Função:</b></td>
		<td width=50% align=left class=\"fontepreta12 style2\"><b>Exames Realizados:</b></td>
	</tr>
	<tr>";
		// SELEÇÃO DOS RISCOS DA FUNÇÃO.
		if( !empty($funcionario) and !empty($aso) ){
			$query_risco="SELECT tr.cod_tipo_risco, nome_tipo_risco, ar.cod_agente_risco
						  FROM tipo_risco tr, risco_setor rs, agente_risco ar, cliente c, aso a, funcionarios f
						  WHERE ar.cod_agente_risco = rs.cod_agente_risco
						  AND ar.cod_tipo_risco = tr.cod_tipo_risco
						  AND c.cliente_id = rs.cod_cliente
						  AND a.cod_cliente = c.cliente_id
						  AND rs.cod_setor = f.cod_setor
						  AND a.cod_aso = $aso
						  AND f.cod_func = $funcionario
						  AND f.cod_cliente = $cliente
						  AND f.cod_setor = $setor
						  order by nome_tipo_risco";
						  
			$result_risco=pg_query($query_risco) 
			or die("Erro na query: $query_risco".pg_last_error($connect));
			
			$msg.= "	<td align=\"left\" class=\"fontepreta12 style1\">";
			
				while($row_risco=pg_fetch_array($result_risco)){ 
			         $msg.= $row_risco[nome_tipo_risco]; $msg.= " <br> ";
				}
			$msg.= "	</td>";
			} //Fim da Seleção

		//ESPECIFICAR OS RISCOS DA FUNÇÃO.
		if( !empty($funcionario) and !empty($aso) ){
			$query_agente="SELECT tr.cod_tipo_risco, nome_agente_risco, ar.cod_agente_risco
						   FROM tipo_risco tr, risco_setor rs, agente_risco ar, cliente c, aso a, funcionarios f
						   WHERE ar.cod_agente_risco = rs.cod_agente_risco
						   AND ar.cod_tipo_risco = tr.cod_tipo_risco
						   AND c.cliente_id = rs.cod_cliente
						   AND a.cod_cliente = c.cliente_id
						   AND rs.cod_setor = f.cod_setor
						   AND a.cod_aso = $aso
						   AND f.cod_func = $funcionario
						   AND f.cod_cliente = $cliente
						   AND f.cod_setor = $setor
						   order by nome_agente_risco";
						  
			$result_agente=pg_query($query_agente) 
			or die("Erro na query: $query_agente".pg_last_error($connect));

			$msg.= "	<td align=\"left\" class=\"fontepreta12 style1\">";

				while($row_agente=pg_fetch_array($result_agente)){ 
			$msg.= $row_agente[nome_agente_risco]; $msg.= " <br> ";
				}
			$msg.= "	</td>";
			} //FIM DA SELEÇÃO

		//SELEÇÃO DOS EXAMES COMPLEMENTARES.
		if( !empty($funcionario) and !empty($aso) ){
			$query_exame="SELECT e.cod_exame, e.especialidade, ae.data
						  FROM exame e, aso a, aso_exame ae, funcionarios f, cliente c
						  WHERE a.cod_aso = ae.cod_aso
						  AND e.cod_exame = ae.cod_exame
						  AND a.cod_func = f.cod_func 
						  AND c.cliente_id = f.cod_cliente
						  AND a.cod_setor = f.cod_setor
						  AND a.cod_aso = $aso
						  AND f.cod_func = $funcionario
						  AND f.cod_cliente = $cliente
						  AND f.cod_setor = $setor
						  order by especialidade";
						  
			$result_exame=pg_query($query_exame) 
			or die("Erro na query: $query_exame".pg_last_error($connect));
			
			$msg.= "	<td align=\"left\" class=\"fontepreta12 style1\">";
			$msg.= "	<Table border=0 width=100%>";	
				while($row_exame=pg_fetch_array($result_exame)){ 
			$msg.= " <tr><td align=\"left\" class='fontepreta12 style1'>";
			$msg.= $row_exame[especialidade];
				
			$msg.= " </td><td width=30% align=\"left\" class=\"fontepreta12 style1\">".date("d/m/Y", strtotime($row_exame[data]))."</td></tr>";
			}
			$msg.= "</table></td>";
			} //Fim da Seleção

$msg.="	</tr>
</table></div>";

/******CONSULTAR SE FOR EXAME SEM COMPLEMENTAR********/
$sc = "SELECT *
	   FROM aso_exame
	   WHERE cod_aso = $aso";
$rsc = pg_query($connect, $sc);
$ce = pg_fetch_array($rsc);
/*****************************************************/

$msg.=" <div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 bordercolor=\"#000000\">
<br />
	<tr>
		<td align=\"left\" class=\"fontepreta14 style2\">
		Atesto para os fins do artigo 168 da lei 6.514/77 e port. 3.214/78 SSMT Nº24 de 29/12/94 e 
		despacho SSMT nº8 de 01/10/96, NR7 - PCMSO, que: o funcionário como acima qualificado, 
		encontra-se <strong>$row_func[aso_resultado] </strong> mediante ter sido aprovado nos
		exames físicos e psicológicos.";
		/*if(pg_num_rows($rsc) == 1 and $ce[cod_exame] == 22){
			$msg.=" Dependendo apenas dos exames complementares acima quando solicitados, para diagnosticação do médico coordenador dos programas de PCMSO - NR7, de responsabilidade do empregador realizá-los e remeter ao médico examinador o(s) original(is), em até o 10º dia útil da avaliação física. Este ASO(atestado de saúde ocupacional) só será válido para efeito de fiscalização e ou judicialmente se acompanhado dos exames complementares sempre que for solicitado pelo médico examinador.";
		}else{
		
		}*/
		$msg.=" </td>
	</tr>";

if($row_func[aso_resultado] == "Inapto" || $row_func[aso_resultado] == "Apto com Restrição"){
	$msg.= "<tr><td align=left class=fontepreta12>
			{$row_func[obs]}
		  </td></tr>";
}

$msg.=" <tr>
		<td align=\"left\" class=\"fontepreta12 style1\"><b>Data de Realização:</b>&nbsp;". date("d/m/Y", strtotime($row_func[aso_data]))."</td>
	</tr>";

$msg.=" </table></div>
<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 bordercolor=\"#000000\">
	<br /><br />
	<tr>
		<td align=center width=50%>___________________________________</td>
		<td align=center width=50%>";
		if(!$_GET['sem_timbre']){
        	$msg.= "<img src=\"http://www.sesmt-rio.com/erp/img/assinatura.png\" border=\"0\" />";
        }
		$msg.=" </td>
	</tr>
	<tr>
		<th class=\"fontepreta12 style2\">Assinatura do Examinado</th>
		<th class=\"fontepreta12 style2\">Assinatura do Examinador</th>
	</tr>
</table></div>
<div align=center>
<table width=\"100%\" border=0 cellpadding=0 cellspacing=0 bordercolor=\"#000000\">
<p>
	<tr>
		<td width=65% align=center class=\"fontepreta12 style2\">
		<br /><br /><br /><br /><br /><br />
		  Telefone: (55 - *21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
		  Nextel: (55 - *21) 7844-9394 &nbsp;&nbsp;ID:23*31368
		  <p>
		  faleprimeirocomagente@sesmt-rio.com - medicotrab@sesmt-rio.com<br />
          www.sesmt-rio.com / www.shoppingsesmt.com<br />
        
	    </td>
		<td width=35% align=right><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=280 height=200 /></td>
	</tr>
</table></div>
</form>
</td>
</tr>
</table>
</body>
</html>
";

echo $msg;

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <medicotrab@sesmt-rio.com> \n";

//PARA -> $row[email]
$mail_list = explode(";", $_GET['email']);
$ok = "";
$er = "";

for($x=0;$x<count($mail_list);$x++){
if($mail_list[$x] != ""){
   if(mail($mail_list[$x], "SESMT - ASO Nº: ".coloca_zeros($row_func[cod_aso]), $msg, $headers)){
      $ok .= ", ".$mail_list[$x];
   }else{
      $er .= ", ".$mail_list[$x];
   }
}
}

echo "<script>alert('E-Mails enviado para".$ok."');</script>";
if($er != ""){
    echo "<script>alert('Erro ao enviar E-mail para".$er."');</script>";
}
    if($ok != ""){
        $sql = "UPDATE aso SET data_envio = '".date("r")."', enviado=1 WHERE cod_aso = '$row_func[cod_aso]'";
        $resu = pg_query($sql);
    }

//mail($mail_list[$x], "Simulador(enviado manualmente)- Proposta Comercial Nº: {$orc_n}/".date("Y"), $msg, $headers);

echo "<script>location.href='lista_aso.php?s={$_GET[cliente]}';</script>";
?>
