<?php
require_once __DIR__ . "/../Models/Managers/UsersManagers.php";
require_once 'AuthController.php';

class UsersController
{

    private $usersManager;
    private $table = 'utilisateur';
    private $role;

    public function __construct()
    {
        $this->usersManager  = new UsersManagers();
    }

    public function liste_users()
    {
        AuthController::checkRole('admin_principal');

        $allUsers = $this->usersManager->findAll($this->table);

        if ($_GET['role'] == "client") {
            $allUsers = array_filter($allUsers, function ($user) {
                return $user->role_users == 'client';
            });
            ob_start(); //Demarre l'enregistrement et capture le bout de code en dessous

            require_once  __DIR__ . "/../Views/gerer_clients.php"; // ce code est capturer ne sera pas affiché

            $content = ob_get_clean(); //Arrete l'enregistrement et met tout le code html dans $content
        }


        if ($_GET['role'] == "admin") {
            $allUsers = array_filter($allUsers, function ($user) {
                return $user->role_users == 'admin';
            });

            ob_start(); //Demarre l'enregistrement et capture le bout de code en dessous

            require_once  __DIR__ . "/../Views/gerer_clients.php"; // ce code est capturer ne sera pas affiché

            $content = ob_get_clean(); //Arrete l'enregistrement et met tout le code html dans $content

        }

        require_once __DIR__ . '/../Views/layouts/sideBarAdminP.php';
    }

    public function insert_AC()
    {
        $this->usersManager->nom_users = $_POST['nom'];
        $this->usersManager->email_users = $_POST['mail'];
        $this->usersManager->mot_de_passe = $_POST['password'];
        $this->usersManager->telephone = $_POST['phone'];
        $this->usersManager->role_users = $_GET['role'];

        if ($this->usersManager->insert()) {

            header('Location:index.php?action=listeUsers&role=' . $this->usersManager->role_users);
        } else {
            header('Location:index.php?action=listeUsers&role=' . $this->usersManager->role_users);
        }
    }


    public function edit_AC()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if ($this->usersManager->update($_POST['id'], $_POST['nom'], $_POST['mail'], $_POST['password'], $_POST['phone'])) {
                    if (!isset($_POST['profil'])) {
                         header('Location:index.php?action=listeUsers&role=' . $_GET['role']);
                    }else{
                         header('Location:index.php?action=profil');
                    }
                }
        }
    }


    public function delete_AC()
    {
        AuthController::checkRole('admin_principal');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if ($this->usersManager->delete($_GET['id'])) {
                header('Location:index.php?action=listeUsers&role=' . $_GET['role']);
            } else {
                header('Location:index.php?action=listeUsers&role=' . $_GET['role']);
            }
        }
    }
}
