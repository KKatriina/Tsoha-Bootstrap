<?php

class KurssiController extends BaseController{
    
    public static function index(){
        $kurssit = Kurssi::all();
        View::make('kurssit/index.html', array('kurssit' => $kurssit));
    }
    
    public static function show($nimi) {
        $kurssi = Kurssi::find($nimi);
        View::make('kurssit/:nimi.html', array('kurssi' => $kurssi));
    }
    
    public static function uusi() {
        View::make('/kurssit/new.html');
    }
    
    public static function store() {
        $params = $_POST;
        $kurssi = new Kurssi(array(
            'nimi' => $params['nimi'],
            'opettaja' => $params['opettaja'],
            'tyyppi' => $params['tyyppi'],
            'aika' => $params['aika'],
            'kuvaus' => $params['kuvaus']
        ));
        
                
        $kurssi->save();
        
        Redirect::to('/kurssit/index.html');
    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

