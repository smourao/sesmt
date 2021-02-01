<center>
<table width="500" border="0">
  <tr>
    <td colspan="0"><center><span class="style4"><b>AGENDAR ASO</b></span><br></center></td>
  </tr>
</table><br />

<?PHP


if((date("y.m.d") >= '15.12.17') && (date("y.m.d") <= '16.01.10')){


if(!$_GET['nomostrar']){
	
	echo "<font face='Arial, Helvetica, sans-serif' color='#FF0000'><center><b>RECESSO FINAL DE ANO</b>
	
	<p>

<b>COMUNICADO RECESSO FINAL DE ANO</b></center>

<p>

Nós da Empresa SESMT desejamos a todos os nossos clientes um Feliz Natal e um 2016 de prosperidade e muitas realizações profissionais!!!

<p>
 


Informamos através desta Que a empresa SESMT, entrara em recesso de Fim de Ano, <b>No dia 17 de dezembro de 2015 e retornara suas atividades do dia 11 de Janeiro de 2016.</b>

<p>

Orientamos aos nossos Clientes que para um bom aproveitamento do nosso expediente que antecipem suas solicitações na área de Saúde Ocupacional, agendamento para Atestado Médico do Trabalho – ASO, pois nossas Clinicas parceiras entrarão de recesso nos período dos dias <b>18/12/2015 á 04/01/2016</b>, lembrando que o serviço online estará em funcionamento 24 horas por dia.

<p>

Quanto à área de Segurança de Engenharia do Trabalho, para as solicitações de avaliações ambientais só serão entregues no ano de 2016, devido o tempo de leitura dos laudos e o recesso que o nosso laboratório de analises ambiental também no mesmo período.</font> 


<p>

";
	
}


}







echo '
<script language="Javascript">
function showDiv(div)
{
document.getElementById("4").className = "invisivel";

document.getElementById(div).className = "visivel";
}
</script>
<style>
.invisivel { display: none; }
.visivel { visibility: visible; }
</style>';


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
		echo "<td align='center' class='bgTitle' colspan='2'><a href=\"?do=colaboradores&act=new\">
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
        echo "<td class='$bgclass' align=center><a href='?do=geraso&a=2&cod={$col[$x][cod_func]}&set={$col[$x][cod_setor]}'>{$col[$x][cod_func]}</a></td>";
        echo "<td class='$bgclass'><a href='?do=geraso&a=2&cod={$col[$x][cod_func]}&set={$col[$x][cod_setor]}'>{$col[$x][nome_func]}</a></td>";
        echo "</tr>";
	}
	echo "</table>";
}else{
   //Show the list of Clinicas
   if($_GET[a] == 2 ){
           $sql = "SELECT * FROM funcionarios WHERE cod_cliente = ".(int)($_SESSION['cod_cliente'])." AND cod_func = ".(int)$_GET[cod];
           $res = pg_query($sql);
           $buffer = pg_fetch_all($res);
		   
		   
		   $veradsql = "SELECT * FROM aso WHERE cod_cliente = ".(int)($_SESSION['cod_cliente'])." AND cod_func = ".(int)$_GET[cod]." AND tipo_exame = 'Admissional'";
		   $veradquery = pg_query($veradsql);
		   $veradd = pg_fetch_all($veradquery);
		   $verad = pg_num_rows($veradquery);
           
           if(empty($buffer[0][cod_setor])){
               echo "
               <br>O colaborador selecionado ainda não foi vinculado ao setor de sua empresa. Os provaveis motivos são:
               <BR>- Visita técnica ainda não realizada na empresa;
               <BR>- Sua empresa ainda não possui os relatórios técnicos on-line;
               <BR>- O exame à ser agendado é Admissional e, portanto, o funcionário não está vinculado à um setor de sua empresa em nosso sistema;
               <p>
               Em qualquer um dos casos acima, por favor, agendar o ASO através do e-mail <a href=mailto:medicotrab@sesmt-rio.com>medicotrab@sesmt-rio.com</a> contendo as seguintes informações:
               <BR>
               - Nome completo do candidato ao exame;<BR>
               - A Data de Nascimento;<BR>
               - O nº da CTPS e da Série;<BR>
               - O CBO - Código brasileiro de Ocupação; <BR>
               - A Função que será registrado; <BR>
               - A Data da Admissão; <BR>
               - O nº do PIS devido o PPP - Perfil Profissiográfico Previdenciário;<BR>
               - e um breve relato da dinâmica da função (O que realizara o dia dia em seu posto de trabalho).
               <p>
               Com base nas informações acima, enviaremos prontamente o encaminhamento ao exame e o prontuário para sua caixa de e-mail.
               <p>";
		       echo "<input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'>";
           
           }else{
					
		   /*$sql = "SELECT f.nome_func, f.cod_func, f.cod_funcao, 
				   fu.nome_funcao, fu.dsc_funcao, fec.*, ex.* 
				   FROM funcionarios f, funcao fu, fun_exa_cli fec, exame ex 
				   WHERE f.cod_func = '".$_GET['cod']."'
				   AND f.cod_funcao = fu.cod_funcao 
				   AND fec.cod_fun = f.cod_fun 
				   AND fec.cod_fun = fu.cod_funcao 
				   AND f.cod_setor = s.cod_setor 
				   AND f.cod_cliente = '".$_SESSION['cod_cliente']."' 
				   AND AND fec.cod_cli = '".$_SESSION['cod_cliente']."'";*/
				   
			$sql = "SELECT fec.*, f.*, fu.*, ex.* 
					FROM fun_exa_cli fec, funcionarios f, funcao fu, exame ex 
					WHERE fec.cod_cli = '".$_SESSION['cod_cliente']."' 
					AND f.cod_func = '".$_GET['cod']."' 
					AND f.cod_funcao = fec.cod_fun 
					AND fu.cod_funcao = f.cod_funcao 
					AND f.cod_cliente = '".$_SESSION['cod_cliente']."' 
					AND ex.cod_exame = fec.cod_exa";
				   	
           $res = pg_query($sql);
           $buffer = pg_fetch_all($res);

           $txt = "";
           $txt .= "<b>Exames Indicados para a Função</b>";
           $txt .= "<p>";
           $exames_indicados = array();
           for($x=0;$x<pg_num_rows($res);$x++){
               $exames_indicados[] = $buffer[$x]['cod_exa'];
               $txt .= $buffer[$x]['especialidade'];
               $txt .= "<br>";
           }		   echo pg_num_rows($res2);
           echo "<p>";
           echo "<center>Verifique os dados do colaborador selecionado</center>";
           echo "<p>";
           echo "<form method=\"POST\" action=\"?do=geraso&a=3&cod={$_GET[cod]}&set={$_GET[set]}&nome_func={$_GET[nome_func]}\">";
           echo "<table width=500 border=1 cellpadding=5 cellspacing=2>";
           echo "<tr>";
           echo "<td align=center width=30><b>Cod.</b></td>";
           echo "<td align=center><b>Colaborador</b></td>";
           echo "<td align=center width=200><b>Função</b></td>";
           if(pg_num_rows($res)>0){
			   echo "<tr>";
			   echo "<td align=center width=30>{$buffer[0][cod_func]}</td>";
			   echo "<td onMouseOver=\"return overlib('{$txt}');\" onMouseOut=\"return nd();\">{$buffer[0]['nome_func']}</td>";
			   echo "<td >{$buffer[0]['nome_funcao']}</td>";
			   echo "</tr>";
           }
		   $tp = $_GET[tp];
		   
		   if($tp <> 1){
           echo "<tr>";
  	       echo "<td align=center width=30 colspan=3>";
                echo "<b>Tipo de exame: </b>";
                echo "<select name=tipo_exame id=tipo_exame onchange=\"showDiv(this.value);\">";
               	$verdemsql = "SELECT * FROM aso WHERE cod_cliente = ".(int)($_SESSION['cod_cliente'])." AND cod_func = ".(int)$_GET[cod]." AND tipo_exame = 'Demissional'";
                    	$verdemquery = pg_query($verdemsql);
                    	$verdem = pg_fetch_all($verdemquery);
                    	$verd = pg_num_rows($verdemquery);
                    if(strtotime($veradd[0][aso_data]) < strtotime($verdem[0][aso_data])){
                	
                    echo "<option value='1'>Admissional</option>";
			        }
                    echo "<option value='2'>Demissional</option>";
                    echo "<option value='3' selected>Periódico</option>";
                    echo "<option value='4'>Mudança de função</option>";
					echo "<option value='5'>Retorno ao trabalho</option>";
               echo "</select>";
		   echo "</td>";
		   echo "</tr>";
		   
           echo "<tr>";
  	       echo '<td align=center width=30 colspan=3>
		<div id="4" ';
				echo ' class="invisivel">';
	
	$fu_cl = "SELECT fec.*, f.* FROM fun_exa_cli fec, funcao f 
			WHERE fec.cod_cli = ".$_SESSION[cod_cliente]." 
			AND fec.cod_fun = f.cod_funcao 
			ORDER BY nome_funcao";
	$fu_cli = pg_query($fu_cl);
	$fun_cli = pg_fetch_all($fu_cli);
	
    $sql = "SELECT cod_funcao, nome_funcao, dsc_funcao FROM funcao ORDER BY nome_funcao";
    $rlf = pg_query($sql);
    $funcoes = pg_fetch_all($rlf);
    
	echo "<b>Selecione a nova função: </b><select name='nfuncao' id='nfuncao' style=\"width: 300px;\">";
        echo "<option value=''></option>";
    for($y=0;$y < pg_num_rows($fu_cli);$y++){
		if($fun_cli[$y][cod_funcao] != $fun_cli[$y-1][cod_funcao]){
			echo "<option value='{$fun_cli[$y][cod_funcao]}'";
			if($fun[cod_funcao] == $fun_cli[$y][cod_funcao]){
			echo " selected ";
			$dinamica = $fun_cli[$y][dsc_funcao];
			}else{
			 "";
			 }
			 echo ">".substr($fun_cli[$y][nome_funcao], 0, 71)."</option>";
			 echo ">{$funcoes[$y][nome_funcao]}</option>";
		}
    }
    echo "</select>";

		echo '</div>
		</td></tr>';

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
	}}
       
   //Select the clinica
   
   if($_GET['a'] == '3'){
      
	   if($_POST['nfuncao']){
	   
				$nsql = "SELECT fec.*, f.*, fu.*, ex.* 
						FROM fun_exa_cli fec, funcionarios f, funcao fu, exame ex 
						WHERE fec.cod_cli = '".$_SESSION['cod_cliente']."' 
						AND f.cod_func = '".$_GET['cod']."' 
						AND ".$_POST['nfuncao']." = fec.cod_fun 
						AND fu.cod_funcao = ".$_POST['nfuncao']." 
						AND f.cod_cliente = '".$_SESSION['cod_cliente']."' 
						AND ex.cod_exame = fec.cod_exa";
						
			   $nres = pg_query($nsql);
			   $nbuffer = pg_fetch_all($nres);

			   $nexames_indicados = array();
			   for($x=0;$x<pg_num_rows($nres);$x++){
				   $nexames_indicados[] = $nbuffer[$x]['cod_exa'];
			   }
			   

			$ex = urlencode(serialize($nexames_indicados));
			$exames = $nexames_indicados;

		}else{
	   
		   $ex = $_POST['exames'];
		   $exames = unserialize(urldecode($_POST['exames']));
			   
		}
		
		
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
		   
		   //if(date('w') == 1){
			
				//$sql = "SELECT cod_clinica, count(*) as exames FROM clinica_exame WHERE ({$fix}) AND cod_clinica != 17 GROUP BY cod_clinica HAVING count(*) = ".count($exames);
		   
		   
			//}else{
				
				$sql = "SELECT cod_clinica, count(*) as exames FROM clinica_exame WHERE {$fix} GROUP BY cod_clinica HAVING count(*) = ".count($exames);
				
				
			//}
		   
		   
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
		   // Se select (tipo_exame) receber "==5", mostrar aquilo tudo, se não, mostrar o q tem a baixo
		   
		   switch($_POST['tipo_exame']){
			case '5':
			echo"<br><br><br><br>";
			   echo"<center><h2> Favor entrar em contato com o departamento médico para que seu exame possa ser agendado atráves do <br><br> Tel: (21)3014-4304 <br> Email: medicotrab@sesmt-rio.com </h2></center>";
			   echo"<br><br>";
			   echo "<center><input value='<< Voltar' type=button class=button onclick='javascript:history.go(-2);'></center>";
			break;
			}
		   
		   if(pg_num_rows($res)>0 && $_POST['tipo_exame'] <5){
			   echo "<p>";
			   echo "<center>Selecione uma clínica abaixo para a realização dos exames</center>";
			   echo "<p>";
			   

			   echo "<table width=100% border=1 cellpadding=5 cellspacing=2>";
			   echo "<tr>";
			   echo "<td align=center><b>Clínica</b></td>";
			   echo "<td align=center width=15%><b>Total</b></td>";
			   echo "<td align=center width=35%><b>Localização</b></td>";
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
				   echo "<td><a href='?do=geraso&a=4&col={$_GET[cod]}&tp=$tipo&set={$_GET[set]}&cl={$buffer[$x]['cod_clinica']}&ex={$ex}&nf=".$_POST['nfuncao']."'>{$buffer[$x]['razao_social_clinica']}</a></td>";
				   echo "<td>R$ ".number_format($preco[0]['preco']/*+(($preco[0]['preco']*20)/100)*/, 2,',','.')."</td>";
				   echo "<td onMouseOver=\"return overlib('{$localizacao}');\" onMouseOut=\"return nd();\">{$buffer[$x]['bairro_clinica']} / {$buffer[$x]['cidade']}</td>";
				   echo "</tr>";
			  }
			  echo "</table>";
			  echo "<p><center><input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'></center>";
		}else if($_POST['tipo_exame'] <5){
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
       $sql = "SELECT f.cod_funcao, f.nome_func, fe.cod_exa as exame_id, exa.especialidade as descricao, fun.nome_funcao, fun.dsc_funcao, f.cod_setor
	   FROM funcionarios f, fun_exa_cli fe, funcao fun, exame exa
	   WHERE f.cod_cliente = '".$_SESSION['cod_cliente']."' AND f.cod_func = {$_GET['col']} AND f.cod_funcao = fe.cod_fun
	   AND fun.cod_funcao = fe.cod_fun AND fe.cod_exa = exa.cod_exame AND f.cod_setor = {$_GET[set]}";
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
            $localizacao .= "<b>Complemento:</b> {$buffer[$x]['complemento']}";
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
         echo "<td align=left><b>Complemento</b></td>";
         echo "<td>{$buffer[0]['complemento']}&nbsp;</td>";
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
         
         $cont = 0;
         $datas = array();
         while(count($datas)<30){
             if(date("w", mktime(0,0,0,date("m"),date("d")+$count,date("Y"))) != 0 &&
             date("w", mktime(0,0,0,date("m"),date("d")+$count,date("Y"))) != 6){
                 $datas[] =  date("Y/m/d", mktime(0,0,0,date("m"),date("d")+$count,date("Y")));
             }
             $count++;
         }
                  
         echo "</table>";
         echo "<p>";


         echo "<center><b>Dados dos Exames</b></center>";
         echo "<table width=100% border=1 cellpadding=5 cellspacing=2>";
         echo "<tr>";
         echo "<td width=70% align=center><b>Exame</b></td>";
         echo "<td width=30% align=center><b>Valor</b></td>";
         echo "</tr>";
         $total_exames = 0;
         for($x=0;$x<count($data);$x++){
             echo "<tr>";
             echo "<td  align=left >{$data[$x]['especialidade']}</td>";
             echo "<td align=right>R$ ".number_format($data[$x]['preco_exame']/*+(($data[$x]['preco_exame']*20)/100)*/, 2, ',','.')."</td>";
             echo "</tr>";
             $total_exames += $data[$x]['preco_exame'];
         }
         echo "<tr>";
         echo "<td align=left ><b>Total</b></td>";
         echo "<td align=right><b>R$ ".number_format($total_exames/*+(($total_exames*20)/100)*/, 2, ',','.')."</b></td>";
         echo "</tr>";
         echo "</table>";
         
         echo "<p>";

        if($buffer[0]['segunda']=='segunda' || $buffer[0]['terca']=='terca' || $buffer[0]['quarta']=='quarta' || $buffer[0]['quinta']=='quinta' || $buffer[0]['sexta']=='sexta'){
        	echo "<font color=red align=justify><b>*".$buffer[0]['motivo']."</b></font>";
     	}
         echo "<p><table><tr><td>";
         echo "<input value='<< Voltar' type=button class=button onclick='javascript:history.back(-1);'>";
         echo "&nbsp;";
         $get = "cliente={$_SESSION['cod_cliente']}&clinica={$buffer[0]['email_clinica']}&col={$_GET['col']}&nf={$_GET['nf']}&set={$_GET[set]}&cl={$_GET['cl']}&ex=".urlencode(serialize($exames))."";

         //echo "<input type=button class=button value='Confirmar Agendamento' onclick=\"window.open('internal/client_files/confirmar_aso.php?{$get}&tp={$_GET[tp]}&data_agendamento='+document.getElementById('data_agenda').options[document.getElementById('data_agenda').selectedIndex].value, '800,600');\">";
		 if(($_GET['cl']==17)){
			if((date("y.m.d") >= '14.12.16') && (date("y.m.d") <= '15.01.05')){
				
				echo '</td><td><strong>Clínica em período de recesso<br>Novos agendamentos a partir de 06/01/15</strong></td></tr></table>';
				
			}
			
			else{echo '</td><td><a target="_blank" href="internal/client_files/confirmar_aso.php?'.$get.'&tp='.$_GET[tp].'&data_agendamento='.date("Y-m-d").' "><img src="http://sesmt-rio.com/images/conf_aso.jpg" width="170" height="21"></a></td></tr></table>';}
			
		 }else if(($_GET['cl']==19)){	
			if((date("y.m.d") >= '14.12.23') && (date("y.m.d") <= '15.01.04')){
				
				echo '</td><td><strong>Clínica em período de recesso<br>Novos agendamentos a partir de 05/01/15</strong></td></tr></table>';
				
			}else{echo '</td><td><a target="_blank" href="internal/client_files/confirmar_aso.php?'.$get.'&tp='.$_GET[tp].'&data_agendamento='.date("Y-m-d").' "><img src="http://sesmt-rio.com/images/conf_aso.jpg" width="170" height="21"></a></td></tr></table>';}
			
		 }else{echo '</td><td><a target="_blank" href="internal/client_files/confirmar_aso.php?'.$get.'&tp='.$_GET[tp].'&data_agendamento='.date("Y-m-d").' "><img src="http://sesmt-rio.com/images/conf_aso.jpg" width="170" height="21"></a></td></tr></table>';}
         echo "<p>";
}//END IF = 3
}
?>
</body>
</html>
