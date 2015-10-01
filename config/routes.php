<?php

  //yleisiä reittejä

//  $routes->get('/muokkaa_kurssia', function() {
//  HelloWorldController::muokkaa_kurssia();
//  });
//  
//  
//  $routes->get('/kurssin_esittelysivu', function() {
//  HelloWorldController::kurssin_esittelysivu();
//  });

  $routes->get('/', function() {
  UserController::login();
  });
  
  $routes->get('/hiekkalaatikko', function() {
  HelloWorldController::sandbox();
  });
  
  $routes->get('/etusivu', function() {
  UserController::login();
  });
  
  $routes->get('/tervetuloa', function() {
  UserController::tervetulosivu();
  });
  
  
  //kyselyihin liittyviä reittejä
  
  $routes->get('/kyselyt', function() {
  KyselyController::index();
  });
  
  $routes->get('/kyselyt/new', function() {
  KyselyController::uusi();
  });
  
  $routes->get('/kyselyt/lisaysvaihtoehdot', function() {
  KyselyController::lisaysvaihtoehdot();
  });
  
  $routes->post('/kyselyt/uusi', function() {
  KyselyController::store();
  });
  
  $routes->post('/kyselyt/taydenna', function() {
  KyselyController::taydenna();
  });
  
  $routes->get('/kyselyt/taydenna', function() {
  KyselyController::nayta_taydennyslomake();
  });
  
  $routes->post('/kyselyt/taydennetty', function() {
  KyselyController::liita_kysely_kurssiin();
  });
  
  $routes->get('/kyselyt/:tunniste', function($tunniste) {
  KyselyController::show($tunniste);
  });
  
  $routes->get('/kyselyt/:tunniste/lisaa_kysymys', function($tunniste) {
  KyselyController::lisaa_kysymys($tunniste);
  });
  
  $routes->post('/kyselyt/:tunniste/uusi_kysymys', function ($tunniste) {
  KyselyController::new_kysymys($tunniste);
  }); 
  
  $routes->get('/kyselyt/:tunniste/edit', function($tunniste){
  KyselyController::edit($tunniste);
  });
  
  $routes->post('/kyselyt/:tunniste/edit', function($tunniste){
  KyselyController::update($tunniste);
  });
  
  $routes->post('/kyselyt/:tunniste/destroy', function($tunniste){
  KyselyController::destroy($tunniste);
  });
  
  //kursseihin liittyviä reittejä
  
  $routes->get('/kurssit', function() {
  KurssiController::index();
  });

  $routes->get('/kurssit/new', function(){
     KurssiController::uusi(); 
  });
  
  
  $routes->get('/kurssit/:tunniste', function($tunniste){
      KurssiController::show($tunniste); 
  });  
  
  
  $routes->post('/kurssi', function(){
  KurssiController::store();
  });
  
  $routes->get('/kurssit/:tunniste/edit', function($tunniste){
  KurssiController::edit($tunniste);
  });
  
  $routes->post('/kurssit/:tunniste/edit', function($tunniste){
  KurssiController::update($tunniste);
  });
  
  
  $routes->post('/kurssit/:tunniste/destroy', function($tunniste){
  KurssiController::destroy($tunniste);
  });
  
  $routes->get('/kurssit/:tunniste/kyselyt', function($tunniste) {
  KyselyController::kurssin_kyselyt($tunniste);
  });
  
  //käyttäjään liittyviä reittejä
  
  $routes->get('/login', function() {
  UserController::login();
  });
  
  $routes->post('/login', function() {
  UserController::handle_login();
  });
  
  $routes->post('/logout', function() {
  UserController::logout();
  });
  
  $routes->get('/user/tervetuloa', function() {
  UserController::tervetuloa();
  });
  
  
  $routes->get('/:nimi/omat_kurssit', function($nimi) {
  KurssiController::omat_kurssit($nimi);
  });
  
  
  

  

  


