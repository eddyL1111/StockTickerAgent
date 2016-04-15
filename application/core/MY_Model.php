<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Generic data access abstraction.
 *
 * @author		JLP
 * @copyright           Copyright (c) 2010-2015, James L. Parry
 * ------------------------------------------------------------------------
 */
interface Active_record {
//---------------------------------------------------------------------------
//  Utility methods
//---------------------------------------------------------------------------

    /**
     * Return the number of records in this table.
     * @return int The number of records in this table
     */
    function size();

    /**
     * Return the field names in this table, from the table metadata.
     * @return array(string) The field names in this table
     */
    function fields();

//---------------------------------------------------------------------------
//  C R U D methods
//---------------------------------------------------------------------------
    /**
     * Create a new data object.
     * Only use this method if intending to create an empty record and then populate it.
     * @return object   An object with all its fields in place.
     */
    function create();

    /**
     * Add a record to the DB.
     * Request fails if the record already exists.
     * @param mixed $record The record to add, either an object or an associative array.
     */
    function add($record);

    /**
     * Retrieve an existing DB record as an object.
     * @param string $key Primary key of the record to return.
     * @param string $key2 Second part of composite key, if applicable
     * @return object The requested record, null if not found.
     */
    function get($key, $key2);

    /**
     * Update an existing DB record.
     * Method fails if the record does not exist.
     * @param mixed $record The record to update, either an object or an associative array.
     */
    function update($record);

    /**
     * Delete an existing DB record.
     * Method fails if the record does not exist.
     * @param string $key Primary key of the record to delete.
     * @param string $key2 Second part of composite key, if applicable
     */
    function delete($key, $key2);

    /**
     * Determine if a record exists.
     * @param string $key Primary key of the record sought.
     * @param string $key2 Second part of composite key, if applicable
     * @return boolean True if the record exists, false otherwise.
     */
    function exists($key, $key2);

    /**
     * Determine the highest key used.
     * @return string The highest key
     */
    function highest();

//---------------------------------------------------------------------------
//  Aggregate methods
//---------------------------------------------------------------------------
    /**
     * Retrieve all DB records.
     * @return array(object) All the records in the table.
     */
    function all($order);

    /**
     * Retrieve all DB records, but as a result set.
     * @return mixed The DB query result set.
     */
    function results();

    /**
     * Retrieve some of the DB records, namely those for which the
     * value of the field $what matches $which.
     * @param string    $what   Name of the field being matched.
     * @param   mixed   $which  Value sought.
     * @return mixed The selected records, as an array of records
     */
    function some($what, $which);
}

/**
 * Generic data access abstraction.
 *
 * @author		JLP
 * @copyright           Copyright (c) 2010-2015, James L. Parry
 * ------------------------------------------------------------------------
 */
interface Readable_record {
//---------------------------------------------------------------------------
//  Utility methods
//---------------------------------------------------------------------------

    /**
     * Return the number of records in this table.
     * @return int The number of records in this table
     */
    function size();

    /**
     * Return the field names in this table, from the table metadata.
     * @return array(string) The field names in this table
     */
    function fields();

//---------------------------------------------------------------------------
//  C R U D methods
//---------------------------------------------------------------------------

    /**
     * Retrieve an existing DB record as an object.
     * @param string $key Primary key of the record to return.
     * @param string $key2 Second part of composite key, if applicable
     * @return object The requested record, null if not found.
     */
    function get($key, $key2);

    /**
     * Determine if a record exists.
     * @param string $key Primary key of the record sought.
     * @param string $key2 Second part of composite key, if applicable
     * @return boolean True if the record exists, false otherwise.
     */
    function exists($key, $key2);

    /**
     * Determine the highest key used.
     * @return string The highest key
     */
    function highest();

//---------------------------------------------------------------------------
//  Aggregate methods
//---------------------------------------------------------------------------
    /**
     * Retrieve all DB records.
     * @return array(object) All the records in the table.
     */
    function all($order);

    /**
     * Retrieve all DB records, but as a result set.
     * @return mixed The DB query result set.
     */
    function results();

    /**
     * Retrieve some of the DB records, namely those for which the
     * value of the field $what matches $which.
     * @param string    $what   Name of the field being matched.
     * @param   mixed   $which  Value sought.
     * @return mixed The selected records, as an array of records
     */
    function some($what, $which);
}

/**
 * Generic data access model, for an RDB.
 *
 * @author		JLP
 * @copyright           Copyright (c) 2010-2014, James L. Parry
 * ------------------------------------------------------------------------
 */
class MY_Model extends CI_Model implements Active_Record {

    protected $_tableName;            // Which table is this a model for?
    protected $_keyField;             // name of the primary key field

//---------------------------------------------------------------------------
//  Housekeeping methods
//---------------------------------------------------------------------------

    /**
     * Constructor.
     * @param string $tablename Name of the RDB table
     * @param string $keyfield  Name of the primary key field
     */
    function __construct($tablename = null, $keyfield = 'id') {
        parent::__construct();

        if ($tablename == null)
            $this->_tableName = get_class($this);
        else
            $this->_tableName = $tablename;

        $this->_keyField = $keyfield;
    }

//---------------------------------------------------------------------------
//  Utility methods
//---------------------------------------------------------------------------

    /**
     * Return the number of records in this table.
     * @return int The number of records in this table
     */
    function size() {
        $query = $this->db->get($this->_tableName);
        return $query->num_rows();
    }

    /**
     * Return the field names in this table, from the table metadata.
     * @return array(string) The field names in this table
     */
    function fields() {
        return $this->db->list_fields($this->_tableName);
    }

//---------------------------------------------------------------------------
//  C R U D methods
//---------------------------------------------------------------------------
    // Create a new data object.
    // Only use this method if intending to create an empty record and then
    // populate it.
    function create() {
        $names = $this->db->list_fields($this->_tableName);
        $object = new StdClass;
        foreach ($names as $name)
            $object->$name = "";
        return $object;
    }

    // Add a record to the DB
    function add($record) {
        // convert object to associative array, if needed
        if (is_object($record)) {
            $data = get_object_vars($record);
        } else {
            $data = $record;
        }
        // update the DB table appropriately
        $key = $data[$this->_keyField];
        $object = $this->db->insert($this->_tableName, $data);
    }

    // Retrieve an existing DB record as an object
    function get($key, $key2 = null) {
        $this->db->where($this->_keyField, $key);
        $query = $this->db->get($this->_tableName);
        if ($query->num_rows() < 1)
            return null;
        return $query->row();
    }

    // Update a record in the DB
    function update($record) {
        // convert object to associative array, if needed
        if (is_object($record)) {
            $data = get_object_vars($record);
        } else {
            $data = $record;
        }
        // update the DB table appropriately
        $key = $data[$this->_keyField];
        $this->db->where($this->_keyField, $key);
        $object = $this->db->update($this->_tableName, $data);
    }

    // Delete a record from the DB
    function delete($key, $key2 = null) {
        $this->db->where($this->_keyField, $key);
        $object = $this->db->delete($this->_tableName);
    }

    // Determine if a key exists
    function exists($key, $key2 = null) {
        $this->db->where($this->_keyField, $key);
        $query = $this->db->get($this->_tableName);
        if ($query->num_rows() < 1)
            return false;
        return true;
    }

//---------------------------------------------------------------------------
//  Aggregate methods
//---------------------------------------------------------------------------
    // Return all records as an array of objects
    function all($order = 'asc') {
        if (strcmp($order, 'asc') == 0) {
            $this->db->order_by($this->_keyField, 'asc');
        } else {
            $this->db->order_by($this->_keyField, 'desc');
        }
        $query = $this->db->get($this->_tableName);
        return $query->result();
    }

    // Return all records as a result set
    function results() {
        $this->db->order_by($this->_keyField, 'asc');
        $query = $this->db->get($this->_tableName);
        return $query;
    }

    // Return filtered records as an array of records
    function some($what, $which) {
        $this->db->order_by($this->_keyField, 'asc');
        if (($what == 'period') && ($which < 9)) {
            $this->db->where($what, $which); // special treatment for period
        } else
            $this->db->where($what, $which);
        $query = $this->db->get($this->_tableName);
        return $query->result();
    }

    // Determine the highest key used
    function highest() {
        $this->db->select_max($this->_keyField);
        $query = $this->db->get($this->_tableName);
        $result = $query->result();
        if (count($result) > 0)
            return $result[0]->num;
        else
            return null;
    }

}

class MY_Model2 extends CI_Model implements Readable_record {

    protected $_tableName;            // Which table is this a model for?
    protected $_keyField;             // name of the primary key field
    protected $_csvData;
    protected $_csvTitles;

//---------------------------------------------------------------------------
//  Housekeeping methods
//---------------------------------------------------------------------------

    /**
     * Constructor.
     * @param string $tablename Name of the RDB table
     * @param string $keyfield  Name of the primary key field
     */
    function __construct($tablename = null, $keyfield = 'id') {
        parent::__construct();

        if ($tablename == null)
            $this->_tableName = get_class($this);
        else
            $this->_tableName = $tablename;

        $this->_keyField = $keyfield;
        
        $this->__download_CSV_data();
    }
    
    function __download_CSV_data() {
        $csv_file_data = file_get_contents(BSX_SERVER.$this->_tableName);
        
        if ( ! write_file('./temp.csv', $csv_file_data))
        {
            echo "Error loading csv information.<br />";
            echo "(Error saving temp csv file)";
            exit();
        }
        
        $csv_data = array();
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
                $csv_data[] = $temp;
            }
            fclose($handle);
        }
        delete_files('./temp.csv');
        
        $this->_csvTitles = $titles;
        $this->_csvData = $csv_data;
    }

//---------------------------------------------------------------------------
//  Utility methods
//---------------------------------------------------------------------------

    /**
     * Return the number of records in this table.
     * @return int The number of records in this table
     */
    function size() {
        return count($this->_csvData);
    }

    /**
     * Return the field names in this table, from the table metadata.
     * @return array(string) The field names in this table
     */
    function fields() {
        return $this->_csvTitles;
    }

//---------------------------------------------------------------------------
//  C R U D methods
//---------------------------------------------------------------------------
    // Retrieve an existing DB record as an object
    function get($key, $key2 = null) {
        $data_filtered = array();
        
        foreach($this->_csvData as $value) 
        {
            if (strcmp($value[$this->_keyField], $key) == 0) 
            {
                $data_filtered[] = $value;
            }
        }
        return $data_filtered;
    }

    // Determine if a key exists
    function exists($key, $key2 = null) {
        foreach($this->_csvData as $value) 
        {
            if (strcmp($value[$this->_keyField], $key) == 0) 
            {
                return true;
            }
        }
        return false;
    }

//---------------------------------------------------------------------------
//  Aggregate methods
//---------------------------------------------------------------------------
    // Return all records as an array of objects
    function all($order = 'asc') {
        if (count($this->_csvData) < 2) {
            return $this->_csvData;
        }
        
        $sortArray = array(); 

        foreach($this->_csvData as $datum){ 
            foreach($datum as $key=>$value){ 
                if(!isset($sortArray[$key])){ 
                    $sortArray[$key] = array(); 
                } 
                $sortArray[$key][] = $value; 
            }
        }
        
        if (strcmp($order, 'asc') == 0) 
        {
            array_multisort($sortArray[$this->_keyField], SORT_ASC, $this->_csvData); 
        } 
        else 
        {
            array_multisort($sortArray[$this->_keyField], SORT_DESC, $this->_csvData); 
        }
        return $this->_csvData;
    }

    // Return all records as a result set
    function results() {
        return $this->_csvData;
    }

    // Return filtered records as an array of records
    function some($what, $which) {
        $data = $this->all('desc');
        $results = array();
        
        foreach ($data as $value) {
            if ($value[$what] == $which) {
                $results[] = $value;
            }
        }
        
        return $results;
    }

    // Determine the highest key used
    function highest() {
        return null;
    }

}
