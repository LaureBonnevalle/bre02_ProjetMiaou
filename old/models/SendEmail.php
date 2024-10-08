<?php


class SendEmail {

    public function sendEmailConfirme(string $firstname, string $email, string $passwordView) :void {

        $expeditorEmail = "apprendreavecmiaou@gmail.com";
        $destinataire = $email;

        $header= "MIME-Version: 1.0\r\n";
        $header.= 'From:"ApprendreAvecMiaou"<'.$expeditorEmail.'>'."\n";
        //$header.= "Cc: .......@hotmail.fr\n";
        $header.= "X-Priority: 1\n";
        $header.= 'Content-Type: text/html; charset="uft-8"'."\n";
        $header.= 'Content-Transfer-Encoding: 8bit';

        $message =
'<html>
    <body>
        <div style="font-size: 24px; text-align: center">
            <img src="assets/img/Miaou/chatfiligranne.jpg" alt="logo du site"/>

            <h1>Site de jeux et activités pour enfants</h1>

            <p>Bonjour, <span style="text-transform:uppercase">' . $email . ' responsable de ' . $firstname . '</span>

            <p>Votre demande d\'accès au site a bien été enregistrée.</p>
            <p>Votre mot de passe temporaire est : <strong>' . $passwordView . '</strong></p>
            <p>Email : <strong>' . $email . '</strong></p>
            <p style="color: rgb(255, 0, 0); font-size: 24px;">Nous vous conseillons de le changer rapidement !</p>
    
            <p>Respectez bien les majuscules et les minuscules.<br />
            Votre compte n\'est pas encore activé. Vous devez vous connectez et modifier votre mot de passe.</p>

            <img src="assets/img/Miaou/chatfiligranne.jpg" alt="logo du site"/>
        </div>
    </body>
</html>';

        /*
        $message .= "Content-Disposition: attachment; filename=\"Cars.png\"\n\n";
        $message .= $content_encode . "\n";
        $message .= "\n\n";	*/

        file_put_contents('documents/email1.html', $message);

        //mail($destinataire, "CONFIRMATION DE RECEPTION DE DEMANDE D'INSCRIPTION SUR ApprendreAvecMiaou.", $message, $header);
    }
}

