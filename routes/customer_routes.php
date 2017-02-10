<?php

$app->get("/customer/", "CustomerController@getAll");
$app->get("/customer/{id}", "CustomerController@get");
$app->post("/customer/", "CustomerController@create");