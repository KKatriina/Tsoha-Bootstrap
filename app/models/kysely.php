<?php

class Kysely extends BaseModel{
    public $tunniste, $kurssi, $aika, $kyselyn_nimi, $paattyminen, $tarkoitus;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        
    }
    
    public function keraa_tiedot() {
        $query = DB::connection()->prepare('SELECT kurssin_kysely.tunniste, kurssi.nimi, kurssi.aika, kurssin_kysely.kysely, paattyminen, tarkoitus
                 FROM kurssi, kurssin_kysely, kysely
                 WHERE kurssi.tunniste=kurssin_kysely.kurssi
                    and kurssin_kysely.kysely = kysely.nimi');
        $query->execute();
        $rows = $query->fetchAll();
        $kyselyt = array();
        
        if (count($rows) == 0) {
            return $kyselyt;
        }
        
        foreach($rows as $row){
            $kyselyt[] = new Kysely(array(
               'tunniste' => $row['tunniste'],
               'kurssi' => $row['nimi'],
               'aika' => $row['aika'],
               'kyselyn_nimi' => $row['kysely'],
               'paattyminen' => $row['paattyminen'],
               'tarkoitus' => $row['tarkoitus']
            ));
        }
        
        return $kyselyt;
    }
    
     public function kurssin_kyselyt($kurssitunniste) {
        $query = DB::connection()->prepare('SELECT kurssin_kysely.tunniste, kurssi.nimi, kurssi.aika, kurssin_kysely.kysely, paattyminen, tarkoitus
                 FROM kurssi, kurssin_kysely, kysely
                 WHERE kurssi.tunniste=kurssin_kysely.kurssi
                    and kurssin_kysely.kysely = kysely.nimi
                    and kurssi.tunniste = :kurssitunniste');
        $query->execute(array('kurssitunniste' => $kurssitunniste));
        $rows = $query->fetchAll();
        
                $kyselyt = array();
        
        if (count($rows) == 0) {
            return $kyselyt;
        }
        
        foreach($rows as $row){
            $kyselyt[] = new Kysely(array(
               'tunniste' => $row['tunniste'],
               'kurssi' => $row['nimi'],
               'aika' => $row['aika'],
               'kyselyn_nimi' => $row['kysely'],
               'paattyminen' => $row['paattyminen'],
               'tarkoitus' => $row['tarkoitus']
            ));
        }
        
        return $kyselyt;
    }
    
    public function find($tunniste) {
        
            $query = DB::connection()->prepare('SELECT kurssin_kysely.tunniste, kurssi.nimi, kurssi.aika, kurssin_kysely.kysely, paattyminen, tarkoitus
                 FROM kurssi, kurssin_kysely, kysely
                 WHERE kurssi.tunniste=kurssin_kysely.kurssi
                    and kurssin_kysely.kysely = kysely.nimi
                    and kurssin_kysely.tunniste = :tunniste LIMIT 1');
        $query->execute(array('tunniste' => $tunniste));
        $row = $query->fetch();
 
        
        if($row){
            $kysely = new Kysely(array(
               'tunniste' => $tunniste,
               'kurssi' => $row['nimi'],
               'aika' => $row['aika'],
               'kyselyn_nimi' => $row['kysely'],
               'paattyminen' => $row['paattyminen'],
               'tarkoitus' => $row['tarkoitus']
            ));
        }
        
        return $kysely;
    }
    
    public function save($kurssin_tunniste) {
        
        //tehdään lisäys taulukkoon kysely
        $query = DB::connection()->prepare('INSERT INTO KYSELY (nimi, tarkoitus) VALUES (:nimi, :tarkoitus)');
        $query->execute(array('nimi' => $this->kyselyn_nimi, 'tarkoitus' => 'testi'));
        
        
        //tehdään lisäys liitostauluun
        $query = DB::connection()->prepare('INSERT INTO KURSSIN_KYSELY (kurssi, kysely, paattyminen)
                 VALUES (:kurssi, :kysely, :paattyminen)');
        $query->execute(array('kurssi' => $kurssin_tunniste, 'kysely' => $this->kyselyn_nimi, 'paattyminen' => $this->paattyminen));
              

    }
    
    public function add_question($kysymys, $kysely) {

        $query = DB::connection()->prepare('INSERT INTO KYSYMYS (kysely, kysymys) values (:kysely, :kysymys)');
        $query->execute(array('kysely' => $kysely->kyselyn_nimi, 'kysymys' => $kysymys));
    }
    
    public function questions($kysely) {
        $query = DB::connection()->prepare('SELECT KYSYMYS FROM KYSYMYS WHERE kysely = :kyselyn_nimi');
        $query->execute(array('kyselyn_nimi' => $kysely->kyselyn_nimi));
        $rows = $query->fetchAll();
        
        $kysymykset = array();
        
        if (count($rows) == 0) {
            return $kysymykset;
        }
        
        foreach($rows as $row){
            $kysymykset[] = $row['kysymys'];
        }
        
        return $kysymykset;
    }
    
    public static function update($tunniste) {
        
    }
    
    public static function destroy($tunniste) {               
        $query = DB::connection()->prepare('DELETE FROM Kurssin_kysely WHERE tunniste = :tunniste');
        $query->execute(array('tunniste' => $this->tunniste));
        $row = $query->fetch();
        
    }
}
