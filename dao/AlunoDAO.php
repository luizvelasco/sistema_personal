<?php

    require_once("models/Aluno.php");
    require_once("models/Message.php");

    class AlunoDAO implements AlunoDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildAluno($data){

            $aluno = new Aluno();

            $aluno->id = $data["id"];
            $aluno->nome = $data["nome"];
            $aluno->email = $data["email"];
            $aluno->telefone = $data["telefone"];
            $aluno->data_nascimento = $data["data_nascimento"];
            $aluno->genero = $data["genero"];
            $aluno->foto = $data["foto"];
            $aluno->professor_id = $data["professor_id"];

        }
        public function findAll(){
            
        }

        public function create(Aluno $aluno){
            
        }

        public function update(Aluno $aluno){
            
        }

        public function destroy ($id){
            
        }

    }
