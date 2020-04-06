<?php

namespace AnsJabar\LaraDocs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use AnsJabar\LaraDocs\AnnotationReader;

class DocGenerator extends Controller
{
    private $docs;
    public function __construct($routes)
    {
        return $this -> generate($routes);
    }
    private function generate($routes)
    {
        $this -> docs = array_map([$this, "annotations"], $routes);
    }
    public function getDocs()
    {
        return array_filter($this -> docs);
    }
    private function annotations($route)
    {
        $group_annorations  = (new AnnotationReader($route['class']))->read(); 
        $method_annorations  = (new AnnotationReader($route['class'], $route['method']))->read();
        
        if(
            $this -> isValidGroupAnnotation($group_annorations) &&
            $this -> isValidMethodAnnotation($method_annorations)
        )
        {
            return [
                'group' => $group_annorations,
                'resource' => $this -> parseMethodAnnotations($method_annorations, $route)
            ];
        }

    }
    private function parseMethodAnnotations($method_annorations, $route)
    {
        if(empty($method_annorations['method']))
        {
            $method_annorations['method'] = $route['http_methods'];
        }
        else
        {
            $method_annorations['method'] = array($method_annorations['method']);
        }
        $method_annorations['path'] = $route['path'];
        $method_annorations = $this -> parseParameters($method_annorations);
        return $method_annorations;
    }
    private function parseParameters($method_annorations)
    {
        $filtered_params = $this -> filterParameters($method_annorations);
        foreach($filtered_params as $key => $val)
        {
            $method_annorations[$key] = $this -> parseParameter($key, $val);
        }
        return $method_annorations;
    }
    private function filterParameters($method_annorations)
    {
        return Arr::where($method_annorations, function ($value, $key) {
            return in_array($key, ["queryParams", "dataParams", "headers"]);
        });
    }
    private function parseParameter($param_name, $parameter)
    {
        if(empty($parameter))
            return null;
        else if(is_array($parameter))
        {
            return $this -> explodeANdParse($param_name, $parameter);
        }
        else
        {
            return $this -> explodeANdParse($param_name, (array)$parameter);
        }
    }
    private function explodeANdParse($param_name, $parameters)
    {
        $exploded_params = [];
        foreach($parameters as $key => $value)
        {
            $exploded_params[] = [
                "name" => $this -> parseParameterName($value),
                "required" => $this -> parseParameterPresence($value),
                "type" => $this -> parseParameterType($param_name, $value),
                "description" => $value
            ];
        }
        return $exploded_params;
    }
    private function parseParameterName(&$value)
    {
            $array = explode(' ', $value, 2);
            $value = $array[1];
            return $array[0];
    }
    private function parseParameterPresence(&$value)
    {
        $array = explode(' ', $value, 2);
        $name = $array[0];
        if(in_array(strtoupper($array[0]), ["REQUIRED", "OPTIONAL"]))
        {
            $value = $array[1];
            return strtoupper($name);
        }
        return null;
    }
    private function parseParameterType($param_name, &$value)
    {
        $array = explode(' ', $value, 2);
        $name = $array[0];
        if($param_name != "headers" && in_array(strtoupper($array[0]), ["NUMBER", "STRING", "FLOAT", "EMAIL", "OBJECT", "ARRAY"]))
        {
            $value = $array[1];
            return Str::ucfirst($name);
        }
        else if($param_name == "headers")
        {
            $value = $array[1];
            return $name;
        }
        return null;
    }
    private function isValidGroupAnnotation($group_annorations)
    {
        if(empty($group_annorations['title']) || empty($group_annorations['description']))
            return false;
        return true;
    }
    private function isValidMethodAnnotation($method_annorations)
    {
        if(
            empty($method_annorations['title']) ||
            empty($method_annorations['description'])
        )
            return false;
        return true;
    }
}