<div class='pt-4'>

    <?php $id = 1;
    foreach ($agences as $agence): ?>
        <div class="card mb-5">
            <div class="card-header bg-primary text-white">
                <h4><?= htmlspecialchars('Agence de ' . $agence->quartier . ' a ' . $agence->ville) ?></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class='table text-center'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Statut</th>
                                <th>Nombre_place</th>
                                <th>Date/heure</th>
                                <th>mode_paiement</th>
                                <th>Montant</th>
                                <th>Nom_voyage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($agence->reservations)): ?>
                                <?php $i = 0;
                                foreach ($agence->reservations as $reservation): ?>
                                    <tr>
                                        <td class="small"><?= ++$i ?></td>
                                        <td class="small"><?= htmlspecialchars('RES-' . substr($reservation->id_reservation, 0, 6)) ?></td>
                                        <td>
                                            <?php if ($reservation->statut == 'confirmee') : ?>
                                                <span class="badge bg-success">Confirmée</span>
                                            <?php elseif ($reservation->statut == 'en_attente') : ?>
                                                <span class="badge bg-warning text-dark">En attente</span>
                                            <?php elseif ($reservation->statut == 'echouee') : ?>
                                                <span class="badge bg-danger">Échouée</span>
                                            <?php elseif ($reservation->statut == 'annulee') : ?>
                                                <span class="badge bg-secondary">Annulée</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small"><?= htmlspecialchars($reservation->nb_places) ?></td>
                                        <td class="small"><?= date('d/m/Y', strtotime($reservation->date_reservation)).' '.substr($reservation->heure_reservation, 0, 5) ?></td>
                                        <td class="small"><?= htmlspecialchars($reservation->mode_paiement) ?></td>
                                        <td class="small"><?= htmlspecialchars($reservation->montant) ?></td>
                                        <td class="small"><?= htmlspecialchars($reservation->nom_voyage) ?></td>
                                    </tr>

                                <?php $id++;
                                endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-muted">Aucune reservation prévu pour cette agence</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>