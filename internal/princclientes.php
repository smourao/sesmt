<?PHP
   include("include/db.php");
   $list = array();
   
   $sql = "SELECT * FROM cliente_pc";
   $result = pg_query($sql);
   $buffer = pg_fetch_all($result);
   for($x=0;$x<pg_num_rows($result);$x++){
       if(!in_array($buffer[$x]['razao_social'], $list))
           $list[] = $buffer[$x]['razao_social'];
   }
   
   $sql = "SELECT razao_social FROM cliente WHERE razao_social != 'TESTE' AND showsite = 1 ORDER BY cliente_id ASC";
   $result = pg_query($conn, $sql);
   $row = pg_fetch_all($result);
   for($x=0;$x<count($row);$x++){
      if(!in_array($row[$x]['razao_social'], $list))
          $list[] = $row[$x]['razao_social'];
   }
   
   //$list = array_rand($list);

   $t = "";
   for($x=0;$x<count($list);$x++){
       if(!empty($list[$x]))
           $t .= $list[$x]."<BR>";
   }

//   <MARQUEE Direction=up scrollDelay=300 height=200 trueSpeed>
   echo "
   <MARQUEE Direction=up scrollAmount=4 height=500>
   {$t}
   </marquee>";
?>
