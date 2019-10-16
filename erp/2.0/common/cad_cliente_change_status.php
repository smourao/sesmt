<?PHP
    header("Content-Type: text/html; charset=ISO-8859-1",true);
    include("database/conn.php");
    include("functions.php");
    include("globals.php");
    $iSt = 0;
	if($_GET[value] == "comercial"){
        $iSt = 0;
    }
    if($_GET[value] == "ativo"){
        $iSt = 1;
    }
	if($_GET[value] == "parceria"){
        $iSt = 2;
    }
    $sql = "SELECT * FROM cliente WHERE cliente_id = {$_GET[cod_cliente]}";
    $result = pg_query($sql);
    $data = pg_fetch_array($result);
    if($data[status] == "ativo")
        $rval = "0";
    else
        $rval = "1";
    
    if($_GET[value] == "ativo" || $_GET[value] == "comercial" || $_GET[value] == "parceria" && is_numeric($_GET[cod_cliente])){
        if($data[status] != $_GET[value]){
            $sql = "UPDATE cliente SET status = '{$_GET[value]}', cliente_ativo = {$iSt} WHERE cliente_id = $_GET[cod_cliente]";
            //echo "100".$sql;
			if(pg_query($sql)){
				//$rpj = "UPDATE reg_pessoa_juridica SET grupo = 2, cod_cliente = $_GET[cod_cliente] WHERE cnpj = $data[cnpj]";
				//if(pg_query($rpj)){
					echo "2";
				}else{
					echo $rval;
				}
			//}
        }else{
            echo "2";
        }
    }else{
        echo $rval;
    }
?>
