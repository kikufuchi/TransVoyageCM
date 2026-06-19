<div class="modal fade" id="editModal<?= (isset($id)) ? $id : '' ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Modifier <?= (isset($_GET['role'])) ? 'un '.$_GET['role'] : "mon profil"?> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?action=editAC&role=<?= (isset($_GET['role'])) ? $_GET['role'] : ""?>" method="post">
                <input type="hidden" name="id" value="<?= $users->id_users?>">
                <?php if(isset($profil)): ?>
                  <input type="hidden" name="profil" value="<?=$profil?>">
                <?php endif;?>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for='nom'>Nom : </label>
                        <input type="text" name="nom" class="form-control" value="<?= htmlentities($users->nom_users) ?>" id='nom' required>
                    </div>
                    <div class="mb-2">
                        <label for='mail'>Email : </label>
                        <input type="email" name="mail" class="form-control" value="<?= htmlentities($users->email_users) ?>" id='mail' required>
                    </div>
                    <div class="mb-2">
                        <label for='password'>Mot de passe : </label>
                        <input type="password" name="password" class="form-control" value="<?= htmlentities($users->mot_de_passe) ?>" id='password' required>
                    </div>
                    <div class="mb-2">
                        <label for='phone'>Téléphone</label>
                        <input type="number" name="phone" class="form-control" value="<?= $users->telephone ?>" id='phone' title="Numero de 9 chiffres" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

