<?php

class KurssiController extends BaseController{
    
    public static function index(){
        $kurssit = Kurssi::all();
        View::make('kurssit/index.html', array('kurssit' => $kurssit));
    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

