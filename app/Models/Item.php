<?php
class Item {
    private $conn;

    public function __construct($conexao) {
        $this->conn = $conexao;
    }

    /**
     * Insere um item no banco de dados
     */
    public function cadastrar(
        $nome,
        $descricao,
        $descricao_curta,
        $situacao,
        $cor,
        $foto,
        $data = null,
        $hora = null,
        $pergunta = '',
        $achador = ''
    ) {
        $sql = "INSERT INTO itens 
            (nome, descricao, descricao_curta, situacao, cor_predominante, foto, data_encontrado, horario_aproximado, pergunta_especifica, nome_de_quem_achou)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($this->conn, $sql);
        if ($stmt === false) {
            throw new Exception("Erro na preparação da query: " . mysqli_error($this->conn));
        }

        // Para data e hora, enviar NULL se não preenchido
        $bind_data = $data ?: null;
        $bind_hora = $hora ?: null;

        mysqli_stmt_bind_param(
            $stmt,
            'ssssssssss',
            $nome,
            $descricao,
            $descricao_curta,
            $situacao,
            $cor,
            $foto,
            $bind_data,
            $bind_hora,
            $pergunta,
            $achador
        );

        $resultado = mysqli_stmt_execute($stmt);
        if (!$resultado) {
            throw new Exception("Erro ao cadastrar item: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);

        return true;
    }
}
