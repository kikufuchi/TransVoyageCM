<?php require_once 'layouts/header.php'; ?>

<!-- Banderole info voyage -->
<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm bg-gradient" style="background: linear-gradient(135deg, #118599 0%, #068861 100%)!important;">
                <div class="card-body text-white text-center py-3">
                    <h5 class="mb-2">
                        <i class="fas fa-route me-2"></i>
                        <?= htmlspecialchars(explode('-', $voyage->nom_voyage)[0]) ?>
                        <i class="fas fa-arrow-right mx-2"></i>
                        <?= htmlspecialchars(explode('-', $voyage->nom_voyage)[1]) ?>
                    </h5>
                    <div class="d-flex justify-content-center flex-wrap gap-3">
                        <span>
                            <i class="far fa-calendar-alt me-1"></i>
                            <?= date('d/m/Y', strtotime($voyage->date_voyage)) ?>
                        </span>
                        <span>
                            <i class="far fa-clock me-1"></i>
                            <?= date('H:i', strtotime($voyage->heure_depart)) ?>
                        </span>
                        <span class="badge bg-primary text-dark fs-6 text-white">
                            <?= number_format($voyage->prix, 0, ',', ' ') ?> FCFA
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="px-2">
    <div class="card shadow mx-auto" style="max-width: <?= $nbColonnes === 5 ? '650px' : '550px' ?>;">
        <!-- En-tête -->
        <div class="card-header bg-success text-white text-center">
            <h4 class="mb-0">
                <i class="fas fa-couch me-2" style="transform: scaleX(0.6)!important;"></i>Places bus
            </h4>
        </div>

        <!-- Corps -->
        <div class="card-body bg-light p-4">
            <div class="container-fluid">

                <?php for ($i = 0; $i < $totalLignes; $i++) : ?>
                    <div class="row mb-2 justify-content-center">

                        <?php for ($j = 0; $j < $nbColonnes; $j++) : ?>

                            <?php if ($nbColonnes === 4) : ?>
                                <?php if ($j === 0) : ?>
                                    <div class="col-2 text-center ms-auto">
                                    <?php elseif ($j === 1) : ?>
                                        <div class="col-2 text-center me-3">
                                        <?php elseif ($j === 2) : ?>
                                            <div class="col-2 text-center ms-3">
                                            <?php elseif ($j === 3) : ?>
                                                <div class="col-2 text-center me-auto">
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <?php if ($j === 0) : ?>
                                                    <div class="col-2 text-center ms-auto">
                                                    <?php elseif ($j === 1) : ?>
                                                        <div class="col-2 text-center">
                                                        <?php elseif ($j === 2) : ?>
                                                            <div class="col-2 text-center me-3">
                                                            <?php elseif ($j === 3) : ?>
                                                                <div class="col-2 text-center ms-3">
                                                                <?php elseif ($j === 4) : ?>
                                                                    <div class="col-2 text-center me-auto">
                                                                    <?php endif; ?>
                                                                <?php endif; ?>

                                                                <?php if ($travelPlaces[$indexPlace]->disponibilite == 1) : ?>
                                                                    <?php if ($compteurAffichage === 1) : ?>
                                                                        <!-- Place du chauffeur (première place) -->
                                                                        <div class="alert alert-success placeSquare px-2"
                                                                            data-id="<?= $travelPlaces[$indexPlace]->id_place ?>"
                                                                            data-chauffeur="true">
                                                                            🚌
                                                                        </div>
                                                                    <?php else : ?>
                                                                        <!-- Place disponible -->
                                                                        <?php if ($travelPlaces[$indexPlace]->statut === 'libre') : ?>
                                                                            <!-- Place libre -->
                                                                            <div class="alert alert-primary placeSquare px-2 place-client"
                                                                                data-statut="libre"
                                                                                data-id="<?= $travelPlaces[$indexPlace]->id_place ?>"
                                                                                onclick="selectionnerPlace(this, <?= $compteurAffichage ?>)">
                                                                                <?= $compteurAffichage ?>
                                                                            </div>
                                                                        <?php elseif ($travelPlaces[$indexPlace]->statut === 'en_attente') : ?>
                                                                            <!-- Place en attente de paiement -->
                                                                            <div class="alert alert-danger placeSquare px-2"
                                                                                data-statut="en_attente"
                                                                                style="cursor: not-allowed;">
                                                                                <?= $compteurAffichage ?>
                                                                            </div>
                                                                        <?php elseif ($travelPlaces[$indexPlace]->statut === 'occupee') : ?>
                                                                            <!-- Place payée -->
                                                                            <div class="alert alert-secondary placeSquare px-2"
                                                                                data-statut="payee"
                                                                                style="cursor: not-allowed;">
                                                                                <?= $compteurAffichage ?>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    <?php endif; ?>
                                                                    <?php $compteurAffichage++; ?>
                                                                <?php else : ?>
                                                                    <div class="alert"></div>
                                                                <?php endif; ?>

                                                                <?php $indexPlace++; ?>
                                                                    </div>

                                                                <?php endfor; ?>

                                                                </div>
                                                            <?php endfor; ?>

                                                            </div>

                                                            <!-- Champ caché pour stocker l'ID de la place choisie -->
                                                            <input type="hidden" name="id_voyage" id="inputIdVoyage" value="<?= $voyage->id_voyage ?>">

                                                            <div class="text-center mt-3 pt-2 ">
                                                                <button id="btnReserver" class="small btn btn-success btn-lg d-none" onclick="reserverPlaces()">
                                                                    Réserver <span id="nbPlacesChoisies" class="badge bg-light text-dark ms-2">0</span> place(s)
                                                                </button>
                                                            </div>
                                                        </div>

                                                        <!-- Pied avec légende -->
                                                        <div class="card-footer bg-white">
                                                            <div class="d-flex justify-content-around">
                                                                <small class="d-flex align-items-center">
                                                                    <span class="badge bg-primary me-1">&nbsp;</span> Libre
                                                                </small>
                                                                <small class="d-flex align-items-center">
                                                                    <span class="badge bg-secondary me-1">&nbsp;</span> Occupée
                                                                </small>
                                                                <small class="d-flex align-items-center">
                                                                    <span class="badge bg-danger me-1">&nbsp;</span> Choisie
                                                                </small>
                                                                <small class="d-flex align-items-center">
                                                                    <span class="badge bg-success me-1">&nbsp;</span> Chauffeur
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><br>
                                                <script src="/TransVoyageCM/assets/js/ChoicePlace.js"></script>
                                                <script>
                                                    sessionStorage.removeItem('tempsFinPaiement');
                                                </script>
                                                <?php require_once 'layouts/footer.php'; ?>