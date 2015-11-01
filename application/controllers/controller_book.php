<?php

class Controller_Book extends Controller
{
    public $bK;
    function __construct() {
        $this->view = new View();
        $this->model = new Model_Book();
    }

/*    function BaseOut() {
        $this->prepareQuery("SELECT * FROM book");
        $qd = $this->executeQuery_All();

        $data["rows"] = count($qd);
        for($i=0; $i<count($qd); $i++) {
            echo "number".$i.":  ".$qd[$i];
            $data["arr"][$i] = $qd[$i];
        }

    }
*/
    function action_dat()
    {
        //header('Content-Type: application/json ');
        //echo $this->model->getDat();
 /*       header('Content-type: text/html; charset=windows-1251');*/
        if(isset($_POST['group'])) {
            //echo "ajax!  " + $_POST['group'];
            //$re = ('<table class="table"> <thead> <tr> <th>���</th> <th>�������</th> </tr> </thead>');
            if(isset($_POST['group'])) {
                $res = $this->model->getDat($_POST['group']);
            }
            //$re = $_POST['group'];

            $re = ('<table class="table"> <thead> <tr> <th>ФИО</th> <th>Контакты</th> <th>Группа</th> </tr> </thead>');

            $re .= ('<tbody>');
            for($i=0; $i<count($res); $i++) {
                $re .= '<tr><td>'.iconv("UTF-8", "windows-1251", $res[$i]["user_info"]).'</td><td>'.iconv("UTF-8", "windows-1251", $res[$i]["contacts"]).
                    '</td><td>'.iconv("UTF-8", "windows-1251", $res[$i]["group_name"]).'</td></tr>';
            }
            $re .= '</tbody>';
        /*    echo iconv("windows-1251", "UTF-8", $re);*/
            echo $re;
        }
    }

    function action_index()
    {
        //$res["dat"] = $this->model->BaseOut();
        $this->view->generate('book_view.php','template_view.php', $this->model->prepareHeader());
    }
/*
    function table_paint()
    {
        for ($i=1; $i<5; $i++) {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>���</th>';
            echo '</tr>';
            echo '</thead>';
            echo '</table>';
        }
    }*/

}
//Controller_Book.table_pain();
