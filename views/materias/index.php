<?php require __DIR__ . "/../layouts/header.php"; ?>

<div class="container crud-contenido">

    <!-- Mensajes de éxito -->
    <?php if (isset($_GET["mensaje"])): ?>
        <?php if ($_GET["mensaje"] === "creada"): ?>

            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                <strong>¡Listo!</strong> La materia fue creada correctamente.
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar"
                ></button>
            </div>
        <?php elseif ($_GET["mensaje"] === "actualizada"): ?>

            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                <strong>¡Listo!</strong> La materia fue actualizada correctamente.
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar"
                ></button>
            </div>
        <?php elseif ($_GET["mensaje"] === "eliminada"): ?>

            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                <strong>¡Listo!</strong> La materia fue eliminada correctamente.
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar"
                ></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>


    <!-- Título -->
    <div class="text-center mb-4">
        <h1>Materias cursadas</h1>
        <p class="subtitulo-crud">
            Gestión de mi trayectoria académica
        </p>
    </div>


    <!-- Buscador -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-6 col-lg-5">
            <form
                action="index.php"
                method="GET"
                class="buscador-crud"
            >
                <input
                    type="hidden"
                    name="action"
                    value="index"
                >

                <div class="input-group input-group-sm">
                    <span class="input-group-text">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input
                        type="text"
                        id="busqueda"
                        name="busqueda"
                        class="form-control"
                        placeholder="Buscar materia..."
                        value="<?= htmlspecialchars($busqueda) ?>"
                    >
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Buscar
                    </button>
                    <?php if ($busqueda !== ""): ?>
                        <a
                            href="index.php?action=index"
                            class="btn btn-outline-secondary"
                        >
                            Limpiar
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>


    <!-- Nueva materia -->
    <div class="d-flex justify-content-end mb-3">
        <a
            href="index.php?action=create"
            class="btn btn-primary"
        >
            <i class="fa-solid fa-plus"></i>
            Nueva materia
        </a>
    </div>

    <!-- Tabla -->
    <div class="crud-tabla table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Materia</th>
                    <th>Año de carrera</th>
                    <th>Nota</th>
                    <th>Año de cursada</th>
                    <th>Año de aprobación</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($materias->num_rows > 0): ?>
                    <?php while ($materia = $materias->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($materia["id"]) ?>
                            </td>
                            <td class="fw-semibold">
                                <?= htmlspecialchars($materia["nombre"]) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($materia["anio_carrera"]) ?>
                            </td>
                            <td>
                                <?= $materia["nota"] !== null
                                    ? htmlspecialchars($materia["nota"])
                                    : "—"
                                ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($materia["anio_cursada"]) ?>
                            </td>
                            <td>
                                <?= $materia["anio_aprobacion"] !== null
                                    ? htmlspecialchars($materia["anio_aprobacion"])
                                    : "—"
                                ?>
                            </td>
                            <td>
                                <span class="badge
                                    <?= $materia['estado'] === 'Aprobada'
                                        ? 'bg-success'
                                        : ($materia['estado'] === 'Regular'
                                            ? 'bg-warning text-dark'
                                            : 'bg-secondary')
                                    ?>"
                                >
                                    <?= htmlspecialchars($materia["estado"]) ?>
                                </span>

                            </td>
                            <td class="actions">
                                <!-- Editar -->
                                <a
                                    href="index.php?action=edit&id=<?= $materia["id"] ?>"
                                    class="btn btn-sm btn-primary"
                                    title="Editar"
                                >
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <!-- Eliminar -->
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-danger"
                                    title="Eliminar"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEliminar"
                                    data-id="<?= $materia["id"] ?>"
                                    data-nombre="<?= htmlspecialchars($materia["nombre"], ENT_QUOTES) ?>"
                                >
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>

                    <tr class="sin-materias">
                        <td colspan="8">
                            <i class="fa-solid fa-book-open"></i>
                            <div>
                                <?php if ($busqueda !== ""): ?>
                                    No se encontraron materias con esa búsqueda.
                                <?php else: ?>
                                    No hay materias cargadas.
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <div
        class="modal fade"
        id="modalEliminar"
        tabindex="-1"
        aria-labelledby="modalEliminarLabel"
        aria-hidden="true"
    >

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEliminarLabel">
                        <i class="fa-solid fa-triangle-exclamation text-warning me-2"></i>
                        ¿Eliminar materia?
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Cerrar"
                    ></button>
                </div>

                <div class="modal-body text-center">
                    <p class="mb-2">
                        Estás por eliminar la materia:
                    </p>
                    <p class="fw-bold fs-5" id="nombreMateriaEliminar"></p>
                    <p class="text-muted mb-0">
                        Esta acción quitará la materia del listado.
                    </p>
                </div>

                <div class="modal-footer justify-content-center">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        <i class="fa-solid fa-xmark me-2"></i>
                        Cancelar
                    </button>
                    <a
                        href="#"
                        id="btnConfirmarEliminar"
                        class="btn btn-danger"
                    >
                        <i class="fa-solid fa-trash me-2"></i>
                        Eliminar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Script del modal -->
<script>

document.addEventListener("DOMContentLoaded", function () {
    const modalEliminar = document.getElementById("modalEliminar");
    const nombreMateriaEliminar =
        document.getElementById("nombreMateriaEliminar");
    const btnConfirmarEliminar =
        document.getElementById("btnConfirmarEliminar");
    modalEliminar.addEventListener("show.bs.modal", function (event) {
        const boton = event.relatedTarget;
        const id = boton.getAttribute("data-id");
        const nombre = boton.getAttribute("data-nombre");
        nombreMateriaEliminar.textContent = nombre;
        btnConfirmarEliminar.href =
            "index.php?action=delete&id=" + id;
    });
});
</script>

<?php require __DIR__ . "/../layouts/footer.php"; ?>