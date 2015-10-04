<?php
class Model_Login extends Model
{
    private $thisUser;
    private $hash;
    public  $errors = array();
    private function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }
    public function checkPass($pass,$login) {
        $this->prepareQuery('SELECT id, password ,login FROM users WHERE login=:login LIMIT 1'); // Warning!!!
        $this->query->bindParam(':login',$login);
        $this->thisUser = $this->executeQuery_Row();
        if($this->thisUser["password"] === md5(md5($pass))) {
            return true;
        }
        return false;
    }
    private function createCookie() {
        setcookie("user_id", $this->thisUser['id'], time()+TIME);
        setcookie("hash", $this->hash, time()+TIME);
        setcookie("login", $this->thisUser['login'], time()+TIME);
    }
    function approveUser($login,$pass) {
        if($this->checkPass($pass,$login)) { #ПРОВЕРЯЕМ ПРАВИЛЬНОСТЬ ПАРОЛЯ
            $time = time() + 60 * 2;
            var_dump($time);
            $this->hash = md5($this->generateCode(10));
            $this->prepareQuery("INSERT INTO sessions SET user_id=:id, s_hash=:hash,s_time=:time");
            $this->query->bindParam(':hash',$this->hash);
            $this->query->bindParam(':id',$this->thisUser['id']);
            $this->query->bindParam(':time',$time); // Два часа!
            $this->executeQuery_Simple();
            $this->createCookie(); // Создаем куки
            return true;
        }
        else {
            Authorization::logOut();
            return false;
        }
    }
}