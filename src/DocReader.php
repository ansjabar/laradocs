<?php

namespace AnsJabar\LaraDocs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use AnsJabar\LaraDocs\Disk;
use Illuminate\Support\Arr;

class DocReader extends Controller
{
    public function index($group_name = null)
    {
        $docs = $this -> readDocFile();
        $docs = collect(json_decode($docs));
        $groups = $docs -> pluck('group') -> all();
        $resources = $this -> resources($docs, $group_name);
        return view('laradocs::docs')->with('groups', $groups)
                                     ->with('resources', $resources)
                                     ->with('endpoints', config('laradocs.endpoints'))
                                     ->with('group_name', $group_name)
                                     ->with('arr', new Arr());
    }
    private function readDocFile()
    {
        if(Storage::disk((new Disk)->name())->exists('LaraDocs.json'))
        {
            return Storage::disk((new Disk)->name())->get('LaraDocs.json');
        }
        abort(404);
    }
    private function resources($docs, $group_name)
    {
        if(empty($group_name))
            $group_name = $docs -> pluck('group.slug') -> first();
        $docs =  $docs->where('group.slug', $group_name)->first();
        if(empty($docs))
            abort(404);
        return $docs;
    }
}