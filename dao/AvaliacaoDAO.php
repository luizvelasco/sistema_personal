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

            $avaliacoes = [];

            $query = "SELECT * FROM avaliacoes WHERE aluno_id = :aluno_id ORDER BY data_avaliacao DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":aluno_id", $aluno_id);
            $stmt->execute();

            $avaliacaoArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($avaliacaoArray as $avaliacao) {
                $avaliacoes[] = $this->buildAvaliacao($avaliacao);
            }

            return $avaliacoes;

        }

        public function create(Avaliacao $avaliacao) {

            $stmt = $this->conn->prepare("INSERT INTO avaliacoes (
                aluno_id, data_avaliacao, peso, percentual_gordura, percentual_massa_magra, observacoes
            ) VALUES (
                :aluno_id, :data_avaliacao, :peso, :percentual_gordura, :percentual_massa_magra, :observacoes
            )");

            $stmt->bindParam(":aluno_id", $avaliacao->aluno_id);
            $stmt->bindParam(":data_avaliacao", $avaliacao->data_avaliacao);
            $stmt->bindParam(":peso", $avaliacao->peso);
            $stmt->bindParam(":percentual_gordura", $avaliacao->percentual_gordura);
            $stmt->bindParam(":percentual_massa_magra", $avaliacao->percentual_massa_magra);
            $stmt->bindParam(":observacoes", $avaliacao->observacoes);

            $stmt->execute();

            // Mensagem de sucesso por adicionar avaliação
            $this->message->setMessage("Avaliação adicionada com sucesso", "success", "avaliacao_dashboard.php?aluno_id=" . $avaliacao->aluno_id);

        }

    }
