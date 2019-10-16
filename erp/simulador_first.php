<?PHP
header("Content-Type: text/html; charset=ISO-8859-1",true);
include ("config/connect.php");

$cod_cliente = $_GET['id'];
$contato = addslashes($_GET['contato']);
$apreciado = $_GET['apreciado'];
$reacao = $_GET['reacao'];
$prestadora = addslashes($_GET['prestadora']);
$data_programa = $_GET['data_programa'];
$visita = $_GET['visita'];
$dia_visita = explode("/", $_GET['dia_visita']);
$hora_visita = explode(":", $_GET['horario_visita']);
$pessoa_contato = addslashes($_GET['pessoa_contato']);
$telefone = $_GET['telefone'];
$referencia = addslashes($_GET['referencia']);
$brindes = $_GET['brindes'];

$sql = "SELECT * FROM cliente_comercial WHERE cliente_id = '{$cod_cliente}'";
$result = pg_query($sql);
$buffer = pg_fetch_array($result);

if(!$_GET['editar']){
$sql = "SELECT * FROM erp_relatorio_simulador WHERE simulador_id = '{$cod_cliente}'";
$r = pg_query($sql);

if(pg_num_rows($r)>0){
   //update
   $sql = "UPDATE erp_relatorio_simulador SET
   razao_social='{$buffer[razao_social]}',
   contato='{$contato}',
   apreciado='{$apreciado}',
   aceitacao='{$reacao}',
   aceitou='{$visita}',
   dia_visita='{$dia_visita[0]}',
   mes_visita='{$dia_visita[1]}',
   ano_visita='{$dia_visita[2]}',
   hora_visita='{$hora_visita[0]}',
   min_visita='{$dia_visita[1]}',
   contato_visita='{$pessoa_contato}',
   telefone_visita='{$telefone}',
   referencia_visita='{$referencia}',
   brindes_visita='{$brindes}',
   data_atualizacao = '".date("Y-m-d")."',
   prestadora = '{$prestadora}',
   vencimento = '{$data_programa}'
   WHERE simulador_id = '{$cod_cliente}'
   ";
   $act = pg_query($sql);
}else{
   //insert
   $sql = "INSERT INTO erp_relatorio_simulador
   (razao_social, simulador_id, contato, apreciado, aceitacao, aceitou, dia_visita, mes_visita,
   ano_visita, hora_visita, min_visita, contato_visita, telefone_visita, referencia_visita,
   brindes_visita, data_criacao, data_atualizacao, prestadora, vencimento)
   VALUES
   ('{$buffer[razao_social]}', '{$cod_cliente}', '{$contato}', '{$apreciado}', '{$reacao}',
   '{$visita}','{$dia_visita[0]}','{$dia_visita[1]}','{$dia_visita[2]}','{$hora_visita[0]}',
   '{$hora_visita[1]}','{$pessoa_contato}','{$telefone}','{$referencia}','{$brindes}',
   '".date("Y-m-d")."', '".date("Y-m-d")."', '{$prestadora}', '{$data_programa}')
   ";
   $act = pg_query($sql);
}

if($act){
   echo "1";
}else{
   echo "0";
}
}else{
$sql = "SELECT * FROM erp_relatorio_simulador WHERE simulador_id = '{$cod_cliente}'";
$r = pg_query($sql);
$data = pg_fetch_array($r);

$venc = explode("/", $data[vencimento]);
$bri = explode("|", $data[brindes_visita]);

$msg = "
    Em contato com o Sr.(ª)
   <input type=text size=20 id=contato_direto name=contato_direto value='{$data[contato]}'>
   foi nos relatado ter
   <select name=apreciado id=apreciado>
   <option value='1' "; if($data[apreciado]){$msg.= " selected ";} $msg.= " >apreciado</option>
   <option value='0' "; if(!$data[apreciado]){$msg.= " selected ";} $msg.= " >não apreciado</option>
   </select>
    nossos preços que a empresa dele foi enviado.<br>
    <select name=reacao id=reacao onchange='reacao(this);'>
    <option value='0' "; if(!$data[aceitacao]){$msg.= " selected ";} $msg.= " >Selecione</option>
    <option value='1' "; if($data[aceitacao] == "1"){$msg.= " selected ";} $msg.= " >Contudo alegou não estar no período de renovação.</option>
    <option value='2' "; if($data[aceitacao] == "2"){$msg.= " selected ";} $msg.= " >Aceitou uma visita para melhor esplanação.</option>
    <option value='3' "; if($data[aceitacao] == "3"){$msg.= " selected ";} $msg.= " >Aceitou uma visita por nunca ter realizado os programas.</option>
    <option value='4' "; if($data[aceitacao] == "4"){$msg.= " selected ";} $msg.= " >Aceitou uma visita por faltar informações por parte de quem os atende.</option>
    </select>
    <br>

    <div id=razao_social style='display: block;'>
    Razão Social de empresa prestadora dos serviços:
    <input type=text name=empresa id=empresa size=23 value='{$data[prestadora]}'><br>
    Data da última realização dos serviços:
    <input type=text size=2 name=dia_u id=dia_u value='{$venc[0]}' maxlength=2 onkeyup=\"if(this.value.length>=2){document.getElementById('mes_u').focus();}\">/<input type=text size=2 maxlength=2 name=mes_u id=mes_u  value='{$venc[1]}' onkeyup=\"if(this.value.length>=2){document.getElementById('ano_u').focus();}\">/<input type=text size=4 name=ano_u id=ano_u  value='{$venc[2]}' maxlength=4>
    </div>

    <div id=aceitouvisita  style='display: block;'>
    Aceitou visita?
    <input type=radio name=visita id=visita1 value=1 onclick='visita(this.value);'  "; if($data[aceitou] == "1"){$msg.= " checked ";} $msg.= " > Sim
    <input type=radio name=visita id=visita0 value=0 onclick='visita(this.value);'  "; if($data[aceitou] == "0"){$msg.= " checked ";} $msg.= " > Não
    </div>

    <div id=visitasim  style='display: block;'>
    <table width=100%>
    <tr>
    <td class=textorelatorio width=150>Dia da visita:</td>
    <td class=textorelatorio>
    <input type=text size=2 name=dia id=dia maxlength=2 value='{$data[dia_visita]}' onkeyup=\"if(this.value.length>=2){document.getElementById('mes').focus();}\">/<input type=text size=2 name=mes id=mes value='{$data[mes_visita]}' maxlength=2  onkeyup=\"if(this.value.length>=2){document.getElementById('ano').focus();}\">/<input type=text size=4 name=ano id=ano maxlength=4 value='{$data[ano_visita]}' onkeyup=\"if(this.value.length>=4){document.getElementById('hora').focus();}\"></td>
    </tr><tr>
    <td class=textorelatorio>Horário:</td>
    <td class=textorelatorio>
    <input type=text size=2 name=hora id=hora maxlength=2 value='{$data[hora_visita]}' onkeyup=\"if(this.value.length>=2){document.getElementById('min').focus();}\">:<input type=text size=2 name=min id=min maxlength=2 value='{$data[min_visita]}' onkeyup=\"if(this.value.length>=2){document.getElementById('pessoa').focus();}\"></td>
    </tr><tr>
    <td class=textorelatorio>Pessoa de contato:</td><td class=textorelatorio><input type=text name=pessoa id=pessoa value='{$data[contato_visita]}'></td>
    </tr><tr>
    <td class=textorelatorio>Telefone:</td><td class=textorelatorio><input type=text name=telefone id=telefone onkeypress=\"fone(this);\" value='{$data[telefone_visita]}'></td>
    </tr><tr>
    <td class=textorelatorio>Ponto de referência:</td><td class=textorelatorio><input type=text name=referencia id=referencia size=50 value='{$data[referencia_visita]}'></td>
    </table>
    Necessidade de brinde:<br>
    <input type=checkbox name=brinde[1] id=brinde[1] "; if(in_array("Porta Caneta", $bri)){ $msg.=" checked ";} $msg.= " value=\"Porta Caneta\">Porta Caneta
    <input type=checkbox name=brinde[7] id=brinde[7] "; if(in_array("Caneta", $bri)){ $msg.=" checked ";} $msg.= " value=\"Caneta\">Caneta
    <input type=checkbox name=brinde[2] id=brinde[2] "; if(in_array("Régua", $bri)){ $msg.=" checked ";} $msg.= " value=\"Régua\">Régua
    <input type=checkbox name=brinde[8] id=brinde[8] "; if(in_array("Calendário de Mesa", $bri)){ $msg.=" checked ";} $msg.= " value=\"Calendário de Mesa\">Calendário de Mesa
    <input type=checkbox name=brinde[3] id=brinde[3] "; if(in_array("Risque Rabisque", $bri)){ $msg.=" checked ";} $msg.= " value=\"Risque Rabisque\">Risque Rabisque
    <input type=checkbox name=brinde[9] id=brinde[9] "; if(in_array("Chaveiro", $bri)){ $msg.=" checked ";} $msg.= " value=\"Chaveiro\">Chaveiro
    <input type=checkbox name=brinde[4] id=brinde[4] "; if(in_array("Mouse Pad", $bri)){ $msg.=" checked ";} $msg.= " value=\"Mouse Pad\">Mouse Pad
    <input type=checkbox name=brinde[10] id=brinde[10] "; if(in_array("Relógio de Parede", $bri)){ $msg.=" checked ";} $msg.= " value=\"Relógio de Parede\">Relógio de Parede
    <input type=checkbox name=brinde[5] id=brinde[5] "; if(in_array("Agenda", $bri)){ $msg.=" checked ";} $msg.= " value=\"Agenda\">Agenda
    <input type=checkbox name=brinde[11] id=brinde[11] "; if(in_array("Garrafa de Vinho", $bri)){ $msg.=" checked ";} $msg.= " value=\"Garrafa de Vinho\">Garrafa de Vinho
    <input type=checkbox name=brinde[6] id=brinde[6] "; if(in_array("Adesivo", $bri)){ $msg.=" checked ";} $msg.= " value=\"Adesivo\">Adesivo
    </div>
    <br>
    <center>
    <input type=button onclick=\"simulador_first({$cod_cliente});\" value=\"Salvar\"> &nbsp;
    <input type=button onclick=\"back_to_list({$cod_cliente});\" value=\"Voltar\">
";
echo "2|".$msg;
}

?>
