<?php require_once 'layouts/header.php'; ?>

<div class="container py-4 text-center">
    <div class="card shadow mx-auto" style="max-width: 500px;">
        <div class="card-body p-4">
            
            <!-- Succès -->
            <div class="text-success mb-3">
                <i class="fas fa-check-circle fa-4x"></i>
            </div>
            <h4 class="text-success">Paiement réussi !</h4>
            <p>Votre réservation est confirmée.</p>
            
            <!-- Infos -->
            <div class="bg-light rounded p-3 mb-4 text-start">
                <p><strong>Voyage :</strong> <?= $voyage->nom_voyage ?></p>
                <p><strong>Date :</strong> <?= date('d/m/Y', strtotime($voyage->date_voyage)) ?></p>
                <p><strong>Heure :</strong> <?= date('H:i', strtotime($voyage->heure_depart)) ?></p>
                <p><strong>Montant :</strong> <?= number_format($reservation->montant, 0, ',', ' ') ?> FCFA</p>
            </div>
            
            <!-- Bouton télécharger -->
            <a href="index.php?action=telechargerTickets&id_reservation=<?= $id_reservation ?>&id_voyage=<?= $id_voyage ?>" 
               class="btn btn-primary btn-lg" target="_blank">
                <i class="fas fa-download me-2"></i>Télécharger les tickets
            </a>
        </div>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?>