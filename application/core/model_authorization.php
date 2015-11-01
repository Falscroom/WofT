<?php
class Authorization extends Model {
    private $current_rights = null;
    static function delete_cookie() {
        if(isset($_COOKIE['hash'])) {
            setcookie("user_id", "", time() - TIME*12);
            setcookie("hash", "", time() - TIME*12);
            setcookie("login", "", time() - TIME*12);
        }
    }
    public function delete_session() {
        $user_id = (int) $_COOKIE['user_id'];
        $this->prepare("DELETE FROM sessions WHERE user_id=:id");
        $this->query->bindParam(':id',$user_id,PDO::PARAM_INT);
        $this->execute_simple();
        Authorization::delete_cookie();
    }
    public function get_login() {
        if($this->approve_session())
            return $_COOKIE['login'];
        return false;
    }
    public function get_rights() {
        if($this->current_rights === null)
            $this->approve_session();
        return $this->current_rights;
    }
    public function approve_session($login = null) {
        if (isset($_COOKIE['user_id']) and isset($_COOKIE['hash']))
        {
            $user_id = (int) $_COOKIE['user_id'];
            $this->prepare("SELECT sessions.*,users.login,users.rights FROM sessions,users
WHERE user_id = :id AND s_hash=:hash  AND users.id = sessions.user_id LIMIT 1");
            $this->query->bindParam(':id',$user_id,PDO::PARAM_INT);
            $this->query->bindParam(':hash',$_COOKIE['hash'],PDO::PARAM_STR);
            $user_data = $this->execute_row();
            if(($user_data['s_hash'] !== $_COOKIE['hash']) or ($user_data['user_id'] !== $_COOKIE['user_id'])
                or ($user_data['s_time'] < time()) or ($login !== null && $login !== $user_data["login"]))
            {   #в этом случае сносим существующие куки
                $this->delete_session();
                return false;
            }
            else
            {
                $this->current_rights = $user_data["rights"];
                return true;
            }
        }
        else {
            return false;
        }
    }
}