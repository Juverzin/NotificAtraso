<?php
include ('conexao.php');

if (isset($_POST['cpf']) || isset($_POST['senha'])) {

    if(strlen($_POST['cpf']) == 0){
        echo "<script>
                 alert('Preencha seu CPF');
                   window.history.back(); // volta para a página anterior
                 </script>";
    } else if(strlen($_POST['senha']) == 0){
        echo "<script>
                 alert('Preencha sua senha');
                   window.history.back(); // volta para a página anterior
                 </script>";
    } else {
        $cpf = $mysqli->real_escape_string($_POST['cpf']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM funcionarios WHERE cpf = '$cpf' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL." . $mysqli->error);

        $quantidade = $sql_query->num_rows;

        if($quantidade == 1){
            $funcionario = $sql_query->fetch_assoc();

            if(!isset($_SESSION)){
                session_start();
            }


            $_SESSION['id_funcionario'] = $funcionario['id_funcionario'];
            $_SESSION['nome'] = $funcionario['nome'];

            header("Location: painel.php");
        } else {
            echo "<script>
                 alert('Usuario ou senha incorretos');
                   window.history.back(); // volta para a página anterior
                 </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NotificAtraso - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: hsl(48, 93%, 83%);
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        .bg-warning {
            background-color: #f6c300 !important;
        }

        h2, h3 {
            color: #fff;
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .btn-warning {
            border-color: #f6c300;
            font-size: 1.1rem;
        }

        .btn-warning:hover {
            background-color: #e5b200;
            border-color: #e5b200;
        }

        a {
            color: #f6c300;
        }

        a:hover {
            color: #e5b200;
        }

    </style>
</head>
<body>

    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-5 shadow-lg w-100" style="max-width: 1100px;">
            <div class="row g-0">
                <!-- Coluna da logo -->
                <div class="col-md-5 d-flex flex-column align-items-center justify-content-center text-center">
                    <img src="imgs/NotificAtraso.png" alt="NotificAtraso" class="img-fluid mb-3" style="max-width: 250px;">
                    <h2 class="fw-bold text-white">NotificAtraso</h2>
                </div>

                <!-- Coluna do formulário -->
                <div class="col-md-7 p-4">
                    <h3 class="mb-4 text-center fw-bold">Acessar o NotificAtraso</h3>
                    <form action="" method="POST">
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite seu CPF">
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha">
                        </div>
                        <button type="submit" class="btn btn-warning w-100 py-2">Login</button>

                    </form>
                    <p class="text-center text-muted mt-4">© 2024 Instituto Federal Farroupilha</p>
                </div>
            </div>
        </div>
    </div>

        

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
