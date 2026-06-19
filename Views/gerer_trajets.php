<div class=''>
    <button class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#addModal">Ajouter un trajet</button>
    <div class="table-responsive">
        <table class='table caption-top text-center '>
            <caption>Liste des chauffeurs</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ville de depart</th>
                    <th>Ville d'arrivée</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; foreach ($journays as $journay) : ?>
                    <tr>
                        <th><?= $id++; ?></th>
                        <td><?= htmlentities($journay->ville_depart) ?></td>
                        <td><?= htmlentities($journay->ville_arrivee) ?></td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal<?= $id ?>">
                                <span class="small me-1 ">Modifier</span><i class="fas fa-edit"></i>
                            </button>
                            <a class="btn btn-sm btn-danger ms-2 text-decoration-none" href="index.php?action=deleteTrajet&id=<?= $journay->id_trajet ?>">
                                <span class="small me-1 ">Supprimer</span><i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php require "form/editTrajet.php"; ?>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>

</div>

<?php require_once "form/addTrajet.php"; ?>