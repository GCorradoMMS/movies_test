<?php
class Utils {

    public function appHeader()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }
    
    public function notFound()
    {
        header("HTTP/1.1 404 Not Found");
        print_r(json_encode([
            'error' => true,
            'message'  => "Your request was not found!",
            'code' => 404]));
        exit();
    }
    
    public function successResponse($name, $type)
    {
        print_r(json_encode([
            'error' => false,
            'message'  => "$name : $type",
            'code' => 200]));
        exit();
    }
    
    public function errorResponse()
    {
        print_r(json_encode([
            'error' => true,
            'message'  => "Something went wrong!",
            'code' => 500]));
        exit();
    }
    
    public function pp($msg, $isDie = true)
    {
        print("<pre>".print_r($msg,true)."</pre>");
        if($isDie)
            die();
    }
}