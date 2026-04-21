<?php
session_start();
require 'conexao.php';

if (isset($_POST['create_professor'])) {
    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

    if (empty($nome) || empty($email) || empty($data_nascimento) || empty($senha)) {
        $_SESSION['mensagem'] = 'Preencha todos os campos!';
        header('Location: create.php');
        exit;
    }

    $senha = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO professores (nome, email, data_nascimento, senha) 
            VALUES ('$nome', '$email', '$data_nascimento', '$senha')";

    mysqli_query($conexao, $sql);

    if (mysqli_affected_rows($conexao) > 0) {
        $_SESSION['mensagem'] = 'Professor criado com sucesso';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['mensagem'] = 'Professor não foi criado';
        header('Location: index.php');
        exit;
    }
}

if (isset($_POST['update_professor'])) {
    $professor_id = mysqli_real_escape_string($conexao, $_POST['professor_id']);

    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

    if (empty($nome) || empty($email) || empty($data_nascimento)) {
        $_SESSION['mensagem'] = 'Preencha os campos obrigatórios';
        header('Location: professor-edit.php?id=' . $professor_id);
        exit;
    }
    $sql = "UPDATE professores 
        SET nome = '$nome', 
            email = '$email', 
            data_nascimento = '$data_nascimento'";

    if (!empty($senha)) {
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql .= ", senha = '$senha'";
    }

    $sql .= " WHERE id = '$professor_id'";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = 'Professor atualizado com sucesso';
    } else {
        $_SESSION['mensagem'] = 'Erro ao atualizar';
    }

    header('Location: index.php');
    exit;
}

if (isset($_POST['delete_professor'])) {

    $professor_id = mysqli_real_escape_string($conexao, $_POST['delete_professor']);

    $sql = "DELETE FROM professores WHERE id = '$professor_id'";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = 'Professor deletado com sucesso';
    } else {
        $_SESSION['mensagem'] = 'Professor não foi deletado';
    }

    header('Location: index.php');
    exit;
}
