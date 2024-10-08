<?php

require('Router.php');



// "local" :    Local working environment
// "network" :  Network working environment
    
// Create an instance of the Router class
$router = new Router();

// Call the handleRoute method to handle the routing logic
$router->handleRoute();