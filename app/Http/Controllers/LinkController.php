<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LinkController extends Controller
{
    public function links(){

        $links = Link::all();
        return view('links', compact('links'));
    }

    public function create_link(Request $request)
    {
        $link = new Link();
        $link->link = $request->link;
        $link->short_link;
        $link->save();
       // $link->short_link = $this->shortenUrl($request->link);
       if ($link->exists()) {
        $shortLink = route('sLink', ['id' => $link->id]);
        $link->short_link = $shortLink;
        $link->save();

    }

        return redirect()->back();
    }
    
    public function sLink($id){

        // $link = Link::find($id);
        // if ($link) {
        //     $link->clicks = $link->clicks + 1;
        //     $link->save();
        //     return redirect()->away($link->link);
        // } else {
        //     abort(404);
        // }

        $id = Link::where('id',$id)->first();
        $link = Link::where('short_link', $id->short_link)->first();
        if ($link) {
            $link->clicks = $link->clicks + 1;
            $link->save();
            return redirect()->away($link->link);
        } else {
            abort(404);
        }

    
    }


    // private function shortenUrl($longUrl)
    // {
    //     $apiUrl = 'https://tinyurl.com/api-create.php?url=' . urlencode($longUrl);
    //     $response = Http::get($apiUrl);
    //     if ($response->ok()) {
    //         return $response->body();
    //     } else {
    //         return 'Error: Unable to generate short URL.';
    //     }
    // }


    public function delete_l(Request $request)
    {
        Link::where('id',$request->id)->delete();
        return back();

    }

}
