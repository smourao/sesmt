<center>
<table width="500" border="0">
  <tr>
    <td colspan="0"><center><span class="style4"><b>AGENDAR ASO AVULSO</b></span><br></center></td>
  </tr>
  <tr>
    <td colspan="0" align="justify"><?php if(!$_GET[a]){echo '
    	<br>&nbsp;&nbsp;&nbsp;&nbsp;Bem vindo ao ambiente de <b>ASO AVULSO</b>, caso não tenha colaboradores cadastrados, basta clicar no botão verde <b>"Cadastrar novo colaborador para aso admissional"</b> e seguir as instruções, ou apenas clique no nome do colaborador listado.
		<br>&nbsp;&nbsp;&nbsp;&nbsp;Ao finalizar este processo, será gerado um encaminhamento para que o colaborador possa ir até uma das clínica conveniadas, escolhida por sua empresa e realizar os exames dignósticos requeridos para a função.
    	<br>&nbsp;&nbsp;&nbsp;&nbsp;O valor do ASO é de <b>R$35,00, (Trinta e cinco reais)</b> a serem depositados por ASO agendado em conta corrente da SESMT.    <br><b>Bco:</b> 001    <br><b>Ag.:</b> 0576-2    <br><b>C/C:</b> 38858-0    <br><b>Nome:</b> Banco do Brasil<br>
&nbsp;&nbsp;&nbsp;&nbsp;Encaminhado o comprovante por e-mail a: medicotrab@sesmt-rio.com
		<br><br>&nbsp;&nbsp;&nbsp;&nbsp;As custas com exames diagnósticos complementares caso seja necessário, devem ser pagos a vista diretamente na clínica de acordo com o valor informado no processo de agendamento.
		<br>&nbsp;&nbsp;&nbsp;&nbsp;O ASO será enviado para o e-mail cadastrado no prazo de 120 horas no máximo, que o prazo das clínicas remeterem os resultados dos exames para a SESMT.';}?>

</td>
  </tr>
</table><br />

<?PHP

if(isset($_GET['d'])){

    $dia = $_GET['d'];

}else{

    $dia = date("d");

}

$dia_v = $dia - 5;

if(!isset($_SESSION[mi])){

    $_SESSION[mi] = date("m");

}

if(!isset($_SESSION[yi])){

    $_SESSION[yi] = date("Y");

}



if(isset($_GET['m'])){

    $mes = $_GET['m'];

    $_SESSION[mi] = $mes;

}else{

    if(isset($_SESSION[mi])){

        $mes = $_SESSION[mi];

    }else{

        $mes = date("m");

    }

}



if(isset($_GET['y'])){

    $ano = $_GET['y'];

    $_SESSION[yi] = $ano;

}else{

    if(isset($_SESSION[yi])){

        $ano = $_SESSION[yi];

    }else{

        $ano = date("Y");

    }

}

session_start();
			$t   = "SELECT cod_cliente, data_vencimento, migrado FROM site_fatura_info WHERE cod_cliente = $_SESSION[cod_cliente] 

					AND

					(

					(

					--EXTRACT(month FROM data_vencimento) < {$mes}

					--AND

					EXTRACT(year FROM data_vencimento) < {$ano}

					)OR(

					EXTRACT(day FROM data_vencimento) < {$dia_v}

					AND

					EXTRACT(month FROM data_vencimento) = {$mes}

					AND

					EXTRACT(year FROM data_vencimento) = {$ano}

					)OR(

					EXTRACT(month FROM data_vencimento) < {$mes}

					AND

					EXTRACT(year FROM data_vencimento) = {$ano}

					)

					)

					AND

					migrado = 0";
					
			$tt  = @pg_query($t);
			


$sql1 = "SELECT * FROM funcao_exame ORDER BY cod_exame, exame_id";
$query1 = pg_query($sql1);
$array1 = pg_fetch_all($query1);

for($x=0;$x<pg_num_rows($query1);$x++){
	if(
	   (($array[$x][cod_exame] == $array[$x-1][cod_exame]) 
	&& ($array[$x][exame_id] == 22 || $array[$x-1][exame_id] == 22))
	|| (($array[$x][cod_exame] == $array[$x+1][cod_exame]) 
	&& ($array[$x][exame_id] == 22 || $array[$x+1][exame_id] == 22))){
		$sql2 = "DELETE FROM funcao_exame WHERE cod_exame = ".$array[$x][cod_exame]." AND exame_id = 22";
		$query2 = pg_query($sql2);
	}
}


//TELA INICIAL - LISTA DE FUNCIONARIOS
if(pg_num_rows($tt) == 0){
if(!$_GET['a'] && $_SESSION['cod_cliente'] != '0'){
	$numreg = 5;

	if (!isset($_GET['pg'])) {
		$pg = 0;
	}

	$inicial = $pg * $numreg;
	
	// Serve para contar quantos registros você tem na sua tabela para fazer a paginação
	$sql_conta = "SELECT * FROM funcionarios where cod_cliente = {$_SESSION[cod_cliente]} AND cod_status = 1 LIMIT $inicial, $numreg";
	$sql_c = pg_query($sql_conta);
	
	$quantreg = pg_num_rows($sql_c); // Quantidade de registros pra paginação
    //print_r($_POST);
    //include("paginacao.php"); // Chama o arquivo que monta a paginação. ex: << anterior 1 2 3 4 5 próximo >>
    
    //echo "<br>jh<br>".$sql_conta; // Vai servir só para dar uma linha de espaço entre a paginação e o conteúdo

	$sql = "SELECT * FROM funcionarios WHERE cod_cliente = {$_SESSION[cod_cliente]} AND cod_status = 1 ORDER BY nome_func ASC ";
	$res = pg_query($sql);
	$col = pg_fetch_all($res);
	
	echo "<table width='100%' border='0' cellpadding='2' cellspacing='2'>";
	echo "<tr>";
		echo "<td align='center' class='bgTitle' colspan='2'><a href=\"?do=col_avulso\">
				<img src='images/button.gif' border=0 alt='Cadastrar colaborador' title='Cadastrar colaborador'>
				</a></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class='bgTitle' align='center' colspan='2'><b>Lista de Colaboradores</b></td>";
    echo "</tr>";
	echo "<tr>";
    	echo "<td class='bgTitle' align=center width=20>Cód.</td>";
    	echo "<td class='bgTitle' align=center>Nome</td>";
	echo "</tr>";
	for($x=0;$x<pg_num_rows($res);$x++){
        if($x%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';

        echo "<tr>";
        echo "<td class='$bgclass' align=center><a href='?do=aso_avulso&a=2&cod={$col[$x][cod_func]}&set={$col[$x][cod_setor]}'>{$col[$x][cod_func]}</a></td>";
        echo "<td class='$bgclass'><a href='?do=aso_avulso&a=2&cod={$col[$x][cod_func]}&set={$col[$x][cod_setor]}'>{$col[$x][nome_func]}</a></td>";
        echo "</tr>";
	}
	echo "</table>";
}else{
   //Show the list of Clinicas
   if($_GET[a] == 2 ){
           $sql = "SELECT * FROM funcionarios WHERE cod_cliente = ".(int)($_SESSION['cod_cliente'])." AND cod_func = ".(int)$_GET[cod];
           $res = pg_query($sql);
           $buffer = pg_fetch_all($res);
           
			$sql = "SELECT fe.*, f.*, fu.*, ex.* FROM funcionarios f, funcao fu, exame ex, funcao_exame fe 
					WHERE f.cod_func = '".$_GET['cod']."' 
					AND fu.cod_funcao = f.cod_funcao 
					AND f.cod_cliente = '".$_SESSION['cod_cliente']."' 
					AND fe.cod_exame = f.cod_funcao
					AND fe.exame_id = ex.cod_exame";
				   	
           $res = pg_query($sql);
           $buffer = pg_fetch_all($res);

           $txt = "";
           $txt .= "<b>Exames Indicados para a Função</b>";
           $txt .= "<p>";
           $exames_indicados = array();
           for($x=0;$x<pg_num_rows($res);$x++){
               $exames_indicados[] = $buffer[$x]['cod_exame'];
               $txt .= $buffer[$x]['especialidade'];
               $txt .= "<br>";
           }		   echo pg_num_rows($res2);
           echo "<p>";
           echo "<center>Verifique os dados do colaborador selecionado</center>";
           echo "<p>";
           echo "<form method=\"POST\" action=\"?do=aso_avulso&a=4&cod={$_GET[cod]}&set={$_GET[set]}&col={$buffer[0][cod_func]}&fun={$buffer[0][cod_func]}\">";
           echo "<table width=500 border=1 cellpadding=5 cellspacing=2>";
           echo "<tr>";
           echo "<td align=center width=30><b>Cod.</b></td>";
           echo "<td align=center><b>Colaborador</b></td>";
           echo "<td align=center width=200><b>Função</b></td>";
           if(pg_num_rows($res)>0){
			   echo "<tr>";
			   echo "<td align=center width=30>{$buffer[0][cod_func]}</td>";
			   echo "<td>{$buffer[0]['nome_func']}</td>";
			   echo "<td >{$buffer[0]['nome_funcao']}</td>";
			   echo "</tr>";
           }
		   
           echo "<tr>";
  	       echo "<td align=center width=30 colspan=3>";
               echo "<b>Tipo de exame: </b>";
               echo "<select name=tipo_exame id=tipo_exame>";
                    echo "<option value='1'>Admissional</option>";
                    echo "<option value='2'>Demissional</option>";
                    echo "<option value='3' selected>Periódico</option>";
                    echo "<option value='4'>Mudança de função</option>";
					echo "<option value='5'>Retorno ao trabalho</option>";
               echo "</select>";
		   echo "</td>";
		   echo "</tr>";

           echo "</table>";
           echo "<input type=hidden name=cod_cbo value='{$_POST['cod_cbo']}'>";
           echo "<input type=hidden name=cod_colaborador value='{$_POST['cod_colaborador']}'>";
           echo "<p><input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'>";
           if(pg_num_rows($res)>0){
               echo "<input type=submit class=button value='Avançar'>";
           }

           echo "</form>";
           //print_r($exames_indicados);
      	if(pg_num_rows($res) == 0){
			echo "<br>Código do Colaborador Inválido.<p>";
			echo "<input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'>";
        }
    }
	}
       
	if($_GET['a'] == 4){//END IF = 3
       //SELECIONA DADOS DO FUNCIONÁRIO
       $sql = "SELECT f.cod_funcao, f.nome_func, fe.exame_id, fe.descricao, fun.nome_funcao, fun.dsc_funcao
	   FROM funcionarios f, funcao_exame fe, funcao fun
	   WHERE f.cod_cliente = '".$_SESSION['cod_cliente']."' AND f.cod_func = {$_GET['col']} AND f.cod_funcao = fe.cod_exame
	   AND fun.cod_funcao = fe.cod_exame";
       $rss = pg_query($sql);
       $funcionario = pg_fetch_all($rss);
	   $tp=$_POST[tipo_exame];
		 
		 if ($tp == 1) $tipo_exame = "ADMISSIONAL";
		 if ($tp == 2) $tipo_exame = "DEMISSIONAL";
		 if ($tp == 3) $tipo_exame = "PERIÓDICO";
		 if ($tp == 4) $tipo_exame = "MUDANÇA DE FUNÇÃO";
		 if ($tp == 5) $tipo_exame = "RETORNO AO TRABALHO";

         //print_r($data);
         echo "<p>";
         echo "<center>Confirme os dados para finalizar o agendamento</center>";
         echo "<p>";
         echo "<center><b>Dados do Colaborador</b></center>";
         echo "<table width=100% border=1 cellpadding=5 cellspacing=2>";
         echo "<tr>";
         echo "<td align=center width=5%><b>Cod.</b></td>";
         echo "<td align=center width=50%><b>Nome</b></td>";
         echo "<td align=center><b>Função</b></td>";
         echo "</tr>";
         echo "<tr>";
         echo "<td align=center>{$_GET['col']}</td>";
         echo "<td>{$funcionario[0]['nome_func']}</td>";
         echo "<td>{$funcionario[0]['nome_funcao']}</td>";
         echo "</tr>";
         echo "</table>";
         echo "<p>";
         echo "<font color=red>
         *Os exames serão selecionados pelo nosso setor médico, em breve você receberá o encaminhamento por email.
         </font>";
         echo "<p>";
         echo "<form method=\"POST\" action=\"?do=aso_avulso&a=5&cliente={$_SESSION['cod_cliente']}&conf=1&col={$_GET['col']}&set={$_GET['set']}&tp=$tp\">";
         echo "<input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'>";
		 echo "<input type=submit class=button value='Confirmar agendamento'>";
		 echo "</form>";
         echo "&nbsp;";
         $get = "cliente={$_SESSION['cod_cliente']}&con=1&col={$_GET['col']}&set={$_GET['set']}&tp=$tp";

		/* echo '</td><td><a target="_parent" href="?do=confirmar_aso&'.$get.'&tp='.$_POST[tipo_exame].' "><img src="http://sesmt-rio.com/images/conf_aso.jpg" width="170" height="21"></a></td></tr></table>';*/
         echo "<p>";
	}//END IF = 3
	if($_GET['a'] == 5){//END IF = 3
	
		 if ($_GET[tp] == 1) $tipo_exame = "Admissional";
		 if ($_GET[tp] == 2) $tipo_exame = "Demissional";
		 if ($_GET[tp] == 3) $tipo_exame = "Periódico";
		 if ($_GET[tp] == 4) $tipo_exame = "Mudança de Função";
		 if ($_GET[tp] == 5) $tipo_exame = "Retorno ao Trabalho";

		$data_agendamento = date('Y-m-d');
		//SELECIONAR DADOS DO CLIENTE E FUNCIONARIO
		$sqlcf = "SELECT c.*, f.*, u.* FROM cliente c, funcionarios f, funcao u 
				  WHERE c.cliente_id = '$_GET[cliente]'
				  AND   f.cod_cliente = '$_GET[cliente]'
				  AND   f.cod_funcionario = '$_GET[col]'
				  AND   u.cod_funcao = f.cod_funcao";
		$querycf = pg_query($sqlcf);
		$arraycf = pg_fetch_array($querycf);
		
		/*ACRESCENTAR UM ASO*/
		$query_max = "SELECT max(cod_aso) as cod_aso FROM aso";
		$result_max = pg_query($query_max);
		$row_max = pg_fetch_array($result_max);
		$cod_aso = $row_max[cod_aso] + 1;
		
		//VERIFICAR SE JA TEM UM ASO AGENDADO RECENTEMENTE
		$sqlver = "SELECT * FROM aso WHERE cod_func = '$_GET[col]' AND cod_cliente = '$_GET[cliente]' AND EXTRACT (MONTH FROM aso_data) = ".date('m')." AND EXTRACT (YEAR FROM aso_data) = ".date('Y')." ORDER BY cod_aso DESC";
		$queryver = pg_query($sqlver);
		$ary = pg_fetch_array($queryver);
		
		if(pg_num_rows($queryver) == 0 && $_GET[conf]){
			$query_insert = "INSERT INTO aso (cod_aso, cod_cliente, aso_data, cod_func, tipo_exame, cod_setor, tipo)
							VALUES ('$cod_aso', '$_GET[cliente]', '$data_agendamento', '$_GET[col]', '$tipo_exame', '$_GET[set]', 1)";
			if($quey = pg_query($query_insert)){
			echo "Seu agendamento será analisado pela nossa equipe, logo voce receberá um email com o encaminhamento para seu funcionário.";
			}else{
				echo pg_last_error();
			}
			$msg = "Olá Luciana, foi solicitado um encaminhamento para ASO avulso através do site, entre no ambiente <b>'Encaminhamento Avulso'</b> no sistema e pesquise pelo <b>código: $cod_aso </b>para inserir os exames necessários e enviar o encaminhamento para o cliente.";
			$headers = "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\n";
			$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";
			mail("suporte@ti-seg.com;medicotrab@sesmt-rio.com", "SESMT - Solicitação de encaminhamento para ASO avulso Nº: ".$cod_aso, $msg, $headers);
		
		}elseif(pg_num_rows($queryver) != 0 && $_GET[conf]){
			echo "<table border=0><tr><td align='justify'>Prezado cliente, já foi feito um agendamento para esse funcionário recentemente, portanto, não será possível fazer um novo agendamento. 
			<br><br>Se realmente já tenha feito o agendamento e ainda não recebeu o encaminhamento por email, envie um email solicitando para <b>medicotrab@sesmt-rio.com</b> informando o seguinte<b> código: ".$ary[cod_aso]."</b>
			<br><br>Caso não tenha feito um agendamento para o funcionário anteriormente, entrar em contato com nosso setor de suporte através do email: <b>suporte@sesmt-rio.com</b>, também informando o <b>código: ".$ary[cod_aso]."</b></td></tr></table>";
		}
	}
}
?>
</body>
</html>
