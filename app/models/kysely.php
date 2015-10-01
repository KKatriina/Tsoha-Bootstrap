<?php

class Kysely extends BaseModel{
    public $tunniste, $kurssi, $aika, $kyselyn_nimi, $paattyminen, $tarkoitus, $kysymykset;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_nimi', 'validate_kurssi_ja_aika', 'validate_paattyminen');
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
    
    public function keraa_tiedot_lisayslomakkeeseen() {
        $query = DB::connection()->prepare('SELECT nimi, tarkoitus
         FROM kysely');
        $query->execute();
        $rows = $query->fetchAll();
        $kyselyt = array();
        
        if (count($rows) == 0) {
            return $kyselyt;
        }
        
        foreach($rows as $row){
            $uusi_kysely = new Kysely(array(
               'kyselyn_nimi' => $row['nimi'],
               'tarkoitus' => $row['tarkoitus']
            ));
            $uusi_kysely->kysymykset = Kysely::questions($uusi_kysely);
            $kyselyt[] = $uusi_kysely;
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
    
    public function save() {
        //haetaan oikea kurssi
        $query = DB::connection()->prepare('SELECT tunniste FROM KURSSI WHERE nimi = :nimi and aika = :aika LIMIT 1');
        $query->execute(array('nimi' => $this->kurssi, 'aika' => $this->aika));
        $params2 = $query->fetch();
        $kurssin_tunniste = $params2['tunniste'];
        
        
        //tehdään lisäys taulukkoon kysely
        $query = DB::connection()->prepare('INSERT INTO KYSELY (nimi, tarkoitus) VALUES (:nimi, :tarkoitus)');
        $query->execute(array('nimi' => $this->kyselyn_nimi, 'tarkoitus' => $this->tarkoitus));
        
        
        //tehdään lisäys liitostauluun
        $query = DB::connection()->prepare('INSERT INTO KURSSIN_KYSELY (kurssi, kysely, paattyminen)
                 VALUES (:kurssi, :kysely, :paattyminen)');
        $query->execute(array('kurssi' => $kurssin_tunniste, 'kysely' => $this->kyselyn_nimi, 'paattyminen' => $this->paattyminen));
              
    }
    
    public function validate_kurssi_ja_aika() {
        $errors = array();
        
        if ($this->kurssi == '' || $this->kurssi == null) {
            $errors[] = 'Syötä kurssin nimi -kenttään jonkin kurssin nimi';         
        }
        
        $query = DB::connection()->prepare('SELECT tunniste FROM Kurssi WHERE nimi = :nimi and aika = :aika');
        $query->execute(array('nimi' => $this->kurssi, 'aika' => $this->aika));
        $rows = $query->fetchAll();
        
        if (count($rows) == 0) {
            $errors[] = 'Syötä kenttiin Kurssin nimi ja Kurssin aika jonkin järjestelmässä jo olevan kurssin vastaavat tiedot';
        }
        
        return $errors;
    
    }
    
    public function validate_paattyminen() {
        $errors = array();
        
        return $errors;
    }
    
    public function validate_nimi() {
        $errors = array();
        
        if ($this->kyselyn_nimi == '' || $this->kyselyn_nimi == null) {
            $errors[] = 'Syötä kyselyn nimi -kenttään jokin nimi';         
        }
        
        $query = DB::connection()->prepare('SELECT nimi from KYSELY');
        $query->execute();
        $rows = $query->fetchAll();
        
        foreach($rows as $row){
            $nimi = $row['nimi'];
            if ($nimi == $this->kyselyn_nimi) {
                $errors[] = 'Järjestelmä sisältää jo tämännimisen kyselyn. Syötä toinen nimi';
            }
        }
        
        return $errors;
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
    
    public function update($tunniste) {
        $query = DB::connection()->prepare('SELECT kysely FROM kurssin_kysely WHERE tunniste = :tunniste');
        $query->execute(array('tunniste' => $tunniste));
        $row = $query->fetch();
        $ap_nimi = $row['kysely'];

        $query = DB::connection()->prepare('UPDATE KYSELY SET tarkoitus = :tarkoitus WHERE nimi = :nimi');       
        $query->execute(array('nimi' => $ap_nimi, 'tarkoitus' => $this->tarkoitus));
        

        $query = DB::connection()->prepare('UPDATE KURSSIN_KYSELY 
                SET paattyminen = :paattyminen 
                WHERE tunniste = :tunniste');
        $query->execute(array('tunniste' => $tunniste, 'paattyminen' => $this->paattyminen));
        
    }
    
    public function destroy() {               
        $query = DB::connection()->prepare('DELETE FROM Kurssin_kysely WHERE tunniste = :tunniste');
        $query->execute(array('tunniste' => $this->tunniste));
        $row = $query->fetch();        
    }
    
    public function liita_kurssiin() {
        //haetaan oikea kurssi
        $query = DB::connection()->prepare('SELECT tunniste FROM KURSSI WHERE nimi = :nimi and aika = :aika LIMIT 1');
        $query->execute(array('nimi' => $this->kurssi, 'aika' => $this->aika));
        $params2 = $query->fetch();
        $kurssin_tunniste = $params2['tunniste'];
        
        //tehdään lisäys liitostauluun
        $query = DB::connection()->prepare('INSERT INTO KURSSIN_KYSELY (kurssi, kysely, paattyminen)
                 VALUES (:kurssi, :kysely, :paattyminen)');
        $query->execute(array('kurssi' => $kurssin_tunniste, 'kysely' => $this->kyselyn_nimi, 'paattyminen' => $this->paattyminen));
        
    }
}
