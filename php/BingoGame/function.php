<?php
# NUm이 잘 표시될수 있도록 html에 표시(탈출함수)
function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

 ?>
