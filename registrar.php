<?php
include 'conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['id_funcionario'])) {
        die("Funcionário não está logado.");
    }

    $funcionario_id = $_SESSION['id_funcionario'];
    $matricula = $_POST['matricula'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $motivo = $_POST['motivo'];
    $email_professor = $_POST['email_professor'];

    // Verifica conexão
    if (!$conn) {
        die("Erro: Conexão com o banco de dados não foi estabelecida.");
    }

    // Buscar aluno pela matrícula
    $stmtAluno = $conn->prepare("SELECT * FROM alunos WHERE matricula = ?");
    $stmtAluno->bind_param("s", $matricula);
    $stmtAluno->execute();
    $resultAluno = $stmtAluno->get_result();
    $aluno = $resultAluno->fetch_assoc();

    if (!$aluno) {
        echo "<script>alert('Aluno não encontrado.'); window.history.back();</script>";
        exit;
    }

    // Buscar professor pelo e-mail
    $stmtProfessor = $conn->prepare("SELECT * FROM professores WHERE email = ?");
    $stmtProfessor->bind_param("s", $email_professor);
    $stmtProfessor->execute();
    $resultProfessor = $stmtProfessor->get_result();
    $professor = $resultProfessor->fetch_assoc();

    if (!$professor) {
        echo "<script>alert('Professor não encontrado.'); window.history.back();</script>";
        exit;
    }

    $dataHora = "$data $hora";

    // Inserir atraso
    $stmt = $conn->prepare("INSERT INTO atrasos (matricula, professor_id, funcionario_id, data_hora, motivo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siiss", $matricula, $professor['id_professor'], $funcionario_id, $dataHora, $motivo);

    if ($stmt->execute()) {
        echo "<script>alert('Atraso registrado com sucesso!'); window.location.href='painel.php';</script>";
    } else {
        echo "<script>alert('Erro ao registrar atraso: " . $stmt->error . "'); window.history.back();</script>";
    }
}
?>
