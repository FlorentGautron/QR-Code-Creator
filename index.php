<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <title>QR Code</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>

    <body>
        <main>

            <div class="d-flex align-items-stretch">

                <div class="container-fluid px-lg-4 px-xl-5">
                    <div class="w-100 py-5 ">

                        <!-- Titre -->
                        <div class="col-12 row mt-4 text-center">
                            <h3 class="col-12">Générer un QR Code : </h3>
                        </div>

                        <!-- Formulaire -->
                        <form onsubmit="creerQrCode()" id="formURL" class="w-100 row col-12 mt-4">

                            <div class="row mb-3 col-12">
                                <!--  EMAIL  -->
                                <label for="adresse_url" class="form-label col-3">URL : </label>
                                <div class="col-7">
                                    <input id="adresse_url" class="form-control" name="adresse_url" type="text" autocomplete="true" required >
                                </div>
                                <p id="log"></p>
                            </div>

                            <!-- BOUTONS-->
                            <div class="d-grid mb-5 text-center col-12">
                                <button id="bouton_validation" onclick="creerQrCode()" type="" class="btn btn-primary text-uppercase">Valider</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </main>
    </body>
    <footer>

        <script>
            let form = document.getElementById('formURL');
            let log = document.getElementById('log');

            // Annulé la fonction de défaut de la soumission du form
            form.addEventListener('submit', (even) => {
                even.preventDefault();
                creerQrCode();
            });

            // Fonction Créer un QR Code
            function creerQrCode(){

                // Récupérer l'input
                let url = document.getElementById('adresse_url').value;

                // Vérifier présence HTTP
                if(!url.toLowerCase().includes("http")){
                    url = "http://" + url;
                }

                // Crée le QR Code avec Google Api
                let qrcode = 'https://chart.googleapis.com/chart?cht=qr&chl=' + encodeURIComponent(url) + '&chs=200x200&choe=UTF-8&chld=L|0';

                // Cas seconde création
                if( document.body.contains( document.getElementById("img_qr_code") ) ){
                    document.getElementById("img_qr_code").remove();
                }

                // Créer un élément div
                let div = document.createElement("div");
                div.classList.add('w-100', "text-center");

                // Créer un élément img
                let img = document.createElement("img");
                img.alt = "img_r_code";
                img.src = qrcode; // Ajouter le QR code à l'image
                img.id = "img_qr_code";
                img.classList.add("m-auto");
                img.setAttribute("onclick", "click_qr_code('" + qrcode + "', 'nouveau')") ;

                // Img dans la div
                div.appendChild(img);

                // Récupérer la div du formulaire
                let div_form = document.getElementById('formURL');

                // Insérer l'image après la div du formulaire
                insertAfter(div, div_form);
            }

            // Fonction pour insérer après élément
            function insertAfter(newNode, existingNode) {
                existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
            }

            // Clic sur le QR Code
            function click_qr_code(url, name){
                downloadImage(url, 'qr_code_'+ name + '.png');
            }

            // Function pour télécharger le QR Code
            function downloadImage(url, name){
                fetch(url)
                    .then(resp => resp.blob())
                    .then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = url;
                        // the filename you want
                        a.download = name;
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                    })
                    .catch(() => alert('Une erreur c\'est produit));
            }

        </script>
    </footer>
</html>
