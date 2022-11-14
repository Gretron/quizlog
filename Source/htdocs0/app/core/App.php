<?php

namespace app\core;

/**
 * Web Application
 */
class App
{
    private $controller = 'User';
    private $method = 'index';

    /**
     * Default Constructor
     */
    public function __construct()
    {
        // Separate Url in Parts
        $url = self::parseUrl();

        // Check If First Part of Url & Corresponding File Exists
        if (isset($url[0]))
        {
            if (file_exists('app/controllers/' . $url[0] . '.php'))
            {
                // Select Appropriate Controller
                $this->controller = $url[0];
            }

            unset($url[0]);
        }

        // Instantiate Controller
        $this->controller = 'app\\controllers\\' . $this->controller;
        $this->controller = new $this->controller;

        // Check If Second Part of Url & Corresponding Method Exists
        if (isset($url[1]))
        {
            if (method_exists($this->controller, $url[1]) && $url[1] != 'view')
            {
                // Select Appropriate Method
                $this->method = $url[1];
            }

            unset($url[1]);
        }

        // Get Class and Method Attributes & Run Attribute Methods
        $reflection = new \ReflectionObject($this->controller);

        $classAttributes = $reflection->getAttributes();
        $methodAttributes = $reflection->getMethod($this->method)->getAttributes();
        $attributes = array_values(array_merge($classAttributes, $methodAttributes));

        foreach ($attributes as $attribute)
        {
            $filter = $attribute->newInstance();

            if ($filter->execute())
            {
                return;
            }
        }

        // Get Remaining Parameters If Any
        $params = $url ? array_values($url) : [];

        // Call Method on Controller & Pass Remaining Parameters
        call_user_func([$this->controller, $this->method], $params);
    }

    /**
     * Parse Url & Return as an Array of Url Segments
     * @return string[]
     */
    public static function parseUrl()
    {
        if (isset($_GET['url']))
        {
            return explode('/',
                filter_var(
                    rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}