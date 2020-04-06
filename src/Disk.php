<?php

namespace AnsJabar\LaraDocs;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class Disk extends Controller
{
    private $disk_name = 'laradocs';
    public function __construct()
    {
        config(['filesystems.disks.' . $this -> disk_name => [
                'driver' => 'local',
                'root' => public_path('ansjabar/laradocs/'),
            ]
        ]);
    }
    public function name()
    {
        return $this -> disk_name;
    }
}