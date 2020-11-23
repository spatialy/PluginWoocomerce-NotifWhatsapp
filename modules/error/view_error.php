<?php 

function woowa_error_log_view(){
  $script = woowa_script_error_view();
  if (get_option('woowa_license')!='active') { return ('<br>please activate license code. click <a href="#license" data-toggle="tab" aria-expanded="true">here</a>');}
  $view='';

  $errors = file(__DIR__.'/error.log');
    if(!empty($errors)){
        $view.=
        '<div style="float:left;">
        <h3>Log : </h3>
        <form method="post" id="error_log">
        <input type="hidden" name="action" value="" >';


      if (count($errors)>0) {
        if ((count($errors)-500)>=0) {
          $limit=count($errors)-5;
        }else{
          $limit=0;
        }
        for ($i=count($errors); $i >= $limit ; $i--) { 
          if(isset($errors[$i]) and !empty(trim($errors[$i]))){
            $results[$i] = strip_tags($errors[$i]);
          }
        }
      }else{
        $results=array();
      }
      $results2=$results;
      if (!empty($results2)) {
        ksort($results2);
        $y = fopen(__DIR__.'/error.log', 'w'); 
        fwrite($y,implode("", $results2));
      
        $view .= implode("</br>", $results);
        fclose($y);
    }
    $view .= '</form></div>';
    }else {
      $view.=
        '<div style="float:left;">
          <h3>Log : </h3>
          <form method="post" id="error_log">
          <input type="hidden" name="action" value="" >
          <p>Theres no log</p>
          </form>
        </div>';
    }
      return $view.$script;
}

?>