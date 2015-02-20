<?php

function json_pretty($json){
 $a = preg_split('|([\{\}\]\[,])|', $json, -1, PREG_SPLIT_DELIM_CAPTURE);
 $r = '';
 $i = 0;
 $t = chr(9);//"\t";
 $n = chr(10);//"\n";
 $l = false;
 foreach($a as $s){
	if($s == ''){continue;};
	$p = str_repeat($t,$i);
	if(!$l && ($s == '{' || $s == '[')){
	 $i++;if(($r != '') && ($r[(strlen($r) - 1) ] == $n)){$r.= $p;};$r.=($s.$n);
	}elseif(!$l && ($s == '}' || $s == ']')){
	 $i--;$p = str_repeat($t,$i);$r.=($n.$p.$s);
	}elseif(!$l && $s == ','){
	 $r.=($s.$n);
	}else{
	 $r.=(($l ? '' : $p).$s);
	 if((substr_count($s,'"') - substr_count($s,'\\"')) % 2 != 0){$l = !$l;}
	};
 };
 return $r;
};
//

function json_encode_pretty($obj){return json_pretty(json_encode($obj));};
//

function printf_pre($x){return printf('<pre class="print">%s</pre>',$x);};
//

die('');
?>
