<?PHP
    if(!is_numeric($_GET[status])){
        $_GET[status] = -1;
    }
        if($_GET[action]=='del' && $_GET[id]){
            $sql = "DELETE FROM site_contrato_info WHERE id = $_GET[id]";
            pg_query($sql);
            echo "<script>location.href='?action=list';</script>";
        }
        
        if(!empty($_GET[mail])){
           //
           $sql = "SELECT * FROM cliente WHERE cliente_id = $_GET[cod_cliente]";
           $res = pg_query($sql);
           $cliente = pg_fetch_array($res);
           
           $url = "http://sesmt-rio.com/contratos/aberto.php?cod_cliente={$_GET[cod_cliente]}&cid={$_GET[cid]}&tipo_contrato={$_GET[tipo_contrato]}&sala={$_GET[sala]}&parcelas={$_GET[parcelas]}&vencimento={$_GET[vencimento]}&rnd=".rand(10000, 99999);
           //echo $url;
           
           
           $msg = "<!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
           <HTML>
           <HEAD>
              <TITLE>SESMT</TITLE>
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
		  <p>";
        $msg.= "
        </td>
	</tr>
</table></div>
<div align=center>
<table width=100% border=0 cellpadding=0 cellspacing=0 >
	<tr>
		<td width=100% class=fontepreta12><span class=style15>
Prezado(ª) {$cliente[nome_contato_dir]}, Solicito imprimir o contrato em duas vias, ler o contrato atentamente.
Rubricar cada folha, porém, a última deverá ser assinada e reconhecido firma da assinatura e
enviar a Sesmt via correios. <p>
Os anexos são normatização que dão validades as cláusulas em que se diz respeito cada um deles
sendo tão somente necessária a rubrica das primeiras páginas, a assinatura da última e o respectivo
reconhecimento de firma da assinatura.<p>

....continuação dos  anexos onde constam a razão social e o CNPJ da CONTRATANTE e o anexo 1 que é o
objetivo deste contrato.<p>

Remeter junto com a nossa via do contrato e, cópia das primeira e últimas folhas do contrato social
ou estatuto, solicito ainda informar ao escritório de contabilidade quem presta serviços a sua
empresa sobre a celebração do contrato com a SESMT para que formalmente apresentados possamos
coletar-mos informações importante a prestação dos serviços.<p>

Link para visualizar e imprimir o contrato:<br>
<a href='$url' target=_blank>$url</a>
        </td>
	</tr>
</table></div>
";

$msg .= "<div align=\"center\">
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
$headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <juridico@sesmt-rio.com> \n";

$mail_list = explode(";", $_GET['mail']);
$ok = "";
$er = "";

for($x=0;$x<count($mail_list);$x++){
    if($mail_list[$x] != ""){
       if(mail($mail_list[$x], "Contrato - SESMT", $msg, $headers)){
          $ok .= ", ".$mail_list[$x];
       }else{
          $er .= ", ".$mail_list[$x];
       }
    }
}

echo "<script>alert('E-Mails enviado para".$ok."');location.href='?action=list';</script>";

        }

        echo "<FORM method='post' action='?action=list&q=search'>";
        echo "<table BORDER=0 align=center width=100%>";
        echo "<tr>";
        echo "<td width=100 align=left class=fontebranca12><b>Consulta:</b></td>";
        echo "<td class=fontebranca12><input type=text value='{$_POST[search]}' name=search size=30> <input type=submit value='Pesquisar'> </td>";
        echo "<td>";
        echo "</tr>";
        echo "</table>";
        echo "</FORM>";
        echo "<br>";
        echo "<center><!--<a href='?action=list' class=fontebranca12><b>Todos</b></a> | --><a href='?action=list&status=0' class=fontebranca12><b>Aguardando</b></a> | <a href='?action=list&status=1' class=fontebranca12><b>Finalizados</b></a> | <a href='?action=list&status=2' class=fontebranca12><b>Cancelados</b></a></center>";
        echo "<br>";
        if($_POST){
            $sql = "SELECT c.razao_social, c.ano_contrato, c.email as mail, ci.* FROM site_gerar_contrato ci, cliente c WHERE
            c.cliente_id = ci.cod_cliente AND
            LOWER(razao_social) LIKE '%".strtolower($_POST[search])."%' ORDER BY id";
        }else{
            if($_GET[status]>=0 && is_numeric($_GET[status]) && $_GET[status]<=2){
                $sql = "SELECT c.razao_social, c.ano_contrato, c.email as mail, ci.*
                FROM site_gerar_contrato ci, cliente c
                WHERE
                ci.status = {$_GET[status]}
                AND
                c.cliente_id = ci.cod_cliente
                ORDER BY id";
            }elseif($_GET[status] <0){
                $sql = "SELECT c.razao_social, c.ano_contrato, c.email as mail, ci.*
                FROM site_gerar_contrato ci, cliente c
                WHERE
                ci.status <> 2
                AND
                c.cliente_id = ci.cod_cliente
                ORDER BY id";
            }else{
                $sql = "SELECT c.razao_social, c.ano_contrato, c.email as mail, ci.* FROM site_gerar_contrato ci, cliente c WHERE
                c.cliente_id = ci.cod_cliente ORDER BY id";
            }
        }
        $r = pg_query($sql);
        $buffer = pg_fetch_all($r);

        if(pg_num_rows($r)>0){
        echo "<table width=100% BORDER=1 align=center>";
        echo "<tr>";
        echo "<td align=center width=20 class=fontebranca12><b>Nº</b></td>";
        echo "<td align=center class=fontebranca12><b>Razão Social</b></td>";
        echo "<td align=center width=80 class=fontebranca12><b>Contrato</b></td>";
        echo "<td align=center width=80 class=fontebranca12><b>Resumo</b></td>";
        //echo "<td align=center width=60 class=fontebranca12><b>Vencimento</b></td>";
        echo "<td align=center width=60 class=fontebranca12><b>Enviar</b></td>";
        echo "<td align=center width=60 class=fontebranca12><b>Orçamento</b></td>";
        echo "<td align=center width=60 class=fontebranca12><b>Status</b></td>";
        echo "</tr>";
            for($x=0;$x<pg_num_rows($r);$x++){
                echo "<tr>";
                echo "<td class=fontebranca12 align=center><font size=1>".($x+1)."</td>";
                echo "<td class=fontebranca12 align=left>
                <a class=fontebranca12 target=_blank href='http://sesmt-rio.com/contratos/aberto.php?cod_cliente={$buffer[$x][cod_cliente]}&cid={$buffer[$x][cod_orcamento]}/{$buffer[$x][ano_orcamento]}&tipo_contrato={$buffer[$x][tipo_contrato]}&sala={$buffer[$x][atendimento_medico]}&parcelas={$buffer[$x][n_parcelas]}&vencimento=".date("d/m/Y", strtotime($buffer[$x][vencimento]))."&rnd=".rand(10000, 99999)."'>
                <b>".$buffer[$x][razao_social]."</b>
                </a></td>";
                echo "<td class=fontebranca12 align=center  onMouseOver=\"return overlib('<center><b>{$buffer[$x][razao_social]}</b></center><p><b>Vencimento: </b>".date("d/m/Y", strtotime($buffer[$x][vencimento]))."<br><b>Data de Criação: </b>".date("d/m/Y", strtotime($buffer[$x][data_criacao]))."<br><b>Última Alteração: </b>".date("d/m/Y", strtotime($buffer[$x][ultima_alteracao]))."');\" onMouseOut=\"return nd();\">".$buffer[$x][ano_contrato].".".str_pad($buffer[$x][cod_cliente], 4, "0", 0)."</td>";
                echo "<td class=fontebranca12 align=center>
                <a class=fontebranca12 href='?action=propriedade_de_contrato&cod_cliente={$buffer[$x][cod_cliente]}'>
                <b>Visualizar</b></a></td>";
                
                //echo "<td class=fontebranca12 align=center><font size=1>".date("d/m/Y", strtotime($buffer[$x][vencimento]))."</td>";
                echo "<td class=fontebranca12 align=center><a href='javascript:;' class=fontebranca12 onclick=\"if(mail = prompt('Informe o E-Mail que receberá o contrato:','{$buffer[$x][mail]}')){location.href='?action=list&mail='+mail+'&cod_cliente={$buffer[$x][cod_cliente]}&cid={$buffer[$x][cod_orcamento]}/{$buffer[$x][ano_orcamento]}&tipo_contrato={$buffer[$x][tipo_contrato]}&sala={$buffer[$x][atendimento_medico]}&parcelas={$buffer[$x][n_parcelas]}&vencimento=".date("d/m/Y", strtotime($buffer[$x][vencimento]))."'};\"><b>Enviar</b></a></td>";

                $orc = $buffer[$x][cod_orcamento];//explode("/", $buffer[$x][cod_orcamento]);
                echo "<td class=fontebranca12 align=center>
                <a class=fontebranca12 target=_blank href='http://www.sesmt-rio.com/erp/cria_orcamento.php?act=edit&cod_cliente={$buffer[$x][cod_cliente]}&cod_filial=1&orcamento={$orc}'>
                <b>".$buffer[$x][cod_orcamento]."/".$buffer[$x][ano_orcamento]."
                </b></a></td>";
                echo "<td class=fontebranca12 align=center>";
                echo "<select id=status name=status onchange=\"cStatus('{$buffer[$x][id]}', this.value);\">";
                    echo "<option value=0"; print $buffer[$x][status] == 0 ? " selected ":" "; echo ">Aguardando</option>";
                    echo "<option value=1"; print $buffer[$x][status] == 1 ? " selected ":" "; echo ">Finalizado</option>";
                    echo "<option value=2"; print $buffer[$x][status] == 2 ? " selected ":" "; echo ">Cancelado</option>";
                echo "</select>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }else{
            echo "<center><span class=fontebranca12><b>Nenhum registro encontrado!</b></span></center>";
        }
?>
<pre>






















</pre>
