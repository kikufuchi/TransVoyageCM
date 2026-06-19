<div class=''>
    <button class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#addModal">Ajouter une agence</button>
    <div class="table-responsive">
        <table class='table caption-top text-center '>
            <caption>Liste des agences</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ville </th>
                    <th>Quartier</th>
                    <th>Gerant</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; $i= 0; foreach ($allAgence as $agence) : ?>
                    <tr>
                        <th><?= $id++; ?></th>
                        <td><?= htmlentities($agence->ville) ?></td>
                        <td><?= htmlentities($agence->quartier) ?></td>
                        <td><?= $nom_admins[$i] ?></td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal<?= $id ?>">
                                <span class="small me-1 ">Modifier</span><i class="fas fa-edit"></i>
                            </button>
                            <a class="btn btn-sm btn-danger ms-2 text-decoration-none" href="index.php?action=deleteAgence&id=<?= $agence->id_agence ?>">
                                <span class="small me-1 ">Supprimer</span><i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php require "form/editAgence.php";  $i++;?>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>

</div>

<?php require_once "form/addAgence.php"; ?>