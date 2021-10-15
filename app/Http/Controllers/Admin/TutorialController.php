<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutorial;
use App\Models\Admin;

class TutorialController extends Controller
{
    public function index(){
        $d=['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];

        $all=Tutorial::all();
        return view('admin.tutorial.index',$d,compact('all'));
    }


    public function tutorialAdd(){
        $d=['LoggedUserInfo'=>Admin::where('id','=',session('LoggedUser'))->first()];
        return view('admin.tutorial.addtutorial',$d);
    }

    public function postTutorial(Request $req){


        $input = $req->all();
        //dd($input);

        $description=$req->body;
        $dom = new \DomDocument();
        $dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        foreach($images as $k => $img){
            $data = $img->getAttribute('src');

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            $image_name="/uploads/Tutorial/" . time().$k.'.png';

            $path = public_path() . $image_name;



            file_put_contents($path, $data);

            $img->removeAttribute('src');
            $img->setAttribute('src', $image_name);
        }

        $details = $dom->saveHTML();

        $tutorial = new Tutorial;
        $tutorial->title = $req->title;
        $tutorial->s_description = $req->s_description;
        $tutorial->details = $details;
     

        $tutorial->save();

        session()->flash('success',' New Tutorial Created');

        return redirect()->back();

    }


    public function delete(Tutorial $id)
    {
        $id->delete();
        return response()->json('Blog successfully Deleted!!!');
    }

}
