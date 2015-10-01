<?php

class KurssiController extends BaseController{
    
    public static function index(){
        self::check_logged_in();
        $kurssit = Kurssi::all();
        View::make('kurssit/index.html', array('kurssit' => $kurssit));
    }
    
    public static function omat_kurssit($nimi) {
        self::check_logged_in();
        $kurssit = Kurssi::omat_kurssit($nimi);
        View::make('kurssit/index.html', array('kurssit' => $kurssit));
    }
    
    public static function show($tunniste) {
        self::check_logged_in();
        $kurssi = Kurssi::find($tunniste);
        View::make('kurssit/show.html', array('kurssi' => $kurssi));
    }
    
    public static function uusi() {
        self::check_logged_in();
        View::make('/kurssit/new.html');
    }
    
    
    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        $kurssi = new Kurssi(array(
            'nimi' => $params['nimi'],
            'opettaja' => $params['opettaja'],
            'tyyppi' => $params['tyyppi'],
            'aika' => $params['aika'],
            'kuvaus' => $params['kuvaus']
        ));
        
        $errors = $kurssi->errors();
        
        if(count($errors) == 0) {
            $kurssi->save();
            Redirect::to('/kurssit', array('message' => 'Kurssi lisätty onnistuneesti!'));
        } else {
            View::make('kurssit/new.html', array('errors' => $errors, 'kurssi' => $kurssi));
        }
        
                
               
        
    }
    
    public static function edit($tunniste) {
        self::check_logged_in();
        $kurssi = Kurssi::find($tunniste);
        View::make('/kurssit/edit.html', array('kurssi' => $kurssi));
    }
    
    public static function destroy($tunniste) {
        self::check_logged_in();
        $kurssi = new Kurssi(array('tunniste' => $tunniste));
        
        $kurssi->destroy();
        
        Redirect::to('/kurssit', array('message' => 'Kurssi on poistettu onnistuneesti!'));
    }
    
    public static function update($tunniste) {
        self::check_logged_in();
        $params = $_POST;
        
        $attributes = array(
            'tunniste' => $tunniste,
            'nimi' => $params['nimi'],
            'opettaja' => $params['opettaja'],
            'tyyppi' => $params['tyyppi'],
            'aika' => $params['aika'],
            'kuvaus' => $params['kuvaus']        
        );
        
        $kurssi = new Kurssi($attributes);
        $errors = $kurssi->errors();
        
        if(count($errors) > 0) {
            View::make('kurssit/edit.html', array('errors' => $errors, 'kurssi' => $kurssi));
        } else {
            $kurssi->update($tunniste);
            
            
 
            Redirect::to('/kurssit', array('message' => 'Kurssia on muokattu onnistuneesti!'));
        }
    }
    
    
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

