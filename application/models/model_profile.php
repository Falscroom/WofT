<?php
class Model_Profile extends Authorization
{
    function get_user($login) {
        $this->prepare("SELECT * FROM users WHERE login=:login");
        $this->query->bindParam(":login",$login,PDO::PARAM_STR);
        return $this->execute_row();
    }
}