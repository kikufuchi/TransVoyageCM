<div class="modal fade" id="creationModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Creer les places de bus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?action=insertPlaces" id="createPlace" method="post">
                <div class="modal-body">
                    <label for="bus" class="form-label">Bus</label>
                    <select name="bus" id="bus" class="form-control mb-1" required>
                        <option value="">Sélectionnez un bus</option>
                        <?php foreach ($busWithoutPlace as $bus) : ?>
                            <option value="<?= htmlspecialchars($bus->id_bus) ?>" data-capacite = "<?= htmlspecialchars($bus->capacite) ?>">
                                <?= htmlspecialchars($bus->nom_bus) . ' - ' . htmlspecialchars($bus->capacite) . ' places' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="border-top border-primary mb-3"></div>
                    <div class="d-none" id="guide">Cliquez sur les places en surplus pour les desactiver</div>
                    <div id="placeContainer" class=""></div>
                    <div id="infoCount" class="mt-2"></div>

                    <input type="hidden" name="placeActives" id="placeActives">
                    <input type="hidden" name="placeInacitves" id="placeInactives">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" id="validerBtn" class="btn btn-success">Enregistrer</button>
                    </div>
            </form>
        </div>
    </div>
</div>
<script src="/TransVoyageCM/assets/js/configurePlace.js"></script>

