<?php

    require_once("models/professor.php");
    require_once("models/Message.php");

    class ProfressorDAO implements ProfessorDAOInterface{

        private $conn;
        private $url;
        private $message;

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

         public function verifyToken($protected = false) {

            if (!empty($_SESSION["token"])){

                // Pega o token da session
                $token = $_SESSION["token"];

                $professor = $this->findByToken($token);

                if ($professor){
                    return $professor;
                } else if ($protected){

                    // redireciona usuário não autenticado
                    $this->message->setMessage("Faça a autenticação para acessar essa página", "error", "index.php");
                }
            } else if ($protected) {
                
                 // redireciona usuário não autenticado
                $this->message->setMessage("Faça a autenticação para acessar essa página", "error", "index.php");
            }
            
        }

        public function findByToken($token) {

             if($token != ""){

                $stmt = $this->conn->prepare("SELECT * FROM professores WHERE token = :token");

                $stmt->bindParam(":token", $token);

                $stmt->execute();

                if($stmt->rowCount() > 0) {

                    $data = $stmt->fetch();
                    $professor = $this->buildProfessor($data);

                    return $professor;

                } else {
                    return false;
                }
            } else {
                return false;
            }

        }

        public function destroyToken() {

            // Remove o token da session
            $_SESSION["token"] = "";

            // Redireciona e apreseta a mensagem de sucesso
            $this->message->setMessage("Voce fez o logout com sucesso", "success", "index.php");

        }

    }