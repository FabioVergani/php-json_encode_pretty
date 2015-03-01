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
