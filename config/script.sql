drop DATABASE lista_de_tarefas;

CREATE DATABASE lista_de_tarefas;
USE lista_de_tarefas;

CREATE TABLE tarefa (
    idTarefa INT NOT NULL AUTO_INCREMENT,
    idUsuario INT NOT NULL,
    description VARCHAR(255) NOT NULL, 
    status INT(1) NOT NULL, 
    PRIMARY KEY (idTarefa, status, idUsuario)                      
);

CREATE TABLE usuario (
    idUsuario INT NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    PRIMARY KEY (idUsuario)
);

CREATE TABLE status (
 idStatus INT NOT NULL AUTO_INCREMENT,
 description VARCHAR(255) NOT NULL,
 PRIMARY KEY (idStatus)
);

INSERT INTO status (description) VALUES ('Pendente'), ('Concluída');

ALTER TABLE tarefa
ADD CONSTRAINT `status` FOREIGN KEY (`status`) REFERENCES `status` (`idStatus`);

ALTER TABLE tarefa
ADD CONSTRAINT `usuario` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);