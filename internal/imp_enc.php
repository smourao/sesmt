<center>
<table width="500" border="0">
  <tr>
    <td colspan="0"><center><span class="style4"><b>AGENDAR ASO AVULSO</b></span><br></center></td>
  </tr>
  <tr>
    <td colspan="0" align="justify"><?php if(!$_GET[a]){echo '
    	<br>&nbsp;&nbsp;&nbsp;&nbsp;Selecione abaixo o encaminhamento. O encaminhamento somente será listado abaixo depois que o agendamento for feito e confirmado pelo nosso setor médico.';}?>

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
			

if($_GET['a'] == '3'){
		
		$sql = "SELECT a.*, ae.* FROM aso_exame ae, aso a WHERE a.cod_aso = $_GET[cod_aso] AND  ae.cod_aso = $_GET[cod_aso]";
		$query = pg_query($sql);
		$array = pg_fetch_all($query);
      
   		for($y=0;$y<pg_num_rows($query);$y++){
       		$exames[] = $array[$y][cod_exame];
		}
       if(count($exames)>0 AND !empty($exames[0])){
           $fix = "";
           for($x=0;$x<count($exames);$x++){
			   //$fix .= "ce.cod_exame = '{$exames[$x]}'";
			   $fix .= "cod_exame = '{$exames[$x]}'";
			   if($x < count($exames)-1){
				   $fix.=" OR ";
			   }
			   echo $axames[$x];
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
           echo "<center><font color=red>**Para concluir é necessário ter feito login no site, caso não tenha feito, basta entrar com seu usuário e senha no painel acima e em seguida concluir o agendamento selecioando uma clínica abaixo!</font></center>";
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
               echo "<td><a target='_blank' href='internal/encaminhamento.php?cod_aso=$_GET[cod_aso]&col=$_GET[col]&cod=$_SESSION[cod_cliente]&cl={$buffer[$x]['cod_clinica']}'>{$buffer[$x]['razao_social_clinica']}</a></td>";
               echo "<td>R$ ".number_format($preco[0]['preco']/*+(($preco[0]['preco']*20)/100)*/, 2,',','.')."</td>";
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

?>
</body>
</html>
