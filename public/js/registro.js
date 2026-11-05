document.addEventListener("DOMContentLoaded", () => {

    const avatares = document.querySelectorAll(".avatar-item");
    const fotoInput = document.getElementById("foto_perfil");
    const previewContainer = document.getElementById("preview-container");
    const previewFoto = document.getElementById("preview-foto");

    avatares.forEach((avatar) => {

        avatar.addEventListener("click", () => {

            avatares.forEach((item) => {
                item.style.borderColor = "transparent";
            });

            avatar.style.borderColor = "#2563eb";

            if (fotoInput) {
                fotoInput.value = "";
            }

            if (previewContainer) {
                previewContainer.style.display = "none";
            }

        });

    });

    if (fotoInput) {

        fotoInput.addEventListener("change", () => {

            const archivo = fotoInput.files[0];

            if (!archivo) {
                previewContainer.style.display = "none";
                return;
            }

            const tiposPermitidos = [
                "image/jpeg",
                "image/png",
                "image/webp"
            ];

            if (!tiposPermitidos.includes(archivo.type)) {

                alert("Solo puedes subir imágenes JPG, PNG o WEBP.");

                fotoInput.value = "";

                previewContainer.style.display = "none";

                return;
            }

            if (archivo.size > 2 * 1024 * 1024) {

                alert("La imagen no puede superar los 2 MB.");

                fotoInput.value = "";

                previewContainer.style.display = "none";

                return;
            }

            avatares.forEach((avatar) => {
                avatar.style.borderColor = "transparent";
            });

            const lector = new FileReader();

            lector.onload = (evento) => {

                previewFoto.src = evento.target.result;

                previewContainer.style.display = "block";

            };

            lector.readAsDataURL(archivo);

        });

    }

});