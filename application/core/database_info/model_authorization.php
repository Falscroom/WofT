<?php
class Authorization extends Model {
    static function logOut() {
        if(isset($_COOKIE['hash'])) {
            setcookie("user_id", "", time() - TIME*12);
            setcookie("hash", "", time() - TIME*12);
            setcookie("login", "", time() - TIME*12);
        }
    }
    private function deleteSessions() {
        $this->prepareQuery("DELETE FROM sessions WHERE user_id=:id");
        $this->query->bindParam(':id',intval($_COOKIE['user_id']));
        $this->executeQuery_Simple();
    }
    public function mainApproveLogin() {
        if (isset($_COOKIE['user_id']) and isset($_COOKIE['hash']))
        {
            $this->prepareQuery("SELECT * FROM sessions WHERE user_id = :id AND hash=:hash LIMIT 1");
            $this->query->bindParam(':id',intval($_COOKIE['user_id']));
            $this->query->bindParam(':hash',$_COOKIE['hash']);
            $userData = $this->executeQuery_Row();
            if(($userData['hash'] !== $_COOKIE['hash']) or ($userData['user_id'] !== $_COOKIE['user_id'])
                or ((long2ip($userData['ip']) !== $_SERVER['REMOTE_ADDR'])  and ($userData['user_id'] !== "0")) or ($userData['time'] < time()))
            {   #в этом случае сносим существующие куки
                $this->deleteSessions();
                Authorization::logOut();
                return false;
            }
            else
            {
                return true;
            }
        }
        else {
            return false;
        }
    }
}