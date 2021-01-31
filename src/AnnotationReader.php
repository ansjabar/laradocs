<?php

namespace AnsJabar\LaraDocs;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class AnnotationReader extends Controller
{
	private $raw_doc_block;
	private $parameters = [];
	private $end_pattern = "[ ]*(?:@|\r\n|\n)";
    public function __construct()
    {
        $arguments = func_get_args();
        return $this -> reader($arguments);
    }
    private function reader($arguments)
    {
        $this -> rawDocs($arguments);
        $this ->  parameters = $this -> parseDocs();
    }
    public function read()
    {
        return $this ->  parameters;
    }
    private function getReflectionInstance($arguments)
    {
        $total_arguments = count($arguments);
        if($total_arguments === 1)
        {
            $this -> block_keys = $this -> classBlockKeys();
            return new \ReflectionClass($arguments[0]);
        }
        else if($total_arguments === 2)
        {
            $this -> block_keys = $this -> methodBlockKeys();
            return new \ReflectionMethod($arguments[0], $arguments[1]);
        }
        else
        {
            throw new \Exception("Invalid argument exception.");
        }
    }
    private function rawDocs($arguments)
    {
        $reflection_instance = $this -> getReflectionInstance($arguments);
        $this -> raw_doc_block =  $reflection_instance -> getDocComment();

    }
    private function parseDocs()
    {
        $parsed_docs = [];
        foreach($this -> block_keys as $value)
        {
            $parsed_docs[$value] = $this -> parseValue($value);
        }
        return $parsed_docs;
    }
    private function parseValue($key)
	{
		if(isset($this->parameters[$key]))
			return $this->parameters[$key];
        if(preg_match("/@".preg_quote($key).$this->end_pattern."/", $this->raw_doc_block, $match))
            return true;

        preg_match_all("/@".preg_quote($key)." (.*)".$this->end_pattern."/U", $this->raw_doc_block, $matches);
        $size = sizeof($matches[1]);
        if($size === 0)
            return NULL;
        elseif($size === 1)
            return $this->decodeIfJson($matches[1][0]);
        else
        {
            $this->parameters[$key] = array();
            foreach($matches[1] as $elem)
                $this->parameters[$key][] = $this->decodeIfJson($elem);
            return $this->parameters[$key];
        }
    }
	private function decodeIfJson($string)
	{
		if($string && $string !== 'null')
        {
            if( ($json = json_decode($string,TRUE)) !== NULL)
			{
				return $json;
            }
            return $string;
        }
        return NULL;
    }
    private function classBlockKeys()
    {
        return [
            'title',
            'description',
        ];
    }
    private function methodBlockKeys()
    {
        $keys = $this->defaultHeaders();
        $keys = array_merge($keys, [
            'title',
            'auth',
            'description',
            'method',
            'queryParams',
            'dataParams',
            'headers',
        ]);
        return array_merge($keys, $this -> responseKeys());
    }
    private function defaultHeaders()
    {
        return is_array( config('laradocs.default_headers') ) ?
            array_keys(config('laradocs.default_headers')) : 
            [];
    }
    private function responseKeys()
    {
        return array_merge(
            $this -> successResponseKeys(),
            $this -> failureResponseKeys()
        );
    }
    private function successResponseKeys()
    {
        $keys = [];
        foreach(config('laradocs.response.success') as $key => $val)
        {
            $keys[] = 'success'.Str::studly($key);
        }
        return $keys;
    }
    private function failureResponseKeys()
    {
        $keys = [];
        foreach(config('laradocs.response.failure') as $key => $val)
        {
            $keys[] = 'failure'.Str::studly($key);
        }
        return $keys;
    }
}