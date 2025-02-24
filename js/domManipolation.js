let form = document.getElementById('#contact-form');
const toggleButton = document.getElementById("toggleFormBtn");
const formContainer = document.querySelector(".form-container");


function changePlaceholder(event) {

    const input = event.target;
    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (file.type.startsWith("image/")) { // Verifica che il file sia un'immagine
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("previewImage").src = e.target.result;
                document.getElementById("previewImage").style.position = 'absolute';


            };
            reader.readAsDataURL(file);
        } else {
            alert("Seleziona un file immagine valido.");
        }
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const toggleButton = document.getElementById("toggleFormBtn");
    const formContainer = document.querySelector(".form-container");

    toggleButton.addEventListener("click", function () {
        if (formContainer.style.display === "none" || formContainer.style.display === "") {
            formContainer.style.display = "block"; // Mostra il form
            setTimeout(() => {
                formContainer.style.opacity = "1"; // Effetto dissolvenza
            }, 10);
        } else {
            formContainer.style.opacity = "0"; // Inizia l'animazione di fade-out
            setTimeout(() => {
                formContainer.style.display = "none"; // Nasconde il form dopo l'animazione
            }, 500);
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const closeButton = document.getElementById("close-form");
    const formContainer = document.querySelector(".form-container");

    closeButton.addEventListener("click", function () {
        formContainer.style.opacity = "0";
        formContainer.style.transform = "translateY(-20px)";
        setTimeout(() => {
            formContainer.classList.add("hidden");
        }, 300); // Tempo per l'animazione
    });
});