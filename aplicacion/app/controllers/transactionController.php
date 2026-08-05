<?php

class TransactionController extends Controller {

    function __construct(){

    }

    public function create(){
        
        $this->view('transaction/create');
    }
}