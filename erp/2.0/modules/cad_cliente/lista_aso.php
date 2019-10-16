<?php

echo '
<script language="Javascript">
function showDiv(div)
{
document.getElementById("Apto com Restricao").className = "invisivel";

document.getElementById(div).className = "visivel";
}
</script>
<style>
.invisivel { display: none; }
.visivel { visibility: visible; }
</style>';


if($_GET[m] == 1){
showMessage('Notificação enviada com sucesso!');
}
if($_GET[pq]){
	$_POST[search] = $_GET[pq];
}
if($_GET[pq] == 1){	
}

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
		$sql="UPDATE aso_exame SET confirma= 1, data_repasse = '$dat', data = '${dtaso[$key]}'  WHERE cod_exame = '$schkbox' AND cod_aso = $_POST[aso1] ";
		$query = pg_query($sql); 
		$per = ($buffer[preco_exame]*$buffer[por_exames])/100;
		$sql3 = "INSERT INTO repasse (cod_exame, cod_aso, cod_clinica, valor, cod_func, cod_cliente, confirma_data) VALUES ('$schkbox', '$_POST[aso1]', '$buffer[cod_clinica]', '$per', '$ttt[cod_func]', '$ttt[cod_cliente]', '$dat')";
		$query3 = @pg_query($sql3);
		}
		if($query){
		}
	}else{
		$t = "SELECT * FROM aso WHERE cod_aso = $_POST[aso1]";
		$tt = pg_query($t);
		$ttt = pg_fetch_array($tt);
		$sqll = "SELECT c.*, a.*, ce.*, ae.* FROM clinicas c, aso a, clinica_exame ce, aso_exame ae WHERE a.cod_clinica = c.cod_clinica AND a.cod_aso = $_POST[aso1] AND ae.cod_exame = '$chkbox' AND ce.cod_exame = '$chkbox' AND ce.cod_clinica = a.cod_clinica";
	    $res = @pg_query($sqll);
	    $buffer = @pg_fetch_array($res);
		$sql="UPDATE aso_exame SET confirma= 1, data = '$dtaso'  WHERE cod_exame = '$chkbox' AND cod_aso = $_POST[aso1] ";
		$query = @pg_query($sql); 
		$per = ($buffer[preco_exame]*$buffer[por_exames])/100;
		$sql3 = "INSERT INTO repasse (cod_exame, cod_aso, cod_clinica, valor, cod_func, cod_cliente) VALUES ('$chkbox', '$_POST[aso1]', '$buffer[cod_clinica]', '$per', '$ttt[cod_func]', '$ttt[cod_cliente]')";
		$query3 = @pg_query($sql3);

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
	$dma = explode('/', $buffer[aso_data]);
	$aso_d = $dma[2]."-".$dma[1]."-".$dma[0];
	$sql6="UPDATE aso SET aso_data = '$aso_d' WHERE cod_aso = $_POST[aso1]";
	$query6 = @pg_query($sql6); 
}



$count = 0;
$datas = array();
while(count($datas)<30){
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
                echo "<form method=POST name='form1' action='?dir=gerar_aso&p=lista_aso'>";
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
	echo "<td align=center class='text roundborderselected'><b>Resultado da Pesquisa</b></td>";
	echo "</tr>";
	echo "</table>";
	
	echo "<form method=POST name='form2' action='?dir=gerar_aso&p=lista_aso'>";
	if($_POST[search]){
		$sql = "SELECT * FROM aso WHERE $_POST[search] = cod_aso ORDER BY cod_aso";
		$result_aso = pg_query($sql);
		$row = pg_fetch_all($result_aso);
		for($x=0;$x<pg_num_rows($result_aso);$x++){
		$sql = "SELECT f.*, c.*, s.* FROM funcionarios f, cliente c, setor s
		WHERE
		f.cod_cliente = c.cliente_id AND
		f.cod_setor = s.cod_setor AND
		c.cliente_id = {$row[$x][cod_cliente]} AND
		f.cod_func = {$row[$x][cod_func]}";
		$result = pg_query($sql);
		$buffer = pg_fetch_array($result);	
		echo "<table width=100% border=0>";	
		echo "<tr><td width=60%>";
		echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
		echo "<tr>";	
		echo "<td bgcolor='$color'><b>Empresa:</b></td>";
		echo "</tr>";
		echo "<tr>";	
		echo "<td>" . $buffer[razao_social] . "</td>";
		echo "</tr>";
		echo "</table>";
		echo "<table  width=100% border=0 cellspacing=2 cellpadding=2 >";
		echo "<tr>";
		echo "<td class='text' width=100%><b>Exames feitos:</b>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		$nome_f = $buffer[nome_func];
		$setor_f = $buffer[nome_setor];
	}
	}
		
	echo "<table width=100% border=0 cellspacing=2 cellpadding=2>";
    echo "<tr>";

	$sql = "SELECT ae.*, e.* FROM aso_exame ae, exame e WHERE $_POST[search] = ae.cod_aso AND ae.cod_exame = e.cod_exame";
	$result_ex=@pg_query($sql);
	
		for($x=0;$x<@pg_num_rows($result_ex);$x++){
		$row_ex[$x] = @pg_fetch_array($result_ex);
		echo "<td align=left class='text' width=100%>";
		echo "<input name=confirma[] type=checkbox value={$row_ex[$x][cod_exame]}";
		if ($row_ex[$x][confirma] == 0){
		echo ">";
				
		}else{
		echo " checked disabled >";
		}
		echo " <b>Exame:</b> ";
		echo $row_ex[$x][especialidade];
		
         echo "<td width=70%>";
            echo "<select name=aso_data[] id=aso_data";
			
			if ($row_ex[$x][confirma] == 0){
			echo ">";
				
			}else{
			echo " disabled=disabled >";
			}
			if ($row_ex[$x][confirma] == 1){
                echo "<option value='".date("Y-m-d", strtotime($row_ex[$x][data]))."'>".date("d-m-Y", strtotime($row_ex[$x][data]))."</option>";
			}
            for($d=0;$d<count($datas);$d++){
                echo "<option value='".date("Y-m-d", strtotime($datas[$d]))."'>".date("d-m-Y", strtotime($datas[$d]))."</option>";
            }
            echo "</select>";
         echo "</td>";
         
		$as = $row_ex[$x][cod_aso];
		echo "<input name=aso1 type=hidden value={$row_ex[$x][cod_aso]}>";
	echo "</td>";
    echo "</tr>";
	}
	
	$result = "SELECT * FROM aso WHERE cod_aso = $as";
	$raso = @pg_query($result);
	$buffer = @pg_fetch_array($raso);
	
	$t = "SELECT * FROM clinicas";
	$tt = pg_query($t);
	$ttt = pg_fetch_all($tt);
		
	$sq = "SELECT f.*, c.* FROM funcionarios f, cliente c
		WHERE
		f.cod_cliente = c.cliente_id AND
		c.cliente_id = $buffer[cod_cliente] AND
		f.cod_func = $buffer[cod_func]";
		$resul = @pg_query($sq);
		$buff = @pg_fetch_array($resul);

if($resul){

	if($buffer[cod_clinica] == 0){
	echo "<tr><td>";
	echo "<select name='clinic' id='clinic' style=\"width: 230px;\">";
	echo "<option value='' selected=selected></option>";
	for($x=0;$x<=pg_num_rows($tt);$x++){
		echo "<option value='{$ttt[$x][cod_clinica]}'>{$ttt[$x][razao_social_clinica]}	</option>";
	}
	echo "</select></td></tr>";
	}
	
		echo "<tr>";
    echo "<tr><td><b>Classificação da Atividade:</b></td></tr>";
    echo "<tr><td><select name='clas' id='clas' style=\"width: 230px;\">";
		
		echo "<option value='0'"; 
		if($buffer[classificacao_atividade_id]==""){
			echo "selected";
		} 
		echo "></option>";
		//0
		echo "<option value='1'"; 
		if($buffer[classificacao_atividade_id]==1){
			echo "selected";
		} 
		echo ">Penosa</option>";
		//1
		echo "<option value='2'"; 
		if($buffer[classificacao_atividade_id]==2){
			echo " selected";
		} 
		echo ">Insalubre</option>";
		//2
		echo "<option value='3'"; 
		if($buffer[classificacao_atividade_id]==3){
			echo " selected";
		} 
		echo ">Periculosa</option>";
		//3
		echo "<option value='4'"; 
		if($buffer[classificacao_atividade_id]==4){
			echo " selected";
		} 
		echo ">Nenhuma das Situações</option>";
		
	echo "</select></td>";
    echo "</tr>";
	echo "<tr>";
    echo "<tr><td><b>Resultado:</b></td><td><b>ASO data:</b></td></tr>";
    echo "<tr><td><select name='aso2' id='aso2' onchange=\"showDiv(this.value);\" style=\"width: 230px;\">";
		
		echo "<option value=''"; 
		if($buffer[aso_resultado]==""){
			echo "selected";
		} 
		echo "></option>";
		//0
		echo "<option value='Apto'"; 
		if($buffer[aso_resultado]=="Apto"){
			echo "selected";
		} 
		echo ">Apto</option>";
		//1
		echo "<option value='Apto a manipular alimentos'"; 
		if($buffer[aso_resultado]=="Apto a manipular alimentos"){
			echo " selected";
		} 
		echo ">Apto à manipular alimentos</option>";
		//2
		echo "<option value='Apto para trabalhar em altura'"; 
		if($buffer[aso_resultado]=="Apto para trabalhar em altura"){
			echo " selected";
		} 
		echo ">Apto para trabalhar em altura</option>";
		//3
		echo "<option value='Apto para operar empilhadeira'"; 
		if($buffer[aso_resultado]=="Apto para operar empilhadeira"){
			echo " selected";
		} 
		echo ">Apto para operar empilhadeira</option>";
		//4
		echo "<option value='Apto para trabalhar em espaco confinado'"; 
		if($buffer[aso_resultado]=="Apto para trabalhar em espaco confinado"){
			echo " selected";
		} 
		echo ">Apto para trabalhar em espaço confinado</option>";
		//5
		echo "<option value='Inapto'";
		if($buffer[aso_resultado]=="Inapto"){
			echo " selected";
		} 
		echo ">Inapto</option>";
		//6
		echo "<option value='Apto com Restricao'"; 
		if($buffer[aso_resultado]=="Apto com Restricao"){
			echo " selected";
		} echo ">Apto com Restrição</option>";
		
	echo "</select></td>";
    echo "<td align=left class='text'><input type='text' class='inputText' size=10 name=aso_d id=aso_d";
		$dma = explode('-', $buffer[aso_data]
		echo " value='".$dma[2]."/".$dma[1]."/".$dma[0]."'";
		echo " maxlength=10 onkeypress=\"formatar(this, '##/##/####');\"></td>";
    echo "</tr>";
	echo '<tr><td>
		<div id="Apto com Restricao" ';
			if($buffer[aso_resultado]=="Apto com Restricao"){
				echo ' class="visivel">';
			}else{
				echo ' class="invisivel">';
			}
			echo'
			<textarea name="obs" id="obs" cols="26" rows="3">'.$buffer[obs].'</textarea>
		</div>
		</td></tr>';
	echo "</table>";
    echo "</td>";
    echo "<td width=40% valign=top>";
	
	echo "<table width=100%>";	
	echo "<tr>";
	echo "<td width=100%>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<b>Funcionário:</b>";					
	echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td width=100%>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo $nome_f;			
	echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td width=100%>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<b>Setor: </b>";
	echo $setor_f;						
	echo "</td>";
	echo "</tr>";	
	echo "</table>";
	
    echo "</td>";
	echo "</table>";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	echo "<table width=100%>";	
	echo "<tr>";
	echo "<td align=center class='text roundborderselected'>";
	
	echo "<input name=confirmar type=submit value='Confirmar ASO' width='250' class='btn' onmouseover=\"showtip('tipbox', '- Confirmar exames e resultado do ASO.');\" onmouseout=\"hidetip('tipbox');\">
	<input name=geraraso type=button value='Ver/Gerar ASO' class='btn' onmouseover=\"showtip('tipbox', '- Gerar e Visualizar PDF do ASO.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"newWindow('".current_module_path."exame/?cod_cliente=".$buff[cod_cliente]."&setor=".$buff[cod_setor]."&funcionario=".$buff[cod_func]."&aso=".$as."');\">
		<input name=enviaemail type=button value='Notificar' class='btn' onmouseover=\"showtip('tipbox', '- Enviar notificação para que o cliente saiba que o ASO encontra-se disponível no site.');\" onmouseout=\"hidetip('tipbox');\" onclick=\"var mmm = prompt('Enviar este ASO para:','$buff[email]');
			if(mmm){			location.href='?dir=gerar_aso&p=aso_mail&funcionario=$buff[cod_func]&aso=$as&cod_cliente=$buff[cod_cliente]&setor=$buff[cod_setor]&email='+mmm+'';
			}\">
";
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