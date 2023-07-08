<?php
/* 
    *App Core class
    *creates URL and loads core controller
    *URL FORMAT - /controller/method/params
*/

    class Core{
        protected $currentController = "pages";
        protected $currentMethod = "index";
        protected $params = [];

        public function __construct(){
            // print_r($this->getUrl());
            $url = $this->getUrl();

            //look in controllers for first value
            if(file_exists('../app/controllers/' . ucwords($url[0]) . '.php')){
                //if exists, set as current controller
                $this->currentController = ucwords($url[0]);
                //unset 0 index
                unset($url[0]);
            }

            //require the controller
            require_once "../app/controllers/" . $this->currentController . ".php";

            //instantiate the controller class
            $this->currentController = new $this->currentController;

            //check for the second part of the url

            if(isset($url[1])){
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];
                    //unset index 1
                    unset($url[1]);
                }
            }

            echo $this->currentMethod;
        }

        public function getUrl(){
            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'], '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                return $url;
            }
        }
    }