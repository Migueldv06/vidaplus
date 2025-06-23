<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastro - Sistema de Saúde</title>
  <link rel="stylesheet" href="styles/cadastrar.css">
</head>
<body>
  <div class="form-container">
    <h2>Cadastro de Usuário</h2>
    <form action="processa-cadastro.php" method="post">
      <div class="form-group">
        <label for="nome">Nome completo</label>
        <input type="text" id="nome" name="nome" required>
      </div>

      <div class="form-group">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" required>
      </div>

      <div class="form-group">
        <label for="usuario">Usuário</label>
        <input type="text" id="usuario" name="usuario" required>
      </div>

      <div class="form-group">
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" required>
      </div>

      <div class="form-group">
        <label for="confirmar">Confirmar senha</label>
        <input type="password" id="confirmar" name="confirmar" required>
      </div>

      <button type="submit" class="submit-btn">Cadastrar</button>

      <div class="voltar">
        <a href="login.php">Voltar para o login</a>
      </div>
    </form>
  </div>
</body>
</html>
