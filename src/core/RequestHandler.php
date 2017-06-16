<?php

/**
 * Created by PhpStorm.
 * User: khan
 * Date: 16.06.17
 * Time: 21:22
 */
class RequestHandler{
    private $action;
    private $requestList;
    private $callAction;
    private $pathParams;
    public function __construct($requestPaths)
    {
        if (empty($requestPaths[1])) {
            $this->action = MVC_DEFAULT_ACTION;
        } else {
            $this->action = $requestPaths[1];
        }
        if (count($requestPaths) >= 2) {
            $this->pathParams = array_slice($requestPaths, 2);
        } else {
            $this->pathParams = [];
        }
        $this->requestList = [];
    }
    public function registerAction($path, $controllerName, $action){
        $this->requestList[$path] = [$controllerName,$action];
    }
    public function callController(){
        foreach ($this->requestList as $key=>$value){
            if (strpos($this->action, $key)===0){
                $this->callAction = $value;
            }
        }
        return $this->call($this->callAction[0],$this->callAction[1]);
    }
    public function call($controllerName, $functionName)
    {
        $controllerName = ucfirst($controllerName."Controller");
        $controllerPath = SITE_PATH . '/controllers/' . $controllerName . '.php';
        $controllerFunctionName = $functionName;
        if (!file_exists($controllerPath)) {
            exit('No such module for controller "' . $controllerName . '".');
        }
        require_once $controllerPath;
//        use Controllers\$controllerName;
        $controller = new $controllerName();
        if (!method_exists($controller, $controllerFunctionName)) {
            exit('No such action "' . $this->action . '".');
        }
        return $controller->$controllerFunctionName($this->pathParams);
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->action;
    }

}