<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function welcome(Request $request) {
        echo <<<HERE
<pre>
echo alias publish=\"curl -F file=@- https://publish.ip1.cc\" >> ~/.bashrc
echo alias publish=\"curl -F file=@- https://publish.ip1.cc\" >> ~/.zsh

ls | publish

cat file.pdf | publish
</pre>
HERE;
    }

    public function receiveFile(Request $request) {
        $path = Storage::disk('public_uploads')->put('uploads', $request->file('file'));
        if ($path) {
            echo "https://publish.ip1.cc/storage/".$path."\n";
        }
    }
}
