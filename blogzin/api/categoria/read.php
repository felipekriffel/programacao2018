<?php
header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD']!="GET"){
    die("{\"mensagem\":\"Método não suportado\"}");
}

header("Content-Type: application/json");
include_once "../../config/conexao.php";
include_once "../../model/categoria.php";

$id = $_GET["id"];

$db = new Conexao();
$categoria = new Categoria($db->getConexao());

try{
    if(!empty($id)){
        echo json_encode($categoria->read($id));
    }else{
        echo json_encode($categoria->read());
    }
}catch(Exception $e){
    echo "Erro: ".$e;
}