<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;

class HomeController extends Controller
{
    /**
     * Show the home page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $defaults = Product::whereEnabled(true)
                ->join('product_images','product_images.product_id','=','products.id')
                ->limit(4)
                ->inRandomOrder()
                ->get();
        return view('pages/home', ['defaults' => $defaults]);
    }

    /**
     * Show the about page
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('pages/about');
    }

    /**
     * Show the contact page
     *
     * @return \Illuminate\View\View
     */
    public function contact()
    {
        return view('pages/contact');
    }

    /**
     * Show the instructions page
     *
     * @return \Illuminate\View\View
     */
    public function instructions()
    {
        return view('pages/instructions');
    }

    /**
     * Show the videos page
     *
     * @return \Illuminate\View\View
     */
    public function videos()
    {
        return view('pages/videos');
    }

    /**
     * Show the privacy page
     *
     * @return \Illuminate\View\View
     */
    public function privacy()
    {
        return view('pages/privacy');
    }

    /**
     * Show the catalogs page
     *
     * @return \Illuminate\View\View
     */
    public function catalogs()
    {
        return view('pages/catalogs');
    }

    /**
     * Show the shipping terms page
     *
     * @return \Illuminate\View\View
     */
    public function shipping()
    {
        return view('pages/shipping-terms');
    }

    /**
     * Show the merchandise page
     *
     * @return \Illuminate\View\View
     */
    public function merchandise()
    {
        return view('pages/merchandise');
    }

    /**
     * Show the warranty page
     *
     * @return \Illuminate\View\View
     */
    public function warranty()
    {
        return view('pages/warranty');
    }

    /**
     * Show the faq page
     *
     * @return \Illuminate\View\View
     */
    public function faq()
    {
        return view('pages/faq');
    }

    /**
     * Show the vehicle safety page
     *
     * @return \Illuminate\View\View
     */
    public function adas()
    {
        return view('pages/adas');
    }

    /**
     * Show the Installation Tips page
     *
     * @return \Illuminate\View\View
     */
    public function installation()
    {
        return view('pages/installation');
    }

    /**
     * Show the Accessibility Statement page
     *
     * @return \Illuminate\View\View
     */
    public function accessibility()
    {
        return view('pages/accessibility');
    }
}
