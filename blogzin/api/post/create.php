<?php

include_once "../../config/conexao.php";
include_once "../../model/post.php";

$objRecebido = json_decode(file_get_contents("php://input"));

$db = new Conexao();
$post = new Post($db->getConexao());

try{
    print_r($objRecebido);
    $post->setAttributes($objRecebido->titulo, $objRecebido->texto, $objRecebido->idCategoria);
    $result = $post->create();
    if($result){
        echo '{\"mensagem:\":\"Cadastrado com sucesso\"}';
        http_response_code(201);
    }
    else
        echo '{\"mensagem:\":\"Erro na inserção\"}';
}catch(Exception $e){
    echo "Erro: ".$e;
}