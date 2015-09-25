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
        View::make('kyselyt/tunniste.html', array('kysely' => $kysely, 'kysymykset' => $kysymykset));
    }
    
    public static function add_question($tunniste) {
        self::check_logged_in();
        $kysely = Kysely::find($tunniste);
        View::make('kyselyt/add_question.html', array('kysely' => $kysely));
    }
    
    public static function new_question($tunniste) {
        $params = $_POST;
        $itse_kysymys = $params['kysymys'];
        $kysely = Kysely::find($tunniste);
        $kysely->add_question($itse_kysymys, $kysely);
        
        Redirect::to('/kyselyt/' . $kysely->tunniste . '/lisaa_kysymys');
        
    }


    public static function save($tunniste) {
        self::check_logged_in();
        $params = $_POST;
        $kysely = new Kysely(array(
            'kurssi' => $params['kurssi'],
            'aika' => $params['aika'],
            'kyselyn_nimi' => $params['kyselyn_nimi'],
            'paattyminen' => $params['paattyminen'],
            'tarkoitus' => $params['tarkoitus']
        ));
        
                
        $kysely->save();
        
        Redirect::to('/kyselyt');
    
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
}