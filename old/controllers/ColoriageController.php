<?php

require_once('managers/ColoriageManager.php');
require_once('managers/ColoriageCategoriesManager.php');


class ColoriageController extends AbstractController
{
    public function displayDraw()
    {
        $avatarManager = new AvatarManager();
        $timesModels = new TimesModels();
        $cm = new ColoriageCategoriesManager();
        $categories= $cm->getAllCategoriesColoriages();
        //var_dump($categories);
        $scripts = $this->addScripts(['assets/js/ajaxColoriage.js']);
        
        //var_dump($categories);
        //var_dump($_SESSION);

        $avatar = $avatarManager->getById($_SESSION['user']['avatar']);
        $errorMessage = $_SESSION['error_message'];
        $elapsedTime = $timesModels->getElapsedTime();
        
        //var_dump($categories, $avatar);
        
        $coloriages = [];
    if (isset($_GET['categorie_id'])) {
        $cm = new ColoriageManager();
        $coloriages = $cm->getAllColoriagesByCategorie((int)$_GET['categorie_id']);
        
        
        /*foreach ($coloriages as &$coloriage) {
            $thumbnailPath = 'assets/img/coloriages/' . $coloriage['id'] . '.jpg';
            if (!file_exists($thumbnailPath)) {
                createThumbnailFromPDF($coloriage['url'], $thumbnailPath);
            }
            $coloriage['thumbnail_url'] = $thumbnailPath;
        }*/
    }

    return $this->render('coloriage.html.twig', [
        'avatar' => $avatar,
        'categories' => $categories,
        'error_message' => $errorMessage,
        'elapsed_time' => $elapsedTime,
        'coloriages' => $coloriages,
    ], $scripts);
        
        
    }
    
    public function getColoriagesByCategorieJson(){
        
        ob_clean(); // Clean the output buffer

        $content = file_get_contents("php://input");
        $data = json_decode($content, true);
        
        $coloriageManager = new ColoriageManager();
        $coloriages = $coloriageManager->getAllColoriagesByCategorie($data['id']);        
    
        header('Content-Type: application/json');
        echo json_encode($coloriages);
        
        exit;
    }
   
    
    function createThumbnailFromPDF($pdfFilePath, $thumbnailPath) {
        
        $pdfFilePath = "assets/img/coloriages/";
        $thumbnailPath = "assets/img/coloriages/thumbnails/";
    $imagick = new \Imagick();
    $imagick->setResolution(150, 150);
    $imagick->readImage($pdfFilePath . '[0]');
    $imagick->setImageFormat('jpg');
    $imagick->writeImage($thumbnailPath);
    $imagick->clear();
    $imagick->destroy();
    }
    
    /*public function downloadFile(Request $request): Response
    {
        $fileId = $cm->getId($id);
        // Logique pour récupérer le chemin du fichier basé sur l'ID
        $filePath = '/path/to/files/' . $fileId . '.pdf';

        $response = new BinaryFileResponse($filePath);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            basename($filePath)
        );

        return $response;
    }*/
}