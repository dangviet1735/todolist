<?php

namespace app\core;

use app\core\Request;

class Router
{
    public Request $request;
    protected array $routers = [];
    
    /**
     * __construct
     *
     * @param  mixed $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    /**
     * get
     *
     * @param  mixed $path
     * @param  mixed $callback
     * @return void
     */
    public function get($path, $callback)
    {
        $this->routers['get'][$path] = $callback;
    }
    
    /**
     * post
     *
     * @param  mixed $path
     * @param  mixed $callback
     * @return void
     */
    public function post($path, $callback)
    {
        $this->routers['post'][$path] = $callback;
    }
    
    /**
     * resolve
     *
     * @return mixed
     */
    public function resolve()
    {
        $path = $this->request->getPath();

        $method = $this->request->getMethod();
        $callback = $this->routers[$method][$path] ?? false;

        if ($callback === false) {
            echo "Not found";
            exit;
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        echo call_user_func($callback);
    }
    
    /**
     * renderView
     *
     * @param  mixed $view
     * @return void
     */
    public function renderView($view)
    {
        include_once __DIR__.'/../views/'. $view .'.php';
    }
}