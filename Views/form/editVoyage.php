<div class="modal fade" id="editModal<?= $id ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5>Modifierr un voyage</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="index.php?action=editVoyage" method="post">
                <input type="hidden" value="<?= $voyage->id_voyage ?>" name="id">
                <div class="modal-body">
                    <!-- Ligne 1 : Nom du voyage (trajet) + Agence -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="trajet" class="form-label">Nom du voyage </label>
                            <select name="trajet" id="trajet" class="form-control" required>
                                <option value="">Sélectionnez un trajet</option>
                                <?php foreach ($trajets as $trajet): ?>
                                    <option value="<?= htmlspecialchars($trajet->ville_depart . ' - ' . $trajet->ville_arrivee) ?>" <?= (htmlspecialchars($trajet->ville_depart . ' - ' . $trajet->ville_arrivee) == $voyage->nom_voyage) ? "selected" : '' ?>>
                                        <?= htmlspecialchars($trajet->ville_depart . ' - ' . $trajet->ville_arrivee) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="agence" class="form-label">Agence</label>
                            <select name="agence" id="agence" class="form-control" required>
                                <option value="">Sélectionnez une agence</option>
                                <?php foreach ($agences as $agence): ?>
                                    <option value="<?= htmlspecialchars($agence->quartier) ?>" >
                                        Agence de <?= htmlspecialchars($agence->quartier) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Ligne 2 : Date + Heure de départ -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date de départ</label>
                            <input type="date" name="date" class="form-control" id="date" value="<?= $voyage->date_voyage ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="departure" class="form-label">Heure de départ</label>
                            <input type="time" name="departure" class="form-control" id="departure" value="<?= $voyage->heure_depart ?>" required>
                        </div>
                    </div>

                    <!-- Ligne 3 : Bus + Chauffeur -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bus" class="form-label">Bus</label>
                            <select name="bus" id="bus" class="form-control" required>
                                <option value="">Sélectionnez un bus</option>
                                <?php foreach ($bus as $b): ?>
                                    <option value="<?= htmlspecialchars($b->nom_bus) ?>" <?= (htmlspecialchars($b->nom_bus) == $voyage->nom_bus) ? "selected" : '' ?>>
                                        <?= htmlspecialchars($b->nom_bus).' - '.htmlspecialchars($b->capacite).' places' ?> 
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="chauffeur" class="form-label">Chauffeur</label>
                            <select name="chauffeur" id="chauffeur" class="form-control" required>
                                <option value="">Sélectionnez un chauffeur</option>
                                <?php foreach ($chauffeurs as $chauffeur): ?>
                                    <option value="<?= htmlspecialchars($chauffeur->nom_chauffeur) ?>" <?= (htmlspecialchars($chauffeur->nom_chauffeur) == $voyage->nom_chauffeur) ? "selected" : '' ?>>
                                        <?= htmlspecialchars($chauffeur->nom_chauffeur) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Ligne 4 : Statut + Catégorie -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="statut" class="form-label">Statut</label>
                            <select name="statut" id="statut" class="form-control" required>
                                <option value="ouvert" <?= ($voyage->statut == 'ouvert') ? 'selected' : '' ?>>Ouvert</option>
                                <option value="fermé" <?= ($voyage->statut == 'fermé') ? 'selected' : '' ?>>Fermé</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="categorie" class="form-label">Catégorie</label>
                            <select name="categorie" id="categorie" class="form-control" required>
                                <option value="VIP" <?= ($voyage->categorie == 'VIP') ? 'selected' : '' ?>>VIP</option>
                                <option value="Standard" <?= ($voyage->categorie == 'Standard') ? 'selected' : '' ?>>Standard</option>
                            </select>
                        </div>
                    </div>

                    <!-- Ligne 5 : Prix -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="prix" class="form-label">Prix (FCFA)</label>
                            <input type="number" name="prix" class="form-control" id="prix" value="<?= $voyage->prix ?>" placeholder="Ex: 5000" required>
                        </div>
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