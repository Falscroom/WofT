<?php
Class Model_Book extends Model {
    function BaseOut(){
        $quer = "SELECT * FROM book";
        $this->prepare($quer);
        $qd = $this->execute_all();

//        $data["rows"] = count($qd);

//        echo "number 0: ".$qd[0][0];
        $mas = $qd;
        $mas["rows"] = count($qd);
        $mas["fields"] = count($qd[0])/2;
        $data["dat"] = $mas;

        $data["login"] = "Test.";

        return $data;
    }

    function prepareHeader() {
        $qrGr = "SELECT group_name FROM groups";
        $this->prepare($qrGr);
        $data["groups"] = $this->execute_all();
        //$data = $this->executeQuery_All();
        //$data["groups"]["rows"] = count($data["droups"]);
        return $data;
    }

    public function getDat($group) {
        var_dump($group);
        //SELECT users.user_info, users.contacts, groups.group_name FROM `users` join groups on users.group_id = groups.id WHERE groups.group_name = "��������"
        if($group != "*") {
            $quer = 'SELECT users.user_info, users.contacts, groups.group_name FROM users JOIN groups ON users.group_id = groups.id WHERE groups.group_name = ' . '"' . $group . '"';
        }
        else {
            $quer = 'SELECT users.user_info, users.contacts, groups.group_name FROM users JOIN groups ON users.group_id = groups.id';
        }
        var_dump($quer);
        $this->prepare($quer);
        $qd = $this->execute_all();
        var_dump($this->errorCode);
        // ��� ����������� ���� "value of qd:  ".$qdGroupId[0]["id"]
        return $qd;
    }

}