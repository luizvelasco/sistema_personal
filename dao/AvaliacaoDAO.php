<?php

    require_once("models/Avaliacao.php");
    require_once("models/Message.php");

    class AvaliacaoDAO implements AvaliacaoDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {
            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);
        }

        public function buildAvaliacao($data){

            $avaliacao = new Avaliacao();

            $avaliacao->id = $data["id"];
            $avaliacao->aluno_id = $data["aluno_id"];
            $avaliacao->data_avaliacao = $data["data_avaliacao"];
            $avaliacao->peso = $data["peso"];
            $avaliacao->percentual_gordura = $data["percentual_gordura"];
            $avaliacao->percentual_massa_magra = $data["percentual_massa_magra"];
            $avaliacao->observacoes = $data["observacoes"];
            $avaliacao->criado_em = $data["criado_em"];
            $avaliacao->atualizado_em = $data["atualizado_em"];

            return $avaliacao;

        }

        public function getAvaliacoes($aluno_id){

            $avaliacao = [];

            $query = "SELECT * FROM avaliacoes WHERE aluno_id = :aluno_id ORDER BY data_avaliacao DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":aluno_id", $aluno_id);
            $stmt->execute();

            $avaliacaoArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($avaliacaoArray as $avaliacao) {
                $avaliacao[] = $this->buildAvaliacao($avaliacao);
            }

            return $avaliacao;

        }

    }
