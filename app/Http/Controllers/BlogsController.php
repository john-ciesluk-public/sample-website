<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BlogPosts;

class BlogsController extends Controller
{
     public function __construct(Request $request) {
        $this->siteId = config('sitespecific.siteId');
    }

    /**
     * Show the blogs index page
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        
        $blogs = BlogPosts::join('website_blog_posts','website_blog_posts.blog_posts_id','=','blog_posts.id')
        ->where('website_blog_posts.website_id',$this->siteId)
        ->orderBy('release_date','DESC')
        ->paginate(20);
        return view('blogs/index', ['blogs' => $blogs]);
    }

    /**
     * Show the blog view page
     *
     * @return \Illuminate\View\View
     */
    public function view($slug)
    {
        $blog = BlogPosts::where('blog_posts.slug',$slug)
            ->join('website_blog_posts','website_blog_posts.blog_posts_id','=','blog_posts.id')
            ->where('website_blog_posts.website_id',$this->siteId)
            ->first();

        if ($blog) {
            return view('blogs/view',['blog' => $blog]);
        }
        abort(404);
    }
   
}
