<?php

class Transactions extends MY_Model2 {
    function __construct() {
        parent::__construct("data/transactions", "datetime");
    }
}
