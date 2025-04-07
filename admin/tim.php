<?php

require 'vendor/autoload.php';

use Intervention\Image\ImageManager;

// Criar o gerenciador de imagem com o driver desejado
$manager = new ImageManager(array('driver' => 'gd'));  // ou 'imagick'

// Obter os parâmetros da URL
$src = $_GET['src'];  // O caminho relativo da imagem
$width = isset($_GET['w']) ? (int)$_GET['w'] : 100;  // Largura padrão se não especificada
$height = isset($_GET['h']) ? (int)$_GET['h'] : 100;  // Altura padrão se não especificada

// Caminho completo para a imagem na pasta uploads
$path = __DIR__ . '/uploads/' . $src;

// Verificar se a imagem existe, caso contrário usar imagem padrão
if (!file_exists($path)) {
    $path = __DIR__ . '/_img/no_image.jpg';  // Caminho para a imagem padrão
}

try {
    // Carregar a imagem
    $image = $manager->make($path);

    // Redimensionar a imagem conforme especificado
    $image->fit($width, $height);

    // Definir cabeçalho para o tipo de conteúdo e exibir a imagem
    header("Content-Type: image/jpeg");
    echo $image->encode('jpg', 80); // O segundo parâmetro é a qualidade da imagem

} catch (Exception $e) {
    // Caso ocorra algum erro, exibir uma mensagem ou uma imagem de erro
    header("HTTP/1.0 404 Not Found");
    echo "Erro ao processar a imagem: " . $e->getMessage();
}
