<?php
Class Model_Admin extends Authorization {
    function get_professors() {
        $this->prepare("SELECT id,user_info FROM users WHERE rights >= ".U_PROFESSOR." AND if_stuff = 1");
        return $this->execute_all();
    }
    function get_groups() {
        $this->prepare("SELECT id,group_name FROM groups");
        return $this->execute_all();
    }
    function check_date() { //TODO
    }
    function get_id($array,$find_str,$column_name) {
        return $array[ array_search($find_str,array_column($array, $column_name) ) ]["id"];
    }
    function get_events($date) {
        $this->prepare("SELECT * FROM events WHERE ev_date =:ev_date");
        $this->query->bindParam(":ev_date",$date,PDO::PARAM_STR);
        return $this->execute_all();
    }
    function create_event($event) {
        $this->prepare("INSERT INTO events(id,professor,ev_group,ev_date,ev_text)
VALUES (NULL,:professor_id,:group_id,:ev_date,:ev_text)");
        $this->query->bindParam(":professor_id",$event->professor_id,PDO::PARAM_INT);
        $this->query->bindParam(":group_id",$event->group_id,PDO::PARAM_INT);
        $this->query->bindParam(":ev_date",$event->ev_date,PDO::PARAM_STR);
        $this->query->bindParam(":ev_text",$event->ev_text,PDO::PARAM_STR);
        $this->execute_simple();
    }

}