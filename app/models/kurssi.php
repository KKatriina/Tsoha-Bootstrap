<?php

class Kurssi extends BaseModel{
    public $tunniste, $nimi, $aika, $tyyppi, $kuvaus, $opettaja;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        
    }
    
    public static function all(){
        $query = DB::connection()->prepare('SELECT * FROM kurssi');
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
               'opettaja' => $row['opettaja']
            ));
        }
        
        return $kurssit;
    }
    
    public static function find($tunniste){
        $query = DB::connection()->prepare('SELECT * FROM Kurssi WHERE tunniste = :tunniste LIMIT 1');
        $query->execute(array('tunniste' => $tunniste));
        $row = $query->fetch();
        
        if ($row){
            $kurssi = new Kurssi(array(
                'tunniste' => $row['tunniste'],
                'nimi' => $row['nimi'],
                'aika' => $row['aika'],
                'tyyppi' => $row['tyyppi'],
                'kuvaus' => $row['kuvaus'],
                'opettaja' => $row['opettaja']
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
    
    public function update(){
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
        $query = DB::connection()->prepare('UPDATE KURSSI (nimi, aika, tyyppi, kuvaus, opettaja)
                 VALUES (:nimi, :aika, :tyyppi, :kuvaus, :opettaja) RETURNING tunniste');
        
        $query->execute(array('nimi' => $this->nimi, 'aika' => $this->aika,
                'tyyppi' => $tyyppiLukuna, 'kuvaus' => $this->kuvaus, 'opettaja' => $this->opettaja));
                
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

