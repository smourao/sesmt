<?php
//include "../sessao.php";
include "../config/connect.php";

if(isset($_GET['y'])){
    $ano = $_GET['y'];
}else{
    $ano = date("Y");
}

$cliente = $_GET["cliente"];

/**********************PÁGINA 2**************************/
if($cliente != "" ){
	$rela = "SELECT c.*, cs.*, cnae
			FROM cliente_setor cs, cliente c, cnae cn, setor s
			WHERE cs.cod_cliente = c.cliente_id
			AND s.cod_setor = cs.cod_setor
			AND c.cnae_id = cn.cnae_id
			AND cs.id_ppra = $_GET[id_ppra]";
	$resu = pg_query($connect, $rela) or die
		("ERRO NA QUERY: $rela ==>".pg_last_error($connect));
	$row = pg_fetch_array($resu);
}

/*************NÚMERO DE FUNCIONÁRIOS DA TABELA CGRT*****************/
$num = "select f.cod_func, nome_func 
		from funcionarios f, cgrt_func_list l
		where f.cod_cliente = $cliente
		and f.cod_func = l.cod_func
		and cod_cgrt = $_GET[id_ppra]";
$res = pg_query($num);
$sm = pg_num_rows($res);

/*************SETOR ADMINISTRATIVO************/
$adm = "SELECT cod_func, tipo_setor FROM cliente_setor cs, cgrt_func_list l 
		WHERE cs.id_ppra = $_GET[id_ppra]
		AND cs.id_ppra = l.cod_cgrt
		AND cs.cod_cliente = l.cod_cliente
		AND cs.cod_setor = l.cod_setor
		AND	tipo_setor = 'Administrativo'";
$result = pg_query($adm);
$nadm = pg_num_rows($result);

/*************SETOR OPERACIONAL************/
$ope = "SELECT cod_func, tipo_setor FROM cliente_setor cs, cgrt_func_list l
		WHERE cs.id_ppra = $_GET[id_ppra]
		AND cs.id_ppra = l.cod_cgrt
		AND cs.cod_cliente = l.cod_cliente
		AND cs.cod_setor = l.cod_setor
		AND	tipo_setor = 'Operacional'";
$result = pg_query($ope);
$nope = pg_num_rows($result);

/************PÁGINA 8 *****************/
$ativ = "SELECT cs.cod_ppra, cs.cod_cliente, cs.cod_setor, s.nome_setor, s.desc_setor, tp.descricao, p.descricao_piso,
		pa.decicao_parede, co.decicao_cobertura, ln.descricao_luz_nat, la.decricao_luz_art, vn.decricao_vent_nat,
		va.decricao_vent_art, cs.epc_existente, cs.epc_sugerido
		FROM cliente_setor cs, setor s, cliente c, tipo_edificacao tp, piso p, parede pa, cobertura co,
		luz_natural ln, luz_artificial la, ventilacao_natural vn, ventilacao_artificial va
		WHERE cs.cod_cliente = c.cliente_id
		AND cs.cod_setor = s.cod_setor
		AND tp.tipo_edificacao_id = cs.cod_edificacao
		AND p.cod_piso = cs.cod_piso
		AND pa.cod_parede = cs.cod_parede
		AND co.cod_cobertura = cs.cod_cobertura
		AND ln.cod_luz_nat = cs.cod_luz_nat
		AND la.cod_luz_art = cs.cod_luz_art
		AND vn.cod_vent_nat = cs.cod_vent_nat
		AND va.cod_vent_art = cs.cod_vent_art
		AND cs.id_ppra = $_GET[id_ppra]";
$r_ativ = pg_query($connect, $ativ) or die
	("ERRO NA QUERY: $ativ ==>".pg_last_error($connect));
$row_ativ = pg_fetch_all($r_ativ);

/*************QUANTIDADE DE FUNCIONÁRIOS MASCULINOS************/
$masc = "SELECT sexo_func
		FROM funcionarios f, cgrt_func_list l
		WHERE f.cod_cliente = $_GET[cliente]
		AND cod_cgrt = $_GET[id_ppra]
		AND f.cod_func = l.cod_func
		AND sexo_func = 'Masculino'";
$result = pg_query($masc);
$nmasc = pg_num_rows($result);

/*************QUANTIDADE DE FUNCIONÁRIOS FEMININOS************/
$fem = "SELECT sexo_func
		FROM funcionarios f, cgrt_func_list l
		WHERE f.cod_cliente = $_GET[cliente]
		AND cod_cgrt = $_GET[id_ppra]
		AND f.cod_func = l.cod_func
		AND sexo_func = 'Feminino'";
$result = pg_query($fem);
$nfem = pg_num_rows($result);

/******************VALORAÇÃO QUANTITATIVA***************/
$vr = "SELECT s.nome_setor, ln.descricao_luz_nat, la.decricao_luz_art, cs.data_avaliacao, i.lux_atual,
		i.lux_recomendado, i.exposicao, i.movel, i.numero, f.cod_func, f.nome_func, s.cod_setor
		FROM cliente_setor cs, setor s, luz_natural ln, luz_artificial la, iluminacao_ppra i, funcionarios f, cgrt_func_list l
		WHERE cs.cod_setor = s.cod_setor
		AND (i.cod_setor = l.cod_setor OR l.setor_adicional like '%'||cs.cod_setor||'%')
		AND i.cod_setor = cs.cod_setor
		AND ln.cod_luz_nat = cs.cod_luz_nat
		AND la.cod_luz_art = cs.cod_luz_art
		AND i.cod_cliente = cs.cod_cliente
		AND f.cod_func = l.cod_func	
		AND i.cod_func = f.cod_func
		AND f.cod_cliente = i.cod_cliente
		AND cs.id_ppra = i.id_ppra
		AND i.id_ppra = l.cod_cgrt
		AND l.cod_cgrt = {$_GET[id_ppra]}";
$res_vr = pg_query($connect, $vr);
$row_vr = pg_fetch_all($res_vr);

?>