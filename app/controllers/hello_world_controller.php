<?php


  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
      View::make('suunnitelmat/etusivu.html');
    }

    public static function sandbox(){
      // Testaa koodiasi täällä
      //View::make('helloworld.html');
      $uusiKurssi = new Kurssi(array(
          'nimi' => '1',
          'aika' => 'III periodi',
          'tyyppi' => 'agf',
          'kuvaus' => 'Metriikkaa',
          'opettaja' => ''
      ));
      $errors = $uusiKurssi->errors();
      
      Kint::dump($errors);
    }
    
    public static function etusivu() {
        View::make('suunnitelmat/etusivu.html');
    }
    
    public static function kurssit() {
        View::make('suunnitelmat/kurssit.html');
    }
    
    public static function kyselyt() {
        View::make('suunnitelmat/kyselyt.html');
    }
    
    public static function muokkaa_kurssia() {
        View::make('suunnitelmat/muokkaa_kurssia.html');
    }
    
    public static function kurssin_esittelysivu() {
        View::make('suunnitelmat/kurssin_esittelysivu.html');
    }
    
    public static function tervetuloa() {
        View::make('suunnitelmat/tervetuloa.html');
    }
  }
