<?php
require_once("managers/HistoireManager.php");
require_once("managers/PersonnageManager.php");
require_once("managers/ObjetManager.php");
require_once("managers/LieuManager.php");
require_once("managers/AvatarManager.php");
require_once("models/TimesModels.php");

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
        $pm = new PersonnageManager();
        $lm = new LieuManager();
        $om = new ObjetManager();
        $am = new AvatarManager();
        $avatar = $am->getById($_SESSION['user']['avatar']);
        $timesModels = new TimesModels();
        $elapsedTime = $timesModels->getElapsedTime();
        
        
        $scripts = $this->addScripts(['assets/js/ajaxStorie.js']);

        $personnages = $pm->getAllPersonnages();
        $lieux = $lm->getAllLieux();
        $objets = $om->getAllObjets();

        return $this->render('histoire.html.twig', [
            
            'elapsed_time' => $elapsedTime,
            'personnages' => $personnages,
            'lieux' => $lieux,
            'objets' => $objets,
            'avatar' => $avatar,
        ], $scripts);
    }

    
    
    public function getImage() {
        $entity = $_GET['entity'];
        $id = $_GET['id'];
        //var_dump($_GET);
        //die;
        
        $manager = null;
        
        switch($entity) {
            case 'personnage':
                $manager = new PersonnageManager();
                break;
            case 'objet':
                $manager = new ObjetManager();
                break;
            case 'lieu':
                $manager = new LieuManager();
                break;
            default:
                http_response_code(400);
                echo json_encode(['error' => 'Invalid entity']);
                exit;
                break;
        }

        $data = $manager->getById($id);
        //file_put_contents('text1.txt', $data['url']);
        //file_put_contents('text2.txt', $data['alt']);
        header('Content-Type: application/json');
        echo json_encode($data['url']);
        //echo json_encode($data['alt']);
        exit;
        
    }
    
    public function getHistoire() {
    $data = json_decode(file_get_contents('php://input'), true);
    $histoireManager = new HistoireManager();
    $histoire = $histoireManager->getHistoiresByCriteria($data['personnage_id'], $data['objet_id'], $data['lieu_id']);
    file_put_contents('text.txt', $histoire);
    header('Content-Type: application/json');
    echo json_encode($histoire);
    exit;
}
}
