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
    
    public static function find($nimi){
        $query = DB::connection()->prepare('SELECT * FROM Kurssi WHERE nimi = :nimi LIMIT 1');
        $query->execute(array('nimi' => $nimi));
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
//        $tyyppiLukuna = 4;
//        if ($this->tyyppi = 'Perusopinnot') {
//            $tyyppiLukuna = 1;
//        }
//        if ($this->tyyppi = 'Aineopinnot') {
//            $tyyppiLukuna = 2;
//        }
//        if ($this->tyyppi = 'Syventävät opinnot') {
//            $tyyppiLukuna = 3;
//        }
        $query = DB::connection()->prepare('INSERT INTO KURSSI (nimi, aika, tyyppi, kuvaus, opettaja)
                 VALUES (:nimi, :aika, :tyyppi, :kuvaus, :opettaja) RETURNING id');
        
        $query->execute(array('nimi' => $this->nimi, 'aika' => $this->aika,
                'tyyppi' => 3, 'kuvaus' => $this->kuvaus, 'opettaja' => $this.opettaja));
                
        $row = $query->fetch();
        $this->nimi = $row['nimi'];
    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

