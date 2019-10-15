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

    public function receiveData(Request $request) {

        if( $request->file('file') ) {
            $path = Storage::disk('public_uploads')->put('uploads', $request->file('file'));
            if ($path) {
                return response("https://publish.ip1.cc/storage/".$path."\n");
            }
        } elseif( $request->input('data') ) {
            $data_key = md5(md5($request->input('data')));
            $internal_path = 'uploads/'.$data_key.'.json';
            $path = Storage::disk('public_uploads')->path($internal_path);
                Storage::disk('public_uploads')->put($internal_path, $request->input('data'));
            if ($path) {
                return response("{\"key\": \"".$data_key."\", \"url\": \"https://publish.ip1.cc/storage/uploads/".$data_key.".json\"}\n")
                    ->withHeaders([
                        "Content-Type" => "application/json; charset=utf-8",
                        "Access-Control-Allow-Origin" => "*",
                        "Access-Control-Allow-Headers" => "Origin, X-Requested-With, Content-Type, Accept"
                    ]);
            }
        } else {
            return response("Nothing received under 'file' or 'data' keys\n");
        }
    }

    public function sendOptions() {
        return response("")
            ->withHeaders([
                "Content-Type" => "application/json; charset=utf-8",
                "Access-Control-Allow-Origin" => "*",
                "Access-Control-Allow-Headers" => "Origin, X-Requested-With, Content-Type, Accept",
                "Allow" => "GET,HEAD,POST"
            ]);
    }
}
