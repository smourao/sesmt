<?PHP
include "../config/connect.php";
/*
SELECT * FROM sugestao WHERE cod_cliente = 210 AND extract(year FROM data) = '2010'
SELECT * FROM aso_exame WHERE cod_aso in (select cod_aso from aso where cod_cliente = 210 AND extract(year FROM data) = '2010')
SELECT * FROM aso WHERE cod_cliente = 210 AND extract(year FROM aso_data) = '2010'
SELECT * FROM risco_setor WHERE cod_cliente = 210 AND extract(year FROM data) = '2010'
SELECT * FROM cliente_setor WHERE cod_cliente = 210 AND extract(year FROM data_criacao) = '2010'
SELECT * FROM extintor WHERE cod_cliente = 210 AND extract(year FROM data) = '2010'
SELECT * FROM ppra_placas WHERE cod_cliente = 210 AND extract(year FROM data) = '2010'
*/

$ano = $_GET[year];
$cod_cliente = $_GET[cod_cliente];
$newy = $_GET[newy];

$sql = "SELECT MAX(cod_ppra) as maxppra FROM cliente_setor";
$r = pg_query($sql);
$cod_ppra = pg_fetch_array($r);
$cod_ppra = $cod_ppra[maxppra] + 1;

$sql = "SELECT MAX(id_ppra) as maxid FROM cliente_setor";
$ra = pg_query($sql);
$id_ppra = pg_fetch_array($ra);
$id_ppra = $id_ppra[maxid] + 1;

$sql = "SELECT * FROM cliente_setor WHERE cod_cliente = $cod_cliente AND extract(year FROM data_criacao) = '{$ano}'";
$res = pg_query($sql);
$cs  = pg_fetch_all($res);
//echo "CLIENTE_SETOR<BR>";
for($x=0;$x<pg_num_rows($res);$x++){
    $sql = "INSERT INTO cliente_setor
    (cod_cliente, cod_setor, cod_luz_nat, cod_luz_art, cod_vent_nat, cod_vent_art, cod_edificacao, cod_piso, cod_parede, cod_cobertura, observacao_setor, umidade, temperatura, pavimentos, altura, frente, comprimento, tipo_setor, ruido_fundo_setor, data_avaliacao, hora_avaliacao, ruido_operacao_setor, cod_filial, tipo_hidrante_id, diametro_mangueira_id, quantidade_mangueira, esguicho, chave_stors, pl_ident, demarcacao, porta_cont_fogo, tipo_sistema_fixo_contra_incendio_id, tipo_para_raio_id, alarme_contra_incendio_id, qtd_esquicho, qtd_raio, sprinkler, detector, registro, repor, mang_reposta, bulbos, qtd_porta, cod_ppra, epc_existente, epc_sugerido, termico, metragem, ruido, data_criacao, estado_abrigo, estado_mang, dt_ventilacao, degraus, largura, fita, rabica, gripal, tanica, vistoria, higiene, jornada, num_aparelhos, proxima_limpeza_mecanica, marca, ultima_limpeza_duto, proxima_limpeza_duto, modelo, capacidade, empresa_servico, epc_eficaz, ca, data_limpeza_filtros, cod_orcamento, id_ppra)
    values
    ('{$cs[$x][cod_cliente]}', '{$cs[$x][cod_setor]}', '{$cs[$x][cod_luz_nat]}', '{$cs[$x][cod_luz_art]}', '{$cs[$x][cod_vent_nat]}', '{$cs[$x][cod_vent_art]}', '{$cs[$x][cod_edificacao]}', '{$cs[$x][cod_piso]}', '{$cs[$x][cod_parede]}', '{$cs[$x][cod_cobertura]}', '{$cs[$x][observacao_setor]}', '{$cs[$x][umidade]}', '{$cs[$x][temperatura]}', '{$cs[$x][pavimentos]}', '{$cs[$x][altura]}', '{$cs[$x][frente]}', '{$cs[$x][comprimento]}', '{$cs[$x][tipo_setor]}', '{$cs[$x][ruido_fundo_setor]}', '{$cs[$x][data_avaliacao]}', '{$cs[$x][hora_avaliacao]}', '{$cs[$x][ruido_operacao_setor]}', '1', '0', '0', '{$cs[$x][quantidade_mangueira]}', '{$cs[$x][esguicho]}', '{$cs[$x][chave_stors]}', '{$cs[$x][pl_ident]}', '{$cs[$x][demarcacao]}', '{$cs[$x][porta_cont_fogo]}', '0', '0', '0', '{$cs[$x][qtd_esquicho]}', '{$cs[$x][qtd_raio]}', '{$cs[$x][sprinkler]}', '{$cs[$x][detector]}', '{$cs[$x][registro]}', '{$cs[$x][repor]}',
    '{$cs[$x][mang_reposta]}', '{$cs[$x][bulbos]}', '{$cs[$x][qtd_porta]}',
    '{$cod_ppra}',
    '{$cs[$x][epc_existente]}', '{$cs[$x][epc_sugerido]}',
    '{$cs[$x][termico]}', '{$cs[$x][metragem]}', '{$cs[$x][ruido]}',
    '$newy/".date("m/d")."',
    '{$cs[$x][estado_abrigo]}', '{$cs[$x][estado_mang]}', null, '{$cs[$x][degraus]}', '{$cs[$x][largura]}', '{$cs[$x][fita]}', '{$cs[$x][rabica]}', '{$cs[$x][gripal]}', '{$cs[$x][tanica]}', null, '{$cs[$x][higiene]}', '{$cs[$x][jornada]}', '{$cs[$x][num_aparelhos]}', null, '{$cs[$x][marca]}', null, null, '{$cs[$x][modelo]}', '{$cs[$x][capacidade]}', '{$cs[$x][empresa_servico]}', '{$cs[$x][epc_eficaz]}', '{$cs[$x][ca]}', null,
    null, '{$id_ppra}')";
    pg_query($sql);
}

//echo "<P>";
//echo "RISCO_SETOR<BR>";
$sql = "SELECT * FROM risco_setor WHERE cod_cliente = $cod_cliente AND extract(year FROM data) = '$ano'";
$res = pg_query($sql);
$rs  = pg_fetch_all($res);

for($x=0;$x<pg_num_rows($res);$x++){
    $sql = "INSERT INTO risco_setor
    (cod_cliente, cod_setor, cod_agente_risco, fonte_geradora, cod_tipo_contato, cod_agente_contato, nivel, itensidade, danos_saude, escala_acao, acao_necessaria, diagnostico, preventiva, acidente, corretiva, data)
    VALUES
    ('{$rs[$x][cod_cliente]}', '{$rs[$x][cod_setor]}', '{$rs[$x][cod_agente_risco]}', '{$rs[$x][fonte_geradora]}', '{$rs[$x][cod_tipo_contato]}', '{$rs[$x][cod_agente_contato]}', '{$rs[$x][nivel]}', '{$rs[$x][itensidade]}', '{$rs[$x][danos_saude]}', '{$rs[$x][escala_acao]}', '{$rs[$x][acao_necessaria]}', '{$rs[$x][diagnostico]}', '{$rs[$x][preventiva]}', '{$rs[$x][acidente]}', '{$rs[$x][corretiva]}', '$newy/".date("m/d")."')";
    pg_query($sql);
}

//echo "<P>";
//echo "SUGESTAO<BR>";
$sql = "SELECT * FROM sugestao WHERE cod_cliente = $cod_cliente AND extract(year FROM data) = '$ano'";
$res = pg_query($sql);
$sug = pg_fetch_all($res);
for($x=0;$x<pg_num_rows($res);$x++){
    if(empty($sug[$x][cod_produto]))
        $sug[$x][cod_produto] = 0;
    if(empty($sug[$x][quantidade]))
        $sug[$x][quantidade] = 0;
    $sql = "INSERT INTO sugestao
    (cod_setor, cod_cliente, cod_funcao, cod_filial, med_prev, plano_acao, data, cod_produto, quantidade, cod_ppra)
    VALUES
    ('{$sug[$x][cod_setor]}', '{$sug[$x][cod_cliente]}', '{$sug[$x][cod_funcao]}', '1', '{$sug[$x][med_prev]}', '{$sug[$x][plano_acao]}', '$newy/".date("m/d")."', '{$sug[$x][cod_produto]}', '{$sug[$x][quantidade]}', '{$cod_ppra}')";
    pg_query($sql);
}

//echo "<P>";
//echo "EXTINTOR<BR>";
$sql = "SELECT * FROM extintor WHERE cod_cliente = $cod_cliente AND extract(year FROM data) = '$ano'";
$res = pg_query($sql);
$ext = pg_fetch_all($res);
for($x=0;$x<pg_num_rows($res);$x++){
    $sql = "INSERT INTO extintor
    (extintor, tipo_extintor, qtd_extintor, data_recarga, numero_cilindro, vencimento_abnt, proxima_carga, placa_sinalizacao_id, demarcacao_solo_id, tipo_instalacao_id, empresa_prestadora, cod_setor, cod_cliente, f_inspecao, cod_produto, data)
    VALUES
    ('{$ext[$x][extintor]}', '{$ext[$x][tipo_extintor]}', '{$ext[$x][qtd_extintor]}', '{$ext[$x][data_recarga]}', '{$ext[$x][numero_cilindro]}', '{$ext[$x][vencimento_abnt]}', '{$ext[$x][proxima_carga]}', '{$ext[$x][placa_sinalizacao_id]}', '{$ext[$x][demarcacao_solo_id]}', '{$ext[$x][tipo_instalacao_id]}', '{$ext[$x][empresa_prestadora]}', '{$ext[$x][cod_setor]}', '{$ext[$x][cod_cliente]}', '{$ext[$x][f_inspecao]}', '{$ext[$x][cod_produto]}', '$newy/".date("m/d")."')";
    pg_query($sql);
}

//echo "<P>";
//echo "PPRA_PLACAS<BR>";
$sql = "SELECT * FROM ppra_placas WHERE cod_cliente = $cod_cliente AND extract(year FROM data) = '$ano'";
$res = pg_query($sql);
$pla = pg_fetch_all($res);
for($x=0;$x<pg_num_rows($res);$x++){
    $sql = "INSERT INTO ppra_placas
    (descricao, quantidade, cod_prod, legenda, cod_cliente, cod_setor, data)
    VALUES
    ('{$pla[$x][descricao]}', '{$pla[$x][quantidade]}', '{$pla[$x][cod_prod]}', '{$pla[$x][legenda]}', '{$pla[$x][cod_cliente]}', '{$pla[$x][cod_setor]}', '$newy/".date("m/d")."')";
    pg_query($sql);
}

//echo "<P>";
//echo "ASO<BR>";
$sql = "SELECT * FROM aso WHERE cod_cliente = $cod_cliente AND extract(year FROM aso_data) = '$ano'";
$res = pg_query($sql);
$aso = pg_fetch_all($res);
for($x=0;$x<pg_num_rows($res);$x++){
    $sql = "INSERT INTO aso
    (cod_aso, cod_cliente, cod_func, aso_resultado, aso_hora, risco_id, classificacao_atividade_id, tipo_exame, cod_setor, data_envio, enviado, aso_data)
    VALUES
    ('{$aso[$x][cod_aso]}', '{$aso[$x][cod_cliente]}', '{$aso[$x][cod_func]}', '{$aso[$x][aso_resultado]}', '{$aso[$x][aso_hora]}', '{$aso[$x][risco_id]}', '{$aso[$x][classificacao_atividade_id]}', '{$aso[$x][tipo_exame]}', '{$aso[$x][cod_setor]}', '{$aso[$x][data_envio]}', '{$aso[$x][enviado]}', '$newy/".date("m/d")."')";
    pg_query($sql);
}

//echo "<P>";
//echo "ASO_EXAME<BR>";
$sql = "SELECT * FROM aso_exame WHERE cod_aso in (select cod_aso from aso where cod_cliente = $cod_cliente AND extract(year FROM data) = '$ano')";
$res = pg_query($sql);
$aex = pg_fetch_all($res);
for($x=0;$x<pg_num_rows($res);$x++){
    $sql = "INSERT INTO aso_exame
    (cod_aso, cod_exame, data)
    VALUES
    ('{$aex[$x][cod_aso]}', '{$aex[$x][cod_exame]}', '$newy/".date("m/d")."')";
    pg_query($sql);
}
echo "<script>location.href='lista_ppra.php';</script>";
?>
