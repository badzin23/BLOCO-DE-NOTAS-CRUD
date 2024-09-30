Create database bloco_de_notas;
Use bloco_de_notas;

create table user (
user_id INT auto_increment primary key,
    nome_usuario VARCHAR(50) NOT NULL
    );


create table notas(
nota_id INT auto_increment primary Key,
    user_id INT NOT NULL,
    titulo VARCHAR(50) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    conteudo TEXT not null,
    FOREIGN KEY (user_id) REFERENCES USER(user_id)
    );
    
    select * from notas;