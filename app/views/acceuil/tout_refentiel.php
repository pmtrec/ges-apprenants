<?php 
use App\MESS\Enums\Textes;
include __DIR__ ."/../layout/base.layout.php";

return function ($data) {
    ob_start();
    $urlCss = "http://" . $_SERVER["HTTP_HOST"];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?= $urlCss . Chemins::CheminAssetCss->value ."/tout_referentiel.css" ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Référentiels</title>

</head>
<div class="body">
    <div class="Container">
        <div class="Li1">
            <div class="titre-principal">Réferentiels</div>
            <div><p>Gérer les réferentiels de la promotion</p></div>
        </div>


        <div class="Cherche">
        <div class="search12">
            <form action="/referentiels" method="get">
                <input id="search1" class="search1" type="text" name="recherche" placeholder="Rechercher un référentiel">
            </form>
        </div>
        



        <div id="openModalBtn" class="Gril btn-ajouter " >+ Creer un référentiel</div>
        </div> 
    

        <div class="separateur"></div>

        <div class="liste-refs">
    <?php if (!empty($data)): ?>
        <?php foreach ($data as $datas): ?>
            <div class="item-ref">
                <div class="containImage">
                    <img src="<?= Chemins::CheminAssetImage->value . '/' . ($datas['PhotoRef'] ?? 'logo_odc.png') ?>" alt="">
                </div>
                <div class="titre-ref"><?= htmlspecialchars($datas['Nom']) ?></div>
                <div class="nb-modeles"><?= htmlspecialchars($datas['NombresModule']) . ' Module(s)' ?></div>
                <div class="desc-ref"><?= htmlspecialchars($datas['Description']) ?></div>
                <div class="Lvert"></div>
                <div class="derL">
                    <div class="poin">
                        <span class="points1"></span>
                        <span class="points2"></span>
                        <span class="points3"></span>
                    </div>
                    <div class="nbrAp">
                        <p><?= htmlspecialchars($datas['NombresApprenant']) . ' Apprenant(s)' ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune promotion disponible.</p>
    <?php endif; ?>
</div>

        </div>

        <div class="pied-page">
        
        </div>
    </div>
</div>




<div id="openModalBtn" class="btn-ajouter">+ Créer un référentiel</div>

<div id="referentielModal" class="modal">
    <div class="modal-content">
        <div class="cln">
            
            <h2>Créer un nouveau référentiel</h2>
            <span class="close">&times;</span>
        </div>

    <form action="/referentiel/ajout" method="post" enctype="multipart/form-data">
        <label for="photo">Photo du référentiel</label>
        <div class="photdp">
            <label for="photo" class="drop-area">
                <span class="aj">Ajouter </span> ou Glisser
            </label>
            <input type="file" id="photo" name="photo" accept="image/*" style="display: none;" required>
        </div>

        <label>Nom*</label>
        <input type="text" class="nomref" name="nomReferentiel" placeholder="Nom du référentiel" required>

        <label>Description</label>
        <textarea name="description" class="textar" placeholder="Description"></textarea>

        <div class="form-row">
            <div>
                <label>Capacité*</label>
                <input type="number" class="capacite" name="capacite" value="30" required>
            </div>
            <div >
                <label>Nombre de sessions*</label>
                <select class="select" name="nombre_sessions" required>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button type="button" class="cancel-btn">Annuler</button>
            <button type="submit" class="submit" class="submit-btn">Créer</button>
        </div>
    </form>
    </div>
</div>

<script>
                const modal = document.getElementById("referentielModal");
                const openBtn = document.getElementById("openModalBtn");  
                const closeBtn = document.querySelector(".close");
                const cancelBtn = document.querySelector(".cancel-btn");

                openBtn.onclick = () => modal.style.display = "block";
                closeBtn.onclick = () => modal.style.display = "none";
                cancelBtn.onclick = () => modal.style.display = "none";

                window.onclick = (event) => {
                    if (event.target === modal) modal.style.display = "none";
                };

                const dropArea = document.querySelector('.drop-area');

                dropArea.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropArea.classList.add('dragover');
                });

                dropArea.addEventListener('dragleave', () => {
                    dropArea.classList.remove('dragover');
                });

                dropArea.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropArea.classList.remove('dragover');
                    const fileInput = document.getElementById('photo');
                    fileInput.files = e.dataTransfer.files;
                });


                document.querySelector('.search1').addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                        e.preventDefault();
                        this.form.submit();
                    }
                });


</script>
</html>
<?php
    return ob_get_clean(); 
}
?>
