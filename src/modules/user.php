<?php

class user {
    protected $fullname;
    protected $email;
    protected $password;

    public function __construct( $fullname, $email, $password ) {
        $this->fullname = $fullname;
        $this->email = $email;
        $this->password = $password;
    }

}
?>