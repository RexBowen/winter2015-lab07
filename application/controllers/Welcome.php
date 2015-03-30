<?php

/**
 * Our homepage. Show the most recently added quote.
 * 
 * controllers/Welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  Homepage: show a list of the orders on file
    //-------------------------------------------------------------

    function index() {
        // Build a list of orders
        $test = '.xml';
        $map = directory_map('./data/');
        $files = array();
        foreach ($map as $str) {
            if (substr_compare($str, $test, strlen($str) - strlen($test), strlen($test)) === 0 && $str != 'menu.xml') {

                //we don't need to load the entire orders in this case
                $this->order->load($str, 1);
                //remove the file extension, where 4 is the length of the extension
                array_push($files, array('filename' => substr($str, 0, strlen($str) - 4),
                    'customer' => $this->order->getCustomer()
                ));
            }
        }
        $this->data['pagebody'] = 'homepage';
        $this->data['files'] = $files;
        $this->render();
    }

    //-------------------------------------------------------------
    //  Show the "receipt" for a specific order
    //-------------------------------------------------------------

    function order($filename) {
        // Build a receipt for the chosen order
        // Present the list to choose from
        $this->data['pagebody'] = 'justone';
        $this->data['filename'] = $filename;
        $this->order->load($filename . '.xml', 2);
        $this->data['customer'] = $this->order->getCustomer();
        $this->data['type'] = $this->order->getType();
        $burger_list = array();

        $burgers = $this->order->burgers();
        $count = 1;
        foreach ($burgers as $burger) {
            array_push($burger_list, array(
                'name' => '*Burger #' . $count++ . '*',
                'base' => $this->menu->getPatty($burger->patty),
                'cheese' => $this->__getCheese($burger),
                'sauces' => $this->__getSauce($burger),
                'toppings' =>$this->__getTopping($burger)
            ));
        }
        $this->data['burgers'] = $burger_list;
        $this->render();
    }

    private function __getCheese($burger) {
            //tried to test with is_null, didn't work
        if (($burger->top)=='' && ($burger->bottom)=='')
            return '';
        $result = 'Cheese:';
        if (($burger->top)!='')
            $result.=' ' . $this->menu->getCheese($burger->top) . '(top)';

        if (($burger->bottom)!='')
            $result.=' ' . $this->menu->getCheese($burger->bottom) . '(bottom)';

        return $result;
    }
    
    private function __getTopping($burger) {
        
        if (count($burger->toppings) == 0)
            return 'Toppings: none';

        $result = 'Toppings:';
        foreach ($burger->toppings as $item) {
            $result.=' '.$this->menu->getTopping((string) $item);
        }

        return $result;
    }

    private function __getSauce($burger) {
        if (count($burger->sauces) == 0)
            return 'Sauces: none';

        $result = 'Sauces:';
        foreach ($burger->sauces as $sauce) {
            $result.=' '.$this->menu->getSauce((string) $sauce);
        }

        return $result;
    }

}
