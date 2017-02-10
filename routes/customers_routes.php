<?php

$app->get("/customers/", "CustomerController@getAll");
$app->get("/customers/{id}", "CustomerController@get");
$app->post("/customers/", "CustomerController@create");