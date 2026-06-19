<div class=''>
    <button class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#addModal">Ajouter un bus</button>
    <div class="table-responsive">
        <table class='table caption-top text-center '>
            <caption>Liste des chauffeurs</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom du bus</th>
                    <th>Capacité</th>
                    <th>Categorie</th>
                    <th>Etat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 1; foreach ($allBus as $bus) : ?>
                    <tr>
                        <th><?= $id++; ?></th>
                        <td><?= htmlentities($bus->nom_bus) ?></td>
                        <td><?= $bus->capacite ?></td>
                        <td><?= $bus->categorie ?></td>
                        <td><?= $bus->etat ?></td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target=<?= ($bus->nbrPlace == 0) ? "#editModal$id" : "' ' onclick=\"alert('ce bus est dejat configuré, vous ne pouvez donc pas le modifier')\" "?>>
                                <span class="small me-1 ">Modifier</span><i class="fas fa-edit"></i>
                            </button>
                            <a class="btn btn-sm btn-danger ms-2 text-decoration-none" href="index.php?action=deleteBus&id=<?= $bus->id_bus ?>">
                                <span class="small me-1 ">Supprimer</span><i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <?php require "form/editBus.php"; ?>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
    
</div>


<?php require_once "form/addBus.php"; ?><br><br>

<button class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#creationModal">Creer les places de bus</button>
<?php $i=0; foreach ($allBus as $bus) : ?>
  <?php if($totalPlace[$i] > 0):?>
    <div class="alert alert-success ps-3 py-2 small"> Les places du bus de nom ' <?= $bus->nom_bus." '"?> ont été configuré</div>
  <?php endif;?>
<?php $i++; endforeach; ?>
<?php require_once "form/createPlace.php"; ?>

