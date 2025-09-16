<?php
class Router {
    private $routes = [];
    private $notFoundCallback;
    private $basePath = '';
    private $currentGroup = [];
    
    /**
     * Set the base path for all routes
     */
    public function setBasePath($path) {
        $this->basePath = rtrim($path, '/');
    }
    
    /**
     * Add a route
     */
    private function addRoute($method, $path, $handler) {
        // Add group prefix if exists
        if (!empty($this->currentGroup['prefix'])) {
            $path = $this->currentGroup['prefix'] . '/' . ltrim($path, '/');
        }
        
        $path = rtrim($path, '/');
        
        // Convert route parameters to regex pattern
        $pattern = preg_replace('/\{([^\/]+)\}/', '([^\/]+)', $path);
        $pattern = '#^' . $pattern . '$#';
        
        $this->routes[$method][] = [
            'pattern' => $pattern,
            'handler' => $handler,
            'middleware' => !empty($this->currentGroup['middleware']) ? $this->currentGroup['middleware'] : []
        ];
    }
    
    /**
     * Define a route group
     */
    public function group($prefix, $callback) {
        $previousGroup = $this->currentGroup;
        $this->currentGroup['prefix'] = isset($previousGroup['prefix']) 
            ? $previousGroup['prefix'] . '/' . trim($prefix, '/') 
            : trim($prefix, '/');
            
        $this->currentGroup['middleware'] = $previousGroup['middleware'] ?? [];
        
        $callback($this);
        
        $this->currentGroup = $previousGroup;
    }
    
    /**
     * Add middleware to the current group
     */
    public function middleware($middleware) {
        if (is_string($middleware)) {
            $middleware = [$middleware];
        }
        
        $this->currentGroup['middleware'] = array_merge(
            $this->currentGroup['middleware'] ?? [],
            $middleware
        );
        
        return $this;
    }
    
    /**
     * Define a GET route
     */
    public function get($path, $handler) {
        $this->addRoute('GET', $path, $handler);
        return $this;
    }
    
    /**
     * Define a POST route
     */
    public function post($path, $handler) {
        $this->addRoute('POST', $path, $handler);
        return $this;
    }
    
    /**
     * Define a PUT route
     */
    public function put($path, $handler) {
        $this->addRoute('PUT', $path, $handler);
        return $this;
    }
    
    /**
     * Define a DELETE route
     */
    public function delete($path, $handler) {
        $this->addRoute('DELETE', $path, $handler);
        return $this;
    }
    
    /**
     * Set 404 handler
     */
    public function notFound($callback) {
        $this->notFoundCallback = $callback;
    }
    
    /**
     * Dispatch the request to the appropriate handler
     */
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Get the URL from the query parameter (set by .htaccess)
        $path = isset($_GET['url']) ? $_GET['url'] : '';
        $path = rtrim($path, '/');
        
        // If path is empty, default to home
        if (empty($path)) {
            $path = '';
        }
        
        // Check for matching routes
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route) {
                if (preg_match($route['pattern'], $path, $matches)) {
                    // Remove the full match from matches
                    array_shift($matches);
                    
                    // Apply middleware
                    $this->applyMiddleware($route['middleware']);
                    
                    // Call the handler with parameters
                    $this->callHandler($route['handler'], $matches);
                    return;
                }
            }
        }
        
        // No route found
        if ($this->notFoundCallback) {
            call_user_func($this->notFoundCallback);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo '404 Not Found';
        }
    }
    
    /**
     * Apply middleware to the current request
     */
    private function applyMiddleware($middleware) {
        foreach ($middleware as $m) {
            $middlewareClass = $m . 'Middleware';
            if (class_exists($middlewareClass)) {
                $middlewareInstance = new $middlewareClass();
                $middlewareInstance->handle();
            }
        }
    }
    
    /**
     * Call the route handler
     */
    private function callHandler($handler, $params = []) {
        if (is_callable($handler)) {
            call_user_func_array($handler, $params);
        } elseif (is_string($handler) && strpos($handler, '@') !== false) {
            list($controller, $method) = explode('@', $handler, 2);
            $controllerClass = $controller . 'Controller';
            
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                
                if (method_exists($controllerInstance, $method)) {
                    call_user_func_array([$controllerInstance, $method], $params);
                    return;
                }
            }
        }
        
        // Invalid handler
        throw new \Exception("Invalid route handler");
    }
}
