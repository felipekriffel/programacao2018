<?php

//inclui classe de conexao ao banco e de categoria
include_once "../../config/conexao.php";
include_once "../../model/categoria.php";

$objRecebido = json_decode(file_get_contents("php://input"));

$db = new Conexao();
$categoria = new Categoria($db->getConexao());

try{
    $categoria->setNomeDescricao($objRecebido->nome, $objRecebido->descricao);
    $categoria->create();
    http_response_code(201);
    echo "{\"mensagem\": \"Cadastrado com sucesso\"}";
}catch(Exception $e){
    echo "Erro: ".$e;
}

// echo json_encode($objRecebido);