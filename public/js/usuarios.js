document.addEventListener("DOMContentLoaded", () => {

    const buscador = document.getElementById("buscarUsuario");

    if (buscador) {

        buscador.addEventListener("keyup", function () {

            const texto = this.value.toLowerCase();

            const filas = document.querySelectorAll("tbody tr");

            filas.forEach(fila => {

                const contenido = fila.innerText.toLowerCase();

                fila.style.display = contenido.includes(texto)
                    ? ""
                    : "none";

            });

        });

    }

    document.querySelectorAll("input[type=radio]").forEach(radio => {

        radio.addEventListener("change", () => {

            document.querySelectorAll("input[type=radio]+img").forEach(img => {

                img.style.border = "3px solid #3b82f6";

            });

            if (radio.nextElementSibling) {

                radio.nextElementSibling.style.border = "4px solid #22c55e";

            }

        });

    });

    document.querySelectorAll(".btn-danger").forEach(boton => {

        boton.addEventListener("click", function (e) {

            if (!confirm("¿Deseas eliminar este usuario?")) {

                e.preventDefault();

            }

        });

    });

});