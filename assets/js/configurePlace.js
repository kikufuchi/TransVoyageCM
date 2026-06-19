document.addEventListener('DOMContentLoaded', function () {

    function display(param) {
        console.log(param);
    }

    let busSelect = document.getElementById('bus');
    let placeContainer = document.getElementById('placeContainer');
    let infoCount = document.getElementById('infoCount');
    let validerBtn = document.getElementById('validerBtn');
    let textGuide = document.getElementById('guide');

    let currentPlacesState = [];
    let currentNbColonnes = 4;
    let currentTotalPlaces = 0;
    let currentCapacite = 0;

    busSelect.addEventListener('change', function () {
        textGuide.className = 'd-block text-center text-primary mb-3';
        currentCapacite = parseInt(this.options[this.selectedIndex].dataset.capacite);
        currentNbColonnes = currentCapacite >= 70 ? 5 : 4;

        // Arrondit au multiple supérieur pour avoir du surplus
        currentTotalPlaces = Math.ceil(currentCapacite / currentNbColonnes) * currentNbColonnes;

        genererPlan(currentTotalPlaces);
    })

    function genererPlan(totalPlaces) {
        placeContainer.innerHTML = '';
        currentPlacesState = [];
        infoCount.innerHTML = '';

        let nbLignes = totalPlaces / currentNbColonnes;
        let numeroPlace = 1;

        for (let i = 0; i < nbLignes; i++) {
            let row = createRow(numeroPlace, currentNbColonnes);
            placeContainer.appendChild(row);
            numeroPlace += currentNbColonnes;
        }

        // Boutons d'ajout/suppression de ligne
        ajouterBoutonsControle();
        updateCount();
    }

    function createRow(startNumero, nbColonnes) {
        let row = document.createElement('div');
        row.className = 'row mb-1 justify-content-center';

        for (let j = 0; j < nbColonnes; j++) {
            let col = document.createElement('div');

            if (nbColonnes === 4) {
                if (j === 0) {
                    col.className = 'col-2 d-flex justify-content-center align-items-center text-center ms-auto';
                } else if (j === 1) {
                    col.className = 'col-2 d-flex justify-content-center align-items-center text-center me-3';
                } else if (j === 2) {
                    col.className = 'col-2 d-flex justify-content-center align-items-center text-center ms-3';
                } else if (j === 3) {
                    col.className = 'col-2 d-flex justify-content-center align-items-center text-center me-auto';
                }
            } else {
                if (j === 0) {
                    col.className = 'col-2 d-flex justify-content-center align-items-center text-center ms-auto';
                } else if (j === 1) {
                    col.className = 'col-2 d-flex justify-content-center align-items-center text-center';
                } else if (j === 2) {
                    col.className = 'col-2 d-flex justify-content-center align-items-center text-center me-3';
                } else if (j === 3) {
                    col.className = 'col-2 d-flex justify-content-center align-items-center text-center ms-3';
                } else if (j === 4) {
                    col.className = 'col-2 d-flex justify-content-center align-items-center text-center me-auto';
                }
            }

            let square = document.createElement('div');
            square.className = 'place-square active rounded text-center';
            square.textContent = startNumero + j;
            square.dataset.numero = startNumero + j;

            square.addEventListener('click', function () {
                togglePlace(this);
            });

            col.appendChild(square);
            row.appendChild(col);
            currentPlacesState.push(true);
        }

        return row;
    }

    function ajouterBoutonsControle() {
        let controles = document.createElement('div');
        controles.className = 'text-center mt-3 mb-2';
        controles.id = 'controlesLignes';

        // Bouton ajouter une ligne
        let btnAjouter = document.createElement('button');
        btnAjouter.type = 'button';
        btnAjouter.className = 'btn btn-sm btn-outline-primary me-2';
        btnAjouter.innerHTML = '<i class="fas fa-plus"></i> Ajouter une ligne';
        btnAjouter.addEventListener('click', function () {
            ajouterLigne();
        });

        // Bouton supprimer dernière ligne
        let btnSupprimer = document.createElement('button');
        btnSupprimer.type = 'button';
        btnSupprimer.className = 'btn btn-sm btn-outline-danger';
        btnSupprimer.innerHTML = '<i class="fas fa-trash"></i> Supprimer dernière ligne';
        btnSupprimer.addEventListener('click', function () {
            supprimerDerniereLigne();
        });
        
        controles.appendChild(btnAjouter);
        controles.appendChild(btnSupprimer);
        placeContainer.appendChild(controles);
        placeContainer.insertBefore(document.createElement('br'),controles);

    }

    function ajouterLigne() {
        let dernierNumero = currentPlacesState.length;
        let newRow = createRow(dernierNumero + 1, currentNbColonnes);

        // Insère avant les boutons de contrôle
        let controles = document.getElementById('controlesLignes');
        placeContainer.insertBefore(newRow, controles);

        updateCount();
    }

    function supprimerDerniereLigne() {
        let rows = placeContainer.querySelectorAll('.row:not(#controlesLignes)');

        if (rows.length <= 1) {
            alert('Il doit y avoir au moins une ligne de places.');
            return;
        }

        // Supprime la dernière ligne
        let derniereLigne = rows[rows.length - 1];
        placeContainer.removeChild(derniereLigne);

        // Supprime les états correspondants
        currentPlacesState.splice(-currentNbColonnes);

        // Re-numérote les places restantes
        renuméroterPlaces();
        updateCount();
    }

    function renuméroterPlaces() {
        let squares = placeContainer.querySelectorAll('.place-square');
        squares.forEach((square, index) => {
            square.textContent = index + 1;
            square.dataset.numero = index + 1;
        });
    }

    function togglePlace(square) {
        let index = parseInt(square.dataset.numero) - 1;

        if (currentPlacesState[index]) {
            square.classList.remove('active');
            square.classList.add('inactive');
            currentPlacesState[index] = false;
        } else {
            square.classList.remove('inactive');
            square.classList.add('active');
            currentPlacesState[index] = true;
        }
        updateCount();
    }

    function updateCount() {
        let actives = currentPlacesState.filter((state) => state == true).length;
        let inactives = currentPlacesState.filter((state) => state == false).length;

        infoCount.innerHTML = `
          <span class="text-success small">✅ ${actives} places actives</span> | 
          <span class="text-danger small">❌ ${inactives} places inactives</span> |
          <span class="text-primary small">🎯 Capacité : ${currentCapacite}</span>
        `;
    }

    // Envoi des places à enregistrer (avec vérification)
    document.querySelector('#createPlace').addEventListener('submit', function (e) {
        let actives = [];
        let inactives = [];
        let activesCount = 0;

        for (let i = 0; i < currentPlacesState.length; i++) {
            if (currentPlacesState[i]) {
                actives.push(i + 1);
                activesCount++;
            } else {
                inactives.push(i + 1);
            }
        }

        // Vérification
        if (activesCount !== currentCapacite) {
            e.preventDefault();
            alert('⚠️ Le nombre de places actives (' + activesCount +
                ') doit être égal à la capacité du bus (' + currentCapacite + ').');
            return;
        }

        document.getElementById('placeActives').value = actives.join('-');
        document.getElementById('placeInactives').value = inactives.join('-');
    });

});