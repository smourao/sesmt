<?PHP
//Get client
$sql = "SELECT * FROM cliente WHERE cliente_id = '{$_GET[cod_cliente]}'";
$res = pg_query($sql);
$buffer = pg_fetch_array($res);

echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
    echo "<td width=250 class='text roundborder' valign=top>";
		// RESUMO DO CLIENTE
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=center class='text roundborderselected'>";
			echo "<b>Clique em uma função para editá-la</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "<p>";
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
		echo "<td align=left class='text'><b>Responsável:</b>&nbsp;{$buffer[nome_contato_dir]}</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td align=left class='text'><b>Telefone:</b>&nbsp;{$buffer[telefone]}</td>";
		echo "</tr>";
		echo "</table>";
		echo "<p>";
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td align=center class='text roundborderselected'><b>Opções</b></td>";
		echo "</tr>";
		echo "</table>";
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
		echo "<tr>";
			echo "<td class='roundbordermix text' height=30 align=left>";
				echo "<form method=post>";
				echo "<table width=100% border=0>";
				echo "<tr>";
				echo "<td class='text' align=center><input type='button' class='btn' name='button' value='Nova Função' onclick=\"location.href='?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=2';\" onmouseover=\"showtip('tipbox', '- Cadastro de Função, Permite cadastrar uma determinada função para a empresa.');\" onmouseout=\"hidetip('tipbox');\"></td>";				
				echo "<td class='text' align=center><input type='button' class='btn' name='butVtr' value='Voltar' onclick=\"location.href='";
				if($_GET[step]==1){ 
					echo "?dir=cad_cliente&p=detalhe_cliente&cod_cliente={$_GET[cod_cliente]}";
				}else{
					echo "?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=1";
				}
					echo "';\" onmouseover=\"showtip('tipbox', '- Voltar, permite voltar para o cadastro de clientes.');\" onmouseout=\"hidetip('tipbox');\"></td>";
				echo "</tr>";
				echo "</table>"; 
				echo "</form>";
			echo "</td>";
		echo "</tr>";
		echo "</table>";
	
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
            echo "<b>{$buffer[razao_social]}</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
//STEP 1 BEGIN
if($_GET[step] == 1){





	



	$f = "SELECT f.*, ff.cod_cliente, ff.cod_funcao 
						FROM funcao f, funcionarios ff 
						WHERE ff.cod_cliente = $_GET[cod_cliente] 
						AND ff.cod_funcao = f.cod_funcao 
						AND ff.cod_fec = 0 
						ORDER BY nome_funcao";
	$fq = pg_query($f);
	$fqa = pg_fetch_all($fq);
	
	for($x=0;$x<=pg_num_rows($fq);$x++){
		if($fqa[$x]['cod_funcao'] <> $fqa[$x-1]['cod_funcao']	 ){
		
			$s = "SELECT * FROM fun_exa_cli WHERE cod_cli = ".$fqa[$x][cod_cliente]." AND cod_fun = ".$fqa[$x][cod_funcao]." ";
			$e = @pg_query($s);
			
			$fe = "SELECT * FROM funcao_exame WHERE cod_exame = ".$fqa[$x][cod_funcao]." ";
			$feq = @pg_query($fe);
			$feqa = @pg_fetch_all($feq);
			
			for($y=0;$y<=@pg_num_rows($feq);$y++){
			
				if(@pg_num_rows($e) == 0){	
					$q = "INSERT INTO fun_exa_cli(cod_fun, cod_cli, cod_exa) 
						  VALUES(".$fqa[$x][cod_funcao].", ".$fqa[$x][cod_cliente].",".$feqa[$y][exame_id].")";
					$w = @pg_query($q);
					
					$r = "UPDATE funcionarios SET cod_fec = 1 WHERE cod_cliente = ".$fqa[$x][cod_cliente]." 
						  AND cod_fun = ".$fqa[$x][cod_funcao]."";
				}
			}
		}
	}










		echo "<table width=100% border=0 cellspacing=0 cellpadding=0>";
		echo "<tr>";
		echo "<td align=left class='text'>";
				echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
			for($x=0;$x<pg_num_rows($result);$x++){
			//BUSCA INFORMAÇÕES DE FUNÇOES
			$sql = "SELECT fec.*, cli.*, fun.*   
					FROM fun_exa_cli fec, cliente cli, funcao fun  
					WHERE fec.cod_cli = '{$_GET[cod_cliente]}' 
					AND cli.cliente_id = '{$_GET[cod_cliente]}' 
					AND fun.cod_funcao = fec.cod_fun 
					ORDER BY nome_funcao";
			$r = pg_query($sql);
			$items = pg_fetch_all($r);
			$in = pg_num_rows($r);
			$total=0;
			if($in){
				echo "<tr>";
					echo "<td align=left class='text'><b>Funções</b></td>";;
				echo "</tr>";
			}
			for($q=0;$q<$in;$q++){	
			if($items[$q]['nome_funcao'] <> $items[$q-1]['nome_funcao']	 ){   
				echo "<tr>";
				echo "<td align=left class='text roundbordermix curhand' width=90%><a href='?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=4&fun={$items[$q][cod_funcao]}';\" onmouseover=\"showtip('tipbox', '- Editar Função, Permite alterar detalhes de uma determinada função da empresa.'\">";
				echo $items[$q]['nome_funcao'];
				echo "</a><td align = center class='text roundbordermix curhand' width=90%><a href='?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=6&del={$items[$q]['cod_funcao']}'><b>Excluir</b></a></td></td>";
				echo "</tr>";
			}}
			echo "</table>";
		}
		echo "<td>";
		echo "</tr>";
		echo "</table>";
}//STEP 1 END
//STEP 2 BEGIN
if($_GET[step] == 2){
		echo "<form method=post name=cad_funcao 

action='?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=3'><table 

width=100% border=0 cellspacing=0 cellpadding=0>";		
		echo "<tr>";
		echo "<td align=left class='text'>";
				echo "<tr>";
				echo "<td align=left class='text' width=11%><b>&nbsp;Função: 

</b></td>";
				echo "<td align=left class='text'><select id=funcao 

name=funcao class='inputText'>";
				$f = "SELECT * FROM funcao ORDER BY nome_funcao";
				$fq = pg_query($f);
				$fqa = pg_fetch_all($fq);
				echo '<option></option>';
				for($x=0;$x<pg_num_rows($fq);$x++){
				echo "<option 

value=".$fqa[$x][cod_funcao].">".strtoupper($fqa[$x][nome_funcao])."</option>";
				}
				echo "</select></td>";
				echo "</tr>";
		echo "</td>";
		echo "</tr>";
		echo "</table width=100% border=0>";
			
		$e = "SELECT * FROM exame ORDER BY especialidade";
		$eq = pg_query($e);
		$eqa = pg_fetch_all($eq);
		
		echo "<table><tr>";
			echo "<td align=left class='text' width=65><b>&nbsp;Exames: 

</b></td>";
			echo "<td align=left class='text' width=300>";
			for($y=0;$y<(pg_num_rows($eq)/2);$y++){
			echo "<input name=ex1[] value=".$eqa[$y][cod_exame]." 

type=checkbox>";
			echo $eqa[$y][especialidade];
			echo '<br>';
			}
			echo "</td>";
			echo "<td align=left class='text' width=300>";
			for($y=((pg_num_rows($eq)/2)+1);$y<pg_num_rows($eq);$y++){
			echo "<input name=ex2[] value=".$eqa[$y][cod_exame]." 

type=checkbox>";
			echo $eqa[$y][especialidade];
			echo '<br>';
			}
			echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "<table width=100% border=0>";		
			echo "<tr height=50>";
				echo "<td align=right class='text'><input type=reset 

name=limpar value=Limpar class=btn></td>";
				echo "<td align=left class='text'><input type=submit 

name=enviar value=Confirmar class=btn></td>";
			echo "</tr>";
		echo "</table></form>";				
}//STEP 2 END
//STEP 3 BEGIN
$funcao = $_POST[funcao];
$exame1 = $_POST[ex1];
$exame2 = $_POST[ex2];
$cliente = $_GET[cod_cliente];
if($_GET[step] == 3){
	if(($funcao <> "" && $cliente <> "" && $exame2 <> "") || ($funcao <> "" && $cliente <> "" && $exame1 <> "")){	
		
		if(is_array($exame1)){
			foreach($exame1 as $exame){
				$s = "SELECT * FROM fun_exa_cli WHERE cod_cli = '$cliente' AND cod_fun = '$funcao' AND cod_exa = '$exame' ";
				$q = @pg_query($s);
				if(@pg_num_rows($q) == 0){
					$sql = "INSERT INTO fun_exa_cli(cod_fun, cod_exa, cod_cli) VALUES('$funcao', '$exame', '$cliente')";
					$query = @pg_query($sql);
				}
			}
		}else{
				$s = "SELECT * FROM fun_exa_cli WHERE cod_cli = '$cliente' AND cod_fun = '$funcao' AND cod_exa = '$exame1' ";
				$q = @pg_query($s);
				if(@pg_num_rows($q) == 0){
					$sql = "INSERT INTO fun_exa_cli(cod_fun, cod_exa, cod_cli) VALUES('$funcao', '$exame1', '$cliente')";
					$query = @pg_query($sql);
				}
		}
		if(is_array($exame2)){
			foreach($exame2 as $exame){
				$s = "SELECT * FROM fun_exa_cli WHERE cod_cli = '$cliente' AND cod_fun = '$funcao' AND cod_exa = '$exame' ";
				$q = @pg_query($s);
				if(@pg_num_rows($q) == 0){
					$sql = "INSERT INTO fun_exa_cli(cod_fun, cod_exa, cod_cli) VALUES('$funcao', '$exame', '$cliente')";
					$query = @pg_query($sql);
				}
			}
		}else{
			$s = "SELECT * FROM fun_exa_cli WHERE cod_cli = '$cliente' AND cod_fun = '$funcao' AND cod_exa = '$exame2' ";
			$q = @pg_query($s);
			if(@pg_num_rows($q) == 0){
				$sql = "INSERT INTO fun_exa_cli(cod_fun, cod_exa, cod_cli) VALUES('$funcao', '$exame2', '$cliente')";
				$query = @pg_query($sql);
			}
		}
	}
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=4&fun=$funcao'>";
}//STEP 3 END
//STEP 4 BEGIN
echo "<table width=100%><tr><td>";
if($_GET[step] == 4){
	$sql = "SELECT exa.*, fec.* FROM 
			exame exa, fun_exa_cli fec 
			WHERE fec.cod_fun = $_GET[fun] 
			AND fec.cod_cli = $_GET[cod_cliente] 
			AND fec.cod_exa = exa.cod_exame 
			ORDER BY especialidade";
	$query = pg_query($sql);
	$array = pg_fetch_all($query);
	
	$f = "SELECT * FROM funcao WHERE cod_funcao = $_GET[fun] ORDER BY nome_funcao";
	$fq = pg_query($f);
	$fqa = pg_fetch_array($fq);

				echo "<tr><td><b>Função: ".$fqa[nome_funcao]."</b></td></tr><tr>";
	for($x=0;$x<pg_num_rows($query);$x++){
				echo "<tr>";
				echo "<td align=left class='text roundbordermix curhand' width=90%><b>";
				echo $array[$x][especialidade];
				echo "</b></td><td align=center class='text roundbordermix curhand' width=10%><a href='?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=5&del={$array[$x][cod_exa]}&fun={$array[$x][cod_fun]}'><b>Excluir</b></a></td>";
				echo "</tr><p>";
	}
	
	echo "<tr height=40><td width=90%><input type='button' class='btn' name='button' value='Novo exame' onclick=\"location.href='?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=7&fun=$_GET[fun]';\" onmouseover=\"showtip('tipbox', '- Adicionar Exame, Permite cadastrar um novo exame para essa função.');\" onmouseout=\"hidetip('tipbox');\"></td></tr>";
	
}
echo "</td></tr></table>";
//STEP 4 END
//STEP 5 BEGIN
$funcao = $_GET[fun];
$del = $_GET[del];
$cliente = $_GET[cod_cliente];
if($_GET[step] == 5){
	$sql = "DELETE FROM fun_exa_cli WHERE cod_exa = '$del' AND cod_cli = '$cliente' AND cod_fun = '$funcao'";
	$query = pg_query($sql);
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=4&fun=$_GET[fun]'>";
}//STEP 5 END
//STEP 6 BEGIN
$del = $_GET[del];
$cliente = $_GET[cod_cliente];
if($_GET[step] == 6){
	$sql = "DELETE FROM fun_exa_cli WHERE cod_cli = '$cliente' AND cod_fun = '$del'";
	$query = pg_query($sql);
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=1'>";
}//STEP 6 END

//STEP 7 BEGIN
if($_GET[step] == 7){

	$f = "SELECT * FROM funcao WHERE cod_funcao = $_GET[fun] ORDER BY nome_funcao";
	$fq = pg_query($f);
	$fqa = pg_fetch_array($fq);
	
		echo "<form method=post name=cad_funcao 
action='?dir=cad_cliente&p=list_funcao&cod_cliente=$_GET[cod_cliente]&step=3'><table width=100% border=0 cellspacing=0 cellpadding=0>";
		echo "<input type=hidden name=funcao value=$_GET[fun]>";
		
		echo "<tr>";
		echo "<td align=left class='text'>";
				echo "<tr>";
				echo "<td align=left class='text' width=11%><b>&nbsp;Função: ".$fqa[nome_funcao]."</b></td>";
		echo "</tr>";
		echo "</td>";
		echo "</tr>";
		echo "</table width=100% border=0>";
			
		$e = "SELECT * FROM exame ORDER BY especialidade";
		$eq = pg_query($e);
		$eqa = pg_fetch_all($eq);
		
		echo "<table><tr>";
			echo "<td align=left class='text' width=65><b>&nbsp;Exames: 

</b></td>";
			echo "<td align=left class='text' width=300>";
			for($y=0;$y<(pg_num_rows($eq)/2);$y++){
			echo "<input name=ex1[] value=".$eqa[$y][cod_exame]." 

type=checkbox>";
			echo $eqa[$y][especialidade];
			echo '<br>';
			}
			echo "</td>";
			echo "<td align=left class='text' width=300>";
			for($y=((pg_num_rows($eq)/2)+1);$y<pg_num_rows($eq);$y++){
			echo "<input name=ex2[] value=".$eqa[$y][cod_exame]." 

type=checkbox>";
			echo $eqa[$y][especialidade];
			echo '<br>';
			}
			echo "</td>";
			echo "</tr>";
		echo "</table>";
		echo "<table width=100% border=0>";		
			echo "<tr height=50>";
				echo "<td align=right class='text'><input type=reset 

name=limpar value=Limpar class=btn></td>";
				echo "<td align=left class='text'><input type=submit 
name=enviar value=Confirmar class=btn></td>";
			echo "</tr>";
		echo "</table></form>";				
}//STEP 7 END


echo "</td>";
echo "</tr>";
echo "</table>";
?>