<?phpclass Router
{
    private AuthController $ac;
    private BlogController $pc;

    public function __construct()
    {
        $this->ac = new AuthController();
        $this->pc = new PageController();
    }
    public function handleRequest(array $get) : void
    {
        if(!isset($get["route"]))
        {
            $this->pc->home();
        }
        else if(isset($get["route"]) && $get["route"] === "register")
        {
            $this->ac->register();
        }
        else if(isset($get["route"]) && $get["route"] === "check-register")
        {
            $this->ac->checkRegister();
        }
        else if(isset($get["route"]) && $get["route"] === "login")
        {
            $this->ac->login();
        }
        else if(isset($get["route"]) && $get["route"] === "check-login")
        {
            $this->ac->checkLogin();
        }
        else if(isset($get["route"]) && $get["route"] === "logout")
        {
            $this->ac->logout();
        }
        else if(isset($get["route"]) && $get["route"] === "jeux")
        {
            $this->pc->Jeux();
        }
        
        
        /*else if(isset($get["route"]) && $get["route"] === "category")
        {
            if(isset($get["category_id"]))
            {
                $this->pc->category($get["category_id"]);
            }
            else
            {
                $this->pc->home();
            }
        }*/
        else if(isset($get["route"]) && $get["route"] === "jeux")
        {
            if(isset($get["jeux_id"]))
            {
                $this->pc->post($get["jeux_id"]);
            }
            else
            {
                $this->pc->home();
            }
        }
        else if(isset($get["route"]) && $get["route"] === "check-comment")
        {
            $this->pc->checkComment();
        }
        else
        {
            $this->pc->home();
        }
    }
}