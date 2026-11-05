document.addEventListener("DOMContentLoaded", () => {

    const formulario = document.getElementById("loginForm");
    const loginLoader = document.getElementById("loginLoader");

    if (!formulario) return;

    formulario.addEventListener("submit", (e) => {

        const usuario = document.querySelector("[name='usuario']");
        const password = document.querySelector("[name='password']");

        if (usuario.value.trim() === "" || password.value.trim() === "") {

            e.preventDefault();

            alert("Todos los campos son obligatorios.");

            return;

        }

        if (loginLoader) {

            loginLoader.classList.add("active");

        }

    });

});