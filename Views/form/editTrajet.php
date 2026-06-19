<div class="modal fade" id="editModal<?= $id ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Ajouter un trajet</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?action=editTrajet" method="post">
                <div class="modal-body">
                    <input type="hidden" value="<?= $journay->id_trajet ?>" name="id">
                    <div class="mb-2">
                        <label for='depart' class="form-label">date de depart: </label>
                        <input type="text" name="depart" class="form-control" value="<?= htmlentities($journay->ville_depart)?>" id='depart' required>
                    </div>
                    <div class="mb-2">
                        <label for='arrivee' class="form-label">date d'arrivée : </label>
                        <input type="text" name="arrivee" class="form-control" value="<?= htmlentities($journay->ville_arrivee)?>" id='arrivee' required>
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
