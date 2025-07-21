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
        $view = new View('Home');
        $view->render("home");
    }
}
