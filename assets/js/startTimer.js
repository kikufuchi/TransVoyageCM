let id_voyage = document.getElementById('id_voyage').value;

// Définit le timer à la première visite
if (!sessionStorage.getItem('tempsFinPaiement')) {
    let tempsFin = Date.now() + (15 * 60 * 1000);
    sessionStorage.setItem('tempsFinPaiement', tempsFin);
}

// Affiche le timer dans la page formulaire
function afficherTimer() {
    let tempsFin = sessionStorage.getItem('tempsFinPaiement');
    let timerInterval = setInterval(() => {
        let restant = Math.floor((tempsFin - Date.now()) / 1000);
        if (restant <= 0) {
            clearInterval(timerInterval);
            sessionStorage.removeItem('tempsFinPaiement');
            alert('Temps expirée. Veuillez recommencer la reservation.');
            window.location.href = 'index.php?action=placeBus&id_voyage=' + id_voyage;
            return;
        }
        min = Math.floor(restant / 60);
        sec = restant % 60;
        document.getElementById('timerDisplay').textContent =
            String(min).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
    }, 1000);

}
afficherTimer();