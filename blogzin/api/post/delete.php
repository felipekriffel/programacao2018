<?php
header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD']!="DELETE"){
    die("{\"mensagem\":\"Método não suportado\"}");
}

header("Content-Type: application/json");
include_once "../../config/conexao.php";
include_once "../../model/post.php";

$objRecebido = json_decode(file_get_contents("php://input"));

$db = new Conexao();
$post = new Post($db->getConexao());

try{
    $id = $objRecebido->id;
    $response = $post->delete($id);
    http_response_code(200);
    echo $response;
}catch(Exception $e){
    echo "Erro: ".$e;
}