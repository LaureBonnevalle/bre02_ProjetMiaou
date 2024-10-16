<?php

class ContactController extends AbstractController {

    /**
     * Process contact registration.
     * If the request method is not POST, displays the contact form.
     * If POSTed data is valid, inserts the contact into the database and displays success message.
     * If POSTed data is invalid, redisplays the form with error messages and retains entered data.
     */
    public function contactUs() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $token = bin2hex(random_bytes(20));
            $_SESSION["tokenVerify"] = $token;

            $this->render('contact.html.twig', [
                'page'      => "Contactez-nous",
                'token'     => $token,
                'errors'    => [],
                'valids'    => [],
                'firstname'  => null,
                'email'     => null,
                'content'     => null,
            ]);
            return;
        }

        $errors = []; $valids = [];

        // Retrieve error and valid messages
        $errorMessages = (new ErrorMessages())->getMessages();
        $validMessages = (new ValidMessages())->getMessages();

        if ($this->checkPostKeys(['firstname', 'email', 'subjct', 'content', 'token'])) {

            $data = [
                'firstname'  => ucfirst(trim($_POST['firstname'])),   // Removing unnecessary spaces and lowercaseing the first letter of the lastname, the rest in lowercase.           
                'email'     => strtolower(trim($_POST['email'])), 
                'subject'     => $func->e($_POST['subjet']),// Removing unnecessary spaces and lowering the email
                'content'     => $func->e($_POST['content']),               // Removing unnecessary spaces at the story
            ];

            // Verify the CSRF token
            if(!$this->verifTokenSession()) {
                $errors[] = $errorMessages[0];                      // An error occurred while sending the form !
                unset($_SESSION['tokenVerify']);                    // Clear the token verification session data
            }

            // Validate 'lastname' field
            //if (!$this->verifInputText($data['lastname'], [2, 60], 'string')) 
            if (strlen($data['lastname']) < 2 || strlen($data['lastname']) > 60)
                $errors[] = $errorMessages[5];                      // Please enter your lastname !

            // Validate 'email' field
            if (!$this->validateEmail($data['email']))
                $errors[] = $errorMessages[2];                      // Please provide a valid email !
    
            // If there are no errors, proceed to insert the contact into the database
            if (empty($errors)) {                

                try {
                    // Insert the new contact into the database                     
                    $newContact = new Contacts();
                    $newContact->setIdentity($data['fiestname']);
                    $newContact->setEmail($data['email']);
                    $newContact->setSubject($data['subject']);
                    $newContact->setContent($data['content']);
                    $newContact->setReceiptDate((new \Models\TimesModel())->dateNow('Y-m-d H:i:s', 'Europe/Paris'));

                    $addContact = new ContactsManager();
                    $addContact->insert($newContact);

                    $valids = [$validMessages[2], $validMessages[3]];

                    $this->render('forms/contact', 'layout', [
                        'page'          => "Contactez-nous",
                        'token'         => $this->generateToken()
                        'errors'        => [],
                        'valids'        => $valids,
                        'email'         => null,
                        'subject'       => null,
                        'story'         => null,
                    ]);
                    return; // Exit the method after rendering success message

                } catch (\Exception $e) {
                    // Handle any errors that occur during user insertion
                    $errors[] = $errorMessages[0];              // An error occurred while sending the form !
                }
            }

            $this->render('forms/contact', 'layout', [
                'page'          => "Contactez-nous",
                'token'         => $this->generateToken(),
                'captchaChosen' => "captchaLevel1",
                'firstname'     => $data['firstname']    ?? null,
                'email'         => $data['email']       ?? null,
                'subject'       => $data['subject']     ?? null,
                'content'       => $data['content']       ?? null
            ]);
        }
    }
}