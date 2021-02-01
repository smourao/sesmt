<?PHP
session_start();
function next_days($num_days){
   global $conn;
   $mes = date("n");
   $ano = date("Y");
   $tdias = date("t", mktime(0, 0, 0, $mes, 1, $ano));
   $diah =  date("d");
   $d = date("d");
   $dias = array();
   $sql = "SELECT participantes FROM agenda_cipa_config";
   $result = pg_query($sql);
   $config = pg_fetch_array($result);

       while(count($dias) < $num_days){
          if(date("w", mktime(0, 0, 0, $mes, $d, $ano)) == 1){
             $sql = "SELECT * FROM agenda_cipa_part WHERE data_realizacao = '".$ano."-".$mes."-".$d."'";
             $result = pg_query($sql);
             if(pg_num_rows($result)<$config[participantes]){
                $dias[] = $ano."/".$mes."/".$d;//date("d", mktime(0, 0, 0, $mes, $d, $ano));
             }
          }

          $d++;

          if($d > $tdias){
              //break;
              $d = 1;
              if($mes<=11){$mes++;}else{$mes=1;$ano++;}
              $tdias = date("t", mktime(0, 0, 0, $mes, 1, $ano));
          }
       }//end while
   return $dias;
}
?>
<form method="post">
<table width="100%" border="0">
    <tr>
        <td width="180">Selecione o Candidato: </td>
        <td align="left">
            <select name="funcionario">
            <?PHP
                $sql = "SELECT * FROM funcionarios WHERE cod_cliente = '{$_SESSION[cod_cliente]}'";
                $result = pg_query($sql);
                $buffer = pg_fetch_all($result);
                for($x=0;$x<pg_num_rows($result);$x++){
                    echo "<option value='{$buffer[$x][cod_func]}'>{$buffer[$x][nome_func]}</option>";
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
        <td width="180">Data de Realização: </td>
        <td align="left">
            <select name="data_realizacao">
            <?PHP
                $datas = next_days(10);
                for($x=0;$x<10;$x++){
                    echo "<option value='{$datas[$x]}'>".date("d/m/Y", strtotime($datas[$x]))."</option>";
                }
            ?>
            </select>
        </td>
    </tr>
    <tr>
    	<td colspan="2"><p><b>Duração do Curso:<br>09:00 às 12:00 hs<br>13:00 às 16:00 hs</b></td>
    </tr>
	<tr>
    	<td colspan="2"><p><input type="submit" value="Confirmar" class="button"></td>
    </tr>
</table>
</form>

<?PHP
if($_POST){

//Verifica se funcionário já está cadastrado.
$sql = "SELECT * FROM agenda_cipa_part WHERE cod_funcionario = '{$_POST[funcionario]}'
AND cod_cliente = '{$_SESSION[cod_cliente]}'";
$result = pg_query($sql);
if(pg_num_rows($result)<=0){

    //Verifica se já existe informações sobre esta data, senão, adiciona na tabela.
    $sql = "SELECT * FROM agenda_cipa_info WHERE data_realizacao = '{$_POST[data_realizacao]}'";
    $result = pg_query($sql);
    if(pg_num_rows($result)<=0){
        $sql = "INSERT INTO agenda_cipa_info (data_realizacao, status) VALUES ('{$_POST[data_realizacao]}', '0')";
        pg_query($sql);
    }

    //Obtem número da cipa cadastrado acima, ou pega o numero se já estiver cadatsrado anteriormente.
    $sql = "SELECT id FROM agenda_cipa_info WHERE data_realizacao = '{$_POST[data_realizacao]}'";
    $result = pg_query($sql);
    $cipaid = pg_fetch_array($result);
    $cipaid = $cipaid[id];
    
    //Dados do cadastro do funcionário.
    $sql = "SELECT * FROM funcionarios WHERE cod_func = '{$_POST[funcionario]}' AND cod_cliente = '{$_SESSION[cod_cliente]}'";
    $result = pg_query($sql);
    $f = pg_fetch_array($result);

    //Insert na tabela de participantes do curso de cipa
    $sql = "INSERT INTO agenda_cipa_part (cod_cipa, data_realizacao, participante, cod_cliente, cod_filial,
    compareceu, data_inscricao, cod_funcionario) VALUES
    ('{$cipaid}', '{$_POST[data_realizacao]}', '{$f[nome_func]}', '{$_SESSION[cod_cliente]}',
    '{$_SESSION[cod_filial]}', '0', '".date("Y/m/d")."', '{$_POST[funcionario]}')";
    pg_query($sql);
	echo ">>".$sql;
    
    echo "<script>alert('Participante inscrito com sucesso!');</script>";
    
}else{
    echo "Este funcionário já esta cadastrado.";
}


//   echo "<center><iframe src=\"http://www.sesmt-rio.com/sendmail.php?name={$name}&mymail={$email}&to={$to}&body={$msg}&subject={$sbj}\" width=100% height=100 frameborder=0></iframe></center>";
}



$sql = "SELECT * FROM cliente WHERE cliente_id = '{$_SESSION[cod_cliente]}'";
$result = pg_query($sql);
$cliente=pg_fetch_array($result);


$msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
   <HTML>
   <HEAD>
      <TITLE>Carta - CIPA</TITLE>
<META http-equiv=Content-Type content=\"text/html; charset=iso-8859-1\">
<META content=\"MSHTML 6.00.2900.3157\" name=GENERATOR>
<style type=\"text/css\">
td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}td img {display: block;}
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif}
.style13 {font-size: 14px}
.style15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
.style16 {font-size: 9px}
.style17 {font-family: Arial, Helvetica, sans-serif}
.style18 {font-size: 12px}
</style>
   </HEAD>
   <BODY>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=0 cellspacing=0>
	<tr>
		<td align=left><img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt.png\" width=\"333\" height=\"180\" /></td>
		<td align=\"left\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\"><span class=style18>Serviços Especializados de Segurança e <br>
		  Monitoramento de Atividades no Trabalho ltda.</span>
		  </font><br><br>
		  <p class=\"style18\">
		  <p class=\"style18\"><font color=\"#006633\" face=\"Verdana, Arial, Helvetica, sans-serif\">Segurança do Trabalho e Higiene Ocupacional.</font><br><br><br><br>
		  <p>
</td>
	</tr>
</table></div>
<br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
	<tr>
		<td width=\"70%\" align=\"center\" class=\"fontepreta12\"><br />
		  <span class=\"style2 fontepreta12\" style=\"font-size:14px;align: justify;\">
		  <p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Prezado(ª) Cliente: <b>{$cliente[nome_contato_dir]}</b>, nos dispomos dessa para solicitar o agendamento
de sua empresa, reservando assim espaço em nosso auditório para a ministração do curso da CIPA - Comissão
Interna de Prevenção de Acidentes, conforme disposto na NR 5.6.4 lei 6.514/77 e sua Port 3.214/78.
<p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
NR 5.6.4 \"Quando a empresa não se enquadrar no disposto desta NR deverá designar alguém para o cumprimento
da mesma\", o que a Norma Regulamentadora quer trazer neste texto. Que existe uma série de procedimentos a
serem cumpridos pelas empresas e que indenpendente de não terem a CIPA constituida ou seja através do voto
em scrutino secreto. A empresa tem que cumprir o disposto na NR. Sendo assim, o designado, que será um
colaborador da sua escolha será treinado para cumprir as demandas da NR no que diz respeito as informações e
aspectos burocráticos da CIPA.
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Algumas das atribuições do designado são: Orientar a empresa de consultoria os locais onde mais se precise
do MR - Mapa de Risco que tem a finalidade de orientar aos demais colaboradores quanto aos riscos e poderem
se previnir evitando a incidêncie de acidentes;
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Montar o Mapa Anual de Doença Ocupacional e Acidente do Trabalho, conforme quadros III e IV da NR 4 e
remeter para protocolo no MTE mensalmente ou anualmente se assim preferir;
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Cobrar dos fornecedores de EPI - Equipamento de Proteção Individual, os C.A's Certificado de Aprovação
concedidos ao fabricante pelo INMETRO e arquivá-lo junto com a ficha de entrega dos mesmo aos seus
colaboradores;
<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Inspeção mensal dos Extintores de Incêndio;
<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Controlar para a administração as validades de: Recarga de Extintores (recarga); Limpeza dos reservatórios
de água inferior e superior; Dedetização; Desratização; Limpeza dos filtros de ar condicionados e etc.
<p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
É de suma importância o cumprimento destes procedimentos e a participação da sua administração nesse
processo a Segurança do Trabalho tem a caracteristica de gerar organização e com isso findar os gargalos
operacionais e paralização de produções, sem contar com a liquidez que gera a sua empresa.
<p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
A SESMT prisma por cumprir o acordado entre a nossa e a sua empresa e conta com sua colaboração.
<p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Para agendar é simples, acesse o site <a href='http://www.sesmt-rio.com'>www.sesmt-rio.com</a> e clique no
botão cliente de cor laranja, nele faça
seu acesso com seu login e senha pessoal, selecione a opção serviços e localize o botão <b>Curso Designado</b>,
Selecione o candidato e qual o dia para realização do curso.
<p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
A prioridade da SESMT é levar a sua empresa a excelência da Organização administrativa objetivando assim o
sucesso pleno de sua empresa.
<p>
<br>
<p>
<BR>
<p>
<b><p align=left>
<i>SESMT VELANDO PELA SEGURANÇA NO TRABALHO<br>
E PELA SAÚDE OCUPACIONAL DA SUA EMPRESA <br></i></b>
<p>
<br>
</span>
</td>
</tr>
</table></div>
<br><p>
<br>
<div align=\"center\">
<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bordercolor=\"#000000\">
	<p>
		<tr>
		<td width=\"65%\" align=\"center\" class=\"fontepreta12 style2\">
		<br /><br /><br /><br /><br /><br />
		  <span class=\"style17\">Telefone: +55 (21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
		  Nextel: +55 (21) 7844-9394 &nbsp;&nbsp;ID:55*23*31368 </span>
          <p class=\"style17\">
		  faleprimeirocomagente@sesmt-rio.com / comercial@sesmt-rio.com<br />
          www.sesmt-rio.com / www.shoppingsesmt.com<br />

	    </td>
		<td width=\"35%\" align=\"right\">
        <img src=\"http://www.sesmt-rio.com/erp/img/logo_sesmt2.png\" width=\"280\" height=\"200\" /></td>
	</tr>
</table></div>
   </BODY>
</HTML>  ";

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <webmaster@sesmt-rio.com> \n";
//mail('celso.leo@gmail.com', 'CARTA DE CIPA', $msg, $headers);
//echo $msg;
?>
</body>
</html>
