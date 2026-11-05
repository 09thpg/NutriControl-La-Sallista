document.addEventListener("DOMContentLoaded", function () {

    const input = document.getElementById("foto_perfil");
    const preview = document.getElementById("foto-perfil-preview");

    if (!input || !preview) {
        return;
    }

    input.addEventListener("change", function () {

        const archivo = this.files[0];

        if (!archivo) {
            return;
        }

        const tiposPermitidos = [
            "image/jpeg",
            "image/png",
            "image/webp"
        ];

        if (!tiposPermitidos.includes(archivo.type)) {

            alert("Solo puedes subir imágenes JPG, PNG o WEBP.");

            this.value = "";

            return;
        }

        if (archivo.size > 2 * 1024 * 1024) {

            alert("La foto no puede superar los 2 MB.");

            this.value = "";

            return;
        }

        const lector = new FileReader();

        lector.onload = function (evento) {

            preview.src = evento.target.result;

        };

        lector.readAsDataURL(archivo);

    });

});