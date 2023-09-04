<?php
    function match_data($event_id) {
        $_SERVER['REQUEST_URI'] == "/" ? require 'config/config.php' : require '../config/config.php';
        global $my_api;

        $get_event = JwtApiCall($my_api."event/read", "POST", array('eventId' => $event_id), $_SESSION['token']);
        class event_dto {
            private $eventId;
            private $title;
            private $gender;
            private $money;
            private $description;
            private $startTime;
            private $endTime;
            private $location;

            public function __construct($eventId, $title, $gender, $money, $description, $startTime, $endTime, $location) {
                $this->eventId = $eventId;
                $this->title = $title;
                $this->gender = $gender;
                $this->money = $money;
                $this->description = $description;
                $this->startTime = $startTime;
                $this->endTime = $endTime;
                $this->location = $location;
            }
            public function get_event_id() {
                return $this->eventId;
            }
        
            public function get_event_title() {
                return $this->title;
            }

            public function get_event_gender() {
                return $this->gender;
            }

            public function get_event_money() {
                return $this->money;
            }

            public function get_event_description() {
                return $this->description;
            }

            public function get_event_startTime_datetimeLocal() {
                return $this->startTime;
            }

            public function get_event_startTime() {
                $this->startTime = strtotime($this->startTime);
                $hour = date("H", $this->startTime);
                $minute = date("i", $this->startTime);

                if ($hour <= 12) {
                    $this->startTime = '오전 ' . $hour . ':' . $minute;
                } else {
                    $hour -= 12;
                    $this->startTime = '오후 ' . $hour . ':' . $minute;
                }

                return $this->startTime;
            }

            public function get_event_endTime() {
                $this->endTime = strtotime($this->endTime);
                $hour = date("H", $this->endTime);
                $minute = date("i", $this->endTime);

                if ($hour <= 12) {
                    $this->endTime = '오전 ' . $hour . ':' . $minute;
                } else {
                    $hour -= 12;
                    $this->endTime = '오후 ' . $hour . ':' . $minute;
                }

                return $this->endTime;
            }

            public function get_event_endTime_datetimeLocal() {
                return $this->endTime;
            }

            public function get_event_location() {
                return $this->location;
            }

        }
        $event_dto = new event_dto($get_event['readResult']['eventId'], $get_event['readResult']['title'], $get_event['readResult']['gender'], $get_event['readResult']['money'], $get_event['readResult']['description'], $get_event['readResult']['startTime'], $get_event['readResult']['endTime'], $get_event['readResult']['location']);
        $event_dto_id = $event_dto->get_event_id();
        $event_dto_title = $event_dto->get_event_title();
        $event_dto_gender = $event_dto->get_event_gender();
        $event_dto_money = $event_dto->get_event_money();
        $event_dto_description = $event_dto->get_event_description();
        $event_dto_startTime_datetimeLocal = $event_dto->get_event_startTime_datetimeLocal();
        $event_dto_startTime = $event_dto->get_event_startTime();
        $event_dto_endTime_datetimeLocal = $event_dto->get_event_endTime_datetimeLocal();
        $event_dto_endTime = $event_dto->get_event_endTime();
        $event_dto_location = $event_dto->get_event_location();
        if ($event_dto_gender == 'MALE') {
            $event_dto_gender = '남자 경기';
        } elseif ($event_dto_gender == 'FEMALE') {
            $event_dto_gender = '여자 경기';
        } else {
            $event_dto_gender = '혼성 경기';
        }

        $event_info = [
            "event_dto_id" => $event_dto_id,
            "event_dto_title" => $event_dto_title,
            "event_dto_gender" => $event_dto_gender,
            "event_dto_money" => $event_dto_money,
            "event_dto_description" => $event_dto_description,
            "event_dto_startTime_datetimeLocal" => $event_dto_startTime_datetimeLocal,
            "event_dto_startTime" => $event_dto_startTime,
            "event_dto_endTime_datetimeLocal" => $event_dto_endTime_datetimeLocal,
            "event_dto_endTime" => $event_dto_endTime,
            "event_dto_location" => $event_dto_location
        ];

        return $event_info;
    }
?>