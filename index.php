<?php
$host = "localhost"; 
$user = "root"; 
$password = "root"; 
$dbname = "atividade_nota"; 

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Criar notas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $id_usuario = 1; 

    if (isset($_POST['id_nota']) && !empty($_POST['id_nota'])) {
        // Atualizar as nota
        $id_nota = $_POST['id_nota'];
        $stmt = $conn->prepare("UPDATE nota SET titulo = ?, conteudo = ? WHERE id_nota = ?");
        $stmt->bind_param("ssi", $titulo, $conteudo, $id_nota);
    } else {
        // Criar nova nota
        $stmt = $conn->prepare("INSERT INTO nota (titulo, conteudo, id_usuario) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $titulo, $conteudo, $id_usuario);
    }
    $stmt->execute();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Excluir as notas
if (isset($_GET['delete_id'])) {
    $id_nota = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM nota WHERE id_nota = ?");
    $stmt->bind_param("i", $id_nota);
    $stmt->execute();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Selecionar nota para editar
$nota = null;
if (isset($_GET['id_nota'])) {
    $id_nota = $_GET['id_nota'];
    $stmt = $conn->prepare("SELECT * FROM nota WHERE id_nota = ?");
    $stmt->bind_param("i", $id_nota);
    $stmt->execute();
    $result = $stmt->get_result();
    $nota = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloco de Notas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1><?= $nota ? 'Editar Nota' : 'Criar Nova Nota' ?></h1>
    <form method="POST">
        <?php if ($nota): ?>
            <input type="hidden" name="id_nota" value="<?= htmlspecialchars($nota['id_nota']) ?>">
        <?php endif; ?>
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?= $nota ? htmlspecialchars($nota['titulo']) : '' ?>" required>

        <label for="conteudo">Conteúdo:</label>
        <textarea id="conteudo" name="conteudo" required><?= $nota ? htmlspecialchars($nota['conteudo']) : '' ?></textarea>

        <button type="submit"><?= $nota ? 'Salvar' : 'Criar' ?></button>
    </form>
    <!-- Ler as notas -->
    <h2>Notas</h2>
    <ul>
        <?php
        $result = $conn->query("SELECT * FROM nota");
        while ($row = $result->fetch_assoc()): ?>
            <li>
                <strong><?= htmlspecialchars($row['titulo']) ?></strong>
                <br>
                <small><?= nl2br(htmlspecialchars($row['conteudo'])) ?></small>
                <br>
                <a href="?id_nota=<?= $row['id_nota'] ?>">Editar</a> |
                <a href="?delete_id=<?= $row['id_nota'] ?>" onclick="return confirm('Deseja realmente excluir esta nota?');">Excluir</a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>