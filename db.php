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
        $sql = "INSERT INTO notas (user_id, titulo, categoria, conteudo) VALUES ('$titulo', '$categoria', '$conteudo')";
        $conn-> query($sql);
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
        Nome aula <input type="text" name="nome" placeholder="Nome aula"  required><br><br>
        sala aula <input type="text" name="sala" placeholder="Sala aula"  required><br><br>
        hora aula <input type="time" name="hora" placeholder="Hora aula"  required><br><br>
        data aula <input type="date" name="data_aula" placeholder="Sala aula"  required><br><br>
        <input type="submit" name="update_aula" value="Atualizar Aula">
    </form>

