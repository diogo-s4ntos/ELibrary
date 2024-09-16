CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(25),
    email VARCHAR(50),
    password VARCHAR(19)
);

CREATE TABLE livros (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    autor VARCHAR(50),
    titulo VARCHAR(100),
    descricao VARCHAR(2200),
    ano INT,
    genero VARCHAR(450),
    user_id INT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE reviews (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    review VARCHAR(455),
    livro_id INT NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (livro_id) REFERENCES livros(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);