<?php 
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../../common/MPDF45/');
define('_IMG_PATH', '../../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../../common/database/conn.php");
//define('_IMG_PATH_', '../../../../images/relatorios/');
/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$cod_cliente = $_GET[cod_cliente];
$setor 		 = $_GET[setor];
$funcionario = $_GET[funcionario];
$aso 		 = $_GET[aso];
$code        = "";
$header_h    = 140;//header height;
$footer_h    = 170;//footer height;
$meses       = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m           = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");

/*>>>>>>>>>R0CH4<<<<<<<<<<<<<<<*/
/******************** DADOS **********************/
$s = "SELECT * FROM aso WHERE cod_aso = '$aso'";
$q = pg_query($s);
$a = pg_fetch_array($q);

if($a[tipo] != 1){
	if (!empty($funcionario) and !empty($aso)){
			$query_func = "SELECT f.*, a.*, c.*, ca.*, cl.*, rc.*, fu.*	
			FROM	
			funcionarios f,	aso a, cliente c, cnae ca, classificacao_atividade cl, risco_cliente rc, funcao fu, cliente_setor cs	
			WHERE
				f.cod_func = {$funcionario}
			AND a.cod_aso = {$aso}
			AND a.cod_func = f.cod_func
			AND a.cod_cliente = f.cod_cliente
			AND c.cliente_id = f.cod_cliente
			AND c.cnae_id = ca.cnae_id
			AND rc.risco_id = a.risco_id 
			AND a.classificacao_atividade_id = cl.classificacao_atividade_id 
			AND fu.cod_funcao = f.cod_funcao
			AND cs.cod_setor = f.cod_setor
			AND cs.cod_cliente = f.cod_cliente";
			$result_func = pg_query($query_func);
			$row_func = pg_fetch_array($result_func);
	}
}else{
	if (!empty($funcionario) and !empty($aso)){
			$query_func = "SELECT f.*, a.*, c.*, ca.*, fu.*, cl.*	
			FROM	
			funcionarios f,	aso a, cliente c, cnae ca, funcao fu, classificacao_atividade cl	
			WHERE
				f.cod_func = {$funcionario}
			AND a.cod_aso = {$aso}
			AND a.cod_func = f.cod_func
			AND a.cod_cliente = f.cod_cliente
			AND c.cliente_id = f.cod_cliente
			AND c.cnae_id = ca.cnae_id
			AND fu.cod_funcao = f.cod_funcao
			AND cl.classificacao_atividade_id = a.classificacao_atividade_id";
			$result_func = pg_query($query_func);
			$row_func = pg_fetch_array($result_func);
	}
}

//BUSCAR DADOS DA TABELA ASO
if (!empty($funcionario) and !empty($aso)){
	$affs = "select * from aso where cod_aso = {$aso} and cod_func = {$funcionario}";
	$aff = pg_query($affs);
	$fdp = pg_fetch_array($aff);
}

if(!empty($funcionario) and !empty($aso)){
	$goku = "select * from cliente where cliente_id = {$fdp[cod_cliente]}";
	$piccolo = pg_query($goku);
	$vegeta = pg_fetch_array($piccolo);
	
	$razao_social = ucwords(strtolower($vegeta[razao_social]));
}

if(!empty($funcionario) and !empty($aso)){
	$seiya = "select * from funcionarios where cod_func = $fdp[cod_func] and cod_cliente = $fdp[cod_cliente] ";
	$hyoga = pg_query($seiya);
	$shiryu = pg_fetch_array($hyoga);
	
	$nome_func = ucwords(strtolower($shiryu[nome_func]));
}

if(!empty($funcionario) and !empty($aso)){
	$pichu = "select * from funcao where cod_funcao = $shiryu[cod_funcao] ";
	$pikachu = pg_query($pichu);
	$raichu = pg_fetch_array($pikachu);
}

if(!empty($funcionario) and !empty($aso)){
	$clas1 = "select * from classificacao_atividade where classificacao_atividade_id = $fdp[classificacao_atividade_id] ";
	$clas2 = pg_query($clas1);
	$clas3 = pg_fetch_array($clas2);
}

if(!empty($funcionario) and !empty($aso)){
	$client_sql = "select * from cliente where cliente_id = {$fdp[cod_cliente]}";
	$client_query = pg_query($client_sql);
	$client_array = pg_fetch_array($client_query);
}

/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/
ob_start();
    /*************************************************************************************************************/
    // -> HEADER
    /*************************************************************************************************************/
    /*if($_GET[sem*timbre]){
		$cabecalho	 = "<br><br><br>";
        $cabecalho  .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td valign=top align=left height=$header_h> </td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
        $cabecalho  = "<table width=100% border=0>";
        $cabecalho .= "<tr>";
        $cabecalho .= '<td align="left">
            <p><strong>
            <font size="7" face="Verdana, Arial, Helvetica, sans-serif">SESMT<sup><font size=3>®</font></sup></font>&nbsp;&nbsp;
			<font size="1" face="Verdana, Arial, Helvetica, sans-serif">SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
			CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>';
        $cabecalho .= ' <td width=40% align="right">
            <font face="Verdana, Arial, Helvetica, sans-serif" size="4">
            <b>Atestado de Saúde Ocupacional</b>
            </td>';
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }*/
    if($_GET[sem_timbre]){
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h>&nbsp; </td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h style='margin-top:20'>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h valign=top width=400><img src='logonovo.png' width='400' height='80'></td>";
        $cabecalho .= "<td align=right height=$header_h valign=top width=240><img src='main-logo.png' width='240' height='80'></td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }
	
	//CHANCELA MEDICO PCMSO
		$cabecalho .= "<br/><table width=100% cellspacing=2 cellpadding=2 border=0>";
		$cabecalho .= "<tr>";	
		$cabecalho .= "<td valign=top class='text' align='center'>
		<font size='3' face='Verdana, Arial, Helvetica, sans-serif'>
		Médico Coordenador do PCMSO: Drª Maria de Lourdes Fernandes Magalhães<br/>
		CREMERJ 52.33.471-0 Reg. MTE 13.320
		</font>
		</td>";
		$cabecalho .= "</tr>";
		$cabecalho .= "</table>";
	
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/
    if($_GET[sem*timbre]){
        $rodape  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
        $rodape .= "<td valign=top align=left height=$footer_h> </td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }else{
        $rodape .= "<table width=100% border=0>";
        $rodape .= "<tr>";
        $rodape .= "<td align=left width=88%><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9703 64932 - Id 35*8*16700</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >faleprimeirocomagente@sesmt-rio.com / medicotrab@sesmt-rio.com</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=12%><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     <br></td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }
    $code .= "<html>";
    $code .= "<head>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body style=\"display: inline\">";

/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
	
	/*$code .= '<div class="mainTitle" align=center><font face="Verdana, Arial, Helvetica, sans-serif">
			 <p><font face="Verdana, Arial, Helvetica, sans-serif"><small><small><small><small>Médico Coordenador do PCMSO:<br />
			  Maria de Lourdes Fernandes Magalhães<br />
			  CREMERJ 52.33.471-0 Reg. MTE 13.320 </small></small></small></small></p></font></div><br>';*/
	
	$code .= "<div class='mainTitle' align=center><b>ASO - Atestado de Saúde Ocupacional</b></div>";
	$code .= "<div align=center><b>Conforme NR 7.4.1</b></div>";
	$code .= "<p align=justify>";
	
	$code .= "<table width=100% border=0>";
	$code .= "<tr>";
	$code .= "<td valign=top width=20% class='text'><b>Nº ASO: </b>".str_pad($fdp[cod_aso], "4", "0", "")."</td>";
	$code .= "<td valign=top width=20% class='text'><b>Cliente: </b>".str_pad($fdp[cod_cliente], "4", "0", "")."</td>";
	$code .= "<td valign=top width=35% class='text'><b>CNPJ: </b>".str_pad($vegeta[cnpj], "4", "0", "")."</td>";
	$code .= "<td valign=top width=25% class='text'><b>CNAE: </b>".str_pad($vegeta[cnae_id], "4", "0", "")."</td>";
    $code .= "</tr>";
	$code .= "</table>";
	//linha 1
	$code .= "<table width=100% border=0>";
	$code .= "<tr>";
	$code .= "<td valign=top class='text' width=100% cellspacing=5><b>Razão social: </b>".$razao_social."</td>";
    $code .= "</tr>";
	$code .= "</table>";
	//linha 2
	$code .= "<table width=100% border=0>";
	$code .= "<tr>";
	$code .= "<td valign=top class='text' width=75% cellspacing=5><b>Endereço: </b>".$vegeta[endereco].", ".$vegeta[num_end]." - ".$vegeta[bairro]."</td>";
	$code .= "<td valign=top class='text' width=25% cellspacing=5><b>CEP: </b>".$vegeta[cep]."</td>";
    $code .= "</tr>";
	$code .= "</table>";
	$code .= "<p>";
	//linha 3
	$code .= "<table width=100% border=0>";
	$code .= "<tr>";
	$code .= "<td valign=top class='text' width75%><b>Nome do Funcionário: </b>".$nome_func."</td>";
	$code .= "<td valign=top width=25% class='text'><b>CBO: </b>".$shiryu[cbo]."</td>";
    $code .= "</tr>";
	$code .= "</table>";
	//linha 4
	$code .= "<table width=100% border=0>";
    $code .= "<tr>";	
	$code .= "<td valign=top class='text' width=20%><b>CTPS: </b>".$shiryu[num_ctps_func]."</td>";
	$code .= "<td valign=top class='text' width=20%><b>Série: </b>".$shiryu[serie_ctps_func]."</td>";
	$code .= "<td valign=top class='text' width=35%><b>Tipo de Exame: </b>".$fdp[tipo_exame]."</td>";
	$code .= "<td valign=top class='text' width=25%><b>Grau de Risco: </b>".str_pad($client_array[grau_de_risco], "2", "0", "")."</td>";
    $code .= "</tr>";
	$code .= "</table>";
	$code .= "<p>";
	//linha 5	
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
    $code .= "<td valign=top width=100% class='text' valign=top><b>Função: </b>".$raichu[nome_funcao]."<br><br>";
	$code .= "<b>Atividade Laborativa: </b>".$shiryu[dinamica_funcao]."</td>";
    $code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td valign=top width=40% class='text'><b>Classificação da Atividade: </b>".$clas3[nome_atividade]."</td>";
    $code .= "<td valign=top width=60% class='text'><b>Nível de Tolerância: </b>";
	if($a[tipo] != 1){
		$code .= $fdp[tolerancia]."</td>";
	}else{
		$code .= $fdp[tolerancia]."</td>";
	}
    $code .= "</tr>";
	//linha 6	
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td valign=top width=30% class='text'><b>Risco da Função:</b></td>";
    $code .= "<td valign=top width=30% class='text'><b>Riscos Específicados:</b></td>";
	$code .= "<td valign=top class='text'><b>Exames Realizados:</b></td>";
    $code .= "</tr>";
	$code .= "<tr>";
		// SELEÇÃO DOS RISCOS DA FUNÇÃO.
		if( !empty($funcionario) and !empty($aso) ){
			if($a[tipo] != 1){
				$query_risco="SELECT distinct(nome_tipo_risco)
							  FROM tipo_risco tr, risco_setor rs, agente_risco ar, cliente c, aso a, funcionarios f
							  WHERE ar.cod_tipo_risco = tr.cod_tipo_risco
							  AND ar.cod_agente_risco = rs.cod_agente_risco 
							  AND a.cod_cliente = c.cliente_id
							  AND c.cliente_id = rs.cod_cliente
							  AND rs.cod_setor = f.cod_setor
							  AND a.cod_aso = {$aso}
							  AND f.cod_func = {$funcionario} 
							  AND f.cod_cliente = {$cod_cliente}
							  AND f.cod_setor = {$setor} order by nome_tipo_risco";
				$result_risco=pg_query($query_risco);
				
				$code .= "<td valign=top class='text'>";			
				while($row_risco=pg_fetch_array($result_risco)){ 
					$code .= "$row_risco[nome_tipo_risco] <br> ";
				}
				$code .= "</td>";
			}else{
				$query_risco="SELECT *
							  FROM tipo_risco tr, avulso_tipo_risco av, aso a
							  WHERE tr.cod_tipo_risco = av.cod_tipo_risco
							  AND a.cod_aso = {$aso}
							  AND a.cod_aso = av.cod_aso";
				$result_risco=pg_query($query_risco);
				
				$code .= "<td valign=top class='text'>";			
				while($row_risco=pg_fetch_array($result_risco)){ 
					$code .= "$row_risco[nome_tipo_risco] <br> ";
				}
				$code .= "</td>";
			}
		}else{
			$code .= "erro";
		}//Fim da Seleção
		
		//ESPECIFICAR OS RISCOS DA FUNÇÃO.
		if( !empty($funcionario) and !empty($aso) ){
			if($a[tipo] != 1){
				$query_agente="SELECT distinct(nome_agente_risco)
							   FROM tipo_risco tr, risco_setor rs, agente_risco ar, cliente c, aso a, funcionarios f
							   WHERE ar.cod_agente_risco = rs.cod_agente_risco
							   AND ar.cod_tipo_risco = tr.cod_tipo_risco
							   AND c.cliente_id = rs.cod_cliente
							   AND a.cod_cliente = c.cliente_id
							   AND rs.cod_setor = f.cod_setor
							   AND a.cod_aso = {$aso}
							   AND f.cod_func = {$funcionario}
							   AND f.cod_cliente = {$cod_cliente}
							   AND f.cod_setor = {$setor} order by nome_agente_risco";
				$result_agente=pg_query($query_agente);
		
				$code .= "<td valign=top class='text'>";
				while($row_agente=pg_fetch_array($result_agente)){ 
					$code .= "$row_agente[nome_agente_risco] <br>";
				}
				$code .= "</td>";
			}else{
				$query_agente="SELECT *
							   FROM agente_risco ar, aso a, avulso_agente_risco av
							   WHERE ar.cod_agente_risco = av.cod_agente_risco
							   AND av.cod_aso = {$aso}
							   AND a.cod_aso = {$aso}";
				$result_agente=pg_query($query_agente);
		
				$code .= "<td valign=top class='text'>";
				while($row_agente=pg_fetch_array($result_agente)){ 
					$code .= "$row_agente[nome_agente_risco] <br>";
				}
				$code .= "</td>";
			}
		} //FIM DA SELEÇÃO
		
		//SELEÇÃO DOS EXAMES COMPLEMENTARES.
		if( !empty($funcionario) and !empty($aso) ){
		$query_exame="SELECT e.cod_exame, e.especialidade, c.cliente_id, ae.cod_aso, ae.data  FROM exame e, aso a, aso_exame ae, cliente c
					  WHERE e.cod_exame = ae.cod_exame
					  AND ae.confirma = 1
					  AND ae.cod_aso = a.cod_aso
					  AND a.cod_aso = {$aso}
					  AND c.cliente_id = {$cod_cliente}
					  order by especialidade";
		$result_exame=pg_query($query_exame);
		
		
		$code .= "<td valign=top class='text'>";
			$code .= "<Table border=0 width=100%>";			
			while($row_exame=pg_fetch_array($result_exame)){ 
				$code .= "<tr><td valign=top class='text'>";
					$code .= "$row_exame[especialidade]";
				$code .= "</td><td valign=top class='text'>";
					$code .= date("d/m/Y", strtotime($row_exame[data]));
				$code .= "</td></tr>";
			}
			$code .= "</table>";
		$code .= "</td>";
		} //Fim da Seleção
    $code .= "</tr>";
	$code .= "</table>";
	
	//ESTA CONSULTA SÓ ACONTECERÁ PARA UM CLIENTE ESPECÍFICO
	$sc = "SELECT * FROM aso_exame WHERE cod_aso = {$aso}";
	$rsc = pg_query($sc);
	$ce = pg_fetch_array($rsc);
	
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td valign=top align=justify class='text'>Atesto para os fins do artigo 168 da lei 6.514/77 e port. 3.214/78 SSMT Nº24 de 29/12/94 e despacho SSMT nº8 de 01/10/96, NR7 - PCMSO, que: o funcionário como acima qualificado, encontra-se <b>$fdp[aso_resultado]</b> mediante ter sido "; if($fdp[aso_resultado] == 'INAPTO' || $fdp[aso_resultado] == 'Inapto'){ $code .= 'reprovado'; }else{ $code .= 'aprovado'; }  $code .= " nos exames físicos e mental.";
	/*
		if(pg_num_rows($rsc) == 1 and $ce[cod_exame] == 22){
			$code .= "Dependendo apenas dos exames complementares acima quando solicitados, para diagnosticação do médico coordenador dos programas de PCMSO - NR7, de responsabilidade do empregador realizá-los e remeter ao médico examinador o(s) original(is), em até o 10º dia útil da avaliação física. Este ASO(atestado de saúde ocupacional) só será válido para efeito de fiscalização e ou judicialmente se acompanhado dos exames complementares sempre que for solicitado pelo médico examinador.";
		}else{
		
		}*/
	$code .= "</td>";
    $code .= "</tr>";
	$sl = "SELECT * FROM aso WHERE cod_aso = ".$aso." ";
	$qy = pg_query($sl);
	$cee = pg_fetch_array($qy);
	if($cee[aso_resultado] == "Inapto" || $cee[aso_resultado] == "Apto com Restricao"){
		$code .= "<tr><td valign=top align=left class='text'> ".$cee[obs]." </td></tr>";
	}
	$code .= "<tr>";
	$code .= "<td valign=top class='text'><b>Data de Realização:&nbsp;</b>".date("d/m/Y", strtotime($fdp[aso_data]))."</td>";
    $code .= "</tr>";
	$code .= "</table><br><br>";
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td valign=top align=center width=50% class='text' valign='bottom'>______________________________________</td>";
    $code .= "<td valign=top align=center width=50% class='text'>"; if(!$_GET[sem_timbre]){	$code .= "<img src='"._IMG_PATH."assinatura.png'/>"; }else{
	$code .= "<br><br><br><br>______________________________________";	
	}$code .= "</td>";
    $code .= "</tr>";
	$code .= "<tr>";	
	$code .= "<td valign=top align=center class='text'>Assinatura do Examinado</td>";
    $code .= "<td valign=top align=center class='text'>Assinatura do Examinador</td>";
    $code .= "</tr>";
	$code .= "</table><br><br>";
	

	
    //$code .= "<div class='pagebreak'></div>";

ob_end_clean();

/*****************************************************************************************************************/
// -> OUTPUT
/*****************************************************************************************************************/
//if(!$_GET[html]){
    //$html = ob_get_clean();
    //$html = utf8_encode($html);
    //$mpdf = new mPDF('pt','A4',3,'',8,8,5,14,9,9,'P');
    //class mPDF ([ string $codepage [, mixed $format [, float $default_font_size [, string $default_font [, float $margin_left , float $margin_right , float $margin_top , float $margin_bottom , float $margin_header , float $margin_footer [, string $orientation ]]]]]])
    $mpdf = new mPDF('pt', 'A4', 12, 'verdana', 8, 8, 0, 0, 0, 0, 'P'); //P: DEFAULT Portrait L: Landscape
    //$mpdf->allow_charset_conversion=true;
    $mpdf->charset_in='iso-8859-1';
    $mpdf->SetDisplayMode('fullpage');
    //$mpdf->SetFooter('{DATE j/m/Y&nbsp; H:i}|{PAGENO}/{nb}|SEDUC / SIGETI');
    $mpdf->SetHTMLHeader($cabecalho);
    $mpdf->SetHTMLFooter($rodape);
    //carregar folha de estilos
    //$stylesheet = file_get_contents('./pcmso.css');
    $stylesheet = file_get_contents('style.css');
    //incorporar folha de estilos ao documento
    $mpdf->WriteHTML($stylesheet,1);
    // incorpora o corpo ao PDF na posição 2 e deverá ser interpretado como footage. Todo footage é posicao 2 ou 0(padrão).
    $mpdf->WriteHTML($code);
    //void WriteHTML ( string $html [, int $mode [, boolean $initialise  [, boolean $close ]]])
    //MODE Values
    //0 - Parses a whole html document
    //1 - Parses the html as styles and stylesheets only
    //2 - Parses the html as output elements only
    //3 - (For internal use only - parses the html code without writing to document)
    //4 - (For internal use only - writes the html code to a buffer)
    //DEFAULT: 0
	if(!is_dir("aso_pdf/$cod_cliente")){  
	mkdir("aso_pdf/$cod_cliente", 0700 );
	}	
    //nome do arquivo de saida PDF
    $arquivo = "ASO_".$aso.'.pdf';
    //gera o relatorio
	if(file_exists("aso_pdf/$cod_cliente/$arquivo")){ 
    unlink("aso_pdf/$cod_cliente/$arquivo");
	$mpdf->Output("aso_pdf/$cod_cliente/$arquivo",'F');
	}else{
    $mpdf->Output("aso_pdf/$cod_cliente/$arquivo",'F');
	}
	$mpdf->Output("$arquivo",'I');

    /*
    I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
    D: send to the browser and force a file download with the name given by filename.
    F: save to a local file with the name given by filename (may include a path).
    S: return the document as a string. filename is ignored.
    */
    exit();
//}else{
    echo $code;
//}
?> 