<?php

class DebtController extends Controller
{

    public function index()
    {
        return $this->view("debts/index");
    }
}