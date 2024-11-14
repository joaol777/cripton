<?php
// Incluindo o arquivo bd.php que contém o mapeamento de caracteres
$mapa = require 'bd.php';

// Invertendo o mapa para buscar os códigos de 6 dígitos
$mapaInvertido = array_flip($mapa);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['arquivo'])) {
    $arquivo = $_FILES['arquivo']['tmp_name'];
    $conteudoCriptografado = file_get_contents($arquivo);

    $conteudoOriginal = '';
    for ($i = 0; $i < strlen($conteudoCriptografado); $i += 6) {
        $codigo = substr($conteudoCriptografado, $i, 6);

        // Verifica se o código existe no mapa invertido
        if (isset($mapaInvertido[$codigo])) {
            $conteudoOriginal .= $mapaInvertido[$codigo];
        } else {
            $conteudoOriginal .= '?';  // Caso não encontre o código, insere um caractere de erro
        }
    }

    $novoArquivo = 'desencriptado.txt';
    file_put_contents($novoArquivo, $conteudoOriginal);

    echo "Arquivo desencriptado com sucesso! <a href='$novoArquivo' download>Baixar arquivo desencriptado</a>";
} else {
    echo "Nenhum arquivo foi enviado!";
}
