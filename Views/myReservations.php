<?php require_once 'layouts/header.php'; ?>

<div class="container-fluid py-4 " style='min-height:100vh!important'>

    <!-- En-tête profil -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="mb-0">
                        <i class="fas fa-ticket-alt me-2 text-primary"></i>Mes réservations
                    </h5>
                </div>
                <div class="card-body">

                    <?php if (empty($reservations)) : ?>
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>Aucune réservation pour le moment.</p>
                            <a href="index.php?action=voyage" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Voir les voyages
                            </a>
                        </div>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle text-center small">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Voyage</th>
                                        <th>Agence de depart</th>
                                        <th>Date et heute de reservation</th>
                                        <th>Nombre_place</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($reservations as $resa) : ?>
                                        <tr>
                                            <td>
                                                <small class="text-muted"><?= $i++ ?></small>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars($resa->nom_voyage) ?></strong>
                                            </td>
                                            <td>
                                                <strong><?= htmlspecialchars('Agence de '.$resa->quartier) ?></strong>
                                            </td>
                                            <td><?= date('d/m/Y', strtotime($resa->date_reservation)).' '.substr($resa->heure_reservation, 0, 5) ?></td>
                                            <td><?= $resa->nb_places?></td>
                                            <td><strong><?= number_format($resa->montant, 0, ',', ' ') ?> FCFA</strong></td>
                                            <td>
                                                <?php if ($resa->statut == 'confirmee') : ?>
                                                    <span class="badge bg-success">Confirmée</span>
                                                <?php elseif ($resa->statut == 'en_attente') : ?>
                                                    <span class="badge bg-warning text-dark">En attente</span>
                                                <?php elseif ($resa->statut == 'echouee') : ?>
                                                    <span class="badge bg-danger">Échouée</span>
                                                <?php elseif ($resa->statut == 'annulee') : ?>
                                                    <span class="badge bg-secondary">Annulée</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($resa->statut == 'confirmee') : ?>
                                                    <a href="index.php?action=telechargerTickets&id_reservation=<?= $resa->id_reservation ?>&id_voyage=<?= $resa->id_voyage?>"
                                                        class="btn btn-sm btn-outline-primary" target="_blank">
                                                        <i class="fas fa-download me-1"></i> Ticket
                                                    </a>
                                                <?php else : ?>
                                                    <span class="text-muted small">—</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?>