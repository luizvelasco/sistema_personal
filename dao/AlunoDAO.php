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
            $aluno->ativo = $data["ativo"];
            $aluno->professor_id = $data["professor_id"];

            return $aluno;

        }
        public function findAll(){
            
        }

        public function getAlunos($professor_id){

            $alunos = [];

            $query = "SELECT * FROM alunos WHERE professor_id = :professor_id ORDER BY id DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":professor_id", $professor_id);
            $stmt->execute();

            $alunosArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($alunosArray as $aluno) {
                $alunos[] = $this->buildAluno($aluno);
            }

            return $alunos;

        }

        public function create(Aluno $aluno){

            $stmt = $this->conn->prepare("INSERT INTO alunos (
                nome, email, telefone, data_nascimento, genero, foto, professor_id) 
                VALUES (:nome, :email, :telefone, :data_nascimento, :genero, :foto, :professor_id)
            ");

            $stmt->bindParam(":nome", $aluno->nome);
            $stmt->bindParam(":email", $aluno->email);
            $stmt->bindParam(":telefone", $aluno->telefone);
            $stmt->bindParam(":data_nascimento", $aluno->data_nascimento);
            $stmt->bindParam(":genero", $aluno->genero);
            $stmt->bindParam(":foto", $aluno->foto);
            $stmt->bindParam(":professor_id", $aluno->professor_id);

            $stmt->execute();

            // Mensagem de sucesso por adicionar filme
            $this->message->setMessage("Aluno adicionado com sucesso", "success", "index.php");
            
        }

        public function update(Aluno $aluno){
            
        }

        public function destroy ($id){
            
        }

    }
