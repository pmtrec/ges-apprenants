<?php 
include __DIR__ . "/../layout/base.layout.php";

return function ($data) {
    ob_start();
    $urlCss = "http://" . $_SERVER["HTTP_HOST"];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Affichage Liste</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="<?= $urlCss . Chemins::CheminAssetCss->value . '/affichage_list.css' ?>">
</head>
<body>
  <div class="sidebar">

    <div class="logPRO">
                <div class="log">
                    <img class="imglo" src="<?= $urlCss.Chemins::CheminAssetImage->value."/logo_odc.png"?>" alt="logo sonatel">
                </div>
                <div class="Prom">
                    <h5>Promotion - 2025</h5>
                </div>
      </div>
      <div class="menu">       
      <ul>
        <li><i class="fas fa-tachometer-alt"></i> Tableau de bord</li>
        <li class="active"><i class="fas fa-graduation-cap"></i> Promotions</li>
    
      <a href="/referentiels" class="ret">
        <li><i class="fas fa-book"></i> Référentiels</li>
      </a>
        <li><i class="fas fa-users"></i> Apprenants</li>
        
        <li><i class="fas fa-calendar-check"></i> Présences</li>
        
        <li><i class="fas fa-laptop"></i> Kits & Laptops</li>
   
        <li><i class="fas fa-chart-line"></i> Rapports & Stats</li>
      </ul>
    </div>
    <!-- <div class="saysay"></div> -->

      <div class="form">
          <form class="form" action="/logout" method="post">
              <button type="submit" class="form">
                  <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
              </button>
          </form>
      </div>
  </div>
<div class="col">
  <div class="main">
    <div class="top-bar">
      <h2><span style="color: orange;"><?= htmlspecialchars(end($data['Promotion'])['MatriculePromo']) ?> </span></h2>
      <!-- <button style="padding: 10px 15px; background-color: #00775b; color: white; border-radius: 8px; border: none;">
        + Ajouter promotion
      </button> -->
      <div class="droite1">
                            <a href="#form-popup" id="btn-open-popup"><p>+ Ajouter une promotion</p></a>
      </div>
    </div>

    <div class="filters">
        <form id="form-recherche" method="get">
          <input type="text" placeholder="Rechercher..." name="recherche" value="<?= isset($_GET['recherche']) ? htmlspecialchars($_GET['recherche']) : '' ?>">
          <select id="btn-recherche">
            <option>Filtrer par classe</option>
          </select>
          <select>
            <option>Filtrer par statut</option>
          </select>
        </form>
    </div>


    </div>
    <script>
                    document.getElementById('btn-recherche').addEventListener('click', function() {
                        document.getElementById('form-recherche').submit();
                    });
      </script>

    <div class="stats">
      <div class="stat-card"><i class="fas fa-user-graduate fa-2x"></i><?= htmlspecialchars($data['nbrAppr']) ?><br><small>Apprenants</small></div>
      <div class="stat-card"><i class="fas fa-book fa-2x"></i><?= htmlspecialchars($data['nbrRef']) ?><br><small>Référentiels</small></div>
      <div class="stat-card"><i class="fas fa-user fa-2x"></i><?= htmlspecialchars($data['nbrProm']) ?><br><small>Promotions</small></div>
      <div class="stat-card"><i class="fas fa-users fa-2x"></i>13<br><small>Permanents</small></div>
    </div>

    <table>
      <thead>
        <tr>
          <th>Photo</th>
          <th>Promotion</th>
          <th>Date de début</th>
          <th>Date de fin</th>
          <th>Référentiel</th>
          <th>Statut</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data['Promotion'] as $promotion): ?>
          <tr>
            <td><img src="<?=Chemins::CheminAssetImage->value . '/' . ($promotion['photoPromo'] ?? 'imagesp7.jpeg')?>" class="photo" /></td>
            <td><?= htmlspecialchars($promotion['MatriculePromo']) ?></td>
            <td><?= htmlspecialchars($promotion['debut']) ?></td>
            <td><?= htmlspecialchars($promotion['fin']) ?></td>
            <td class="tags">
              <?php foreach (explode(',', $promotion['filiere']) as $filiere): ?>
                <span class="<?= "tag-".htmlspecialchars(trim($filiere)) ?>"><?= htmlspecialchars(trim($filiere)) ?></span>
              <?php endforeach; ?>
            </td>
            <td class="status <?= htmlspecialchars($promotion['etat']) ?>">●<?= htmlspecialchars($promotion['etat']) ?></td>
            <td class="actions"><i class="fas fa-ellipsis-h"></i></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="pagination">
      <form method="get" style="display: inline;">
          <span>par page</span>
          <select name="perPage" onchange="this.form.submit()">
            <?php foreach ([2,4,6,12,24,48] as $option): ?>
              <option value="<?= $option ?>" <?= ($option == (isset($_GET['perPage']) ? (int)$_GET['perPage'] : 6)) ? 'selected' : '' ?>>
                <?= $option ?>
              </option>
            <?php endforeach; ?>
          </select>
          <input type="hidden" name="page" value="1">
        </form>

        <span><?= $data['pageActuelle'] ?> sur <?= $data['totalPages'] ?></span>

        <?php
          $perPage = isset($_GET['perPage']) ? (int)$_GET['perPage'] : 6;
        ?>

        <?php if ($data['pageActuelle'] > 1): ?>
          <a href="?page=<?= $data['pageActuelle'] - 1 ?>&perPage=<?= $perPage ?>"><button><</button></a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $data['totalPages']; $i++): ?>
          <a href="?page=<?= $i ?>&perPage=<?= $perPage ?>">
            <button <?= ($i == $data['pageActuelle']) ? 'class="active-page"' : '' ?>>
              <?= $i ?>
            </button>
          </a>
        <?php endfor; ?>

        <?php if ($data['pageActuelle'] < $data['totalPages']): ?>
          <a href="?page=<?= $data['pageActuelle'] + 1 ?>&perPage=<?= $perPage ?>"><button>></button></a>
        <?php endif; ?>
    </div>



  </div>

  <a id="form-popup" class="overlay" href="#"></a>
            <div class="popbi">
                <div class="popup">
                    <h2>Créer une nouvelle promotion</h2>

                    <?php if (!empty($erreurs)): ?>
                        <div class="error-message">
                            <ul>
                                <?php foreach ($erreurs as $erreur): ?>
                                    <li><?= htmlspecialchars($erreur) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    



                    <form action="/promotion/ajout" method="post" enctype="multipart/form-data">
                        <label for="nomPromo">Nom de la promotion</label>
                        <input type="text" id="nom" name="nomPromo" placeholder="Ex: Promotion 2025" value="<?= htmlspecialchars($old['nomPromo'] ?? '') ?>">

                        <div class="datePopup">
                            <div class="popuDd">
                                <label for="debut">Date de début</label>
                                <input type="text" id="debut" name="date_debut" placeholder="Ex: 21/03/2000" value="<?= htmlspecialchars($old['date_debut'] ?? '') ?>">
                            </div>
                            <div class="popuDf">
                                <label for="fin">Date de fin</label>
                                <input type="text" id="fin" name="date_fin" placeholder="Ex: 21/03/2000" value="<?= htmlspecialchars($old['date_fin'] ?? '') ?>">
                            </div>
                        </div>

                        <label for="photo">Photo de la promotion</label>
                        <div class="photdp">
                            <label for="photo" class="drop-area">
                                <span class="aj">Ajouter</span> ou Glisser
                            </label>
                            <input type="file" id="photo" name="photo" accept="image/*" style="display: none;">
                        </div>

                        <label for="referentiel">Référentiels</label>
                        <input type="search" id="referentiel" name="referentiel" placeholder="Rechercher un référentiel..." value="<?= htmlspecialchars($old['referentiel'] ?? '') ?>">

                        <div class="actions">
                            <a href="#"><button type="button" class="cancel">Annuler</button></a>
                            <button type="submit" class="submit">Créer la promotion</button>
                        </div>
                    </form>

                    
                    <script>
                        const openBtn = document.getElementById('btn-open-popup');
                        const popup = document.querySelector('.popbi');
                        const overlay = document.getElementById('form-popup');
                        const cancelBtn = document.querySelector('.cancel');

                        openBtn.addEventListener('click', () => {
                            popup.classList.add('active');
                            overlay.classList.add('active');
                        });

                        overlay.addEventListener('click', () => {
                            popup.classList.remove('active');
                            overlay.classList.remove('active');
                        });

                        cancelBtn.addEventListener('click', () => {
                            popup.classList.remove('active');
                            overlay.classList.remove('active');
                        });
                    </script>


</body>
</html>
<?php
    return ob_get_clean(); 
}
?>
