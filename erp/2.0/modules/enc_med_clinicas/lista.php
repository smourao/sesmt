<?php
//RETORNO DO ASO_EMAIL.PHP//
if($_GET[m] == 1){
	showMessage(utf8_decode('Alteração realizada com sucesso!'));
}
if($_GET[pq]){
	$_POST[search] = $_GET[pq];
}
if($_GET[pq] == 1){	
}
//FIM RETORNO DO ASO_EMAIL.PHP//

/*echo "<pre>";
print_r($_POST);
exit();
echo "</pre>";*/
$dat = date("Y-m-d");
//${dtaso[$key]}
if($_POST[aso1]){
	$chkbox = $_POST[confirma];	
	$dtaso = $_POST[aso_data];
	$_POST[search] = $_POST[aso1];
	if(is_array($chkbox)){
		foreach($chkbox as $key => $schkbox){
			$t = "SELECT * FROM aso WHERE cod_aso = $_POST[aso1]";
			$tt = pg_query($t);
			$ttt = pg_fetch_array($tt);
			$sqll = "SELECT c.*, a.*, ce.*, ae.* FROM clinicas c, aso a, clinica_exame ce, aso_exame ae WHERE a.cod_clinica = c.cod_clinica AND a.cod_aso = $_POST[aso1] AND ae.cod_exame = '$schkbox' AND ce.cod_exame = '$schkbox' AND ce.cod_clinica = a.cod_clinica";
		    $res = pg_query($sqll);
		    $buffer = pg_fetch_array($res);
	   
	    	$sqlup = "UPDATE aso SET cod_clinica = $_POST[clinic], tipo_exame = '$_POST[tp_exame]' WHERE cod_aso = $_POST[aso1]";
	    	$queryup = pg_query($sqlup);

	    	$upsag = "UPDATE site_aso_agendamento SET cod_clinica = $_POST[clinic] WHERE cod_aso = $_POST[aso1]";
	    	$querysag = pg_query($upsag);
		}
	}else{
		$t = "SELECT * FROM aso WHERE cod_aso = $_POST[aso1]";
		$tt = pg_query($t);
		$ttt = pg_fetch_array($tt);
		$sqll = "SELECT c.*, a.*, ce.*, ae.* FROM clinicas c, aso a, clinica_exame ce, aso_exame ae WHERE a.cod_clinica = c.cod_clinica AND a.cod_aso = $_POST[aso1] AND ae.cod_exame = '$chkbox' AND ce.cod_exame = '$chkbox' AND ce.cod_clinica = a.cod_clinica";
	    $res = @pg_query($sqll);
	    $buffer = @pg_fetch_array($res);

    	$sqlup = "UPDATE aso SET cod_clinica = $_POST[clinic], tipo_exame = '$_POST[tp_exame]' WHERE cod_aso = $_POST[aso1]";
    	$queryup = pg_query($sqlup);

    	$upsag = "UPDATE site_aso_agendamento SET cod_clinica = $_POST[clinic] WHERE cod_aso = $_POST[aso1]";
	    $querysag = pg_query($upsag);
	}
}

$sql_r = "SELECT a.cod_aso, a.cod_cliente, c.cliente_id, c.grau_de_risco FROM aso a, cliente c WHERE a.cod_aso = $_POST[aso1] AND a.cod_cliente = c.cliente_id";
$query_r = @pg_query($sql_r);
$array_r = @pg_fetch_array($query_r);
$aso_ = $_POST[aso2];
if($_POST[aso2]){
	$sql3="UPDATE aso SET aso_resultado = '$aso_', risco_id = {$array_r[0][grau_de_risco]} WHERE cod_aso = $_POST[aso1]";
	$query3 = @pg_query($sql3); 
}
if($_POST[clas]){
	$sql4="UPDATE aso SET classificacao_atividade_id = $_POST[clas] WHERE cod_aso = $_POST[aso1]";
	$query4 = @pg_query($sql4); 
}

if($_POST['obs']){
	$obs = $_POST['obs'];
	$sql5="UPDATE aso SET obs = '$obs' WHERE cod_aso = $_POST[aso1]";
	$query5 = @pg_query($sql5); 
}

if($_POST['aso_d']){
	$dma = explode('/', $_POST['aso_d']);
	$aso_d = $dma[2]."-".$dma[1]."-".$dma[0];
	$sql6="UPDATE aso SET aso_data = '$aso_d' WHERE cod_aso = $_POST[aso1]";
	$query6 = @pg_query($sql6); 
}

if($_POST['aso_d'] && $aso_ != ''){
	$sel = "SELECT cod_aso, cod_func FROM aso WHERE cod_aso = $_POST[aso1] ORDER BY aso_data DESC";
	$que = pg_query($sel);
	$buf = pg_fetch_all($que);
	$sql6="UPDATE funcionarios SET data_ultimo_exame = '$_POST[aso_d]' WHERE cod_func = '{$buf[0][cod_func]}'";
	$query6 = @pg_query($sql6); 
}

if($_POST['tolerancia']){
	$tolerancia = $_POST['tolerancia'];
	$sql7="UPDATE aso SET tolerancia = '$tolerancia' WHERE cod_aso = $_POST[aso1]";
	$query7 = @pg_query($sql7); 
}

$count = 0;
$datas = array();
while(count($datas)<40){
	if(date("w", mktime(0,0,0,date("m"),date("d")-$count,date("Y"))) != 0 &&
	date("w", mktime(0,0,0,date("m"),date("d")-$count,date("Y"))) != 6){
		$datas[] =  date("Y-m-d", mktime(0,0,0,date("m"),date("d")-$count,date("Y")));
	}
	$count++;
}

/***************************************************************************************************/
// --> VARIABLES
/***************************************************************************************************/
$_POST[search] = anti_injection($_POST[search]);

if(!empty($_GET[cliente]) && !empty($_GET[funcionario]) && !empty($_GET[aso]) && !empty($_GET[email])){
    $sql = "SELECT f.cod_cliente, f.cod_filial, f.cod_funcao,f.nome_func, f.num_ctps_func, f.serie_ctps_func, fe.exame_id, 								fe.descricao, fun.nome_funcao, fun.dsc_funcao FROM
        funcionarios f, funcao_exame fe, funcao fun WHERE
        f.cod_cliente = '".$_GET['cliente']."' AND
        f.cod_func = {$_GET['funcionario']} AND
        f.cod_funcao = fe.cod_exame AND
        fun.cod_funcao = fe.cod_exame";
    $rss = pg_query($sql);
    $funcionario = pg_fetch_all($rss);
}

if($_POST[aso1]){
	$aso = $_POST[aso1];
}else{
	$aso = $_POST[search];
}

$p = "SELECT * FROM aso WHERE cod_aso = '$aso'";
$pp = pg_query($p);
$ppp = pg_fetch_array($pp);

/**************************************************************************************************/
// -->  LEFT SIDE
/**************************************************************************************************/
echo "<table width=100% height=300 cellspacing=5 cellpadding=0 border=0>";
echo "<tr>";
    echo "<td width=250 class='text roundborder' valign=top>";
        echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
        echo "<tr>";
        echo "<td align=center class='text roundborderselected'>";
            echo "<b>Pesquisa</b>";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
		
		echo "<table width=100% border=0 cellspacing=3 cellpadding=2>";
        echo "<tr>";
        echo "<form method=POST name='form1' action='?dir=enc_med_clinicas&p=lista'>";
            echo "<td class='roundbordermix text' height=30 align=center onmouseover=\"showtip('tipbox', '- Digite o numero do encaminhamento no campo e clique em Busca para pesquisar um ASO.');\" onmouseout=\"hidetip('tipbox');\">";
                echo "<input type='text' class='inputText' name='search' id='search' value='{$_POST[search]}' size=18 maxlength=500>";
                echo "&nbsp;";
                echo "<input type='submit' class='btn' name='btnSearch' value='Busca'>";
            echo "</td>";
        echo "</form>";
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
				echo "<td align=center class='text roundborderselected'><b>".utf8_decode('Alterar encaminhamento à clínica')."</b></td>";
			echo "</tr>";
		echo "</table>";
	
		echo "<form method=POST name='form2' action='?dir=enc_med_clinicas&p=lista'>";
		if($_POST[search]){
			$sql = "SELECT * FROM aso WHERE $_POST[search] = cod_aso ORDER BY cod_aso";
			$result_aso = pg_query($sql);
			$row = pg_fetch_all($result_aso);

			for($x=0;$x<pg_num_rows($result_aso);$x++){
				$sql = "SELECT f.*, c.*, s.* FROM funcionarios f, cliente c, funcao s
				WHERE
				f.cod_cliente = c.cliente_id AND
				f.cod_funcao = s.cod_funcao AND
				c.cliente_id = {$row[$x][cod_cliente]} AND
				f.cod_func = {$row[$x][cod_func]}";
				$result = pg_query($sql);
				$buffer = pg_fetch_array($result);
				echo "<table width=100% border=0>";	
					echo "<tr><td width=100%>";
						echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
							echo "<tr>";	
								echo "<td bgcolor='$color'><b>Empresa: </b>";
								echo $buffer[razao_social];
								echo "</td>";
							echo "</tr>";
						echo "</table>";
						echo "<table width=100%>";	
							echo "<tr>";
								echo "<td width=100%>";
								echo "<b>".utf8_decode('Funcionário').": </b>";
								echo $buffer[nome_func];					
								echo "</td>";
							echo "</tr>";
						echo "</table>";
						echo "<table  width=100% border=0 cellspacing=2 cellpadding=2 >";							
							echo "<tr>";
								echo "<td width=100%>";
								echo "<b>".utf8_decode('Função').": </b>";
								echo $buffer[nome_funcao];						
								echo "</td>";
							echo "</tr>";	
						echo "</table>";
						echo "<table  width=100% border=0 cellspacing=2 cellpadding=2 >";
							echo "<tr>";
								echo "<td class='text' width=100%><b>Exames:</b></td>";
							echo "</tr>";
						echo "</table>";
				$nome_f = $buffer[nome_func];
				$setor_f = $buffer[nome_funcao];
			}
		}
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";

	$sql = "SELECT ae.*, e.* FROM aso_exame ae, exame e WHERE $_POST[search] = ae.cod_aso AND ae.cod_exame = e.cod_exame";
	$result_ex=@pg_query($sql);
	
		for($x=0;$x<@pg_num_rows($result_ex);$x++){
		$row_ex[$x] = @pg_fetch_array($result_ex);
		echo "<td align=left class='text' width=100%>";
		
		echo $row_ex[$x][especialidade];
		         
		$as = $row_ex[$x][cod_aso];
		echo "<input name=aso1 type=hidden value={$row_ex[$x][cod_aso]}>";
	echo "</td>";
    echo "</tr>";
	}
	
	$result = "SELECT * FROM aso WHERE cod_aso = $as";
	$raso = @pg_query($result);
	$buffer = @pg_fetch_array($raso);
	
	$t = "SELECT * FROM clinicas WHERE ativo = 1 ORDER BY razao_social_clinica";
	$tt = pg_query($t);
	//$ttt = pg_fetch_all($tt);
		
	$sq = "SELECT f.*, c.* FROM funcionarios f, cliente c
	WHERE
	f.cod_cliente = c.cliente_id AND
	c.cliente_id = $buffer[cod_cliente] AND
	f.cod_func = $buffer[cod_func]";
	$resul = @pg_query($sq);
	$buff = @pg_fetch_array($resul);

if($resul){

	echo "<tr>";
    echo "<tr><td><b>".utf8_decode('Clínica').":</b></td></tr>";
	echo "<tr><td colspan='2'>";
	echo "<select name='clinic' id='clinic' style=\"width: 600px;\">";
	while ($ttt = pg_fetch_array($tt)) {
		if($ttt[cod_clinica]<>$buffer[cod_clinica]){
			echo "<option value='{$ttt[cod_clinica]}'> $ttt[razao_social_clinica] </option>";
		}else{
			echo "<option value='{$ttt[cod_clinica]}' selected> $ttt[razao_social_clinica] </option>";
		}
	}
	echo "</select></td></tr>";
	
	echo "<tr>";
    echo "<tr><td><b>Tipo de Exame:</b></td></tr>";
    echo "<tr><td><select name='tp_exame' id='tp_exame' style=\"width: 230px;\">";
		
		echo "<option value=''"; 
		if($buffer[tipo_exame]==""){
			echo "selected";
		} 
		echo "> -</option>";
		//0
		echo "<option value='Admissional'"; 
		if($buffer[tipo_exame]=='Admissional'){
			echo "selected";
		} 
		echo "> Admissional</option>";
		//1
		echo "<option value='Demissional'"; 
		if($buffer[tipo_exame]=='Demissional'){
			echo " selected";
		} 
		echo "> Demissional</option>";
		//2
		echo "<option value='".utf8_decode('Mudança de função')."'"; 
		if($buffer[tipo_exame]==utf8_decode('Mudança de função')){
			echo " selected";
		} 
		echo "> ".utf8_decode('Mudança de função')."</option>";
		//3
		echo "<option value='".utf8_decode('Periódico')."'"; 
		if($buffer[tipo_exame]==utf8_decode('Periódico')){
			echo " selected";
		} 
		echo "> ".utf8_decode('Periódico')."</option>";

		echo "<option value='Retorno ao Trabalho'"; 
		if($buffer[tipo_exame]=='Retorno ao Trabalho'){
			echo " selected";
		} 
		echo "> Retorno ao Trabalho</option>";
		
	echo "</select></td></tr>";
	echo "<tr><td><b>ASO data:</b></td></tr>";
    echo "<tr><td align=left class='text'><input disabled type='text' class='inputText' size=10 name=aso_d id=aso_d";
		$dma = explode('-', $buffer[aso_data]);
		echo " value='".$dma[2]."/".$dma[1]."/".$dma[0]."'";
		echo " maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"></td>";
    echo "</tr>";

	echo "</table>";
    
	echo "</table>";
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<table width=100%>";	
	echo "<tr>";
	echo "<td align=center class='text roundborderselected'>";
	
	$confirmbtsql = "SELECT ae.confirma FROM aso_exame ae, exame e WHERE $_POST[search] = ae.cod_aso AND ae.cod_exame = e.cod_exame AND confirma = 1";
	$confirmbtquery = pg_query($confirmbtsql);
	$confirmbt = pg_num_rows($confirmbtquery);
	
	$diaina = date("d");
	$mesina = date("m");
	$anoina = date('Y');
	
	$sqlinatiaso = "SELECT c.cliente_id FROM site_fatura_info fi, cliente c
    WHERE fi.cod_cliente = c.cliente_id
    AND
    fi.cod_filial = c.filial_id
    AND
    (
    ( EXTRACT(year FROM fi.data_vencimento) < $anoina )OR( EXTRACT(day FROM fi.data_vencimento) < $diaina
    AND
    EXTRACT(month FROM fi.data_vencimento) = $mesina
    AND
    EXTRACT(year FROM fi.data_vencimento) = $anoina )OR( EXTRACT(month FROM fi.data_vencimento) < $mesina
    AND
    EXTRACT(year FROM fi.data_vencimento) = $anoina
    )
    )
    AND
    fi.migrado = 0
    AND
    c.status != 'Inativo'
	AND
	c.cliente_id = $buff[cod_cliente]
    GROUP BY c.cliente_id
	ORDER BY cliente_id";
	
	$queryinatiaso = pg_query($sqlinatiaso);
	
	$inatiaso = pg_num_rows($queryinatiaso);
	
	echo "<input name=confirmar type=submit value='Alterar' width='250' class='btn' onmouseover=\"showtip('tipbox', '- ".utf8_decode('Alterar a clínica e o tipo de exame do ASO.')."');\" onmouseout=\"hidetip('tipbox');\">";
	
	echo "<input name=geraraso type=button value='Imprimir' class='btn' onmouseover=\"showtip('tipbox', '- ".utf8_decode('Gerar Visualização para impressão em PDF do encaminhamento.')."');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."exame/?cod_cliente=".$buff[cod_cliente]."&setor=".$buff[cod_setor]."&funcionario=".$buff[cod_func]."&aso=".$as."');\">";
		
	echo "<input name=enviaemail type=button value='Notificar' class='btn' onmouseover=\"showtip('tipbox', '- ".utf8_decode('Enviar notificação para que o cliente saiba que ele foi encaminhado para outra clínica.')."');\" onmouseout=\"hidetip('tipbox');\" onclick=\"var mmm = prompt('Enviar encaminhamento para:','$buff[email]');
			if(mmm){location.href='?dir=enc_med_clinicas&p=aso_mail&funcionario=$buff[cod_func]&aso=$as&cod_cliente=$buff[cod_cliente]&setor=$buff[cod_setor]&email='+mmm+'';
			}\">";
	echo "</td></tr>";
}else{
	showMessage('ASO não encontrado! Verifique o código e tente novamente!');	
}
	echo "</form>";
	echo "</table>";
    echo "</td>";
echo "</tr>";
echo "</table>";
?>