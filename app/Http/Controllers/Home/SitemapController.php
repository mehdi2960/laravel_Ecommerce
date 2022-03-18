<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function index()
    {
        // create sitemap
        $sitemap = App::make("sitemap");

        // set cache
        $sitemap->setCache('laravel.sitemap-index', false);

        // add sitemaps (loc, lastmod (optional))
        $sitemap->addSitemap(URL::to('sitemap-products'));
        $sitemap->addSitemap(URL::to('sitemap-tags'));

        // show sitemap
        return $sitemap->render('sitemapindex');
    }

    public function sitemapTags()
    {
        // create sitemap
        $sitemap_tags = App::make("sitemap");

        // set cache
        $sitemap_tags->setCache('laravel.sitemap-tags', false);

        // add items
        $tags = Tag::all();

        foreach ($tags as $tag) {
            $sitemap_tags->add($tag->name, $tag->updated_at, '0.5', 'weekly');
        }

        // show sitemap
        return $sitemap_tags->render('xml');
    }

    public function sitemapProducts()
    {
        // create sitemap
        $sitemap_products = App::make("sitemap");

        // set cache
        $sitemap_products->setCache('laravel.sitemap-products', false);

        // add items
        $products = Product::all();

        foreach ($products as $product) {
            $images = [];
            array_push($images, ['url' => asset(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image), 'title' => 'primary_image']);
            foreach ($product->images as $image) {
                array_push($images, ['url' => asset(env('PRODUCT_IMAGES_UPLOAD_PATH') . $image->image), 'title' => $image->image]);
            }
            $sitemap_products->add($product->slug, $product->updated_at, '1.0', 'daily', $images);
        }

        // show sitemap
        return $sitemap_products->render('xml');
    }
}
