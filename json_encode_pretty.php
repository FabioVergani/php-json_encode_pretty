 define(space,chr(0x0020));

 function dump(&$o){
  $r='';
  if(!empty($o)){
   $r='<ul>';
   foreach($o as $p => $v){
    $c=(empty($v)?(space.'class="'.$v===0?'zero':'empty'.'"'):'');
    if(is_array($v)||is_object($v)){
     $r.=('<ul'.$c.'><strong>'.$p.'</strong>:<div>'.dump($v).'</div></ul>');
    }else{
     $r.=('<li'.$c.'><b class="key">'.$p.'</b>:&emsp;'.$v.'</li>');
    };
   };
   $r.='</ul>';
  };
  return $r;
 };

 function json_pretty($json){
  $r='';
  if(!empty($json)){
   $a=preg_split('|([\{\}\]\[,])|', $json, -1, PREG_SPLIT_DELIM_CAPTURE);
   $i=0;
   $t=chr(9);//"\t";
   $n=chr(10);//"\n";
   $l=false;
   foreach($a as $s){
     if($s==''){continue;};
     $p=str_repeat($t,$i);
     if(!$l && ($s=='{'||$s=='[')){
      $i++;if(($r!='') && ($r[(strlen($r) - 1)]==$n)){$r.=$p;};$r.=($s.$n);
     }elseif(!$l && ($s=='}'||$s==']')){
      $i--;$p=str_repeat($t,$i);$r.=($n.$p.$s);
     }elseif(!$l && $s==','){
      $r.=($s.$n);
     }else{
      $r.=(($l?'':$p).$s);
      if((substr_count($s,'"') - substr_count($s,'\\"')) % 2!=0){$l=!$l;}
     };
   };
   $r.=$n;
  };
  return $r;
 };

 function nicejson($o){return json_pretty(json_encode($o));};

 function mtx($n,$v){return titled($n,stripcslashes(nicejson($v)));};


 function titled($n,$v){
  $f=preg_replace;
  $nr=$f('/\[(.*?)\]/', '<span class="square-brackets">[<i>$1</i>]</span>',$n);
  $nr=$f('/\$/', '<span class="sign dollar">&#36;</span>',$nr);
  return '<b class="key">'.$nr.'</b>:<span class="data">'.$v.'</span>';
 };
