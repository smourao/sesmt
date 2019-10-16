<?php
include "../sessao.php";
include "../config/config.php";
include "../config/connect.php"; //arquivo que contém a conexão com o Banco.


if(!empty($_GET[cliente]) && !empty($_GET[funcionario]) && !empty($_GET[aso]) && !empty($_GET[email])){
    $sql = "SELECT f.cod_cliente, f.cod_filial, f.cod_funcao,f.nome_func, f.num_ctps_func, f.serie_ctps_func, fe.exame_id, fe.descricao, fun.nome_funcao, fun.dsc_funcao FROM
        funcionarios f, funcao_exame fe, funcao fun WHERE
        f.cod_cliente = '".$_GET['cliente']."' AND
        f.cod_func = {$_GET['funcionario']} AND
        f.cod_funcao = fe.cod_exame AND
        fun.cod_funcao = fe.cod_exame";
    $rss = pg_query($sql);
    $funcionario = pg_fetch_all($rss);

    $sql = "SELECT * FROM cliente WHERE cliente_id = ".$_GET['cliente'];
    $r = pg_query($sql);
    $cliente = pg_fetch_array($r);

    $sql = "SELECT e.*, ex.* FROM aso_exame e, exame ex
        WHERE
        ex.cod_exame = e.cod_exame
        AND
        e.cod_aso = $_GET[aso]";
    $rex = pg_query($sql);
    $exa = pg_fetch_all($rex);

    $tipo_exames = "";
    for($x=0;$x<pg_num_rows($rex);$x++){
        $tipo_exames .= $exa[$x][especialidade];
        if($x<pg_num_rows($rex)-1)
            $tipo_exames .= ", ";
        else
            $tipo_exames .= ".";
    }

    $msg_clinica = "
    <!DOCTYPE HTML PUBLIC -//W3C//DTD HTML 4.0 Transitional//EN>
       <HTML>
       <HEAD>
          <TITLE>SESMT</TITLE>
    <META http-equiv=Content-Type content=text/html; charset=iso-8859-1>
    <META content=MSHTML 6.00.2900.3157 name=GENERATOR>
    <style type=text/css>
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
    <div align=center>
    <table width=100% border=0 cellpadding=0 cellspacing=0>
    	<tr>
    		<td align=left><img src=http://www.sesmt-rio.com/erp/img/logo_sesmt.png width=333 height=180 /></td>
    		<td align=left><font color=#006633 face=Verdana, Arial, Helvetica, sans-serif><span class=style18>Serviços Especializados de Segurança e <br>
    		  Monitoramento de Atividades no Trabalho ltda.</span>
    		  </font><br><br>
    		  <p class=style18>
    		  <p class=style18><font color=#006633 face=Verdana, Arial, Helvetica, sans-serif>Segurança do Trabalho e Higiene Ocupacional.</font><br><br><br><br>
    		  <p>
    </td>
    	</tr>
    </table>
    </div>
    <center>

    <table width=85% border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td align=center><b>CONFIRMAÇÃO DE AGENDAMENTO MÉDICO COMPLEMENTAR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nº ".str_pad($count2[0]['id'], 4,"0",STR_PAD_LEFT)."</b></td>
        <tr>
    </table>
    <br><p><br><BR>
    <table width=85% border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td align=justify><b>Empresa Solicitante:</b>  {$cliente['razao_social']}</td>
        <tr>
    </table>
    <br>
    <table width=85% border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td align=justify colspan=2><b>Endereço:</b> {$cliente[endereco]}&nbsp;&nbsp;<b>Nº:</b> {$cliente[num_end]}&nbsp;&nbsp;<b>CEP:</b> {$cliente[cep]}</td>
        <tr>
        <tr>
            <td align=justify colspan=2><b>Cidade:</b> {$cliente[municipio]}&nbsp;&nbsp;<b>Insc. Municipal:</b> {$cliente[insc_municipal]}&nbsp;&nbsp;<b>Insc. Estadual:</b> {$cliente[insc_estadual]}</td>
        <tr>
        <tr>
            <td align=justify><b>CNPJ:</b>  {$cliente['cnpj']}</td>
            <td align=justify><b>Resp. Solicitante:</b> {$cliente['nome_contato_dir']}</td>
        <tr>
    </table>
    <br>
    <table width=85% border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td align=justify><b>Horário:</b> Ordem de Chegada</td>
        <tr>
            <tr>
            <td align=justify><b>Horário Término para atendimento Laboratorial:</b> 11h00min</td>
        <tr>
            <tr>
            <td align=justify><b>Horário Término para atendimento Geral:</b> 15h00min</td>
        <tr>
    </table>


    <br><BR>

    <table width=85% border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td align=justify width=30%><b>Encaminhado:</b> {$funcionario[0]['nome_func']}</td>
        </tr>
    </table>
    <br>
    <table width=85% border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td align=justify width=60%><b>Função:</b> {$funcionario[0]['nome_funcao']}</td>
            <td align=justify width=20%><b>CTPS:</b> {$funcionario[0]['num_ctps_func']}</td>
            <td align=justify width=20%><b>Série:</b> {$funcionario[0]['serie_ctps_func']}</td>
        </tr>
    </table>
    <BR>
    <table width=85% border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td align=justify><b>Tipo dos Exames:</b> $tipo_exames</td>
        <tr>
    </table>
    <BR> <p><br><BR>
    <table width=85% border=0 cellpadding=0 cellspacing=0>
        <tr>
            <td align=justify><b>Segue em anexo a anamnese do paciente pré-preenchida ela deverá
            regressar a SESMT junto com os resultados do exame, caso o resultado não contenha a
            anamnese a SESMT reserva-se no direito de efetuar o pagamento dos serviços prestados.</b></td>
        <tr>
    </table>


    <div align=center>
    <table width=100% border=0 cellpadding=0 cellspacing=0 bordercolor=#000000>
    	<p>
    		<tr>
    		<td width=65% align=center class=fontepreta12 style2>
    		<br /><br /><br /><br /><br /><br />
    		  <span class=style17>Telefone: +55 (21) 3014-4304 &nbsp;&nbsp;Fax: Ramal 7<br />
    		  Nextel: +55 (21) 7844-9394 &nbsp;&nbsp;ID:55*23*31368 </span>
              <p class=style17>
    		  faleprimeirocomagente@sesmt-rio.com / comercial@sesmt-rio.com<br />
              www.sesmt-rio.com / www.shoppingsesmt.com<br />

    	    </td>
    		<td width=35% align=right>
            <img src=http://www.sesmt-rio.com/erp/img/logo_sesmt2.png width=280 height=200 /></td>
    	</tr>
    </table></div>


       </BODY>
    </HTML>

    ";

    echo $msg_clinica;
}

if($_GET[excluir]=="sim"){
	$funcionario = $_GET["funcionario"];
	$setor = $_GET["setor"];
	$cliente = $_GET["cliente"];
	$filial = $_GET["filial"];
	$aso = $_GET["aso"];
	$sql_excluir = "delete from aso_exame where cod_aso = $aso;";
	$sql_excluir = $sql_excluir . "delete from aso where cod_aso = $aso;";
	$result_excluir = pg_query($sql_excluir);
	if ($result_excluir){
		echo "<script>alert('ASO excluído com sucesso!');</script>";
	}
}
?>
<html>
<head>
<title>Lista ASO</title>
<link href="../css_js/css.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../scripts.js">
</script>
<style type="text/css">
<!--
.style2 {font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
</head>
<body bgcolor="#006633" text="#FFFFFF" alink="#FFFFFF" vlink="#FFFFFF">
<form name="frm_lista" method="post" action="lista_aso.php">
<table align="center" width="700" border="2" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF">
  <tr>
    <td colspan="6" bgcolor="#009966" align="center">
		<br>
        <h2 class="style2">Atestado de Saúde Ocupacional (ASO)</h2></td>
  </tr>
  <tr bgcolor="#009966" align="center">
  	<td colspan="6" class="fontebranca12 style2"><br><b>&nbsp; Cliente: &nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;<input type="text" name="aso_pesq" size="25" value="<?PHP echo $_POST[aso_pesq];?>">
		&nbsp;&nbsp;&nbsp; <input type="submit" name="btn_busca" value="Buscar" style="width:100;"> <br>&nbsp;
	</td>
  </tr>
   <tr>
		<th colspan="6" bgcolor="#009966">
		<br>&nbsp;
		<input name="btn_novo" type="submit" id="btn_novo" onClick="MM_goToURL('parent','pesq_cli.php'); return document.MM_returnValue" value="Novo" style="width:100;" onClick="confirmar();" title="Criar novo registro de ASO">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="btn1" type="submit" onClick="MM_goToURL('parent','../tela_principal.php'); return document.MM_returnValue" value="Sair" style="width:100;">
		<br>&nbsp;
		</th>
	</tr>
  </tr>
    <th colspan="3"><br><h3 class="style2">CLIENTE</h3></th>
    <th colspan="3"><br><h3 class="style2">FUNCIONÁRIO</h3></th>
  </tr>
<?php
	if ( (!empty($_POST[aso_pesq]) and $_POST[btn_busca]=="Buscar") )
	{
		echo "<tr>";
		echo "	<th class=\"style1\" colspan=6> Resultado da busca:</th>";
		echo "</tr>";

        echo "<tr>";
        echo "	<th class=linksistema align=center><b><font size=2>Enviar</a></b></th>";
		//echo "	<td class=linksistema width=55 align=center><b><font size=2>Nº ASO</b></td>";
		echo "	<td class=linksistema width=55 align=center><b><font size=2>Editar</b></td>";
		echo "	<td class=linksistema align=center><b><font size=2>Razão Social</b></td>";
		echo "	<td class=linksistema align=center><b><font size=2>Funcionário</b></td>";
		echo "	<td class=linksistema align=center><b><font size=2>Data do ASO</b></td>";
		echo "	<th class=linksistema align=center><b><font size=2>Excluir</a></b></th>";
        echo "</tr>";
		
    if(is_numeric($_POST[aso_pesq])){
        $sql = "SELECT * FROM aso WHERE cod_cliente = '{$_POST[aso_pesq]}' ORDER BY cod_aso";
    }else{
        $sql = "SELECT a.* FROM aso a, cliente c WHERE
        lower(c.razao_social) LIKE '%{$_POST[aso_pesq]}%'
        AND
        c.cliente_id = a.cod_cliente ORDER BY a.cod_aso";
    }
	$result_aso = pg_query($sql);

	while($row = pg_fetch_array($result_aso)){
	    $sql = "SELECT f.*, c.* FROM funcionarios f, cliente c
        WHERE
        f.cod_cliente = c.cliente_id AND
        c.cliente_id = $row[cod_cliente] AND
        f.cod_func = $row[cod_func]";
        $result = pg_query($sql);
        $buffer = pg_fetch_array($result);
		echo "<tr>";
		echo "	<th class=linksistema";
        if($row[enviado]){
            echo " bgcolor=green alt='Enviado por email em: ".date("d/m/Y à\s H:i:s", strtotime($row[data_envio])).".' title='Enviado por email em: ".date("d/m/Y à\s H:i:s", strtotime($row[data_envio])).".'";
        }else{
            echo " bgcolor=red alt='Clique aqui para enviar por email.' title='Clique aqui para enviar por email.'";
        }
        echo "><a href=\"#\" onclick=\"var mmm = prompt('Enviar este ASO para:','{$buffer[email]}');if(mmm){location.href='aso_final_mail.php?funcionario=$row[cod_func]&aso=$row[cod_aso]&cliente=$row[cod_cliente]&setor=$row[cod_setor]&email='+mmm+'';}\">Email</a> </th>";
		//echo "	<td class=linksistema align=center><a href=\"aso_final.php?funcionario=$row[cod_func]&aso=$row[cod_aso]&cliente=$row[cod_cliente]&setor=$row[cod_setor]\">".str_pad($row[cod_aso], 4, "0", 0)."</a></td>";
        if($row[aso_resultado]!="")
            $color = "#006633";
        else
            $color = "#C9AF00";
            
        echo "	<th class=linksistema bgcolor='$color'><a href=\"editar_aso.php?funcionario=$buffer[cod_func]&aso=$row[cod_aso]&cliente=$buffer[cod_cliente]&setor=$buffer[cod_setor]\" >Editar</a> </th>";
        echo "	<td class=linksistema bgcolor='$color'><a href=\"aso_final.php?funcionario=$buffer[cod_func]&aso=$row[cod_aso]&cliente=$buffer[cod_cliente]&setor=$buffer[cod_setor]\">&nbsp;&nbsp;&nbsp;" . ucwords(strtolower($buffer[razao_social])) . "</a> </td>";
		echo "	<td class=linksistema bgcolor='$color'><a href=\"aso_final.php?funcionario=$buffer[cod_func]&aso=$row[cod_aso]&cliente=$buffer[cod_cliente]&setor=$buffer[cod_setor]\">&nbsp;&nbsp;&nbsp;" . ucwords(strtolower($buffer[nome_func])) . "</a> </td>";
		echo "	<td class=linksistema bgcolor='$color' align=center><a href=\"aso_final.php?funcionario=$buffer[cod_func]&aso=$row[cod_aso]&cliente=$buffer[cod_cliente]&setor=$buffer[cod_setor]\">".date("d/m/Y", strtotime($row[aso_data]))."</a> </td>";
		echo "	<th class=linksistema bgcolor='$color'><a href=\"lista_aso.php?aso=$row[cod_aso]&excluir=sim\" >Excluir</a> </th>";
		echo "</tr>";
	}
}
pg_close($connect);
?>
</table>
</form>
</body>
</html>
