<?php
require_once 'AuthController.php';
class DashboardController
{

    public function showDashboard()
    {
        AuthController::checkRole('admin_principal');
        ob_start();

        require_once  __DIR__ . "/../Views/gerer_dashboard.php";

        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/layouts/sideBarAdminP.php';
    }


    public function showDashboardAdmin(){
        AuthController::checkRole('admin');
        ob_start();

        require_once  __DIR__ . "/../Views/gerer_dashboard.php";

        $content = ob_get_clean();

        require_once __DIR__ . '/../Views/layouts/sideBarAdmin.php';
    }
}
