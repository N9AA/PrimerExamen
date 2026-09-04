<?php require __DIR__ . "/../layouts/header.php"; ?>

<div class="container crud-contenido">
    <div class="crud-card">
        <div class="crud-card-header text-center">
            <h1 class="crud-titulo mb-0">Nueva materia</h1>
            <p class="subtitulo-crud mb-0 mt-2">
                Completá los datos de la cursada
            </p>
        </div>

        <div class="crud-card-body">
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="fa-solid fa-circle-exclamation me-2"></i>
                    <strong>Error:</strong>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="index.php?action=store" method="POST" class="crud-form">
                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="nombre" class="form-label">
                            Materia
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="nombre"
                            name="nombre"
                            placeholder="Ej: Programación I"
                            value="<?= htmlspecialchars($nombre) ?>"
                            required
                        >
                    </div>
                    <div class="col-md-6">
                        <label for="anio_carrera" class="form-label">
                            Año de la carrera
                        </label>
                        <input
                            type="number"
                            class="form-control"
                            id="anio_carrera"
                            name="anio_carrera"
                            min="1"
                            placeholder="Ej: 1"
                            value="<?= htmlspecialchars($anio_carrera) ?>"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="anio_cursada" class="form-label">
                            Año de cursada
                        </label>
                        <input
                            type="number"
                            class="form-control"
                            id="anio_cursada"
                            name="anio_cursada"
                            min="2000"
                            placeholder="Ej: 2024"
                            value="<?= htmlspecialchars($anio_cursada) ?>"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="id_estado" class="form-label">
                            Estado
                        </label>
                        <select
                            class="form-select"
                            id="id_estado"
                            name="id_estado"
                            required
                        >
                            <option value="">Seleccionar estado</option>
                            <?php while ($estado = $estados->fetch_assoc()): ?>
                                <option
                                    value="<?= $estado["id_estado"] ?>"
                                    <?= $id_estado == $estado["id_estado"] ? "selected" : "" ?>
                                >
                                    <?= htmlspecialchars($estado["nombre"]) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="nota" class="form-label">
                            Nota
                        </label>
                        <input
                            type="number"
                            class="form-control"
                            id="nota"
                            name="nota"
                            min="0"
                            max="10"
                            step="0.01"
                            placeholder="Ej: 8.50"
                            value="<?= htmlspecialchars($nota) ?>"
                        >
                    </div>

                    <div class="col-md-12">
                        <label for="anio_aprobacion" class="form-label">
                            Año de aprobación
                        </label>
                        <input
                            type="number"
                            class="form-control"
                            id="anio_aprobacion"
                            name="anio_aprobacion"
                            min="2000"
                            placeholder="Ej: 2025"
                            value="<?= htmlspecialchars($anio_aprobacion) ?>"
                        >
                    </div>
                </div>

                <div class="crud-actions mt-4 d-flex gap-3 justify-content-center">
                    <button
                        type="submit"
                        class="btn btn-principal"
                    >
                        <i class="fa-solid fa-floppy-disk me-2"></i>
                        Guardar materia
                    </button>
                    <a
                        href="index.php?action=index"
                        class="btn btn-secundario"
                    >
                        <i class="fa-solid fa-xmark me-2"></i>
                        Cancelar
                    </a>

                </div>

            </form>
        </div>
    </div>
</div>

<?php require __DIR__ . "/../layouts/footer.php"; ?>