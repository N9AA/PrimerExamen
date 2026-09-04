CREATE DATABASE IF NOT EXISTS cruddb;
USE cruddb;

CREATE TABLE estados (
    id_estado INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

INSERT INTO estados (nombre) VALUES
('Regular'),
('Aprobada'),
('Libre');

CREATE TABLE materias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    anio_carrera INT NOT NULL,
    nota DECIMAL(4,2) NULL,
    anio_cursada INT NOT NULL,
    anio_aprobacion INT NULL,
    id_estado INT NOT NULL,
    habilitado TINYINT(1) NOT NULL DEFAULT 1,

    FOREIGN KEY (id_estado) REFERENCES estados(id_estado)
);