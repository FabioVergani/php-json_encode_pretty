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
