<div class="modal fade" id="addModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Ajouter un bus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?action=insertBus" method="post">
                <div class="modal-body">
                    <div class="mb-2">
                        <label for='nom' class="form-label">Nom : </label>
                        <input type="text" name="nom" class="form-control" id='nom' required>
                    </div>
                    <div class="mb-2">
                        <label for='capacite' class="form-label">Capacité : </label>
                        <input type="number" name="capacite" class="form-control" id='capacite' title="juste des nombre positifs" required>
                    </div>
                    <div class="mb-2">
                        <label for='categorie' class="form-label">Categorie : </label>
                        <select name="categorie" id="categorie" class="form-control">
                            <option value="VIP" selected>VIP</option>
                            <option value="Standard">Standard</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for='etat' class="form-label">Etat : </label>
                        <select name="etat" id="etat" class="form-control">
                            <option value="disponible" selected>disponible</option>
                            <option value="en_panne">en_panne</option>
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
