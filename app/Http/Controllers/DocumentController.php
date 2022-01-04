<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Models\Role;
use App\Models\Document;
use Carbon\Carbon;

class DocumentController extends Controller
{
    public function upload(Request $request){
        $fileName= time().$request->name.".pdf";
        $path =$request->file('document')->move(public_path("/"), $fileName);
        $documentURL=url('/'.$fileName);
        $document= new Document();
        $document->name=$fileName;
        $document->description=$request->description;
        $document->path=$documentURL;
        $document->status_id=1;
        $document->save();
        return response()->json(['url' => $documentURL], 200);
    }

    
}
