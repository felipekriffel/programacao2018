<?php
    class Categoria{    
    public $id;
    public $nome;
    public $descricao;
    private $conexao;

    public function __construct($con){
        $this->conexao = $con;
    }

    public function read($id=null){
        if(isset($id)){
            $query = "SELECT id_categoria, nome_categoria, descricao FROM categoria WHERE id_categoria = :id ORDER BY nome_categoria";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam('id',$id);
        }else{
            $query = "SELECT id_categoria, nome_categoria, descricao FROM categoria ORDER BY nome_categoria";
            $stmt = $this->conexao->prepare($query);            
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($nome=null, $descricao=null){
        $query = "INSERT INTO categoria(nome_categoria, descricao) VALUES (:nome, :descricao)";
        $stmt = $this->conexao->prepare($query);
        if(isset($nome)&&isset($descricao)){
            $result = $stmt->execute([
                "nome" => $nome,
                "descricao" => $descricao
            ]);
        }else{
            if(empty($this->nome)||empty($this->descricao))
                throw new Exception("É necessário definir o nome e a descricao da categoria");
            $result = $stmt->execute([
                "nome" => $this->nome,
                "descricao" => $this->descricao
            ]);
        }
        return $result;
    }

    public function update($id, $nome, $descricao){
        $query = "UPDATE categoria SET nome_categoria = :nome, descricao =:descricao WHERE id_categoria=:id";
        $stmt = $this->conexao->prepare($query);
        $result = $stmt->execute([
            "id" => $id,
            "nome" => $nome,
            "descricao" => $descricao
        ]);
        return $result;
    }

    public function delete($id){
        $query = "DELETE FROM categoria WHERE id_categoria = :id";
        $stmt = $this->conexao->prepare($query);
        $result = $stmt->execute([
            "id" => $id
        ]);
        return $result;
    }

    public function setAttributes($nome,$descricao){
        $this->nome = $nome;
        $this->descricao = $descricao;
    }
}