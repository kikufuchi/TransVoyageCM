<?php require_once 'layouts/header.php';?>

<main class="container-fluid mainTravel pt-4 mb-3">
  <div class="text-center h2">Voyages disponibles dans les agences de la compagnie</div>
  <div class="text-center h1 title">TransVoyagesCM</div>

  <form action="index.php?action=searchTravel" method='post' class='container-fluid pb-5'>
    <div class="row mt-5">
      <div class="col-1"></div>
      <div class="col-10">
        <div class="row">
          <div class="col-md-6">
            <label for="cityStart" class='form-label text-muted'>Ville de depart : </label>
            <select name="cityStart" id="cityStart" class='form-control' required>
              <option value="">Selectionner une ville de depart</option>
              <?php foreach ($villeDeparts as $villeDepart): ?>
                <option value="<?= $villeDepart ?>"><?= $villeDepart ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="cityEnd" class='form-label text-muted'>Ville d'arrivée : </label>
            <select name="cityEnd" id="cityEnd" class='form-control' required>
            
            </select>
          </div>
        </div>
      </div>
      <div class="col-1"></div>
    </div>
    <div class="row mt-4">
      <div class="col-1"></div>
      <div class="col-10">
        <div class="row">
          <div class="col-md-6">
            <label for="agenceStart" class='form-label text-muted'>Agence de depart : </label>
            <select name="agenceStart" id="agenceStart" class='form-control' required>
              <option value="">Selectionner une agence</option>
              <?php foreach ($agences as $agence): ?>
                <option value="<?= $agence->quartier ?>">Agence de <?= $agence->quartier ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="categ" class='form-label text-muted'>Categorie de voyage</label>
            <select name="categ" id="categ" class='form-control'>
              <option value="">Selectionner une categorie</option>
              <option value="VIP">VIP</option>
              <option value="Standard">Standard</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-1"></div>
    </div>
    <div class="row mt-2">
      <div class="col-1"></div>
      <button class="col-10 btn btn-primary fs-4" type='submit'>Rechercher un voyage <span class='fas fa-arrow-right ms-3'></span></button>
      <div class="col-1"></div>
    </div>
  </form>

  <div class="border-top border-primary mt-5"></div>
  <div>
    <?= $content ?>
  </div>
</main>

<script src="\TransVoyageCM\assets\js\searchCityEnd.js"></script>

<?php require_once 'layouts/footer.php' ?>

