<?php

    require_once("models/professor.php");

    class ProfressorDAO implements ProfessorDAOInterface{

        private $conn;
        private $url;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            
        }

        public function buildProfessor($data){

            $user = new Professor();

            $user->id = $data["id"];
            $user->nome = $data["nome"];
            $user->email = $data["email"];
            $user->telefone = $data["telefone"];
            $user->password = $data["password"];
            $user->token = $data["token"];
            $user->ativo = $data["ativo"];

            return $user;

        }
        public function create(Professor $professor, $authUser = false) {

        }

    }