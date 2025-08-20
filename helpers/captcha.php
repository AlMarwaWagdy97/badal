<?php

$code = rand('10000', '99999');
$_SESSION['captcha'] = $code;
$image = imagecreate(200, 70);
$bg = imagecolorallocatealpha($image, 100, 100, 100, 0);
$black = imagecolorallocate($image, 0, 0, 0);
$white = imagecolorallocate($image, 255, 255, 255);
$gray = imagecolorallocatealpha($image, 110, 110, 110, 0);
imagettftext($image, 66, 0, 10, 70, $gray, APPROOT . '/public/templates/default/css/fonts/ae_AlHor.ttf', '@#0% +');
imagettftext($image, 36, 0, 30, 50, $white, APPROOT . '/public/templates/default/css/fonts/ae_AlHor.ttf', $code);
header('Content-Type: image/png');
imagepng($image);
