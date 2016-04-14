<?php

class Movements extends MY_Model {
    function __construct() {
        parent::__construct("movements", "Datetime");
    }
    
    /**
     * 
     * @return type Array of associative arrays. each entry should have 'datetime', 'code', 'action', 'amount'
     */
    function find_recent_by_stock() 
    {
        //$this->db->order_by("Datetime", "desc"); 
        //$query = $this->db->get($this->_tableName); 
        //return $query->result();
        
        $this->load->helper('file');
        
        $csv_move_info = file_get_contents(BSX_SERVER."data/movement");
        
        if ( ! write_file('./temp.csv', $csv_move_info))
        {
            echo "Error loading stock movement information.<br />";
            echo "(Error saving temp csv file)";
            exit();
        }
        
        $movements = array();
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
                $movements[] = $temp;
            }
            fclose($handle);
        }
        delete_files('./temp.csv');
        
        rsort($movements);
        
        return $movements;
    }
    
}
