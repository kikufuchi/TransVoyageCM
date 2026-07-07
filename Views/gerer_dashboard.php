<div class="container-fluid px-4">

  <!-- ========================================= -->
  <!-- 1. CARTES RÉCAPITULATIVES                 -->
  <!-- ========================================= -->
  <div class="row mt-4 g-3">

    <!-- Trajets -->
    <div class="col-6 col-md-2">
      <div class="cart text-center text-white h5 p-3 rounded ">
        <span class="fas fa-route fa-2x text-dark"></span>
        <div class="fw-bold my-2 small">Trajets</div>
        <div style="font-size: 25px!important;"><?= $totalTrajets->total_trajet ?? 0 ?></div>
      </div>
    </div>

    <!-- Bus -->
    <div class="col-6 col-md-2">
      <div class="cart text-center text-white h5 p-3 rounded ">
        <span class="fas fa-bus fa-2x text-dark"></span>
        <div class="fw-bold my-2 small">Bus</div>
        <div style="font-size: 25px!important;"><?= $totalBus->total_bus ?? 0 ?></div>
      </div>
    </div>

    
    <!-- Réservations aujourd'hui -->
    <div class="col-6 col-md-2">
      <div class="cart text-center text-white h5 p-3 ps-1 rounded ">
        <span class="fas fa-ticket-alt fa-2x text-dark"></span>
        <div class="fw-bold my-2 small">Réservations/jr</div>
        <div style="font-size: 25px!important;"><?= $totalResas ?? 0 ?></div>
      </div>
    </div>

    <!-- CA aujourd'hui -->
    <div class="col-6 col-md-2">
      <div class="cart text-center text-white h5 p-3 rounded ">
        <span class="fas fa-money-bill-wave fa-2x text-dark"></span>
        <div class="fw-bold my-2 small">CA/jr</div>
        <div style="font-size: 25px!important;"><?= number_format($totalCA ?? 0, 0, ',', ' ') ?></div>
      </div>
    </div>

    <!-- Agences -->
    <div class="col-6 col-md-2">
      <div class="cart text-center text-white h5 p-3 rounded ">
        <span class="fas fa-building fa-2x text-dark"></span>
        <div class="fw-bold my-2 small">Agences</div>
        <div style="font-size: 25px!important;"><?= $nbAgences->total_agence ?? 0 ?></div>
      </div>
    </div>

    <!-- Passagers aujourd'hui -->
    <div class="col-6 col-md-2">
      <div class="cart text-center text-white h5 p-3 rounded ">
        <span class="fas fa-users fa-2x text-dark"></span>
        <div class="fw-bold my-2 small">Passagers/jr</div>
        <div style="font-size: 25px!important;"><?= $nbPassagers ?? 0 ?></div>
      </div>
    </div>

  </div>

  <!-- ========================================= -->
  <!-- 2. TABLEAU DES AGENCES                    -->
  <!-- ========================================= -->
  <div class="mt-5">
    <h5 class="text-primary fw-bold">
      <i class="fas fa-store me-2"></i>Activité du jour par agence
    </h5>
    <div class="table-responsive mt-3">
      <table class="table table-bordered text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>Agence</th>
            <th>Ville</th>
            <th>Réservations (jour)</th>
            <th>Chiffre d'affaires (jour)</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($agences)): ?>
            <?php foreach ($agences as $agence): ?>
              <tr>
                <td><strong><?= htmlspecialchars($agence->quartier?? 'Agence') ?></strong></td>
                <td><?= htmlspecialchars($agence->ville) ?></td>
                <td><?= $agence->nb_resas ?? 0 ?></td>
                <td><?= number_format($agence->ca ?? 0, 0, ',', ' ') ?> FCFA</td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-muted">Aucune agence trouvée</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ========================================= -->
  <!-- 3. GRAPHIQUE (ADMIN PRINCIPAL UNIQUEMENT) -->
  <!-- ========================================= -->
  <?php if ($isAdminPrincipal): ?>
    <input type ='hidden' id='labels' value='<?= json_encode($labels)?>'>
    <input type ='hidden' id='values' value='<?= json_encode($values)?>'>
    <div class="mt-5">
      <h5 class="text-primary fw-bold">
        <i class="fas fa-chart-bar me-2"></i>Chiffre d'affaires par agence 
      </h5>
      <div class="bg-white p-3 rounded shadow-sm">
        <canvas id="caChart" height="100"></canvas>
      </div>
    </div>
  <?php endif; ?>

</div>