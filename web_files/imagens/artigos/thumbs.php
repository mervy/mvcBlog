<?php

// Variables
$filename = $_GET['i'];
$newwidth = $_GET['w'];
$newheight = $_GET['h'];

//Verificando o formato da imagem com base na extensão
$image_type = strstr($filename, '.');
switch ($image_type) {
    case '.jpg':
        $source = imagecreatefromjpeg($filename);
        break;
    case '.jpeg':
        $source = imagecreatefromjpeg($filename);
        break;
    case '.png':
        $source = imagecreatefrompng($filename);
        break;
    case '.gif':
        $source = imagecreatefromgif($filename);
        break;
    default:
        echo("Error Invalid Image Type");
        die;
        break;
}
$percent = 1.0;

// Cabeçalho que ira definir a saida da pagina
header('Content-type: image/jpeg');

// pegando as dimensoes reais da imagem, largura e altura
list($width, $height) = getimagesize($filename);

//setando a largura da miniatura
$new_width = $newwidth;
//setando a altura da miniatura
$new_height = $newheight;

//gerando a a miniatura da imagem
$image_p = imagecreatetruecolor($new_width, $new_height);
//$source foi gerado lá em cima
imagecopyresampled($image_p, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

//o 3º argumento é a qualidade da imagem de 0 a 100
imagejpeg($image_p, null, 100);
imagedestroy($image_p);