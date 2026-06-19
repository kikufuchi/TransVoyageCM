// Tableau qui stocke les IDs des places choisies
let placesChoisies = [];
let ids = [];
function selectionnerPlace(element, numeroAffichage) {
    // Vérifie que ce n'est pas la place du chauffeur
    if (element.dataset.chauffeur === 'true') {
        return;
    }

    let idPlace = element.dataset.id;
    let index = placesChoisies.indexOf(idPlace);

    if (index === -1) {
        // Place non choisie → on l'ajoute
        element.classList.remove('alert-primary');
        element.classList.add('alert-danger');
        placesChoisies.push(idPlace);
    } else {
        // Place déjà choisie → on la retire
        element.classList.remove('alert-danger');
        element.classList.add('alert-primary');
        placesChoisies.splice(index, 1);
    }

    mettreAJourBouton();
}

function mettreAJourBouton() {
    let btnReserver = document.getElementById('btnReserver');
    let nbPlaces = document.getElementById('nbPlacesChoisies');

    if (placesChoisies.length > 0) {
        btnReserver.classList.remove('d-none');
        nbPlaces.textContent = placesChoisies.length;
    } else {
        btnReserver.classList.add('d-none');
        nbPlaces.textContent = '0';
    }
}


function reserverPlaces() {
    if (placesChoisies.length === 0) {
        alert('Veuillez choisir au moins une place.');
        return;
    }
    // Récupère les IDs et les numéros affichés
    let ids = [];
    let numeros = [];

    document.querySelectorAll('.place-client.alert-danger').forEach(place => {
        ids.push(place.dataset.id);
        numeros.push(place.textContent.trim());
    });
    

    // Met les IDs dans le champ caché
    idVoyage = document.getElementById('inputIdVoyage').value;

    // Redirige avec IDs + numéros
    window.location.href = 'index.php?action=creerReservation&id_voyage='+idVoyage+'&places=' + ids.join(',') + '&numeros=' + numeros.join(',');
}