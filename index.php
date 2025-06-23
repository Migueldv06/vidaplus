<?php
include "config.php";
session_start();
function alreadyLogged($role)
{
  header("Location: $role/main.php");
  exit();
}

function autenticar($DB, $tabela, $cpf, $senha, $role)
{
  $stmt = $DB->prepare("SELECT * FROM $tabela WHERE cpf = ?");
  $stmt->bind_param("s", $cpf);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    if (password_verify($senha, $usuario['senha'])) {
      $_SESSION['id'] = $usuario['id'];
      $_SESSION['nome'] = $usuario['nome'];
      $_SESSION['role'] = $role;
      header("Location: $role/main.php");
      exit();
    }
  }
}

if (isset($_SESSION['role'])) {
  alreadyLogged($_SESSION['role']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $cpf_pontuado = $_POST['cpf'];
  $senha = $_POST['senha'];
  $cpf = preg_replace('/\D/', '', $cpf_pontuado);
  autenticar($DB, 'admin', $cpf, $senha, 'admin');
  autenticar($DB, 'medico', $cpf, $senha, 'medico');
  autenticar($DB, 'recepcionista', $cpf, $senha, 'recepcionista');
  autenticar($DB, 'cliente', $cpf, $senha, 'cliente');
  echo "<script>alert('CPF ou senha incorretos.');</script>";
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="styles/index.css" />
  <title>Login - Sistema de Saúde</title>
</head>

<body>
  <header class="header">
    <a href="index.php"><img src="img/vidaplus.png" alt="Logo Vida+" class="logo-small" /></a>
    <div class="title">Vida+</div>
  </header>

  <main class="login-container">
    <h2>Sistema de Saúde</h2>
    <form action="" method="post">
      <img src="img/vidaplus.png" alt="Logo Vida+" class="logo" />
      <div class="form-group">
        <label for="cpf">CPF</label>
        <input type="text" id="cpf" name="cpf" maxlength="14" required />
      </div>
      <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" required />
      </div>
      <button type="submit" class="login-btn">Entrar</button>
    </form>

    <div class="register">
      <p>Não tem uma conta?</p>
      <a href="cadastrar.php" class="register-btn">Criar cadastro</a>
    </div>

    <div class="footer">
      © 2025 Sistema Vida+
    </div>
  </main>

  <footer>
    <h2>Contato com o Suporte</h2>
    <p>Para dúvidas ou informações, entre em contato pelo e-mail
      <a href="mailto:suporte@vidaplus.com.br">suporte@vidaplus.com.br</a> ou telefone (21) 4002-8922.
    </p>
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const cpfInput = document.getElementById("cpf");

      cpfInput.addEventListener("input", function () {
        let value = cpfInput.value.replace(/\D/g, "");
        if (value.length > 11) value = value.slice(0, 11);
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d)/, "$1.$2");
        value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
        cpfInput.value = value;
      });
    });
  </script>
</body>

</html>