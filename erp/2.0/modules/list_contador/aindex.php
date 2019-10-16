<?PHP


echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                

                
                echo "<P>";
                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>Resumo</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                $sql = "SELECT DISTINCT(nome_contador), escritorio_contador, email_contador, tel_contador FROM cliente WHERE TRIM(nome_contador) <> '' AND tel_contador not like '0%' AND tel_contador != '' AND tel_contador != '-' AND tel_contador not like '21 - 00%' ORDER BY nome_contador DESC";
                $rtotal = pg_query($sql);
                $total = pg_num_rows($rtotal);
                

                
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='roundbordermix text' height=30 align=left onmouseover=\"showtip('tipbox', '- Resumo dos contadores.');\" onmouseout=\"hidetip('tipbox');\">";
                        echo "<table width=100% border=0>";
                        echo "<tr>";
                        echo "<td class='text'>Total:</td><td class='text' width=40 align=right><a href='?dir=list_contador&p=index&o=@total'>".$total."</a></td>";
                        echo "</tr></table>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "<P>";
                
                

                // --> TIPBOX
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class=text height=30 valign=top align=justify>";
                        echo "<div id='tipbox' class='roundborderselected text' style='display: none;'>&nbsp;</div>";
                    echo "</td>";
                echo "</tr>";
                echo "</table>";
        echo "</td>";

/**************************************************************************************************/
// -->  RIGHT SIDE!!!
/**************************************************************************************************/
    ?>
    <?php

echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
        echo "<b>Lista de Contadores</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        
        echo "<table width=100% border=1 bordercolor='#FFFFFF' cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=left bgcolor='#009966' class='text' width=20><b>Cod:</b></td>";
        echo "<td align=left bgcolor='#009966' class='text'><b>Escritorio:</b></td>";
        echo "<td align=left bgcolor='#009966' class='text' width=100><b>Contador:</b></td>";
		echo "<td align=left bgcolor='#009966' class='text' width=100><b>Telefone:</b></td>";
		echo "<td align=left bgcolor='#009966' class='text' width=100><b>Clientes:</b></td>";
        echo "</tr>";
$sql = "SELECT DISTINCT(nome_contador), escritorio_contador, email_contador, tel_contador FROM cliente WHERE TRIM(nome_contador) <> '' AND tel_contador not like '0%' AND tel_contador != '' AND tel_contador != '-' AND tel_contador not like '21 - 00%' ORDER BY nome_contador DESC";
$result = pg_query($sql);
$buffer = pg_fetch_all($result);

for($x=0;$x<pg_num_rows($result);$x++){
$sql = "SELECT razao_social FROM cliente WHERE nome_contador = '{$buffer[$x]['nome_contador']}'";
$r = pg_query($sql);
$data = pg_fetch_all($r);
$clist = "<center><b>Empresas</b></center><p>";
    for($y=0;$y<pg_num_rows($r);$y++){
        $clist .= ($y+1)." - <b>{$data[$y][razao_social]}</b><BR>";
    }
?>
  <tr>
    <td class="linhatopodiresq">
	  <div align="center" class="fontebranca12">
      <?PHP echo $x+1;?>
	  </div>
	</td>

    <td class="linhatopodiresq">
	  <div align="left"  class="fontebranca12" width="50">
             <b><?PHP echo $buffer[$x]['escritorio_contador'];?></b>
	  </div>
	</td>
	
	    <td class="linhatopodiresq">
	  <div align="left"  class="fontebranca12" width="50">
   <?PHP echo $buffer[$x]['nome_contador'];?>
	  </div>
	</td>

	
    <td class="linhatopodiresq">
	  <div align="left"  class="fontebranca12" width="50">
         <?PHP echo $buffer[$x]['tel_contador'];?>
	  </div>
	</td>

    <td class="linhatopodiresq">
	  <div align="center"  class="fontebranca12"  onMouseOver="return overlib('<?PHP echo $clist;?>');" onMouseOut="return nd();">
         <?PHP echo "(".pg_num_rows($r).")".$data[0]['razao_social'];?>
	  </div>
	</td>

  </tr>
<?php
  }
  $fecha = pg_close($connect);
?>
  <tr>
    <td bgcolor="#009966" class="linhatopodiresqbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
    <td bgcolor="#009966" class="linhatopodirbase"><div align="left"><font color="#FFFFFF"></font>&nbsp;</div></td>
  </tr>
</table>
<pre>














</pre>
<?php
    echo "</td>";
echo "</tr>";
echo "</table>";

?>
