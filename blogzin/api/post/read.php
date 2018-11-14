<?php
header("Content-Type: application/json; charset=utf-8");

if($_SERVER['REQUEST_METHOD']!="GET"){
    die("{\"mensagem\":\"Método não suportado\"}");
}

include_once "../../config/conexao.php";
include_once "../../model/post.php";

$idPost = null;
$idCategoria = null;

if(!empty($_GET["idPost"]))$idPost = $_GET["idPost"];
if(!empty($_GET["idCategoria"]))$idCategoria = $_GET["idCategoria"];

$db = new Conexao();
$post = new Post($db->getConexao());


try{
    if(!empty($idPost)){
        echo json_encode($post->read($idPost));
    }elseif (!empty($idCategoria)) {
        echo json_encode($post->readFromCategoria($idCategoria));
    }else{
        echo json_encode($post->read());
    }
}catch(Exception $e){
    echo "Erro :".$e;
}
