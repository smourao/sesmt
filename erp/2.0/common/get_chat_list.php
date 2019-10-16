<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "database/conn.php";
$id = $_GET[id];
$sql = "SELECT u.* FROM usuario u, funcionario f WHERE u.usuario_id != $id AND f.funcionario_id = u.usuario_id ORDER BY f.nome";
$res = pg_query($sql);
$ulist = pg_fetch_all($res);
$user = array();
$ret = "";
for($x=0;$x<pg_num_rows($res);$x++){
    $sql = "SELECT l.*, f.*, s.* FROM log l, funcionario f, setor_sesmt s
    WHERE l.usuario_id = {$ulist[$x]['usuario_id']} AND (l.detalhe = 'login' OR l.detalhe = 'logout') AND
    f.funcionario_id = l.usuario_id AND
    s.id = f.cod_setor
    ORDER BY data DESC LIMIT 1";
    $r = pg_query($sql);
    $status = pg_fetch_array($r);
    $user[$x][id] = $status[usuario_id];
    $user[$x][nome] = $status[nome];
    if($status[detalhe] == 'login')
        $user[$x][status] = 1;
    else
        $user[$x][status] = 0;
    $user[$x][setor] = $status[nome_setor];
    
    $tmp = explode(" ", $status[nome]);
    if(strlen($tmp[1]) > 2)
        $mnome = $tmp[0]." ".$tmp[1];
    else
        $mnome = $tmp[0]." ".$tmp[1]." ".$tmp[2];
        
    $sql = "SELECT count(m.*) as n FROM sist_sci_messages m, sist_sci_check_message c
           WHERE
           (
           m.msg_from = c.msg_from
           AND
           m.msg_to = {$id}
           AND
           m.msg_from = {$ulist[$x]['usuario_id']}
           AND
           m.time_sended > c.last_check_messages)";
    $rz = pg_query($sql);
    $nmen = pg_fetch_array($rz);
    $n = $nmen[n];
    
    if(!empty($status[nome])){
        $ret .= $status[usuario_id]."|";
        $ret .= $mnome."|";
        $ret .= $user[$x][status]."|";
        $ret .= $status[nome_setor]."|";
        $ret .= $id."|";
        $ret .= $n."£";
    }
}
echo $ret;
?>
