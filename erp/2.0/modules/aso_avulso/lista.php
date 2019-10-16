<?PHP

// --> ESCLUSÃO DE ASO

if($_GET[act] == "del"){
    if(!empty($_GET[id])){
        $sql = "DELETE FROM aso_avulso WHERE cod_aso = $_GET[id]";
        if(pg_query($sql)){
            echo "<script>alert('ASO excluído!');</script>";
        }else{
            echo "<script>alert('Erro ao excluir ASO!');</script>";
        }
    }
}


/*$sfunc = "SELECT a.*, f.*, c.* FROM aso a, funcionarios f, cliente c WHERE 
			a.tipo = '2' AND
			a.cod_cliente = c.cliente_id AND
			a.cod_func = f.cod_func AND
			f.cod_cliente = c.cliente_id
			ORDER BY cod_aso DESC";
$qfunc = pg_query($sfunc);
$afunc = pg_fetch_all($qfunc);*/


//verifica a página atual caso seja informada na URL, senão atribui como 1ª página
        $pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

//seleciona todos os itens da tabela
$slist = "SELECT * FROM aso_avulso";
$qlist = pg_query($slist);

//conta o total de itens
        $total = pg_num_rows($qlist);
		
//seta a quantidade de itens por página, neste caso, 2 itens
        $registros = 100;
		
//calcula o número de páginas arredondando o resultado para cima
        $numPaginas = ceil($total/$registros);
		
//variavel para calcular o início da visualização com base na página atual
        $inicio = ($registros*$pagina)-$registros;
		
//seleciona os itens por página
        $slist = "SELECT * FROM aso_avulso ORDER BY cod_aso DESC LIMIT $registros OFFSET $inicio";
		$qlist = pg_query($slist);
        $alist = pg_num_rows($qlist);


//Pegar da tabela funcionarios
		$slistar = "SELECT * FROM aso_avulso";
		$qlistar = pg_query($slistar);
		$arrayasoa = pg_fetch_array($qlistar);

		$sfunc = "SELECT a.*, f.*, c.* FROM aso_avulso a, funcionarios f, cliente c WHERE
			a.cod_aso = $arrayasoa[cod_aso] AND
			a.cnpj_cliente = c.cnpj AND
			a.nome_func = f.nome_func AND
			f.cod_cliente = c.cliente_id";
$qfunc = pg_query($sfunc);
$afunc = pg_fetch_all($qfunc);

    if($total>0){
		echo"<form method='post' target='_blank' action=\"http://sesmt-rio.com/erp/2.0/modules/aso_avulso/exames/impri_aso_avulso.php\">";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			echo "<tr>";
			echo "<td align=left>";
				echo "<input type='submit' name='printer' value='Imprimir'>";
			echo "</td>";
			echo "</tr>";
            echo "<tr>";
				echo "<td width=20 align=left class='text'>";
				echo "<b>Sel.</b>";
				echo "</td>";
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
		
		
		
        while ($produto = pg_fetch_array($qlist)) {

			

                echo "<tr>";
				
				echo "<td align=left class='text roundbordermix curhand'>";
                    echo "<input type='checkbox' name='botao_aso[]'  value='".$produto[cod_aso]."'";
                echo "</td>";

                echo "<td align=left class='text roundbordermix curhand' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=aso_avulso_alterar&cod_aso=".$produto[cod_aso]."';\">";
                    echo str_pad($produto[cod_aso], 3, '0', 0);
                echo "</td>";

				echo "<td align=left class='text roundbordermix curhand' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=aso_avulso_alterar&cod_aso=".$produto[cod_aso]."';\">";
                    echo substr($produto[nome_func], 0, 45);
                echo "</td>";

                echo "<td align=left class='text roundbordermix curhand' onclick=\"location.href='?dir=$_GET[dir]&p=$_GET[p]&sp=aso_avulso_alterar&cod_aso=".$produto[cod_aso]."';\">";
                    echo $produto[razao_social_cliente];
                echo "</td>";
				
                echo "<td width=40 align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', 'Exibe o ASO.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."exame/?aso=".$produto[cod_aso]."');\">";
				
                    echo "Visualizar";
					

                echo "</td>";
				
				?>
                
				
                
				<?php
				echo "<td width=40 align=center class='text roundbordermix curhand'  onmouseover=\"showtip('tipbox', 'Excluir o ASO.');\" onmouseout=\"hidetip('tipbox');\">";
				?>
                <a href="#" onClick="if(confirm('Tem certeza que deseja excluir este ASO?','')){location.href='?dir=aso_avulso&p=index&act=del&id=<?php echo $produto[cod_aso]; ?>' }">
				Excluir
				</a>
                <?php
				echo"</td>";
				
                echo "</tr>";
				
				//exibe a paginação
        

			

        }
		echo"<tr>";
		for($i = 1; $i < $numPaginas + 1; $i++) {
             echo "<a href='?dir=aso_avulso&p=index&pagina=$i'> ".$i." </a> | ";
        }

        echo "</table>";
		
		echo"</form>";
		
		for($i = 1; $i < $numPaginas + 1; $i++) {
             echo "<a href='?dir=aso_avulso&p=index&pagina=$i'> ".$i." </a> | ";
        }
		
		}else{

    //caso não seja encontrado nenhum registro

        if($_GET[sYear] && $_GET[sMonth] && is_numeric($_GET[sYear]) && is_numeric($_GET[sMonth])){

            echo "Não foram encontrados registros.";

        }else{

            echo "Não foram encontrados registros.";

        }

    }



?>
