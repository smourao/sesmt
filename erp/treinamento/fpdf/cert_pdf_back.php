<?php
ob_start();
include "../config/connect.php";
include "../functions.php";

$mes = array("", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho",
"Agosto", "Setembro", "Outubro", "Novembro", "Dezembro", );

define('PARAGRAPH_STRING', '~~~');
//require_once("fpdf/fpdf.php");
//require_once("fpdf/class.multicelltag.php");
//require_once("fpdf/header_footer.inc");

require_once("fpdf/class.fpdf_table.php");
require_once("fpdf/table_def.inc");


/*************************************************************************************************/
// --> INCOMMING - SERVER CONNECTION
/*************************************************************************************************/
$host = 'postgres345.locaweb.com.br';
$port = '5432';
$dbname = 'sesmt_rio';
$user = 'sesmt_rio';
$pass = 'diggio3001';
$str = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$conn = pg_connect($str);
/*************************************************************************************************/

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
     for($i=0;$i< count($data);$i++){
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
                    $this->MultiCell(145,5,$e,0,'C');
                }elseif($this->ALIGN == 'justify'){
                    $this->MultiCell(145,5,$e,0,"J");
                }elseif($this->ALIGN == 'right'){
                    $this->MultiCell(145,5,$e,0,"R");
                }
                else
                    $this->Write(5,$e);
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
    
/*************************************************************************************************/
//Page header
/*************************************************************************************************/
function Header()
{
    global $buffer;
    global $ccli;
    $this->AddFont("verdana");
    $this->AddFont("verdanab");
    $this->SetFont('Verdanab','',26);
    //largura, altura, texto, borda, quebra de linha, alinhamento
    //$this->Cell(35,0,'SESMT',0,0,'L');
    //$this->SetFont('Verdanab','',12);
    //$this->Cell(5,-8,'®',0,0,'L');
    //$this->SetFont('Verdanab','',8);
    //$this->Cell(0,4,'SERVIÇOS ESPECIALIZADOS DE SEGURANÇA',0,0,'L');
    $this->Ln(5);
    //$this->Cell(0,0,'E MONITORAMENTO DE ATIVIDADES NO TRABALHO LTDA',0,0,'L');
    //numero de contrato
    $this->SetFont('Verdanab','',8);
    //$pqp = 'CONTRATO nº.: '.$buffer['ano_contrato'].'.'.str_pad($ccli, 4,"0",STR_PAD_LEFT).'';
    //$this->Cell(0,0,$pqp,0,0,'R');
    $this->SetFont('Verdanab','',8);
    $this->Ln(3);
    //$this->Cell(0,0,'CNPJ 04.722.248/0001-17                                  INSC. MUN. 311.213-6',0,0,'L');
    $this->Ln(8);
    
    $this->Ln(20);
}
/*************************************************************************************************/
//Page footer
/*************************************************************************************************/
function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-32);
    //Arial italic 8
    $this->Ln(12);
    $this->AddFont("Verdana");
    $this->SetFont('Verdanab','',11);
    //$this->Cell(100,10,'Telefone: +55 (21) 3014 4304      Fax: Ramal 7',0,0,'C');
    $this->Cell(70,10,'',0,0,'L');
    $this->SetFont('Verdanab','',8);
    //$this->Cell(40,0,'Pensando em',0,0,'L');
    $this->Ln(4);$this->SetFont('Verdana','',10);
    //$this->Cell(100,10,'Nextel: +55 (21) 7844 9394 / Id 55*23*31368',0,0,'C');
    $this->Cell(70,10,'',0,0,'L');
    $this->SetFont('Verdanab','',8);
    //$this->Cell(40,0,'renovar seus',0,0,'L');
    $this->Ln(4);
    $this->SetFont('Verdana','',8);
    //$this->Cell(100,10,'faleprimeirocomagente@sesmt-rio.com / juridico@sesmt-rio.com',0,0,'C');
    //$this->Cell(70,10,'',0,0,'L');
    $this->SetFont('Verdanab','',8);
    //$this->Cell(0,0,'programas?',0,0,'L');
    $this->Ln(4);
    $this->SetFont('Verdana','',10);
    //$this->Cell(100,10,'www.sesmt-rio.com / www.shoppingsesmt.com',0,0,'C');
    //$this->Cell(70,10,'',0,0,'L');
    $this->SetFont('Verdanab','',8);
    //$this->Cell(0,0,'Fale primeiro',0,0,'L');
    $this->Ln(4);
    //$this->Cell(170,0,'',0,0,'L');
    //$this->Cell(0,0,'com a gente!',0,0,'L');
    }
}
define('FPDF_FONTPATH','fpdf/font/');


/**********************************************************************************************************/
//--> INICIO DA CLASSE FPDF                                               /
/**********************************************************************************************************/
$pdf=new PDF("L", "mm", "A4");

if(!$_GET[tid]){
    $sql = "SELECT t.*, f.*, c.*, fn.* FROM bt_treinamento t, funcionarios f, bt_cursos c, funcao fn
    WHERE
    t.cert_empresa=$_GET[mcid] AND
    t.cod_funcionario = f.cod_func AND
    t.cod_cliente = f.cod_cliente AND
    t.cod_curso = c.id AND
    f.cod_funcao = fn.cod_funcao";
}else{
    $sql = "SELECT t.*, f.*, c.*, fn.* FROM bt_treinamento t, funcionarios f, bt_cursos c, funcao fn
    WHERE
    t.id=$_GET[tid] AND
    t.cod_funcionario = f.cod_func AND
    t.cod_cliente = f.cod_cliente AND
    t.cod_curso = c.id AND
    f.cod_funcao = fn.cod_funcao";
}
$result = pg_query($sql);
$tr = pg_fetch_all($result);

for($x=0;$x<pg_num_rows($result);$x++){
//PAGE
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->AddFont("Verdana");
$pdf->SetFont('Verdanab','',12);
$pdf->Ln(6);
$pdf->Cell(277,5,$tr[$x][curso],1,0,'C');
$pdf->Ln(5);
$pdf->SetFont('Verdana','',8);
$pdf->Cell(107,5,'Aluno: '.$tr[$x][nome_func],1,0,'L');
$pdf->Cell(70,5,'CTPS: '.$tr[$x][num_ctps_func].' Série: '.$tr[$x][serie_ctps_func],1,0,'L');
$pdf->Cell(100,5,'Função: '.$tr[$x][nome_funcao],1,0,'L');
$pdf->Ln(5);
$pdf->SetFont('Verdana','',12);
$pdf->MultiCell(277,5,"HISTÓRICO\n\nCARGA HORÁRIA\n",1,'C');
$pdf->MultiCell(277,5,"{$tr[$x][descricao]}\n\nCarga Horária: {$tr[$x][carga_horaria]} Horas;\n\nConteúdo Programático:\n{$tr[$x][conteudo_programatico]}",1,'J');

/*$pdf->Ln(12);
$pdf->SetFont('Verdanab','',8);
$pdf->Cell(0,0,'Nº '.STR_PAD($tr[$x][numero_certificado], 6, "0",0).'',0,0,'R');
$pdf->Ln(4);
$pdf->Ln(4);
$pdf->SetFont('Verdana','',12);

$pdf->SetFont('Verdanab','',12);
$pdf->Cell(100,0,' ',1,0,'L');
$pdf->Cell(20,0,' ',0,0,'L');
$pdf->Cell(100,0,' ',1,0,'L');
$pdf->Ln(4);
$pdf->Image('ass.png',130,110,100,45);
$pdf->Cell(100,0,'Portador do Certificado',0,0,'C');
$pdf->Cell(20,0,' ',0,0,'C');
$pdf->Cell(100,0,'Coordenador',0,0,'C');
*/
}

$pdf->Output("contrato_aberto[".$buffer['ano_contrato'].'.'.str_pad($ccli, 4,"0",STR_PAD_LEFT)."].pdf", "I");

      /*
      REFERENCIAS :
  87.
      FPDF - >Esta é o construtor da classe. Ele permite que seja definido o formato da página, a orientação e a unidade de medida usada em todos os métodos (exeto para tamanhos de fonte).
  88.
      utilizacao : FPDF([string orientation [, string unit [, mixed format]]])
  89.

  90.
      SetFont -> Define a fonte que será usada para imprimir os caracteres de texto. É obrigatória a chamada, ao menos uma vez, deste método antes de imprimir o texto ou o documento resultante não será válido.
  91.
      utilizacao : SetFont(string family [, string style [, float size]])
  92.

  93.
      SetTitle - >Define o título do documento.
  94.
      utilizacao : SetTitle(string title)
  95.

  96.
      SetSubject -> Define o assunto do documento
  97.
      utilizacao : SetSubject(string subject)
  98.

  99.
      SetX - >Define a abscissa da posição corrente. Se o valor passado for negativo, ele será relativo à margem direita da página.
 100.
      utilizacao : SetX(float x)
 101.

 102.
      SetY - > Move a abscissa atual de volta para margem esquerda e define a ordenada. Se o valor passado for negativo, ele será relativo a margem inferior da página.
 103.

 104.
      utilizacao : SetY(float y)
 105.

 106.
      Cell - > Imprime uma célula (área retangular) com bordas opcionais, cor de fundo e texto. O canto superior-esquerdo da célula corresponde à posição atual. O texto pode ser alinhado ou centralizado. Depois de chamada, a posição atual se move para a direita ou para a linha seguinte. É possível pôr um link no texto.
 107.
      Se a quebra de página automática está habilitada e a pilha for além do limite, uma quebra de página é feita antes da impressão.
 108.
      utilizacao - >Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, int fill [, mixed link]]]]]]])
 109.

 110.
      Ln - > Faz uma quebra de linha. A abscissa corrente volta para a margem esquerda e a ordenada é somada ao valor passado como parâmetro.
 111.
      utilizacao ->Ln([float h])
 112.

 113.
      MultiCell - > Este método permite imprimir um texto com quebras de linha. Podem ser automática (assim que o texto alcança a margem direita da célula) ou explícita (através do caracter \n). Serão geradas tantas células quantas forem necessárias, uma abaixo da outra.
 114.
      O texto pode ser alinhado, centralizado ou justificado. O bloco de células podem ter borda e um fundo colorido.
 115.
      utilizacao : MultiCell(float w, float h, string txt [, mixed border [, string align [, int fill]]])
 116.

 117.
      Image ->Coloca uma imagem na página - tipos suportados JPG PNG
 118.
      utilizacao : Image(string file, float x, float y [, float w [, float h [, string type [, mixed link]]]])

      */
      ?>
