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
$meses       = array('', 'Janeiro',  'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
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
      <font size="1" face="Verdana, Arial, Helvetica, sans-serif">SERVIÇOS ESPECIALIZADOS DE SEGURANÇA<br> E MONITORAMENTO DE ATIVIDADES NO TRABALHO<br>
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
    $msg_site .= "<td align=center><b>ENCAMINHAMENTO MÉDICO COMPLEMENTAR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nº ".$aso."</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table><p><br><p>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify><b>Clínica:</b> ".$clinica['razao_social_clinica']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=60%><b>Endereço:</b> ".$clinica['endereco_clinica']."</td>";
  $msg_site .= "<td align=justify><b>Nº</b> {$clinica['num_end']}</td>";
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
    $msg_site .= "<td align=justify><b>Ponto de Referência:</b> ".$clinica['referencia_clinica']."</td>";
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
    $msg_site .= "<td align=justify width=60%><b>Função:</b> ".$funcionario[0]['nome_funcao']."</td>";
  $msg_site .= "<td align=justify width=20%><b>CTPS:</b> {$funcionario[0]['num_ctps_func']}</td>";
  $msg_site .= "<td align=justify width=20%><b>Série:</b> {$funcionario[0]['serie_ctps_func']}</td>";
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
    $msg_site .= "<td align=justify width=30%><b>Horário:</b> Ordem de Chegada de Segunda a Sexta</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Horário Término para atendimento Laboratorial:</b> 11h00min</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%><b>Horário Término para atendimento Geral:</b> 15h00min</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";

  for($y=0;$y<pg_num_rows($rr);$y++){
    if($ee[$y][cod_exame] == '10' ){
    $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%>EAS - Fazer uma higiene íntima rigorosa em sua casa, usando sabonete e água, enxaguar bem com água abundante e secar bem com uma toalha limpa; Coletar a primeira urina da manhã ou 2 horas após a última micção; Desprezar o primeiro jato da urina no vaso sanitário e coletar no copo descartável o jato do meio, mais ou menos (até a metade do copo) desprezando o restante da micção no vaso sanitário; Imediatamente, passar a urina do copo para o tubo, até preencher totalmente, fechar e muito bem e identificar com seu nome completo.</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table><br>";
    }
    
    if($ee[$y][cod_exame] == 11 ){
    $msg_site .= "<table width=100% cellspacing=2 cellpadding=2 border=0>";
    $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=30%>EPF - Colher as fezes diretamente no frasco ou sobre um papel ou plástico e transferir para o pote, este procedimento de preferência no período da manhã e depois de coletar (pequena porção) levar para o local do exame, caso não seja possível, acondicionar o pote em um saco plástico e manter refrigerado.</td>";
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
  $msg_site .= "<td align=justify width=30%><b>OBS: O não comparecimento do candidato e/ou a não realização de algum procedimento ora agendado e não cumprido pelo solicitante não anulará a cobrança do mesmo, ficando o crédito para esse mesmo candidato se submeter em outra data.</b></td>";
  $msg_site .= "</tr>";
  $msg_site .= "</table>";
  
  $msg_site .= "<div class='pagebreak'></div>";
/****************************************************************************************************************/
// -> PAGE [2]
/****************************************************************************************************************/
  $msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=1>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=center colspan=5><b>SESMT - Serviços Especializados de Segurança de Monitoramento de Atividades no Trabalho LTDA</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=4></td>";
    $msg_site .= "<td align=justify><b>Ficha de Anamnese:</b> $cod_aso</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Clínica:</b> ".$clinica['razao_social_clinica']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Empresa:</b> ".$cliente['razao_social']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=5><b>Nome:</b> ".$funcionario[0]['nome_func']."</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2 width=40%><b>Função Atual:</b> ".$funcionario[0]['nome_funcao']."</td>";
  $msg_site .= "<td align=justify colspan=2 width=40%><b>Função Anterior:</b> </td>";
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
    $msg_site .= "<td align=justify colspan=5><b>Endereço:</b> ".$funcionario[0]['endereco_func']."</td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Antecedentes Familiares:&nbsp;&nbsp;&nbsp;Parentesco</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=50%><b>&bull; Tuberculose/Diabete/Câncer ________________________________</b></td>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Asma/Alergias/Urticária _____________________________________</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=50%><b>&bull; Doença do Coração/Pressão Alta ___________________________</b></td>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Doença Mental/Nervosa _____________________________________</b></td>";
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
    $msg_site .= "<td align=justify width=33%><b>&bull; Doença do Coração/Pressão Alta ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Enxerga Bem ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Varizes/Varicocele/Hérnias ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Dor no Peito/Palpitação ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Ouve Bem/Otite/Zumbido ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Hemorróidas/Diarréia Frequente ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Bronquite/Asma/Rinite ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Já esteve internado ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Sofreu doença não mencionada ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doenças Coluna/Dor nas Costas ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Encontra-se grávida ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Pode executar tarefas pesadas ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doenças Renais(Rins) ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Doença Mental/Nervosa ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Tem alguma deficiência ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Doença do Fígado/Diabetes ( )</b></td>";
  $msg_site .= "<td align=justify width=34%><b>&bull; Dor de Cabeça/Tontura/Convulsões ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Sofreu alguma cirurgia ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Úlcera/Gastrite ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Alergia/Doença de Pele ( )</b></td>";
  $msg_site .= "<td align=justify width=33%><b>&bull; Tabagismo(Fumo)/Etilismo(Bebe) ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify width=33%><b>&bull; Resfriado/Tosse Crônica/Sinusite ( )</b></td>";
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
  $msg_site .= "<td align=justify width=50%><b>&bull; Suas condições de saúde exige trabalho especial ( )</b></td>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Recebeu indenização por acidente de trabalho ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Perdeu dias de trabalho por motivos de saúde ( )</b></td>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Esteve doente devido seu trabalho ( )</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=50%><b>&bull; Esteve afastado pelo I.N.P.S. ( )</b></td>";
  $msg_site .= "<td align=justify width=50%><b> </b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Anotações(tratamentos-remédios): _____________________________________________________________________________________________</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=2><b>Obs: ________________________________________________________________________________________________________________________________</b></td>";
    $msg_site .= "</tr>";
    $msg_site .= "</table>";
  
  $msg_site .= "<table width=100% cellspacing=0 cellpadding=0 border=0>";
  $msg_site .= "<tr>";
    $msg_site .= "<td align=justify colspan=4><b>Exame Físico</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%><b>Cabeça</b></td>";
  $msg_site .= "<td align=justify width=25%><b>Pescoço</b></td>";
  $msg_site .= "<td align=justify width=25%><b>Tórax</b></td>";
  $msg_site .= "<td align=justify width=25%><b>Abdomem</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>Boca/Dente: ______________</td>";
  $msg_site .= "<td align=justify width=25%>Faringe: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Coração: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Hérnias: _______________</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>Nariz: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Amígdalas: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Pulmões: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Anéis: _______________</td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>Língua: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Laringe: _______________</td>";
  $msg_site .= "<td align=justify width=25%><b></b></td>";
  $msg_site .= "<td align=justify width=25%><b></b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>Ouvidos: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Tireóide: _______________</td>";
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
  $msg_site .= "<td align=justify width=25%>Pé Plano: _______________</td>";
  $msg_site .= "<td align=justify width=25%><b>Pressão Arterial: ___________</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>Hidroxila: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Edemas: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Pele/Mucosa: _______________</td>";
  $msg_site .= "<td align=justify width=25%><b>Pulso: _______________</b></td>";
    $msg_site .= "</tr>";
  $msg_site .= "<tr>";
  $msg_site .= "<td align=justify width=25%>D.U.M.: _______________</td>";
  $msg_site .= "<td align=justify width=25%>Má Formação: _______________</td>";
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
    $headers .= "From: SESMT - Segurança do Trabalho e Higiene Ocupacional. <medicotrab@sesmt-rio.com> \n";

      $mail_list = explode(";", $_GET['email']);
      $ok = "";
      $er = "";

      for($x=0;$x<count($mail_list);$x++){
        if($mail_list[$x] != ""){
          if($x ==0){          
           if(mail($mail_list[$x].";suporte@sesmt-rio.com", "SESMT - Alteração de Encaminhamento à Clínica", $msg_site, $headers)){
              $ok .= ", ".$mail_list[$x];
            $m = 1;
           }else{
              $er .= ", ".$mail_list[$x];
           }         
          }else{          
            if(mail($mail_list[$x], "SESMT - Alteração de Encaminhamento à Clínica", $msg_site, $headers)){
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
