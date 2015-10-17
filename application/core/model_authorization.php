<?php
class Authorization extends Model {
    private $current_rights = NULL;
    static function delete_cookie() {
        if(isset($_COOKIE['hash'])) {
            setcookie("user_id", "", time() - TIME*12);
            setcookie("hash", "", time() - TIME*12);
            setcookie("login", "", time() - TIME*12);
        }
    }
    public function delete_session() {
        $this->prepare("DELETE FROM sessions WHERE user_id=:id");
        $this->query->bindParam(':id',intval($_COOKIE['user_id']));
        $this->execute_simple();
        Authorization::delete_cookie();
    }
    public function get_login() {
        if(!$this->current_rights)
            $this->current_rights = $this->approve_session();
        if($this->current_rights !== false)
            return $_COOKIE['login'];
        return NULL;
    }
    public function get_rights() {
        if(!$this->current_rights)
            $this->current_rights = $this->approve_session();
        return $this->current_rights;
    }
    public function approve_session($login = NULL) {
        if (isset($_COOKIE['user_id']) and isset($_COOKIE['hash']))
        {
            $this->prepare("SELECT sessions.*,users.login,users.rights FROM sessions,users
WHERE user_id = :id AND s_hash=:hash  AND users.id = sessions.user_id LIMIT 1");
            $this->query->bindParam(':id',intval($_COOKIE['user_id']));
            $this->query->bindParam(':hash',$_COOKIE['hash']);
            $user_data = $this->execute_row();
            if(($user_data['s_hash'] !== $_COOKIE['hash']) or ($user_data['user_id'] !== $_COOKIE['user_id'])
                or ($user_data['s_time'] < time()) or ($login !== NULL && $login !== $user_data["login"]))
            {   #в этом случае сносим существующие куки
                $this->delete_session();
                return false;
            }
            else
            {
                return $user_data["rights"];
            }
        }
        else {
            return false;
        }
    }
}