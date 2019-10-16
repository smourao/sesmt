<?php
define('_MPDF_PATH', '../../common/MPDF45/');
define('_IMG_PATH', '../../images/');
/*****************************************************************************************************************/
// -> VARS
/*****************************************************************************************************************/
$cod_cliente = $_GET[cod_cliente];
$setor     = $_GET[setor];
$funcionario = $_GET[funcionario];
$aso     = $_GET[aso];
$code        = "";
$header_h    = 140;//header height;
$footer_h    = 170;//footer height;
$meses       = array('', 'Janeiro',  'Fevereiro', 'Mar�o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$m           = array(" ", "Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez");

$sql = "SELECT ce.*, e.*, a.* FROM clinica_exame ce, exame e, site_aso_agendamento a WHERE ce.cod_clinica=a.cod_clinica AND ce.cod_exame = e.cod_exame and e.cod_exame = a.exames and a.cod_aso = ".$aso;
$r = pg_query($sql);
$data = pg_fetch_all($r);

for($x=0;$x<pg_num_rows($r);$x++){
  $tipo_exames .= "{$data[$x]['especialidade']}";
  if($x < count($data)-1){
     $tipo_exames .= ", ";
  }
}

$sql = "SELECT f.*, fe.cod_exa as exame_id, exa.especialidade as descricao, fun.nome_funcao, fun.dsc_funcao
    FROM funcionarios f, fun_exa_cli fe, funcao fun, exame exa
    WHERE f.cod_cliente = ".$cod_cliente." AND f.cod_func = ".$funcionario." AND f.cod_funcao = fe.cod_fun
    AND fun.cod_funcao = fe.cod_fun AND fe.cod_exa = exa.cod_exame AND f.cod_setor = ".$setor;
$rss = pg_query($sql);
$funcionario = pg_fetch_all($rss);

$sql = "SELECT c.*, a.* FROM clinicas c, aso a WHERE c.cod_clinica = a.cod_clinica AND a.cod_aso = ".$aso;
$result = pg_query($sql);
$clinica = pg_fetch_array($result);

$sql = "SELECT * FROM cliente WHERE cliente_id = ".$cod_cliente;
$r = pg_query($sql);
$cliente = pg_fetch_array($r);

$sql = "SELECT * FROM exame WHERE cod_exame = 10 or cod_exame = 11";
$rr = pg_query($sql);
$ee = pg_fetch_all($rr);

    /*************************************************************************************************************/
    // -> HEADER
    /*************************************************************************************************************/
    if($_GET[sem_timbre]){
        $cabecalho .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
        $cabecalho .= "<td align=left height=$header_h>&nbsp; </td>";
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }else{
        $cabecalho  = "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$header_h>";
        $cabecalho .= "<tr>";
         $cabecalho .= '<td align="left" height=$header_h>
            <p><strong>
            <font size="7" face="Verdana, Arial, Helvetica, sans-serif">SESMT<sup><font size=3>&reg;</font></sup></font>&nbsp;&nbsp;
      <font size="1" face="Verdana, Arial, Helvetica, sans-serif">SERVI�OS ESPECIALIZADOS DE SEGURAN�A<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
      CNPJ&nbsp; 04.722.248/0001-17 &nbsp;&nbsp;INSC. MUN.&nbsp; 311.213-6</font></strong>
            </td>';
        $cabecalho .= ' <td width=40% align="right" height=$header_h>
            <font face="Verdana, Arial, Helvetica, sans-serif" size="4">
            <b>Encaminhamento</b>
            </td>';
        
        $cabecalho .= "</tr>";
        $cabecalho .= "</table>";
    }
    /************************************************************************************************************/
    // -> FOOTER
    /************************************************************************************************************/
    if($_GET[sem_timbre]){
        $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
    $rodape .= "<td align=left height=$footer_h valign=bottom class='medText'>Telefone: +55 (21) 3014 4304      Fax: Ramal 7<br>Nextel: +55 (21) 7844 6095 / Id 55*23*31641<br>medicotrab@sesmt-rio.com<br>www.sesmt-rio.com / www.shoppingsesmt.com</td>";
        $rodape .= "<td align=left height=$footer_h>&nbsp; </td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    }else{
    
    $rodape .= "<table width=100% border=0 cellspacing=0 cellpadding=0 height=$footer_h>";
        $rodape .= "<tr>";
        $rodape .= "<td align=left height=$header_h><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Telefone: +55 (21) 3014 4304   Fax: Ramal 7</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >Nextel: +55 (21) 9700 31385 - Id 55*23*31641</font><br><font face=\"Verdana, Arial, Helvetica, sans-serif\"size=3 >medicotrab@sesmt-rio.com</font> / <font face=\"Verdana, Arial, Helvetica, sans-serif\"size=4 >www.sesmt-rio.com</font></td><td width=130 height=$header_h><font face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
     Pensando em<br>renovar seus<br>programas?<br>Fale primeiro<br>com a gente!</b>
     </td>";
        $rodape .= "</tr>";
        $rodape .= "</table>";
    
    }
    $msg_site .= "<html>";
    $msg_site .= "<head>";
    $msg_site .= "</head>";
    $msg_site .= "<body>";
    
/****************************************************************************************************************/
// -> PAGE [1]
/****************************************************************************************************************/
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=center><b>ENCAMINHAMENTO M�DICO COMPLEMENTAR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; N� ".$aso."</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table><p><br><p>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify><b>Cl�nica:</b> ".$clinica['razao_social_clinica']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=60%><b>Endere�o:</b> ".$clinica['endereco_clinica']."</td>";
  $msg_site .= "<td align=justify><b>N�</b> {$clinica['num_end']}</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=40%><b>CEP:</b>  {$clinica['cep_clinica']}</td>";
  $msg_site .= "<td align=justify ><b>Bairro:</b> ".$clinica['bairro_clinica']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify><b>Ponto de Refer�ncia:</b> ".$clinica['referencia_clinica']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table><br>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Assunto:</b> Atendimento para ASO ".$clinica['tipo_exame']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Encaminhado:</b> ".$funcionario[0]['nome_func']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=60%><b>Fun��o:</b> ".$funcionario[0]['nome_funcao']."</td>";
  $msg_site .= "<td align=justify width=20%><b>CTPS:</b> {$funcionario[0]['num_ctps_func']}</td>";
  $msg_site .= "<td align=justify width=20%><b>S�rie:</b> {$funcionario[0]['serie_ctps_func']}</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Exames a serem realizados:</b> ".$clinica['tipo_exame']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table><br>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>CNPJ:</b> {$cliente['cnpj']}</td>";
    $msg_site .= "<td align=justify width=70%><b>Empresa Solicitante:</b> ".$cliente['razao_social']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table><br>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Contato:</b> {$cliente['telefone']}</td>";
  $msg_site .= "<td align=justify width=70%><b>Resp. Solicitante</b> ".$cliente['nome_contato_dir']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table><br>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Tel. Solicitante:</b> {$cliente['tel_contato_dir']} {$cliente['nextel_contato_dir']}</td>";
  $msg_site .= "<td align=justify width=70%><b>Email. Solicitante</b> {$cliente['email_contato_dir']}</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table><br>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=100%><b>Resp. Solicitante</b> ".$cliente['endereco'].", ".$cliente['bairro'].", ".$cliente['municipio'].", ".$cliente['estado']." - CEP: {$cliente['cep']}</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table><br>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Hor�rio:</b> Ordem de Chegada de Segunda a Sexta</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Hor�rio T�rmino para atendimento Laboratorial:</b> 11h00min</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Hor�rio T�rmino para atendimento Geral:</b> 15h00min</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";

  for($y=0;$y<pg_num_rows($rr);$y++){
    if($ee[$y][cod_exame] == '10' ){
    $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%>EAS - Fazer uma higiene �ntima rigorosa em sua casa, usando sabonete e �gua, enxaguar bem com �gua abundante e secar bem com uma toalha limpa; Coletar a primeira urina da manh� ou 2 horas ap�s a �ltima mic��o; Desprezar o primeiro jato da urina no vaso sanit�rio e coletar no copo descart�vel o jato do meio, mais ou menos (at� a metade do copo) desprezando o restante da mic��o no vaso sanit�rio; Imediatamente, passar a urina do copo para o tubo, at� preencher totalmente, fechar e muito bem e identificar com seu nome completo.</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";
    }
    
    if($ee[$y][cod_exame] == 11 ){
    $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%>EPF - Colher as fezes diretamente no frasco ou sobre um papel ou pl�stico e transferir para o pote, este procedimento de prefer�ncia no per�odo da manh� e depois de coletar (pequena por��o) levar para o local do exame, caso n�o seja poss�vel, acondicionar o pote em um saco pl�stico e manter refrigerado.</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";
    }
  }
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
  if($clinica['segunda']=='segunda' || $clinica['terca']=='terca' || $clinica['quarta']=='quarta' || $clinica['quinta']=='quinta' || $clinica['sexta']=='sexta'){
    $msg_site .= "<tr>";
    $msg_site .="<td align=justify width=30%><b>OBS: ".$clinica['motivo']."</b></td>";
    $msg_site .= "</tr>";
  }
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=30%><b>OBS: O n�o comparecimento do candidato e/ou a n�o realiza��o de algum procedimento ora agendado e n�o cumprido pelo solicitante n�o anular� a cobran�a do mesmo, ficando o cr�dito para esse mesmo candidato se submeter em outra data.</b></td>";
  $msg_site .= "</tr>";
  $msg_site .= "</table>";
  
  $msg_site .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
  $msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=center colspan=5><b>SESMT - Servi�os Especializados de Seguran�a de Monitoramento de Atividades no Trabalho LTDA</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=4></td>";
    $msg_site .= "<td align=justify><b>Ficha de Anamnese:</b> $cod_aso</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Cl�nica:</b> ".$clinica['razao_social_clinica']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Empresa:</b> ".$cliente['razao_social']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Nome:</b> ".$funcionario[0]['nome_func']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2 width=40%><b>Fun��o Atual:</b> ".$funcionario[0]['nome_funcao']."</td>";
  $msg_site .= "<td align=justify colspan=2 width=40%><b>Fun��o Anterior:</b> </td>";
  $msg_site .= "<td align=justify width=20%><b>RG:</b> {$funcionario[0]['rg']}</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=20%><b>Sexo:</b> {$funcionario[0]['sexo_func']}</td>";
  $msg_site .= "<td align=justify width=20%><b>Est. Civil:</b> </td>";
  $msg_site .= "<td align=justify width=20%><b>Cor:</b> </td>";
  $msg_site .= "<td align=justify width=20%><b>Nasc.:</b> </td>";
  $msg_site .= "<td align=justify width=20%><b>Natural:</b> </td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Endere�o:</b> ".$funcionario[0]['endereco_func']."</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Antecedentes Familiares:&nbsp;&nbsp;&nbsp;Parentesco</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=50%><b>&bull; Tuberculose/Diabete/C�ncer ________________________________</b></td>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Asma/Alergias/Urtic�ria _____________________________________</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=50%><b>&bull; Doen�a do Cora��o/Press�o Alta ___________________________</b></td>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Doen�a Mental/Nervosa _____________________________________</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>&bull; Outras ____________________________________________________________________________________________________________________________</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Antecedentes Pessoais</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doen�a do Cora��o/Press�o Alta ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Enxerga Bem ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Varizes/Varicocele/H�rnias ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Dor no Peito/Palpita��o ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Ouve Bem/Otite/Zumbido ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Hemorr�idas/Diarr�ia Frequente ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Bronquite/Asma/Rinite ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; J� esteve internado ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Sofreu doen�a n�o mencionada ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doen�as Coluna/Dor nas Costas ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Encontra-se gr�vida ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Pode executar tarefas pesadas ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doen�as Renais(Rins) ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Doen�a Mental/Nervosa ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Tem alguma defici�ncia ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doen�a do F�gado/Diabetes ( )</b></td>";
  $msg_site .= "<td align=justify width=34%><b>&bull; Dor de Cabe�a/Tontura/Convuls�es ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Sofreu alguma cirurgia ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; �lcera/Gastrite ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Alergia/Doen�a de Pele ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Tabagismo(Fumo)/Etilismo(Bebe) ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Resfriado/Tosse Cr�nica/Sinusite ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Reumatismo/Dor nas Juntas ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b> </b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=3><b>Obs: _________________________________________________________________________________________________________________________________</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";

  $msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Antecedentes Ocupacionais</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Suas condi��es de sa�de exige trabalho especial ( )</b></td>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Recebeu indeniza��o por acidente de trabalho ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Perdeu dias de trabalho por motivos de sa�de ( )</b></td>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Esteve doente devido seu trabalho ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Esteve afastado pelo I.N.P.S. ( )</b></td>";
  $msg_site .= "<td align=justify width=50%><b> </b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Anota��es(tratamentos-rem�dios): _____________________________________________________________________________________________</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Obs: ________________________________________________________________________________________________________________________________</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=4><b>Exame F�sico</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%><b>Cabe�a</b></td>";
  $msg_site .= "<td align=justify width=25%><b>Pesco�o</b></td>";
  $msg_site .= "<td align=justify width=25%><b>T�rax</b></td>";
  $msg_site .= "<td align=justify width=25%><b>Abdomem</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>Boca/Dente: ______________</td>";
  $msg_site .= "<td align=justify width=25%>Faringe: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Cora��o: _______________</td>";
  $msg_site .= "<td align=justify width=25%>H�rnias: _______________</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>Nariz: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Am�gdalas: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Pulm�es: _______________</td>";
  $msg_site .= "<td align=justify width=25%>An�is: _______________</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>L�ngua: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Laringe: _______________</td>";
  $msg_site .= "<td align=justify width=25%><b></b></td>";
  $msg_site .= "<td align=justify width=25%><b></b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>Ouvidos: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Tire�ide: _______________</td>";
  $msg_site .= "<td align=justify width=25%><b></b></td>";
  $msg_site .= "<td align=justify width=25%><b></b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%><b>Genital</b></td>";
  $msg_site .= "<td align=justify width=25%><b>Membros</b></td>";
  $msg_site .= "<td align=justify width=25%><b></b></td>";
  $msg_site .= "<td align=justify width=25%><b></b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>Varicocele: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Isquemia: _______________</td>";
  $msg_site .= "<td align=justify width=25%>P� Plano: _______________</td>";
  $msg_site .= "<td align=justify width=25%><b>Press�o Arterial: ___________</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>Hidroxila: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Edemas: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Pele/Mucosa: _______________</td>";
  $msg_site .= "<td align=justify width=25%><b>Pulso: _______________</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>D.U.M.: _______________</td>";
  $msg_site .= "<td align=justify width=25%>M� Forma��o: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Coluna Vertebral: _______________</td>";
  $msg_site .= "<td align=justify width=25%><b>Altura: _______________</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>Corrimentos: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Calos: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Varizes: _______________</td>";
  $msg_site .= "<td align=justify width=25%><b>Peso: _______________</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=4><b>Obs: _______________________________________________________________________________________________________________________________</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify ><b>Exames Complementares</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=15%><b>Exames</b></td>";
  $msg_site .= "<td align=justify width=8%><b>Data</b> </td>";
  $msg_site .= "<td align=justify width=10%><b>Resultado</b></td>";
  $msg_site .= "<td align=justify width=15%><b>Exames</b></td>";
  $msg_site .= "<td align=justify width=8%><b>Data</b> </td>";
  $msg_site .= "<td align=justify width=10%><b>Resultado</b></td>";
  $msg_site .= "<td align=justify width=15%><b>Exames</b></td>";
  $msg_site .= "<td align=justify width=8%><b>Data</b> </td>";
  $msg_site .= "<td align=justify width=10%><b>Resultado</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=15%><b>Eritrograma</b></td>";
  $msg_site .= "<td align=justify width=8%></td>";
  $msg_site .= "<td align=justify width=10%></td>";
  $msg_site .= "<td align=justify width=15%><b>Urina - EAS</b></td>";
  $msg_site .= "<td align=justify width=8%></td>";
  $msg_site .= "<td align=justify width=10%></td>";
  $msg_site .= "<td align=justify width=15%><b>Oftalmologico</b></td>";
  $msg_site .= "<td align=justify width=8%></td>";
  $msg_site .= "<td align=justify width=10%></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=15%><b>Leucograma</b></td>";
  $msg_site .= "<td align=justify width=8%></td>";
  $msg_site .= "<td align=justify width=10%></td>";
  $msg_site .= "<td align=justify width=15%><b>Fezes</b></td>";
  $msg_site .= "<td align=justify width=8%></td>";
  $msg_site .= "<td align=justify width=10%></td>";
  $msg_site .= "<td align=justify width=15%><b>Grupo Sanguinio</b></td>";
  $msg_site .= "<td align=justify width=8%></td>";
  $msg_site .= "<td align=justify width=10%></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=15%><b>Plaquetas</b></td>";
  $msg_site .= "<td align=justify width=8%></td>";
  $msg_site .= "<td align=justify width=10%></td>";
  $msg_site .= "<td align=justify width=15%><b>RX Torax</b></td>";
  $msg_site .= "<td align=justify width=8%></td>";
  $msg_site .= "<td align=justify width=10%></td>";
  $msg_site .= "<td align=justify width=15%><b>Fator RH</b></td>";
  $msg_site .= "<td align=justify width=8%></td>";
  $msg_site .= "<td align=justify width=10%></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=15%><b>VDRL</b></td>";
  $msg_site .= "<td align=justify width=8%></td>";
  $msg_site .= "<td align=justify width=10%></td>";
  $msg_site .= "<td align=justify width=15%><b>Audiometria</b></td>";
  $msg_site .= "<td align=justify width=8%></td>";
  $msg_site .= "<td align=justify width=10%></td>";
  $msg_site .= "<td align=justify width=15%></td>";
  $msg_site .= "<td align=justify width=8%></td>";
  $msg_site .= "<td align=justify width=10%></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";
  
  $msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify>Assino como prova de ter declarado a verdade: ________________________________, ____/____/________</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";
  
  $msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=center width=50%>_____________________________________________________________</td>";
  $msg_site .= "<td align=center width=50%>_____________________________________________________________</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=center width=50%>Assinatura do Candidato</td>";
  $msg_site .= "<td align=center width=50%>Assinatura do Examinador</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
  
    $msg_site .= "</body>";
    $msg_site .= "</html>";

    $headers = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\n";
    $headers .= "From: SESMT - Seguran�a do Trabalho e Higiene Ocupacional. <medicotrab@sesmt-rio.com> \n";

      $mail_list = explode(";", $_GET['email']);
      $ok = "";
      $er = "";

      for($x=0;$x<count($mail_list);$x++){
        if($mail_list[$x] != ""){
          if($x ==0){          
           if(mail($mail_list[$x].";suporte@sesmt-rio.com", "SESMT - Altera��o de Encaminhamento � Cl�nica", $msg_site, $headers)){
              $ok .= ", ".$mail_list[$x];
            $m = 1;
           }else{
              $er .= ", ".$mail_list[$x];
           }         
          }else{          
            if(mail($mail_list[$x], "SESMT - Altera��o de Encaminhamento � Cl�nica", $msg_site, $headers)){
              $ok .= ", ".$mail_list[$x];
            $m = 1;
           }else{
              $er .= ", ".$mail_list[$x];
           }
          }
        }
      }
    
      echo "<script>('E-Mails enviado para".$ok."');</script>";
      if($er != ""){
          echo "<script>('Erro ao enviar E-mail para".$er."');</script>";
      }
        
      echo "<script>location.href='?dir=enc_med_clinicas&p=lista&pq=$aso&m=$m';</script>";
?>
