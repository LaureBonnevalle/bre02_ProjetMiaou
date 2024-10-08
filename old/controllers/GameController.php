<?php

class GameController extends AbstractController {
    
     public function __construct()
    {
        parent::__construct();
    } 
    
    public function displatGames() {
       
       $this->render("games.html.twig", [],[]); 
    }
    
    public function displayPixelArt() {
    
        $this->render("pixelArt.html.twig", [],["pixelArt.js"]);  
        
    }
    
    
    
    
    
}