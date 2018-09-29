<?php

class Post{
    public $id;
    public $titulo;
    public $texto;
    private $conexao;
    public $idCategoria;
    
    public function __construct($conection){        
        $this->conexao = $conection;
    }


    public function read($idPost){
        $query = "SELECT id_post, titulo_post, texto_post, id_categoria FROM post WHERE id_post = :id";

        $stmt = $this->conexao->prepare($query);
        $result = $stmt->execute([
            "id" => $idPost
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readFromCategoria($idCategoria){
        $query = "SELECT p.id_post, p.titulo_post, p.texto_post FROM post p
            INNER JOIN categoria c ON
                p.id_categoria = c.id_categoria
        WHERE c.id_categoria = :id";

        $stmt = $this->conexao->prepare($query);
        $stmt->execute([
            "id" => $idCategoria
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($titulo=null, $texto=null, $categoria=null){
        $query = "INSERT INTO post(titulo_post, texto_post, id_categoria) VALUES(:titulo, :texto, :idCategoria)";

        $stmt = $this->conexao->prepare($query);

        if(isset($titulo)&&isset($texto)&&isset($categoria)){
            $stmt->execute([
                "titulo" => $titulo,
                "texto" => $texto,
                "idCategoria" => $categoria
            ]);
        }else{
            if(empty($this->titulo)||empty($this->texto)||empty($this->idCategoria))
                throw new Exception("É necessário definir o título, o texto e a categoria do post");
            $stmt->execute([
                "titulo" => $this->titulo,
                "texto" => $this->texto,
                "idCategoria" => $this->idCategoria
            ]);    
        }

        return "Cadastrado com sucesso";
    }

    public function setAttributes($titulo, $texto, $categoria){
        $this->titulo = $titulo;
        $this->$texto = $texto;
        $this->$idCategoria = $categoria;
    }

    public function update(){

    }

    public function delete(){

    }
}