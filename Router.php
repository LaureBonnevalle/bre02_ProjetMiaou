<?php

// Check if the session has not already been started
if (session_status() == PHP_SESSION_NONE)
    session_start();
    
//var_dump($_SESSION);

require('config/Config.php');

date_default_timezone_set('Europe/Paris');

Config::registerAutoloader();   // Call the methods to register the autoloader and config constants

define('INTEGRAL_CONFIG',   Config::getConfig());       // Je récupère l'intégralité du tableau de config
define('DB_CONFIG',         Config::getConfig("db"));   // Je ne récupère que les identifiants de connexion

class Router extends Functionality {

    /**
     * Handle the routing logic based on the 'route' parameter in the $_GET array.
     *
     * @param void
     * - Checks if the 'route' parameter is set in the $_GET array.
     * - Switches between different routes and calls corresponding methods on controllers.
     * - If the 'route' parameter is not set, or an unknown route is provided, redirects to the default 'home' route.
    */
    public function handleRoute() {

        $defaultRoute = INTEGRAL_CONFIG['routes']['default'];

        if (array_key_exists('route', $_GET)) {
            $routing = INTEGRAL_CONFIG['routes'][0][$_GET['route']];
            if (isset($routing)){
                $this->callController($routing[0], $routing[1], $routing[2], $routing[3]); // HomeController, display, false, false
            } else {
                $this->redirectTo($defaultRoute);
            }
        } else {
            $this->redirectTo($defaultRoute);
        }
    }


    /**
     * Call a method on a specified controller.
     *
     * - Concatenates the namespace and class name to get the fully qualified class name.
     * - Creates an instance of the specified controller class.
     * - Calls the specified method on the controller instance.
     *
     * @param string $controllerName    - The name of the controller class (without the namespace).
     * @param string $methodName        - The name of the method to be called on the controller.
    */
    private function callController($controllerName, $methodName, $requiresAuthentication = false, $requiresAdmin = false) {

        $controllerClass = "Controllers\\" . $controllerName;

        $controller = new $controllerClass();

        if ($requiresAuthentication && !$this->isAuthenticated()) {
            $this->redirectTo(INTEGRAL_CONFIG['routes']['error404'][0]);
            return;
        }

        if ($requiresAdmin && !$this->hasRole(INTEGRAL_CONFIG['routes']['authorizations']['valueIsAdmin'])) {
            $this->redirectTo(INTEGRAL_CONFIG['routes']['connection'][0]);
            return;
        }

        $controller->$methodName();
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


    /**
     * Checks if the user is authenticated.
     *
     * @param  void
     * @return bool - Returns true if the user is authenticated, else False.
     */
    private function isAuthenticated() {
        return isset($_SESSION['connected']) && $_SESSION['connected'] === true;
    }


    /**
     * Checks if the user has a specified role.
     *
     * @param  string $role - The role to check.
     * @return bool         - Returns true if the user has the specified role, else False.
     */
    private function hasRole($role) {
        return isset($_SESSION[INTEGRAL_CONFIG['sessionName']]) && $_SESSION[INTEGRAL_CONFIG['sessionName']][INTEGRAL_CONFIG['searchIsAdmin']] === $role;
    }


    /**
     * Public method to create sessions after successful login.
     *
     * @param   array - $data The user data array containing session information.
     * @return  void
     */
    public function createSessions($data) {

        $session = INTEGRAL_CONFIG['sessionName'];
        $defaultRoute = INTEGRAL_CONFIG['routes']['default'];

        // Set the 'connected' session flag to true to indicate successful login.
        $_SESSION['connected'] = true;

        // Set the 'user' session data to the provided user data.
        $_SESSION[$session] = $data;

        // Remove the 'password' key from the 'user' session data for security reasons.
        unset($_SESSION[$session]['password']);

        if ($_SESSION['user']['statuts_id'] === 7){
            $_SESSION['alert'] = "Vous avez reçu une alerte ! Voir votre profil.";
        }else if ($_SESSION['user']['statuts_id'] === 2){
            $_SESSION['alert'] = "Merci de renseigner votre profil";
        
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
        
        session_start();
        
        $_SESSION['error'] = "Déconnexion effectuée !";

        // Redirect to the default 'home' route if the 'route' parameter is not set
        $this->redirectTo(INTEGRAL_CONFIG['routes']['default']);
    }


    /**
     * Render function to display a view within a layout.
     *
     * @param string $viewName   - The name of the view file (without extension) to render.
     * @param string $layoutName - The name of the layout file (without extension) to use.
     * @param array  $data       - An associative array containing data to pass to the view.
     */
    public function render($viewName, $layoutName, $data = []) {
        $page = "";
        // Extract data from the $data array and make them accessible as variables within the function.
        foreach($data as $key => $value) {
            $$key = $value;
        }
        if ($page == "") { $page = $viewName; }        
        $infoNav = $this->infosNav();
        $template = $viewName . '.html.twig';               // Define the path to the view file.
        include_once 'views/' . $layoutName . '.phtml'; // Include the layout file, which will in turn include the view file.
        exit();
    }
    
}

// Start output buffering
ob_start();

$router = new Router();
$router->handleRoute();

// End output buffering and flush the output
ob_end_flush();

?>