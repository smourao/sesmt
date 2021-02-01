<?PHP
$login = anti_injection($_POST[txtLogin]);
$pass  = md5(anti_injection($_POST[txtPass]));
$sql = "SELECT id, grupo, 1 as pessoa, 0 as cod_cliente FROM reg_pessoa_fisica   WHERE email='$login' AND senha='$pass'
        UNION
        SELECT id, grupo, 2 as pessoa, cod_cliente FROM reg_pessoa_juridica WHERE email='$login' AND senha='$pass'";
$rlo = @pg_query($sql);
$loginerror = 0;
if(@pg_num_rows($rlo)){
    $userdata = @pg_fetch_array($rlo);
    $_SESSION[user_id]      = $login;                       // email
    $_SESSION[tipo_usuario] = $userdata[grupo];             // tipo de usuario, adm, cliente, contador, franquia, visitante
    $_SESSION[tipo_cliente] = (int)($userdata[pessoa]);     // 1 fisica, 2 juridica
    $_SESSION[cod_cliente]  = (int)($userdata[cod_cliente]);// :D
    $_SESSION[tipo_acesso]  = 0;                            // 0 - Total; 1 - Interno (Limitado); 2 - Externo (read only)
    makeLog($_SESSION[user_id], "Cliente logado utilizando conta principal.", 010, $sql);
}else{
    unset($_SESSION[user_id]);
    unset($_SESSION[tipo_usuario]);
    unset($_SESSION[tipo_cliente]);
    unset($_SESSION[cod_cliente]);
    unset($_SESSION[tipo_acesso]);
    $loginerror = 1;
}
//se erro ao tentar logar normalmente, tenta logar adicionalmente
if($loginerror){
    $sql = "SELECT * FROM site_acesso_secundario WHERE email='$login' AND senha='$pass'";
    $r = pg_query($sql);

    if(pg_num_rows($r)>0){
        $buffer = pg_fetch_array($r);
        
        $_SESSION[user_id]      = $login;                     // email
        $_SESSION[tipo_usuario] = $buffer[grupo];             // tipo de usuario, adm, cliente, contador, franquia, visitante
        $_SESSION[tipo_cliente] = 2;                          // 1 fisica, 2 juridica
        $_SESSION[cod_cliente]  = (int)($buffer[cod_cliente]);// :D
        $_SESSION[tipo_acesso]  = $buffer[tipo_acesso];       // 0 - Total; 1 - Interno (Limitado); 2 - Externo (read only)
        makeLog($_SESSION[user_id], "Cliente logado utilizando senha adicional.", 011, $sql);
    }else{
        unset($_SESSION[user_id]);
        unset($_SESSION[tipo_usuario]);
        unset($_SESSION[tipo_cliente]);
        unset($_SESSION[cod_cliente]);
        unset($_SESSION[tipo_acesso]);
        $loginerror = 1;
    }
}
?>
