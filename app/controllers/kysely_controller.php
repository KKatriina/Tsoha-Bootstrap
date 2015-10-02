<?php

class KyselyController extends BaseController{
    public static function index() {
        $kyselyt = Kysely::keraa_tiedot();
        View::make('kyselyt/index.html', array('kyselyt' => $kyselyt));
//        View::make('/kyselyt/index.html');
    }
    
    public static function uusi() {
        self::check_logged_in();
        View::make('/kyselyt/new.html');
    }
    
    public static function show($tunniste) {
        $kysely = Kysely::find($tunniste);
        $kysymykset = Kysely::questions($kysely);
        View::make('kyselyt/show.html', array('kysely' => $kysely, 'kysymykset' => $kysymykset));
    }
    
    public static function lisaysvaihtoehdot() {
        self::check_logged_in();
        $kyselyt = Kysely::keraa_tiedot_lisayslomakkeeseen();
        View::make('kyselyt/lisaysvaihtoehdot.html', array('kyselyt' => $kyselyt));
    }
    
    public static function lisaa_kysymys($tunniste) {
        self::check_logged_in();
        $kysely = Kysely::find($tunniste);
        View::make('kyselyt/lisaa_kysymys.html', array('kysely' => $kysely));
    }
    
    public static function new_kysymys($tunniste) {
        self::check_logged_in();
        $params = $_POST;
        $itse_kysymys = $params['kysymys'];
        $kysely = Kysely::find($tunniste);
        $kysely->add_question($itse_kysymys, $kysely);
        
        Redirect::to('/kyselyt/' . $kysely->tunniste . '/lisaa_kysymys');
        
    }


    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        $kysely = new Kysely(array(
            'kurssi' => $params['kurssi'],
            'aika' => $params['aika'],
            'kyselyn_nimi' => $params['kyselyn_nimi'],
            'paattyminen' => $params['paattyminen'],
            'tarkoitus' => $params['tarkoitus']
        ));
        
        $errors = $kysely->errors();
        
        if(count($errors) == 0) {
            $kysely->save();
            Redirect::to('/kyselyt', array('message' => 'Kysely lisätty onnistuneesti!'));
        } else {
            View::make('kyselyt/new.html', array('errors' => $errors, 'kysely' => $kysely));
        }
           
    }
    
    public static function kurssin_kyselyt($tunniste) {
        self::check_logged_in();
        $kurssi = Kurssi::find($tunniste);
        $kyselyt = Kysely::kurssin_kyselyt($tunniste);
        if(count($kyselyt) == 0) {
            View::make('/user/tervetuloa.html');
        }
        View::make('/kurssit/kurssin_kyselyt.html', array('kyselyt' => $kyselyt, 'kurssi' => $kurssi));
    }
    
    public static function edit($tunniste){
        self::check_logged_in();
        $kysely = Kysely::find($tunniste);
        View::make('kyselyt/edit.html', array('kysely' => $kysely));
    }

    
    public static function update($tunniste) {
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'tunniste' => $tunniste,
            'paattyminen' => $params['paattyminen'],
            'tarkoitus' => $params['tarkoitus']
        );
        
        $kysely = new Kysely($attributes);
        
        $errors = $kysely->validate_paattyminen();
        
        if(count($errors) == 0) {
            $kysely->update($tunniste);     
            Redirect::to('/kyselyt', array('message' => 'Kyselyä on muokattu onnistuneesti!'));
        } else {
            View::make('kyselyt/edit.html', array('errors' => $errors, 'kysely' => $kysely));
        }
    }
    
    public static function destroy($tunniste) {
        self::check_logged_in();
        $kysely = new Kysely(array('tunniste' => $tunniste));
        
        $kysely->destroy();
        
        Redirect::to('/kyselyt', array('message' => 'Kysely on poistettu onnistuneesti!'));
    }
    
    public static function taydenna() {
        self::check_logged_in();
        $params = $_POST;
        $attributes = array(
            'kyselyn_nimi' => $params['kyselyn_nimi'],
            'tarkoitus' => $params['tarkoitus']
        );
        
        $kysely = new Kysely($attributes);
        Redirect::to('/kyselyt/taydenna', array('kysely' => $kysely));
    }
    
    public static function nayta_taydennyslomake($nimi) {
        self::check_logged_in();
        
        $kysely = Kysely::hae_nimella($nimi);
        
        View::make('kyselyt/taydenna.html', array('kysely' => $kysely));
    }
    
    public static function liita_kysely_kurssiin($nimi) {
        self::check_logged_in();
        $params = $_POST;
        
        $kysely1 = Kysely::hae_nimella($nimi);
        
        $kysely = new Kysely(array(
            'kurssi' => $params['kurssi'],
            'aika' => $params['aika'],
            'kyselyn_nimi' => $kysely1->kyselyn_nimi,
            'paattyminen' => $params['paattyminen'],
            'tarkoitus' => $kysely1->tarkoitus
        ));
        
        $errors1 = $kysely->validate_kurssi_ja_aika();
        $errors2 = $kysely->validate_paattyminen();
        $errors = array_merge($errors1, $errors2);
        
        if(count($errors) == 0) {
            $kysely->liita_kurssiin();
            Redirect::to('/kurssit', array('message' => 'Kysely lisätty onnistuneesti!'));
        } else {
            View::make('kyselyt/taydenna.html', array('errors' => $errors, 'kysely' => $kysely));
        }
    }
}