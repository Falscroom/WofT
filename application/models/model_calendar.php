<?php
Class Model_Calendar extends Authorization {
    public function getDates() {
        $this->prepare("SELECT * FROM events");
        $events_array = $this->execute_all();
        $json_encoded_array = [];
        foreach($events_array as $element_event) {
            $text_event =  '<span>'.$element_event["ev_text"].'</span>';
            $date_event = (new DateTime($element_event["ev_date"]))->format('m-d-Y');
            if(array_key_exists($date_event,$json_encoded_array)) {
                if(!is_array($json_encoded_array[$date_event])) {
                    $buffer_element = $json_encoded_array[$date_event];
                    $json_encoded_array[$date_event] = [];
                    array_push($json_encoded_array[$date_event],$buffer_element);
                }
                array_push($json_encoded_array[$date_event],$text_event);
            }
            else
                $json_encoded_array[$date_event] = $text_event;
        }
        return json_encode($json_encoded_array);

    }
}