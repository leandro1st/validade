<?php
require("../externo/c.php");

// lol
// function convert_case_ptbr($string) {
//     $string = mb_convert_case(trim($string), MB_CASE_TITLE, 'utf-8');
//     $delimiters = ['de ', 'do ', 'da ', 'em ', 'na ', 'no ', 'ni ', 'c/', 's/', 'p/', 'ml', 'mg', 'kg', 'para ', 'com ', 'sem ', 'como '];
//     $string = str_ireplace($delimiters, $delimiters, $string);
//     return $string;
//     //this returns lowercase (or uppercase) delimiter word found in string using those same delimiters as a case insensitive search
// }

$codigo_produto = trim($_POST['nome_produto']);
$pesquisar_nome = mysqli_query($connect, "SELECT nome FROM $produtos WHERE $id = '$codigo_produto'");
$vetor_produto = mysqli_fetch_array($pesquisar_nome);
$nome = $vetor_produto['nome'];

$data = trim($_POST['data_vencimento']);
date_default_timezone_set('America/Sao_Paulo');
$hoje = date("Y-m-d");
$hora_cadastro = date("Y-m-d H:i:s");
$pesquisar = mysqli_query($connect, "SELECT * FROM $vencimentos WHERE ($nome_produto = '$nome' AND DATE_FORMAT(validade, '%d/%m/%Y') = DATE_FORMAT('$data', '%d/%m/%Y'))");
$numero_pesquisa = mysqli_num_rows($pesquisar);

if($numero_pesquisa == 0) {
    if ($nome == "" || $data <= $hoje || $data > "2099-12-31" || $data == "0000-00-00" || $data == "") {
        echo "0";
    } else{
        $cadastrar = mysqli_query($connect, "INSERT INTO $vencimentos(nome_produto, validade, hora_cadastro) VALUES('$nome', '$data', '$hora_cadastro')");
        echo "1";
    }
} else{
    echo "Existente";
    // echo "Nome do produto: ".$nome."\nData do vencimento: ".date("d/m/Y", strtotime($data)). "\nCadastro já existe!";
}
