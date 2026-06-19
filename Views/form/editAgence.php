<div class="modal fade" id="editModal<?= $id ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Modifier une agence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?action=editAgence" method="post">
                <input type="hidden" name="id" value="<?= htmlentities($agence->id_agence) ?>">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for='ville' class="form-label">Ville de residence: </label>
                        <input type="text" name="ville" class="form-control" id='ville' value="<?= htmlentities($agence->ville) ?>" required>
                    </div>
                    <div class="mb-2">
                        <label for='quartier' class="form-label">Quartier : </label>
                        <input type="text" name="brotherhood" class="form-control" id='quartier' value="<?= htmlentities($agence->quartier) ?>" required>
                    </div>
                    <div class="mb-2">
                        <label for='nomAdmin' class="form-label">Gerant de l'agence : </label>
                        <select name="nomAdmin" id="nomAdmin" class="form-control">
                            <?php if ($nom_admins[$i] != $nom_adminP): ?>
                                <option value="<?= $nom_admins[$i] ?>"><?= $nom_admins[$i] ?></option>
                            <?php endif; ?>
                            <?php foreach ($admins as $admin): ?>
                                <option value="<?= $admin->nom_users ?>"><?= $admin->nom_users ?></option>

                            <?php endforeach; ?>
                        </select>
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