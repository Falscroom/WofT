<?php
Class Model_Calendar extends Model {
    public function getDates() {
        $this->prepareQuery("SELECT * FROM Events");
        $events_array = $this->executeQuery_All();
/*        $arr = Array((new DateTime($result[0]["ev_date"]))->format('m-d-Y') => $result[0]["professor"]);
        return  json_encode($arr);*/
        foreach($events_array as $element_event) {
            $text_event =  ;
            $date_event = (new DateTime($element_event["ev_date"]))->format('m-d-Y');
        }

    }
}