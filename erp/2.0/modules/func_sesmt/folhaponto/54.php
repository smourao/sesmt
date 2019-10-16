<?php
 
//##########################################################################
$host = 'postgresql04.sesmt-rio.com';//'postgresql01.sesmt-rio.com';//'s4d.servegame.com'; //postgresql01.sesmt-rio.com
$port = '5432';
$dbname = 'sesmt_rio3';//'loja';//sesmt_rio
$user = 'sesmt_rio3';//'postgres';//sesmt_rio
$pass = 'Sesmt507311';//'xxxxxx';//diggio3001
$str = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$conn = @pg_connect($str) or die('Houve um problema ao tentar se conectar � database. Por favor, tente novamente mais tarde!');
//##########################################################################
 
 
//Convertendo Dia da SEMANA
$dia_semana = date("l"); //L (Minusculo) pega o nome em ingles da semana
if($dia_semana == "Monday")
$dia_semana = "Segunda";
if($dia_semana == "Tuesday")
$dia_semana = "Ter�a";
if($dia_semana == "Wednesday")
$dia_semana = "Quarta";
if($dia_semana == "Thursday")
$dia_semana = "Quinta";
if($dia_semana == "Friday")
$dia_semana = "Sexta";
if($dia_semana == "Saturday")
$dia_semana = "Sab�do";
if($dia_semana == "Sunday")
$dia_semana = "Domingo";
if($_GET){

$ano_atual = $_GET[ano]; //Y pega o ano no formato YYYY caso queira YY ponha y ...


//Recebendo o Mes Atual para Nome
$mes_atual = $_GET[mes];
//Recebendo Mes Atual para Numero
$mes = $_GET[mes];


}else{
	
$ano_atual = date("Y"); //Y pega o ano no formato YYYY caso queira YY ponha y ...


//Recebendo o Mes Atual para Nome
$mes_atual = date("m");
//Recebendo Mes Atual para Numero
$mes = date("m");

	
	
	
}
 
if($mes_atual == "01"){
$mes_atual = "Janeiro";
$time_left = 31;
}
//########################################################
//Vendo se � Fevereiro e se O ano � Bissexto
//Recebendo o Ano Bissexto
$bisexto = date("y");
if($mes_atual == "02"){
$mes_atual = "Fevereiro";
if ((($bisexto % 4) == 0 and ($bisexto % 100)!=0) or ($bisexto % 400)==0){
$time_left = 29;
}
else{
$time_left = 28;
}
}
//##########################################################
if($mes_atual == "03"){
$mes_atual = "Mar�o";
$time_left = 31;
}
if($mes_atual == "04"){
$mes_atual = "Abril";
$time_left = 30;
}
if($mes_atual == "05"){
$mes_atual = "Maio";
$time_left = 31;
}
if($mes_atual == "06"){
$mes_atual = "Junho";
$time_left = 30;
}
if($mes_atual == "07"){
$mes_atual = "Julho";
$time_left = 31;
}
if($mes_atual == "08"){
$mes_atual = "Agosto";
$time_left = 31;
}
if($mes_atual == "09"){
$mes_atual = "Setembro";
$time_left = 30;
}
if($mes_atual == "10"){
$mes_atual = "Outubro";
$time_left = 31;
}
if($mes_atual == "11"){
$mes_atual = "Novembro";
$time_left = 30;
}
if($mes_atual == "12"){
$mes_atual = "Dezembro";
$time_left = 31;
}

$nome = 'Fl�via Cristina Gomes Barbosa';
$lotacao = 'SESMT';
$carga_horaria = '48';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Frequ�ncia de <?=$nome?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
 
<body>
<br>
<table width="97%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="28%" height="60"><img src="sesmt-logo.png" width="800" height="100"></td>
    
  </tr>
</table>
<table width="97%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40%"> </td>
    <td width="33%"> </td>
  </tr>
  <br>
  <br>
  <tr>
    <td><strong>EMPREGADO:</strong> <?=$nome?></td>
    <td><strong>M�S:</strong> <?=$mes_atual?> de <?=$ano_atual?></td>
  </tr>
  <tr>
    <td><strong>SETOR: </strong>Departamento T�cnico </td>
    <td><strong>FUN��O: </strong>Tec. Seguran�a do Trabalho </td>
  </tr>
  <tr>
    <td><strong>N� REGISTRO: </strong>054 </td>
    <td><strong>HOR�RIO:</strong> Seg. A Quin.:08hs �s 18hs Sexta: 08hs �s 17hs</td>
  </tr>
  <tr>
    <td><strong>Hor�rio Aos S�bados:</strong></td>
    <td><strong>Descanso Semanal: </strong>48</td>
  </tr>
</table>
<table width="97%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td width="5%" bgcolor="#CCCCCC"><div align="center"><strong>DIA</strong></div></td>
    <td width="13%" bordercolor="#000000" bgcolor="#CCCCCC"><div align="center"><strong>HORA
        DE ENTRADA</strong></div></td>
    <td width="13%" bgcolor="#CCCCCC"><div align="center"><strong>HORA DO ALMO�O</strong></div></td>
    <td width="13%" bgcolor="#CCCCCC"><div align="center"><strong>HORA DE SA�DA</strong></div></td>
    <td width="32%" bgcolor="#CCCCCC"><div align="center"><strong>RUBRICA DO FUNCION�RIO</strong></div></td>
  </tr>
  <?php
//********FERIADOS M�VEIS*********************************************
//===>Carnaval
//===>Corpus Christi
//===>Sexta-Feira Santa
//********************************************************************
//********FERIADOS FIXOS**********************************************
// 01/01 - Confraterniza��o universal
// 21/04 - Tiradentes / Niver Bras�lia (Distrital)
// 01/05 - Dia do Trabalhador
// 07/09 - Dia da Independ�ncia do Brasil
// 12/08 - Dia da Nossa Ser Aparecida
// 02/11 - Dia de Finados
// 15/11 - Ploclama��o da Rep
// 30/11 - Dia do Evang�lico (Distrital)
// 25/12 - Natal
//********************************************************************
// Faixa de anos X Y, Servem para calcular a Pascoa e consectivamente feriados m�veis...
//� um c�lculo que resgata as fases da lua...
//Para pegar as fases da Lua depende do nosso S�culo...
if($ano_atual >=1582 and $ano_atual <=1599){
$x= 22;
$y= 2;
}
if($ano_atual >=1600 and $ano_atual <= 1699){
$x= 22;
$y= 2;
}
if($ano_atual >=1700 and $ano_atual <= 1799){
$x= 23;
$y= 3;
}
if($ano_atual >=1800 and $ano_atual <= 1899){
$x= 24;
$y= 4;
}
if($ano_atual >=1900 and $ano_atual <= 1999){
$x= 24 ;
$y=5;
}
if($ano_atual >=2000 and $ano_atual <= 2099){
$x= 24;
$y=5;
}
if($ano_atual >=2100 and $ano_atual <= 2199){
$x= 24;
$y= 6;
}
if($ano_atual >=2200 and $ano_atual <= 2299){
$x= 25;
$y=7;
}
//Vamos ao c�lculo da P�scoa
$a = $ano_atual % 19;
$b =  $ano_atual % 4;
$c = $ano_atual % 7;
$d = (((19*$a)+$x) % 30);
$e =(((2*$b)+(4*$c)+(6*$d)+$y)%7);
 
if(($d+$e)<10){
$dia_de_hoje = ($d+$e+22);
$mes_now = 3;
}
else{
$dia_de_hoje = ($d+$e-9);
$mes_now = 4;
}
//Caso espec�fico
//H� dois casos particulares que ocorrem duas vezes por s�culo
//Quando o domingo de P�scoa cair em Abril e o dia for 26, corrige-se para uma semana antes, ou seja, vai para dia 19
if($dia_de_hoje==26 && $mes_now==4){
$dia_de_hoje=19;
}
//Quando o domingo de P�scoa cair em Abril e o dia for 25 e o termo "d" for igual a 28, simultaneamente com "a" maior que 10, ent�o o dia � corrigido para 18.
if($dia_de_hoje==25 && $mes_now==4){
$dia_de_hoje=18;
}
 
 
//#######################################################################
             //FUN��O DE SOMA E SUBTRA��O DE DATAS
//#######################################################################
function SomarData($data2, $dia_de_hoje2, $mes_nowe2, $oano2)
{
   //passe a data no formato dd/mm/yyyy
   $data2 = explode("/", $data2);
   $newData2 = date("d/m/Y", mktime(0, 0, 0, $data2[1] + $mes_nowe2,
    $data2[0] + $dia_de_hoje2, $data2[2] + $oano2) );
   return $newData2;
}
 
function SubtrairData($data3, $dia_de_hoje3, $mes_nowe3, $oano3)
{
   //passe a data no formato dd/mm/yyyy
   $data3 = explode("/", $data3);
   $newData3 = date("d/m/Y", mktime(0, 0, 0, $data3[1] - $mes_nowe3,
    $data3[0] - $dia_de_hoje3, $data3[2] - $oano3) );
   return $newData3;
}
//#######################################################################
//Recebe a Pascoa deste Ano
$data_pascoa = date("$dia_de_hoje/$mes_now/$ano_atual");
//Calcular o Carnaval - 47 Dias antes da P�scoa
$carnaval = SubtrairData("$data_pascoa", 47, 0, 0);
$carnaval = date($carnaval);
//Calcular a Sexta-Feira Santa - 2 Dias antes da P�scoa
$sexta_santa = SubtrairData("$data_pascoa", 2, 0, 0);
//Calcular Corpus Christi - 60 Dias apos a P�scoa
$corpus =SomarData("$data_pascoa", 60, 0, 0);
//Agora o resto dos feriados
$confraternizacao = date ("01/01/$ano_atual");          // 01/01 - Confraterniza��o universal
$saosebastiao = date ("20/01/$ano_atual");             // 20/01 -  Dia de S�o Sebasti�o
$tiradentes = date ("21/04/$ano_atual");              // 21/04 - Tiradentes / Niver Bras�lia (Distrital)
$saojorge = date ("23/04/$ano_atual");               // 23/04 - Dia de S�o Jorge
$trabalhador = date ("01/05/$ano_atual");           // 01/05 - Dia do Trabalhador
$independencia = date ("07/09/$ano_atual");        // 07/09 - Dia da Independ�ncia do Brasil
$nsaparecida = date ("12/10/$ano_atual");         // 12/10 - Dia da Nossa Ser Aparecida
$comercio = date ("19/10/$ano_atual");           // 19/10 - Dia do Com�rcio
$finados = date ("02/11/$ano_atual");           // 02/11 - Dia de Finados
$replublica = date ("15/11/$ano_atual");       // 15/11 - Ploclama��o da Republica
$consciencia = date ("20/11/$ano_atual");     // 20/11 - Dia da Consci�ncia Negra
$natal = date ("25/12/$ano_atual");         // 25/12 - Natal
//Inicio da Parte Fisica da Lista de frequencia
?>
<?php for($z=1;$z<=$time_left;$z++){
//EVITANDO ERROS 1 � != DE 01


$pegarferiassql = "SELECT inicio, termino FROM ferias_sesmt WHERE funcionario_id = 54 ORDER BY id DESC";
$pegarferiasquery = pg_query($pegarferiassql);
$pegarferias = pg_fetch_array($pegarferiasquery);
$inicioferias = $pegarferias['inicio'];
$terminoferias = $pegarferias['termino'];


date('Y-m-d', strtotime("+10 day",strtotime($inicioferias)));


if($z==1)
$z="01";
if($z==2)
$z="02";
if($z==3)
$z="03";
if($z==4)
$z="04";
if($z==5)
$z="05";
if($z==6)
$z="06";
if($z==7)
$z="07";
if($z==8)
$z="08";
if($z==9)
$z="09";
//Recebe o Dia da Semana em Nome (Saturday or Sunday)
$semana_nomeada[$z]  = date("l", mktime(0, 0, 0, $mes, $z, $ano_atual));
$bgcolor[$z]="FFFFFF";
$aterisco[$z]=" ";
//Recebe o Dia mes e Ano em que estamos
$sendo_agora = date ("$z/$mes/$ano_atual");
$d = str_replace('/', '-', $sendo_agora);
$d = date('Y-m-d', strtotime($d));


//Ver se esta de f�rias
if(($d >= $inicioferias) && ($d <= $terminoferias)){
$sabado_domingo = "<b>F�rias</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}else{
//Ver se � sabao ou domingo
if($semana_nomeada[$z]=="Saturday"){
$sabado_domingo = "<b>S�bado</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($semana_nomeada[$z]=="Sunday"){
$sabado_domingo = "<b>Domingo</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
else
$sabado_domingo = " ";
 
//Ver se � Feriado
if($confraternizacao == $sendo_agora){
$sabado_domingo = "<b>Feriado - Confrateniza��o</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($saosebastiao == $sendo_agora){
$sabado_domingo = "<b>Feriado - S�o Sebasti�o</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($carnaval == $sendo_agora){
$sabado_domingo = "<b>Feriado - Carnaval</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($sexta_santa == $sendo_agora){
$sabado_domingo = "<b>Feriado - Sexta-Feira Santa</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($corpus == $sendo_agora){
$sabado_domingo = "<b>Feriado - Corpus Christi</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($tiradentes == $sendo_agora){
$sabado_domingo = "<b>Feriado - Tiradentes</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($saojorge == $sendo_agora){
$sabado_domingo = "<b>Feriado - S�o Jorge</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($trabalhador == $sendo_agora){
$sabado_domingo = "<b>Feriado - Dia do Trabalhador</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($independencia == $sendo_agora){
$sabado_domingo = "<b>Feriado - Independ�ncia</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($nsaparecida == $sendo_agora){
$sabado_domingo = "<b>Feriado - N. S. Aparecida</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($comercio == $sendo_agora){
$sabado_domingo = "<b>Feriado - Com�rcio</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($finados == $sendo_agora){
$sabado_domingo = "<b>Feriado - Dia de Finados</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($replublica == $sendo_agora){
$sabado_domingo = "<b>Feriado - Procl. da Rep</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($consciencia == $sendo_agora){
$sabado_domingo = "<b>Feriado - Consci�ncia Negra</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
elseif($natal == $sendo_agora){
$sabado_domingo = "<b>Feriado - Natal</b>";
$bgcolor[$z]="CCCCCC";
$aterisco[$z]="**********";
}
}
 
//Recebe os Feriados
 
  echo"<tr>
    <td bgcolor=\"#$bgcolor[$z]\"><div align=\"center\"><center>$z</center></div></td>
    <td bgcolor=\"#$bgcolor[$z]\"><center>$sabado_domingo</center></td>
    <td bgcolor=\"#$bgcolor[$z]\"><center>$aterisco[$z]</center></td>
	<td bgcolor=\"#$bgcolor[$z]\"><center>$aterisco[$z]</center></td>
    <td bgcolor=\"#$bgcolor[$z]\"><center>$aterisco[$z]</center></td>
  </tr>" ;
  }
?>
   
  </tr>
   
</table>
<!--<table width="97%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="90%"><font size="2">Somat�rio de aus�ncias, atrasos
      e sa�das antecipadas n�o justificadas: _____</font></td>
    <td width="10%">  </td>
  </tr>
  <tr>
    <td> </td>
    <td> </td>
  </tr>
  <tr>
    <td>Data: ____/____/____</td>
    <td> </td>
  </tr>
  <tr>
    <td> </td>
    <td> </td>
  </tr>
  <tr>
    <td> </td>
    <td> </td>
  </tr>
  <tr>
    <td> </td>
    <td> </td>
  </tr>
</table>
<table width="97%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="48%"><div align="center">______________________________________________</div></td>
    <td width="52%"><div align="center"> ____________________________</div></td>
  </tr>
  <tr>
    <td><div align="center"><?=$nome?></div></td>
    <td> <div align="center">Visto da Chefia Imediata</div></td>
  </tr>
  <tr>
    <td> </td>
    <td><div align="center"><font size="2">CARIMBO</font></div></td>
  </tr>
</table>-->
<p><font size="2"></font></p>
</body>
</html>