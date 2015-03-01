<?php
//init:
$m=array('in','out','url','fallback','params','optional','required','received','missing','show','config'/*, …*/);
foreach($m as $i){define($i,$i);};
define(debug,$_GET[show]===config);
$i=&$_SERVER;
$m=pathinfo($i['PHP_SELF']);
$m=array(empty($i['HTTPS'])?'http':'https',&$i['SERVER_NAME'],$m['dirname'],$m['basename']);
unset($i);
define(pageurl,$m[0].'://'.$m[1].$m[2].'/'.$m[3]);
unset($m);

//digest:





function ParseQsBy(&$x){
 $r=array(received=>null,missing=>array(required=>$a,optional=>$b));
 $m=&$_GET;//array_flip(array_flip());??????
 if(!empty($m)){
  $a=$x[required][in];
  $b=$x[optional][in];
  function g(&$o,$j,&$r,$k){
   $a=&$r[received][$k];
   $b=&$r[missing][$k];
   foreach($o as $p){
    $v=$j[$p];
    if(!empty($v)){
     $a[]=Array($p=>$v);
     unset($b[array_search($p,$o)]);
    };
   };
   $j=function(&$e){if(empty($e)){$e=null;};};//EmptyToNull;
   $j($a);
   $j($b);
  };
  g($a,$m,$r,required);
  g($b,$m,$r,optional);
 };
 return $r;
};










//======================================================================================================================================================================================================================
//#Config:





//======================================================================================================================================================================================================================
$params=ParseQsBy($partner[params]);
$receivedparams=&$params[received];
//
$defined=debug?count(get_defined_vars()):null;









//========================================================================================================================================================================================================
if(debug){
 define('space',chr(0x0020));
 define('spancolon','<span class="colon">:</span>');

 function bname($n){return '<b class="name">'.$n.'</b>';};
 function spanvalue($v){return '<span class="value">'.$v.'</span>';};

 function nv($n,$v){return bname($n.spancolon).(empty($v)?'':spanvalue($v));};//($j?'<span class="counts">('.$j.')</span>'.PHP_EOL:'').

 function dump($o){
  $r='';
  if(!empty($o)){
   $r='<ul>';
   foreach($o as $n => $v){
    $c=(empty($v)?(space.'class="'.$v===0?'zero':'empty'.'"'):'');
    if(is_array($v)||is_object($v)){
     $r.=('<ul'.$c.'><strong>'.$n.'</strong>'.spancolon.'<div>'.dump($v).'</div></ul>');
    }else{
     $r.=('<li'.$c.'>'.nv($n,$v).'</li>');
    };
   };
   $r.='</ul>'.PHP_EOL;
  };
  return $r;
 };





 function json_pretty($x,$tag=false){
  $r='';
  if(!empty($x)){
   $x=preg_split('|([\{\}\]\[,])|',$x,-1,PREG_SPLIT_DELIM_CAPTURE);
   $i=0;
   $n=chr(10);//:\n
   $z=chr(13);//:\r
   $tab=function($i){return str_repeat(chr(9),$i);};//:\t
   $branch=function($s,$a,$b){return ($s===$a||$s===$b);};
   $f=function($o){return $o;};
   $h=function($o){return '';};
   if($tag===true){
    $h=function($x){$m=array('{'=>'object','['=>'array');return '<span class="'.$m[$x].'">';};$z='</span>';
    $f=function($x){$g=preg_match;$j=preg_replace;$k='/(")(.+)(")(:$)/';if($g($k,$x)){$x=$j($k,'<q class="key">$2</q>:',$x);}else{$k='/(")(.+)(")(:)(.+$)/';if($g($k,$x)){$x=$j($k,'<span class="pair"><q>$2</q>:<i>$2</i></span>',$x);}else{$k='/(")(.+)(")/';$x=$j($k,'<q>$2</q>',$x);};};return $x;};
   };
   foreach($x as $s){
    if($s==''){continue;};
    $p=$tab($i);
    if($branch($s,'{','[')){$i++;//open*
     if(($r!='') && ($r[(strlen($r) - 1)]==$n)){$r.=$p;};
     $r.=($h($s).($s.$n));
    }elseif($branch($s,'}',']')){$i--;//*close
     $p=$tab($i);$r.=($n.$p.$s.$z);//lastlineofbranch
    }elseif($s==','){
     $r.=($s.$n);//comma
    }else{
     $r.=($p.$f($s));
    };
   };
   $r.=$n;
  };
  return $r;
 };






 function jsonfy($o,$h){return empty($o)?'':json_pretty(stripcslashes(json_encode($o)),$h);};

 function printout($k,$c,$o){$L=PHP_EOL;echo($L.'<div class="printed'.(isset($c)?(space.$c):'output').'">'.(strpos($o,$L)?'<input class="folding control" type="checkbox" '.($k===1?'checked':'').'/>':'').$o.'</div>'.$L);};

 function titled($n,$v){
  $f=preg_replace;
  $n=$f('/\$/','<span class="sign dollar">&#36;</span>',$n);
  $n=$f('/\[(.*?)\]/','<span class="square-brackets">[<i>$1</i>]</span>',$n);
  return '<span class="data">'.nv($n,$v).'</span>';
 };

 function printout_json($k,$n,$v,$h){printout($k,'json',titled($n,jsonfy($v,$h===1)));};
 function printout_dump($k,$n,$v){printout($k,'dump',titled($n,dump($v)));};



/*…*/
?>
<span class="traced">
<style scoped>
pre{font-family:monospace;white-space:pre;margin:1em 0px;}

input{
-webkit-writing-mode:horizontal-tb;
-webkit-user-select:text;
box-sizing:border-box;
display:inline-block;
letter-spacing:normal;
word-spacing:normal;
text-transform:none;
text-shadow:none;
text-align:start;
text-indent:0;
cursor:auto;
}

input[type="checkbox"]{
-webkit-appearance:checkbox;
font:-webkit-small-control;
margin:3px 3px 3px 4px;
vertical-align: sub;
text-align:center;
}


.folding.control:not(:checked):after{font-size:1em;color:#7C7C7C;content:"+";position:relative;bottom:.16em;right:.1em;}
.folding.control:not(:checked){box-shadow: inset 0 0 6px #fff,inset 1px 1px 22px #fff;}
.folding.control:not(:checked)+ .data > .name > .colon,
.folding.control:not(:checked)+ .data > .value{display:none;}



</style>
<pre>
<?php
 printout_json(1,'$params',$params,1);
 printout_json(1,'$partner',$partner);
 printout_json(1,'$campaign',$campaign);

/*…*/

 printout_dump(1,'defined variables',array_slice(get_defined_vars(),$defined+1));
 $defined=get_defined_constants(true);
 printout_dump(1,'defined constant["user"]',$defined['user']);
 unset($defined);
?>
</pre>
</span>
<?php
};//end:debug
?>



<!--
<?php
/*
&emsp;

  //$h=($L.'<!--'.$L.print_r($o,true).$L.'-->'.$L);
'<!--'.$L.print_r($o,true).$L.'-->';





 printout_json('$params',$params);
 printout_json('$campaign',$campaign);
 printout_json('$partner',$partner);

 $defined=array('$params','$campaign','$partner');
 foreach($defined as $i){printout_json($i,eval($i));};
 unset($defined);


print_r(parse_url(pageurl));

empty($o)?'':
 var_dump($m);
$ƒ=function($m){};

$ƒ();unset($ƒ);

function CloneArray($o){return array_slice($o,0,count($o));};//

, …
*/
?>
-->
