<?php
include "protect.php";
include "../config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'];
  $sobrenome = $_POST['sobrenome'];
  $genero = $_POST['genero'];
  $cpf = preg_replace('/\D/', '', $_POST['cpf']);
  $data_nasc = $_POST['data-nascimento'];
  $email = $_POST['email'];
  $telefone = $_POST['telefone'];
  $endereco = $_POST['endereco'];
  $crm = $_POST['crm'];
  $senha = $_POST['senha'];
  $rep_senha = $_POST['rep-senha'];

  if ($senha !== $rep_senha) {
    $erro = "As senhas não coincidem.";
  } else {
    $hash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $DB->prepare("INSERT INTO medico (nome, sobrenome, genero, cpf, data_nascimento, email, telefone, endereco, crm, senha)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssss", $nome, $sobrenome, $genero, $cpf, $data_nasc, $email, $telefone, $endereco, $crm, $hash);

    if ($stmt->execute()) {
      header("Location: main.php");
      exit();
    } else {
      $erro = "Erro ao cadastrar médico: " . $stmt->error;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Criar Médico</title>
  <link rel="stylesheet" href="styles/criar-medico.css" />
</head>

<body>
  <header class="header">
    <a href="main.php"><img src="../img/vidaplus.png" alt="Logo Vida+" class="logo" /></a>
    <div class="title">Vida+</div>
    <a href="../logout.php" class="logout-button">Sair</a>
  </header>

  <div class="container">
    <h2>Cadastrar Novo Médico</h2>
    <?php if (isset($erro))
      echo "<p class='erro'>$erro</p>"; ?>

    <form method="post" id="form-medico">
      <div class="form-group">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label>Sobrenome</label>
        <input type="text" name="sobrenome" value="<?= htmlspecialchars($_POST['sobrenome'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label>Gênero</label>
        <select name="genero" required>
          <option value="Masculino" <?= ($_POST['genero'] ?? '') === 'Masculino' ? 'selected' : '' ?>>Masculino</option>
          <option value="Feminino" <?= ($_POST['genero'] ?? '') === 'Feminino' ? 'selected' : '' ?>>Feminino</option>
          <option value="Outro" <?= ($_POST['genero'] ?? '') === 'Outro' ? 'selected' : '' ?>>Outro</option>
        </select>
      </div>
      <div class="form-group">
        <label>CPF</label>
        <input type="text" id="cpf" name="cpf" maxlength="14" value="<?= htmlspecialchars($_POST['cpf'] ?? '') ?>"
          required>
      </div>
      <div class="form-group">
        <label>Data de Nascimento</label>
        <input type="date" name="data-nascimento" value="<?= htmlspecialchars($_POST['data-nascimento'] ?? '') ?>"
          required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label>Telefone</label>
        <input type="text" name="telefone" value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label>Endereço</label>
        <input type="text" name="endereco" value="<?= htmlspecialchars($_POST['endereco'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label>CRM</label>
        <input type="text" name="crm" value="<?= htmlspecialchars($_POST['crm'] ?? '') ?>" required>
      </div>
      <div class="form-group">
        <label>Senha</label>
        <input type="password" id="senha" name="senha" required>
      </div>
      <div class="form-group">
        <label>Repita a Senha</label>
        <input type="password" id="rep-senha" name="rep-senha" required>
      </div>
      <p id="erro-senha" class="erro" style="display:none;">As senhas não coincidem.</p>
      <div class="botoes">
        <button type="submit" class="btn">Salvar</button>
        <a href="main.php" class="btn cancel">Cancelar</a>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const form = document.getElementById('form-medico');
      const senha = document.getElementById('senha');
      const repSenha = document.getElementById('rep-senha');
      const erro = document.getElementById('erro-senha');

      form.addEventListener('submit', function (e) {
        if (senha.value !== repSenha.value) {
          e.preventDefault();
          erro.style.display = 'block';
        } else {
          erro.style.display = 'none';
        }
      });

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