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
                $this->order->load($str);
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
        $this->menu->patties();
        $this->render();
    }

}
