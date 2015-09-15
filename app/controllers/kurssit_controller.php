<?php

class KurssiController extends BaseController{
    
    public static function index(){
        $kurssit = Kurssi::all();
        View::make('kurssit/index.html', array('kurssit' => $kurssit));
    }
    
    public static function show($nimi) {
        $nimi = Kurssi::find($nimi);
        View::make('kurssit/:nimi.html');
    }
    
    public static function uusi() {
        View::make('/kurssit/new.html');
    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

