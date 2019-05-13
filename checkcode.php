<?php

header("Access-Control-Allow-Origin:http://localhost:8080");
header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");
header('Content-Type:application/json; charset=utf-8');
session_start();
// 生成一张图片
header('Content-type: image/png');

$image = imagecreatetruecolor(150, 40);
$bgcolor = imagecolorallocate($image, 45, 19, 31);
imagefill($image, 0, 0, $bgcolor);

$codestr = 'ABCDEFGHJKLMNPQRSTUVWXY3456789';
$strlen = strlen($codestr);

$authcode = '';

for($i = 1; $i <= 4; $i++) {
    $text = $codestr[rand(0, $strlen-1)];
    $authcode .= $text;
    $textcolor = imagecolorallocate($image, rand(150, 255), rand(150, 255), rand(150, 255));
    $x = $i * (150 - 50) / 4;
    $y = 30;
    imagettftext($image, 26, rand(-15, 15), $x, $y, $textcolor, './FZPHTJW.TTF', $text);
}

$_SESSION['authcode'] = $authcode;

for($i = 1; $i <= 1000; $i++) {
    $pixelcolor = imagecolorallocate($image, rand(150, 255), rand(150, 255), rand(150, 255));
    imagesetpixel($image, rand(0, 149), rand(0, 39), $pixelcolor);
}

for($i = 1; $i <= 10; $i++) {
    $linecolor = imagecolorallocate($image, rand(150, 255), rand(150, 255), rand(150, 255));
    imageline($image, rand(0, 149), rand(0, 39), rand(0, 149), rand(0, 39), $linecolor);
}

imagepng($image,"one.png");

$arr3 = array('is_success' => true,'authcode' => $authcode);
$json3 = json_encode($arr3);
exit($json3);

?>
