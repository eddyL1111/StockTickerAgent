<?php

class Transactions extends MY_Model {
    function __construct() {
        parent::__construct("transactions", "DateTime");
    }
    
    /**
     * Retrieve transaction table data from database.
     * @return type Associative array of transaction data from the database. 
     * Attributes: DateTime, Player, Stock, Trans, Quantity
     */
    function find_recent_by_stock() {
        $this->load->helper('file');
        
        $csv_trans_info = file_get_contents(BSX_SERVER."data/transactions");
        
        if ( ! write_file('./temp.csv', $csv_trans_info))
        {
            echo "Error loading stock information.<br />";
            echo "(Error saving temp csv file)";
            exit();
        }
        
        $transactions = array();
        $titles = array();
        $len = 0;
        $row = 0;
        if (($handle = fopen("./temp.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 256, ",")) !== FALSE) {
                if ($row++ == 0) {
                    $len = count($data);
                    $titles = $data;
                    continue;
                }
                $temp = array();
                for ($i = 0; $i < $len; $i++) {
                    $temp[$titles[$i]] = $data[$i];
                }
                $transactions[] = $temp;
            }
            fclose($handle);
        }
        delete_files('./temp.csv');
        
        return $transactions;
    }
}
