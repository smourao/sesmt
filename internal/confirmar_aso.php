
<?PHP
/*****************************************************************************************************************/
// -> INCLUDES / DEFINES
/*****************************************************************************************************************/

/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$data_agendamento = $_GET[data_agendamento];
$msg_site = "";
$msg_cliente = "";
$msg_medico = "";
$msg_clinica = "";
$msg_financeiro = "";
$header_h = 75;//header height;
$footer_h = 75;//footer height;

function coloca_zeros($numero){
   return str_pad($numero, 4, "0", STR_PAD_LEFT);
}

$data1 = $_GET[data_agendamento];
$d = explode("/",$data1);
$data1 = $d[2]."/".$d[1]."/".$d[0];

if ($_GET['tp'] == 1) $tipo_exame = "Admissional";
if ($_GET['tp'] == 2) $tipo_exame = "Demissional";
if ($_GET['tp'] == 3) $tipo_exame = "Periódico";
if ($_GET['tp'] == 4) $tipo_exame = "Mudança de função";
if ($_GET['tp'] == 5) $tipo_exame = "Retorno ao trabalho";
		 
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

if(pg_num_rows($queryver) == 0 && $_GET[con]){
	$query_insert = "INSERT INTO aso (cod_aso, cod_cliente, aso_data, cod_func, tipo_exame, cod_clinica, cod_setor, tipo)
					VALUES ({$cod_aso}, {$_GET[cliente]}, '$data_agendamento', {$_GET[col]}, '$tipo_exame', {$_GET[cl]}, {$_GET[set]}, 1)";
	$quey = pg_query($query_insert);
	echo '<table width="500" border="0">
  <tr>
    <td colspan="0"><center><span class="style4"><b>AGENDAR ASO AVULSO</b></span><br></center></td>
  </tr>
  <tr>
    <td colspan="0" align="justify">

</td>
  </tr>
</table><br />';
	echo "Seu agendamento será analisado pela nossa equipe, logo voce receberá um email com o encaminhamento para seu funcionário.";
	$msg = "Olá Luciana, foi solicitado um encaminhamento para ASO avulso através do site, entre no ambiente <b>'Encaminhamento Avulso'</b> no sistema e pesquise pelo <b>código: $cod_aso </b>para inserir os exames necessários e enviar o encaminhamento para o cliente.";
	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <suporte@sesmt-rio.com> \n";
	mail("suporte@ti-seg.com;medicotrab@sesmt-rio.com", "SESMT - Solicitação de encaminhamento para ASO avulso Nº: ".$cod_aso, $msg, $headers);

}elseif(pg_num_rows($queryver) != 0 && $_GET[con]){
	echo "<table border=0><tr><td align='justify'>Prezado cliente, já foi feito um agendamento para esse funcionário recentemente, portanto, não será possível fazer um novo agendamento. 
	<br><br>Se realmente já tenha feito o agendamento e ainda não recebeu o encaminhamento por email, envie um email solicitando para <b>medicotrab@sesmt-rio.com</b> informando o seguinte<b> código: ".$ary[cod_aso]."</b>
	<br><br>Caso não tenha feito um agendamento para o funcionário anteriormente, entrar em contato com nosso setor de suporte através do email: <b>suporte@sesmt-rio.com</b>, também informando o <b>código: ".$ary[cod_aso]."</b></td></tr></table>";
}

?>