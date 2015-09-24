<?php

class Kysely extends BaseModel{
    public $tunniste, $kurssi, $aika, $kyselyn_nimi, $paattyminen, $tarkoitus;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        
    }
    
    public function keraa_tiedot() {
        
    }
    
    public function save() {
        //etsitään kurssin nimen ja ajan perusteella oikea kurssi
        $query = DB::connection()->prepare('SELECT * FROM Kurssi WHERE nimi = :nimi and aika = :aika LIMIT 1');
        $query->execute(array('nimi' => $this->kurssi, 'aika' => $this->aika));
        $row = $query->fetch();
        $kurssin_tunniste = $row['tunniste'];
        

        
        
        //tehdään lisäys liitostauluun
        $query = DB::connection()->prepare('INSERT INTO KURSSIN_KYSELY (kurssi, kysely, paattyminen)
                 VALUES (:kurssi, :kysely, :paattyminen)');
        $query->execute(array('kurssi' => $kurssin_tunniste, 'kysely' => $this->kyselyn_nimi, 'paattyminen' => $this->paattyminen));
              
        //tehdään lisäys taulukkoon kysely
        $query = DB::connection()->prepare('INSERT INTO KYSELY (nimi, tarkoitus) VALUES (:nimi, :tarkoitus)');
        $query->execute(array('nimi' => $this->kyselyn_nimi, 'tarkoitus' => $this->tarkoitus));
        
    }
}
