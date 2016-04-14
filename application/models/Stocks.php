<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Stocks extends MY_Model {
    function __construct() {
        parent::__construct("stocks", "Code");
    }
    
    function all($order = 'asc') {
        $this->load->helper('file');
        
        $csv_stock_info = file_get_contents(BSX_SERVER."data/stocks");
        
        if ( ! write_file('./temp.csv', $csv_stock_info))
        {
            echo "Error loading stock information.<br />";
            echo "(Error saving temp csv file)";
            exit();
        }
        
        $stocks = array();
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
                $stocks[] = $temp;
            }
            fclose($handle);
        }
        delete_files('./temp.csv');
        
        ksort($stocks);
        
        return $stocks;
    }
}