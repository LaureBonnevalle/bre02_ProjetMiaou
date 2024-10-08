<?php

class ColoriageController extends AbstractController
{
    public function displayDraw(): Response
    {
        $avatarManager = new AvatarManager();
        $timesModels = new TimesModels();

        $avatar = $avatarManager->getById($_SESSION['user']['avatar']);
        $errorMessage = $_SESSION['error_message'];
        $elapsedTime = $timesModels->getElapsedTime();
        $defaultScripts = $this->getDefaultScripts();

        return $this->render('coloriage.html.twig', [
            'avatar' => $avatar,
            'error_message' => $errorMessage,
            'elapsed_time' => $elapsedTime,
            'default_scripts' => $defaultScripts,
        ]);
    }
    
    public function downloadFile(Request $request): Response
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
    }
}