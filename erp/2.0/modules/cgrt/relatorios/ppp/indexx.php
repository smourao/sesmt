<?php
define('_MPDF_PATH', '../../../../common/MPDF45/');
define('_IMG_PATH', '../../../../images/');
include(_MPDF_PATH.'mpdf.php');
include("../../../../common/database/conn.php");
/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$code     = "";
$header_h = 130;//header height; 175
$footer_h = 170;//footer height;
$meses    = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m        = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");
$title    = "PERFIL PROFISSIOGRÁFICO PREVIDENCIÁRIO";

$cliente = (int)(base64_decode($_GET["cliente"]));
$setor	 = (int)(base64_decode($_GET["setor"]));
$func	 = (int)(base64_decode($_GET["funcionario"]));
$cod_cgrt = (int)(base64_decode($_GET["cod_cgrt"]));

//Cliente info
$sql = "SELECT cgrt.*, c.*, cnae.* FROM cgrt_info cgrt, cliente c, cnae cnae 
		WHERE cgrt.cod_cgrt = $cod_cgrt AND cgrt.cod_cliente = c.cliente_id AND c.cnae_id = cnae.cnae_id";
$rci = pg_query($sql);
$info = pg_fetch_array($rci);

//Func list
$sql = "SELECT cfl.*,f.*, fun.* FROM cgrt_func_list cfl, funcionarios f, funcao fun
		WHERE cfl.cod_cgrt = $cod_cgrt AND f.cod_cliente = cfl.cod_cliente AND f.cod_func = cfl.cod_func
		AND fun.cod_funcao = cfl.cod_funcao AND cfl.status = 1 ORDER BY f.nome_func";
$rfl = pg_query($sql);
$funclist = pg_fetch_all($rfl);

//Efetivo masculino
$sql = "SELECT count(*) as nfuncmasc FROM funcionarios f, cgrt_func_list l 
		WHERE f.cod_cliente = ".(int)($info[cliente_id])." AND l.cod_cgrt = ".(int)($cod_cgrt)." AND f.cod_func = l.cod_func 
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

if($cliente != "" and $func != "" ){
	$ppp = "SELECT c.*, f.*, s.nome_setor, fu.nome_funcao, fu.dsc_funcao, cn.cnae
			FROM cliente c, cnae cn, funcionarios f, setor s, funcao fu
			WHERE c.cliente_id = f.cod_cliente
			AND s.cod_setor = f.cod_setor
			AND f.cod_funcao = fu.cod_funcao
			AND cn.cnae_id = c.cnae_id
			AND f.cod_func = $func
			AND c.cliente_id = $cliente";
	$res = pg_query($ppp);
	$row = pg_fetch_array($res);
}

//BUSCA DADOS DA EXAMINADORA
if($cliente != ""){
	$busca = "SELECT admissao, nome, ctps, email, demissao
			  FROM funcionario
			  WHERE funcionario_id = 21";
	$r = pg_query($connect, $busca);
	$rr = pg_fetch_array($r);
}

//BUSCA OS FATORES DE RISCO REALIZADOS DA II SEÇÃO 1ª PARTE
if($cliente != "" and $func != "" ){
	$exames = "SELECT Distinct(nome_tipo_risco) as nome
			FROM tipo_risco tp, agente_risco ar, risco_setor rs, funcionarios f, cliente_setor cs
			WHERE rs.cod_cliente = f.cod_cliente
			AND rs.cod_setor = f.cod_setor
			AND tp.cod_tipo_risco = ar.cod_tipo_risco
			AND ar.cod_agente_risco = rs.cod_agente_risco
			AND rs.cod_cliente = cs.cod_cliente
			AND rs.cod_setor = cs.cod_setor
			AND rs.cod_cliente = $cliente
			AND f.cod_func = $func";
	$resul = pg_query($connect, $exames);
	$r_resul = pg_fetch_all($resul);
}

//BUSCA OS FATORES DE RISCO REALIZADOS DA II SEÇÃO 2ª PARTE
if($cliente != "" and $func != "" ){
	$exame = "SELECT itensidade, epc_eficaz, ca
			FROM tipo_risco tp, agente_risco ar, risco_setor rs, funcionarios f, cliente_setor cs
			WHERE rs.cod_cliente = f.cod_cliente
			AND rs.cod_setor = f.cod_setor
			AND tp.cod_tipo_risco = ar.cod_tipo_risco
			AND ar.cod_agente_risco = rs.cod_agente_risco
			AND rs.cod_cliente = cs.cod_cliente
			AND rs.cod_setor = cs.cod_setor
			AND rs.cod_cliente = $cliente
			AND f.cod_func = $func";
	$result = pg_query($connect, $exame);
	$r_res = pg_fetch_all($result);
}

//BUSCA A MONITORAÇÃO BIOLÓGICA DA III SEÇÃO
if($cliente != "" and $func != "" ){
	$risco = "SELECT e.especialidade, a.tipo_exame, ae.data
			   FROM aso_exame ae, aso a, exame e, cliente c, funcionarios f
			   WHERE ae.cod_exame = e.cod_exame
			   AND a.cod_func = f.cod_func
			   AND c.cliente_id = f.cod_cliente
			   AND a.cod_cliente = c.cliente_id
			   AND ae.cod_aso = a.cod_aso
			   AND c.cliente_id = $cliente
			   AND a.cod_func = $func
			   ORDER BY ae.data";
	$resu = pg_query($connect, $risco);
	$r_resu = pg_fetch_all($resu);
}

//CONSULTA PARA VERIFICAR SE O EPI É EFICAZ
if($cliente != "" and $setor != "" ){
	$epi = "select s.* 
			from setor_epi se, sugestao s, cliente_setor cs
			where cs.cod_cliente = s.cod_cliente
			and cs.cod_setor = s.cod_setor
			and s.cod_setor = se.cod_setor
			and s.med_prev = se.id
			and s.cod_cliente = $cliente
			and s.cod_setor = $setor";
	$res_epi = pg_query($connect, $epi);
	$row_epi = pg_fetch_array($res_epi);
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
        $cabecalho .= "<td align=left height=$header_h valign=top width=270><img src='"._IMG_PATH."logo_sesmt.png' width='270' height='135'></td>";
        $cabecalho .= "<td align=center height=$header_h valign=top class='medText'>Serviços Especializados de Segurança e<br>Monitoramento de Atividades no Trabalho<p>Assistência em Segurança e Higiene no Trabalho</td>";
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
        $rodape  = "<div style=\"position: relative; text-align: right; width: 100%\"><img src='"._IMG_PATH."carimbo_assin_pedro.png' border=0 width='180' height='100'></div>";
        //$rodape  = "<div style=\"position: relative; text-align: right; width: 100%\"><img src='http://sesmt-rio.com/erp/img/ass_everaldo.PNG' border=0 width='180' height='110'></div>";
        

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
        $rodape .= "<td align=right height=$footer_h width=207 valign=bottom><img src='"._IMG_PATH."logo_sesmt2.png' width=207 height=135></td>";
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
    $code .= "<td>Área contruída: </td><td>{$info[frente]}</td>";
    $code .= "</tr><tr>";
    $code .= "<td>Pé direito da área contruída: </td><td>{$info[pe_direito]}</td>";
    $code .= "</tr>";
    $code .= "</table>";

    $code .= "<div class='pagebreak'></div>";

/****************************************************************************************************************/
// -> PAGE [3]
/****************************************************************************************************************/
	
	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="center" width="20" class="fontepreta12bold">I</td>
		<td align="left" width="679" class="fontepreta12bold">&nbsp;Seção de Dados Administrativos</td>
	</tr>
</table><p>
';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="250" class="fontepreta12">&nbsp;1-CNPJ do Domicílio Tributário/CEI<br>&nbsp;'.$row[cnpj].'</td>
		<td align="left" width="350" class="fontepreta12">&nbsp;2-Nome Empresarial<br>&nbsp;'.$row[razao_social].'</td>
		<td align="left" width="99" class="fontepreta12">&nbsp;3-CNAE<br>&nbsp;'.$row[cnae].'</td>
	</tr>
</table><p>
';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="500" class="fontepreta12">&nbsp;4-Nome do Trabalhador<br>&nbsp;'.$row[nome_func].'</td>
		<td align="left" width="99" class="fontepreta12">&nbsp;5-BR/PDH<br>&nbsp;'.$row[pdh].'</td>
		<td align="left" width="100" class="fontepreta12">&nbsp;6-NIT<br>&nbsp;'.$row[pis].'</td>
	</tr>
</table><p>
';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" width="150" class="fontepreta12">&nbsp;7-Data de Nascimento<br>&nbsp;'.$row[data_nasc_func].'</td>
		<td align="left" width="90" class="fontepreta12">&nbsp;8-Sexo (M/F)<br>&nbsp;'.$row[sexo_func].'</td>
		<td align="left" width="150" class="fontepreta12">&nbsp;9-CTPS (Nº, Série e UF)<br>&nbsp;'.$row[num_ctps_func].'-Série '.$row[serie_ctps_func].'-UF '.$row[estado].'</td>
		<td align="left" width="145" class="fontepreta12">&nbsp;10-Data de Admissão<br>&nbsp;'.$row[data_admissao_func].'</td>
		<td align="left" width="164" class="fontepreta12">&nbsp;11-Regime de Revezamento<br>&nbsp;'.$row[revezamento].'</td>
	</tr>
</table><p>
';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="4" width="699" class="fontepreta12">&nbsp;12-CAT Registrada</td>
	</tr>
	<tr>
		<td align="left" width="175" class="fontepreta12">&nbsp;12.1-Data de Registro</td>
		<td align="left" width="175" class="fontepreta12">&nbsp;12.2-Número da CAT</td>
		<td align="left" width="174" class="fontepreta12">&nbsp;12.1-Data do Registro</td>
		<td align="left" width="174" class="fontepreta12">&nbsp;12.2-Número da CAT</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">&nbsp;</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
		<td align="left" class="fontepreta12">&nbsp;</td>
	</tr>
</table><p>
';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="7" width="699" class="fontepreta12">&nbsp;13-Lotação e Atribuição</td>
	</tr>
	<tr>
		<td align="left" width="90" class="fontepreta12">&nbsp;13.1-Período</td>
		<td align="left" width="100" class="fontepreta12">&nbsp;13.2-CNPJ/CEI</td>
		<td align="left" width="100" class="fontepreta12">&nbsp;13.3-Setor</td>
		<td align="left" width="117" class="fontepreta12">&nbsp;13.4-Cargo</td>
		<td align="left" width="117" class="fontepreta12">&nbsp;13.5-Função</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;13.6-CBO</td>
		<td align="left" width="95" class="fontepreta12">&nbsp;13.7-Cód. GFIP</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">';
		 ?>
		<?php 
		if($row[cod_status] == '0'){
			$dat = explode('/', $row[data_admissao_func]);
			$code .= $row[data_admissao_func].' à '.$row[data_desligamento_func];
		}else{
			$dat = explode('/', $row[data_admissao_func]);
			$code .= $row[data_admissao_func];
		}
		?>
		<?php 
			$code .= '</td>
		<td align="left" class="fontepreta12">&nbsp;'.$row[cnpj].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$row[nome_setor].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$row[nome_funcao].'</td>
		<td align="left" class="fontepreta12">&nbsp;'.$row[nome_funcao].'</td>
		<td align="center" class="fontepreta12">&nbsp;'.$row[cbo].'</td>
		<td align="center" class="fontepreta12">&nbsp;'.$row[grau_de_risco].'</td>
	</tr>
</table><p>
';

	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="2" width="699" class="fontepreta12">&nbsp;14-Profissiografia</td>
	</tr>
	<tr>
		<td align="left" width="90" class="fontepreta12">&nbsp;14.1-Período</td>
		<td align="left" width="608" class="fontepreta12">&nbsp;14.2-Descrção das Atividades</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">';
		?>
		<?php 
		if($row[cod_status] == "0"){
			$dat = explode("/", $row[data_admissao_func]);
				echo $row[data_admissao_func]." à ".$row[data_desligamento_func];
		}else{
			$dat = explode("/", $row[data_admissao_func]);
				echo $row[data_admissao_func];
		}?>
		<?php 
	$code .= '</td>
		<td align="justify" class="fontepreta12">&nbsp;'.$row[dsc_funcao].'</td>
	</tr>
</table><p>
';


	$code .= '<table align="center" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
	<tr>
		<td align="left" colspan="8" width="699" class="fontepreta12">&nbsp;15-Exposição a Fatores de Riscos</td>
	</tr>
	<tr>
		<td align="left" width="90" class="fontepreta12">&nbsp;15.1-Período</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.2-Tipo</td>
		<td align="left" width="115" class="fontepreta12">&nbsp;15.3-Fator de Risco</td>
		<td align="left" width="85" class="fontepreta12">&nbsp;15.4-Itens./Conc.</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.5-Téc. Utilizada</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.6-EPC Eficaz(S/N)</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.7-EPI Eficaz(S/N)</td>
		<td align="left" width="80" class="fontepreta12">&nbsp;15.8-CA EPI</td>
	</tr>
	<tr>
		<td align="left" class="fontepreta12">';
		?>
		<?php if($row[cod_status] == "0"){
			$dat = explode("/", $row[data_admissao_func]);
				$code .= $row[data_admissao_func]." à ".$row[data_desligamento_func];
		}else{
			$dat = explode("/", $row[data_admissao_func]);
				$code .= $row[data_admissao_func];
		}
		?>
		<?php 
		$code .= '
		</td>
		<td align="center" class="fontepreta12">' 
		?>
		<?php 
		for($x=0; $x<pg_num_rows($resul); $x++){ $code .= substr($r_resul[$x][nome],0,1)."&nbsp;"; } 
		?>
		<?php $code .= '
		</td>
		<td align="center" class="fontepreta12">';
		?>
		<?php 
		for($y=0; $y<pg_num_rows($resul); $y++){ $code .= $r_resul[$y][nome]."<br>"; } 
		?>
		<?php $code .= '
		</td>
		<td align="left" class="fontepreta12">&nbsp;'.$r_res[0][itensidade].'</td>
		<td align="left" class="fontepreta12">&nbsp;Avaliado por aparelhos de medição</td>
		<td align="center" class="fontepreta12">&nbsp;'.$r_res[0][epc_eficaz].'</td>
		<td align="center" class="fontepreta12">&nbsp;';
		?>
		<?php 
		if($row_epi[plano_acao] == 1){ echo "Sim"; }else{ echo "Não";} 
		?>
		<?php 
		$code .= '
		</td>
		<td align="center" class="fontepreta12">&nbsp;'.$r_res[0][ca].'</td>
	</tr>
</table><p>
';


    $code .= "<div class='pagebreak'></div>";

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
