<?PHP
makeLog($_SESSION[user_id], "Logout efetuado.", 012, $sql);
unset($_SESSION[user_id]);
unset($_SESSION[tipo_usuario]);
unset($_SESSION[tipo_cliente]);
unset($_SESSION[cod_cliente]);
?>
