let form = document.getElementById('#contact-form');
const toggleButton = document.getElementById("toggleFormBtn");
const formContainer = document.querySelector(".form-container");


function changePlaceholder(event) {

    const input = event.target;
    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (file.type.startsWith("image/")) { 
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
            formContainer.style.display = "block"; 
            setTimeout(() => {
                formContainer.style.opacity = "1"; 
            }, 10);
        } else {
            formContainer.style.opacity = "0"; 
            setTimeout(() => {
                formContainer.style.display = "none"; 
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
        }, 300); 
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const contactList = document.querySelector(".contacts-container");
    let isScrolling; // Per il debounce dello scroll

    contactList.addEventListener("wheel", function (event) {
        event.preventDefault();
        let scrollAmount = event.deltaY * 0.5; // Rallenta lo scroll per più controllo
        contactList.scrollBy({
            top: scrollAmount,
            behavior: "smooth" // Effetto scorrevole
        });

        // Ferma lo scrolling con un effetto morbido quando si smette di scorrere
        window.clearTimeout(isScrolling);
        isScrolling = setTimeout(() => {
            contactList.style.scrollBehavior = "smooth"; // Riapplica lo scroll morbido dopo il rilascio
        }, 100);
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const contactItems = document.querySelectorAll(".contact-item");
    const overlay = document.querySelector(".contact-details-overlay");
    const closeBtn = document.querySelector(".close-btn");

    const contactName = document.getElementById("contact-name");
    const contactPhone = document.getElementById("contact-phone");
    const contactEmail = document.getElementById("contact-email");
    const contactPhoto = document.getElementById("contact-photo");

    contactItems.forEach(item => {
        item.addEventListener("click", function () {
            contactName.textContent = this.dataset.name + " " + this.dataset.surname;
            contactPhone.textContent = this.dataset.phone;
            contactEmail.textContent = this.dataset.email;
            contactPhoto.src = this.querySelector("img").src;

            overlay.classList.add("active");
        });
    });

    closeBtn.addEventListener("click", function () {
        overlay.classList.remove("active");
    });

    overlay.addEventListener("click", function (event) {
        if (event.target === overlay) {
            overlay.classList.remove("active");
        }
    });
});