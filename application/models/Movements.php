<?php

class Movements extends MY_Model2 {
    function __construct() {
        parent::__construct("data/movement", "datetime");
    }
}
