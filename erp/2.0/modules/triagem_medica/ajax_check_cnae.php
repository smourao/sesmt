<?php
    header("Content-Type: text/html; charset=ISO-8859-1",true);
 
	include("../../common/database/conn.php");
 

    $cnae = $_GET['cnae'];

    if(!empty($cnae)){
        $query_cnae="select * from cnae where cnae='".$cnae."'";
        $result_cnae=pg_query($query_cnae)or die("Erro na query $query_cnae".pg_last_error($connect));
        $row_cnae=pg_fetch_array($result_cnae);
        if(pg_num_rows($result_cnae)){
            //$tmp = "";
            $tmp = $row_cnae[grau_risco];
            echo $tmp;
        }else{
            echo "0";
        }
     }else{
         echo "0";
     }
?>
