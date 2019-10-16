<?PHP
    header("Content-Type: text/html; charset=ISO-8859-1",true);
    include("database/conn.php");
    include("functions.php");
    include("globals.php");
    $cepe = substr($_GET['id'], 0, 5);

    if(!empty($_GET['id']) ){
    	$sql = "select cep, tipo_logradouro, logradouro, bairro, cidade from endereco
    			where cep = '".$_GET['id']."'";
    	$result = pg_query($sql);
    	$row = pg_fetch_all($result);
    }
    $text = $row[0]['cep']."|".$row[0]['tipo_logradouro']." ".$row[0]['logradouro']."|".$row[0]['bairro']."|".$row[0]['cidade']."|".$row[1]."RJ - Rio de Janeiro"."|";//$text = $row[0]."|".$row[1]." ".$row[2]."|".$row[3]."|".$row[4]."|".$row[5]."RJ-Rio de Janeiro"."|";
    if(pg_num_rows($result))
        echo $text;
    else
        echo "0";
?>
