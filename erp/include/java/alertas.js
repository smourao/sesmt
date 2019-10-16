function fechar(){
document.getElementById("popup").style.display = "none";
}

function abrir(titulo, texto){
//var x = 5; //Starting Location - left
//var y = 5; //Starting Location - top
//var dest_x = 300;  //Ending Location - left
//var dest_y = 300;  //Ending Location - top
//var interval = 10; //Move 10px every initialization
w = screen.availWidth;
h = screen.availHeight;
document.getElementById("popup").style.display = "block";
document.getElementById("content").innerHTML = texto;
document.getElementById("title").innerHTML = titulo;
//alert("esquerda:" + getPosicaoElemento("popup").left)
//alert("topo:" + getPosicaoElemento("popup").top)
var topo = getPosicaoElemento("popup").top;
var left = ((w-750)/2)+450;
//var af = 160;
//alert(w);
//alert(screen.width + " x " + screen.height)
//topo += 100;
//topo = 0;
//while(topo<160){
/*if(topo<=560){
    document.getElementById("popup").style.top = topo+'px';
    //setTimeout(abrir, 100);
    topo=topo+1;
    window.setTimeout('abrir()',100);
   // alert(topo);
}  */
//document.getElementById("popup").style.top = topo;
document.getElementById("popup").style.left = left+'px';
//setTimeout ("abrir()", 1000);
}


function getPosicaoElemento(elemID){
    var offsetTrail = document.getElementById(elemID);
    var offsetLeft = 0;
    var offsetTop = 0;
    while (offsetTrail) {
        offsetLeft += offsetTrail.offsetLeft;
        offsetTop += offsetTrail.offsetTop;
        offsetTrail = offsetTrail.offsetParent;
    }
    if (navigator.userAgent.indexOf("Mac") != -1 &&
        typeof document.body.leftMargin != "undefined") {
        offsetLeft += document.body.leftMargin;
        offsetTop += document.body.topMargin;
    }
    return {left:offsetLeft, top:offsetTop};
}



var ie=document.all;
var nn6=document.getElementById&&!document.all;
var isdrag=false;
var x,y;
var dobj;

function movemouse(e)
{
  if (isdrag)
  {
    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x;
    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y;
    return false;
  }
}

function selectmouse(e)
{
  var fobj       = nn6 ? e.target : event.srcElement;
  var topelement = nn6 ? "HTML" : "BODY";
  while (fobj.tagName != topelement && fobj.className != "popup2")
  {
    fobj = nn6 ? fobj.parentNode : fobj.parentElement;
  }

  if (fobj.className=="popup2")
  {
    isdrag = true;
    dobj = fobj;
    tx = parseInt(dobj.style.left+0);
    ty = parseInt(dobj.style.top+0);
    x = nn6 ? e.clientX : event.clientX;
    y = nn6 ? e.clientY : event.clientY;
    document.onmousemove=movemouse;
    return false;
  }

}
document.onmousedown=selectmouse;
document.onmouseup=new Function("isdrag=false");

