<?php

class KurssiController extends BaseController{
    
    public static function index(){
        $kurssit = Kurssi::all();
        View::make('kurssit/index.html', array('kurssit' => $kurssit));
    }
    
    public static function show($tunniste) {
        $kurssi = Kurssi::find($tunniste);
        View::make('kurssit/tunniste.html', array('kurssi' => $kurssi));
    }
    
    public static function uusi() {
        View::make('/kurssit/new.html');
    }
    
    //tää ei toimi. en tiä mikä on
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
        
        Redirect::to('/kurssit');
    }
    
    public static function edit($tunniste) {
        $kurssi = Kurssi::find($tunniste);
        View::make('kurssi/edit.html', array('attributes' => $kurssi));
    }
    
    public static function destroy($tunniste) {
        $kurssi = Kurssi::find($tunniste);
        View::make('kurssi/destroy.html', array('attributes' => $kurssi));
    }
    
//    public static function update($tunniste) {
//        $params = $_POST;
//        
//        $attributes = array(            
//            'nimi' => $params['nimi'],
//            'opettaja' => $params['opettaja'],
//            'tyyppi' => $params['tyyppi'],
//            'aika' => $params['aika'],
//            'kuvaus' => $params['kuvaus']        
//        );
//        
//        $kurssi = new Kurssi($attributes);
//        $errors = $kurssi->errors();
//        
//        if(count($errors) > 0) {
//            View::make('kurssit/edit.html', array('errors' => $errors, 'attributes' => $attributes));
//        } else {
//            $kurssi->update();
//            
//            
//            //mitä tän pitäis olla?????
//            Redirect::to('/kurssi/');
//        }
//    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

