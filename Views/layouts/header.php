<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TransVoyagesCM</title>
    <link rel="stylesheet" href="tools\bootstrap-5.3.8\css\bootstrap.min.css">
    <link rel="stylesheet" href="tools\vendor\fonts\css\all.min.css">
    <link rel="stylesheet" href="assets\css\acceuil.css">
    <link rel="stylesheet" href="assets\css\voyages.css">
    <link rel="stylesheet" href="\TransVoyageCM\assets\css\placeBus.css">
    <link rel="stylesheet" href="\TransVoyageCM\assets\css\paiement.css">
    <link rel="icon" href="assets\images\Capture d’écran 2026-05-26 080655.jpg">
    <script src='tools\vendor\js\jquery.min.js'></script>
</head>

<body>
    <header class="navbar navbar-expand-md">
        <div class="container">
            <span class="navbar-brand titleHome fs-3 mb-3"><span class='fs-2'>T</span>ransVoyagesCM</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white h5 fs-6 me-3" href="index.php?action=home"><i class="fas fa-home"></i>&nbsp; Accueil</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white h5 fs-6 me-4" href="index.php?action=voyage"><i class="fas fa-bus"></i>&nbsp; Nos voyages</a>
                    </li>

                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item dropdown d-flex align-items-center">
                            <div class="indice_profile mb-1 rounded-circle bg-dark text-info text-center fs-6"><?= ucfirst(explode(" ", $_SESSION['user']['nom'])[0])[0]; ?></div>
                            <div class="nav-link text-white btn border-0 dropdown-toggle h5 fs-6 ps-1" data-bs-toggle="dropdown" id="dropdownProfil"><?= $_SESSION['user']['nom']; ?></div>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a href="index.php?action=profil" class="dropdown-item"><span class="fas fa-user me-2"></span> Mon profil</a></li>
                                <li><a href="index.php?action=deconnect" class="dropdown-item"><span class="fas fa-sign-out-alt me-2"></span> Se deconnecter</a></li>
                                <li><a href="index.php?action=reservationClient" class="dropdown-item"><span class="fas fa-ticket-alt me-2"></span> Mes reservations</a></li>
                            </ul>

                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-white h5 fs-6 me-3" href="index.php?action=formInscript"><i class="fas fa-user-plus"></i>&nbsp; S'inscrire</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white h5 fs-6" href="index.php?action=formConnect"> <i class="fas fa-sign-in-alt"></i>&nbsp; Se connecter</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </header>