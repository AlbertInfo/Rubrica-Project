let form = document.getElementById('#contact-form');


function changePlaceholder(event) {
   
    const input = event.target;
    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (file.type.startsWith("image/")) { // Verifica che il file sia un'immagine
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("previewImage").src = e.target.result;
                document.getElementById("previewImage").style.position='absolute';
               

            };
            reader.readAsDataURL(file);
        } else {
            alert("Seleziona un file immagine valido.");
        }
    }
}