  /*
  function getWidth()
  {
       return window.innerWidth ? window.innerWidth : //* For non-IE
              document.documentElement ? document.documentElement.clientWidth : //* IE 6+ (Standards Compilant Mode)
              document.body ? document.body.clientWidth : /* IE 4 Compatible
              window.screen.width; /* Others (It is not browser window size, but screen size)
  }

  function getHeight()
  {
       return window.innerHeight ? window.innerHeight : /* For non-IE
              document.documentElement ? document.documentElement.clientHeight : /* IE 6+ (Standards Compilant Mode)
              document.body ? document.body.clientHeight : /* IE 4 Compatible
              window.screen.height; /* Others (It is not browser window size, but screen size)
  }
*/

function getWidth() {
   return window.innerWidth && window.innerWidth > 0 ? window.innerWidth : /* Non IE */
   document.documentElement.clientWidth && document.documentElement.clientWidth > 0 ? document.documentElement.clientWidth : /* IE 6+ */
   document.body.clientWidth && document.body.clientWidth > 0 ? document.body.clientWidth : -1; /* IE 4 */
}
function getHeight() {
   return window.innerHeight && window.innerHeight > 0 ? window.innerHeight : /* Non IE */
   document.documentElement.clientHeight && document.documentElement.clientHeight > 0 ? document.documentElement.clientHeight : /* IE 6+ */
   document.body.clientHeight && document.body.clientHeight > 0 ? document.body.clientHeight : -1; /* IE 4 */
}
function resize(name) {
   div = document.getElementById(name);
   //div.style.width = getWidth();
   //div.style.height = getHeight();
   div.style.left = (getWidth() - 325)+"px";//"100px";
}
/*
function minimize(name){
   div = document.getElementById(name);
   div.style.height = "25px";
   alert(div.InnerHTML);
   document.getElementById("temptext").value = div.InnerHTML;
   div.innerHTML = "<table width=100%><tr><td><b>Titulo</b></td><td align=right width=40 valign=center><span style='cursor:pointer;' onclick=maximize('test');>_</span> x</td></tr></table>";
}

function maximize(name){
   div = document.getElementById(name);
   div.style.height = "400px";
   div.innerHTML = document.getElementById("temptext").value;
}
*/

/*
alert('Width: ' + window.screen.width.toString());
alert('Height: ' + window.screen.height.toString());
alert('Width: ' + getWidth().toString());
alert('Height: ' + getHeight().toString());
*/



