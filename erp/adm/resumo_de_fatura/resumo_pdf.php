<?php
ob_start();
define('PARAGRAPH_STRING', '~~~');
require_once("fpdf/fpdf.php");
require_once("fpdf/class.fpdf_table.php");
require_once("fpdf/table_def.inc");
//require_once("class.multicelltag.php");
// ---------------------------------------------------------------------------
// desenvolvido por..: SL4Y3R

$mes = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto",
"Setembro", "Outubro", "Novembro", "Dezembro");

$host = 'postgresql02.sesmt-rio.com';
$port = '5432';
$dbname = 'sesmt_rio';
$user = 'sesmt_rio';
$pass = 'diggio3001';
$str = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$conn = pg_connect($str) or die('Erro ao conectar a base de dados!');

$_GET[cod_cliente];
$_GET[fatura];
$_GET[pc];


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
    global $buffer;
    global $ccli;
    $this->AddFont("verdana");
    $this->AddFont("verdanab");
    $this->SetFont('Verdanab','',26);
    //largura, altura, texto, borda, quebra de linha, alinhamento
    $this->Cell(35,0,'SESMT',0,0,'L');
    $this->SetFont('Verdanab','',12);
    $this->Cell(5,-8,'®',0,0,'L');
    $this->SetFont('Verdanab','',8);
    $this->Cell(0,4,'SERVIÇOS ESPECIALIZADOS DE SEGURANÇA',0,0,'L');
    $this->Ln(5);
    $this->Cell(0,0,'E MONITORAMENTO DE ATIVIDADES NO TRABALHO LTDA',0,0,'L');
    //numero de contrato
    $this->SetFont('Verdana','',8);
    $this->Cell(0,-16,'Página '.$this->PageNo().' de {total}',0,0,'R');
    $this->SetFont('Verdanab','',12);
    $pqp = 'Resumo de Fatura de Serviço';
    $this->Cell(0,-8,$pqp,0,0,'R');
    $this->SetFont('Verdanab','',8);
    $this->Ln(3);
    $this->Cell(0,0,'CNPJ 04.722.248/0001-17                                  INSC. MUN. 311.213-6',0,0,'L');
    $this->Ln(8);
}

//Page footer
function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-32);
    //Arial italic 8
    $this->Ln(12);
    $this->AddFont("Verdana");
    $this->SetFont('Verdanab','',11);
    $this->Cell(100,10,'Telefone: +55 (21) 3014 4304      Fax: Ramal 7',0,0,'C');
    $this->Cell(70,10,'',0,0,'L');$this->SetFont('Verdanab','',8);
    $this->Cell(40,0,'Pensando em',0,0,'L');
    $this->Ln(4);$this->SetFont('Verdana','',10);
    $this->Cell(100,10,'Nextel: +55 (21) 7844 9394 / Id 55*23*31368',0,0,'C');
    $this->Cell(70,10,'',0,0,'L');
    $this->SetFont('Verdanab','',8);$this->Cell(40,0,'renovar seus',0,0,'L');
    $this->Ln(4);$this->SetFont('Verdana','',8);
    $this->Cell(100,10,'faleprimeirocomagente@sesmt-rio.com / juridico@sesmt-rio.com',0,0,'C');
    $this->Cell(70,10,'',0,0,'L');
    $this->SetFont('Verdanab','',8);$this->Cell(0,0,'programas?',0,0,'L');
    $this->Ln(4);$this->SetFont('Verdana','',10);
    $this->Cell(100,10,'www.sesmt-rio.com / www.shoppingsesmt.com',0,0,'C');
    $this->Cell(70,10,'',0,0,'L');
    $this->SetFont('Verdanab','',8);$this->Cell(0,0,'Fale primeiro',0,0,'L');
    $this->Ln(4); $this->Cell(170,0,'',0,0,'L');
    $this->Cell(0,0,'com a gente!',0,0,'L');

    }
}
define('FPDF_FONTPATH','fpdf/font/');


$pdf=new PDF();
$pdf->AliasNbPages( '{total}' );
$pdf->AddPage();
$pdf->AddFont("Verdana");
$pdf->SetFont('Verdanab','',8);
$pdf->Ln(4);
$pdf->Cell(160,6,'Resumo de Fatura de Serviço'.strtoupper($contrato),'LTB',0,'L');
$pdf->Cell(30,6,'Nº 03241/10','RTB',0,'L');
$pdf->Ln(4);
$pdf->Ln(2);
$pdf->SetFont('Verdana','',8);
$pdf->Cell(70,6,' ',0,'L');
$pdf->WriteHTML("<b>Cliente:</b> xxxxxxxxxxxxxxxxxxxxx");
$pdf->Ln(4);
$pdf->Cell(70,6,' ',0,'L');
$pdf->WriteHTML("<b>CNPJ:</b> xxxxxxxxxxxxxxxxxxxxx");
$pdf->Ln(4);
$pdf->Cell(70,6,' ',0,'L');
$pdf->WriteHTML("<b>Telefone:</b> xxxxxxxxxxxxxxxxxxxxx");
$pdf->Ln(4);
$pdf->Cell(70,6,' ',0,'L');
$pdf->WriteHTML("<b>Nextel id:</b> xxxxxxxxxxxxxxxxxxxxx");
$pdf->Ln(4);
$pdf->Cell(70,6,' ',0,'L');
$pdf->WriteHTML("<b>Contrato de Cliente:</b> xxxxxxxxxxxxxxxxxxxxx");
$pdf->Ln(4);
$pdf->Cell(70,6,' ',0,'L');
$pdf->WriteHTML("<b>Tipo de Contrato:</b> xxxxxxxxxxxxxxxxxxxxx");
$pdf->Ln(4);
$pdf->Cell(70,6,' ',0,'L');
$pdf->WriteHTML("<b>Código do Cliente:</b> xxxxxxxxxxxxxxxxxxxxx");
$pdf->Ln(4);
$pdf->Cell(70,6,' ',0,'L');
$pdf->WriteHTML("<b>Data da Emissão:</b> xxxxxxxxxxxxxxxxxxxxx");
$pdf->Ln(4);
$pdf->Cell(70,6,' ',0,'L');
$pdf->WriteHTML("<b>Período de Cobrança:</b> xxxxxxxxxxxxxxxxxxxxx");
$pdf->Ln(4);
$pdf->Cell(70,6,' ',0,'L');
$pdf->WriteHTML("<b>Vencimento:</b> xxxxxxxxxxxxxxxxxxxxx");
$pdf->Ln(4);
$pdf->Ln(4);
$pdf->MultiCell(70,6,'Natureça dos Serviços','LTBR','L');
//$pdf->SetX(0);
$y = $pdf->SetY();
$pdf->SetY($y+10);
$pdf->MultiCell(70,6,'Natureça dos Serviços','LTBR','L');


$pdf->Output("resumo_fatura.pdf", "I");


?>
