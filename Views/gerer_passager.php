<div class=' pt-4'>

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
                                <th>Numero_CNI</th>
                                <th>Numero_place</th>
                                <th>Date_reservation</th>
                                <th>Reservation</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($agence->passagers)): ?>
                                <?php $i = 0;
                                foreach ($agence->passagers as $passager): ?>
                                    <tr>
                                        <td class="small"><?= ++$i ?></td>
                                        <td class="small"><?= htmlspecialchars($passager->nom_passager) ?></td>
                                        <td class="small"><?= htmlspecialchars($passager->numero_CNI) ?></td>
                                        <td class="small"><?= htmlspecialchars($passager->numeroChoisi) ?></td>
                                        <td class="small"><?= date('d/m/Y', strtotime($passager->date_reservation)) ?></td>
                                        <td class="small"><?= htmlspecialchars('RES-' . substr($passager->id_reservation, 0, 6)) ?></td>
                                        <td class="small">
                                            <a href="index.php?action=telechargerTickets&id_reservation=<?= $passager->id_reservation ?>&id_voyage=<?= $passager->id_voyage ?>"
                                                class="btn btn-sm btn-outline-primary" target="_blank">
                                                <i class="fas fa-download me-1"></i> Ticket
                                            </a>
                                        </td>
                                    </tr>
                                   
                                <?php $id++;
                                endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-muted">Aucun passager prévu pour cette agence</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

