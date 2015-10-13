<?php
class Model_Authorization extends Model
{
    public $errors = array();
    private function check_login($login) {
/*        if(!preg_match("/^[a-zA-Z0-9]+$/",$login))
        {
            return false;
        }
        if(strlen($login) < 3 or strlen($login) > 30)
        {
            return false;
        }*/
        return true;
    }
    public function get_options() {
        $this->prepare("SELECT * FROM groups");
        return $this->execute_all();
    }
    private function unique_login($login,$stuff) {
        if($stuff)
            $this->prepare("SELECT COUNT(id) FROM stuff WHERE login=:login");
        else
            $this->prepare("SELECT COUNT(id) FROM users WHERE login=:login");
        $this->query->bindParam(':login',$login);
        $data =  $this->execute_row();
        if($data[0] > 0)
        {
            return false;
        }
        return true;
    }
    private function check_pass($password,$confirm_password) {
        if($password != $confirm_password) {
            return false;
        }
/*        if(strlen($password) < 4 || strlen($password) > 30) {
            return false;
        }*/
        return true;
    }
    public function add_user($user) {
        if($this->unique_login($user->login,$user->if_stuff) && $this->check_login($user->login) && ($this->check_pass($user->password,$user->confirm_password))) {
            $user->password = md5(md5(trim($user->password)));
            if($user->if_stuff)
                $this->prepare("INSERT INTO stuff(id, approved, login, password, user_info, contact_info) VALUES (NULL,false,:login,:password,:user_info,:contacts)");
            else
                $this->prepare("INSERT INTO users SET login=:login, password=:password,contact_info=:contacts,user_info=:user_info");
            $this->query->bindParam(':login',$user->login,PDO::PARAM_STR);
            $this->query->bindParam(':password',$user->password,PDO::PARAM_STR);
            $this->query->bindParam(':contacts',$user->contacts,PDO::PARAM_STR);
            $this->query->bindParam(':user_info',$user->user_info,PDO::PARAM_STR);
            $this->execute_simple();
            return true;
        }
        else {
            return false;
        }
    }
}