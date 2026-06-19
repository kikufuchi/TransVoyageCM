<div class="modal fade" id="editModal<?= $id ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Modifier un bus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?action=editBus" method="post">
                <div class="modal-body">
                    <input type="hidden" value="<?= $bus->id_bus ?>" name="id">
                    <div class="mb-2">
                        <label for='nom' class="form-label">Nom : </label>
                        <input type="text" name="nom" class="form-control" id='nom' value="<?= htmlentities($bus->nom_bus) ?>" required>
                    </div>
                    <div class="mb-2">
                        <label for='capacite' class="form-label">Capacité : </label>
                        <input type="number" name="capacite" class="form-control" id='capacite' value="<?= $bus->capacite ?>" title="juste des nombre positifs" required>
                    </div>
                    <div class="mb-2">
                        <label for='categorie' class="form-label">Categorie : </label>
                        <select name="categorie" id="categorie" class="form-control">
                            <option value="VIP" <?= ($bus->categorie == 'VIP') ? 'selected' : '' ?>>VIP</option>
                            <option value="Standard" <?= ($bus->categorie == 'Standard') ? 'selected' : '' ?>>Standard</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for='etat' class="form-label">Etat : </label>
                        <select name="etat" id="etat" class="form-control">
                            <option value="disponible" <?= ($bus->etat == 'disponible') ? 'selected' : '' ?>>disponible</option>
                            <option value="en_panne" <?= ($bus->etat == 'en_panne') ? 'selected' : '' ?>>en_panne</option>
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