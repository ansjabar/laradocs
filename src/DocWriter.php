<?php

namespace AnsJabar\LaraDocs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use AnsJabar\LaraDocs\Disk;

class DocWriter extends Controller
{
    public function __construct($docs)
    {
        $this -> docs = $docs;
    }
    public function write()
    {
        $docs = $this -> formatDocs($this -> docs);
        $this -> writeDocFile($docs);
    }
    private function formatDocs($docs)
    {
        $docs = (collect($docs) -> groupBy('group.title')->sortKeys()->toArray());
        $docs = array_map([$this, "format"], $docs);
        return array_values($docs);
    }
    private function format($docs)
    {
        $group =  $docs[0]['group'];
        $group['slug'] =  Str::slug($docs[0]['group']['title'], '-');
        $fofrmatted_docs['group'] = $group;
        $fofrmatted_docs['resources'] = array_map(function($doc){
            $doc['resource']['slug'] = Str::slug($doc['resource']['title'], '-');
            $doc['resource'] = $this -> responseFormat($doc['resource']);
            return $doc['resource'];
        }, $docs);
        return $fofrmatted_docs;
    }
    private function writeDocFile($docs)
    {
        Storage::disk((new Disk)->name())->put('LaraDocs.json', json_encode($docs));
    }
    private function responseFormat($doc)
    {
        $doc = $this -> successResponse($doc);
        return $this -> failureResponse($doc);
    }
    private function successResponse($doc)
    {
        $success = [];
        foreach(config('laradocs.response.success') as $key => $val)
        {
            $success[$key] = $doc['success'.Str::studly($key)] ?? $val;
            unset($doc['success'.Str::studly($key)]);
        }
        $doc['successResponse'] = $success;
        return $doc;
    }
    private function failureResponse($doc)
    {
        $success = [];
        foreach(config('laradocs.response.failure') as $key => $val)
        {
            $success[$key] = $doc['failure'.Str::studly($key)] ?? $val;
            unset($doc['failure'.Str::studly($key)]);
        }
        $doc['failureResponse'] = $success;
        return $doc;
    }
}