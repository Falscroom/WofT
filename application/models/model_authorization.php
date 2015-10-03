<?php
class Model_Authorization extends Model
{
    public $errors = array();
    private function checkWithRegularExp($login) {
        if(!preg_match("/^[a-zA-Z0-9]+$/",$login))
        {
            return false;
        }
        if(strlen($login) < 3 or strlen($login) > 30)
        {
            return false;
        }
        return true;
    }
    private function checkUserInDB($login) {
        $this->prepareQuery("SELECT COUNT(id) FROM users WHERE login=:login");
        $this->query->bindParam(':login',$login);
        $data =  $this->executeQuery_Row();
        if($data[0] > 0)
        {
            return false;
        }
        return true;
    }
    private function checkPass($password,$password2) {
        if($password != $password2) {
            return false;
        }
        if(strlen($password) < 4 || strlen($password) > 30) {
            return false;
        }
        return true;
    }
    public function addUser($login,$password,$contacts,$password2) {
        if($this->checkUserInDB($login) && $this->checkWithRegularExp($login) && ($this->checkPass($password,$password2))) {
            $password = md5(md5(trim($password)));
            $this->prepareQuery("INSERT INTO users SET login=:login, password=:password,contact_info=:contacts");
            $this->query->bindParam(':login',$login);
            $this->query->bindParam(':password',$password);
            $this->query->bindParam(':contacts',$contacts);
            $this->executeQuery_Simple();
            return true;
        }
        else {
            return false;
        }
    }
}