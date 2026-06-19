    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix du mode</title>
    <link rel="stylesheet" href="\TransVoyageCM\tools\bootstrap-5.3.8\css\bootstrap.min.css">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Bonjour <?= htmlspecialchars($_SESSION['user']['nom']) ?></h4>
                        <p>Que souhaitez-vous faire ?</p>
                    </div>
                    <div class="card-body text-center">
                        <div class="d-grid gap-3">
                            <a href="index.php?action=voyage" class="btn btn-success btn-lg">
                                <i class="fas fa-user"></i> Voyager comme client
                            </a>
                            <a href="index.php?action=<?= ($_SESSION['user']['role'] == 'admin') ? 'dashboardAdmin' : 'dashboard' ;?>" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-cog"></i> Accéder à l'espace admin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="\TransVoyageCM\tools\vendor\js\jquery.min.js"></script>
    <script src="\TransVoyageCM\tools\bootstrap-5.3.8\js\bootstrap.bundle.min.js"></script>
</body>
</html>