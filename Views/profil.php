<?php require_once 'layouts/header.php'; ?>

<div class="container py-4">
    
    <!-- En-tête profil -->
    <div class="row mb-4">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-header text-white text-center py-4" 
                     style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                    <div class="d-inline-block bg-white rounded-circle p-3 mb-2">
                        <i class="fas fa-user fa-3x text-success"></i>
                    </div>
                    <h5 class="mb-1"><?= htmlspecialchars($users->nom_users) ?></h5>
                    <small class="opacity-100">
                        <i class="fas fa-envelope me-1"></i><?= htmlspecialchars($users->email_users) ?>
                    </small>
                </div>
                <div class="card-body">
                    <div class="info-ligne d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted"><i class="fas fa-phone me-2"></i>Téléphone</span>
                        <strong><?= $users->telephone ?? 'Non renseigné' ?></strong>
                    </div>
                    <div class="d-flex justify-content-center align-items-center mt-3">
                            <div class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal"><span class="fas fa-edit me-2"></span>Modifier</div>
                    </div>
                                  
                </div>
            </div>
        </div>
        <div class="col-lg-4"></div>
    </div>
</div>
<?php require_once 'form/editUsers.php'; ?>
<?php require_once 'layouts/footer.php'; ?>