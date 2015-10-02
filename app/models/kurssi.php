<?php

class Kurssi extends BaseModel{
    public $tunniste, $nimi, $aika, $tyyppi, $kuvaus, $opettaja, $laitos;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_aika', 'validate_tyyppi', 'validate_opettaja');
        
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT tunniste, kurssi.nimi, aika, tyyppi, kuvaus, opettaja, laitos FROM kurssi, opettaja where kurssi.opettaja = opettaja.nimi');
        $query->execute();
        $rows = $query->fetchAll();
        $kurssit = array();
        
        foreach($rows as $row){
            $kurssit[] = new Kurssi(array(
               'tunniste' => $row['tunniste'],
               'nimi' => $row['nimi'],
               'aika' => $row['aika'],
               'tyyppi' => $row['tyyppi'],
               'kuvaus' => $row['kuvaus'],
               'opettaja' => $row['opettaja'],
               'laitos' => $row['laitos']
            ));
        }
        
        return $kurssit;
    }
    
    public static function omat_kurssit($nimi){
        $query = DB::connection()->prepare('SELECT tunniste, kurssi.nimi, aika, tyyppi, kuvaus, opettaja, laitos
                FROM kurssi, opettaja where kurssi.opettaja = opettaja.nimi
                AND opettaja = :opettaja');
        $query->execute(array('opettaja' => $nimi));
        $rows = $query->fetchAll();
        $kurssit = array();
        
        foreach($rows as $row){
            $kurssit[] = new Kurssi(array(
               'tunniste' => $row['tunniste'],
               'nimi' => $row['nimi'],
               'aika' => $row['aika'],
               'tyyppi' => $row['tyyppi'],
               'kuvaus' => $row['kuvaus'],
               'opettaja' => $row['opettaja'],
               'laitos' => $row['laitos']
            ));
        }
        
        return $kurssit;
    }
    
    public static function find($tunniste){
        $query = DB::connection()->prepare('SELECT tunniste, kurssi.nimi, aika, tyyppi, kuvaus, opettaja, laitos FROM kurssi, opettaja
                where kurssi.opettaja = opettaja.nimi and tunniste = :tunniste LIMIT 1');
        $query->execute(array('tunniste' => $tunniste));
        $row = $query->fetch();
        
        if ($row){
            $kurssi = new Kurssi(array(
                'tunniste' => $row['tunniste'],
                'nimi' => $row['nimi'],
                'aika' => $row['aika'],
                'tyyppi' => $row['tyyppi'],
                'kuvaus' => $row['kuvaus'],
                'opettaja' => $row['opettaja'],
                'laitos' => $row['laitos']
            ));
            
            return $kurssi;
        }
    }
    
    public function save(){
        $tyyppiLukuna = 4;
        if ($this->tyyppi == 'Perusopinnot') {
            $tyyppiLukuna = 1;
        }
        if ($this->tyyppi == 'Aineopinnot') {
            $tyyppiLukuna = 2;
        }
        if ($this->tyyppi == 'Syventävät opinnot') {
            $tyyppiLukuna = 3;
        }
        $query = DB::connection()->prepare('INSERT INTO KURSSI (nimi, aika, tyyppi, kuvaus, opettaja)
                 VALUES (:nimi, :aika, :tyyppi, :kuvaus, :opettaja) RETURNING tunniste');
        
        $query->execute(array('nimi' => $this->nimi, 'aika' => $this->aika,
                'tyyppi' => $tyyppiLukuna, 'kuvaus' => $this->kuvaus, 'opettaja' => $this->opettaja));
                
        $row = $query->fetch();
        $this->tunniste = $row['tunniste'];
    }
    
    public function validate_nimi() {
        $errors = array();
        if ($this->nimi == '' || $this->nimi == null) {
            $errors[] = 'Syötä nimi-kenttään nimi';
            
        }
        if (strlen($this->nimi) < 3) {
            $errors[] = 'Nimen täytyy olla vähintään kolme merkkiä pitkä';
        }
        
        return $errors;
    }
    
    public function validate_aika() {
        $errors = array();
        if ($this->aika == '' || $this->aika == null) {
            $errors[] = 'Syötä aika-kenttään ajankohta, jolloin kurssi pidetään';
            
        }
        
        return $errors;
    }
    
    public function validate_opettaja() {
        $errors = array();
        if ($this->opettaja != 'Setämies' && $this->opettaja != 'Minä'
                && $this->opettaja != 'Assari') {
            $errors[] = 'Kurssin opettajan täytyy olla jokin järjestelmän käyttäjistä. Käyttäjiä tällä hetkellä: Setämies, Minä, Assari';
        }
        
        
        return $errors;
    }
    
    public function validate_tyyppi() {
        $errors = array();
        if ($this->tyyppi != 'Perusopinnot' && $this->tyyppi != 'Aineopinnot'
                && $this->tyyppi != 'Syventävät opinnot' && $this->tyyppi != 'Muut opinnot') {
            $errors[] = 'Kurssin tyypin täytyy olla jokin seuraavista: Perusopinnot, Aineopinnot, Syventävät opinnot tai Muut opinnot';
        }
        return $errors;
    }
    
    public function update($tunniste){       
        $tyyppiLukuna = 4;
        if ($this->tyyppi == 'Perusopinnot') {
            $tyyppiLukuna = 1;
        }
        if ($this->tyyppi == 'Aineopinnot') {
            $tyyppiLukuna = 2;
        }
        if ($this->tyyppi == 'Syventävät opinnot') {
            $tyyppiLukuna = 3;
        }
        $query = DB::connection()->prepare('UPDATE KURSSI SET nimi = :nimi, aika = :aika,
                 tyyppi = :tyyppi, kuvaus = :kuvaus, opettaja = :opettaja
                 WHERE tunniste = :tunniste
                 RETURNING tunniste');
        
        $query->execute(array('nimi' => $this->nimi, 'aika' => $this->aika,
                'tyyppi' => $tyyppiLukuna, 'kuvaus' => $this->kuvaus, 'opettaja' => $this->opettaja, 'tunniste' => $tunniste));
                
        $row = $query->fetch();
        $this->tunniste = $row['tunniste'];
    }
    
    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM KURSSI WHERE tunniste = :tunniste');
        $query->execute(array('tunniste' => $this->tunniste));
        $row = $query->fetch();
    }
    
    
    
    

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

