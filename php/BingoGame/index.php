<?php

# require_once : index.php파일에서 외붛파일인 config.php를 불러옴.
require_once(__DIR__ . '/config.php'); // __DIR__ : 정수타입으로
require_once(__DIR__ . '/Bingo.php');

# 클래스를 어떻게 쓸것인지 정하기.
//1. 인스턴스 만들기
$bingo = new \MyApp\Bingo();  // 네임스페이스 : MyApp
$nums = $bingo->create(); //$nums는 $bingo에서 나중에 만들예정.

 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>BINGO!</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div id="container">
    <table>
      <tr>
        <th>B</th><th>I</th><th>N</th><th>G</th><th>O</th>
      </tr> <!-- i : 행  / j : 열 -->
      <?php for ($i=0; $i < 5; $i++) :?> <!-- num은 배열의 배열이므로 이중루프 사용 -->
      <tr>
        <?php for ($j=0; $j < 5; $j++) :?>
        <td><?= h($nums[$j][$i]); ?></td>
      <?php endfor; ?>
      </tr>
    <?php endfor; ?>
    </table>
  </div>
</body>
</html>
