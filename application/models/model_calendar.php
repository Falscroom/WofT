<?php
Class Model_Calendar extends Authorization {
    public function getDates() {
        $this->prepare("SELECT * FROM events");
        $events_array = $this->execute_all();
        $json_encoded_array = [];


        foreach($events_array as $element_event) {
            $date_event = (new DateTime($element_event["ev_date"]))->format('m-d-Y');
            $event_text = '<span data-id="'.$element_event["id"].'">'.$element_event["ev_text"].'</span>';

            if(array_key_exists($date_event,$json_encoded_array)) {
                if(!is_array($json_encoded_array[$date_event])) {
                    $buffer = $json_encoded_array[$date_event];
                    $json_encoded_array[$date_event] = [];
                    array_push($json_encoded_array[$date_event],$buffer);
                }
                array_push($json_encoded_array[$date_event],$event_text);
            }
            else
                $json_encoded_array[$date_event] = $event_text;
        }
        return json_encode($json_encoded_array);

    }
}