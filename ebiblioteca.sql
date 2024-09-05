CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    email VARCHAR(150),
    password VARCHAR(19)
);

CREATE TABLE livros (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    autor VARCHAR(100),
    titulo VARCHAR(150),
    descricao VARCHAR(400),
    ano INT,
    genero VARCHAR(255),
    user_id INT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id)
);