<?php

// Função para encriptar um texto
function criptografar($texto) {
    $resultado = "";
    for ($i = 0; $i < strlen($texto); $i++) {
        $ascii = ord($texto[$i]); // Obtém o código ASCII do caractere
        $resultado .= str_pad($ascii, 6, "0", STR_PAD_LEFT); // Adiciona a sequência de 6 dígitos
    }
    return $resultado;
}

// Função para decriptografar um texto
function descriptografar($texto) {
    $resultado = "";
    $textoLength = strlen($texto);
    // Faz o loop para ler cada bloco de 6 números
    for ($i = 0; $i < $textoLength; $i += 6) {
        $ascii = substr($texto, $i, 6); // Pega 6 caracteres de cada vez
        $resultado .= chr((int)$ascii); // Converte para o caractere usando o valor ASCII
    }
    return $resultado;
}

// Função para ler o conteúdo do arquivo
function lerArquivo($nomeArquivo) {
    if (!file_exists($nomeArquivo)) {
        die("Arquivo não encontrado: $nomeArquivo");
    }
    return file_get_contents($nomeArquivo);
}

// Função para salvar o conteúdo no arquivo
function salvarArquivo($nomeArquivo, $conteudo) {
    file_put_contents($nomeArquivo, $conteudo);
}

// Verificando se o arquivo foi enviado via formulário
if (isset($_FILES['arquivo'])) {
    // Recebe o arquivo enviado
    $arquivo = $_FILES['arquivo'];

    // Definindo o nome do arquivo de entrada
    $nomeArquivoEntrada = $arquivo['tmp_name']; // Arquivo enviado temporariamente

    // Ler o conteúdo do arquivo
    $conteudoArquivo = lerArquivo($nomeArquivoEntrada);

    // Escolha de criptografar ou descriptografar
    $opcao = isset($_POST['opcao']) ? $_POST['opcao'] : 'criptografar'; // Pode ser 'criptografar' ou 'descriptografar'

    // Se for para criptografar
    if ($opcao == 'criptografar') {
        $conteudoCriptografado = criptografar($conteudoArquivo);
        $nomeArquivoCriptografado = 'arquivo_criptografado.txt'; // Arquivo para salvar o texto criptografado
        salvarArquivo($nomeArquivoCriptografado, $conteudoCriptografado);
        echo "Conteúdo criptografado foi salvo em '$nomeArquivoCriptografado'.";
    }
    // Se for para descriptografar
    else if ($opcao == 'descriptografar') {
        $conteudoDescriptografado = descriptografar($conteudoArquivo);
        $nomeArquivoDescriptografado = 'arquivo_descriptografado.txt'; // Arquivo para salvar o texto descriptografado
        salvarArquivo($nomeArquivoDescriptografado, $conteudoDescriptografado);
        echo "Conteúdo descriptografado foi salvo em '$nomeArquivoDescriptografado'.";
    }
} else {
    echo "Nenhum arquivo enviado.";
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criptografar ou Descriptografar Arquivo</title>
</head>
<body>

    <h2>Escolha um arquivo para criptografar ou descriptografar</h2>

    <!-- Formulário para envio do arquivo -->
    <form method="POST" enctype="multipart/form-data">
        <label for="arquivo">Escolha um arquivo:</label>
        <input type="file" name="arquivo" id="arquivo" required><br><br>

        <label for="opcao">Escolha a ação:</label><br>
        <input type="radio" name="opcao" value="criptografar" checked> Criptografar<br>
        <input type="radio" name="opcao" value="descriptografar"> Descriptografar<br><br>

        <input type="submit" value="Enviar Arquivo">
    </form>

</body>
</html>
