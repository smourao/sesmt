<?PHP
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.

function ppra_progress_update($cod_cliente, $setor){
global $connect;

$sql = "UPDATE progresso_ppra SET progresso=".ppra_progress($cod_cliente, $setor)." WHERE
cod_cliente=$cod_cliente AND cod_setor=$setor";

if(pg_query($connect, $sql)){
    return true;
}else{
    return false;
}
}

function ppra_progress($cod_cliente, $setor){
global $connect;
$tela1 = 0;
$tela2 = 0;
$tela3 = 0;
$tela4 = 0;
$tela5 = 0;
/*************************************
 VERIFY PPRA PROGRESS 1
/*************************************/
$sql = "SELECT cs.cod_luz_nat, cs.cod_luz_art, cs.cod_vent_nat, cs.cod_vent_art, cs.cod_edificacao, cs.cod_piso,
 cs.cod_parede, cs.cod_cobertura FROM cliente_setor cs
 WHERE cs.cod_cliente = {$cod_cliente} AND
 cs.cod_setor = {$setor}";
$res = pg_query($connect, $sql);
$buff = pg_fetch_array($res);
for($x=0;$x<count($buff);$x++){
    if(!empty($buff[$x])){
        $tela1+=1;
    }
}
$tela1 = ($tela1 * 100) / 8;

/*************************************
 VERIFY PPRA PROGRESS 2
/*************************************/
$sql = "SELECT f.nome_func FROM funcionarios f
 WHERE f.cod_cliente = {$cod_cliente} AND
 f.cod_setor = {$setor}";
$res = pg_query($connect, $sql);
$buff = pg_fetch_all($res);

if(count($buff)>0){$tela2=100;}else{$tela2=0;}

/*************************************
 VERIFY PPRA PROGRESS 3
/*************************************/
$sql = "SELECT cs.data_avaliacao, cs.hora_avaliacao FROM cliente_setor cs
 WHERE cs.cod_cliente = {$cod_cliente} AND
 cs.cod_setor = {$setor}";
$res = pg_query($connect, $sql);
$buff = pg_fetch_array($res);
for($x=0;$x<count($buff);$x++){
    if(!empty($buff[$x])){
        $tela3+=1;
    }
}
$tela3 = ($tela3 * 100) / 2;

/*************************************
 VERIFY PPRA PROGRESS 4
/*************************************/
$sql = "SELECT rs.cod_agente_risco FROM risco_setor rs
 WHERE rs.cod_cliente = {$cod_cliente} AND
 rs.cod_setor = {$setor}";
$res = pg_query($connect, $sql);
$buff = pg_fetch_array($res);
for($x=0;$x<count($buff);$x++){
    if(!empty($buff[$x])){
        $tela4+=1;
    }
}
$tela4 = ($tela4 * 100) / 1;

/*************************************
 VERIFY PPRA PROGRESS 5
/*************************************/
$sql = "SELECT rs.cod_sugestao FROM sugestao rs
 WHERE rs.cod_cliente = {$cod_cliente} AND
 rs.cod_setor = {$setor}";
$res = pg_query($connect, $sql);
$buff = pg_fetch_array($res);
for($x=0;$x<count($buff);$x++){
    if(!empty($buff[$x])){
        $tela5+=1;
    }
}
$tela5 = ($tela5 * 100) / 1;
$progresso = ($tela5+$tela4+$tela3+$tela2+$tela1)/5;
return $progresso;
}

?>
