<?php

class Materia
{
    private $conexion;
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // Obtener materias habilitadas, con búsqueda 
    public function getAll($busqueda = "")
    {
        if ($busqueda !== "") {
            $s = $this->conexion->prepare(
                "SELECT
                    m.*,
                    e.nombre AS estado
                    
                 FROM materias m
                 INNER JOIN estados e
                    ON m.id_estado = e.id_estado
                 WHERE m.habilitado = 1
                   AND m.nombre LIKE ?
                 ORDER BY m.id DESC"
            );
            $busqueda = "%" . $busqueda . "%";
            $s->bind_param("s", $busqueda);
            $s->execute();
            return $s->get_result();
        } else {
            return $this->conexion->query(
                "SELECT
                    m.*,
                    e.nombre AS estado
                 FROM materias m
                 INNER JOIN estados e
                    ON m.id_estado = e.id_estado
                 WHERE m.habilitado = 1
                 ORDER BY m.id DESC"
            );
        }
    }

    // Obtener una materia por ID
    public function getById($id)
    {
        $s = $this->conexion->prepare(
            "SELECT *
             FROM materias
             WHERE id = ?
               AND habilitado = 1"
        );
        $s->bind_param("i", $id);
        $s->execute();
        return $s->get_result()->fetch_assoc();
    }

    // Obtener los estados
    public function getEstados()
    {
        return $this->conexion->query(
            "SELECT id_estado, nombre
             FROM estados
             ORDER BY id_estado"
        );
    }

    // Crear materia
    public function create(
        $nombre,
        $anio_carrera,
        $nota,
        $anio_cursada,
        $anio_aprobacion,
        $id_estado
    ) {
        /*Si no hay nota ni año de aprobación,se guardan como NULL.*/
        if ($nota === "" && $anio_aprobacion === "") {
            $s = $this->conexion->prepare(
                "INSERT INTO materias
                (
                    nombre,
                    anio_carrera,
                    nota,
                    anio_cursada,
                    anio_aprobacion,
                    id_estado,
                    habilitado
                )
                VALUES (?, ?, NULL, ?, NULL, ?, 1)"
            );
            $s->bind_param(
                "siii",
                $nombre,
                $anio_carrera,
                $anio_cursada,
                $id_estado
            );
        } else {
            $s = $this->conexion->prepare(
                "INSERT INTO materias
                (
                    nombre,
                    anio_carrera,
                    nota,
                    anio_cursada,
                    anio_aprobacion,
                    id_estado,
                    habilitado
                )
                VALUES (?, ?, ?, ?, ?, ?, 1)"
            );
            $s->bind_param(
                "sidiii",
                $nombre,
                $anio_carrera,
                $nota,
                $anio_cursada,
                $anio_aprobacion,
                $id_estado
            );
        }

        return $s->execute();
    }

    // Actualizar materia
    public function update(
        $id,
        $nombre,
        $anio_carrera,
        $nota,
        $anio_cursada,
        $anio_aprobacion,
        $id_estado
    ) {
        /*Si no hay nota ni año de aprobación,se guardan como NULL.*/
        if ($nota === "" && $anio_aprobacion === "") {
            $s = $this->conexion->prepare(
                "UPDATE materias
                 SET nombre = ?,
                     anio_carrera = ?,
                     nota = NULL,
                     anio_cursada = ?,
                     anio_aprobacion = NULL,
                     id_estado = ?
                 WHERE id = ?"
            );
            $s->bind_param(
                "siiii",
                $nombre,
                $anio_carrera,
                $anio_cursada,
                $id_estado,
                $id
            );
        } else {
            $s = $this->conexion->prepare(
                "UPDATE materias
                 SET nombre = ?,
                     anio_carrera = ?,
                     nota = ?,
                     anio_cursada = ?,
                     anio_aprobacion = ?,
                     id_estado = ?
                 WHERE id = ?"
            );
            $s->bind_param(
                "sidiiii",
                $nombre,
                $anio_carrera,
                $nota,
                $anio_cursada,
                $anio_aprobacion,
                $id_estado,
                $id
            );
        }
        return $s->execute();
    }

    // Borrado lógico
    public function delete($id)
    {
        $s = $this->conexion->prepare(
            "UPDATE materias
             SET habilitado = 0
             WHERE id = ?"
        );
        $s->bind_param("i", $id);
        return $s->execute();
    }
}