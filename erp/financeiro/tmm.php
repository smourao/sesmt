<?php
ob_start();
require_once('fpdf/fpdf.php');
include "../config/connect.php";
include "../sessao.php";

$name = $_GET['name'];

if($_GET[pc]){
    $sql = "SELECT * FROM cliente_pc WHERE cliente_id={$_GET['cod_cliente']} and filial_id={$_GET[cod_filial]} AND contratante = 1";
}else{
    $sql = "SELECT * FROM cliente WHERE cliente_id={$_GET['cod_cliente']} and filial_id={$_GET[cod_filial]}";
}
$r = pg_query($connect, $sql);
$cliente = pg_fetch_all($r);

$total = $_POST['valor_unitario'] * $_POST['quantidade'];

$pdf=new FPDF("P","cm","A4");
$pdf->AddPage();
$pdf->SetFont('Times','',10);
$pdf->SetMargins(2,2,2);
$pdf->setY("5.5");
$pdf->setX("15.5");
//$novo="02/03/2009";
$novo = $_POST['data'];
$pdf->Cell(0,0,$novo);

$pdf->setY("6.8");
$pdf->setX("2.3");
//$novo=" Transp. Marít. e Multímodas S. Geraldo Ltda";
$novo = " ".$cliente[0]['razao_social'];
$pdf->Cell(0,0,$novo);

$pdf->setY("7.4");
$pdf->setX("2.8");
//$novo="Rodovia Presidente Dutra ";
$novo = $cliente[0]['endereco'].", ".$cliente[0]['num_end'];
$pdf->Cell(0,0,$novo);

$pdf->setY("7.9");
$pdf->setX("2.3");
//$novo="Mesquita";
$novo = $cliente[0]['bairro'];
$pdf->Cell(0,0,$novo);

$pdf->setY("7.9");
$pdf->setX("11.8");
//$novo="Nova Iguaçu";
$novo = $cliente[0]['municipio'];
$pdf->Cell(0,0,$novo);

$pdf->setY("7.9");
$pdf->setX("17");
//$novo="Rio de Janeiro";
$novo = $cliente[0]['estado'];
$pdf->Cell(0,0,$novo);

$pdf->setY("8.5");
$pdf->setX("2.3");
//$novo="31.907.330/0001-99";
$novo = $cliente[0]['cnpj'];
$pdf->Cell(0,0,$novo);

$pdf->setY("8.5");
$pdf->setX("14");
//$novo="83.548.037";
$novo = $cliente[0]['insc_estadual'];  //INSC ESTADUAL E/OU MUNICIPAL
$pdf->Cell(0,0,$novo);

$pdf->setY("9.3");
$pdf->setX("4.2");
$novo="";//cond pagamento
$pdf->Cell(0,0,$novo);

$pdf->setY("9.3");
$pdf->setX("12.1");
//$novo="05/02/2009";
$novo = $_POST['data1'];//VENCIMENTO
$pdf->Cell(0,0,$novo);

$pdf->setY("9.8");
$pdf->setX("4.2");
//$novo="0016/07";//CONTRATO DO CLIENTE
$novo = $cliente[0]['ano_contrato'];
$pdf->Cell(0,0,$novo);

$pdf->setY("9.8");
$pdf->setX("12.9");
//$novo="Aberto";
$novo = $_POST['tipo_contrato'];
$pdf->Cell(0,0,$novo);

$pdf->setY("10.4");
$pdf->setX("4.1");
//$novo="0056";
$novo = str_pad($_GET['cod_cliente'], 4, "0", STR_PAD_LEFT);//COD CLIENTE
$pdf->Cell(0,0,$novo);

$pdf->setY("10.4");
$pdf->setX("12.5");
//$novo="001";
$novo = str_pad($cliente[0]['filial_id'], 3, "0", STR_PAD_LEFT);
$pdf->Cell(0,0,$novo);
//1°
$pdf->setY("12.2");
$pdf->setX("1.4");
//$novo="01";
$novo = $_POST['quantidade'];
$pdf->Cell(0,0,$novo);

$pdf->setY("12");
$pdf->setX("2.5");
if($_POST['data_exibicao']){
   $date = $_POST['data_exibicao'];
}else{
   $date = date("d/m/Y");
}
//$novo="Prestação de serviço em Segurança e Medicina Ocupacional, conforme esta vigente no contrato de numero: 2005 / 0053. 0056. 001";
$_POST['descricao'] = str_replace("/  /", $date, $_POST['descricao']);

$contract = str_replace("/", ".", $cliente[0]['ano_contrato'])."/".STR_PAD($_GET['cod_cliente'], 4, "0", STR_PAD_LEFT);
$_POST['descricao'] = str_replace("%contract_number%", $contract, $_POST['descricao']);

$novo = $_POST['descricao']." - ".$_POST['resumo'];
$pdf->MultiCell(12,0.5,$novo,0,'J');

$pdf->setY("12.2");
$pdf->setX("15");
//$novo="6/12";
$novo = $_POST['parcelas'];
$pdf->Cell(0,0,$novo);

$pdf->setY("12.2");
$pdf->setX("17");
//$novo="420,65";
$novo = number_format($_POST['valor_unitario'],2,',','.');
$pdf->Cell(0,0,$novo);

$pdf->setY("12.2");
$pdf->setX("19.1");
//$novo="420,65";
$novo = number_format($total,2,',','.');
$pdf->Cell(0,0,$novo);

$pdf->setY("23.9");
$pdf->setX("19");
//$novo="420,65";
$novo = number_format($total,2,',','.');
$pdf->Cell(0,0,$novo);

$pdf->setY("24.5");
$pdf->setX("19");
//$novo="21,03";
$novo = number_format(($total*5)/100, 2,',','.');
$pdf->Cell(0,0,$novo);

$pdf->setY("25.3");
$pdf->setX("19");
//$novo="420,65";
$novo = number_format($total,2,',','.');
$pdf->Cell(0,0,$novo);

$pdf->setY("25.2");
$pdf->setX("5");
$novo="5";
$pdf->Cell(0,0,$novo);
$pdf->Output();
?>
