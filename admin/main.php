<?php
include "protect.php";
include "../config.php";

$id = $_SESSION['id'];

$sqlAdmin = "SELECT * FROM admin WHERE id = '$id'";
$resultAdmin = $DB->query($sqlAdmin) or die("Erro ao consultar o banco de dados: " . $DB->error);

if ($resultAdmin->num_rows > 0) {
  $admin = $resultAdmin->fetch_assoc();
} else {
  die("Administrador não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Painel do Administrador</title>
  <link rel="stylesheet" href="styles/main.css">
</head>

<body>
  <header class="header">
    <a href="main.php"><img src="../img/vidaplus.png" alt="Logo Vida+" class="logo"></a>
    <div class="title">Vida+</div>
    <a href="../logout.php" class="logout-button">Sair</a>
  </header>

  <div class="main-wrapper">
    <div class="main-container">
      <h1>Bem-vindo, <?php echo htmlspecialchars($admin['nome']); ?>!</h1>

      <div class="actions">
        <a href="criar-medico.php" class="btn">Criar Médico</a>
        <a href="criar-recepcionista.php" class="btn">Criar Recepcionista</a>
      </div>
    </div>

    <div class="right-column">
      <div class="user-info">
        <h2>Dados Pessoais</h2>
        <ul>
          <li><strong>Nome:</strong> <?php echo htmlspecialchars($admin['nome'] . ' ' . $admin['sobrenome']); ?></li>
          <li><strong>Gênero:</strong> <?php echo htmlspecialchars($admin['genero']); ?></li>
          <li><strong>CPF:</strong> <?php echo htmlspecialchars($admin['cpf']); ?></li>
          <li><strong>Data de Nascimento:</strong> <?php echo htmlspecialchars($admin['data_nascimento']); ?></li>
          <li><strong>Email:</strong> <?php echo htmlspecialchars($admin['email']); ?></li>
          <li><strong>Telefone:</strong> <?php echo htmlspecialchars($admin['telefone']); ?></li>
          <li><strong>Endereço:</strong> <?php echo htmlspecialchars($admin['endereco']); ?></li>
          <li><strong>Data de Cadastro:</strong> <?php echo htmlspecialchars($admin['data_cadastro']); ?></li>
          <li><strong>Matrícula:</strong> <?php echo htmlspecialchars($admin['matricula']); ?></li>
          <br><!-- utilizado para espaçar a opção abaixo, estava muito perto -->
        </ul>
        <a href="editar-dados.php" class="btn" style="margin-top: 16px;">Editar Seus Dados</a>
      </div>
    </div>
  </div>

  <footer>
    <h2>Contato com o Suporte</h2>
    <p>Para dúvidas ou informações, entre em contato pelo e-mail
      <a href="mailto:suporte@vidaplus.com.br">suporte@vidaplus.com.br</a> ou telefone (21) 4002-8922.
    </p>
  </footer>
</body>

</html>