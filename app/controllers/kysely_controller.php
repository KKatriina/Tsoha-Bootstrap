<?php

class KyselyController extends BaseController{
    public static function index() {
        $kyselyt = Kysely::keraa_tiedot();
        View::make('kyselyt/index.html', array('kyselyt' => $kyselyt));
//        View::make('/kyselyt/index.html');
    }
    
    public static function uusi() {
        View::make('/kyselyt/new.html');
    }
    
    public static function show($tunniste) {
        $kysely = Kysely::find($tunniste);
        View::make('kyselyt/tunniste.html', array('kysely' => $kysely));
    }
    
    public static function add_question($tunniste) {
        $kysely = Kysely::find($tunniste);
        View::make('kyselyt/add_question.html', array('kysely' => $kysely));
    }


    public static function save() {
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
        $kurssi = Kurssi::find($tunniste);
        $kyselyt = Kysely::kurssin_kyselyt($tunniste);
        if(count($kyselyt) == 0) {
            View::make('/user/tervetuloa.html');
        }
        View::make('/kurssit/kurssin_kyselyt.html', array('kyselyt' => $kyselyt, 'kurssi' => $kurssi));
    }
}