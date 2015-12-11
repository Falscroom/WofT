<?php
Class Model_Book extends Authorization {

    function prepareHeader() {
        $qrGr = "SELECT group_name FROM groups";
        $this->prepare($qrGr);
        $data["groups"] = $this->execute_all();
        $qrD = "SELECT ev_date FROM events";
        $this->prepare($qrD);
        $data["dates"] = $this->execute_all();
        //$data = $this->executeQuery_All();
        //$data["groups"]["rows"] = count($data["droups"]);
        $data['login'] = $this->get_login();
        return $data;
    }

    function right() {
        if($this->get_rights() & U_EDIT) {
            return 0;
        }
        else {
            return 1;
        }
    }

    public function saveStudentInBase($id, $user_info, $group, $contacts) {
        //return $id." ".$user_info." ".$group." ".$contacts;
        if($group == "notchanged") {
            //составляем обычный запрос
        }
        elseif($group == "notgroup") {
            //прописываем в базу group_id null
        }
        else {
            //получаем group_id
            $quer = 'SELECT id FROM groups WHERE group_name="'.$group.'"';
            $this->prepare($quer);
            $group_id = $this->execute_all();
            $quer = 'UPDATE users SET '.'user_info = "'.$user_info.'", group_id = '.$group_id[0]["id"].', contacts = "'.$contacts.'" WHERE id = '.$id;
            $this->prepare($quer);
            $this->execute_simple();
        }
    }

    public function updateMarks($id, $group, $event, $be, $mark) {
        if($be == "Да") {$be = 1;} else {$be = 0;}
        $quer = 'SELECT id_student FROM marks WHERE id_student='.$id.' AND id_group='.$group.' AND id_event='.$event;
        $this->prepare($quer);
        $vsp = $this->execute_all();
        if($vsp != NULL) {
            $quer = 'UPDATE marks SET mark=' . $mark . ', visit=' . $be . ' WHERE id_student=' . $id . ' AND id_group=' . $group . ' AND id_event=' . $event;
            $this->prepare($quer);
            $this->execute_simple();
        }
        else {
            $quer ='INSERT INTO marks (id_event, id_group, id_student, mark, visit) VALUES ('.$event.', '.$group.', '.$id.', '.$mark.', '.$be.')';
            $this->prepare($quer);
            $this->execute_simple();
        }
    }

    public function getWithGroupAndDate($group, $date) {
        $quer = 'SELECT id FROM groups WHERE group_name="'.$group.'"';
        $this->prepare($quer);
        $group_id = $this->execute_all();
        $quer = 'SELECT COUNT(*) FROM events WHERE ev_group='.$group_id[0]["id"];
        $this->prepare($quer);
        $nTasks = $this->execute_all();
        $quer = 'SELECT events.id FROM events WHERE events.ev_group='.$group_id[0]["id"].' AND events.ev_date="'.$date.'"';
        //$quer = 'SELECT events.id FROM events WHERE events.ev_date="2015-12-15"';
        $this->prepare($quer);
        $id_event = $this->execute_all();
        //$nTasks[0]["COUNT(*)"]
        $quer = 'SELECT users.id FROM users WHERE users.group_id='.$group_id[0]["id"];
        $this->prepare($quer);
        $id_all = $this->execute_all();
        //return $id_all[0]["id"];

        //доработать условие в случае если нет этого события

        if($id_event == NULL) {
            return 0;
        }

        for($i=0; $i<count($id_all); $i++) {
            //доделать совпадение id события!!!
            $quer = 'SELECT marks.visit, marks.mark FROM marks WHERE marks.id_student='.$id_all[$i]["id"].' AND marks.id_group='.$group_id[0]["id"].' AND marks.id_event='.$id_event[0]["id"];
            $this->prepare($quer);
            $tek = $this->execute_all();
            //return $tek;
            $mainRes[$i]["allRei"] = $nTasks[0]["COUNT(*)"]*10;
            $quer = 'SELECT SUM(marks.mark) FROM marks WHERE marks.id_student='.$id_all[$i]["id"];
            $this->prepare($quer);
            $rei_st = $this->execute_all();
            if($rei_st[0]["SUM(marks.mark)"] == NULL) {
                $mainRes[$i]["rei"] = 0;
            }
            else {
                $mainRes[$i]["rei"] = $rei_st[0]["SUM(marks.mark)"];
            }
            if($tek != NULL) {
                $mainRes[$i]["visit"] = $tek[0]["visit"];
                $mainRes[$i]["mark"] = $tek[0]["mark"];
            }
            else if($tek == NULL) {
                $mainRes[$i]["visit"] = 0;
                $mainRes[$i]["mark"] = 0;
            }
            $quer = 'SELECT users.user_info FROM users WHERE users.id='.$id_all[$i]["id"];
            $this->prepare($quer);
            $vs = $this->execute_all();
            $mainRes[$i]["user_info"] = $vs[0]["user_info"];
            $mainRes[$i]["id"] = $id_all[$i]["id"];
            //перезапись
            $vsc = $i;
        }
        //для шапки после фильров но перед таблицей
        $mainRes[0]["ind_func"] = $vsc;
        $mainRes[$vsc]["group"]["name"] = $group;
        $mainRes[$vsc]["group"]["id"] = $group_id[0]["id"];
        $mainRes[$vsc]["event"]["date"] = $date;
        $mainRes[$vsc]["event"]["id"] = $id_event[0]["id"];
        //профессор
        $quer = 'SELECT professor FROM events WHERE id='.$id_event[0]["id"];
        $this->prepare($quer);
        $prof = $this->execute_all();
        if($prof != NULL) {
            $mainRes[$vsc]["professor"]["id"] = $prof[0]["professor"];
            $quer = 'SELECT user_info FROM users WHERE id=' . $prof[0]["professor"];
            $this->prepare($quer);
            $prof = $this->execute_all();
            if ($prof == NULL) {
                $mainRes[$vsc]["professor"]["user_info"] = "";
            } else {
                $mainRes[$vsc]["professor"]["user_info"] = $prof[0]["user_info"];
            }
        }
        else {
            $mainRes[$vsc]["professor"]["user_info"] = "";
            $mainRes[$vsc]["professor"]["id"] = NULL;
        }

        return $mainRes;
    }

    public function aboutEvent($id) {
        $qd = 'SELECT ev_group, ev_date FROM events WHERE id='.$id;
        $this->prepare($qd);
        $r = $this->execute_all();
        $qd = 'SELECT group_name FROM groups WHERE id='.$r[0]["ev_group"];
        $this->prepare($qd);
        $r2 = $this->execute_all();
        $res1["group_name"] = $r2[0]["group_name"];
        $res1["date"] = $r[0]["ev_date"];
        return $res1;
    }

    public function getOnlyGroup($group) {
        //var_dump($group);
        //SELECT users.user_info, users.contacts, groups.group_name FROM `users` join groups on users.group_id = groups.id WHERE groups.group_name = "��������"
        if($group != "*") {
            $quer = 'SELECT users.user_info, users.contacts, groups.group_name, users.id FROM users JOIN groups ON users.group_id = groups.id WHERE groups.group_name = ' . '"' . $group . '"';
            $this->prepare($quer);
            $qd = $this->execute_all();

            //добавить рейтинг и посещаемость студента
            $quer = 'SELECT groups.id FROM groups WHERE groups.group_name = "'.$group.'"';
            $this->prepare($quer);
            $vs = $this->execute_all();
            $group_id = $vs[0]["id"];
            $quer = 'SELECT COUNT(*) FROM events WHERE ev_group = '.$group_id;
            $this->prepare($quer);
            $vs = $this->execute_all();
            if($vs[0] != NULL) {
                $kT[0] = $vs[0]["COUNT(*)"];
            } else {
                $kT[0] = 0;
            }

            for($i=0; $i<count($qd); $i++) {
                $quer = 'SELECT COUNT(*) FROM marks WHERE visit=1 AND id_student = '.$qd[$i]["id"];
                $this->prepare($quer);
                $vs = $this->execute_all();
                if($vs[0] == NULL) {
                    $qd[$i] = 0;
                } else {
                    $qd[$i]["visit"] = $vs[0]["COUNT(*)"];
                }
                $quer = 'SELECT SUM(mark) FROM marks WHERE id_student='.$qd[$i]["id"];
                $this->prepare($quer);
                $vs = $this->execute_all();
                if($vs[0] == NULL) {
                    $qd[$i]["rei"] = 0;
                } else {
                    $qd[$i]["rei"] = $vs[0]["SUM(mark)"];
                }
            }

        }
        else {
            //здесь добавить, чтобы студенты без группы тоже отображались в общих списках
            $quer = 'SELECT users.user_info, users.contacts, groups.group_name FROM users JOIN groups ON users.group_id = groups.id';
            $this->prepare($quer);
            $qd = $this->execute_all();
        }
        //var_dump($quer);

        /*    $mainRes[$i]["allRei"] = $nTasks[0]["COUNT(*)"]*10;
            $quer = 'SELECT SUM(marks.mark) FROM marks WHERE marks.id_student='.$id_all[$i]["id"];
            $this->prepare($quer);
            $rei_st = $this->execute_all();
        */
        $kT[1] = $qd;
        return $kT;
    }

}