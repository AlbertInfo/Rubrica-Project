<?php

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creazione Contatto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/js/domManipolation.js"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container-custom {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 90%;
            max-width: 600px;
        }
        .contacts-container, .form-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .contact-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .contact-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .contact-buttons button {
            margin-left: 5px;
        }
        .image-upload {
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
            display: inline-block;
        }
        .image-upload img {
            width: 100%;
            height: 100%;
            object-fit: cover;
           
        }
        .image-upload::before {
            content: "Aggiungi Foto";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 16px;
            padding: 5px 10px;
            border-radius: 5px;
            opacity: 0.7;
        }
        .image-upload input {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        
        }
        @media (min-width: 768px) {
            .container-custom {
                flex-direction: row;
                max-width: 1000px;
            }
            .contacts-container {
                width: 50%;
                max-height: 500px;
                overflow-y: auto;
            }
            .form-container {
                width: 50%;
            }
        }
    </style>

</head>


<body>
    <div class="container-custom">
        <div class="form-container">
            <h3 class="text-center text-primary">Nuovo Contatto</h3>
            <form>
                <div class="text-center">
                    <label class="image-upload" id="upload-image">
                        <img src="/mock/person-placeholder.jpg" id="previewImage" alt="Aggiungi Foto">
                        <input type="file" id="photo" accept="image/*" onchange="changePlaceholder(event)">
                    </label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" placeholder="Inserisci il nome" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Cognome</label>
                    <input type="text" class="form-control" placeholder="Inserisci il cognome" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" placeholder="Inserisci l'email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Organizzazione</label>
                    <input type="text" class="form-control" placeholder="Inserisci l'organizzazione">
                </div>
                <div class="mb-3">
                    <label class="form-label">Ruolo</label>
                    <input type="text" class="form-control" placeholder="Inserisci l'organizzazione">
                </div>
                <div class="mb-3">
                    <label class="form-label">Numero di cellulare</label>
                    <input type="tel" class="form-control" placeholder="Inserisci il numero" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Compleanno</label>
                    <input type="date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Salva Contatto</button>
            </form>
        </div>
        <div class="contacts-container">
            <h4 class="text-primary">Contatti Salvati</h4>
            <div class="contact-item">
                <img src="/mock/person-placeholder.jpg" class="contact-image" alt="Foto Contatto">
                <div>
                    <strong>Mario Rossi</strong><br>
                    <small>+39 123 456 7890</small>
                </div>
                <div class="contact-buttons">
                    <button class="btn btn-sm btn-warning">Modifica</button>
                    <button class="btn btn-sm btn-danger">Elimina</button>
                </div>
            </div>
        </div>
    </div>
    
    
</body>
</html>
