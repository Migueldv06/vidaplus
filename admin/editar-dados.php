<?php
include "protect.php";
include "../config.php";

$id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'];
  $sobrenome = $_POST['sobrenome'];
  $email = $_POST['email'];
  $telefone = $_POST['telefone'];
  $endereco = $_POST['endereco'];

  $stmt = $DB->prepare("UPDATE admin SET nome = ?, sobrenome = ?, email = ?, telefone = ?, endereco = ? WHERE id = ?");
  $stmt->bind_param("sssssi", $nome, $sobrenome, $email, $telefone, $endereco, $id);

  if ($stmt->execute()) {
    header("Location: main.php");
    exit();
  } else {
    $erro = "Erro ao atualizar dados: " . $stmt->error;
  }
}

$stmt = $DB->prepare("SELECT * FROM admin WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Dados</title>
  <link rel="stylesheet" href="styles/editar-dados.css">
</head>

<body>
  <div class="container">
    <h2>Editar Seus Dados</h2>
    <?php if (isset($erro)) echo "<p class='erro'>$erro</p>"; ?>
    <form method="post">
      <div class="form-group">
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($admin['nome']) ?>" required>
      </div>
      <div class="form-group">
        <label>Sobrenome</label>
        <input type="text" name="sobrenome" value="<?= htmlspecialchars($admin['sobrenome']) ?>" required>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
      </div>
      <div class="form-group">
        <label>Telefone</label>
        <input type="text" name="telefone" value="<?= htmlspecialchars($admin['telefone']) ?>" required>
      </div>
      <div class="form-group">
        <label>Endereço</label>
        <input type="text" name="endereco" value="<?= htmlspecialchars($admin['endereco']) ?>" required>
      </div>
      <div class="botoes">
        <button type="submit" class="btn">Salvar</button>
        <a href="main.php" class="btn cancel">Cancelar</a>
      </div>
    </form>
  </div>
</body>

</html>
