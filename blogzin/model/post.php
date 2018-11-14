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


    public function read($idPost=null){
        if(isset($idPost)){
            $query = "SELECT p.titulo_post, p.texto_post, p.id_categoria, c.nome_categoria FROM post p 
                INNER JOIN categoria c
                ON p.id_categoria = c.id_categoria
                WHERE p.id_post = :id";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam("id",$idPost);
        }else{
            $query = "SELECT p.id_post, p.titulo_post, p.texto_post, p.id_categoria, c.nome_categoria FROM post p
            INNER JOIN categoria c
            ON p.id_categoria = c.id_categoria
            ORDER BY p.id_post DESC";
            $stmt = $this->conexao->prepare($query);
        }

        $result = $stmt->execute();

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
        return $result;
    }

    public function create($titulo=null, $texto=null, $categoria=null){
        $query = "INSERT INTO post(titulo_post, texto_post, id_categoria) VALUES(:titulo, :texto, :idCategoria)";

        $stmt = $this->conexao->prepare($query);

        if(isset($titulo)&&isset($texto)&&isset($categoria)){
            $result = $stmt->execute([
                "titulo" => $titulo,
                "texto" => $texto,
                "idCategoria" => $categoria
            ]);
        }else{
            print $this->titulo;
            print $this->texto;
            print $this->idCategoria;
            if(empty($this->titulo)||empty($this->texto)||empty($this->idCategoria))
                throw new Exception("É necessário definir o título, o texto e a categoria do post");
            $result = $stmt->execute([
                "titulo" => $this->titulo,
                "texto" => $this->texto,
                "idCategoria" => $this->idCategoria
            ]);    
        }

        return $result;
    }

    public function setAttributes($titulo, $texto, $categoria){
        $this->titulo = $titulo;
        $this->texto = $texto;
        $this->idCategoria = $categoria;
    }

    public function update($id, $titulo, $texto, $idCategoria){
        $query = "UPDATE post SET titulo_post = :titulo, texto_post = :texto, id_categoria = :idCategoria WHERE id_post = :id";
        $stmt = $this->conexao->prepare($query);
        $result = $stmt->execute([
            "id" => $id,
            "titulo" => $titulo,
            "texto" => $texto,
            "idCategoria" => $idCategoria
        ]);
        
        return $result;
    }

    public function delete($id){
        $query = "DELETE FROM post WHERE id_post = :id";
        $stmt = $this->conexao->prepare($query);
        $result = $stmt->execute([
            "id" => $id
        ]);
        return $result;
    }
}