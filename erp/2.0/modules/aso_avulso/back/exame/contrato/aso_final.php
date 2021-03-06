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
$cod_cliente = (int)(base64_decode($_GET[cod_cliente]));
$setor = (int)(base64_decode($_GET[setor]));
$funcionario = (int)(base64_decode($_GET[funcionario]));
$aso = (int)(base64_decode($_GET[aso]));
$code     = "";
$header_h = 175;//header height;
$footer_h = 170;//footer height;
$meses    = array('', 'Janeiro',  'Fevereiro', 'Mar?o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m        = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");

/******************** DADOS **********************/
if (!empty($funcionario) and !empty($aso)){
        $query_func = "SELECT f.cod_func, f.nome_func, f.num_ctps_func, f.serie_ctps_func, f.cbo, f.dinamica_funcao, f.rg, f.cpf -- funcion?rio
        , a.cod_aso, a.tipo_exame, a.aso_resultado, a.aso_data, a.obs -- aso
        , c.cliente_id, c.razao_social, c.endereco, c.cep, c.cnpj, c.num_end -- cliente
        , ca.cnae_id, ca.cnae, ca.grau_risco -- cnae
        , cl.classificacao_atividade_id, cl.nome_atividade -- classificacao_atividade
        , rc.risco_id, rc.nome -- risco cliente
        , fu.cod_funcao, fu.nome_funcao -- funcao

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
            f.cod_func = $funcionario
        AND a.cod_aso = $aso
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
	$affs = "select * from aso where cod_aso = $aso and cod_func = $funcionario";
	$aff = pg_query($affs);
	$fdp = pg_fetch_array($aff);
}
/*****************************************************************************************************************/
// -> BEGIN DOCUMENT
/*****************************************************************************************************************/
ob_start();
    /*************************************************************************************************************/
    // -> HEADER
    /*************************************************************************************************************/
    if($_GET[sem_timbre]){
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h> </td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h valign=top width=270><img src='"._IMG_PATH."logo_sesmt.png' width='270' height='135'></td>";
        $cabecalho .= "<td align=center height=$header_h valign=top class='medText'>Servi?os Especializados de Seguran?a e<br>Monitoramento de Atividades no Trabalho<br>CNPJ:04.722.248/0001-17 Insc. Mun.311.213-6<p>M?dico Coordenador do PCMSO:<br>Maria de Lourdes Fernandes Magalh?es<br>CRMEJ 52.33.471-0 Reg. MTE 13.320</td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/
    //assinatura
    /*if($_GET[sem_assinatura])
        $rodape  = "";
    else
        $rodape  = "<div style=\"position: relative; text-align: right; width: 100%\"><img src='"._IMG_PATH."ass_medica.png' border=0 width='180' height='110'></div>";
*/
    if($_GET[sem_timbre]){
        $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
        $rodape .= "<td align=left height=$footer_h> </td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }else{
        $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
        $rodape .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 7844 9394 / Id 55*23*31368<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
        $rodape .= "<td align=right height=$footer_h width=207 valign=bottom><img src='"._IMG_PATH."logo_sesmt2.png' width=207 height=135></td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }
    if($_GET[html]){
        $code .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
    }
    $code .= "<html>";
    $code .= "<head>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body style=\"display: inline\">";

/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
    $code .= "<div class='mainTitle' align=center><b>ASO - Atestado de Sa?de Ocupacional</b></div>";
	$code .= "<div align=center><b>Conforme NR 7.4.1</b></div>";
    $code .= "<p align=justify>";
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
	$code .= "<td width=10% class='text'><b>N? ASO:</b></td>";
	$code .= "<td width=10% class='text'><b>Cliente:</b></td>";
    $code .= "<td class='text'><b>Raz?o social:</b></td>";
    $code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td class='text'>".str_pad($row_func[cod_aso], "4", "0", "")."</td>";
	$code .= "<td class='text'>".str_pad($row_func[cliente_id], "4", "0", "")."</td>";
    $code .= "<td class='text'>".addslashes($row_func[razao_social])."</td>";
    $code .= "</tr>";
	$code .= "</table>";
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
	$code .= "<td width=55% class='text'><b>Endere?o:</b></td>";
	$code .= "<td width=20% class='text'><b>CEP:</b></td>";
	$code .= "<td class='text'><b>CNPJ:</b></td>";
    $code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td class='text'>$row_func[endereco], $row_func[num_end]</td>";
	$code .= "<td class='text'>$row_func[cep]</td>";
	$code .= "<td class='text'>$row_func[cnpj]</td>";
    $code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td width=25% class='text'><b>CNAE:</b></td>";
    $code .= "<td width=25% class='text'><b>Grau de Risco:</b></td>";
	$code .= "<td class='text'><b>Tipo de Exame:</b></td>";
    $code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td class='text'>$row_func[cnae]</td>";
    $code .= "<td class='text'>".str_pad($row_func[grau_risco], "2", "0", "")."</td>";
	$code .= "<td class='text'>$row_func[tipo_exame]</td>";
    $code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td width=70% class='text'><b>Nome do Funcion?rio:</b></td>";
	if($row_func[num_ctps_func] != ""){
		$code .= "<td width=15% class='text'><b>CTPS:</b></td>";
		$code .= "<td class='text'><b>S?rie:</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td class='text'>$row_func[nome_func]</td>";
		$code .= "<td class='text'>$row_func[num_ctps_func]</td>";
		$code .= "<td class='text'>$row_func[serie_ctps_func]</td>";
		$code .= "</tr>";
	}elseif($row_func[rg] != ""){
		//$code .= "<td width=15% class='text'><b>CTPS:</b></td>";
		$code .= "<td class='text'><b>RG:</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td class='text'>$row_func[nome_func]</td>";
		$code .= "<td class='text'>$row_func[rg]</td>";
		//$code .= "<td class='text'>$row_func[serie_ctps_func]</td>";
		$code .= "</tr>";
	}else{
		//$code .= "<td width=15% class='text'><b>CTPS:</b></td>";
		$code .= "<td class='text'><b>CPF:</b></td>";
		$code .= "</tr>";
		$code .= "<tr>";
		$code .= "<td class='text'>$row_func[nome_func]</td>";
		$code .= "<td class='text'>$row_func[cpf]</td>";
		//$code .= "<td class='text'>$row_func[serie_ctps_func]</td>";
		$code .= "</tr>";
	}
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td width=10% class='text'><b>CBO:</b></td>";
    $code .= "<td width=20% class='text'><b>Fun??o:</b></td>";
	$code .= "<td class='text'><b>Atividade Laborativa:</b></td>";
    $code .= "</tr>";
	$code .= "<tr>";
	$code .= "<td class='text'>$row_func[cbo]</td>";
    $code .= "<td class='text'>$row_func[nome_funcao]</td>";
	$code .= "<td class='text'>$row_func[dinamica_funcao]</td>";
    $code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td width=50% class='text'><b>Classifica??o da Atividade:</b></td>";
    $code .= "<td width=50% class='text'><b>N?vel de Toler?ncia:</b></td>";
    $code .= "</tr>";
	$code .= "<tr>";	
	$code .= "<td class='text'>$row_func[nome_atividade]</td>";
    $code .= "<td class='text'>$row_func[nome]</td>";
    $code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td width=30% class='text'><b>Risco da Fun??o:</b></td>";
    $code .= "<td width=30% class='text'><b>Riscos Espec?ficados:</b></td>";
	$code .= "<td class='text'><b>Exames Realizados:</b></td>";
    $code .= "</tr>";
	$code .= "<tr>";
		// SELE??O DOS RISCOS DA FUN??O.
		if( !empty($funcionario) and !empty($aso) ){
		$query_risco="SELECT distinct(nome_tipo_risco)
					  FROM tipo_risco tr, risco_setor rs, agente_risco ar, cliente c, aso a, funcionarios f
					  WHERE ar.cod_agente_risco = rs.cod_agente_risco
					  AND ar.cod_tipo_risco = tr.cod_tipo_risco
					  AND c.cliente_id = rs.cod_cliente
					  AND a.cod_cliente = c.cliente_id
					  AND rs.cod_setor = f.cod_setor
					  AND a.cod_aso = $aso
					  AND f.cod_func = $funcionario 
					  AND f.cod_cliente = $cod_cliente
					  AND f.cod_setor = $setor order by nome_tipo_risco";
		$result_risco=pg_query($query_risco);
		
		$code .= "<td class='text'>";			
		while($row_risco=pg_fetch_array($result_risco)){ 
			$code .= "$row_risco[nome_tipo_risco] <br> ";
		}
		$code .= "</td>";
		} //Fim da Sele??o
		
		//ESPECIFICAR OS RISCOS DA FUN??O.
		if( !empty($funcionario) and !empty($aso) ){
		$query_agente="SELECT distinct(nome_agente_risco)
					   FROM tipo_risco tr, risco_setor rs, agente_risco ar, cliente c, aso a, funcionarios f
					   WHERE ar.cod_agente_risco = rs.cod_agente_risco
					   AND ar.cod_tipo_risco = tr.cod_tipo_risco
					   AND c.cliente_id = rs.cod_cliente
					   AND a.cod_cliente = c.cliente_id
					   AND rs.cod_setor = f.cod_setor
					   AND a.cod_aso = $aso
					   AND f.cod_func = $funcionario
					   AND f.cod_cliente = $cod_cliente
					   AND f.cod_setor = $setor order by nome_agente_risco";
		$result_agente=pg_query($query_agente);

		$code .= "<td class='text'>";
		while($row_agente=pg_fetch_array($result_agente)){ 
			$code .= "$row_agente[nome_agente_risco] <br>";
		}
		$code .= "</td>";
		} //FIM DA SELE??O
		
		//SELE??O DOS EXAMES COMPLEMENTARES.
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
					  AND f.cod_cliente = $cod_cliente
					  AND f.cod_setor = $setor order by especialidade";
		$result_exame=pg_query($query_exame);
		
		$code .= "<td class='text'>";
			$code .= "<Table border=0 width=100%>";			
			while($row_exame=pg_fetch_array($result_exame)){ 
				$code .= "<tr><td class='text'>";
					$code .= "$row_exame[especialidade]";
				$code .= "</td><td class='text'>";
					$code .= date("d/m/Y", strtotime($row_exame[data]));
				$code .= "</td></tr>";
			}
			$code .= "</table>";
		$code .= "</td>";
		} //Fim da Sele??o
    $code .= "</tr>";
	$code .= "</table>";
	
	//ESTA CONSULTA S? ACONTECER? PARA UM CLIENTE ESPEC?FICO
	$sc = "SELECT * FROM aso_exame WHERE cod_aso = $_GET[aso]";
	$rsc = pg_query($sc);
	$ce = pg_fetch_array($rsc);
	
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td align=justify class='text'>Atesto para os fins do artigo 168 da lei 6.514/77 e port. 3.214/78 SSMT N?24 de 29/12/94 e despacho SSMT n?8 de 01/10/96, NR7 - PCMSO, que: o funcion?rio como acima qualificado, encontra-se <b>$row_func[aso_resultado]</b> mediante ter sido aprovado nos exames f?sicos e psicol?gicos.";
		/*if(pg_num_rows($rsc) == 1 and $ce[cod_exame] == 22){
			$code .= "Dependendo apenas dos exames complementares acima quando solicitados, para diagnostica??o do m?dico coordenador dos programas de PCMSO - NR7, de responsabilidade do empregador realiz?-los e remeter ao m?dico examinador o(s) original(is), em at? o 10? dia ?til da avalia??o f?sica. Este ASO(atestado de sa?de ocupacional) s? ser? v?lido para efeito de fiscaliza??o e ou judicialmente se acompanhado dos exames complementares sempre que for solicitado pelo m?dico examinador.";
		}else{
		
		}*/
	$code .= "</td>";
    $code .= "</tr>";
	if($row_func[aso_resultado] == "Inapto" || $row_func[aso_resultado] == "Apto com Restri??o"){
		$code .= "<tr><td align=left class='text'> {$row_func[obs]} </td></tr>";
	}
	$code .= "<tr>";
	$code .= "<td class='text'><b>Data de Realiza??o:&nbsp;</b>".date("d/m/Y", strtotime($row_func[aso_data]))."</td>";
    $code .= "</tr>";
	$code .= "</table>";
	$code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";	
	$code .= "<td width=50% class='text'>_________________________________</td>";
    $code .= "<td width=50% class='text'>"; if(!$_GET[sem_timbre]){	$code .= "<img src='"._IMG_PATH."assinatura.png'/>"; } $code .= "</td>";
    $code .= "</tr>";
	$code .= "<tr>";	
	$code .= "<td class='text'>Assinatura do Examinado</td>";
    $code .= "<td class='text'>Assinatura do Examinador</td>";
    $code .= "</tr>";
	$code .= "</table>";
	
    $code .= "<div class='pagebreak'></div>";

ob_end_clean();

/*****************************************************************************************************************/
// -> OUTPUT
/*****************************************************************************************************************/
if(!$_GET[html]){
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
    $stylesheet = file_get_contents('../style.css');
    //incorporar folha de estilos ao documento
    $mpdf->WriteHTML($stylesheet,1);
    // incorpora o corpo ao PDF na posi??o 2 e dever? ser interpretado como footage. Todo footage ? posicao 2 ou 0(padr?o).
    $mpdf->WriteHTML($code);
    //void WriteHTML ( string $html [, int $mode [, boolean $initialise  [, boolean $close ]]])
    //MODE Values
    //0 - Parses a whole html document
    //1 - Parses the html as styles and stylesheets only
    //2 - Parses the html as output elements only
    //3 - (For internal use only - parses the html code without writing to document)
    //4 - (For internal use only - writes the html code to a buffer)
    //DEFAULT: 0
    //nome do arquivo de saida PDF
    $arquivo = $cod_cgrt.'_'.date("ymdhis").'.pdf';
    //gera o relatorio
    if($_GET[out] == 'D'){
        $mpdf->Output($arquivo,'D');
    }else{
        $mpdf->Output($arquivo,'I');
    }
    /*
    I: send the file inline to the browser. The plug-in is used if available. The name given by filename is used when one selects the "Save as" option on the link generating the PDF.
    D: send to the browser and force a file download with the name given by filename.
    F: save to a local file with the name given by filename (may include a path).
    S: return the document as a string. filename is ignored.
    */
    exit();
}else{
    echo $code;
}

?> 