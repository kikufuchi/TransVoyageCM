<div class=''>
    <button class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#addModal">Ajouter un chauffeur</button>
    <table class='table caption-top text-center '>
      <caption>Liste des chauffeurs</caption>
    <thead>
        <tr>
          <th>#</th>
          <th>Nom </th>
          <th>Telephone</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
      <?php $id = 1; foreach ($chauffeurs as $chauffeur):?>
        <tr>
         <th><?= $id++ ?></th>
         <td><?= htmlspecialchars($chauffeur->nom_chauffeur)?></td>
         <td><?= $chauffeur->telephone?></td>
          <td>
            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal<?= $id ?>">
                <span class="small me-1 ">Modifier</span><i class="fas fa-edit"></i>
            </button>
            <a class="btn btn-sm btn-danger ms-2 text-decoration-none" href="index.php?action=deleteChauffeur&id=<?= $chauffeur->id_chauffeur?>">
                 <span class="small me-1 ">Supprimer</span><i class="fas fa-trash"></i>
            </a>
        </tr>
        <?php require "form/editChauffeur.php"; ?>
      <?php endforeach;?>
    </tbody>
  </table>
</div>


<?php require_once "form/addChauffeur.php"; ?>