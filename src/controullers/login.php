<?php
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

class login {
    private $username;
    private $email;
    private $password;
    private $db;

    public function __construct() {
        $datab = new ConnectionDB();
        $this->db = $datab->getConnection();
    }

    public function loginset( $email, $password ) {
        $query = 'SELECT id, password,fullname as username, email FROM admin WHERE email = :email';
        $stmt = $this->db->prepare( $query );
        $stmt->bindparam( ':email', $email );
        $stmt->execute();
        $result = [];
        $test = $stmt->fetch( PDO::FETCH_ASSOC );
        if ( $test ) {
            if ( password_verify( $password, $test[ 'password' ] ) ) {
                $result = $test;
            }
        }

        if ( $result ) {

            $_SESSION[ 'role' ] = 'admin';
            $_SESSION[ 'admin_id' ] = $result[ 'id' ];
            $_SESSION[ 'fullname' ] = $result[ 'username' ];
            $_SESSION[ 'email' ] = $result[ 'email' ];

            return 'admin';
        }

        $query = 'SELECT cto_id as id,password,fullname as username, email FROM CTO WHERE email = :email';
        $stmt = $this->db->prepare( $query );
        $stmt->bindparam( ':email', $email );
        $stmt->execute();

        $test = $stmt->fetch( PDO::FETCH_ASSOC );
        if ( password_verify( $password, $test[ 'password' ] ) ) {
            if ( $test ) {
                $result = $test;
            }
        }
        if ( $result ) {

            $_SESSION[ 'role' ] = 'CTO';
            $_SESSION[ 'cto_id' ] = $result[ 'id' ];
            $_SESSION[ 'fullname' ] = $result[ 'username' ];
            $_SESSION[ 'email' ] = $result[ 'email' ];

            return 'CTO';
        }

        $query = 'SELECT member_id,password,fullname as username, email FROM member WHERE email = :email';
        $stmt = $this->db->prepare( $query );
        $stmt->bindparam( ':email', $email );
        $stmt->execute();

        $test = $stmt->fetch( PDO::FETCH_ASSOC );
        if ( $test ) {
            if ( password_verify( $password, $test[ 'password' ] ) ) {
                $result = $test;
            }
        }
        if ( $result ) {

            $_SESSION[ 'role' ] = 'member';
            $_SESSION[ 'member_id' ] = $result[ 'member_id' ];
            $_SESSION[ 'fullname' ] = $result[ 'username' ];
            $_SESSION[ 'email' ] = $result[ 'email' ];
            return 'member';
        }

    }
}

$emailregex = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
$isvalide = true;

if ( isset( $_POST[ 'btn_login' ] ) ) {
    $email = htmlspecialchars( trim( $_POST[ 'email' ] ) );
    $password = trim( $_POST[ 'password' ] );

    // Validation de l'email
    if ( empty( $email ) || !preg_match( $emailregex, $email ) ) {
        $isvalide = false;
        $_SESSION[ 'infoerr' ] = 'Email invalide. Veuillez entrer un email valide.';
    } else {
        $_SESSION[ 'erremail' ] = 'Email valide.';
    }

    // Validation du mot de passe
    if ( empty( $password ) ) {
        $isvalide = false;
        $_SESSION[ 'infoerr' ] = 'Mot de passe invalide. Veuillez entrer votre mot de passe.';
    }

    if ( $isvalide ) {
        $user = new login();
        $is_a = $user->loginset( $email, $password );

        switch ( $is_a ) {
            case 'admin':
            $_SESSION[ 'login_success' ] = 'Bienvenue sur votre page admin.';
            header( 'Location: /admin_dashboard' );
            exit();
            case 'CTO':
            $_SESSION[ 'login_success' ] = 'Bienvenue sur votre page CTO.';
            header( 'Location: /CTO_dashboard' );
            exit();
            case 'member':
            $_SESSION[ 'login_success' ] = 'Bienvenue sur votre page membre.';
            header( 'Location: /member_dashboard' );
            exit();
            default:
            $_SESSION[ 'infoerr' ] = 'Identifiants invalides. Veuillez réessayer.';
            header( 'Location: /' );
            exit();
        }
    } else {
        $_SESSION[ 'infoerr' ] = 'Connexion invalide. Veuillez corriger les erreurs : ' . $_SESSION[ 'erremail' ];
        header( 'Location: /' );
        exit();
    }
}

?>