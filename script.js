// MENU
// Funcion que aplica el estilo a la opcion seleccionada en el menu y quita la previamente seleccionada

function seleccionar(link) {
    var opciones = document.querySelectorAll('#links a');
    opciones.forEach(function (opcion) {
        opcion.className = "";
    });
    link.className = "seleccionado";

    // El menu desaparece una vez que se ha seleccionado una opcion en el modo responsive
    var x = document.getElementById("nav");
    if (x) {
        x.className = "";
    }
}

// MENU RESPONSIVE

function responsiveMenu() {
    var x = document.getElementById("nav");
    if (x.className === "") {
        x.className = "responsive";
    } else {
        x.className = "";
    }
}

// ANIMACION DE TECNOLOGIAS

window.onscroll = function () {
    efectoTecnologias();
};

function efectoTecnologias() {
    var tecnologias =
        document.getElementById("tecnologias");
    if (!tecnologias) {
        return;
    }
    var distancia_tecnologias =
        window.innerHeight -
        tecnologias.getBoundingClientRect().top;
    if (distancia_tecnologias >= 300) {
        var canva =
            document.getElementById("canva");
        var figma =
            document.getElementById("figma");
        var sql =
            document.getElementById("sql");
        var wordpress =
            document.getElementById("wordpress");
        if (canva) {
            canva.classList.add("barra-progreso1");
        }
        if (figma) {
            figma.classList.add("barra-progreso2");
        }
        if (sql) {
            sql.classList.add("barra-progreso3");
        }
        if (wordpress) {
            wordpress.classList.add("barra-progreso4");
        }
    }
}

// VALIDACION DEL FORMULARIO DE CONTACTO

const formulario =
    document.getElementById('formulario');
const nombre =
    document.getElementById('nombre');
const email =
    document.getElementById('email');
const tema =
    document.getElementById('tema');
const mensaje =
    document.getElementById('mensaje');

// Expresion regular para validar email
const regexEmail =
    /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

// Crea y muestra un mensaje de error debajo del campo
function mostrarError(campo, texto) {
    let error =
        campo.parentElement.querySelector('.error-msg');
    if (!error) {
        error =
            document.createElement('p');
        error.className =
            'error-msg';
        error.style.color =
            '#ff4d4d';
        error.style.fontSize =
            '0.8rem';
        error.style.margin =
            '4px 0 0';
        campo.parentElement.appendChild(error);
    }
    error.textContent =
        texto;
    campo.style.borderColor =
        '#ff4d4d';
}

// Limpia el error de un campo
function limpiarError(campo) {
    const error =
        campo.parentElement.querySelector('.error-msg');
    if (error) {
        error.textContent = '';
    }
    campo.style.borderColor = '';
}

// Valida cada campo
function validarCampo(campo, tipo) {
    const valor =
        campo.value.trim();
    if (valor === '') {
        mostrarError(
            campo,
            'Este campo es obligatorio'
        );
        return false;
    }

    if (
        tipo === 'nombre' &&
        valor.length < 3
    ) {
        mostrarError(
            campo,
            'Ingresá al menos 3 caracteres'
        );
        return false;
    }
    if (
        tipo === 'email' &&
        !regexEmail.test(valor)
    ) {
        mostrarError(
            campo,
            'Ingresá un email válido'
        );
        return false;
    }

    if (
        tipo === 'mensaje' &&
        valor.length < 10
    ) {
        mostrarError(
            campo,
            'El mensaje debe tener al menos 10 caracteres'
        );
        return false;
    }

    limpiarError(campo);
    return true;
}

// EVENTO AL ENVIAR EL FORMULARIO

if (formulario) {
    formulario.addEventListener(
        'submit',
        function (e) {
            const vNombre =
                validarCampo(
                    nombre,
                    'nombre'
                );
            const vEmail =
                validarCampo(
                    email,
                    'email'
                );
            const vTema =
                validarCampo(
                    tema,
                    'tema'
                );
            const vMensaje =
                validarCampo(
                    mensaje,
                    'mensaje'
                );

            // Si hay algún error,se evita que lo envie
            if (
                !vNombre ||
                !vEmail ||
                !vTema ||
                !vMensaje
            ) {
                e.preventDefault();
            }
            // Si todos los campos son correctos,el formulario se envía normalmente mediante POST hacia contacto.php.
        }
    );
}

// LIMPIAR EL ERROR MIENTRAS SE ESCRIBE

[nombre, email, tema, mensaje].forEach(
    function (campo) {
        if (campo) {
            campo.addEventListener(
                'input',
                function () {
                    limpiarError(campo);
                }
            );
        }
    }
);

// MATERIAS CURSADAS

async function cargarMaterias() {
    const cuerpoTabla =
        document.getElementById("materias-body");
    const cargando =
        document.getElementById("materias-cargando");
    const mensajeError =
        document.getElementById("materias-error");

    // Verificar que exista la tabla
    if (!cuerpoTabla) {
        console.error(
            "No se encontró #materias-body"
        );
        return;
    }
    try {
        // Conectar con la API PHP
        const respuesta =
            await fetch(
                "http://localhost:8081/primerparcial/api/materias.php"
            );
        // Verificar la respuesta
        if (!respuesta.ok) {
            throw new Error(
                "Error HTTP: " +
                respuesta.status
            );
        }

        // Convertir la respuesta a JSON
        const materias =
            await respuesta.json();
        console.log(
            "Materias recibidas:",
            materias
        );

        // Ocultar Cargando materias
        if (cargando) {
            cargando.style.display = "none";
        }

        // Limpiar la tabla
        cuerpoTabla.innerHTML = "";

        // Limpiar mensaje de error
        if (mensajeError) {
            mensajeError.textContent = "";
        }

        // Verificar que sea un array

        if (!Array.isArray(materias)) {
            throw new Error(
                "La API no devolvió un array."
            );

        }

        // Si no hay materias
        if (materias.length === 0) {
            const fila =
                document.createElement("tr");
            const celda =
                document.createElement("td");
            celda.colSpan = 6;
            celda.textContent =
                "No hay materias cargadas.";
            celda.className =
                "materias-vacio";
            fila.appendChild(celda);
            cuerpoTabla.appendChild(fila);
            return;
        }

        // Recorrer las materias
        materias.forEach(
            function (materia) {
                const fila =
                    document.createElement("tr");
                const celdaNombre =
                    document.createElement("td");
                celdaNombre.textContent =
                    materia.nombre;
                const celdaAnioCarrera =
                    document.createElement("td");
                celdaAnioCarrera.textContent =
                    materia.anio_carrera;
                const celdaNota =
                    document.createElement("td");
                celdaNota.textContent =
                    materia.nota !== null
                        ? materia.nota
                        : "—";
                const celdaAnioCursada =
                    document.createElement("td");
                celdaAnioCursada.textContent =
                    materia.anio_cursada;
                const celdaAnioAprobacion =
                    document.createElement("td");
                celdaAnioAprobacion.textContent =
                    materia.anio_aprobacion !== null
                        ? materia.anio_aprobacion
                        : "—";

                const celdaEstado =
                    document.createElement("td");
                const estado =
                    document.createElement("span");
                estado.textContent =
                    materia.estado;
                estado.className =
                    "estado-materia";
                if (
                    materia.estado === "Aprobada"
                ) {
                    estado.classList.add(
                        "estado-aprobada"
                    );
                } else if (
                    materia.estado === "Regular"
                ) {
                    estado.classList.add(
                        "estado-regular"
                    );
                } else {
                    estado.classList.add(
                        "estado-libre"
                    );
                }
                celdaEstado.appendChild(
                    estado
                );
                fila.appendChild(
                    celdaNombre
                );
                fila.appendChild(
                    celdaAnioCarrera
                );
                fila.appendChild(
                    celdaNota
                );
                fila.appendChild(
                    celdaAnioCursada
                );
                fila.appendChild(
                    celdaAnioAprobacion
                );
                fila.appendChild(
                    celdaEstado
                );
                cuerpoTabla.appendChild(
                    fila
                );
            }
        );

    } catch (error) {
        console.error(
            "Error al cargar materias:",
            error
        );
        if (cargando) {
            cargando.style.display = "none";
        }
        if (mensajeError) {
            mensajeError.textContent =
                "No se pudieron cargar las materias.";
        }
    }
}
// EJECUTAR AL CARGAR LA PAGINA
document.addEventListener(
    "DOMContentLoaded",
    function () {
        cargarMaterias();
    }
);