<?php

/**
 * This is a "CMS" model for quotes, but with bogus hard-coded data.
 * This would be considered a "mock database" model.
 *
 * @author jim
 */
class Menu extends CI_Model {

    protected $xml = null;
    protected $patties = array();
    protected $cheeses = array();
    protected $sauces = array();
    protected $toppings = array();

    // Constructor
    public function __construct() {
        parent::__construct();
        $this->xml = simplexml_load_file(DATAPATH . 'menu.xml');

        foreach ($this->xml->patties->patty as $patty) {
            $record = new stdClass();
            $record->code = (string) $patty['code'];
            $record->name = (string) $patty;
            $record->price = (float) $patty['price'];
            $this->patties[$record->code] = $record;
            
        }
        
        $this->__readCheese();
        $this->__readSauce();
        $this->__readTopping();
    }

    private function __readCheese() {
        foreach ($this->xml->cheeses->cheese as $item) {
            $record = new stdClass();
            $record->code = (string) $item['code'];
            $record->name = (string) $item;
            $record->price = (float) $item['price'];
            $this->cheeses[$record->code] = $record;
        }
    }

    //sauce have no price
    private function __readSauce() {
        foreach ($this->xml->sauces->sauce as $item) {
            $record = new stdClass();
            $record->code = (string) $item['code'];
            $record->name = (string) $item;
            $this->sauces[$record->code] = $record;
        }
    }

    private function __readTopping() {
        foreach ($this->xml->toppings->topping as $item) {
            $record = new stdClass();
            $record->code = (string) $item['code'];
            $record->name = (string) $item;
            $record->price = (float) $item['price'];
            $this->toppings[$record->code] = $record;
        }
    }

    // Not used 
    function patties() {
        return $this->patty_names;
    }

    function getCheese($code) {
        if (isset($this->cheeses[$code]))
            return $this->cheeses[$code]->name;
        else
            return null;
    }

    function getSauce($code) {
        if (isset($this->sauces[$code]))
            return $this->sauces[$code]->name;
        else
            return null;
    }

    function getPatty($code) {
        if (isset($this->patties[$code]))
            return $this->patties[$code]->name;
        else
            return 'null';
    }

    function getTopping($code) {
        if (isset($this->toppings[$code]))
            return $this->toppings[$code]->name;
        else
            return null;
    }

}
