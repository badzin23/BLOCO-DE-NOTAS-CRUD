<?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "bloco_de_notas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    if (isset($_POST['create'])) {
        $titulo = $_POST['titulo'];
        $categoria = $_POST['categoria'];
        $conteudo = $_POST['conteudo'];
        $sql = "INSERT INTO notas (titulo, categoria, conteudo) VALUES ('$titulo', '$categoria', '$conteudo')";
        echo "A nota foi criada";
    }

    if(isset($_POST['update'])){
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $categoria = $_POST['categoria'];
        $conteudo = $_POST['conteudo'];

        $sql = "UPDATE notas SET titulo='$titulo',categoria='$categoria',conteudo='$conteudo' WHERE id = $id";

        if($conn -> query($sql) === TRUE){
            echo "Alteração feita com sucesso!";
        }else{
            echo "Erro:". $sql."<br>".$conn->error;
        }

    }

    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
    
        $sql = "DELETE FROM notas WHERE id=$id";
    
        if($conn -> query($sql) === TRUE){
            echo "Excluido com sucesso!";
        }else{
            echo "Erro:". $sql."<br>".$conn->error;
        }
    
    }

    $result = $conn -> query("SELECT * FROM notas");

$sql = "SELECT * FROM notas";

$result = $conn -> query($sql);

if ($result -> num_rows > 0)
    echo "<table border='1'>
    <tr>
        <th>"

?>
<html lang="pt_br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>CRUD AULA</title>
</head>
<body>
 
<h2>Criar nota</h2>
<form method="POST">
    Título: <input type="text" name="titulo"><br>
    Categoria: <input type="text" name="categoria"><br>
    Conteúdo: <textarea name="conteudo"></textarea><br>
    <input type="submit" name="create" value="Criar Nota">
</form>

<h2>Atualizar nota</h2>
    <form method="POST">
        id da aula <input type="number" name="id" placeholder="id"  required><br><br>
        Título: <input type="text" name="titulo"><br>
        Categoria: <input type="text" name="categoria"><br>
        Conteúdo: <textarea name="conteudo"></textarea><br>
        <input type="submit" name="update_aula" value="Atualizar Aula">
    </form>

    <h2>Tabela notas</h2>
    <table borde="1">
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>categoria</th>
            <th>conteudo</th>
        </tr>

        <?php while($row = $result -> fetch_assoc()){ ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['titulo']; ?></td>
                <td><?php echo $row['categoria']; ?></td>
                <td><?php echo $row['conteudo']; ?></td>
                <td> 
                    <a href="index.php?delete=<?php echo $row['id'] ?>">Excluir</a>
                </td>
            </tr>
        <?php } ?>

