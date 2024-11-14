<?php
// Incluindo o arquivo bd.php que contém o mapeamento de caracteres
$mapa = require 'bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['arquivo'])) {
    $arquivo = $_FILES['arquivo']['tmp_name'];
    $conteudo = file_get_contents($arquivo);

    $conteudoCriptografado = '';
    for ($i = 0; $i < strlen($conteudo); $i++) {
        $char = $conteudo[$i];

        // Verifica se o caractere existe no mapeamento
        if (isset($mapa[$char])) {
            $conteudoCriptografado .= $mapa[$char];
        } else {
            $conteudoCriptografado .= '000000';  // Caso não encontre o caractere, atribui um valor padrão
        }
    }

    $novoArquivo = 'criptografado.txt';
    file_put_contents($novoArquivo, $conteudoCriptografado);

    echo "Arquivo criptografado com sucesso! <a href='$novoArquivo' download>Baixar arquivo criptografado</a>";
} else {
    echo "Nenhum arquivo foi enviado!";
}
