<?php
ob_start();
define('PARAGRAPH_STRING', '~~~');
//include "./config/connect.php";
require_once("fpdf/fpdf.php");


$host = 'postgresql02.sesmt-rio.com';
$port = '5432';
$dbname = 'sesmt_rio';
$user = 'sesmt_rio';
$pass = 'diggio3001';//'xxxxxx';//diggio3001

$str = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$conn = pg_connect($str) or die('Erro ao conectar a base de dados!');




class PDF extends FPDF
{
   var $widths;
   var $aligns;

      function SetWidths($w)
   {
     //Set the array of column widths
     $this->widths=$w;
   }

   function SetAligns($a)
   {
     //Set the array of column alignments
     $this->aligns=$a;
   }

   function Row($data)
   {
     //Calculate the height of the row
     $nb=0;
     for($i=0;$i< count($data);$i++)
         $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
     $h=5*$nb;
     //Issue a page break first if needed
     $this->CheckPageBreak($h);
     //Draw the cells of the row
     for($i=0;$i< count($data);$i++)
     {
         $w=$this->widths[$i];
         $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
         //Save the current position
         $x=$this->GetX();
         $y=$this->GetY();
         //Draw the border
         $this->Rect($x,$y,$w,$h);
         //Print the text
         $this->MultiCell($w,5,$data[$i],0,$a);
         //Put the position to the right of the cell
         $this->SetXY($x+$w,$y);
     }
     //Go to the next line
     $this->Ln($h);
   }

   function CheckPageBreak($h)
   {
     //If the height h would cause an overflow, add a new page immediately
     if($this->GetY()+$h>$this->PageBreakTrigger)
         $this->AddPage($this->CurOrientation);
   }

   function NbLines($w,$txt)
   {
     //Computes the number of lines a MultiCell of width w will take
     $cw=&$this->CurrentFont['cw'];
     if($w==0)
         $w=$this->w-$this->rMargin-$this->x;
     $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
     $s=str_replace("\r",'',$txt);
     $nb=strlen($s);
     if($nb>0 and $s[$nb-1]=="\n")
         $nb--;
     $sep=-1;
     $i=0;
     $j=0;
     $l=0;
     $nl=1;
     while($i<$nb)
     {
         $c=$s[$i];
         if($c=="\n")
         {
             $i++;
             $sep=-1;
             $j=$i;
             $l=0;
             $nl++;
             continue;
         }
         if($c==' ')
             $sep=$i;
         $l+=$cw[$c];
         if($l>$wmax)
         {
             if($sep==-1)
             {
                 if($i==$j)
                     $i++;
             }
             else
                 $i=$sep+1;
             $sep=-1;
             $j=$i;
             $l=0;
             $nl++;
         }
         else
             $i++;
     }
     return $nl;
   }

function WriteText($text)
{
    $intPosIni = 0;
    $intPosFim = 0;
    if (strpos($text,'<')!==false and strpos($text,'[')!==false)
    {
        if (strpos($text,'<')<strpos($text,'['))
        {
            $this->Write(5,substr($text,0,strpos($text,'<')));
            $intPosIni = strpos($text,'<');
            $intPosFim = strpos($text,'>');
            $this->SetFont('verdanab','');
            $this->Write(5,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1));
            $this->SetFont('verdana','');
            $this->WriteText(substr($text,$intPosFim+1,strlen($text)));
        }
        else
        {
            $this->Write(5,substr($text,0,strpos($text,'[')));
            $intPosIni = strpos($text,'[');
            $intPosFim = strpos($text,']');
            $w=$this->GetStringWidth('a')*($intPosFim-$intPosIni-1);
            $this->Cell($w,$this->FontSize+0.75,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1),1,0,'');
            $this->WriteText(substr($text,$intPosFim+1,strlen($text)));
        }
    }
    else
    {
        if (strpos($text,'<')!==false)
        {
            $this->Write(5,substr($text,0,strpos($text,'<')));
            $intPosIni = strpos($text,'<');
            $intPosFim = strpos($text,'>');
            $this->SetFont('verdanab','');
            $this->WriteText(substr($text,$intPosIni+1,$intPosFim-$intPosIni-1));
            $this->SetFont('verdana','');
            $this->WriteText(substr($text,$intPosFim+1,strlen($text)));
        }
        elseif (strpos($text,'[')!==false)
        {
            $this->Write(5,substr($text,0,strpos($text,'[')));
            $intPosIni = strpos($text,'[');
            $intPosFim = strpos($text,']');
            $w=$this->GetStringWidth('a')*($intPosFim-$intPosIni-1);
            $this->Cell($w,$this->FontSize+0.75,substr($text,$intPosIni+1,$intPosFim-$intPosIni-1),1,0,'');
            $this->WriteText(substr($text,$intPosFim+1,strlen($text)));
        }
        else
        {
            $this->Write(5,$text);
        }

    }
}

    var $B=0;
    var $I=0;
    var $U=0;
    var $HREF='';
    var $ALIGN='';

    function WriteHTML($html)
    {
        //HTML parser
        $html=str_replace("\n",' ',$html);
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                elseif($this->ALIGN == 'center'){
                    $this->MultiCell(145,4,$e,0,'C');
                                }
                                elseif($this->ALIGN == 'justify'){
                                        $this->MultiCell(145,4,$e,0,"J");
                                }
                                elseif($this->ALIGN == 'right'){
                                        $this->MultiCell(145,4,$e,0,"R");
                                }
                else
                    $this->Write(4,$e);
            }
            else
            {
                //Tag
                if($e{0}=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract properties
                    $a2=split(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $prop=array();
                    foreach($a2 as $v)
                        if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
                            $prop[strtoupper($a3[1])]=$a3[2];
                    $this->OpenTag($tag,$prop);
                }
            }
        }
    }

    function OpenTag($tag,$prop)
    {
        //Opening tag
        if($tag=='B' or $tag=='I' or $tag=='U'){
            if($tag=='B'){
               $this->SetFont('verdanab','');
            }else{
               $this->SetStyle($tag,true);
            }
        }
        if($tag=='A')
            $this->HREF=$prop['HREF'];
        if($tag=='BR')
            $this->Ln(5);
        if($tag=='P')
            $this->ALIGN=$prop['ALIGN'];
        if($tag=='HR')
        {
            if( $prop['WIDTH'] != '' )
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin-$this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x,$y,$x+$Width,$y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }

    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='B' or $tag=='I' or $tag=='U'){
            if($tag=='B'){
               $this->SetFont('verdana','');
            }else{
               $this->SetStyle($tag,false);
            }
        }
        if($tag=='A')
            $this->HREF='';
        if($tag=='P')
            $this->ALIGN='';
    }

   function SetStyle($tag,$enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
            if($this->$s>0)
                $style.=$s;
        $this->SetFont('',$style);
    }

    function PutLink($URL,$txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
//Page header
function Header()
{

	$this->AddFont("verdana");
    $this->AddFont("verdanab");
    $this->SetFont('Verdana','',10);

    //largura, altura, texto, borda, quebra de linha, alinhamento
//    $this->Image('logo_sesmt.gif',0,0,80,40);
//    $this->SetTextColor(0,102,51);
//    $this->Cell(90,0,' ',0,0,'L');
//    $this->Cell(35,-8,'Serviços Especializados de Segurança e',0,0,'L');
    $this->Ln(4);
//    $this->Cell(90,0,' ',0,0,'L');
//    $this->Cell(35,-4,'Monitoramento de Atividades no Trabalho LTDA.',0,0,'L');
    $this->Ln(4);
//    $this->Cell(90,0,' ',0,0,'L');
//    $this->Cell(35,0,'Segurança do Trabalho e Higiene Ocupacional.',0,0,'L');

   //if($cod_orcamento!=""){coloca_zeros($cod_orcamento);}
//    $this->SetTextColor(0,0,0);
//    $this->Ln(8);
//    $orc = str_pad($_GET['cod_orcamento'], 4, "0", STR_PAD_LEFT)." / 2009";
//    $this->Cell(140,0,' ',0,0,'L');
    //$pdf->WriteHTML($orc);
//    $this->SetFont('Verdanab','',10);
//    $this->Cell(25,0,'Orçamento: ',0,0,'L');
//    $this->SetFont('Verdana','',10);
//    $this->Cell(35,0,$orc,0,0,'L');
    $this->Ln(4);
	$this->Ln(18);

}

//Page footer
function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-25);
    //Arial italic 8
    $this->AddFont("Verdana");
    $this->SetFont('Verdanab','',11);

    $this->Cell(100,10,'Telefone: +55 (21) 3014 4304      Fax: Ramal 7',0,0,'C');
    $this->Cell(70,10,'',0,0,'L');$this->SetFont('Verdanab','',8);
 //   $this->Cell(40,0,'Pensando em',0,0,'L');
    $this->Ln(4);$this->SetFont('Verdana','',10);
    $this->Cell(100,10,'Nextel: +55 (21) 7844 9394 / Id 55*23*31368',0,0,'C');
    $this->Cell(70,10,'',0,0,'L');
    $this->SetFont('Verdanab','',8);
//    $this->Cell(40,0,'renovar seus',0,0,'L');
    $this->Ln(4);$this->SetFont('Verdana','',8);
    $this->Cell(100,10,'faleprimeirocomagente@sesmt-rio.com / juridico@sesmt-rio.com',0,0,'C');
    $this->Cell(70,10,'',0,0,'L');
//    $this->SetFont('Verdanab','',8);$this->Cell(0,0,'programas?',0,0,'L');
    $this->Ln(4);$this->SetFont('Verdana','',10);
    $this->Cell(100,10,'www.sesmt-rio.com / www.shoppingsesmt.com',0,0,'C');
    $this->Cell(70,10,'',0,0,'L');
//    $this->SetFont('Verdanab','',8);$this->Cell(0,0,'Fale primeiro',0,0,'L');
    $this->Ln(4); $this->Cell(170,0,'',0,0,'L');
//    $this->Cell(0,0,'com a gente!',0,0,'L');

   //$this->Image('logo_sesmt.gif',0,-25,80,40);

}
}

define('FPDF_FONTPATH','fpdf/font/');



$cliente_id = $_GET[cliente_id];
$item = 0;

if ($cliente_id!="" ){

	$query_cli = "select
					cliente_id
					, razao_social
					, endereco
					, num_end
					, bairro
					, cep
					, cnpj
					, insc_municipal
					, grau_de_risco
					, nome_contato_dir
					, telefone
					, email
					, cnae_id
					, numero_funcionarios
					, classe
				  FROM cliente_comercial cc, orcamento o, orcamento_produto op
				  WHERE cc.cliente_id = o.cod_cliente
				  AND o.cod_orcamento = op.cod_orcamento
				  AND cc.cliente_id = $cliente_id";

	$result_cli = pg_query($query_cli) or die ("Erro na cunsulta!" .pg_last_error($connect));

	$row = pg_fetch_array($result_cli);
}

function coloca_zeros($numero){
echo str_pad($numero, 4, "0", STR_PAD_LEFT);
}

function cz($num){
return str_pad($num, 2, "0", STR_PAD_LEFT);
}

function zero($number){
return str_pad($number, 3, "0", STR_PAD_LEFT);
}

function convertwords($text){
$siglas = array("ppp", "ppra", "pcmso", "aso", "cipa", "apgre", "ltcat", "epi", "ltda", "sa", "me",//Siglas normais
				"ppp,", "ppra,", "pcmso,", "aso,", "cipa,", "apgre,", "ltcat,", "epi,", //Siglas com vírgula
				"(ppp)", "(ppra)", "(pcmso)", "(aso)", "(cipa)", "(apgre)", "(ltcat)", "(epi)", //Siglas entre parênteses
				"nr", "nr.", "mr", "mr.", "in", "in.", "me.", "nbr", "nbr.", "ltda.", "a0", "a3", "a4", "(a4)", "s/a"); //Siglas diversas
$at = explode(" ", $text);
$temp = "";
for($x=0;$x<count($at);$x++){
   $at[$x] = strtolower($at[$x]);
      $at[$x] = strtr(strtolower($at[$x]),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");


  if(in_array($at[$x], $siglas)){
     $at[$x] = strtoupper($at[$x]);
  }elseif(strlen($at[$x])>3){
        $at[$x] = ucwords($at[$x]);
    }

    $temp .= $at[$x]." ";
}
return $temp;
}




$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddFont("Verdana");
$pdf->SetFont('Verdana','',8);
$pdf->Ln(10);
$pdf->WriteHTML('<b>Cod. Cliente:</b> '.$row['cliente_id'].'  <b>Nome:</b> '.convertwords($row[razao_social]));
$pdf->Ln(4);
$pdf->WriteHTML("<b>Endereço:</b> {$row['endereco']}  <b>Nº:</b> {$row['num_end']}  <b>Bairro:</b> {$row['bairro']}  <b>Cep:</b> {$row['cep']}");
$pdf->Ln(4);
$pdf->WriteHTML("<b>CNPJ:</b> {$row[cnpj]}   <b>I.M:</b> {$row[insc_municipal]}     <b>Grau de Risco:</b> {$row[grau_de_risco]} / {$row[numero_funcionarios]}");
$pdf->Ln(4);
$pdf->WriteHTML("<b>ATT:</b> {$row[nome_contato_dir]}   <b>Telefone:</b> {$row[telefone]}   <b>E-mail:</b> {$row[email]}");

$pdf->Ln(8);
$pdf->SetFont('Verdana','',6);
$pdf->Cell(0,3,'Conforme contato estabelecido com V. Sas., estamos apresentando proposta de prestação de serviços, como segue abaixo:', 1);
$pdf->Ln(8);

$pdf->SetFont('Verdana','',10);
$pdf->Cell(10, 0, 'Item', 0,0,'C');
$pdf->Cell(100, 0, 'Descrição do(s) Serviço(s):', 0,0, 'C');
$pdf->Cell(10, 0, 'Qtd', 0,0,'C');
$pdf->Cell(35, 0, 'Preço Unitário', 0,0,'R');
$pdf->Cell(35, 0, 'Preço Total', 0,0,'R');
$pdf->Ln(10);

	$query_prod = "SELECT cod_prod, quantidade, desc_resumida_prod, preco_prod
				   FROM orcamento_produto op, produto p, cliente_comercial cc, orcamento o
				   WHERE op.cod_produto = p.cod_prod
				   and o.cod_orcamento = op.cod_orcamento
				   and o.cod_cliente = cc.cliente_id
				   and cc.cliente_id = $cliente_id ";
	$result_prod = pg_query($query_prod) or die ("Erro na consulta!".pg_last_error($connect));
	$total = 0;
	$x=1;
	$pdf->SetFont('Verdana','',8);
    $total = 0;
    $adj = 74;
while($row_prod = pg_fetch_array($result_prod)){
		//$total += ($row_prod[preco_prod]*$row_prod[quantidade]);

        if($line_mult > 157){
           $pdf->AddPage();
           $tmp = 8;
           $adj = 40;
        }
        
        if($tmp == 0)$tmp=8;
        //if(strlen($row_prod[desc_resumida_prod])>100
        $line_mult = $tmp;//15;//valor que multiplica a altura da linha

		$pdf->SetY(($line_mult)+$adj);
        $pdf->SetX(10);
		$pdf->Cell(10, 0, STR_PAD($x, 2, "0", STR_PAD_LEFT), 0,0,'C');
   		$pdf->SetY(($line_mult)+($adj-1));
        $pdf->SetX(20);
        $pdf->MultiCell(100, 3, convertwords($row_prod[desc_resumida_prod]));
        $pdf->SetY(($line_mult)+$adj);
        $pdf->SetX(120);
        $pdf->Cell(10, 0, STR_PAD($row_prod[quantidade], 3, "0", STR_PAD_LEFT), 0,0,'C');
        $pdf->Cell(35, 0, 'R$ '.number_format($row_prod[preco_prod], 2, ',','.'), 0,0,'R');
        $pdf->Cell(35, 0, 'R$ '.number_format(($row_prod[preco_prod]*$row_prod[quantidade]), 2, ',','.'), 0,0,'R');
//        $pdf->MultiCell(0,4,convertwords($row_prod[desc_resumida_prod]),'J');
        $pdf->Ln(8);
        $x++;
        $last =  ($line_mult)+$adj;

         //strlen($row_prod[desc_resumida_prod]) / 17,6
        if(strlen($row_prod[desc_resumida_prod]) > 100){
          //$tmp = strlen($row_prod[desc_resumida_prod]) / 60;
          $tmp = $tmp + (strlen($row_prod[desc_resumida_prod]) / 50) * 4;
        }else{
          $tmp = $tmp + 10;
        }

        $total += ($row_prod[preco_prod]*$row_prod[quantidade]);
    }

    $subtotal = $total;
	$percentual = 18.0 / 100.0;
	$parcelas = $subtotal / 3;
	$tot_porcento = $subtotal + ($percentual * $subtotal);
	$tot_parc = $tot_porcento / 12;

    //if($cliente_id!=""){
	$ass = "SELECT f.nome, f.assinatura
			FROM funcionario f, cliente_comercial cc
			WHERE cc.funcionario_id = f.funcionario_id
			AND cc.cliente_id = $cliente_id";

	$res_ass = pg_query($ass) or die
		("Erro na query: $ass ==>". pg_last_error());

	$r_ass = pg_fetch_array($res_ass);
	//}

    $pdf->Ln(8);
    $pdf->SetFont('Verdanab','',8);
        $pdf->SetX(120);
        $pdf->Cell(10, 0, '', 0,0,'C');
        $pdf->Cell(35, 0, 'TOTAL: ', 0,0,'R');
        $pdf->Cell(35, 0, 'R$ '.number_format($subtotal,2,",","."), 0,0,'R');



    $pdf->Ln(20);
    $pdf->Image($r_ass[assinatura],45,$last+16,30,20);
    $pdf->Cell(100, 0,$r_ass[nome],0,0,'C');
    $pdf->Ln(4);
    $pdf->Cell(100,0,"Departamento Comercial",0,0,'C');
    $pdf->SetFont('Verdana','',8);

    $pdf->Ln(8);

    $pdf->WriteHTML("<b>Prazo de Entrega:</b> 15 DIAS.");
    $pdf->Ln(4);
    //$pdf->MultiCell(0,4,"<b>Forma de pagamento:</b> R$ ".number_format($subtotal,2,",",".")." divididos em 03 parcelas iguais de R$ ".number_format($parcelas,2,",",".")." ou R$ ".number_format($subtotal,2,",",".")." acrescidos de 18% R$ ".number_format($tot_porcento,2,",",".")." dividos em 12 parcelas iguais de R$ ".number_format($tot_parc,2,",",".").".");
    $pdf->WriteHTML("<b>Forma de pagamento:</b> R$ ".number_format($subtotal,2,",",".")." divididos em 03 parcelas iguais de R$ ".number_format($parcelas,2,",",".")." ou R$ ".number_format($subtotal,2,",",".")." acrescidos de 18% R$ ".number_format($tot_porcento,2,",",".")." dividos em 12 parcelas iguais de R$ ".number_format($tot_parc,2,",",".").".");
    $pdf->Ln(4);
    $pdf->WriteHTML("<b>OBS: Os exames complementares ao ASO serão solicitados automaticamente, no momento do atendimento médico de acordo com a função exercida por cada trabalhador e seu pagamento deverá ser efetuado separadamente.</b>");

$pdf->Output();

?>
