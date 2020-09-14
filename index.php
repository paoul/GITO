<?php
session_start();
// Connexion à la base de données
if (!isset($_SESSION['user'])) {
    require 'config/dbConnect.php';

    // Si on envoie le formulaire de connexion
    if(isset($_POST['send']) and !empty($_POST['pseudo']) and !empty($_POST['mdp'])) {
        
        $req = $db -> prepare('SELECT * FROM autentification');
        $req -> execute(array());
        while ($result = $req ->fetch()) {
            //$mdp1 = password_hash($mdp1, PASSWORD_BCRYPT);
            if($_POST['pseudo'] == $result['pseudo'] && password_verify($_POST['mdp'], $result['mdp'])==1) {
                if ($result['statut']=='etudiant') {
                    $id_user=$result['id_user'];
                    $req=$db->prepare("SELECT * FROM etudiant WHERE Id_Etudiant=?");
                    $req->execute(array($id_user));
                    $nbr_result=$req->rowCount();
                    $user=$req->fetch();
                    if ($nbr_result!=0) {
                        $_SESSION['user']=$user;
                        $_SESSION['acces']="etudiant";
                        unset($_SESSION['message']);
                        header('location: etudiants/index.php');
                    }
                }else {
                    $id_user=$result['id_user'];
                    $req=$db->prepare("SELECT * FROM personnel WHERE id_personnel=?");
                    $req->execute(array($id_user));
                    $nbr_result=$req->rowCount();
                    if ($nbr_result!=0) {
                        $user=$req->fetch();
                        switch ($result['statut']) {
                            case 'secretaire de la scolarite':
                                $_SESSION['acces']="Direction de la Scolarité";
                                $_SESSION['user']=$user;
                                unset($_SESSION['message']);
                                header('location: scolarite/index.php');
                                break;
                            case 'chef de departement':
                                $_SESSION['acces']="chef de departement";
                                $req=$db->prepare("SELECT * FROM chef_departement C, departement D where C.id_personnel=? and D.Id_Departement=C.id_departement");
                                $req->execute(array($id_user));
                                $nbr=$req->rowCount();
                                if ($nbr!=0) {
                                    $_SESSION['departement']=$req->fetch(PDO::FETCH_OBJ);
                                    $_SESSION['user']=$user;
                                    unset($_SESSION['message']);
                                    header('location: departement/accueil');
                                }else{
                                    $_SESSION['type_message']='danger';
                                    $_SESSION['message'] = " Vous n'avez plus accès à ce service ! ";
                                }
                                
                                break;
                            case 'enseignant':
                                $_SESSION['acces']="enseignant";
                                $_SESSION['user']=$user;
                                unset($_SESSION['message']);
                                header('location: prof/index.php');
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                }
            } // Si le pseudo et le mot de passe sont corrects
            else {
                $_SESSION['type_message']='danger';
                $_SESSION['message'] = 'Pseudo ou mot de passe invalide !!!';
            }
        
        }
       
    }
}else{
     $_SESSION['type_message']='info';
     $_SESSION['message'] = "Vous êtes deconnecté.";
     header('location: '.$_SESSION['page_actuelle']);
 }
?>
<?php if (!isset($_SESSION['user'])) { ?>
<div class="">
    <?php require_once 'partials/header.php'?>
    <?php require_once 'vues/index.vue.php'; ?>
</div>
<?php } ?>