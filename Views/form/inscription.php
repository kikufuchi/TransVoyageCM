<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | TransVoyagesCM</title>
    <link rel="stylesheet" href="\TransVoyageCM\tools\vendor\fonts\css\all.min.css">
    <link rel="stylesheet" href="\TransVoyageCM\tools\bootstrap-5.3.8\css\bootstrap.min.css">
    <link rel="stylesheet" href="\TransVoyageCM\assets\css\inscription.css">
    <script src='\TransVoyageCM\tools\vendor\js\jquery.min.js'></script>
    <link rel="icon" href="assets\images\Capture d’écran 2026-05-26 080655.jpg">
</head>

<body>
    <div class="inscription-card w-100">
        <div class="card-header">
            <i class="fas fa-bus fa-3x mb-3"></i>
            <h2>TransVoyagesCM</h2>
            <p>Créez votre compte et voyagez en toute simplicité</p>
        </div>

        <div class="card-body">
            <form id='inscript' action="index.php?action=inscription" method='post'>
                <div class='mb-4 input-icon'>
                    <i class="fas fa-user"></i>
                    <input type="text" id='nom' name='nom' class='form-control' placeholder="Nom complet" required>
                </div>

                <div class='input-icon mail'>
                    <i class="fas fa-envelope"></i>
                    <input type="email" id='email' name='email' class='form-control' placeholder="Adresse email" required>
                </div>
                <div class="text-danger small"><?= (isset($error)) ? $error : '' ?></div>
                <div class='mt-4 input-icon'>
                    <i class="fas fa-phone"></i>
                    <input type="tel" id='phone' name='phone' class='form-control' placeholder="Numéro de téléphone" required>
                </div>
                <div class="text-danger small"><?= (isset($error2)) ? $error2 : '' ?></div>
                <div class='mb-4 mt-4 input-icon'>
                    <i class="fas fa-lock"></i>
                    <input type="password" id='password' name='password' class='form-control' placeholder="Mot de passe" required>
                    <div class="password-strength">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                </div>

                <div class='input-icon'>
                    <i class="fas fa-check-circle mb-3"></i>
                    <input type="password" id='confirm_password' name='confirm_password' class='form-control' placeholder="Confirmer le mot de passe" required>
                </div>
                <div class="error-message" id="passwordError">Les mots de passe ne correspondent pas</div>

                <button type="submit" class="btn btn-inscription text-white mt-4" id="submitBtn">
                    <i class="fas fa-user-plus me-2"></i>S'inscrire
                </button>

                <div class="login-link">
                    Déjà un compte ? <a href="index.php?action=formConnect">Connectez-vous</a>
                </div>
            </form>
        </div>
    </div>


    <script src='\TransVoyageCM\assets\js\scriptConnection.js' defer></script>
</body>
<?php if (isset($error)) : ?>
    <script>
        var $errorMsg = $('.text-danger.small');
        $errorMsg.delay(5000).fadeOut(500);
    </script>
<?php endif; ?>

</html>