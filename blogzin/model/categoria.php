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
        if(isset($nome)||isset($descricao)){
            $stmt->execute([
                "nome" => $nome,
                "descricao" => $descricao
            ]);
        }else{
            if(empty($this->nome)||empty($this->descricao))
                throw new Exception("É necessário definir o nome e a descricao da categoria");
            $stmt->execute([
                "nome" => $this->nome,
                "descricao" => $this->descricao
            ]);
        }
        return "Deu bom coroi";
        http_response_code(201);
    }

    public function update($id, $nome=null, $descricao=null){
        $query = "UPDATE categoria SET nome_categoria = :nome, descricao =:descricao WHERE id_categoria=:id";
        $stmt = $this->conexao->prepare($query);
        $result = $stmt->execute([
            "id" => $id,
            "nome" => $nome,
            "descricao" => $descricao
        ]);
        return "Atualizado com sucesso";
    }

    public function delete($id){
        $query = "DELETE FROM categoria WHERE id_categoria = :id";
        $stmt = $this->conexao->prepare($query);
        $result = $stmt->execute([
            "id" => $id
        ]);
        return "Deletado com sucesso";
    }

    public function setNomeDescricao($nome,$descricao){
        $this->nome = $nome;
        $this->descricao = $descricao;
    }
}