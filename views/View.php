<?php

/**
 * This class generates views based on parameters sent from controller
 */

class View
{
    /** Page's title
     * @var string
     */
    private string $title;

    /** Constructor
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /** Returns a complete page
     * @param string $viewName
     * @param array $params
     * @return void
     * @throws Exception
     */
    public function render(string $viewName, array $params = []) : void
    {
        $viewPath = $this->buildViewPath($viewName);

        $content = $this->_renderViewFromTemplate($viewPath, $params);
        $title = $this->title;
        ob_start();
        require(MAIN_VIEW_PATH);
        echo ob_get_clean();
    }

    /** Generates what the controller asked
     * @param string $viewPath
     * @param array $params
     * @return string
     * @throws Exception
     */
    private function _renderViewFromTemplate(string $viewPath, array $params = []) : string
    {
       if (file_exists($viewPath)) {
           extract($params);
           ob_start();
           require($viewPath);
           return ob_get_clean();
       } else {
           throw new Exception("La vue '$viewPath' n'existe pas.");
       }
    }

    /** Generates the path to the desired view.
     * @param string $viewName
     * @return string
     */
    private function buildViewPath(string $viewName) : string
    {
        return TEMPLATE_VIEW_PATH . $viewName . '.php';
    }
}