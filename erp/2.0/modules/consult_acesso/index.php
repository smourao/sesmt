<?PHP
/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                echo "<td align=center class='text roundborderselected'>";
                    echo "<b>&nbsp;</b>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";

                echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
                echo "<tr>";
                    echo "<td class='text' height=30 align=left>";
					echo "<td class='text' align=center>&nbsp;</td>";
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
    echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'><b>Controle de Vendedores</b></td>";
        echo "</tr>";
        echo "</table>";
        
		$query="select * FROM funcionario ORDER BY funcionario_id";
		$res = pg_query($connect, $query);
		$fun = pg_fetch_all($res);
	
	    echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text' width=3><b>ID:</b></td>";
		echo "<td align=center class='text' width=150><b>Vendedor:</b></td>";
        echo "<td align=center class='text' width=20><b>Acessos:</b></td>";
        echo "<td align=center class='text' width=10><b>Qtd. de Clientes:</b></td>";
		echo "<td align=center class='text' width=50><b>Último Acesso</b></td>";
        echo "</tr>";
        for($x=0;$x<pg_num_rows($res);$x++){
		  $query="select DISTINCT(cc.funcionario_id), f.nome, count(cc.funcionario_id) as cliente
				from cliente_comercial cc, funcionario f 
				WHERE f.funcionario_id = cc.funcionario_id
				AND f.funcionario_id={$fun[$x][funcionario_id]}		
				GROUP BY cc.funcionario_id, f.nome";
			$ress = pg_query($connect, $query);
			$buffer = pg_fetch_array($ress);
		
		  $pqp = "select count(usuario_id) from log where usuario_id = {$fun[$x][funcionario_id]}";
		  $resul = pg_query($connect, $pqp);
		  $row = pg_fetch_array($resul);  
		
		  $pqp2 = "select data from log where usuario_id = {$fun[$x][funcionario_id]} ORDER BY data DESC";
		  $resp = pg_query($connect, $pqp2);
		  $r = pg_fetch_array($resp);
		
		  echo "<tr class='text roundbordermix'>  
			<td align=center class='text roundborder'>".$fun[$x][funcionario_id]."&nbsp;</td>
			<td align=center class='text roundborder'>".$fun[$x][nome]."&nbsp;</td>
			<td align=center class='text roundborder'>".$row[count]."&nbsp;</td>
			<td align=center class='text roundborder'>".$buffer[cliente]."&nbsp;</td>
			<td align=center class='text roundborder'>".date("d/m/Y H:mm", strtotime($r[data]))."&nbsp;</td>
		  </tr>";
		}
        echo "</table>";

/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";
?>