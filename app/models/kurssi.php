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
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

