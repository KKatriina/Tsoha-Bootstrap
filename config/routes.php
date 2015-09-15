<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });
  
  $routes->get('/etusivu', function() {
  HelloWorldController::etusivu();
  });
  
  $routes->get('/kurssit', function() {
  KurssiController::index();
  });
  
  $routes->get('/kyselyt', function() {
  HelloWorldController::kyselyt();
  });
  
  $routes->get('/muokkaa_kurssia', function() {
  HelloWorldController::muokkaa_kurssia();
  });
  
  $routes->get('/kurssin_esittelysivu', function() {
  HelloWorldController::kurssin_esittelysivu();
  });
  
  $routes->get('/tervetuloa', function() {
  HelloWorldController::tervetuloa();
  });
  
  $routes->get('/kurssit/:nimi', function($nimi){
      KurssiController::show($nimi); 
  });
  
  $routes->get('/kurssit/new', function() {
        KurssiController::uusi();
    });
