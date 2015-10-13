<?php
Class Model_Calendar extends Model {
    public function getDates() {
        $this->prepare("SELECT * FROM events");
        $events_array = $this->execute_all();
        foreach($events_array as $element_event) {
            $text_event =  '<span>'.$element_event["ev_text"].'</span>';
            $date_event = (new DateTime($element_event["ev_date"]))->format('m-d-Y');
            $json_encoded_array[$date_event] = $text_event;
        }
        return json_encode($json_encoded_array);

    }
}