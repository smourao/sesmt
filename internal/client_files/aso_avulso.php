<center>
<table width="500" border="0">
  <tr>
    <td colspan="0"><center><span class="style4"><b>aAGENDAR ASO AVULSO</b></span><br></center></td>
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
           echo "<form method=\"POST\" action=\"?do=aso_avulso&a=3&cod={$_GET[cod]}&set={$_GET[set]}\">";
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
		   $tp = $_GET[tp];
		   
		   if($tp <> 1){
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
		   }else{
		          echo "<tr>";
  	       echo "<td align=center width=30 colspan=3>";
               echo "<b>Será agendado um ASO ADMISSIONAL. </b>";
		   echo "</td>";
		   echo "</tr>";
		   }

           echo "</table>";
           echo "<input type=hidden name=cod_cbo value='{$_POST['cod_cbo']}'>";
           echo "<input type=hidden name=cod_colaborador value='{$_POST['cod_colaborador']}'>";
           echo "<input type=hidden name=exames value=".urlencode(serialize($exames_indicados)).">";
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
       
   //Select the clinica
   if($_GET['a'] == '3'){
       $ex = $_POST['exames'];
       $exames = unserialize(urldecode($_POST['exames']));
       if(count($exames)>0 AND !empty($exames[0])){
           $fix = "";
           for($x=0;$x<count($exames);$x++){
           //$fix .= "ce.cod_exame = '{$exames[$x]}'";
           $fix .= "cod_exame = '{$exames[$x]}'";
           if($x < count($exames)-1){
               $fix.=" OR ";
           }
       }
       
       $cesql = $fix;
		$tipo = $_POST['tipo_exame'];
		if(empty($tipo)){
		$tipo = 1;
		}
       $sql = "SELECT cod_clinica, count(*) as exames FROM clinica_exame WHERE {$fix} GROUP BY cod_clinica HAVING count(*) = ".count($exames);
       $res = pg_query($sql);
       $buffer = pg_fetch_all($res);
       $fix="";
       for($x=0;$x<pg_num_rows($res);$x++){
           $fix .= "(cod_clinica = {$buffer[$x]['cod_clinica']} AND ativo=1)";
           if($x < pg_num_rows($res)-1){
               $fix.=" OR ";
           }
       }
       if(pg_num_rows($res)>0){
           $sql = "SELECT * FROM clinicas WHERE {$fix}";
           $res = pg_query($sql);
           $buffer = pg_fetch_all($res);
       }
       
       if(pg_num_rows($res)>0){
           echo "<p>";
           echo "<center>Selecione uma clínica abaixo para a realização dos exames</center>";
           echo "<p>";
		   

           echo "<table width=100% border=1 cellpadding=5 cellspacing=2>";
           echo "<tr>";
           echo "<td align=center><b>Clínica</b></td>";
           echo "";
           echo "<td align=center width=40%><b>Localização</b></td>";
           echo "</tr>";
           for($x=0;$x<pg_num_rows($res);$x++){
               $sql = "SELECT ce.cod_clinica, sum(cast(ce.preco_exame as numeric)) as preco, c.razao_social_clinica
               FROM clinica_exame ce, clinicas c
               WHERE ($cesql) AND c.cod_clinica = ce.cod_clinica AND c.cod_clinica = {$buffer[$x]['cod_clinica']}
               GROUP BY ce.cod_clinica, c.razao_social_clinica";
               $res_preco = pg_query($sql);
               $preco = pg_fetch_all($res_preco);

               $localizacao = "<center><b>{$buffer[$x]['razao_social_clinica']}</b></center>";
               $localizacao .= "<p>";
               $localizacao .= "<b>Endereço:</b> {$buffer[$x]['endereco_clinica']} <b>Nº</b> {$buffer[$x]['num_end']}";
               $localizacao .= "<br>";
               $localizacao .= "<b>Bairro:</b> {$buffer[$x]['bairro_clinica']}";
               $localizacao .= "<br>";
               $localizacao .= "<b>Cidade:</b> {$buffer[$x]['cidade']}/{$buffer[$x]['estado']}";
               $localizacao .= "<br>";
               $localizacao .= "<b>Referência:</b> {$buffer[$x]['referencia_clinica']}";
               
               echo "<tr>";
               echo "<td><a href='?do=aso_avulso&a=4&set={$_GET[set]}&col={$_GET[cod]}&tp=$tipo&cl={$buffer[$x]['cod_clinica']}&ex={$ex}'>{$buffer[$x]['razao_social_clinica']}</a></td>";
               echo "";
               echo "<td onMouseOver=\"return overlib('{$localizacao}');\" onMouseOut=\"return nd();\">{$buffer[$x]['bairro_clinica']} / {$buffer[$x]['cidade']}</td>";
               echo "</tr>";
          }
          echo "</table>";
          echo "<p><center><input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'></center>";
    }else{
       echo "Não há clínicas cadastradas que façam todos os exames necessários para este funcionário.<p>";
       echo "<center><input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'></center>";
    }
    }else{
    //SE NAO TIVER SELECIONADO EXAMES
       echo "Nenhum exame foi selecionado.<p>";
       echo "<center><input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'></center>";
    }
   }elseif($_GET['a'] == 4){//END IF = 3
       $exames = unserialize(stripslashes($_GET['ex']));//ARRAY COM EXAMES PASSADOS COM POST

       //SELECIONA DADOS DO FUNCIONÁRIO
       $sql = "SELECT f.cod_funcao, f.nome_func, fe.exame_id, fe.descricao, fun.nome_funcao, fun.dsc_funcao
	   FROM funcionarios f, funcao_exame fe, funcao fun
	   WHERE f.cod_cliente = '".$_SESSION['cod_cliente']."' AND f.cod_func = {$_GET['col']} AND f.cod_funcao = fe.cod_exame
	   AND fun.cod_funcao = fe.cod_exame";
       $rss = pg_query($sql);
       $funcionario = pg_fetch_all($rss);

       //SELECIONA DADOS DAS CLINICAS
	   $cl = $_GET[cl];
       $sql = "SELECT * FROM clinicas WHERE cod_clinica = $cl";
       $res = pg_query($sql);
       $buffer = pg_fetch_all($res);
            $localizacao = "<center><b>{$buffer[$x]['razao_social_clinica']}</b></center>";
            $localizacao .= "<p>";
            $localizacao .= "<b>Endereço:</b> {$buffer[$x]['endereco_clinica']} <b>Nº</b> {$buffer[$x]['num_end']}";
            $localizacao .= "<br>";
            $localizacao .= "<b>Bairro:</b> {$buffer[$x]['bairro_clinica']}";
            $localizacao .= "<br>";
            $localizacao .= "<b>Cidade:</b> {$buffer[$x]['cidade']}/{$buffer[$x]['estado']}";
            $localizacao .= "<br>";
            $localizacao .= "<b>Referência:</b> {$buffer[$x]['referencia_clinica']}";
            $fix = "";
            for($x=0;$x<count($exames);$x++){
                $fix .= "ce.cod_exame = {$exames[$x]}";
               if($x < count($exames)-1){
                   $fix.=" OR ";
               }
            }
         //SELECIONA PRECO DOS EXAMES
         $sql = "SELECT ce.*, e.especialidade FROM clinica_exame ce, exame e
         WHERE ce.cod_clinica={$_GET['cl']} AND ce.cod_exame = e.cod_exame AND ($fix)";
         $r = pg_query($sql);
         $data = pg_fetch_all($r);
		 
		 if ($_GET['tp'] == 1) $tipo_exame = "ADMISSIONAL";
		 if ($_GET['tp'] == 2) $tipo_exame = "DEMISSIONAL";
		 if ($_GET['tp'] == 3) $tipo_exame = "PERIÓDICO";
		 if ($_GET['tp'] == 4) $tipo_exame = "MUDANÇA DE FUNÇÃO";
		 if ($_GET['tp'] == 5) $tipo_exame = "RETORNO AO TRABALHO";
         
         //print_r($data);
		 echo "<b>$tipo_exame</b>";
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
         
         echo "<center><b>Dados da Clínica</b></center>";
         echo "<table width=100% border=1 cellpadding=5 cellspacing=2>";

         echo "<tr>";
         echo "<td align=left width=25%><b>Clínica</b></td>";
         echo "<td width=75%>{$buffer[0]['razao_social_clinica']}&nbsp;</td>";
         echo "</tr>";
         echo "<tr>";
         echo "<td align=left><b>Endereço</b></td>";
         echo "<td>{$buffer[0]['endereco_clinica']} Nº {$buffer[0]['num_end']}&nbsp;</td>";
         echo "</tr>";
         echo "<tr>";
         echo "<td align=left><b>Bairro</b></td>";
         echo "<td>{$buffer[0]['bairro_clinica']}&nbsp;</td>";
         echo "</tr>";
         echo "<tr>";
         echo "<td align=left><b>Cidade/Estado</b></td>";
         echo "<td>{$buffer[0]['cidade']}/{$buffer[0]['estado']}&nbsp;</td>";
         echo "</tr>";
         echo "<tr>";
         echo "<td align=left><b>Referência</b></td>";
         echo "<td>{$buffer[0]['referencia_clinica']}&nbsp;</td>";
         echo "</tr>";
                           
         echo "</table>";
         echo "<p>";
         
         echo "<font color=red>
         *Os exames serão selecionados pelo nosso setor médico, em breve você receberá o encaminhamento por email.
         </font>";
         echo "<p><table><tr><td>";
         echo "<input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'>";
         echo "&nbsp;";
         $get = "cliente={$_SESSION['cod_cliente']}&clinica={$buffer[0]['email_clinica']}&col={$_GET['col']}&cl={$_GET['cl']}&set={$_GET['set']}";

		 echo '</td><td><a target="_parent" href="?do=confirmar_aso&'.$get.'&tp='.$_GET[tp].'&data_agendamento='.date("Y-m-d").' "><img src="http://sesmt-rio.com/images/conf_aso.jpg" width="170" height="21"></a></td></tr></table>';
         echo "<p>";
}//END IF = 3
}
?>
</body>
</html>
