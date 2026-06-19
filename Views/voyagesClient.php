  <?php foreach ($groupes as $villeArivee => $agenceDepart): ?>
      <br>
      <div class="row mt-4 align-items-center">
          <div class="col-3"></div>
          <div class="col-2 border-top border border-success"></div>
          <div class="col-2 px-0 text-center h3 endTrajet mx-2"><?= $villeArivee ?></div>
          <div class="col-2 border-top border border-success"></div>
          <div class="col-3"></div>
      </div>
      <?php foreach ($agenceDepart as $nomAgence => $voyages): ?>
          <div class=" alert alert-secondary h4 text-primary"><?= $nomAgence ?></div>

          <?php foreach ($voyages as $voyage): ?>
              <div class="mx-5 border alert py-1 voyg px-4 ">
                  <div class="row align-items-center">
                      <div class="col-md-2 small text-center"><?= $voyage->nom_voyage ?></div>
                      <div class="col-md-2 small text-center">Depart le <?= date('d/M/Y', strtotime($voyage->date_voyage)) ?> a <?= substr($voyage->heure_depart, 0, 5) ?></div>
                      <div class="col-6 col-md-2 text-center"><?= number_format($voyage->prix, 0, ',', ' ') ?> FCFA</div>
                      <div class="col-6 col-md-2 text-center "><span class='badge bg-<?= ($voyage->statut == 'ouvert') ? 'success' : 'danger' ?> p-2'><?= $voyage->statut ?></span></div>
                      <div class="col-md-2 text-center "><span class='badge bg-<?= ($voyage->categorie == 'VIP') ? 'success' : 'warning text-black' ?> p-2'><?= $voyage->categorie ?></span></div>
                      <div class="col-md-2 text-center"><a href=<?= ($voyage->statut == 'ouvert') ? "index.php?action=placeBus&id_voyage=$voyage->id_voyage" : '#' ?>  class="btn btn-primary">Reserver</a></div>
                  </div>
              </div>
          <?php endforeach; ?>
      <?php endforeach; ?>
  <?php endforeach; ?>