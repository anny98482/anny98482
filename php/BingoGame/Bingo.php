<?php

namespace MyApp;

class Bingo{

  public function create() {
    $nums = [];

    for ($i=0; $i < 5 ; $i++) { //i : 0~4표현가능
      $col = range($i * 15 + 1, $i * 15 + 15); // 범위의 변수 만들어주기
      shuffle($col);  //범위의 변수에서 랜덤
      $nums[$i] = array_slice($col, 0, 5); // 큰배열에서 랜덤으로 몇개를 잘라올때(0부터 5개 잘라오기!)
    }

    $nums[2][2] = "FREE"; //i행2번, j열2번은 "FREE"라는 글자로!!
    return $nums;
  }


}
