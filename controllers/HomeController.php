<?php

class HomeController
{
    /**
     * Displays home page
     * @return void
     * @throws Exception
     */
    public function showHome() : void
    {
        $action = Helpers::request('action', 'home', 'get');
        $view = new View('Home');
        $view->render("home",['action' => $action]);
    }
}
