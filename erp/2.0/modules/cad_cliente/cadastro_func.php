<script>
function goBack() {
    window.history.go(-1)
}
</script>

<?php
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
     echo "<td width=250 class='text roundborder' valign=top>";
	 	echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
			echo "<b>Resumo</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		$sql = "SELECT * FROM funcionarios WHERE cod_cliente = $_GET[cod_cliente] and cod_status = 1";
		$result = pg_query($sql);
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborder'>";			
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=left class='text'><b>Funcionários Ativos:</b></td>";
		echo "<td align=center class='text'>";
		echo str_pad(pg_num_rows($result), 3, "0", 0);
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		
		$numcgrtsql = "SELECT cod_cgrt FROM cgrt_info WHERE cod_cliente = $_GET[cod_cliente] ORDER BY ano DESC, data_criacao ASC";
		$numcgrtquery = pg_query($numcgrtsql);
		$numcgrt = pg_fetch_array($numcgrtquery);
		
		
		if(pg_num_rows($numcgrtquery) >=1){
			
		
		
		$cod_cgrt = $numcgrt[cod_cgrt];
				
				
				$sql = "SELECT cfl.*,f.*, fun.* FROM cgrt_func_list cfl, funcionarios f, funcao fun
		WHERE cfl.cod_cgrt = $cod_cgrt AND f.cod_cliente = cfl.cod_cliente AND f.cod_func = cfl.cod_func
		AND fun.cod_funcao = cfl.cod_funcao AND cfl.status = 1 AND f.cod_status = 1 ORDER BY f.nome_func";
				$rfl = pg_query($sql);
				$funclist = pg_fetch_all($rfl);
				
				if(pg_num_rows($rfl)>= 1){
					
					$numerocgrt = str_pad(pg_num_rows($rfl), 3, "0", 0);
					
				}
				else{
				
					$numerocgrt = "Sem Programa";
				
				}
				
				
		}else{
			
		$numerocgrt = "Sem Programa";	
			
			
		}
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=left class='text'><b>Efetivo no CGRT:&nbsp;</b></td>";
		echo "<td align=center class='text'>";
		echo $numerocgrt;
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		
		
		
		
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
        echo "<td class='text'><b>Legenda:</b></td>";
        echo "<td width=5% bgcolor='#D75757'>&nbsp;</td>";
        echo "<td class='text'>Dados incompletos</td>";
        echo "</tr>";
		echo "</table>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
	
		echo "<P>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
			echo "<b>Opções</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		
		$sql = "SELECT * FROM funcionarios WHERE cod_cliente = $_GET[cod_cliente]";
		$result = pg_query($sql);
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborder'>";			
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Novo Cadastro' onclick=\"location.href='?dir=cad_cliente&p=new&cod_cliente=$_GET[cod_cliente]';\" onmouseover=\"showtip('tipbox', '- Cadastra um novo funcionário.');\" onmouseout=\"hidetip('tipbox');\">
		
		<input type='button' onclick='goBack()' class='btn' name='btnvoltar' value='Voltar' onmouseover=\"showtip('tipbox', '- Voltar a página anterior.');\" onmouseout=\"hidetip('tipbox');\"></td>";
        echo "</tr>";
		echo "</table>";
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
    echo "<td class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
        echo "<b>Relação de Funcionários</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        $sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
		$result = pg_query($sql);
		$empresa = pg_fetch_array($result);
		echo "<center><b>$empresa[razao_social]</b></center><BR>";
		$p = "./".$_GET['action'].'.php';
		if(file_exists($p)){
			include($p);
		}else{
			include('list.php');
		}

        echo "<p>";
        
/**************************************************************************************************/
// -->
/**************************************************************************************************/
    echo "</td>";
echo "</tr>";
echo "</table>";

echo "<p>";
?>