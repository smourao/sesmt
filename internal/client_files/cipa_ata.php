<?PHP

if($_GET['act'] == "new"){

?>
<form name="form1" id="form1" action="print_ata_cipa.php?act=new&cod_cliente=<?PHP echo $_SESSION['cod_cliente'];?>" method="post" target="_blank">
<table border=0 width="100%" ><tr><td style="vertical-align: top;">
<!-- LOGO -->
    <table border="0" width="100%" align="top" style="vertical-align: middle;"><tr>
        <!--MEDIDAS DO PEDRO
        <td width=491 height=189></td><td width=189 height=189 align=center><img src="cipa0.jpg" width=100% height=100%></td>-->
        <!--td height=200></td-->
        <td width="100%" height="189" align="right">
        <img src="images/cipa0.jpg" width=220 height=189>
        </td>
    </tr></table>
<!-- CORPO -->
    <table border="0" width="100%" align="top"><tr>
        <td style="vertical-align: top;">
    <b>
    ATA DA REUNI�O N�
    <span id=spanatan OnClick="tTOs('atan', 'spanatan', 4);" onMouseOver="return overlib('N�mero da ATA.');" onMouseOut="return nd();"><input type=text  class=text name="atan" id="atan" size=4 OnBlur="check('atan', 'spanatan');" onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span><p>
    </b>
    Reuni�o
    <!--Ordin�ria-->
    <!--<span id=spanord OnClick="tTOs('ord', 'spanord', 14);" onMouseOver="return overlib('ATA Ordin�ria ou Extraordin�ria.');" onMouseOut="return nd();"><input type=text  class=text name="ord" id="ord" size=14 OnBlur="check('ord', 'spanord');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span>
    -->
    <select name="d_ord" id="d_ord" OnBlur=""  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }">
    <option value="Ordin�ria">Ordin�ria</option>
    <option value="Extraordin�ria">Extraordin�ria</option>
    </select>
    
    
    da CIPA Gest�o
    <span id=spananoi OnClick="tTOs('anoi', 'spananoi', 3);" onMouseOver="return overlib('Ano de Gest�o. Ex.: 2008/2009');" onMouseOut="return nd();"><input type=text  class=text name="anoi" id="anoi" size=3 OnBlur="check('anoi', 'spananoi');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span>/<span id=spananof OnClick="tTOs('anof', 'spananof', 3);"><input type=text  class=text name="anof" id="anof" size=3 OnBlur="check('anof', 'spananof');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span>,
    da empresa
    <b><span id=spanempresa OnClick="tTOs('empresa', 'spanempresa', 40);"><input type=text  class=text name="empresa" id="empresa" size=40 OnBlur="check('empresa', 'spanempresa');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></B>,
    Endere�o: <b><span id=spanend OnClick="tTOs('end', 'spanend', 45);"><input type=text  class=text name=end id=end size=45 OnBlur="check('end', 'spanend');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b>,
    N� <b><span id=spannum OnClick="tTOs('num', 'spannum', 3);"><input type=text  class=text name=num id=num size=3 OnBlur="check('num', 'spannum');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b>
    Cidade: <b><span id=spancidade OnClick="tTOs('cidade', 'spancidade', 5);"><input type=text  class=text name=cidade id=cidade size=5 OnBlur="check('cidade', 'spancidade');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b>
    Munic�po: <b><span id=spanmunicipio OnClick="tTOs('municipio', 'spanmunicipio', 15);"><input type=text  class=text name=municipio id=municipio size=15 OnBlur="check('municipio', 'spanmunicipio');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b>
    Estado: <b><span id=spanestado OnClick="tTOs('estado', 'spanestado', 5);"><input type=text  class=text name=estado id=estado size=5 OnBlur="check('estado', 'spanestado');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b>
        </td>
    </tr>
    
    <tr><td>
    Aos dias <b>
    <span id=spandias OnClick="tTOs('dias', 'spandias', 2);" onMouseOver="return overlib('Dia em que se realizou a ATA.');" onMouseOut="return nd();"><input type=text  class=text name=dias id=dias size=2 OnBlur="check('dias', 'spandias');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> de
    <b><span id=spanmes OnClick="tTOs('mes', 'spanmes', 10);" onMouseOver="return overlib('Mes em que se realizou a ATA.');" onMouseOut="return nd();"><input type=text  class=text name=mes id=mes size=10 OnBlur="check('mes', 'spanmes');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> de
    <b><span id=spanano OnClick="tTOs('ano', 'spanano', 5);" onMouseOver="return overlib('Ano em que se realizou a ATA.');" onMouseOut="return nd();"><input type=text  class=text name=ano id=ano size=5 OnBlur="check('ano', 'spanano');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> �s
    <b><span id=spanhora OnClick="tTOs('hora', 'spanhora', 2);" onMouseOver="return overlib('Hora em que foi realizada a ATA.');" onMouseOut="return nd();"><input type=text  class=text name=hora id=hora size=2 OnBlur="check('hora', 'spanhora');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b>h<b><span id=spanmin OnClick="tTOs('min', 'spanmin', 2);" onMouseOver="return overlib('Mensagem.');" onMouseOut="return nd();"><input type=text  class=text name=min id=min size=2 OnBlur="check('min', 'spanmin');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b>min
    na sala de reuni�o da
    <b><span id=spansala OnClick="tTOs('sala', 'spansala', 30);"><input type=text  class=text name=sala id=sala size=30 OnChange="check('sala', 'spansala');"></span></b>
    realizou-se a reuni�o de n�&nbsp;<span id=n></span>&nbsp;com a presen�a dos Srs.
    <b><span id=spanpres OnClick="tTOs('pres', 'spanpres', 30);" onMouseOver="return overlib('Presidente da CIPA.');" onMouseOut="return nd();"><input type=text  class=text name=pres id=pres size=30 OnBlur="check('pres', 'spanpres');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> - Presidente da CIPA;
    <b><span id=spansuplente OnClick="tTOs('suplente', 'spansuplente', 30);" onMouseOver="return overlib('Suplente da CIPA.');" onMouseOut="return nd();"><input type=text  class=text name=suplente id=suplente size=30 OnBlur="check('suplente', 'spansuplente');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> - Suplente da CIPA;
    <b><span id=spanvice OnClick="tTOs('vice', 'spanvice', 30);" onMouseOver="return overlib('Vice Presidente da CIPA.');" onMouseOut="return nd();"><input type=text  class=text name=vice id=vice size=30 OnBlur="check('vice', 'spanvice');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> - Vice Presidente da CIPA;
    <b><span id=spansvp OnClick="tTOs('svp', 'spansvp', 30);" onMouseOver="return overlib('Suplente Vice-Presidente da CIPA.');" onMouseOut="return nd();"><input type=text  class=text name=svp id=svp size=30 OnBlur="check('svp', 'spansvp');"   onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> - Suplente Vice - Presidente;
    <b><span id=spansec OnClick="tTOs('sec', 'spansec', 30);" onMouseOver="return overlib('Secret�ria da CIPA.');" onMouseOut="return nd();"><input type=text  class=text name=sec id=sec size=30 OnBlur="check('sec', 'spansec');"  onKeyPress="if ((window.event ? event.keyCode : event.which) == 13) { nextfield(); }"></span></b> - Secret�ria da CIPA.
    </td></tr>
    
<!--
    <tr><td>
    <br>
    <div class=title1>Acidente de trabalho</div>
    </td></tr>
    <tr><td>
        <div id=spanacidente OnClick="tTOa('acidente', 'spanacidente', 10);">
        <textarea name=acidente id=acidente cols=100% rows=10 OnChange="check('acidente', 'spanacidente');"></textarea>
        </div>
    </td></tr>
    

    <tr><td>
    <br>
    <div class=title1>Medidas de Seguran�a Sugeridas</div>
    </td></tr>
    <tr><td>
        <div id=spansug OnClick="tTOa('sug', 'spansug', 10);">
        <textarea name=sug id=sug cols=100% rows=10 OnChange="check('sug', 'spansug');"></textarea>
        </div>
    </td></tr>
-->
    <tr><td id="tdelements" >
    <br> <center>
   <!--     <div id="elements" align=center>
        </div>
        <br>-->

    </td></tr>
    

    <tr><td align=center>
    <br>
    <div id="finalizar" class=title1>
       <input class=button type="button" name="cria" id="cria" value="Adicionar T�pico" OnClick="addTopic();"> <input class=button type="button" name="finish" id="finish" value="Finalizar" OnClick="Finish();">
    </div>
    </td></tr>

    
    <!-- FINALIZAR -->
    <tr><td> <br>
     Nada mais havendo a relatar ou discutir o Sr. Presidente deu por encerrada a reuni�o,
     sendo lavrada a presente Ata, que ap�s discutida e aprovada passa a ser assinada pelos
     membros representantes.
    </td></tr>
    
    <tr><td> <br> <br>
        <table border=0 align=center width="100%">
        <tr>
           <td><center>________________________<br>Presidente - CIPA</td>
           <td><center>________________________<br>Vice - Presidente - CIPA</td>
           <td><center>________________________<br>1� Secret�ria da CIPA</td>
        </tr>
        </table><br><br><br><br>
        <table border=0 align=center width="100%">
        <tr>
           <td><center>________________________<br>Suplente do Pres.</td>
           <td><center>________________________<br>Suplente do Vice - Pres.</td>
        </tr>
        </table>
        <br><br><br><br>
        <table border=0 align=center width="100%">
        <tr>
           <td>
           <div id="tosend" align=center></div>
           </td>
        </tr>
        </table>
    </td></tr>
    
</table>
<!-- /CORPO -->

</td></tr></table>

<!--<input type=hidden name=send_ata id=send_ata value="">
<input type=hidden name=data[] id=data value="">          -->

<input type=hidden name=d_atan id=d_atan  value="">
<!--<input type=hidden name=d_ord id=d_ord  value="">-->
<input type=hidden name=d_anoi id=d_anoi  value="">
<input type=hidden name=d_anof id=d_anof  value="">
<input type=hidden name=d_empresa id=d_empresa  value="">
<input type=hidden name=d_end id=d_end  value="">
<input type=hidden name=d_num id=d_num  value="">
<input type=hidden name=d_cidade id=d_cidade  value="">
<input type=hidden name=d_municipio id=d_municipio  value="">
<input type=hidden name=d_estado id=d_estado  value="">
<input type=hidden name=d_dias id=d_dias  value="">
<input type=hidden name=d_mes id=d_mes  value="">
<input type=hidden name=d_ano id=d_ano  value="">
<input type=hidden name=d_hora id=d_hora  value="">
<input type=hidden name=d_min id=d_min  value="">
<input type=hidden name=d_sala id=d_sala  value="">
<input type=hidden name=d_pres id=d_pres  value="">
<input type=hidden name=d_vice id=d_vice  value="">
<input type=hidden name=d_svp id=d_svp  value="">
<input type=hidden name=d_sec id=d_sec  value="">

<input type=hidden name=d_titulos id=d_titulos  value="">
<input type=hidden name=d_textos id=d_textos  value="">
</form>

<?PHP
}else{

if($_GET['act'] == "del"){
   $sql = "DELETE FROM site_ata_cipa WHERE id = '{$_GET['id']}' AND cod_cliente = ".$_SESSION['cod_cliente']."";
   $result = pg_query($sql);
}

echo '
<center>
<table width="100%" border="0">
  <tr>
    <td colspan="0"><center>
      <span class="style4">CIPA ATA</span><br>
    </center></td>
  </tr>
</table>
<p>';

echo "<center><input type=button value='Nova Ata da Cipa' class=button onclick=\"location.href='?do=cipa_ata&act=new'\">";

      echo "<p>";
      echo "<Table width=100% border=1 cellspacing=1 cellpading=1>
      <tr>
      <td align=center width=20><b>Cod.</b></td>
      <td align=center width=20><b>N� ATA</b></td>
      <td align=center ><b>Empresa</b></td>
      <td align=center width=90><b>Criado em</b></td>
      <td align=center width=170><b>A��es</b></td>
      </tr> ";
      
      $sql = "SELECT * FROM site_ata_cipa WHERE cod_cliente = '".$_SESSION['cod_cliente']."' ORDER BY id";
      $result = pg_query($sql);
      $buffer = pg_fetch_all($result);
      
      for($x=0;$x<pg_num_rows($result);$x++){
         echo "<tr>";
         echo "   <td>".STR_PAD($buffer[$x]['id'], 4, "0", STR_PAD_LEFT)."</td>";
         echo "   <td>{$buffer[$x]['d_atan']}</td>";
         echo "   <td>{$buffer[$x]['d_empresa']}</td>";
         echo "   <td>".date("d/m/Y", strtotime($buffer[$x]['criacao']))."</td>";
         echo "   <td align=center><a href='print_ata_cipa.php?act=view&id={$buffer[$x]['id']}' target=_blank>Visualizar</a> | <a href='?do=cipa_ata&act=del&id={$buffer[$x]['id']}' onclick=\"return confirm('Tem certeza que deseja excluir este item?')\" class=excluir>Excluir</a></td>";
         echo "</tr>";
      }
    echo "</table>";
}
?>