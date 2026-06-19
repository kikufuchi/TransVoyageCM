<div class=''>
    <button class="btn btn-primary my-4" data-bs-toggle="modal" data-bs-target="#addModal">Ajouter un <?= $_GET['role'] ?></button>
    <div class="table-responsive">
        <table class='table caption-top text-center '>
            <caption>Liste des <?= $_GET['role'].'s' ?></caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $id = 0; foreach ($allUsers as $users): ?>
                    <tr>
                        <th><?= ++$id; ?></th>
                        <th><?= htmlspecialchars($users->nom_users) ?></th>
                        <td><?= htmlspecialchars($users->email_users) ?></td>
                        <td><?= $users->telephone ?></td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal<?= $id ?>">
                                <span class="small me-1 ">Modifier</span><i class="fas fa-edit"></i>
                            </button>
                            <a class="btn btn-sm btn-danger ms-2 text-decoration-none" href="index.php?action=deleteAC&id=<?= $users->id_users ?>&role=<?= $_GET['role'] ?>">
                                <span class="small me-1 ">Supprimer</span><i class="fas fa-trash"></i>
                            </a>
                    </tr>
                    <?php require "form/editUsers.php"; ?>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>
<?php require_once "form/addUsers.php"; ?>