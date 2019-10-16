<?PHP
echo "<b>Início da migração</b>:<p>";
$sql = "SELECT cert_empresa FROM bt_treinamento GROUP BY cert_empresa ORDER BY cert_empresa";
$res = pg_query($sql);
$ltr = pg_fetch_all($res);

$sql = "DELETE * FROM site_treinamento_info";
pg_query($sql);
$ok = 0;
$error = 0;
for($x=0;$x<pg_num_rows($res);$x++){
    $sql = "SELECT c.razao_social, t.*, cur.* FROM bt_treinamento t, cliente c, bt_cursos cur
    WHERE t.cert_empresa = {$ltr[$x][cert_empresa]}
    AND t.cod_cliente = c.cliente_id
    AND t.cod_curso = cur.id";
    $r = pg_query($sql);
    $tinfo = pg_fetch_array($r);
    echo "- Migrando certificado código {$ltr[$x][cert_empresa]}... ";
    $sql = "INSERT INTO site_treinamento_info (cod_certificado, cod_cliente, cod_curso, data_inicio,
    data_termino, tipo_treinamento, nome_instrutor, profissao_instrutor, reg_instrutor, data_criacao) VALUES (
    {$ltr[$x][cert_empresa]}, $tinfo[cod_cliente], $tinfo[cod_curso], '$tinfo[data_inicio]', '$tinfo[data_termino]',
    '$tinfo[tipo_treinamento]', '$tinfo[nome_instrutor]', '$tinfo[profissao_instrutor]', '$tinfo[reg_instrutor]',
    '$tinfo[data_criacao]')";
  //echo $sql;
    if(pg_query($sql)){
        $ok++;
        echo "<font color=green>migrado!</font><BR>";
    }else{
        $error++;
        echo "<font color=red>falha!</font><BR>";
    }
  
}

echo "<b>".pg_num_rows($res)."</b> ocorrências à serem migradas, <b>$ok</b> migradas e <b>$error</b> erros.<BR>";
?>
