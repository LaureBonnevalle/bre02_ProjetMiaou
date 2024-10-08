<?php
require_once("models/TimesModels.php");


abstract class AbstractController
{
    private \Twig\Environment $twig;
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader,[
            'debug' => true,
        ]);

        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $this->twig = $twig;
    }

    protected function render(string $template, array $data =[], array $scripts =[]) : void
    {
        $data['scripts'] = $scripts;
        
        //$infoNav = $this->infosNav();
        
        echo $this->twig->render($template, $data, ['elapsed_time' => (new TimesModels())->getElapsedTime()],[$this->getDefaultScripts()]);
        exit();
    }
    
    protected function redirect (string $route) : void {
        unset($_SESSION["error-message"]);
        unset($_SESSION["success-message"]);
        unset($_SESSION["csrf_token"]);
        header("location: $route");
        
    }
    
    /**
     * Redirect to a specified route.
     *
     * - Uses the PHP header function to send a raw HTTP header to the browser.
     * - Redirects the browser to the specified route in the 'index.php' file.
     * - Terminates script execution using 'exit' to ensure no further code is executed after the redirection.
     *
     * @param string $redirect - The route to which the user should be redirected.
    */
    public function redirectTo($redirect) {
        // Use the PHP header function to send a raw HTTP header to the browser
        // Terminate script execution to ensure no further code is executed after the redirection
        header("Location: index.php?route=$redirect");
        exit;
    }
    
    protected function addScripts(array $scripts) : array {
     
        return array_merge ($this->getDefaultScripts(), $scripts);   
        
    }
    
    protected function getDefaultScripts(): array {
        
        return $data =  [
                            'assets/js/common.js',
                            'assets/js/home;js',
                            'assets/js/global.js',
                        ];
        
    }
    
    /**
     * Checks if the user is authenticated.
     *
     * @param  void
     * @return bool - Returns true if the user is authenticated, else False.
     */
    
    

    /**
     * Public method to create sessions after successful login.
     *
     * @param   array - $data The user data array containing session information.
     * @return  void
     */
    public function createSessions($data) {

        $session = ['sessionName'];
        $defaultRoute = ['routes']['default'];

        // Set the 'connected' session flag to true to indicate successful login.
        $_SESSION['connected'] = true;

        // Set the 'user' session data to the provided user data.
        $_SESSION[$session] = $data;

        // Remove the 'password' key from the 'user' session data for security reasons.
        unset($_SESSION[$session]['password']);

        if ($_SESSION['user']['statut'] === 0){
            $_SESSION['alert'] = "Vous devez modifier votre mot de passe.";
        } else {
            $_SESSION['message'] = "Vous êtes connecté !"; 
        }        

        // Redirect to the default 'home' route if the 'route' parameter is not set
        $this->redirectTo($defaultRoute);
    }


    /**
     * Public method to perform disconnection tasks.
     *
     * @param  void
     * @return void
     */
    public function disconnected() {

        $session = INTEGRAL_CONFIG['sessionName'];

        // Set the 'connected' session variable to false
        $_SESSION['connected'] = false;

        // Clear the 'user' session variable
        $_SESSION[$session] = [];

        // Destroy the entire session, including all session data
        session_destroy();
        
        //echo "<script>localStorage.removeItem('startTime');</script>";
        
        session_start();
        
        $_SESSION['error_message'] = "Déconnexion effectuée !";

        // Redirect to the default 'home' route if the 'route' parameter is not set
        $this->redirectTo('homepage');
    }


    /**
     * Render function to display a view within a layout.
     *
     * @param string $viewName   - The name of the view file (without extension) to render.
     * @param string $layoutName - The name of the layout file (without extension) to use.
     * @param array  $data       - An associative array containing data to pass to the view.
     */
    function getElapsedTime() {
    if (isset($_SESSION['start_time'])) {
        $elapsed = time() - $_SESSION['start_time'];
        return $elapsed;
    }
    return 0;
    }
    
    
}
