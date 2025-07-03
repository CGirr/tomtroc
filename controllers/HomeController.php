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
        $homeController = new HomeController();

        $view = new View('Home');
        $view->render("home");
    }
}
