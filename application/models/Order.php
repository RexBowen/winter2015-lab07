<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Order extends CI_Model {

    protected $xml = null;
    protected $customer_name = null;
    protected $burgers = array();
    protected $type = null;
    protected $loaded_level = -1;

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    //level specifies how much of the xml we want to parse
    public function load($filename, $level = php_int_max) {
        switch ($level) {
            case $level >= 1:
                $this->xml = simplexml_load_file(DATAPATH . $filename);
                $this->customer_name = (string) $this->xml->customer;
                $this->type = (string) $this->xml['type'];
            case $level >= 2:
                foreach ($this->xml->burger as $burger) {
                    $record = new stdClass();
                    $record->patty = (string)$burger->patty['type'];
                    $record->top = (string) $burger->cheeses['top'];
                    $record->bottom = (string) $burger->cheeses['bottom'];
                    $sauces = array();
                    $toppings = array();
                    foreach ($burger->sauce as $sauce)
                        array_push($sauces, $sauce['type']);
                    foreach ($burger->topping as $topping)
                        array_push($toppings, $topping['type']);
                    $record->toppings = $toppings;
                    $record->sauces = $sauces;
                    array_push($this->burgers, $record);
                }
        }
        $this->loaded_level = ($level);
    }

    // retrieve a list of burgers in the order
    function burgers() {
        return $this->burgers;
    }

    /* getter methods */

    public function getCustomer() {
        return $this->customer_name;
    }

    /* getter methods */
    public function getType() {
        return $this->type;
    }

}
