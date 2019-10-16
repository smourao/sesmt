<?PHP
$host="postgresql02.sesmt-rio.com";
$user="sesmt_rio";
$pass="diggio3001";
$db="sesmt_rio";
$connect = pg_connect("host=$host dbname=$db user=$user password=$pass");

$sql = "SELECT id_ppra FROM cliente_setor GROUP BY id_ppra ORDER BY id_ppra";
$res = pg_query($sql);
$grp = pg_fetch_all($res);

for($x=0;$x<pg_num_rows($res);$x++){
    $sql = "SELECT * FROM cliente_setor WHERE id_ppra = {$grp[$x][id_ppra]}";
    $data = pg_fetch_all(pg_query($sql));
    
    $jornada = explode(":", $data[0][id_ppra]);
    $jornada = (int)($jornada[0]);
    
    $ano = date("Y", strtotime($data[0][data_criacao]));
    
    $sql = "INSERT INTO cgrt_info
    (cod_cgrt, cod_cliente, jornada, ano, data_criacao, id_resp_ppra, id_resp_pcmso, cod_ppra)
    VALUES
    ({$data[0][id_ppra]},{$data[0][cod_cliente]},$jornada,$ano,'{$data[0][data_criacao]}',
    {$data[0][funcionario_id]},{$data[0][elaborador_pcmso]},{$data[0][cod_ppra]})
    ";
    pg_query($sql);
}
?>
