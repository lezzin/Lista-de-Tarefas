drop DATABASE lista_de_tarefas;

CREATE DATABASE lista_de_tarefas;
USE lista_de_tarefas;

CREATE TABLE tarefa (
 idTarefa INT NOT NULL AUTO_INCREMENT,
 description VARCHAR(255) NOT NULL, 
 status INT(1) NOT NULL, 
 PRIMARY KEY (idTarefa, status)                      
);

CREATE TABLE status (
 idStatus INT NOT NULL AUTO_INCREMENT,
 description VARCHAR(255) NOT NULL,
 PRIMARY KEY (idStatus)
);

INSERT INTO status (description) VALUES ('Pendente'), ('Concluída');

ALTER TABLE tarefa
ADD CONSTRAINT `status` FOREIGN KEY (`status`) REFERENCES `status` (`idStatus`);