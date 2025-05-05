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
    <link rel="stylesheet" href="<?= $urlCss . Chemins::CheminAssetCss->value ."/referentiel.css" ?>">
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
                <form action="" method="get">
                    <input class="search1" type="text" name="recherche" placeholder="Rechercher un referentiel">
                </form>
            </div>
<a href="/Tout_referentiels" class="filtre1"> 
                <div class="icNite"><i class="fa-solid fa-book"></i></div>
                <div class="ai">Tous les réferentiels</div>
                
            
</a>
          <div class="Gril" id="openModal">+ Ajouter à la promotion</div>
            
        </div>

        <div class="separateur"></div>

        <div class="liste-refs">
        <?php if(isset($data['referentiels_actifs'])): ?>
            <?php foreach ($data['referentiels_actifs'] as $datas): ?>

                    <div class="item-ref">
                        <div class="containImage"><img src="<?= Chemins::CheminAssetImage->value . '/' . ($datas['PhotoRef'] ?? 'logo_odc.png') ?>" alt=""></div>
                        <div class="titre-ref"><?= htmlspecialchars($datas['Nom'])?></div>
                        <div class="nb-modeles"><?= htmlspecialchars($datas['NombresModule']).' '.'Module(s)'?></div>
                        <div class="desc-ref"><?= htmlspecialchars($datas['Description'])?></div>
                        <div class="Lvert"></div>
                        <div class="derL">
                            <div class="poin">
                                <span class="points1"></span>
                                <span class="points2"></span>
                                <span class="points3"></span>
                            </div>
                            <div class="nbrAp"><p><?= htmlspecialchars($datas['NombresApprenant']).' '.'Apprenants'?></p></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune promotion disponible.</p>
            <?php endif; ?>

     
        </div>

        <div class="pied-page">
        
        </div>
    </div>
</div>




<div class="modal" id="referentielModal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Ajouter un référentiel</h2>

        <label>Libellé référentiel</label>
        <input type="text" placeholder="Nom du référentiel..." />

        <label>Promotion active</label>
        <div class="tags">
    <?php if (isset($data['referentiels'])): ?>
        <?php foreach ($data['referentiels'] as $ref): ?>
            <div 
                class="tag" 
                style="background-color: <?= htmlspecialchars($ref['Couleur']) ?>;"
                data-id="<?= htmlspecialchars($ref['Nom']) ?>"
            >
                <?= htmlspecialchars($ref['Nom']) ?> <span>×</span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


        <button class="btn-submit">Terminer</button>
    </div>
</div>


<script>
    const openBtn = document.getElementById("openModal");
    const modal = document.getElementById("referentielModal");
    const closeBtn = document.getElementById("closeModal");

    openBtn.onclick = () => modal.style.display = "flex";
    closeBtn.onclick = () => modal.style.display = "none";
    window.onclick = (e) => {
        if (e.target === modal) modal.style.display = "none";
    };
</script>
</html>
<?php
    return ob_get_clean(); 
}
?>
