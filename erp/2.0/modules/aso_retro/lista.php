<?PHP

$slist = "SELECT a.*, f.*, c.* FROM aso a, funcionarios f, cliente c WHERE 
			a.tipo = '2' AND
			a.cod_cliente = c.cliente_id AND
			a.cod_func = f.cod_func AND
			f.cod_cliente = c.cliente_id
			ORDER BY cod_aso DESC";
$qlist = pg_query($slist);
$alist = pg_fetch_all($qlist);

    if(pg_num_rows($qlist)>0){

        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
            echo "<tr>";
				echo "<td width=60 align=left class='text'>";
				echo "<b>Cód. Aso</b>";
				echo "</td>";
                echo "<td width=200 align=left class='text'>";
                echo "<b>Funcionário</b>";
                echo "</td>";
                echo "<td width=200 align=left class='text'>";
                echo "<b>Empresa</b>";
                echo "</td>";
                echo "<td width=60 colspan=5 align=left class='text'>";
                echo "<b>Opções</b>";
                echo "</td>";

            echo "</tr>";

        for($x=0;$x<pg_num_rows($qlist);$x++){

			if($alist[$x][cod_aso] != $alist[$x-1][cod_aso]){

                echo "<tr>";

                echo "<td align=left class='text roundbordermix curhand' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=edit&aso=".$alist[$x][cod_aso]."';\">";
                    echo str_pad($alist[$x][cod_aso], 3, '0', 0);
                echo "</td>";

				echo "<td align=left class='text roundbordermix curhand' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=edit&aso=".$alist[$x][cod_aso]."';\">";
                    echo substr($alist[$x][nome_func], 0, 45);
                echo "</td>";

                echo "<td align=left class='text roundbordermix curhand' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=edit&aso=".$alist[$x][cod_aso]."';\">";
                    echo $alist[$x][razao_social];
                echo "</td>";
				
                echo "<td width=40 align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', 'Exibe o ASO.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."exame/?cod_cliente=".$alist[$x][cod_cliente]."&setor=".$alist[$x][cod_setor]."&funcionario=".$alist[$x][cod_func]."&aso=".$alist[$x][cod_aso]."');\">";

                    echo "Visualizar";

                echo "</td>";
                echo "</tr>";

			}

        }

        echo "</table>";

    }else{

    //caso não seja encontrado nenhum registro

        if($_GET[sYear] && $_GET[sMonth] && is_numeric($_GET[sYear]) && is_numeric($_GET[sMonth])){

            echo "Não foram encontrados registros.";

        }else{

            echo "Não foram encontrados registros.";

        }

    }



?>
