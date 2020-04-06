<?php

namespace AnsJabar\LaraDocs;

use App\Http\Controllers\Controller;
use AnsJabar\LaraDocs\RouteScanner;
use AnsJabar\LaraDocs\DocWriter;
use AnsJabar\LaraDocs\DocGenerator;

class Generator extends Controller
{
    public function __construct()
    {
        
    }
    public function generate()
    {
        $routes = (new RouteScanner())->routes();
        $docs = (new DocGenerator($routes))->getDocs(); 
        return (new DocWriter($docs))->write();
    }
}