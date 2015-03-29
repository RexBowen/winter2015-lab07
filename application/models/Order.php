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
    protected $patty_names = array();
    protected $patties = array();

    public function getCustomer(){
        return $this->customer_name;
    }
    // Constructor
    public function __construct() {
        parent::__construct();
    }
    public function load($filename) {
        $this->xml = simplexml_load_file(DATAPATH .$filename);

        $this->customer_name = (string) $this->xml->customer;
        // build a full list of patties - approach 2
        /*
        foreach ($this->xml->burger as $burger) {
            $record = new stdClass();
            $record->partty = (string) $burger->patty['type'];
            $record->top = (string) $burger->cheese['top'];
            $record->bottom=(string) $burger->cheese['bottom'];
            $record->sauces = (float) $patty['price'];
            $record->toppings = 'asdf';
            $patties[$record->code] = $record;
        }*/
    }

    // retrieve a list of patties, to populate a dropdown, for instance
    function patties() {
        return $this->patty_names;
    }

    // retrieve a patty record, perhaps for pricing
    function getPatty($code) {
        if (isset($this->patties[$code]))
            return $this->patties[$code];
        else
            return null;
    }

}
