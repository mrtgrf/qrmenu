<?php

class Router {
    private $routes = [];

    public function get($uri, $callback) {
        $this->addRoute("GET", $uri, $callback);
    }

    public function post($uri, $callback) {
        $this->addRoute("POST", $uri, $callback);
    }

    public function put($uri, $callback) {
        $this->addRoute("PUT", $uri, $callback);
    }

    public function delete($uri, $callback) {
        $this->addRoute("DELETE", $uri, $callback);
    }

    private function addRoute($method, $uri, $callback) {
        $this->routes[] = ["method" => $method, "uri" => $uri, "callback" => $callback];
    }

    public function run() {
        $uri = $this->getUri();
        $method = $_SERVER["REQUEST_METHOD"];

        foreach ($this->routes as $route) {
            if ($route["method"] === $method && $this->matchUri($route["uri"], $uri, $params)) {
                $this->executeCallback($route["callback"], $params);
                return;
            }
        }
        header("HTTP/1.0 404 Not Found");
        require_once __DIR__ . "/../views/error.php";
    }

         private function getUri() {
        error_log("START getUri() - Debugging URL parsing");
        error_log("RAW REQUEST_URI: " . $_SERVER["REQUEST_URI"]);

        $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        error_log("Parsed URI (PHP_URL_PATH): " . $uri);

        $uri = trim($uri, "/");
        error_log("Trimmed URI: " . $uri);
        $scriptName = $_SERVER["SCRIPT_NAME"];
        $basePath = dirname($scriptName);
        $basePath = trim($basePath, "/");
        if ($basePath === ".") {
            $basePath = "";
        }

        error_log("Calculated Base Path (from SCRIPT_NAME): " . $basePath);
        if (!empty($basePath) && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
            $uri = trim($uri, "/");
            error_log("URI after base path removal: " . $uri);
        }

        error_log("FINAL URI: " . $uri);
        error_log("END getUri()");
        return $uri;
    }



        private function matchUri($routeUri, $requestUri, &$params) {
        error_log("START matchUri()");
        error_log("Route URI: " . $routeUri);
        error_log("Request URI: " . $requestUri);

        $routeParts = explode("/", trim($routeUri, "/"));
        $requestParts = explode("/", trim($requestUri, "/"));

        error_log("Route Parts: " . print_r($routeParts, true));
        error_log("Request Parts: " . print_r($requestParts, true));

        if (count($routeParts) !== count($requestParts)) {
            error_log("Count mismatch: " . count($routeParts) . " vs " . count($requestParts));
            return false;
        }

        $params = [];
        foreach ($routeParts as $key => $part) {
            if (preg_match("/^{([a-zA-Z0-9_]+)}$/", $part, $matches)) {
                $params[$matches[1]] = $requestParts[$key];
                error_log("Matched param: " . $matches[1] . " = " . $requestParts[$key]);
            } else if ($part !== $requestParts[$key]) {
                error_log("Part mismatch: " . $part . " vs " . $requestParts[$key]);
                return false;
            }
        }
        error_log("FINAL Params: " . print_r($params, true));
        error_log("END matchUri()");
        return true;
    }


       private function executeCallback($callback, $params) {
        error_log("START executeCallback()");
        error_log("Callback: " . (is_string($callback) ? $callback : "(callable)"));
        error_log("Params received by executeCallback: " . print_r($params, true));

        if (is_callable($callback)) {
            call_user_func_array($callback, $params);
        } elseif (is_string($callback)) {
            $this->executeControllerAction($callback, $params);
        } else {
            header("HTTP/1.0 500 Internal Server Error");
            echo "Invalid route callback.";
        }
        error_log("END executeCallback()");
    }


           private function executeControllerAction($callbackString, &$params) {
        error_log("START executeControllerAction()");
        error_log("Callback String: " . $callbackString);
        error_log("Received Params (by reference): " . print_r($params, true));

        list($controllerName, $action) = explode("@", $callbackString);
        $controllerFile = __DIR__ . "/". $controllerName . ".php";

        if (!file_exists($controllerFile)) {
            header("HTTP/1.0 404 Not Found");
            echo "Controller file not found: " . $controllerFile;
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            header("HTTP/1.0 500 Internal Server Error");
            echo "Controller class not found: " . $controllerName;
            return;
        }

        $controllerInstance = new $controllerName();

        if (!method_exists($controllerInstance, $action)) {
            header("HTTP/1.0 404 Not Found");
            echo "Action " . $action . " not found in " . $controllerName;
            return;
        }

        call_user_func_array([$controllerInstance, $action], $params);
        error_log("END executeControllerAction()");
    }


}
