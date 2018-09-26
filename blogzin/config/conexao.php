<?php
class Conexao{
    private $host = 'localhost';
    private $dbname = 'blogzin';
    private $user = 'postgres';
    private $pass = 'root';
    private $conexao;

    public function getConexao(){
        $this->conexao = null;
        try{
            $this->conexao = new PDO('pgsql: host='.$this->host.';dbname='.$this->dbname,$this->user,$this->pass);
        }catch(PDOException $e){
            echo "Erro de conexão: ".$e;
        }
        return $this->conexao;
    }
}