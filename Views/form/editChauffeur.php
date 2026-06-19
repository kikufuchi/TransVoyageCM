<div class="modal fade" id="editModal<?= $id ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Modifier un chauffeur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?action=editChauffeur" method="post">
                <div class="modal-body">
                    <input type="hidden" value="<?= $chauffeur->id_chauffeur?>" name="id" >
                    <div class="mb-2">
                        <label for='nom'>Nom complet</label>
                        <input type="text" name="nom" class="form-control" id='nom' value='<?= $chauffeur->nom_chauffeur ?>' required>
                    </div>
                    <div class="mb-2">
                        <label for='phone'>Téléphone</label>
                        <input type="number" name="phone" class="form-control" id='phone' value='<?= $chauffeur->telephone ?>' title="Numero de 9 chiffres" required>
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

