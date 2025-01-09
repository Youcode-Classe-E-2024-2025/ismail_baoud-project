<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class signup
{
    private $username;
    private $email;
    private $password;
    private $db;
    private $imageData;

    public function __construct()
    {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
        if ($this->db === null) {
            die("Database connection failed");
        }
    }

    public function signupset($username, $email, $password, $imageData)
    {
        try {
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->imageData = $imageData;


            $check_member = member::check_email($this->db, $this->email);
            $check_CTO = CTO::check_email($this->db, $this->email);
            $check_admin = admin::check_email($this->db, $this->email);
            if ($check_member->rowCount() > 0 || $check_CTO->rowCount() > 0 || $check_admin->rowCount() > 0) {
                $err = "email not found";
                header("location: /");
                return false;
            }
            $is_exest = admin::get_admins($this->db);
            if (count($is_exest) > 0) {
                $member = new member($this->username, $this->email, $this->password, $this->imageData);
                echo "admin";
                return $member->add_to_db($this->db);
            } else {
                $member = new admin($this->username, $this->email, $this->password);
                echo "member";

                return $member->add_to_db($this->db);
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

$nameregex = "/^[a-zA-Z0-9_\s]+$/";
$emailregex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

$isvalide = true;
if (isset($_POST["btn_signup"])) {
    $username = htmlspecialchars(trim($_POST["username"]));
    $email = htmlspecialchars(trim($_POST["email"]));
    $password = trim($_POST["password"]);
    $image = $_FILES["image"];
    $imageData = file_get_contents($image['tmp_name']);

    // Validation du nom d'utilisateur
    if (empty($username) || !preg_match($nameregex, $username)) {
        $isvalide = false;
        $_SESSION["errname"] = "Nom invalide. Veuillez entrer un nom valide.";
    } else {
        $_SESSION["errname"] = "Nom valide.";
    }

    // Validation de l'email
    if (empty($email) || !preg_match($emailregex, $email)) {
        $isvalide = false;
        $_SESSION["erremail"] = "Email invalide. Veuillez entrer un email valide.";
    } else {
        $_SESSION["erremail"] = "Email valide.";
    }

    // Validation du mot de passe
    if (empty($password) || strlen($password) < 8) {
        $isvalide = false;
        $_SESSION["errpass"] = "Mot de passe invalide. Il doit contenir au moins 8 caractères.";
    } else {
        $_SESSION["errpass"] = "Mot de passe valide.";
    }

    if ($isvalide) {
        $user = new signup();
        $user->signupset($username, $email, $password, $imageData);
        header('Location: /');

        exit();
    } else {
        $_SESSION["infoerr"] = "Inscription invalide. Veuillez corriger les erreurs suivantes : " .
            $_SESSION["errname"] . " " . $_SESSION["erremail"] . " " . $_SESSION["errpass"];
            header('Location: /');

  
        exit();
    }
}


?>