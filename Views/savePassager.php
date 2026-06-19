<?php require_once 'layouts/header.php'; ?>
<?php require_once 'toast/toastTempsRestant.php'; ?>


<div class="container py-4">
    <div class="toast-container position-fixed  start-50 translate-middle-x p-3" style="z-index: 9999; top:10px">
        <div class="toast align-items-center border-0 shadow-lg fade show" id="toastTimer">
            <div class="d-flex">
                <div class="toast-body fw-semibold">
                    <i class="fas fa-hourglass-half me-2"></i>
                    Temps restant : <strong id="timerDisplay" class="fs-5"></strong>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- En-tête -->
            <div class="text-center mb-4">
                <h4 class="text-primary">
                    <i class="fas fa-users me-2"></i>Informations des passagers
                </h4>
                <p class="text-muted">
                    <i class="fas fa-bus me-1"></i>
                    <?= htmlspecialchars($voyage->nom_voyage) ?> &nbsp;&nbsp;&nbsp;
                    <?= date('d/m/Y', strtotime($voyage->date_voyage)) ?> à
                    <?= date('H:i', strtotime($voyage->heure_depart)) ?>
                </p>
            </div>

            <!-- Formulaire -->
            <div class="card shadow">
                <div class="card-body p-4">
                    <form method="POST" action="index.php?action=enregistrerPassagers">
                        <input type="hidden" name="id_reservation" value="<?= $id_reservation ?>">
                        <input type="hidden" name="id_voyage" id="id_voyage" value="<?= $id_voyage ?>">
                        <input type="hidden" name="id_places" value="<?= $idPlaces ?>">
                        <input type="hidden" name="numeros" value="<?= $_GET['numeros'] ?>">

                        <?php foreach ($numeros as $index => $numero) : ?>
                            <!-- Passager <?= $index + 1 ?> -->
                            <div class="card mb-3 border-primary">
                                <div class="card-header bg-primary text-white py-2">
                                    <h6 class="mb-0">
                                        <i class="fas fa-ticket-alt me-2"></i>Place n°<?= $numero ?>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Nom complet</label>
                                            <input type="text"
                                                name="passagers[]"
                                                class="form-control"
                                                value="<?= $index === 0 ? htmlspecialchars($_SESSION['user']['nom']) : '' ?>"
                                                required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">N° CNI</label>
                                            <input type="text"
                                                name="passagers[]"
                                                class="form-control"
                                                placeholder="Ex: 123456789"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Récapitulatif -->
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong><?= count($numeros) ?></strong> place(s) —
                            <strong><?= number_format($montant, 0, ',', ' ') ?> FCFA</strong>
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between">
                            <a href="index.php?action=placeBus&id_voyage=<?= $id_voyage ?>"
                                class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Retour
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i> Valider et payer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?>
<script src="/TransVoyageCM/assets/js/startTimer.js"></script>
<script>
    $(document).ready(function() {
        $("#myToast").toast('show');
    });

</script>