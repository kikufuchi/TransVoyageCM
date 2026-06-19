<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection | TransVoyagesCM</title>
    <link rel="stylesheet" href="\TransVoyageCM\tools\vendor\fonts\css\all.min.css">
    <link rel="stylesheet" href="\TransVoyageCM\tools\bootstrap-5.3.8\css\bootstrap.min.css">
    <link rel="stylesheet" href="\TransVoyageCM\assets\css\inscription.css">
    <link rel="icon" href="assets\images\Capture d’écran 2026-05-26 080655.jpg">
    <script src='\TransVoyageCM\tools\vendor\js\jquery.min.js'></script>
</head>

<body>
    <div class="inscription-card w-100">
        <div class="card-header">
            <i class="fas fa-bus fa-3x mb-1"></i>
            <h2>TransVoyagesCM</h2>
            <p>Connectez-vous et voyagez en toute simplicité</p>
        </div>

        <div class="card-body">
            <form id='inscript' action="index.php?action=login" method='post'>
                <div class="text-danger text-center small"><?= (isset($error)) ? $error : '' ?></div>

                <div class='input-icon mail'>
                    <i class="fas fa-envelope"></i>
                    <input type="email" id='email' name='email' class='form-control' placeholder="Adresse email" required>
                </div>

                <div class='mt-4 input-icon'>
                    <i class="fas fa-lock"></i>
                    <input type="password" id='password' name='password' class='form-control' placeholder="Mot de passe" required>
                </div>
                <div class="text-danger small"><?= (isset($error2)) ? $error2 : '' ?></div>

                <button type="submit" class="btn btn-inscription text-white mt-4" id="submitBtn">
                    <i class="fas fa-user-plus me-2"></i>Se connecter
                </button>

                <div class="login-link">
                    Pas encore de compte ? <a href="index.php?action=formInscript">Inscrivez-vous</a>
                </div>
            </form>
        </div>
    </div>


    <script src='\TransVoyageCM\assets\js\scriptConnection.js' defer></script>
</body>
<?php if (isset($error) || isset($error2)) : ?>
    <script>
        var $errorMsg = $('.text-danger.small');
        $errorMsg.delay(5000).fadeOut(500);
    </script>
<?php endif; ?>

</html>