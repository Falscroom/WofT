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
    public function getOptions() {
        $this->prepareQuery("SELECT * FROM groups");
        return $this->executeQuery_All();
    }
    private function checkUserInDB($login,$stuff) {
        if($stuff)
            $this->prepareQuery("SELECT COUNT(id) FROM stuff WHERE login=:login");
        else
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
    public function addUser($login,$password,$contacts,$password2,$nmf,$group,$stuff = false) {
        if($this->checkUserInDB($login,$stuff) && $this->checkWithRegularExp($login) && ($this->checkPass($password,$password2))) {
            $password = md5(md5(trim($password)));
            if($stuff)
                $this->prepareQuery("INSERT INTO stuff(id, approved, login, password, NMF, contact_info) VALUES (NULL,false,:login,:password,:nmf,:contacts)");
            else
                $this->prepareQuery("INSERT INTO users SET login=:login, password=:password,contact_info=:contacts,NMF=:nmf");
            $this->query->bindParam(':login',$login,PDO::PARAM_STR);
            $this->query->bindParam(':password',$password,PDO::PARAM_STR);
            $this->query->bindParam(':contacts',$contacts,PDO::PARAM_STR);
            $this->query->bindParam(':nmf',$nmf,PDO::PARAM_STR);
            $this->executeQuery_Simple();
            return true;
        }
        else {
            return false;
        }
    }
}