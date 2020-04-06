<?php

namespace AnsJabar\LaraDocs;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

class RouteScanner extends Controller
{
    public function __construct()
    {
        
    }
    public function routes()
    {
        $routes = [];
        $routes_collection = Route::getRoutes();
        foreach($routes_collection as $collection)
        {
            if($this -> shouldKeepThisRoute($collection))
            {
                $routes[] = [
                    'class' => $this -> controller($collection),
                    'method' => $collection -> getActionMethod(),
                    'http_methods' => $this -> httpMethods($collection),
                    'path' => $collection -> uri()
                ];
            }
        }
        return $routes;
    }
    private function shouldKeepThisRoute($collection)
    {
        return Str::contains($collection -> getActionName(), '@');
    }
    private function httpMethods($collection)
    {
        $all_methods = $collection -> methods();
        return Arr::where($all_methods, function ($value, $key) {
            return !in_array($value, ["HEAD", "OPTIONS"]);
        });
    }
    private function controller($collection)
    {
        return explode('@', $collection -> getActionName(),2)[0];
    }

}