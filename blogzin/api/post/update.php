<?php

if($_SERVER["REQUEST_METHOD"]!="PUT"){
    die("{\"mensagem\":\"Método inválido\"}"); 
}

include_once "../../config/conexao.php";
include_once "../../model/categoria.php";

$objRecebido = json_decode(file_get_contents("php://input"));


$db = new Conexao();
$categoria = new Categoria($db->getConexao());

try{
    $response = $categoria->update($objRecebido->id, $objRecebido->titulo, $objRecebido->texto, $objRecebido->idCategoria);
    http_response_code(200);
    echo $response;
}catch(Error $e){
    echo "Erro: ".$e;
}