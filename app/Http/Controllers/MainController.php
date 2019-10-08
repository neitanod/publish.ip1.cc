<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function welcome(Request $request) {
        echo <<<HERE
<h2>Para "instalar" el comando en la consola:</h2>
En Bash:
<pre>
    echo alias publish=\"curl -F file=@- https://publish.ip1.cc\" >> ~/.bashrc
</pre>

En Zsh:
<pre>
    echo alias publish=\"curl -F file=@- https://publish.ip1.cc\" >> ~/.zshrc
</pre>
(y reiniciar el shell)


<h2>Modo de uso:</h2>

Publicar la salida de la consola:
<pre>
    ls | publish
</pre>

Publicar un archivo:
<pre>
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
