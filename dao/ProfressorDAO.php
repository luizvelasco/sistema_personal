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

        public function findByEmail($email) {

            if($email != ""){

                $stmt = $this->conn->prepare("SELECT * FROM professores WHERE email = :email");

                $stmt->bindParam(":email", $email);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $user = $this->buildProfessor($data);

                    return $user;

                } else {
                    return false;
                }
            } else {
                return false;
            }

        }

    }