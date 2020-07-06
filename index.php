<?php

session_start();

ini_set('display_errors', 1);//오류메세지 설정 -> html로 표시해줌 
define('MAX_FILE_SIZE', 1 * 1024 * 1024); //1024KB * 1024 = 1MB
define('THUMBNAIL_WIDTH', 400); //썸네일 만들때의 임계값이 되는 폭
define('IMAGES_DIR', __DIR__ . '/images'); //이미지를 넣어두는 디렉토리 
define('THUMBNAIL_DIR', __DIR__ . '/thumbs'); //썸네일을 넣어두는 디렉토리 

#image를 처리하기 위한 GD 라는 플러그인 필요 / GD : 그래픽을 취급하기 위한 라이브러리
if(!function_exists('imagecreatetruecolor')){// GD라는 플러그인이 있는지 'imagecreatetruecolor' 함수로 체크
  echo 'GD not installed'; 
  exit;
}

# HTML환경에서의 문자로 전환하는 탈출문
function h($s){
  return htmlspecialchars($s, ENT_QUOTES,'UTF-8');
}

require 'ImageUploader.php';

# uploader라는 인스턴스 제작 
$uploader = new \MyApp\ImageUploader(); // MyApp이라는 네임스페이스를 이용

# $uploader 업로드 작업의 양식이 게시되었을때 호출되는 것
if($_SERVER['REQUEST_METHOD'] === 'POST'){ // 미리 정의 된 상수가 있고, REQUEST_METHOD가 POST라면 form POST가되었다는 의미
  $uploader->upload();
}

# getResults() : 그 메소드의 반환 값으로서, 배열이 잘 되었을때의 메시지와 오류메시지를 반환하기 위해서 list에서 한번에 받아주기.
list($success, $error) = $uploader->getResults();
#$uploader = 사진을 취득해 두는 메소드
$images = $uploader->getImages();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Image Uploader</title>
  <style>
  body{
    text-align : center;
    font-family : Arial, sans-serif;
  }
  ul{
    list-style:none;
    margin : 0;
    padding : 0;
  }
  li{
    margin-bottom:5px;
  }
  input[type=file]{
    position: absolute; /*문서의 원래 위치와 상관없이 위치 지정 가능 */
    top:0;
    left:0;
    width:100%;
    height:100%;
    cursor : pointer; /* 버튼을 클릭할 수 있는 느낌 */
    opacity:0; /* 투명하게 */
  }
  /*부모요소 */
  .btn{
    position:relative;  /*위치 계산시 static의 원래위치부터 계산 */
    display:inline-block;
    width:300px;
    padding:7px;
    border-radius:5px;
    margin:10px auto 20px;
    color :#fff;
    box-shadow: 0 4px #0088cc;
    background: #00aaff;
  }
  /*버튼 주위를 멤돌때 */
  .btn:hover{
    opacity: 0.8; /*얇아지게 */
  }
  .msg{
    margin: 0 auto 15px;
    width: 400px;
    font-weight: bold;
  }
  .msg.success{
    color:#4caf50;  /*녹색 */
  }
  .msg.error{
    color:#f44336;  /*적색 */
  }
  </style>
</head>
<body>

  <div class="btn">
  Upload!
  <form action="" method="post" enctype="multipart/form-data" id="my_form">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>">
    <input type="file" name="image" id="my_file">
  </form>
  </div>
  <!-- $getResults의 반환값이 $sucess이면 표시 -->
  <?php if (isset($success)): ?>
    <div class="msg success"><?php echo h($success); ?></div>
  <?php endif; ?>
  <!-- $getResults의 반환값이 $error이면 표시 -->
  <?php if (isset($error)): ?>
    <div class="msg error"><?php echo h($error); ?></div>
  <?php endif; ?>

  <ul>
    <?php foreach($images as $image): ?>
    <li>
      <a href="<?php echo h(basename(IMAGES_DIR)) . '/' . h(basename($image)); ?>"> <!-- 이미지 링크(폴더명) -->
        <img src="<?php echo h($image); ?>">  <!-- 이미지 소스 -->
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
  <script>
    $(function () {
      $('.msg').fadeOut(3000);  // '.msg'를 지움
      $('#my_file').on('change', function(){// #my_file의 내용이 송신되면 다음 명령을 실행하시오.
        $('#my_form').submit();
      });
    });
  </script>

</body>
</html>



