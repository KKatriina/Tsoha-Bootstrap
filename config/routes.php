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
  HelloWorldController::kurssit();
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
  
