<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Exception;
use App\Models\Role;
use App\Models\Document;
use App\Models\Translation;
use Carbon\Carbon;

class DocumentController extends Controller
{
    public function upload(Request $request){
        $user_id=$request->user()->id;
        $fileExtension = $request->file('document')->extension();
        $fileName= time().$request->name.".".$fileExtension;
        $path =$request->file('document')->move(public_path("/"), $fileName);
        $documentURL=url('/'.$fileName);
        $document= new Document();
        $document->name=$fileName;
        $document->description=$request->description;
        $document->path=$documentURL;
        $document->status_id=1;
        $document->user_id=$user_id;
        $document->save();
        return response()->json(
            $document
        , 200);
    }

    public function saveTranslate(Request $request){
        Storage::disk('public')->put($request->name.'.txt', $request->content);
        $translation= new Translation();
        $translation->name= $request->name;
        $translation->description='Exitoso';
        $translation->path=url('/'.'storage/'.$request->name.'.txt');
        $translation->document_id=$request->document_id;
        $translation->save();
        return response()->json($translation,200);
    }
}
