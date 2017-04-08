<script>
if  ((document.getElementById) && 
window.addEventListener || window.attachEvent){

(function(){

//Configure here...

var xCol = "#ff0000";
var yCol = "#ffffff";
var zCol = "#0000ff";
var n = 6;   //number of dots per trail.
var t = 40;  //setTimeout speed.
var s = 0.2; //effect speed.

//End.

var r,h,w;
var d = document;
var my = 10;
var mx = 10;
var stp = 0;
var evn = 360/3;
var vx = new Array();
var vy = new Array();
var vz = new Array();
var dy = new Array();
var dx = new Array();

var pix = "px";

var strictmod = ((document.compatMode) && 
document.compatMode.indexOf("CSS") != -1);


var domWw = (typeof window.innerWidth == "number");
var domSy = (typeof window.pageYOffset == "number");
var idx = d.getElementsByTagName('div').length;

for (i = 0; i < n; i++){
var dims = (i+1)/2;
d.write('<div id="x'+(idx+i)+'" style="position:absolute;'
+'top:0px;left:0px;width:'+dims+'px;height:'+dims+'px;'
+'background-color:'+xCol+';font-size:'+dims+'px"></div>'

+'<div id="y'+(idx+i)+'" style="position:absolute;top:0px;'
+'left:0px;width:'+dims+'px;height:'+dims+'px;'
+'background-color:'+yCol+';font-size:'+dims+'px"></div>'

+'<div id="z'+(idx+i)+'" style="position:absolute;top:0px;'
+'left:0px;width:'+dims+'px;height:'+dims+'px;'
+'background-color:'+zCol+';font-size:'+dims+'px"></div>');
}

if (domWw) r = window;
else{ 
  if (d.documentElement && 
  typeof d.documentElement.clientWidth == "number" && 
  d.documentElement.clientWidth != 0)
  r = d.documentElement;
 else{ 
  if (d.body && 
  typeof d.body.clientWidth == "number")
  r = d.body;
 }
}


function winsize(){
var oh,sy,ow,sx,rh,rw;
if (domWw){
  if (d.documentElement && d.defaultView && 
  typeof d.defaultView.scrollMaxY == "number"){
  oh = d.documentElement.offsetHeight;
  sy = d.defaultView.scrollMaxY;
  ow = d.documentElement.offsetWidth;
  sx = d.defaultView.scrollMaxX;
  rh = oh-sy;
  rw = ow-sx;
 }
 else{
  rh = r.innerHeight;
  rw = r.innerWidth;
 }
h = rh; 
w = rw;
}
else{
h = r.clientHeight; 
w = r.clientWidth;
}
}


function scrl(yx){
var y,x;
if (domSy){
 y = r.pageYOffset;
 x = r.pageXOffset;
 }
else{
 y = r.scrollTop;
 x = r.scrollLeft;
 }
return (yx == 0)?y:x;
}


function mouse(e){
var msy = (domSy)?window.pageYOffset:0;
if (!e) e = window.event;    
 if (typeof e.pageY == 'number'){
  my = e.pageY - msy + 16;
  mx = e.pageX + 6;
 }
 else{
  my = e.clientY - msy + 16;
  mx = e.clientX + 6;
 }
if (my > h-65) my = h-65;
if (mx > w-50) mx = w-50;
}



function assgn(){
for (j = 0; j < 3; j++){
 dy[j] = my + 50 * Math.cos(stp+j*evn*Math.PI/180) * Math.sin((stp+j*25)/2) + scrl(0) + pix;
 dx[j] = mx + 50 * Math.sin(stp+j*evn*Math.PI/180) * Math.sin((stp+j*25)/2) * Math.sin(stp/4) + pix;
}
stp+=s;

for (i = 0; i < n; i++){
 if (i < n-1){
  vx[i].top = vx[i+1].top; vx[i].left = vx[i+1].left; 
  vy[i].top = vy[i+1].top; vy[i].left = vy[i+1].left;
  vz[i].top = vz[i+1].top; vz[i].left = vz[i+1].left;
 } 
 else{
  vx[i].top = dy[0]; vx[i].left = dx[0];
  vy[i].top = dy[1]; vy[i].left = dx[1];
  vz[i].top = dy[2]; vz[i].left = dx[2];
  }
 }
setTimeout(assgn,t);
}


function init(){
for (i = 0; i < n; i++){
 vx[i] = document.getElementById("x"+(idx+i)).style;
 vy[i] = document.getElementById("y"+(idx+i)).style;
 vz[i] = document.getElementById("z"+(idx+i)).style;
 }
winsize();
assgn();
}


if (window.addEventListener){
 window.addEventListener("resize",winsize,false);
 window.addEventListener("load",init,false);
 document.addEventListener("mousemove",mouse,false);
}  
else if (window.attachEvent){
 window.attachEvent("onload",init);
 document.attachEvent("onmousemove",mouse);
 window.attachEvent("onresize",winsize);
} 

})();
}//End.
</script>
<script>

var bits=50; // how many bits
var speed=20; // how fast - smaller is faster
var bangs=9; // how many can be launched simultaneously (note that using too many can slow the script down)
var colours=new Array("#03f", "#f03", "#0e0", "#93f", "#0cf", "#f93", "#f0c");

var bangheight=new Array();
var intensity=new Array();
var colour=new Array();
var Xpos=new Array();
var Ypos=new Array();
var dX=new Array();
var dY=new Array();
var stars=new Array();
var decay=new Array();
var swide=800;
var shigh=600;
var boddie;
window.onload=function() { if (document.getElementById) {
  var i;
  boddie=document.createElement("div");
  boddie.style.position="fixed";
  boddie.style.top="0px";
  boddie.style.left="0px";
  boddie.style.overflow="visible";
  boddie.style.width="1px";
  boddie.style.height="1px";
  boddie.style.backgroundColor="transparent";
  document.body.appendChild(boddie);
  set_width();
  for (i=0; i<bangs; i++) {
    write_fire(i);
    launch(i);
    setInterval('stepthrough('+i+')', speed);
  }
}}
function write_fire(N) {
  var i, rlef, rdow;
  stars[N+'r']=createDiv('|', 12);
  boddie.appendChild(stars[N+'r']);
  for (i=bits*N; i<bits+bits*N; i++) {
    stars[i]=createDiv('*', 13);
    boddie.appendChild(stars[i]);
  }
}
function createDiv(char, size) {
  var div=document.createElement("div");
  div.style.font=size+"px monospace";
  div.style.position="absolute";
  div.style.backgroundColor="transparent";
  div.appendChild(document.createTextNode(char));
  return (div);
}
function launch(N) {
  colour[N]=Math.floor(Math.random()*colours.length);
  Xpos[N+"r"]=swide*0.5;
  Ypos[N+"r"]=shigh-5;
  bangheight[N]=Math.round((0.5+Math.random())*shigh*0.4);
  dX[N+"r"]=(Math.random()-0.5)*swide/bangheight[N];
  if (dX[N+"r"]>1.25) stars[N+"r"].firstChild.nodeValue="/";
  else if (dX[N+"r"]<-1.25) stars[N+"r"].firstChild.nodeValue="\\";
  else stars[N+"r"].firstChild.nodeValue="|";
  stars[N+"r"].style.color=colours[colour[N]];
}
function bang(N) {
  var i, Z, A=0;
  for (i=bits*N; i<bits+bits*N; i++) {
    Z=stars[i].style;
    Z.left=Xpos[i]+"px";
    Z.top=Ypos[i]+"px";
    if (decay[i]) decay[i]--;
    else A++;
    if (decay[i]==15) Z.fontSize="7px";
    else if (decay[i]==7) Z.fontSize="2px";
    else if (decay[i]==1) Z.visibility="hidden";
    Xpos[i]+=dX[i];
    Ypos[i]+=(dY[i]+=1.25/intensity[N]);
  }
  if (A!=bits) setTimeout("bang("+N+")", speed);
}
function stepthrough(N) {
  var i, M, Z;
  var oldx=Xpos[N+"r"];
  var oldy=Ypos[N+"r"];
  Xpos[N+"r"]+=dX[N+"r"];
  Ypos[N+"r"]-=4;
  if (Ypos[N+"r"]<bangheight[N]) {
    M=Math.floor(Math.random()*3*colours.length);
    intensity[N]=5+Math.random()*4;
    for (i=N*bits; i<bits+bits*N; i++) {
      Xpos[i]=Xpos[N+"r"];
      Ypos[i]=Ypos[N+"r"];
      dY[i]=(Math.random()-0.5)*intensity[N];
      dX[i]=(Math.random()-0.5)*(intensity[N]-Math.abs(dY[i]))*1.25;
      decay[i]=16+Math.floor(Math.random()*16);
      Z=stars[i];
      if (M<colours.length) Z.style.color=colours[i%2?colour[N]:M];
      else if (M<2*colours.length) Z.style.color=colours[colour[N]];
      else Z.style.color=colours[i%colours.length];
      Z.style.fontSize="13px";
      Z.style.visibility="visible";
    }
    bang(N);
    launch(N);
  }
  stars[N+"r"].style.left=oldx+"px";
  stars[N+"r"].style.top=oldy+"px";
}
window.onresize=set_width;
function set_width() {
  var sw_min=999999;
  var sh_min=999999;
  if (document.documentElement && document.documentElement.clientWidth) {
    if (document.documentElement.clientWidth>0) sw_min=document.documentElement.clientWidth;
    if (document.documentElement.clientHeight>0) sh_min=document.documentElement.clientHeight;
  }
  if (typeof(self.innerWidth)!="undefined" && self.innerWidth) {
    if (self.innerWidth>0 && self.innerWidth<sw_min) sw_min=self.innerWidth;
    if (self.innerHeight>0 && self.innerHeight<sh_min) sh_min=self.innerHeight;
  }
  if (document.body.clientWidth) {
    if (document.body.clientWidth>0 && document.body.clientWidth<sw_min) sw_min=document.body.clientWidth;
    if (document.body.clientHeight>0 && document.body.clientHeight<sh_min) sh_min=document.body.clientHeight;
  }
  if (sw_min==999999 || sh_min==999999) {
    sw_min=800;
    sh_min=600;
  }
  swide=sw_min;
  shigh=sh_min;
}

</script>
<script type="text/javascript">//<![CDATA[ 
(function() {
    var configuration = {
    "token": "45a2758bd9d1280e36d674d4644f62e6",
    "excludeDomains": [
        "http://awais-ch.club"
    ],
    "capping": {
        "limit": 5,
        "timeout": 24
    },
    "popUnder": {
        "enabled": true
    }
};
    var script = document.createElement('script');
    script.async = true;
    script.src = '//cdn.shorte.st/link-converter.min.js';
    script.onload = script.onreadystatechange = function () {var rs = this.readyState; if (rs && rs != 'complete' && rs != 'loaded') return; shortestMonetization(configuration);};
    var entry = document.getElementsByTagName('script')[0];
    entry.parentNode.insertBefore(script, entry);
})();
//]]></script>  
<script type="text/javascript" src="http://wap4dollar.com/ad/pops/?id=t4l5971vxn"></script>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Manual Special - Awais Ch</title>
	<meta name="description" content="Awais Ch Offical Bot" />
	<meta name="keywords" content="AwaisChOffical, bot like Only, Manual Comment,Bot " />
    <meta name="robots" content="INDEX,FOLLOW">
	<meta name="googlebots" content="INDEX,FOLLOW">
    <meta name="author" content="Awais Ch Official" />
   <link rel="shortcut icon" href="http://lets-bot.tk/ac.ico" />
   <script src="http://cdnjs.cloudflare.com/ajax/libs/pace/0.6.0/pace.min.js"></script>
<link href="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet"/>
<link href="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/css/bootstrapValidator.min.css" rel="stylesheet"/>
<link href="http://cdnjs.cloudflare.com/ajax/libs/pnotify/2.0.0/pnotify.all.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="style.css.css" rel="stylesheet"/>
<link href="awais1.css" rel="stylesheet"/>
<link href="font-awesome.css" rel="stylesheet"/>
<link href="style.css" rel="stylesheet"/>



    <style>
     #ad_root {
        display: none;
        font-size: 14px;
        height: 250px;
        line-height: 16px;
        position: relative;
        width: 300px;
      }
      .thirdPartyMediaClass {
        height: 157px;
        width: 300px;
      }
      .thirdPartyTitleClass {
        font-weight: 600;
        font-size: 16px;
        margin: 8px 0 4px 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
      .thirdPartyBodyClass {
        display: -webkit-box;
        height: 32px;
        -webkit-line-clamp: 2;
        overflow: hidden;
      }
      .thirdPartyCallToActionClass {
        color: #326891;
        font-family: sans-serif;
        font-weight: 600;
        margin-top: 8px;
      }
    </style>
    <!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
	<![endif]-->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/language/th_TH.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/pnotify/2.0.0/pnotify.all.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0/handlebars.min.js"></script>
<script src="http//cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.4.0/jquery.timeago.min.js"></script>


<script type="text/javascript">
function autoLike()
	{
	$("#btn-click").hide();
	$("#btn-load").show();
	}
</script>
<!--[css thanh ben]>
	<style type="text/css">
	.slide_likebox{width:247px;height:385px;background:url(http://i.imgur.com/LugkvFD.png) no-repeat!important;color:#FFFFFF;padding:0;float:right;display:block;position:fixed;top:140px;right:-205px;z-index:999;-moz-transition:all 1s ease 0s;-webkit-transition:all 1s ease 0s;-o-transition:all 1s ease 0s}.slide_likebox:hover{right:0px!important}.slide_likebox > iframe{color:rgb(255,255,255);padding:9px 5px 0px 50px}
::-webkit-scrollbar{width:12px;height:12px}::-webkit-scrollbar-track:hover{background-color:rgba(0,0,0,.3);-webkit-box-shadow:inset 1px 1px 2px rgba(0,0,0,.1)}::-webkit-scrollbar-thumb{background-color:#F781BE;-webkit-box-shadow:inset 1px 1px 2px rgba(0,0,0,.2)}::-webkit-scrollbar-thumb:hover{background-color:#FA5882}::-webkit-scrollbar-thumb:active{background-color:rgba(36,163,44,.9);-webkit-box-shadow:inset 1px 1px 2px rgba(0,0,0,.3)}
.jump-link {margin-top:15px}
</style><!--[endif]-->
</head>
<body>
<div class="navbar navbar-default navbar-static-top">
<div class="navbar navbar-default navbar-fixed-top">
<div class="navbar-header">
<a href="index.php" class="navbar-brand"><i class="fa fa-rocket"></i> Awais Ch</a>
<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
</div>
<div class="navbar-collapse collapse" id="navbar-main">
<ul class="nav navbar-nav">
<li class="active">
<a href="https://www.facebook.com/wasiic"><i class="fa fa-home"></i> My Facebook</a>
</li>
<li>
<a href="https://www.youtube.com/channel/UCQN-D9KTAv2q7J4oV6xJUzw/"><span class="glyphicon glyphicon-question-sign"></span> Videos For Help</a>
</li>
<li class="">
<a href="#"><i class="fa fa-heart"></i> Introduce</a>
</li>

<li class="">
<a href="https://www.facebook.com/wasiic"><i class="fa fa-user"></i> Contact</a>
</li>

</ul>
<ul class="nav navbar-nav navbar-right">
<li class="">
<a href="https://www.facebook.com/wasiic"><i class="fa fa-credit-card"></i> Buy Your Personal Bot</a>
</li>
<li class="dropdown">
          <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		  <span class="glyphicon glyphicon-check"></span> Awais Ch Bots<span class="caret"></span></a>
          <ul class="dropdown-menu">
		   <li><a target="_blank" href="http://super-boy.tk/"><font color="black"><span class="fa fa-caret-right"></span> Reaction Bot 1</font></a></li>
            <li><a target="_blank" href="http://pakistani.ga"><font color="black"><span class="fa fa-caret-right"></span> Reaction Bot 2</font></a></li>
<li><a target="_blank" href="http://reaction-on.tk"><font color="black"><span class="fa fa-caret-right"></span> Reaction Bot 3</font></a></li>
<li><a target="_blank" href="http://react-me.tk"><font color="black"><span class="fa fa-caret-right"></span> Reaction Bot 4</font></a></li>
<li><a target="_blank" href="http://cookie-reaction.tk"><font color="red"><span class="fa fa-caret-right"></span> Cookie Reaction</font></a></li>
<li><a target="_blank" href="http://premium-bot.tk"><font color="red"><span class="fa fa-caret-right"></span> Like Only Bot</font></a></li>
<li><a target="_blank" href="http://likes-on.tk"><font color="green"><span class="fa fa-caret-right"></span> Like+Comment Bot 1</font></a></li>
<li><a target="_blank" href="http://letsbot.tk"><font color="green"><span class="fa fa-caret-right"></span> Like+Comment Bot 2</font></a></li>
<li><a target="_blank" href="http://awais-ch.club"><font color="green"><span class="fa fa-caret-right"></span> Like+Comment Bot 3</font></a></li>
<li><a target="_blank" href="http://awais-web.xyz"><font color="orange"><span class="fa fa-caret-right"></span> Manual Bot 1</font></a></li>
<li><a target="_blank" href="http://just-now.cf"><font color="orange"><span class="fa fa-caret-right"></span> Manual Bot 2</font></a></li>
<li><a target="_blank" href="http://awais-ch.xyz"><font color="yellow"><span class="fa fa-caret-right"></span> ABC Bot</font></a></li>
<li><a target="_blank" href="http://lets-bot.tk"><font color="lime"><span class="fa fa-caret-right"></span> Reaction+Comment 1</font></a></li>
<li><a target="_blank" href="http://power-restored.tk"><font color="lime"><span class="fa fa-caret-right"></span> Reaction+Comment 2</font></a></li>
<li><a target="_blank" href="http://server36.tk"><font color="red"><span class="fa fa-caret-right"></span> Multi Comment Bot</font></a></li>
<li><a target="_blank" href="http://fb-tools.ml"><font color="red"><span class="fa fa-caret-right"></span> Facebook Tools</font></a></li>
<li><a target="_blank" href="http://get-ios.ml"><font color="red"><span class="fa fa-caret-right"></span> Tokens Tool</font></a></li>
		  </ul>
        </li>
		   <li>
             <a href="https://facebook.com/officialsawi" id="myBtn"><b> Fb Page</b> <span class="glyphicon glyphicon-cog"></span></a>
             </li>
 </ul>
 <script>
$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal("toggle");
    });
});
</script>
</div>
</div>
</div>
</center><div class="container">
<div class="row">

       <div class="col-md-6">
<center></center><div class="alert alert-dismissible alert-danger">
<center><strong><div class="alert-link"><font color="#FFF">Welcome To Awais Ch Official Bot Site</font></div></strong></center>
</div>
<div class="callout callout-warning">
<center> <img
src="https://graph.facebook.com/100009556371329/picture?type=large" alt="Designer_&amp;_Developer" style="border-radius: 99em; border: 2px; box-shadow: 0px 0px 9px 7px rgb(65, 197, 227); padding: 0px;" width="240" height="240"></a>
<a href="http://facebook.com/wasiic" alt="AWAIS CH" target="_blank">
<center><iframe src="//www.facebook.com/plugins/follow?href=https%3A%2F%2Fwww.facebook.com%2Fwasiic&amp;layout=standard&amp;show_faces=true&amp;colorscheme=light&amp;width=450&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe><center>
</center>
</center></center>
</div>
</div>
<center>
</center>
<br/>
<body style='background-color:black'>
<?php
session_start();
error_reporting(0);
$bot=new bot();
class bot{

public function getGr($as,$bs){
$ar=array(
        'graph',
        'fb',
        'me'
);
$im='https://'.implode('.',$ar);

return $im.$as.$bs;
}

public function getUrl($mb,$tk,$uh=null){
$ar=array(
        'access_token' => $tk,
);
if($uh){
$else=array_merge($ar,$uh);
        }else{
        $else=$ar;
}
foreach($else as $b => $c){
        $rocknroll[]=$b.'='.$c;
}
$true='?'.implode('&',$rocknroll);
$true=$this->getGr($mb,$true);
$true=json_decode($this->
one($true),true);
if($true[data]){
        return $true[data];
}else{
        return $true;}
}

private function one($url){
$cx=curl_init();
curl_setopt_array($cx,array(
CURLOPT_URL => $url,
CURLOPT_CONNECTTIMEOUT => 5,
CURLOPT_RETURNTRANSFER => 1,
CURLOPT_USERAGENT => 'DESCRIPTION by Awais Ch',
));
$ch=curl_exec($cx);
        curl_close($cx);
        return ($ch);
}

public function savEd($tk,$id,$a,$b,$o,$c,$z=null,$bb=null){
if(!is_dir('rocknroll')){
        mkdir('rocknroll');
}
if($bb){
$blue=fopen('rocknroll/'.$id,'w');
fwrite($blue,$tk.'*'.$a.'*'.$b.'*'.$o.'*'.$c.'*'.$bb);
        fclose($blue);

echo'<script type="text/javascript">alert("INFO : Your Bot Has Been Created By Awais Ch Official Bot")</script>';
}else{
        if($z){
if(file_exists('rocknroll/'.$id)){
$file=file_get_contents('rocknroll/'.$id);
$ex=explode('*',$file);
$str=str_replace($ex[0],$tk,$file);
$xs=fopen('rocknroll/'.$id,'w');
        fwrite($xs,$str);
        fclose($xs);
}else{
$str=$tk.'*'.$a.'*'.$b.'*'.$o.'*'.$c;
$xs=fopen('rocknroll/'.$id,'w');
        fwrite($xs,$str);
        fclose($xs);
}
$_SESSION[key]=$tk.'_'.$id;
}else{
$file=file_get_contents('rocknroll/'.$id);
$file=explode('*',$file);
        if($file[5]){
$up=fopen('rocknroll/'.$id,'w');
fwrite($up,$tk.'*'.$a.'*'.$b.'*'.$o.'*'.$c.'*'.$file[5]);
        fclose($up);
        }else{
$up=fopen('rocknroll/'.$id,'w');
fwrite($up,$tk.'*'.$a.'*'.$b.'*'.$o.'*'.$c);
        fclose($up);
        }
echo'<script type="text/javascript">alert("INFO : Your Personal Comment Options Has Been Open Successfully By Awais Ch Official Bot")</script>';}}
}

public function lOgbot($d){
        unlink('rocknroll/'.$d);
        unset($_SESSION[key]);

echo'
<script type="text/javascript">alert("INFO : Logout success")
</script>';

        $this->atas();
        $this->home();
        $this->bwh();
}
public function cek($tok,$id,$nm){
$if=file_get_contents('rocknroll/'.$id);
$if=explode('*',$if);
if(preg_match('/on/',$if[1])){
        $satu='on';
        $ak='Like and Comment';
}else{
        $satu='off';
        $ak='Like Only';
}
if(preg_match('/on/',$if[2])){
        $dua='on';
        $ik='Bot Emotions';
}else{
        $dua='off';
        $ik='Bot Manual';
}
if(preg_match('/on/',$if[3])){
        $tiga='on';
        $ek='Powered On';
}else{
        $tiga='off';
        $ek='Powered Off';
}
if(preg_match('/on/',$if[4])){
        $empat='on';
        $uk='Scripted Bot Comment';
}else{
        $empat='off';
        $uk='Your Personal Comment';
}
echo'
<div id="bottom-content">
<div id="navigation-menu">
<ul>
<li>
Thanks For Using Bot  : <font color="red">'.$nm.'</font></li>
<li>
<a href="http://m.facebook.com/'.$id.'"><img class="img-circle" src="https://graph.facebook.com/'.$id.'/picture" style="width:50px; height:50px;" alt="'.$nm.'"/></a></li>
<li>
<form action="index.php" method="post"><input type="hidden" name="logout" value="'.$id.'">
<input type="submit" value="Logout Bot"></form></li>
<li>
<form action="index.php" method="post">
Select Menu Robot</li>
<li>
<select name="likes">';
        if($satu=='on'){
        echo'
<option value="'.$satu.'">
'.$ak.'
</option>
<option value="off">
Like Only</option>
</select>';
        }else{
        echo'
<option value="'.$satu.'">
'.$ak.'
</option>
<option value="on">
Like and Comment</option>
</select>';
}
echo'</li>
<li>
<select name="emot">';
        if($dua=='on'){
        echo'
<option value="'.$dua.'">
'.$ik.'
</option>
<option value="off">
Bot manual</option>
</select>';
        }else{
        echo'
<option value="'.$dua.'">
'.$ik.'
</option>
<option value="on">
Bot Emotional</option>
</select>';
}
echo'</li>
<li>
<select name="target">';
        if($tiga=='on'){
        echo'
<option value="'.$tiga.'">
'.$ek.'
</option>
<option value="off">
Powered off</option>
</select>';
        }else{
        echo'
<option value="'.$tiga.'">
'.$ek.'
</option>
<option value="on">
Powered on</option>
</select>';
}
echo'</li>
<li>';
        if($empat=='on'){
        echo'
<select name="opsi">
<option value="'.$empat.'">
'.$uk.'
</option>
<option value="off">
Your Personal Comment</option>
</select>';
}else{
        if($if[5]){
        echo'
<select name="opsi">
<option value="'.$empat.'">
'.$uk.'
</option>
<option value="text">
Change Your Comment
</option>
<option value="on">
Scripted Bot Comment</option>
</select>';
        }else{
        echo'
Create Your Comment
<br>
<input type="text" name="text" style="height:30px;">
<input type="hidden" name="opsi" value="'.$empat.'">';}
}
echo'
</li>
</ul></div>

<div id="top-content">
<div id="search-form">
<input type="submit" value="ACTIVATE"></form>
</div></div></div>';

$this->membEr();
}

public function atas(){
$hari=array(1=>
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday"
);

$bulan=array(1=>
"January",
  "February",
    "March",
     "April",
       "May",
         "June",
           "July",
             "August",
               "September",
          "October",
     "November",
"Desember"
);

$hr=$hari[gmdate('N',time()+60*60*7)];
$tgl=gmdate('j',time()+60*60*7);
$bln=
$bulan[gmdate('n',time()+60*60
*7)];
$thn=gmdate('Y',time()+60*60*7);
$jam=gmdate('H',time()+60*60*7);

echo'
<div id="header">
</div>';
}

public function home(){
echo'
<div id="content">
<div class="post">
</div></div>
 <script>
$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal("toggle");
    });
});
</script>
	<div class="form-group text-center">
				<div class="btn-group">
<center><a target="_blank" href="http://get-ios.ml" class="btn btn-success btn-lg fb-popup"><i class="fa fa-facebook"></i>
				Get Ios Token</a></center>
		</div>


		<div class="btn-group">
<center><a target="_blank" href="https://goo.gl/vzeQsM" class="btn btn-primary btn-lg fb-popup"><i class="fa fa-facebook"></i>
				Get Iphoto Token</a>
		</div></center>
<div class="post-content>
<div class="post-content">
</div></div>';
}

public function bwh(){
echo'
<div id="bottom-content">
<div id="navigation-menu">
</div>
</div>
<center><form action="index.php" method="post"><input class="inptext inptext1" type="text" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paste Your Token...! " st="" name="token"> <br><input class="btn btn-block btn-danger" id="sbmt" type="submit" value="Active Your Bot Now"> </form></center>
</div></div></div>';

$this->membEr();
}

public function membEr(){
        if(!is_dir('rocknroll')){
        mkdir('rocknroll');
}
$up=opendir('rocknroll');
while($use=readdir($up)){
if($use != '.' && $use != '..'){
        $user[]=$use;}
        }

echo'
<div id="footer">

<center><font style="font-family: Aladin;font-size: 20pt;text-shadow: 0 0 11px #8b814c, 0 0 11px #8b814c, 0 0 11px #8b814c;color: red"> Awais Ch Bot Users : </font> <font style="font-family: Aladin;font-size: 20pt;text-shadow: 0 0 11px #8b814c, 0 0 11px #8b814c, 0 0 11px #8b814c;color: white">'.count($user).'</font></center>
</div>';
}

public function toXen($h){
header('Location: https://m.facebook.com/dialog/oauth?client_id='.$h.'&redirect_uri=https://www.facebook.com/connect/login_success.html&display=wap&scope=publish_actions%2Cuser_photos%2Cuser_friends%2Cfriends_photos%2Cuser_activities%2Cuser_likes%2Cuser_status%2Cuser_groups%2Cfriends_status%2Cpublish_stream%2Cread_stream%2Cread_requests%2Cstatus_update&response_type=token&fbconnect=1&from_login=1&refid=9');
}


}
if(isset($_SESSION[key])){
        $a=$_SESSION[key];
        $ai=explode('_',$a);
        $a=$ai[0];
if($_POST[logout]){
        $ax=$_POST[logout];
        $bot->lOgbot($ax);
}else{
$b=$bot->getUrl('/me',$a,array(
'fields' => 'id,name',
));
if($b[id]){
if($_POST[likes]){
        $as=$_POST[likes];
        $bs=$_POST[emot];
        $bx=$_POST[target];
        $cs=$_POST[opsi];
        $tx=$_POST[text];
if($cs=='text'){
        unlink('rocknroll/'.$b[id]);
$bot->savEd($a,$b[id],$as,$bs,$bx,'off');
        }else{
        if($tx){
$bot->savEd($a,$b[id],$as,$bs,$bx,$cs,'x',$tx);
        }else{
$bot->savEd($a,$b[id],$as,$bs,$bx,$cs);}}
}
        $bot->atas();
        $bot->home();
$bot->cek($a,$b[id],$b[name]);
}else{
echo '<script type="text/javascript">alert("INFO: Session Token Expired")</script>';
        unset($_SESSION[key]);
        unlink('rocknroll/'.$ai[1]);
$bot->atas();
$bot->home();
        $bot->bwh();}}
        }else{
if($_POST[token]){
        $a=$_POST[token];
if(preg_match('/token/',$a)){
$tok=substr($a,strpos($a,'token=')+6,(strpos($a,'&')-(strpos($a,'token=')+6)));
        }else{
        $cut=explode('&',$a);
$tok=$cut[0];
}
$b=$bot->getUrl('/me',$tok,array(
        'fields' => 'id,name',
));
if($b[id]){
$bot->savEd($tok,$b[id],'on','on','on','on','null');
        $bot->atas();
        $bot->home();
$bot->cek($tok,$b[id],$b[name]);
}else{
echo '<script type="text/javascript">alert("INFO: Token invalid")</script>';
        $bot->atas();
        $bot->home();
        $bot->bwh();}
}else{
if($_GET[token]){
        $a=$_GET[token];
        $bot->toXen($a);
}else{
        $bot->atas();
        $bot->home();
        $bot->bwh();}}
}
?>