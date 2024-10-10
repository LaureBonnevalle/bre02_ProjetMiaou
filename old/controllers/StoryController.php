<?php
require_once("managers/HistoireManager.php");
require_once("managers/PersonnageManager.php");
require_once("managers/ObjetManager.php");
require_once("managers/LieuManager.php");
require_once("managers/AvatarManager.php");

class StoryController extends AbstractController {

    public function getImageUrl() {
        $personnageId = $_POST['personnage_id'];
        $lieuId = $_POST['lieu_id'];
        $objetId = $_POST['objet_id'];

        $histoireManager = new HistoireManager();
        $imageUrl = $histoireManager->getImageUrl($personnageId, $lieuId, $objetId);

        header('Content-Type: application/json');
        echo json_encode(['url' => $imageUrl]);
        exit;
    }
    
    public function displayStories() {
        $pm= new PersonnageManager();
        $lm = new LieuManager();
        $om = new ObjetManager();
        $am = new AvatarManager();
        $avatar = $am->getById($_SESSION['user']['avatar']);
        
        
        $scripts = $this->addScripts([]);

        $personnages = $pm->getAllPersonnages();
        $lieux = $lm->getAllLieux();
        $objets = $om->getAllObjets();

        return $this->render('histoire.html.twig', [
            
            'personnages' => $personnages,
            'lieux' => $lieux,
            'objets' => $objets
        ],$scripts);
    }

    public function getHistoire() {
        $histoireManager = new HistoireManager();
        $histoire = $histoireManager->getHistoiresByCriteria($_GET['personnage_id'], $_GET['lieu_id'], $_GET['objet_id']);

        header('Content-Type: application/json');
        echo json_encode($histoire);
        exit;
    }
}