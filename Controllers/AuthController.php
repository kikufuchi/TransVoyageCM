<?php
require_once __DIR__ . "/../Models/Managers/UsersManagers.php";
class AuthController
{

    public static function checkRole($requiredRole)
    {
        if (!isset($_SESSION['user'])) {
            header('Location:index.php?action=formConnect');
            exit();
        }

        if ($_SESSION['user']['role'] != $requiredRole) {
            header('Location:index.php?action=home');
            exit();
        }
    }

    public function inscription()
    {

        $error = '';
        $oldEmail = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $telephone = $_POST['phone'];
            $password = $_POST['password'];
            $oldEmail = $email;

            $userManager = new UsersManagers();
            $mail_exist = $userManager->findByEmail($email);
            $phone_exist = $userManager->findByphone($telephone);
            if ($mail_exist || $phone_exist) {
                if ($mail_exist) $error = "Cet email est déjà utilisé. Utilisez un autre email.";
                if ($phone_exist) $error2 = "Cet numero est déjà utilisé. Utilisez un autre numero.";
                require_once __DIR__ . '\..\Views\form\inscription.php';
            } else {
                $role = 'client';

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $userManager->nom_users = $nom;
                $userManager->email_users = $email;
                $userManager->mot_de_passe = $hashedPassword;
                $userManager->telephone = $telephone;
                $userManager->role_users = $role;
                $userManager->insert();
                $id_users = $userManager->findByEmail($email)->id_users;
                $_SESSION['user'] = ['id_users' => $id_users ,'nom' => $nom, 'email' => $email, 'role' => $role];
                if ($_SESSION['before_page'] == 'home') {
                    $_SESSION['before_page'] = 'voyage';
                    header('Location:index.php?action=' . $_SESSION['before_page']);
                } else {
                    header('Location:index.php?action=' . $_SESSION['before_page']);
                }
                exit();
            }
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UsersManagers();
            $email = $_POST['email'];
            $password = $_POST['password'];
            $maildb = $userManager->findByEmail($email);
            if ($maildb) {

                if (password_verify($password, $maildb->mot_de_passe)) {
                    if ($maildb->role_users == 'admin_principal') {
                        $agence = $userManager->findAgencyById($maildb->id_users); 
                        $_SESSION['user'] = ['id_users' => $maildb->id_users,'nom' => $maildb->nom_users, 'email' => $maildb->email_users, 'role' => $maildb->role_users,'agence' => 'Agence de '.$agence->quartier, 'idAgence' => $agence->id_agence];
                        require_once __DIR__ . '\..\Views\choice.php';
                    } elseif ($maildb->role_users == 'admin') {
                        $agence = $userManager->findAgencyById($maildb->id_users);     
                        $_SESSION['user'] = ['id_users' => $maildb->id_users,'nom' => $maildb->nom_users, 'email' => $maildb->email_users, 'role' => $maildb->role_users,'agence' => 'Agence de '.$agence->quartier, 'idAgence' => $agence->id_agence];
                        require_once __DIR__ . '\..\Views\choice.php';
                    } else {
                        $_SESSION['user'] = ['id_users' => $maildb->id_users,'nom' => $maildb->nom_users, 'email' => $maildb->email_users, 'role' => $maildb->role_users];
                        if ($_SESSION['before_page'] == 'home') {
                            $_SESSION['before_page'] = 'voyage';
                            header('Location:index.php?action=' . $_SESSION['before_page']);
                        } else {
                            header('Location:' . $_SESSION['redirect']);
                        }
                    }
                } else {
                    $error2 = "Mot de passe incorrect";
                    require_once __DIR__ . '\..\Views\form\connection.php';
                }
            } else {
                $error = "Ce compte n'existe pas";
                require_once __DIR__ . '\..\Views\form\connection.php';
            }
        }
    }


    public function choiceMode()
    {

        if ($_SERVER($_REQUEST['REQUEST_METHOD'] === 'POST')) {
        }
    }


    public function logout()
    {
        session_destroy();
        header('Location: index.php');
    }
}
