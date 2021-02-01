<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<center>
<table width="500" border="0">
  <tr>
    <td colspan="0"><center><span class="style4"><b>AGENDAR PPP AVULSO</b></span><br></center></td>
  </tr>
  <tr>
    <td colspan="0" align="justify"><?php if(!$_GET[a]){echo '
    	<br>&nbsp;&nbsp;&nbsp;&nbsp;Bem vindo ao ambiente de <b>PPP AVULSO</b>, caso não tenha colaboradores cadastrados, basta clicar no botão verde <b>"Cadastrar novo colaborador"</b> e seguir as instruções, ou apenas clique no nome do colaborador listado.
		
    	<br>&nbsp;&nbsp;&nbsp;&nbsp;O valor do PPP é de <b>R$120,00, (Cento e vinte reais)</b> a serem depositados por PPP agendado em conta corrente da SESMT.    <br><b>Bco:</b> 001    <br><b>Ag.:</b> 0576-2    <br><b>C/C:</b> 38858-0    <br><b>Nome:</b> Banco do Brasil<br>
&nbsp;&nbsp;&nbsp;&nbsp;Encaminhado o comprovante por e-mail a: medicotrab@sesmt-rio.com
		<br>&nbsp;&nbsp;&nbsp;&nbsp;O PPP será enviado para o e-mail cadastrado no prazo de 120 horas no máximo.';}?>

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
		echo "<td align='center' class='bgTitle' colspan='3'><a href=\"?do=col_ppp_avulso\">
				<img src='../images/cadastroppp.png' border=0 alt='Cadastrar colaborador' title='Cadastrar colaborador'>
				</a></td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td class='bgTitle' align='center' colspan='3'><b>Lista de Colaboradores</b></td>";
    echo "</tr>";
	echo "<tr>";
    	echo "<td class='bgTitle' align=center width=20>Cód.</td>";
    	echo "<td class='bgTitle' align=center>Nome</td>";
		echo "<td class='bgTitle' align=center>Opções</td>";
	echo "</tr>";
	for($x=0;$x<pg_num_rows($res);$x++){
        if($x%2)
            $bgclass = 'bgContent1';
        else
            $bgclass = 'bgContent2';
			
			
			$nomefunc = $col[$x]['nome_func'];
			
			$versolisql = "SELECT * FROM ppp_avulso WHERE cod_func = ".$col[$x][cod_func]." AND cod_cliente = ".(int)($_SESSION[cod_cliente]);
			$versoliquery = pg_query($versolisql);
			$versoli = pg_num_rows($versoliquery);
			$versoliid = pg_fetch_array($versoliquery);
			$idppp = $versoliid[id];
			$statusok = $versoliid[status_ppp];
			

        echo "<tr>";
        echo "<td align='center' class='$bgclass' align=center>{$col[$x][cod_func]}</td>";
        echo "<td align='center' class='$bgclass'>{$col[$x][nome_func]}</td>";
		
		if($versoli >= 1){
			if($statusok == 1){
				
				
			echo "<td align='center' class='$bgclass'><a href='http://www.sesmt-rio.com/erp/2.0/modules/gerar_ppp_avulso/relatorio/index.php?id=".$idppp."'>Visualizar</td>";
			
			}else{
				
			echo "<td align='center' class='$bgclass'>PPP Solicitado</td>";
				
			}
		}else{
			echo "<td align='center' class='$bgclass'><a href='?do=col_ppp_avulso&funid=".$col[$x][cod_func]."&complppp=true'>Completar cadastro para o PPP</a></td>";
		}
		
        echo "</tr>";
	}
	echo "</table>";
}
}
?>
</body>
</html>
