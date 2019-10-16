<?PHP

/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/
define('_MPDF_PATH', '../../../../common/MPDF45/');
define('_IMG_PATH', '../../../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../../../common/database/conn.php");

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = 2013;
}

/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$cod_cgrt = (int)(base64_decode($_GET[cod_cgrt]));
$code     = "";
$header_h = 130;//header height; 175
$footer_h = 170;//footer height;
$meses    = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m        = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
$title    = "LAUDO TÉCNICO DE CONDIÇÕES AMBIENTAIS DE TRABALHO";

/*****************************************************************************************************************/
// -> CGRT / CLIENTE INFO
/*****************************************************************************************************************/
//Cliente info
$sql = "SELECT cgrt.*, c.*, cnae.* FROM cgrt_info cgrt, cliente c, cnae cnae 
		WHERE cgrt.cod_cgrt = $cod_cgrt AND cgrt.cod_cliente = c.cliente_id AND c.cnae_id = cnae.cnae_id";
$rci = pg_query($sql);
$info = pg_fetch_array($rci);
$cliente = $info[cod_cliente];

//Func list
$sql = "SELECT cfl.*,f.*, fun.* FROM cgrt_func_list cfl, funcionarios f, funcao fun
		WHERE cfl.cod_cgrt = $cod_cgrt AND f.cod_cliente = cfl.cod_cliente AND f.cod_func = cfl.cod_func
		AND fun.cod_funcao = cfl.cod_funcao AND cfl.status = 1 ORDER BY f.nome_func";
$rfl = pg_query($sql);
$funclist = pg_fetch_all($rfl);

//Efetivo masculino
$sql = "SELECT count(*) as nfuncmasc FROM funcionarios f, cgrt_func_list l 
		WHERE f.cod_cliente = $cliente AND l.cod_cgrt = $cod_cgrt AND f.cod_func = l.cod_func 
		AND f.sexo_func = 'Masculino' AND l.status = 1";
$efetivo_masc = pg_fetch_array(pg_query($sql));
$efetivo_masc = (int)($efetivo_masc[nfuncmasc]);

//Efetivo feminino
$efetivo_fem = ((int)(pg_num_rows($rfl))-$efetivo_masc);
if($_GET[sem_assinatura]){
    $ass_elaborador  = "<BR><BR><BR><BR><BR><BR><BR>";
    $ass_responsavel = "<BR><BR><BR><BR><BR><BR><BR>";
}else{
    $ass_elaborador  = "<img src='../../../../images/diuliane_assinatura_carimbo.jpg' border='0'>";
    $ass_responsavel = "<img src='../../../../images/ass_pedro3.png' border='0'>";
}
$height = 1050;
$hei = 570;
$cli = "SELECT c.*, cs.* 
		FROM cliente c, cliente_setor cs
		WHERE c.cliente_id = cs.cod_cliente
		AND c.cliente_id = $cliente";
$cl = pg_query( $cli);
$clt = pg_fetch_array($cl);

/*************SETOR ADMINISTRATIVO************/
$adm = "SELECT cod_func, tipo_setor FROM cliente_setor cs, funcionarios f 
		WHERE cs.cod_cliente = $cliente
		and cs.cod_cliente = f.cod_cliente
		and cs.cod_setor = f.cod_setor
		AND	tipo_setor = 'Administrativo'";
$result = pg_query($adm);
$nadm = pg_num_rows($result);

/*************SETOR OPERACIONAL************/
$ope = "SELECT cod_func, tipo_setor FROM cliente_setor cs, funcionarios f 
		WHERE cs.cod_cliente = $cliente
		and cs.cod_cliente = f.cod_cliente
		and cs.cod_setor = f.cod_setor
		AND	tipo_setor = 'Operacional'";
$result = pg_query($ope);
$nope = pg_num_rows($result);

function coloca_zeros($numero){
echo str_pad($numero, 2, "0", STR_PAD_LEFT);
}

function zeros($num){
echo str_pad($num, 3, "0", STR_PAD_LEFT);
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
        $cabecalho .= "<td align=left height=$header_h valign=top width=270>&nbsp;</td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h valign=top width=270><img src='"._IMG_PATH."logo_novo_sesmt.png' width='800' height='135'></td>";
        
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/
    //assinatura
    if($_GET[sem_assinatura])
        $rodape  = "";
    else
        $rodape  = "<div style=\"position: relative; text-align: right; width: 100%\"><img src='"._IMG_PATH."ass_medica.png' border=0 width='180' height='100'></div>";

    if($_GET[sem_timbre]){
        $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
		$rodape .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304 Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
        $rodape .= "<td align=left height=$footer_h width=207 valign=bottom>&nbsp;</td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }else{
        $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
        $rodape .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304 Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
        $rodape .= "<td align=right height=$footer_h width=207 valign=bottom><img src='"._IMG_PATH."logo_novo_sesmt2.png' width=207 height=135></td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }
	
    $code .= "<html>";
    $code .= "<head>";
    $code .= '<link href="../style.css" rel="stylesheet" type="text/css"/>';
    $code .= "</head>";
    $code .= "<body>";

/****************************************************************************************************************/
// -> PAGE [1]
/****************************************************************************************************************/

    $code .= "<BR><p><BR>";
    $code .= "<center><div class='mainTitle'><b>".$info[razao_social]."</b></div></center>";
    $code .= "<BR><p>";
    $code .= "<table align=center width=100% border=0><tr><td align=center><img src='"._IMG_PATH."uno_top.jpg' border=0></td></tr></table>";
    $code .= "<BR><p>";
    $code .= "<center><div class='bigTitle'><b>$title</b></div></center>";
    $code .= "<BR><p><BR>";
    $code .= "<center><div class='mainTitle'>ANO $info[ano]</div></center>";
    $code .= "<center><b>LEI 6.514 Dez / 77<BR>PORTARIA 3.214 Jul / 78<BR>NR 9 - MTE</b></center>";
    $code .= "";
    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/

    $code .= "<br><p>";
	$code .= "<div class='mainTitle'><b>EMPRESA</b></div>";
    $code .= "<BR><p align=justify>";
    $code .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $code .= "<tr>";
    $code .= "<td>Número do contrato:</td><td>{$info[ano_contrato]}/".str_pad($info[cliente_id], 4, "0",0)."</td>";
    $code .= "</tr><tr>";
    $dt = explode("/", $info[data_avaliacao]);
    $code .= "<td>Número do programa:</td><td>{$info[cod_ppra]}/{$info[ano]}</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Razão social:</td><td>$info[razao_social]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Endereço: </td><td>$info[endereco], $info[num_end]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Bairro: </td><td>$info[bairro]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Estado: </td><td>$info[estado]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Cidade: </td><td>$info[municipio]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>CEP: </td><td>$info[cep]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Telefone: </td><td>$info[telefone]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Fax: </td><td>$info[fax]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>CNPJ/CEI: </td><td>$info[cnpj]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Ramo de Atividade: </td><td>$info[descricao]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>CNAE: </td><td>$info[cnae]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Grau de risco: </td><td>$info[grau_risco]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Responsável: </td><td>$info[nome_contato_dir]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Contador: </td><td>$info[nome_contador]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Telefone: </td><td>$info[tel_contador]</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Efetivo geral: </td><td>".str_pad(pg_num_rows($rfl), 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
	
    $sql = "SELECT count(*) as n, tipo_setor FROM cliente_setor cs, cgrt_func_list l
            WHERE cs.id_ppra = ".(int)($cod_cgrt)." AND cs.id_ppra = l.cod_cgrt AND cs.cod_setor = l.cod_setor AND l.status = 1
            GROUP BY tipo_setor ORDER BY tipo_setor";
    $rne = pg_query($sql);
    $efetivo_por_setor = pg_fetch_all($rne);
	
    $ef_admn = 0;
    $ef_oper = 0;
    for($i=0;$i<pg_num_rows($rne);$i++){
        if(strtolower($efetivo_por_setor[$i][tipo_setor]) == 'operacional')
            $ef_oper = (int)($efetivo_por_setor[$i][n]);
        elseif(strtolower($efetivo_por_setor[$i][tipo_setor]) == 'administrativo')
            $ef_admn = (int)($efetivo_por_setor[$i][n]);
    }

    $code .= "<td>Efetivo no setor administrativo: </td><td>".str_pad($ef_admn, 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Efetivo no setor operacional: </td><td>".str_pad($ef_oper, 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Efetivo Masculino: </td><td>".str_pad($efetivo_masc, 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Efetivo Feminino: </td><td>".str_pad($efetivo_fem, 2, "0", 0)."</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Jornada de trabalho: </td><td>{$info[jornada]} horas</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Área total(aproximadamente): </td><td>{$info[comprimento]}</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Área construída: </td><td>{$info[frente]}</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Pé direito da área contruída: </td><td>{$info[pe_direito]}</td>";
    $code .= "</tr>";
    $code .= "</table>";
    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/

// -> PAGE [3]

/****************************************************************************************************************/

$code .='<table align="center" width="700" height="$height" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
	<td class="tabela" valign="top">
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center"><h2>INTRODUÇÃO AO LTCAT<p>LAUDO TÉCNICO DE CONDIÇÕES AMBIENTAIS DE TRABALHO</h2></td>
		</tr>
		</table><p><br><br>

		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="justify" class="fontepreta12">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O laudo técnico das condições ambientais de trabalho visa avaliar, analisar e relatar os níveis de ruídos quer sejam contínuo ou intermitente; e os níveis de exposição por parte dos trabalhadores aos agentes nocivos prejudiciais a saúde e/ou a integridade física do ser humano.<p><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A avaliação Quantitativa de ruídos deverá estar sempre de acordo com o estabelecido pela Portaria 3.214 de 08 de junho de 1978 na NR - Norma Regulamentadora de número 15 (NR 15) Anexo I, contida no Decreto Lei 6.514, de 22 de dezembro de 1977, no seu cap. V do titulo II da CLT Consolidação das Leis Trabalhistas.<p><br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A avaliação Quantitativa das atividades será de acordo com a mesma Portaria 3.214 de 08 de Junho de 1978, na NR Norma Regulamentadora de número 15 (NR 15) nos Anexos 11 e 13, onde são estabelecidos procedimentos aos Agentes Químicos e ACGIH.
			</td>
		</tr>
		</table>

    </td> </tr>
</table>';

$code .= "<div class='pagebreak'></div>";

//<!---------------------QUADRO I--------------->

$quadro = "SELECT p.nome_piso, pa.nome_parede, pa.decicao_parede, co.nome_cobertura, va.nome_vent_art, vn.nome_vent_nat,
			la.nome_luz_art, ln.nome_luz_nat, s.nome_setor, cs.tipo_setor, cs.jornada, cs.cod_setor, s.desc_setor
			FROM cliente_setor cs, piso p, parede pa, cobertura co, ventilacao_artificial va, ventilacao_natural vn,
			luz_artificial la, luz_natural ln, setor s
			WHERE cs.cod_piso = p.cod_piso
			AND cs.cod_parede = pa.cod_parede
			AND cs.cod_cobertura = co.cod_cobertura
			AND cs.cod_vent_art = va.cod_vent_art
			AND cs.cod_vent_nat = vn.cod_vent_nat
			AND cs.cod_luz_art = la.cod_luz_art
			AND cs.cod_luz_nat = ln.cod_luz_nat
			AND cs.cod_setor = s.cod_setor
			AND cs.cod_cliente = $cliente
			AND extract(year from cs.data_criacao) = {$ano}";
$qd = pg_query( $quadro);
$qdo = pg_fetch_all($qd);
for($x=0;$x<pg_num_rows($qd);$x++){

$code .='<table align="center" width="700" height="$height;" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
	<td class="tabela" valign="top">

		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta14bold"><h3>QUADRO I DE AVALIAÇÕES QUANTITATIVAS</h3><br>&nbsp;</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">O local onde estamos avaliando trata-se de uma área constituída de:</td>
		</tr>
		</table>
		
		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="left" class="fontepreta12" width="250">&nbsp;<b>Revestimesnto do Solo:</b></td>
			<td align="left" class="fontepreta12" width="430">&nbsp;'.$qdo[$x][nome_piso].'</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">&nbsp;<b>Parede:</b></td>
			<td align="left" class="fontepreta12">&nbsp;'.$qdo[$x][nome_parede].'</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">&nbsp;<b>Revestimesnto das Paredes:</b></td>
			<td align="left" class="fontepreta12">&nbsp;'.$qdo[$x][decicao_parede].'</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">&nbsp;<b>Cobertura:</b></td>
			<td align="left" class="fontepreta12">&nbsp;'.$qdo[$x][nome_cobertura].'</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">&nbsp;<b>Tipo de Ventilação:</b></td>
			<td align="left" class="fontepreta12">&nbsp;'.$qdo[$x][nome_vent_art].'/'.$qdo[$x][nome_vent_nat].'</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">&nbsp;<b>Tipo de Iluminação:</b></td>
			<td align="left" class="fontepreta12">&nbsp;'.$qdo[$x][nome_luz_art].'/'.$qdo[$x][nome_luz_nat].'</td>
		</tr>
		</table><p>

		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta12bold" width="160">Setor</td>
			<td align="center" class="fontepreta12bold" width="90">Rotina</td>
			<td align="center" class="fontepreta12bold" width="90">Carga Horária</td>
			<td align="center" class="fontepreta12bold" width="170">Agente</td>
			<td align="center" class="fontepreta12bold" width="170">Atividades Desenvolvidas</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12">'.$qdo[$x][nome_setor].'</td>
			<td align="left" class="fontepreta12">'.$qdo[$x][tipo_setor].'</td>
			<td align="left" class="fontepreta12">'.$qdo[$x][jornada].'&nbsp;</td>
			<td align="left" class="fontepreta12">';

			$bat = "SELECT distinct(ag.nome_agente_risco)
					FROM cliente_setor cs, agente_risco ag, risco_setor rs
					WHERE cs.cod_setor = {$qdo[$x][cod_setor]}
					AND cs.cod_cliente = rs.cod_cliente
					AND rs.cod_agente_risco = ag.cod_agente_risco
					AND cs.cod_cliente = $cliente
					AND extract(year from cs.data_criacao) = {$ano}";
			$cel = pg_query( $bat);
			$bc = pg_fetch_all($cel);
			for($w=0;$w<pg_num_rows($cel);$w++){
				$code.= $bc[$w][nome_agente_risco];
				if($w<pg_num_rows($cel)-1) echo "; ";
			}

			$code.= '</td>
			<td align="left" class="fontepreta12">'.$qdo[$x][desc_setor].'</td>
		</tr>
		</table><p>';

		/*************QUANTIDADE DE FUNCIONÁRIOS NO SETOR************/

		$set = "SELECT * FROM funcionarios f, cgrt_func_list l 
				WHERE f.cod_cliente = $cliente AND l.cod_cgrt = $cod_cgrt AND f.cod_func = l.cod_func 
				AND l.status = 1 AND {$qdo[$x][cod_setor]} = f.cod_setor";
		$rset = pg_query($set);
		$et = pg_num_rows($rset);

		/*************QUANTIDADE DE FUNCIONÁRIOS MASCULINOS************/

		$masc = "SELECT * FROM funcionarios f, cgrt_func_list l 
				WHERE f.cod_cliente = $cliente AND l.cod_cgrt = $cod_cgrt AND f.cod_func = l.cod_func 
				AND f.sexo_func = 'Masculino' AND l.status = 1 AND {$qdo[$x][cod_setor]} = f.cod_setor";
		$result1 = pg_query($masc);
		$nmasc = pg_num_rows($result1);

		/*************QUANTIDADE DE FUNCIONÁRIOS FEMININOS************/

		$fem = "SELECT * FROM funcionarios f, cgrt_func_list l 
				WHERE f.cod_cliente = $cliente AND l.cod_cgrt = $cod_cgrt AND f.cod_func = l.cod_func 
				AND f.sexo_func <> 'Masculino' AND l.status = 1 AND {$qdo[$x][cod_setor]} = f.cod_setor";
		$result2 = pg_query($fem);
		$nfem = pg_num_rows($result2);
		$code.= '<table align="center" width="690" border="0">

		<tr>
			<td align="center" class="fontepreta12" width="200"><b>Efetivo Setor</b></td>
			<td align="center" class="fontepreta12" width="200"><b>Efetivo Masculino</b></td>
			<td align="center" class="fontepreta12" width="200"><b>Efetivo Feminino</b></td>
		</tr>
		<tr>
			<td style="border: 1px solid #000000;" align="center" class="fontepreta12"> '.$et.'</td>
			<td style="border: 1px solid #000000;" align="center" class="fontepreta12">'.$nmasc.'</td>
			<td style="border: 1px solid #000000;" align="center" class="fontepreta12">'.$nfem.'</td>
		</tr>
		</table>
		
		<tr>
			<td class="tabela" valign="bottom">
			</td>
		</tr>
    </td> </tr>
</table>';

} 

$code .= "<div class='pagebreak'></div>";

//<!---------------------QUADRO II--------------->

$quadro2 = "select a.nome_agente_risco, r.fonte_geradora, r.diagnostico, r.acao_necessaria, r.corretiva
			from setor s, risco_setor r, cliente_setor c, agente_risco a
			where r.cod_cliente = c.cod_cliente
			AND r.cod_setor = c.cod_setor
			and r.cod_setor = s.cod_setor
			and r.cod_agente_risco = a.cod_agente_risco
			AND EXTRACT(year FROM data_criacao) = EXTRACT(year FROM data)
			and r.cod_cliente = $cliente
			AND EXTRACT(year FROM c.data_criacao) = {$ano}";
$qua = pg_query( $quadro2);
$quad = pg_fetch_all($qua);
$dim = array();

for($x=0;$x<pg_num_rows($qua);$x++){

$di = '<tr>
			<td align=left class=fontepreta12>'.$quad[$x][nome_agente_risco].'&nbsp;</td>
			<td align=left class=fontepreta12>'.$quad[$x][fonte_geradora].'&nbsp;</td>
			<td align=left class=fontepreta12>'.$quad[$x][diagnostico].'&nbsp;</td>
			<td align=left class=fontepreta12>'.$quad[$x][acao_necessaria].'&nbsp;</td>
			<td align=left class=fontepreta12>'.$quad[$x][corretiva].'&nbsp;</td>
		</tr>';

$dim[] = addslashes($di);

}

	$code.='
		<table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta14bold"><h3>QUADRO II DE DESCRIÇÕES QUALITATIVAS</h3></td>
		</tr>
		</table><p><br>

		<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta12" width="15%"><b>Agentes Nocivos</b></td>
			<td align="center" class="fontepreta12" width="15%"><b>Causas</b></td>
			<td align="center" class="fontepreta12" width="25%"><b>Possiveis Danos a Saúde</b></td>
			<td align="center" class="fontepreta12" width="25%"><b>Medidas de Controle</b></td>
			<td align="center" class="fontepreta12" width="20%"><b>Primeiros Socorros</b></td>
		</tr>';
for ($y=0;$y<ceil(count($dim)/5);$y++) {
		$i = $y*5;
			for($x=$i;$x<$i+5;$x++){ 
			   $code.= $dim[$x];			
			}
 }
    $code .= "</table>";
    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [x]
/****************************************************************************************************************/
//<!---------------------METODOLOGIA--------------->
$code.='<table align="center" width="700" height="$height" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
	<td class="tabela" valign="top">
	
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
		<td align="center"><h2>METODOLOGIA APLICADA NA AVALIAÇÃO DOS NÍVEIS DE RUÍDOS</h2></td>
		</tr>
		</table><p><br><br>';

		$apa = "SELECT nome_aparelho, modelo_aparelho, marca_aparelho
				FROM cliente_setor cs, setor s, aparelhos a
				WHERE cs.ruido = a.cod_aparelho
				AND cs.cod_setor = s.cod_setor
				AND cs.cod_cliente = $cliente
				AND EXTRACT(year FROM data_criacao) = {$ano}";
		$par = pg_query( $apa);
		$ap = pg_fetch_array($par);

$code.='<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
			<tr>
				<td align="justify" class="fontepreta12">
				
				<b>RUÍDO</b><P>
				&bull; Medições em decibéis(dB), com o instrumento operado no circuito de compensação “A” e circuito de resposta lento (SLOW), à leitura e feita próximo ao ouvido do trabalhador e nos locais considerados como de maior permanência do mesmo.<p><br>
				<b>CONFORMIDADE</b><p>
				&bull; Anexo 1, item 2 da NR 15 Portaria 3214  de 08/06/78 – MTB.<br>
				&bull; NHT – 06 R/E – Norma para avaliação de exposição ocupacional ao ruído da Fundacentro.<p><br>
				
				<b>APARELHOS UTILIZADOS</b><p>
				&bull; Medidor de nível de pressão sonora('.$ap[nome_aparelho].')  marca '.$ap[marca_aparelho].' – modelo '.$ap[modelo_aparelho].' – tipo 2 escalas. 80-130, db (ANSI) e 50-100 db (IEC).<p><br>

				<b>METODOLOGIA</b><p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Com base no cronograma da empresa. Foram subdivididos os postos de trabalho e as funções, em cada posto de trabalho foi feitos os reconhecimentos das medidas de controles existentes, o número de empregados expostos, o turno de trabalho, a jornada de trabalho e a fonte gerada entre outros.<p>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Após o reconhecimento foi realizada a avaliação quantitativa de níveis de pressão sonora, de acordo com a necessidade de comprovação da exposição dos trabalhadores. As avaliações foram realizadas em dias selecionados aleatoriamente, em empregados e turnos de trabalhos diferentes. Em seguida foi realizada a média das doses obtidas e calculados os níveis equivalentes médios de ruídos LEQ db (A) para exposição diária.
				</td>
			</tr>
		</table>
    </td> </tr>
</table>';

//<!---------------------PRESSÃO SONORA--------------->
$ruido = "SELECT nome_setor, ruido_fundo_setor, ruido_operacao_setor
		FROM cliente_setor cs, setor s
		WHERE cs.cod_setor = s.cod_setor
		AND cs.cod_cliente = $cliente
		AND EXTRACT(year FROM data_criacao) = {$ano}";
$rui = pg_query( $ruido);
$ruid = pg_fetch_all($rui);
$rud = array();
for($x=0;$x<pg_num_rows($rui);$x++){
$rd = '<tr>
			<td align=center class=fontepreta12>'.$ruid[$x][nome_setor].'&nbsp;</td>
			<td align=center class=fontepreta12>'.$ruid[$x][ruido_operacao_setor].'&nbsp;</td>
			<td align=center class=fontepreta12>'.$ruid[$x][ruido_fundo_setor].'&nbsp;</td>
			<td align=center class=fontepreta12>'.$ruid[$x][ruido_fundo_setor].'&nbsp;</td>
			<td align=center class=fontepreta12>'.$ruid[$x][ruido_operacao_setor].'&nbsp;</td>
		</tr>';
$rud[] = addslashes($rd);
}
for ($y=0;$y<ceil(count($rud)/20);$y++) {
$code.='<table align="center" width="700" height="$height" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
	<td class="tabela" valign="top">
	
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta14bold"><h3>VALORIZAÇÃO DE PRESSÃO SONORA ENCONTRADAS</h3></td>
		</tr>
		</table><p><br>

		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta12" width="185"><b>Setor/Posto de Trabalho</b></td>
			<td align="center" class="fontepreta12" width="100"><b>Ruído db (A)</b></td>
			<td align="center" class="fontepreta12" width="100"><b>Ruído de Fundo</b></td>
			<td align="center" class="fontepreta12" width="100"><b>Ruído Mecânico</b></td>
			<td align="center" class="fontepreta12" width="100"><b>Ruído Motor</b></td>
		</tr>';

			$i = $y*20;
			for($x=$i;$x<$i+20;$x++){ 
			   $code.= $rud[$x];			
			}

		$code.='</table>
    </td> </tr>
</table>';
 }
     $code .= "<div class='pagebreak'></div>";
	 
/****************************************************************************************************************/
// -> PAGE [x]
/****************************************************************************************************************/
//<!---------------TEXTO------------->

$code.='<table align="center" width="700" height="$height" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
	<td class="tabela" valign="top">
	
		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="justify" class="fontepreta12">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Observa-se para as condições anteriores a tabela existente na legislação especifica na Lei 6.514 de 22 de Dezembro de 1977, incluída na CLT em seu CAP.V. e regulamentada pela Portaria 3.214 de 08 de Junho de 1978, na norma regulamentadora NR 15 em seu anexo I, que o (limite de tolerância para ruídos contínuos ou intermitentes). A legislação previdenciária definiu o limite de tolerância em 90 db.<p><br>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Durante visita técnica em quanto entrevista a empresa: <b> '.$clt[razao_social].'</b>, a saúde por parte dos funcionários. De acordo com a Portaria 3.751 de 23 de Novembro de 1990, NR 15 Anexo I, o limite de tolerância para ruídos contínuos e ou intermitentes para uma jornada de 08:00 horas diária é de 85 db (A). A legislação previdenciária definiu o limite de tolerância em 90 db.<p><br>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Não é permitida exposição a níveis de ruídos acima de 115 db (A) para indivíduos que não estejam adequadamente protegidos.<p><br>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os maquinários e equipamentos utilizados pelas empresas produzem ruídos que podem atingir níveis excessivos provocados a curto, médio e longo prazo que podem acarretar em sérios prejuízos a saúde.<p><br>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dependendo do tempo da exposição ao nível sonoro e da sensibilidade individual, as alterações auditivas poderão manifestar-se imediatamente ou se começará a perder a audição gradualmente.<p><br>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Quanto maior o nível de ruído, menor deverá ser o tempo de exposição ocupacional, a seguir os principais efeitos prejudiciais do ruído excessivo sobre o funcionário.

			</td>
		</tr>
		</table><p><br><br>

		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="left" class="fontepreta12" width="200"><b>&nbsp;Sobre o Sistema Nervoso</b></td>
			<td align="left" class="fontepreta12" width="485">&nbsp;Modificações das ondas eletroencefalográficas, fadigas, nervoso.</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>&nbsp;Aparelho Cardiovascular</b></td>
			<td align="left" class="fontepreta12">&nbsp;Hipertensão, Modificação do ritmo cardíaco, Modificação do calibre dos vasos sanguíneos.</td>
		</tr>
		<tr>
			<td align="left" class="fontepreta12"><b>&nbsp;Outros Efeitos</b></td>
			<td align="left" class="fontepreta12">&nbsp;Modificação do ritmo respiratório; Perturbações gastrintestinais; Diminuição da visão noturna; Dificuldade na percepção das cores; Perda temporária da capacidade auditiva.</td>
		</tr>
		</table>

</table>';

    $code .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [x]
/****************************************************************************************************************/



$code .= '<table align="center" width="700" height="$height" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">

	<tr>

		<td class="tabela" valign="top">

			

		</td>

	</tr>

	<tr>

	<td class="tabela" valign="top">

		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">

		<tr>

			<td align="center" class="fontepreta14bold"><h3>ATIVIDADES E OPERAÇÕES COM EXPOSIÇÃO A AGENTES NOCIVOS</h3></td>

		</tr>

		</table>

		<p><br><br>

		

		<table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">

		<tr>

			<td align="left" class="fontepreta12"><b>Temperaturas Extremas – Calor</b><br>&nbsp;</td>

		</tr>

		<tr>

			<td align="justify" class="fontepreta12">

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O critério para avaliação da exposição ocupacional ao calor consiste no uso de uma bateria de termômetros e no calculo do índice de bulbo úmido termômetro de globo (IBUTG), recomendado pela legislação brasileira no anexo 3 da NR 15, as medidas foram realizadas de acordo com a norma para avaliação da exposição ocupacional ao calor NHT-01 C / E elaborada pela Fundacentro.<br><br>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Os valores de IBUTG encontrados serão então comparados com os limites de tolerância estabelecidos pelo anexo 3 da NR 15, depois de serem caracterizadas a carga solar do ambiente e a taxa do metabolismo desprendida de acordo com o tipo de atividade estudada.<br><br>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A avaliação quantitativa de calor será efetuada apenas onde existe fonte de calor e exposição dos funcionários (setor operacional). Será utilizado nessa medição um termômetro de globo digital marca instrutherm, modelo TGD 200, com três ondas de temperatura: sonda de bulbo seco; sonda de bulbo úmido; e sonda de globo.<br><br>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As medidas serão efetuadas no local onde permanece o trabalho, a altura da região do corpo mais atingida.<br><br>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O cálculo do índice de bulbo úmido termômetro de globo (Ibutg) será definido pelas equações abaixo:<p><br>

			Ambiente interno ou externo sem carga solar:<br>Ibutg + 0,7 tbn + 0,2 tg<p>

			Ambientes externos com carga solar:<br>ibutg = 0,7 tbn + 0,1 tbs + 0,2 tg<p>

			onde:<br>tbn (temperatura de bulbo úmido natural).<br>tg  (temperatura de globo).<br>tbs (temperatura de bulbo seco).

			</td>

		</tr>

		</table></td>

		</tr>

		</table>';

		
    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/

// -> PAGE [x] IBUTG

/****************************************************************************************************************/

$code .= '<table align="center" width="700" height="$height" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
	<tr>
		<td class="tabela" valign="top"><table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta14bold"><h3>IBUTG DOS SETORES DA EMPRESA</h3></td>
		</tr>
		</table><p><br><br>

		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
		<tr>
			<td align="center" class="fontepreta12bold" colspan="4">Tabela de Tolerância de Exposição ao Calor em Regime de Trabalho</td>
		</tr>

		<tr>
			<td align="center" class="fontepreta12" width="40%"><b>Setor/Posto de Trabalho</b></td>
			<td align="center" class="fontepreta12" width="20%"><b>IBUTG medido</b></td>
			<td align="center" class="fontepreta12" width="20%"><b>IBUTG permitido</b></td>
			<td align="center" class="fontepreta12" width="20%"><b>Classificação das atividades</b></td>
		</tr>';
		
$ibutg = "SELECT cs.*, st.* FROM cliente_setor cs, setor st
 			WHERE cs.id_ppra = $cod_cgrt AND st.cod_setor = cs.cod_setor";
$ibut = pg_query($ibutg);
$ibu = pg_fetch_all($ibut);
	
for($x=0;$x<pg_num_rows($ibut);$x++){

	$ibutg = ( ( $ibu[$x][ibtug_t] * $ibu[$x][tempo_t] ) + ( $ibu[$x][ibtug_d] * $ibu[$x][tempo_d] ) ) / 60;
	
	$code.= '<tr>
				<td align="center" class="fontepreta12" width="40%">'.$ibu[$x][nome_setor].'</td>
				<td align="center" class="fontepreta12" width="20%">'.$ibu[$x][tempo_t].'</td>
				<td align="center" class="fontepreta12" width="20%">30,6</td>
				<td align="center" class="fontepreta12" width="20%">Desprezível</td>
			</tr>';

}

$code.= ' </table>
    </td> </tr>
</table>';

    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/

// -> PAGE [x]

/****************************************************************************************************************/



$code .= '<table align="center" width="700" height="$height" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">

	<tr>

		<td class="tabela" valign="top"><table align="center" width="690" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">

		<tr>

			<td align="center" class="fontepreta14bold"><h3>MEDIDAS PREVENTIVAS EXISTENTES</h3></td>

		</tr>

		</table><p><br><br>

		<table align="center" width="690" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">

		<tr>

			<td align="center" class="fontepreta12bold" colspan="4">Tabela de Tolerância de Exposição ao Calor em Regime de Trabalho</td>

		</tr>

		<tr>

			<td align="left" class="fontepreta12" width="300">Trabalho intermitente com períodos de descanso no próprio local de trabalho(por hora).</td>

			<td align="center" class="fontepreta12" width="385" colspan="3">Tipo de Atividade<p>Leve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Moderada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pesada</td>

		</tr>

		<tr>

			<td align="center" class="fontepreta12">Trabalho Contínuo</td>

			<td align="center" class="fontepreta12" width="125">Até 30,0</td>

			<td align="center" class="fontepreta12" width="125">Até 26,7</td>

			<td align="center" class="fontepreta12" width="125">Até 25,0</td>

		</tr>

		<tr>

			<td align="center" class="fontepreta12">45 min. De trabalho. e 15 minutos de descanso</td>

			<td align="center" class="fontepreta12">Até 30,1 à 30,6</td>

			<td align="center" class="fontepreta12">Até 26,8 à 28,0</td>

			<td align="center" class="fontepreta12">Até 25,1 à 25,9</td>

		</tr>

		<tr>

			<td align="center" class="fontepreta12">30 minutos de trabalho e 30 minutos de descanso</td>

			<td align="center" class="fontepreta12">Até 30,7 à 31,4</td>

			<td align="center" class="fontepreta12">Até 28,1 à 29,4</td>

			<td align="center" class="fontepreta12">Até 26,0 à 27,9</td>

		</tr>

		<tr>

			<td align="center" class="fontepreta12">15 minutos de trabalho e 45 minutos de descanso</td>

			<td align="center" class="fontepreta12">Até 31,5 à 32,2</td>

			<td align="center" class="fontepreta12">Até 29,5 à 31,1</td>

			<td align="center" class="fontepreta12">Até 28,0 à 30,0</td>

		</tr>

		<tr>

			<td align="center" class="fontepreta12">Não é permitido o trabalho, sem a adoção de medidas adequadas de controle.</td>

			<td align="center" class="fontepreta12">Acima de 32,2</td>

			<td align="center" class="fontepreta12">Acima de 31,1</td>

			<td align="center" class="fontepreta12">Acime de 30,0</td>

		</tr>

		</table>

		

		<tr>

			<td class="tabela" valign="bottom">

				

			</td>

		</tr>

    </td> </tr>

</table>';

    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/

// -> PAGE [x]

/****************************************************************************************************************/
$ltcat_sql = "SELECT c.cod_cgrt, c.cod_cliente, c.ltcat_conclusao, c.quimico, c.fisico, c.biologico, c.ergonomico, c.acidente, 
			r.cod_cliente, r.cod_agente_risco, 
			a.cod_agente_risco, 
			t.cod_tipo_risco, t.nome_tipo_risco 
			FROM cgrt_info c, 
			risco_setor r, 
			agente_risco a, 
			tipo_risco t 
			WHERE c.cod_cgrt = '$cod_cgrt' 
			AND c.cod_cliente = r.cod_cliente 
			AND r.cod_agente_risco = a.cod_agente_risco
			AND a.cod_tipo_risco = t.cod_tipo_risco  
			ORDER BY cod_tipo_risco
			";
			
$ltcat_query = pg_query($ltcat_sql);
$ltcat_array = pg_fetch_all($ltcat_query);

for($x=0;$x<=pg_num_rows($ltcat_query);$x++){
	if($ltcat_array[$x][cod_tipo_risco] != $ltcat_array[$x-1][cod_tipo_risco]){
		if($ltcat_array[$x][cod_tipo_risco] == '1'){
			$code .= '<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="left" class="fontepreta14bold"><h3>RISCOS FÍSICOS</h3></td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr height=50>
						<td width=20% align=left>Sim ( <b>X</b> )</td><td width=80% align=left>Não (  )</td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="center" class="fontepreta14bold"><h3>PARECER DE RISCOS FÍSICOS	</h3></td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0">
					<tr>
						<td align="justify" >'.$ltcat_array[$x][fisico].'</td>
					</tr>
					</table><p><p>';
		}
		if($ltcat_array[$x][cod_tipo_risco] == '2'){
			$code .= '<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="left" class="fontepreta14bold"><h3>RISCO QUÍMICOS</h3></td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr height=50>
						<td width=20% align=left>Sim ( <b>X</b> )</td><td width=80% align=left>Não (  )</td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="center" class="fontepreta14bold"><h3>PARECER DE RISCOS QUÍMICOS</h3></td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0">
					<tr>
						<td align="justify" >'.$ltcat_array[$x][quimico].'</td>
					</tr>
					</table><p><p>';
		}
		if($ltcat_array[$x][cod_tipo_risco] == '3'){
			$code .= '<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="left" class="fontepreta14bold"><h3>RISCOS BIOLÓGICOS</h3></td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr height=50>
						<td width=20% align=left>Sim ( <b>X</b> )</td><td width=80% align=left>Não (  )</td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="center" class="fontepreta14bold"><h3>PARECER DE RISCOS BIOLÓGICOS</h3></td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0">
					<tr>
						<td align="justify" >'.$ltcat_array[$x][biologico].'</td>
					</tr>
					</table><p><p>';
		}
		if($ltcat_array[$x][cod_tipo_risco] == '4'){
			$code .= '<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="left" class="fontepreta14bold"><h3>RISCOS ERGONÔMICOS</h3></td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr height=50>
						<td width=20% align=left>Sim ( <b>X</b> )</td><td width=80% align=left>Não (  )</td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="center" class="fontepreta14bold"><h3>PARECER DE RISCOS ERGONÔMICOS</h3></td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0">
					<tr>
						<td align="justify" >'.$ltcat_array[$x][ergonomico].'</td>
					</tr>
					</table><p><p>';
		}
		if($ltcat_array[$x][cod_tipo_risco] == '5'){
			$code .= '<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="left" class="fontepreta14bold"><h3>RISCOS DE ACIDENTES</h3></td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr height=50>
						<td width=20% align=left>Sim ( <b>X</b> )</td><td width=80% align=left>Não (  )</td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
					<tr>
						<td align="center" class="fontepreta14bold"><h3>PARECER DE RISCOS DE ACIDENTES</h3></td>
					</tr>
					</table><p>
					
					<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0">
					<tr>
						<td align="justify" >'.$ltcat_array[$x][acidente].'</td>
					</tr>
					</table><p><p>';
		}
	}
}

/*
$code .= '<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td align="left" class="fontepreta14bold"><h3>CONTATO COM AGENTES QUÍMICOS</h3></td>
		</tr>
		</table><p>
		
		<table align="center" width="80%" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr height=50>
			<td width=20% align=left>Sim (  )</td><td width=80% align=left>Não (  )</td>
		</tr>
		</table><p>
		
		<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td align="center" class="fontepreta14bold"><h3>PARECER DE CONTATO COM AGENTE QUÍMICO</h3></td>
		</tr>
		</table><p>
		
		<table align="center" width="80%" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td align="justify" ></td>
		</tr>
		</table><p><p>';

$code .= '<table align="center" width="80%" height="$height" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td align="left" class="fontepreta14bold"><h3>CONTATO COM AGENTES BIOLÓGICOS</h3></td>
		</tr>
		</table><p>
		
		<table align="center" width="80%" height="$height" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr height=50>
			<td width=20% align=left>Sim (  )</td><td width=80% align=left>Não (  )</td>
		</tr>
		</table><p>
		
		<table align="center" width="80%" height="$height" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td align="center" class="fontepreta14bold"><h3>PARECER DE CONTATO COM AGENTE BIOLÓGICO</h3></td>
		</tr>
		</table><p>
		
		<table align="center" width="80%" height="$height" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td align="justify" >O contato com o agente biológico se dá em pequena proporção, tornando
								assim baixa e sem concentração de riscos por parte biológica. 
			</td>
		</tr>
		</table><p>';
*/
		
$code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/

// -> PAGE [x]

/****************************************************************************************************************/

$code .= '<table align="center" width="80%" height="$height" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td align="left" class="fontepreta14bold"><h3>ANEXO I</h3></td>
		</tr>
		</table><p><p>
		
		<table align="center" width="80%" height="$height" border="0" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
		<tr>
			<td align="center" class="fontepreta14bold"><h3>CONCLUSÃO</h3></td>
		</tr>
		</table><p>
		
		<table align="center" width="80%" height="$height" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td align="justify" >'.$ltcat_array[0][ltcat_conclusao].'
			</td>
		</tr>
		</table><p><p><p><p><p><p>
		
		<table align="center" width="80%" border="0" bordercolor="#FFFFFF">
		<tr>
			<td align="center" class="fontepreta14bold"><img src="../../../../images/ass_medica2.png" border=0></td>
			<td align="center" class="fontepreta14bold"><img src="../../../../images/ass_pedro3.png" border=0></td>
		</tr>
		</table><p>

		';
		
	$sql = "SELECT * FROM cgrt_func_list WHERE cod_cgrt = ".(int)($_GET[cod_cgrt]);

    

    $res = pg_query($sql);

    $buffer = pg_fetch_all($res);
/****************************************************************************************************************/
// -> PAGE [X]
/****************************************************************************************************************/

ob_end_clean();



/*****************************************************************************************************************/

// -> OUTPUT

/*****************************************************************************************************************/

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

$stylesheet = file_get_contents('../style.css');

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

?>