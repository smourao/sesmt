<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
<center><img src='images/welcome1.jpg' border=0></center>

        <p align=justify>
        <table width=100% cellspacing=0 cellpadding=0 border=0>
        <tr>
            
            <td width="96%" valign=top><object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="598" height="229">
              <param name="movie" value="BA14h.swf" />
              <param name="quality" value="high" />
              <param name="wmode" value="opaque" />
              <param name="swfversion" value="6.0.65.0" />
              <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don&rsquo;t want users to see the prompt. -->
              <param name="expressinstall" value="Scripts/expressInstall.swf" />
              <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
              <!--[if !IE]>-->
              <object type="application/x-shockwave-flash" data="BA14h.swf" width="598" height="229">
                <!--<![endif]-->
                <param name="quality" value="high" />
                <param name="wmode" value="opaque" />
                <param name="swfversion" value="6.0.65.0" />
                <param name="expressinstall" value="Scripts/expressInstall.swf" />
                <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
                <div>
                  <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
                  <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
                </div>
                <!--[if !IE]>-->
              </object>
              <!--<![endif]-->
            </object></td>
        </tr>
        </table>
    <BR>
    <p>
    <hr>
    <p>

    <center><img src='images/news.jpg' border=0></center>

<?PHP
    //JORNAL
    $sql = "SELECT * FROM site_jornal_sesmt  ORDER BY id DESC LIMIT 1";
    $res = @pg_query($sql);
    $news = @pg_fetch_all($res);
    for($x=0;$x<@pg_num_rows($res);$x++){
        echo "<p align=justify>";
        echo "<i>".date("d/m/Y", strtotime($news[$x][data]))."</i> - <b>{$news[$x][titulo]}</b><BR>";
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo nl2br($news[$x][resumo]);
        echo "</div>";
        echo "<BR>";
        if($x<3)
            echo "<hr>";
    }

 //MEDICO
    $sql = "SELECT * FROM site_newsletter_msg where (enviado_por = '4' or enviado_por = '10') ORDER BY id DESC LIMIT 1";
    $res = @pg_query($sql);
    $news = @pg_fetch_all($res);
    for($x=0;$x<@pg_num_rows($res);$x++){
        echo "<p align=justify>";
        echo "<i>".date("d/m/Y", strtotime($news[$x][data_criacao]))."</i> - <b>{$news[$x][titulo]}</b><BR>";
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo nl2br($news[$x][texto]);
        echo "</div>";
        echo "<BR>";
        if($x<3)
            echo "<hr>";
    }
	
	
	//GERENCIADOR DE MENSAGEM
    $sql = "SELECT gd.data, gt.titulo, gt.mensagem FROM gm_txt gt, gm_dt gd WHERE gt.mostrar = 1 AND gt.cod_mensagem = gd.cod_mensagem ORDER BY gt.id DESC LIMIT 1";
    $res = @pg_query($sql);
    $news = @pg_fetch_all($res);
    for($x=0;$x<@pg_num_rows($res);$x++){
        echo "<p align=justify>";
        echo "<i>".date("d/m/Y", strtotime($news[$x][data]))."</i> - <b>{$news[$x][titulo]}</b><BR>";
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo nl2br($news[$x][mensagem]);
        echo "</div>";
        echo "<BR>";
        if($x<3)
            echo "<hr>";
    }
	

 //TECNICO
    $sql = "SELECT * FROM site_newsletter_msg where (enviado_por = '33' or enviado_por = '35' or enviado_por = '37') ORDER BY id DESC LIMIT 1";
    $res = @pg_query($sql);
    $news = @pg_fetch_all($res);
    for($x=0;$x<@pg_num_rows($res);$x++){
        echo "<p align=justify>";
        echo "<i>".date("d/m/Y", strtotime($news[$x][data_criacao]))."</i> - <b>{$news[$x][titulo]}</b><BR>";
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo nl2br($news[$x][texto]);
        echo "</div>";
        echo "<BR>";
        if($x<3)
            echo "<hr>";
    }

 //SUPORTE
    $sql = "SELECT * FROM site_newsletter_msg where (enviado_por = '2' or enviado_por = '8') ORDER BY id DESC LIMIT 1";
    $res = @pg_query($sql);
    $news = @pg_fetch_all($res);
    for($x=0;$x<@pg_num_rows($res);$x++){
        echo "<p align=justify>";
        echo "<i>".date("d/m/Y", strtotime($news[$x][data_criacao]))."</i> - <b>{$news[$x][titulo]}</b><BR>";
        echo "<div class='novidades_text'>";
        echo "<p align=justify>";
        echo nl2br($news[$x][texto]);
        echo "</div>";
        echo "<BR>";
        if($x<3)
            echo "<hr>";
    }

?>
    <script type="text/javascript">
<!--
swfobject.registerObject("FlashID");
//-->
    </script>
