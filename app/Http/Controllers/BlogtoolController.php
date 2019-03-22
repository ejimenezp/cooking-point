<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


use App\Http\Requests;
use App\Blogpost;
use App\Related;

use Log;

class BlogtoolController extends Controller
{

    function get($id) 
    {
        $post = Blogpost::find($id);
        $post->related = $this->related($id);
        return $post;
    }

    function delete($id) 
    {
        $post = Blogpost::find($id);
        Storage::disk('blog_images')->deleteDirectory($post->shortname);
        $post->delete();
        Related::where('post_a', $id)->delete();
        Related::where('post_b', $id)->delete();
    }

    function duplicate($id) 
    {
        $old = Blogpost::find($id);
        $new = $old->replicate();
        $new->status = 'DRAFT';
        $new->save();
        $new->shortname .= $new->id;
        Storage::disk('blog_images')->makeDirectory($new->shortname);
        $new->friendly_url .= $new->id;
        $new->save();
        return $new->id;
    }


    function indexforadmin()
    {
    	$blogposts = Blogpost::orderBy('display_position')->get();
        $subset = $blogposts->map(function ($post) { return $post->only(['id', 'shortname', 'title', 'friendly_url', 'status', 'display_position']); });
        return $subset;
    }

    function indexforuser()
    {
        $blogposts = Blogpost::where('status', 'PUBLISHED')->orderBy('display_position')->get();
        return view('blog.postindex', ['postindex' => $blogposts]);
    }


    function savedisplayposition(Request $request) {
        $pos = 10;
        foreach($request->order as $id) {
            $post = Blogpost::find($id);
            $post->display_position = $pos;
            $post->save();
            $pos += 10;
        }

    }


    function related($id)
    {
        $array = [];
        $related_posts =  Related::where('post_a', $id)->get();
        foreach ($related_posts as $related) {
            array_push($array, $related->post_b);
        }
        return $array;
    }

    function thumbnail($id)
    {
        $post = Blogpost::find($id);
        return $post->only(['title', 'thumbnail_image', 'thumbnail_description', 'friendly_url']);
    }

    function preview($id)
    {
        $post = Blogpost::find($id);
        $array = [];
        $array_related = $this->related($id);
        for ($i = 0; $i < sizeof($array_related) && $i < 3; $i++) {
            array_push($array, $this->thumbnail($array_related[$i]));
        }
        $post->body = str_replace('POSTIMAGES/', '/images/blog/'. $post->shortname . '/', $post->body);
        return view('blog.posttemplate', ['post' => $post, 'related' => $array]);
    }

    function showpost($friendlyurl)
    {
        $post = Blogpost::where('friendly_url', $friendlyurl)
                        ->where('status', 'PUBLISHED')
                        ->firstOrFail();

        return $this->preview($post->id);

    }


    function publish($id)
    {
        $post = Blogpost::find($id);
        if ($post->status != 'DRAFT') {
            return;
        } else {
            $post->status = 'PUBLISHED';
            $post->save();
            return;
        }
    }


    function sitemap() {
        $sitemap = Storage::get('static-sitemap.txt');
        $published = Blogpost::where('status', 'PUBLISHED')->orderBy('friendly_url', 'ASC')->get();
        foreach ($published as $post) {
            $sitemap .= config('app.url') . '/blog/' . $post->friendly_url . "\r\n";
        }
        return response($sitemap, 200)->header('Content-Type', 'text/plain');
    }


    function uploadimage(Request $request)
    {
        $post = Blogpost::find($request->id);
        if($request->hasFile('file')) {
           $path= Storage::disk('blog_images')->putFileAs($post->shortname, $request->file('file'), $request->file('file')->getClientOriginalName());
       }

    }

    function getimages($id)
    {
        $post = Blogpost::find($id);
        $array = Storage::disk('blog_images')->files($post->shortname);
        return $array;
    }

    function removeimages(Request $request) {
        foreach ($request->images as $image) {
            Storage::disk('blog_images')->delete($image);
        }
    }

    function update(Request $request)
    {
        $postid = $request->id;
        $post = Blogpost::find($postid);
        if ($post->shortname != $request->shortname) {
            if (Blogpost::where('shortname', $request->shortname)->get()->isEmpty()) {
                if (preg_match('/^[a-z0-9-_]+$/', $request->shortname)) {
                    Storage::disk('blog_images')->move($post->shortname, $request->shortname);
                    $post->shortname = $request->shortname;
                } else {
                    return Response::json('Wrong format for Shortname. Use [a-z0-9-_]', 403);
                } 
            } else {
                return Response::json('Shortname already exists', 403);
            }
        }
        $post->title = $request->title;
        $post->description = $request->description;
        if ($post->friendly_url != $request->friendly_url) {
            if (Blogpost::where('friendly_url', $request->friendly_url)->get()->isEmpty()) {
                if (preg_match('/^[a-z0-9-_]+$/', $request->friendly_url)) {
                    $post->friendly_url = $request->shortname;
                } else {
                    return Response::json('Wrong format of Friendly URL. Use [a-z0-9-_]', 403);
                } 
            } else {
                return Response::json('Friendly URL already in use', 403);
            }
        }
        $post->friendly_url = $request->friendly_url;
        $post->thumbnail_image = $request->thumbnail_image;
        $post->thumbnail_description = $request->thumbnail_description;
        $post->publishing_date = $request->publishing_date;
        if ($request->status == 'PUBLISHED') {
            $post->status = 'PUBLISHED';   
        } else {
            $post->status = 'DRAFT';
        }
        $post->body = $request->body;
        // delete old pairs
        Related::where('post_a', $postid)->delete();
        Related::where('post_b', $postid)->delete();
        // recreate new pairs
        if (!empty($request->input('related'))) {
            foreach ($request->input('related') as $post_b) {
                $left_right = new Related($postid, $post_b);
                $right_left = new Related($post_b, $postid);
                $left_right->save();
                $right_left->save();            
        }       

        }

        $post->save();
    }

}
