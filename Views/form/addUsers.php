<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Ajouter un <?= $_GET['role'] ?> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?action=insertAC&role=<?= $_GET['role'] ?>" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for='nom'>Nom : </label>
                        <input type="text" name="nom" class="form-control" id='nom' required>
                    </div>
                    <div class="mb-2">
                        <label for='mail'>Email : </label>
                        <input type="email" name="mail" class="form-control" id='mail' required>
                    </div>
                    <div class="mb-2">
                        <label for='password'>Mot de passe : </label>
                        <input type="password" name="password" class="form-control" id='password' required>
                    </div>
                    <div class="mb-2">
                        <label for='phone'>Téléphone</label>
                        <input type="number" name="phone" class="form-control" id='phone' title="Numero de 9 chiffres" required>
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