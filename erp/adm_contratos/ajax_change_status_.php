<?php
header("Content-Type: text/html; charset=ISO-8859-1",true);
include "../config/connect.php";

$sql = "UPDATE site_gerar_contrato SET status = '$_GET[val]' WHERE id = '$_GET[id]'";
$res = pg_query($sql);
$func = pg_fetch_array($res);

$sql = "SELECT * FROM site_gerar_contrato WHERE id = '$_GET[id]'";
$r = pg_query($sql);
$cinfo = pg_fetch_array($r);

if($_GET[val] == 1 && $cinfo[resumo_gerado] == 0){
$sql = "UPDATE site_gerar_contrato SET resumo_gerado = '1' WHERE id = '$_GET[id]'";
$res = pg_query($sql);
$func = pg_fetch_array($res);

   //CHECA MAX ID
   $sql = "SELECT MAX(cod_fatura) as cod_fatura FROM site_fatura_info";
   $r = pg_query($sql);
   $max = pg_fetch_array($r);

   $row_cod[cod_fatura] = $max[cod_fatura]+1;

   //$faturas = explode("/", $_GET['parcelas']);
   $z = $cinfo[n_parcelas];//($faturas[1] - $faturas[0]);

   $mes = date("m", strtotime($cinfo[vencimento]));
   $ano = date("Y", strtotime($cinfo[vencimento]));
   
   if(date("m") > $mes && date("Y") >= $ano){
       $mes = date("m");
       $ano = date("Y");
   }
   
   if(date("Y", strtotime($cinfo[vencimento])) <= date("d") && $mes == date("m")){
       $mes = date("m", mktime(0, 0, 0, $mes+1, date("Y", strtotime($cinfo[vencimento])), $ano));
   }

   if(date("d") > 27){
      $dia = 27;
   }else{
      $dia = date("d");
   }

   //valida dados como numerico e maior que zero
   if(is_numeric($z) && $z >= 0){
       //verifica se eh parceria ou não para busca de dados
      /*
      if($_GET[pc]){
          $sql = "SELECT * FROM cliente_pc WHERE cliente_id = {$_GET['cod_cliente']} AND filial_id={$_GET['cod_filial']}";
      }else{
          $sql = "SELECT * FROM cliente WHERE cliente_id = {$_GET['cod_cliente']} AND filial_id={$_GET['cod_filial']}";
      }
      */
      $sql = "SELECT * FROM cliente WHERE cliente_id = {$cinfo[cod_cliente]}";
      $rz = pg_query($sql);
      $dt = pg_fetch_array($rz);

      for($x=0;$x<$z;$x++){
         $sql = "INSERT INTO site_fatura_info
         (cod_fatura, cod_cliente, cod_filial, data_criacao, parcela, pc, data_vencimento, data_emissao)
         VALUES
         ('".($row_cod[cod_fatura]+$x)."','".$cinfo['cod_cliente']."','1',
         '".date("Y-m-d", mktime(0,0,0,$mes+$x,$dia,$ano))."',
         '".(1+$x)."/{$cinfo[n_parcelas]}', 0,
         '".date("Y-m-d", mktime(0,0,0,$mes+$x+2,date("d", strtotime($cinfo[vencimento])),$ano))."',
         '".date("Y-m-d", mktime(0,0,0,$mes+$x+1,21,$ano))."')";
         $result = pg_query($sql);

         //INSERT ENCARGOS BANCÁRIOS NO VALOR DE 4,00 COM N. CONTRATO
         $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade,
         parcelas, valor) VALUES
         ('".($row_cod[cod_fatura]+$x)."', '{$cinfo['cod_cliente']}','1',
         'Taxa de cobrança de encargo bancário conforme, Cláusula: 3 (p) vigente no contrato de numero: ".$dt[ano_contrato].".".STR_PAD($cinfo[cod_cliente],3, "0", STR_PAD_LEFT)."',
         1, '1/01', '4.00')";
         pg_query($sql);

         //INSERT TAXA DE CORRESPONDÊNCIA NO VALOR DE 6,50 COM N. CONTRATO
         $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade,
         parcelas, valor) VALUES
         ('".($row_cod[cod_fatura]+$x)."', '{$cinfo['cod_cliente']}','1',
         'Taxa correspondente a envio de correspondência, Conforme cláusula 3.1(p) do contrato de número: ".$dt[ano_contrato].".".STR_PAD($cinfo[cod_cliente],3, "0", STR_PAD_LEFT)."',
         1, '1/01', '6.50')";
         pg_query($sql);
         
         $valor_total = $cinfo['valor_contrato'];
         
         if($cinfo['n_parcelas'] > 3){
             //Acrescimo de 18%
             $valor_total_mod = round(($valor_total+(($valor_total*18)/100)));
         }elseif($cinfo['parcelas'] == 1){
             //Desconto de 7% pra pagamento a vista
             $valor_total_mod = round(($valor_total-(($valor_total*7)/100)));
         }else{
             $valor_total_mod = $valor_total;
         }
         
         //INSERT VALOR DE MENSALIDADE
         $sql = "INSERT INTO site_fatura_produto (cod_fatura, cod_cliente, cod_filial, descricao, quantidade,
         parcelas, valor) VALUES
         ('".($row_cod[cod_fatura]+$x)."', '{$cinfo['cod_cliente']}','1',
         'Prestação de serviço em Segurança e Medicina Ocupacional \"Cobrança Mensal\", conforme esta vigente na cláusula 4.1 do contrato de numero: ".$dt[ano_contrato].".".STR_PAD($cinfo[cod_cliente],3, "0", STR_PAD_LEFT)."',
         1, '".(1+$x)."/{$cinfo[n_parcelas]}', '".round($valor_total_mod/$cinfo['n_parcelas'], 2)."')";
         pg_query($sql);
      }
   }//numero de parcfelas > 0
   
        $sql = "SELECT c.razao_social, c.ano_contrato, ci.* FROM site_gerar_contrato ci, cliente c
        WHERE
        c.cliente_id = {$cinfo['cod_cliente']}
        AND
        c.cliente_id = ci.cod_cliente";
        $r = pg_query($sql);
        $buffer = pg_fetch_all($r);
        $x = 0;
        //enviar ao setor técnico cláusula 1
        $url = "<a href='http://sesmt-rio.com/contratos/first_page.php?cod_cliente={$buffer[$x][cod_cliente]}&cid={$buffer[$x][cod_orcamento]}/{$buffer[$x][ano_orcamento]}&tipo_contrato={$buffer[$x][tipo_contrato]}&sala={$buffer[$x][atendimento_medico]}&parcelas={$buffer[$x][n_parcelas]}&vencimento=".date("d/m/Y", strtotime($buffer[$x][vencimento]))."&rnd=".rand(10000, 99999)."' target=_blank>http://sesmt-rio.com/contratos/first_page.php?cod_cliente={$buffer[$x][cod_cliente]}&cid={$buffer[$x][cod_orcamento]}/{$buffer[$x][ano_orcamento]}&tipo_contrato={$buffer[$x][tipo_contrato]}&sala={$buffer[$x][atendimento_medico]}&parcelas={$buffer[$x][n_parcelas]}&vencimento=".date("d/m/Y", strtotime($buffer[$x][vencimento]))."&rnd=".rand(10000, 99999)."</a>";
        $headers = "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        $headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <juridico@sesmt-rio.com> \n";
        mail('segtrab@sesmt-rio.com', "Contrato {$dt[razao_social]}", $dt[razao_social].'<BR>'.$url, $headers);
        //enviar por email comunicado ao cliente
}
if($res)
    echo "Status alterado!";
else
    echo "Erro ao alterar status!";
?>
