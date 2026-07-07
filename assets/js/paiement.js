
$(document).ready(function () {
    // Variables
    let timerInterval = null;
    let timeLeft = 900;
    let selectedOperator = null;
    let isProcessing = false;
    let id_voyage = $('#id_voyage').val();
    let id_reservation = $('#id_reservation').val();
    let modePaiement;

    // Timer - Lit depuis sessionStorage (NE CRÉE PAS de nouveau timer)
    function startTimer() {
        const $timerDisplay = $('#timerDisplay');
        let tempsFin = sessionStorage.getItem('tempsFinPaiement');

        // Si pas de timer → rediriger
        if (!tempsFin) {
            window.location.href = 'index.php?action=placeBus&id_voyage=' + id_voyage;
            return;
        }

        timerInterval = setInterval(function() {
            let restant = Math.floor((tempsFin - Date.now()) / 1000);

            if (restant <= 0) {
                clearInterval(timerInterval);
                sessionStorage.removeItem('tempsFinPaiement');
                window.location.href = 'index.php?action=placeBus&id_voyage=' + id_voyage;
                return;
            }

            let minutes = Math.floor(restant / 60);
            let seconds = restant % 60;
            $timerDisplay.text(
                String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0')
            );
        }, 1000);
    }

    // Validation téléphone
    function validatePhone(phone) {
        if (!phone || phone.length === 0) return false;
        return /^[6][0-9]{8}$/.test(phone);
    }

    // Vérification formulaire
    function checkFormCompletion() {
        const phone = $('#telephone').val();
        const isOperatorSelected = selectedOperator !== null;
        const isValidPhone = validatePhone(phone);
        $('#btnPayer').prop('disabled', !(isOperatorSelected && isValidPhone));
    }

    // Sélection opérateur
    $('input[name="mode_paiement"]').on('change', function () {
        $phoneInput = $('#telephone');
        selectedOperator = $(this).val();
        modePaiement = $(this).val();
        console.log(modePaiement);
        // Animation de la carte
        $('.payment-card').removeClass('active');
        $(this).closest('.payment-card').addClass('active');

        // Afficher champ numéro
        $('#champNumero').removeClass('d-none').hide().fadeIn(300);

        $phoneInput.focus();
        checkFormCompletion();
    });

    // Validation en temps réel
    $('#telephone').on('input', function () {
        const phone = $(this).val();
        const isValid = validatePhone(phone);

        if (isValid) {
            $('#phoneValidation').html('<i class="fas fa-check-circle me-1"></i> Numéro valide').removeClass('phone-invalid').addClass('phone-valid');
        } else if (phone.length > 0) {
            $('#phoneValidation').html('<i class="fas fa-times-circle me-1"></i> Numéro invalide (9 chiffres, commence par 6)').removeClass('phone-valid').addClass('phone-invalid');
        } else {
            $('#phoneValidation').empty();
        }

        checkFormCompletion();
    });

    // Paiement
    $('#btnPayer').on('click', function (e) {
        e.preventDefault();
        if (isProcessing) return;

        const $btn = $(this);
        const $btnText = $btn.find('.btn-text');
        const $btnLoader = $btn.find('.btn-loader');

        isProcessing = true;
        $btn.prop('disabled', true);
        $btnText.addClass('d-none');
        $btnLoader.removeClass('d-none');

        setTimeout(function () {
            const randomFailure = Math.random() < 0.1;

            if (randomFailure) {
                Swal.fire({
                    icon: 'error',
                    title: 'Échec du paiement',
                    text: 'Veuillez réessayer.',
                    confirmButtonText: 'Réessayer'
                });
                $btnText.removeClass('d-none');
                $btnLoader.addClass('d-none');
                $btn.prop('disabled', false);
                isProcessing = false;
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Paiement réussi !',
                    text: 'Votre réservation est confirmée.',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed || result.dismiss) {
                        $btnText.removeClass('d-none');
                        $btnLoader.addClass('d-none');
                        window.location.href = 'index.php?action=confirmPaiement&id_voyage=' + id_voyage + '&id_reservation=' + id_reservation + '&modePaiement=' + modePaiement;
                    }
                })
            }
        }, 2000);
    });

    // Annulation
    $('#btnAnnuler').on('click', function () {
        if (confirm('Annuler le paiement ?')) {
            window.location.href = 'index.php?action=voyage';
        }
    });

    // Animation survol cartes
    $('.payment-card').on('mouseenter', function () {
        $(this).addClass('shadow');
    }).on('mouseleave', function () {
        $(this).removeClass('shadow');
    });

    // Démarrer timer
    startTimer();
});
