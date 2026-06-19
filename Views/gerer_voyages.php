<div class=''>
    <button class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#addModal">Ajouter un voyage</button>

    <?php $id = 1; foreach ($agences as $agence): ?>
        <div class="card mb-5">
            <div class="card-header bg-success text-white">
                <h4><?= htmlspecialchars( 'Agence de ' . $agence->quartier . ' a ' . $agence->ville) ?></h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class='table text-center'>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Voyage</th>
                                <th>Prix (FCFA)</th>
                                <th>Statut</th>
                                <th>Catégorie</th>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Bus</th>
                                <th>Chauffeur</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($agence->voyages)): ?>
                                <?php $i = 0; foreach ($agence->voyages as $voyage): ?>
                                    <tr>
                                        <td class="small"><?=  ++$i ?></td>
                                        <td class="small"><?= htmlspecialchars($voyage->nom_voyage) ?></td>
                                        <td class="small"><?= number_format($voyage->prix, 0, ',', ' ') ?></td>
                                        <td class="small">
                                            <span class="badge bg-<?= $voyage->statut == 'ouvert' ? 'success' : 'secondary' ?>">
                                                <?= htmlspecialchars($voyage->statut) ?>
                                            </span>
                                        </td>
                                        <td class="small"><?= htmlspecialchars($voyage->categorie) ?></td>
                                        <td class="small"><?= date('d/m/Y', strtotime($voyage->date_voyage)) ?></td>
                                        <td class="small"><?= substr($voyage->heure_depart, 0, 5) ?></td>
                                        <td class="small"><?= htmlspecialchars($voyage->nom_bus) ?></td>
                                        <td class="small"><?= htmlspecialchars($voyage->nom_chauffeur) ?></td>
                                        <td class="small">
                                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal<?= $id ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <a class="btn btn-sm btn-danger ms-2" href="index.php?action=deleteVoyage&id=<?= $voyage->id_voyage ?>" onclick="return confirm('Supprimer ce voyage ?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                  <?php require "form/editVoyage.php"; ?>
                                <?php $id++; endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-muted">Aucun voyage prévu pour cette agence</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once "form/addVoyage.php"; ?>