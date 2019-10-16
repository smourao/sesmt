<?php
    header("Content-Type: text/html; charset=ISO-8859-1",true);
    include("database/conn.php");
    include("functions.php");
    include("globals.php");

    $cnpj = $_GET['cnpj'];

    $sql = "SELECT * FROM cliente WHERE BTRIM(cnpj, ' ') = '{$cnpj}'";
    $result = pg_query($sql);
    $buffer = pg_fetch_array($result);
    if(pg_num_rows($result)>0){
        if(!empty($buffer[vendedor_id])){
            $sql = "SELECT * FROM funcionario WHERE funcionario_id = {$buffer[vendedor_id]}";
            $r = pg_query($sql);
            $vendedor = pg_fetch_array($r);
        }
        echo "<b>CNPJ já cadastrado:</b> $cnpj<BR><b>Cliente:</b> ".rtrim(ltrim($buffer['razao_social']))."<BR><b>Cadastrado dia:</b> ".$buffer['data']."<BR><b>Vendedor:</b> ".$vendedor['nome'];
    }else{
        echo "0";
    }
?>
