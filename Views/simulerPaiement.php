<?php require_once 'layouts/header.php'; ?>


<!-- Contenu principal -->
<div class="container py-4 py-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <!-- En-tête -->
            <div class="text-center mb-4">
                <div class="d-inline-block bg-white rounded-circle p-3 shadow-sm mb-3">
                    <i class="fas fa-credit-card fa-2x text-primary"></i>
                </div>
                <h4 class="text-primary fw-bold">Paiement sécurisé</h4>
                <p class="text-muted">
                    <?= htmlspecialchars($voyage->nom_voyage ?? 'Réservation') ?> —
                    <?= date('d/m/Y', strtotime($voyage->date_voyage ?? 'now')) ?>
                </p>
            </div>

            <!-- Timer toast -->
            <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 9999;">
                <div class="toast align-items-center border-0 shadow-lg fade show" id="toastTimer">
                    <div class="d-flex">
                        <div class="toast-body fw-semibold">
                            <i class="fas fa-hourglass-half me-2"></i>
                            Temps restant : <strong id="timerDisplay" class="fs-5"></strong>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Carte paiement -->
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-success text-white text-center py-3">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-shield-alt me-2"></i>Paiement sécurisé
                    </h5>
                </div>
                <div class="card-body p-4">

                    <!-- Récapitulatif -->
                    <div class="bg-light rounded-3 p-3 mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Nombre de places :</span>
                            <strong><?= $_GET['n'] ?? 1 ?></strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Prix unitaire :</span>
                            <strong><?= number_format($voyage->prix ?? 0, 0, ',', ' ') ?> FCFA</strong>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Total à payer :</span>
                            <strong class="text-success fs-3"><?= number_format($montant ?? 0, 0, ',', ' ') ?> FCFA</strong>
                        </div>
                    </div>

                    <!-- Formulaire -->
                    <form method="POST" action="" id="paymentForm" style="font-family: 'Poppins-ExtraLight'!important;">
                        <input type="hidden" name="id_reservation" id="id_reservation" value="<?= $id_reservation ?? '' ?>">
                        <input type="hidden" name="id_voyage" id="id_voyage" value="<?= $id_voyage ?? '' ?>">

                        <label class="form-label fw-bold mb-3">Choisir le mode de paiement</label>

                        <!-- Orange Money -->
                        <div class="mb-3 payment-option" data-operator="orange">
                            <div class="form-check card border-0 shadow-sm p-3 rounded-3 payment-card">
                                <input class="form-check-input me-3" type="radio" name="mode_paiement" id="orangeMoney" value="Orange_Money">
                                <label class="form-check-label d-flex align-items-center w-100" for="orangeMoney">
                                    <div class="rounded-3 p-3 me-3 text-white" style="background: linear-gradient(135deg, #FF7900, #FFA500);">
                                        <i class="fas fa-mobile-alt fa-lg"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong class="d-block">Orange Money</strong>
                                        <small class="text-muted">Paiement mobile sécurisé</small>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted opacity-0 transition"></i>
                                </label>
                            </div>
                        </div>

                        <!-- MTN Mobile Money -->
                        <div class="mb-4 payment-option" data-operator="mtn">
                            <div class="form-check card border-0 shadow-sm p-3 rounded-3 payment-card">
                                <input class="form-check-input me-3" type="radio" name="mode_paiement" id="mtnMomo" value="MTN_MOMO">
                                <label class="form-check-label d-flex align-items-center w-100" for="mtnMomo">
                                    <div class="rounded-3 p-3 me-3 text-white" style="background: linear-gradient(135deg, #FFCC00, #FFD700);">
                                        <i class="fas fa-wifi fa-lg"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <strong class="d-block">MTN Mobile Money</strong>
                                        <small class="text-muted">Paiement mobile sécurisé</small>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted opacity-0 transition"></i>
                                </label>
                            </div>
                        </div>

                        <!-- Champ téléphone -->
                        <div id="champNumero" class="d-none mb-4">
                            <label class="form-label">
                                <i class="fas fa-phone-alt me-1 text-primary"></i>
                                Numéro de téléphone
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-plus-circle text-muted"></i> +237
                                </span>
                                <input type="tel" name="telephone" id="telephone"
                                    class="form-control border-start-0 ps-0"
                                    placeholder="6XXXXXXXX" maxlength="9">
                            </div>
                            <div id="phoneValidation" class="form-text mt-2"></div>
                        </div>

                        <!-- Boutons -->
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-success btn-lg py-3 rounded-3" id="btnPayer" disabled>
                                <span class="btn-text">
                                    <i class="fas fa-lock me-2"></i>Payer maintenant
                                </span>
                                <span class="btn-loader d-none">
                                    <span class="spinner-border spinner-border-sm me-2"></span>
                                    Traitement...
                                </span>
                            </button>
                            <button type="button" class="btn btn-outline-danger py-2 rounded-3" id="btnAnnuler">
                                <i class="fas fa-times me-2"></i>Annuler
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt text-success me-1"></i>
                            Paiement 100% sécurisé
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src='tools\sweerAlert2\sweetalert2@11.js'></script>
<script src='assets\js\paiement.js'></script>

<?php require_once 'layouts/footer.php'; ?>