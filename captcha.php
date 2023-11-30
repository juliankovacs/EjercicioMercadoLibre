<?php
session_start();

function randomText($length) {
    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
    $key = '';
    for ($i = 0; $i < $length; $i++) {
        $key .= $pattern[rand(0, 35)];
    }
    return $key;
}

$_SESSION['captcha'] = randomText(5); // Se genera un captcha aleatorio y se almacena en la sesión
$captcha = imagecreatefromgif("fondo.gif");
$colText = imagecolorallocate($captcha, 0, 0, 0);
imagestring($captcha, 5, 16, 7, $_SESSION['captcha'], $colText); // El captcha se agrega a la imagen

header("Content-type: image/gif");
imagegif($captcha);
?>
