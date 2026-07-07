<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard admin principal</title>
    <link rel="stylesheet" href="\TransVoyageCM\tools\vendor\fonts\css\all.min.css">
    <link rel="stylesheet" href="\TransVoyageCM\assets\css\dashboard.css">
    <link rel="stylesheet" href="\TransVoyageCM\assets\css\sidebar.css">
    <link rel="stylesheet" href="\TransVoyageCM\assets\css\placeBus.css">
    <link rel="stylesheet" href="\TransVoyageCM\tools\bootstrap-5.3.8\css\bootstrap.min.css">
    <link rel="icon" href="assets\images\Capture d’écran 2026-05-26 080655.jpg">
</head>

<body>
    <script src="/TransVoyageCM/tools/Chart.js/chart.min.js"></script>
    <script src='/TransVoyageCM/tools/bootstrap-5.3.8/js/bootstrap.bundle.min.js' defer></script>
    <!-- Bouton burger (visible sur mobile seulement) -->
    <div class="container-fluid">

        <div class="row nav align-items-center">
            <div class="col-7 p-1"><img src="/TransVoyageCM/assets/images/Capture d’écran 2026-05-26 080655.jpg" class="rounded-pill" width="100px" height="55px" alt=""><span class="h4 text-light ms-2">TransVoyagesCM</span></div>
            <div class="col-5 ">
                <div class="row text-end pe-2 align-items-center">
                    <div class="col-md-7 text-end mb-1 ps-3 text-white">
                        <div class="dropdown ">

                            <div class="ps-0 d-flex align-items-center text-white btn border-0 dropdown-toggle" data-bs-toggle="dropdown" id="dropdownProfil">
                                <div class="indice_profile mb-1 rounded-circle me-2 bg-dark text-info text-center fs-6"><?= ucfirst($_SESSION['user']['nom'][0]);   ?></div><?= $_SESSION['user']['nom'] ?>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a href="index.php?action=profil" class="dropdown-item"><span class="fas fa-user me-2"></span> Mon profil</a></li>
                                <li><a href="index.php?action=deconnect" class="dropdown-item"><span class="fas fa-sign-out-alt"></span> Se deconnecter</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-5 mb-1 ps-3 text-warning"><?= str_replace('_', ' ', $_SESSION['user']['role']); ?></div>
                </div>
            </div>
        </div>

        <div class="row bg-light">
            <div class="col-12 d-md-none p-2 text-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
                    <i class="fas fa-bars me-2"></i> Menu
                </button>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar (offcanvas) -->
            <div class="col-md-auto p-0">
                <div class="offcanvas offcanvas-start d-md-block" id="sidebarMenu">
                    <div class="offcanvas-header">
                        <button type="button" class="btn-close d-md-none bg-white" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="offcanvas-body px-0 pb-0">
                        <div class="py-2 ps-3 mx-2 rounded-2 mb-3 small"><a href="index.php?action=dashboard" class='text-decoration-none text-white'>Tableau de bord</a></div>
                        <div class="py-2 ps-3 mx-2 rounded-2 mb-3 small"><a href="index.php?action=listeTrajet" class='text-decoration-none text-white'>Trajets</a></div>
                        <div class="py-2 ps-3 mx-2 rounded-2 mb-3 small"><a href="index.php?action=listeAgence" class='text-decoration-none text-white'>Agences</a></div>
                        <div class="py-2 ps-3 mx-2 rounded-2 mb-3 small"><a href="index.php?action=listeUsers&role=admin" class='text-decoration-none text-white'>Admins</a></div>
                        <div class="py-2 ps-3 mx-2 rounded-2 mb-3 small"><a href="index.php?action=listeUsers&role=client" class='text-decoration-none text-white'>Clients</a></div>
                        <div class="py-2 ps-3 mx-2 rounded-2 mb-3 small"><a href="index.php?action=listeReservations" class='text-decoration-none text-white'>Les Reservations</a></div>
                        <div class="py-2 ps-3 mx-2 rounded-2 mb-3 small"><a href="index.php?action=listeBus" class='text-decoration-none text-white'>Les bus</a></div>
                        <div class="py-2 ps-3 mx-2 rounded-2 mb-3 small"><a href="index.php?action=listeVoyage" class='text-decoration-none text-white'>Les voyages</a></div>
                        <div class="py-2 ps-3 mx-2 rounded-2 mb-3 small"><a href="index.php?action=listeChauffeur" class='text-decoration-none text-white'>Les chauffeurs</a></div>
                        <div class="py-2 ps-3 mx-2 rounded-2 mb-3 small"><a href="index.php?action=listePassager" class='text-decoration-none text-white'>Les passagers</a></div>
                    </div>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="col">
                <?= $content; ?>
            </div>
        </div>

    </div>

    <script src="\TransVoyageCM\assets\js\displayGraphic.js"></script>

</body>

</html>