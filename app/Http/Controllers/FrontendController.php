<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Hash;
use Session;
use App\User;
use Newsletter;
use App\Models\Cart;
use App\Models\Post;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\Country;
use App\Models\PostTag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Mail\VerificationCodeMail;
use App\Services\RedisCacheService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;


class FrontendController extends Controller
{

    public function index(Request $request)
    {
        return redirect()->route($request->user()->role);
    }

    public function home(RedisCacheService $cache)
    {
        $ttl = 60 * 60 * 24;
        $featured = $cache->remember('product_listing_featured', $ttl, function () {
            return Product::where('status', 'active')->where('is_featured', 1)->orderBy('price', 'DESC')->limit(2)->get()
            ->map(function ($product) {
                if ($product->photo) {
                    // Determine image size folders based on orientation
                    if ($product->image_width > $product->image_height) {
                        $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                    } elseif ($product->image_height > $product->image_width) {
                        $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                    } else {
                        $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                    }
                    $directory = dirname($product->photo);
                    $filename = basename($product->photo);
                    $imagePaths = [];
                    foreach ($sizes as $key => $folder) {
                        // Build URL
                        $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                    }

                    $product->images = $imagePaths;
                    $product->photo = $imagePaths['m'];  // already full URL here
                    return $product;
                }
            });
        });

        $posts = $cache->remember('post_listing', $ttl, function () {
            return Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get()
            ->map(function ($post) {
                if ($post->photo) {
                    // Determine image size folders based on orientation
                    if ($post->image_width > $post->image_height) {
                        $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                    } elseif ($post->image_height > $post->image_width) {
                        $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                    } else {
                        $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                    }
                    $directory = dirname($post->photo);
                    $filename = basename($post->photo);
                    $imagePaths = [];
                    foreach ($sizes as $key => $folder) {
                        // Build URL
                        $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                    }

                    $post->images = $imagePaths;
                    $post->photo = $imagePaths['s'];  // already full URL here
                    return $post;
                }
            });
        });
        $banners = $cache->remember('banner_listing', $ttl, function () {
            return Banner::where('status', 'active')->limit(3)->orderBy('id', 'DESC')->get()
            ->map(function ($banner) {
                if ($banner->photo) {
                    // Determine image size folders based on orientation
                    if ($banner->image_width > $banner->image_height) {
                        $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                    } elseif ($banner->image_height > $banner->image_width) {
                        $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                    } else {
                        $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                    }
                    $directory = dirname($banner->photo);
                    $filename = basename($banner->photo);
                    $imagePaths = [];
                    foreach ($sizes as $key => $folder) {
                        // Build URL
                        $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                    }

                    $banner->images = $imagePaths;
                    $banner->photo = $imagePaths['l'];  // already full URL here
                    return $banner;
                }
            });
        });
        // return $banner;
        $products = $cache->remember('product_listing', $ttl, function () {
            return Product::where('status', 'active')->orderBy('id', 'DESC')->limit(8)->get()
            ->map(function ($product) {
                if ($product->photo) {
                    // Determine image size folders based on orientation
                    if ($product->image_width > $product->image_height) {
                        $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                    } elseif ($product->image_height > $product->image_width) {
                        $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                    } else {
                        $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                    }
                    $directory = dirname($product->photo);
                    $filename = basename($product->photo);
                    $imagePaths = [];
                    foreach ($sizes as $key => $folder) {
                        // Build URL
                        $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                    }

                    $product->images = $imagePaths;
                    $product->photo = $imagePaths['s'];  // already full URL here
                    return $product;
                }
            });
        });
        //src="{{ isset($product->photo) ? $product->images['s'] : $product->photo }}
        $category = $cache->remember('category_listing', $ttl, function () {
            return Category::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'ASC')->get()
            ->map(function ($cat) {
                if ($cat->photo) {
                    // Determine image size folders based on orientation
                    if ($cat->image_width > $cat->image_height) {
                        $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                    } elseif ($cat->image_height > $cat->image_width) {
                        $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                    } else {
                        $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                    }
                    $directory = dirname($cat->photo);
                    $filename = basename($cat->photo);
                    $imagePaths = [];
                    foreach ($sizes as $key => $folder) {
                        // Build URL
                        $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                    }

                    $cat->images = $imagePaths;
                    $cat->photo = $imagePaths['s'];  // already full URL here
                    return $cat;
                }
            });
        });
        // return $category;
        return view('frontend.index')
            ->with('featured', $featured)
            ->with('posts', $posts)
            ->with('banners', $banners)
            ->with('product_lists', $products)
            ->with('category_lists', $category);
    }

    public function aboutUs()
    {
        return view('frontend.pages.about-us');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }


    public function gallery()
    {
        return view('frontend.pages.gallery');
    }

    public function customization()
    {
        return view('frontend.pages.customization');
    }

    public function productDetail($slug, $country_code = null)
    {
        $cache = app(RedisCacheService::class);
        $ttl = 60 * 60 * 24;
        $product_detail = $cache->remember('product_detail_'.$slug, $ttl, function () use($slug) {
             return Product::getProductBySlug($slug);
        });
        $countries = $cache->remember('country_listing', $ttl, function () {
            return Country::orderBy('name')->get();
        });

        // Flag to check if cookies are set and need redirect
        $shouldRedirect = false;

        if ($country_code !== null) {
            $country_code = $country_code;

            $ratesFilePath = 'data/currencyrate/rates.json';
            $countryFilePath = 'data/countries.json';


            if (Storage::exists($ratesFilePath) && Storage::exists($countryFilePath)) {
                $ratesData = json_decode(Storage::get($ratesFilePath), true);
                $countryList = json_decode(Storage::get($countryFilePath), true);

                if (isset($ratesData['npr'][$country_code])) {
                    $rate = 1 / $ratesData['npr'][$country_code];

                    $matchedCountry = collect($countryList)->firstWhere('currency_code', strtoupper($country_code));



                    if ($matchedCountry) {
                        Cookie::queue('currency_rate', $rate, 60);
                        Cookie::queue('currency_symbol', $matchedCountry['currency_symbol'], 60);
                        Cookie::queue('country_name', $matchedCountry['name'], 60);

                        $shouldRedirect = true;
                    }
                }
            }
        }

        if ($shouldRedirect) {
            // Redirect to same route without country_code in URL
            return redirect()->route('product-detail', ['slug' => $slug]);
        }

        return view('frontend.pages.product_detail', [
            'product_detail' => $product_detail,
            'countries' => $countries,
        ]);
    }

    public function currencyChange($country_code,$country_name)
    {
        $ratesFilePath = 'data/currencyrate/rates.json';
        $countryFilePath = 'data/countries.json';


        if (Storage::exists($ratesFilePath) && Storage::exists($countryFilePath)) {
            $ratesData = json_decode(Storage::get($ratesFilePath), true);
            $countryList = json_decode(Storage::get($countryFilePath), true);

            if (isset($ratesData['npr'][$country_code])) {
                $rate = 1 / $ratesData['npr'][$country_code];

                $matchedCountry = collect($countryList)->firstWhere('currency_code', strtoupper($country_code));

                if ($matchedCountry) {
                    Cookie::queue('currency_rate', $rate, 60);
                    Cookie::queue('currency_symbol', $matchedCountry['currency_symbol'], 60);
                    Cookie::queue('country_name', $country_name, 60);
                }
            }
        }

        return redirect()->back();
    }




    public function productGrids(RedisCacheService $cache)
    {
        $ttl = 60 * 60 * 24;
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids);
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        $recent_products = $cache->remember('product_listing_recent', $ttl, function () {
             return Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get()
             ->map(function ($product) {
                if ($product->photo) {
                    // Determine image size folders based on orientation
                    if ($product->image_width > $product->image_height) {
                        $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                    } elseif ($product->image_height > $product->image_width) {
                        $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                    } else {
                        $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                    }
                    $directory = dirname($product->photo);
                    $filename = basename($product->photo);
                    $imagePaths = [];
                    foreach ($sizes as $key => $folder) {
                        // Build URL
                        $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                    }

                    $product->images = $imagePaths;
                    $product->photo = $imagePaths['s'];  // already full URL here
                    return $product;
                }
            });
        });
        
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', 'active')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', 'active')->paginate(9);
        }
        // Sort by name , price, category
        $products->map(function ($product) {
            if ($product->photo) {
                // Determine image size folders based on orientation
                if ($product->image_width > $product->image_height) {
                    $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                } elseif ($product->image_height > $product->image_width) {
                    $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                } else {
                    $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                }
                $directory = dirname($product->photo);
                $filename = basename($product->photo);
                $imagePaths = [];
                foreach ($sizes as $key => $folder) {
                    // Build URL
                    $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                }

                $product->images = $imagePaths;
                $product->photo = $imagePaths['s'];  // already full URL here
                return $product;
            }
        });


        return view('frontend.pages.product-grids')->with('products', $products)->with('recent_products', $recent_products);
    }
    public function productLists(RedisCacheService $cache)
    {
        $ttl = 60 * 60 * 24;
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids)->paginate;
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        $recent_products = $cache->remember('product_listing_recent', $ttl, function () {
            return Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get()
            ->map(function ($product) {
                if ($product->photo) {
                    // Determine image size folders based on orientation
                    if ($product->image_width > $product->image_height) {
                        $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                    } elseif ($product->image_height > $product->image_width) {
                        $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                    } else {
                        $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                    }
                    $directory = dirname($product->photo);
                    $filename = basename($product->photo);
                    $imagePaths = [];
                    foreach ($sizes as $key => $folder) {
                        // Build URL
                        $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                    }

                    $product->images = $imagePaths;
                    $product->photo = $imagePaths['s'];  // already full URL here
                    return $product;
                }
            });
        });
        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', 'active')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', 'active')->paginate(6);
        }
        // Sort by name , price, category

        $products->map(function ($product) {
            if ($product->photo) {
                // Determine image size folders based on orientation
                if ($product->image_width > $product->image_height) {
                    $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                } elseif ($product->image_height > $product->image_width) {
                    $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                } else {
                    $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                }
                $directory = dirname($product->photo);
                $filename = basename($product->photo);
                $imagePaths = [];
                foreach ($sizes as $key => $folder) {
                    // Build URL
                    $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                }

                $product->images = $imagePaths;
                $product->photo = $imagePaths['s'];  // already full URL here
                return $product;
            }
        });

        return view('frontend.pages.product-lists')->with('products', $products)->with('recent_products', $recent_products);
    }
    public function productFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $showURL = "";
        if (!empty($data['show'])) {
            $showURL .= '&show=' . $data['show'];
        }

        $sortByURL = '';
        if (!empty($data['sortBy'])) {
            $sortByURL .= '&sortBy=' . $data['sortBy'];
        }

        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $brandURL = "";
        if (!empty($data['brand'])) {
            foreach ($data['brand'] as $brand) {
                if (empty($brandURL)) {
                    $brandURL .= '&brand=' . $brand;
                } else {
                    $brandURL .= ',' . $brand;
                }
            }
        }
        // return $brandURL;

        $priceRangeURL = "";
        if (!empty($data['price_range'])) {
            $priceRangeURL .= '&price=' . $data['price_range'];
        }
        if (request()->is('e-shop.loc/product-grids')) {
            return redirect()->route('product-grids', $catURL . $brandURL . $priceRangeURL . $showURL . $sortByURL);
        } else {
            return redirect()->route('product-lists', $catURL . $brandURL . $priceRangeURL . $showURL . $sortByURL);
        }
    }
    public function productSearch(Request $request, RedisCacheService $cache)
    {
        $ttl = 60 * 60 * 24;
        $recent_products = $cache->remember('product_listing_recent', $ttl, function () {
            return Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get()
            ->map(function ($product) {
                if ($product->photo) {
                    // Determine image size folders based on orientation
                    if ($product->image_width > $product->image_height) {
                        $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                    } elseif ($product->image_height > $product->image_width) {
                        $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                    } else {
                        $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                    }
                    $directory = dirname($product->photo);
                    $filename = basename($product->photo);
                    $imagePaths = [];
                    foreach ($sizes as $key => $folder) {
                        // Build URL
                        $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                    }

                    $product->images = $imagePaths;
                    $product->photo = $imagePaths['s'];  // already full URL here
                    return $product;
                }
            });
        });
        $products = Product::orwhere('title', 'like', '%' . $request->search . '%')
            ->orwhere('slug', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('summary', 'like', '%' . $request->search . '%')
            ->orwhere('price', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate('9');
        $mappedItems =$products->getCollection()->map(function ($product) {
            if ($product->photo) {
                // Determine image size folders based on orientation
                if ($product->image_width > $product->image_height) {
                    $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                } elseif ($product->image_height > $product->image_width) {
                    $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                } else {
                    $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                }
                $directory = dirname($product->photo);
                $filename = basename($product->photo);
                $imagePaths = [];
                foreach ($sizes as $key => $folder) {
                    // Build URL
                    $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                }

                $product->images = $imagePaths;
                $product->photo = $imagePaths['s'];  // already full URL here
                return $product;
            }
        });
        $products->setCollection($mappedItems);
        return view('frontend.pages.product-grids')->with('products', $products)->with('recent_products', $recent_products);
    }

    public function productBrand(Request $request, RedisCacheService $cache)
    {
        $ttl = 60 * 60 * 24;
        $products = $cache->remember('product_listing_brand_'.$request->slug, $ttl, function () {
            return Brand::getProductByBrand($request->slug);
        });
        $recent_products = $cache->remember('product_listing_recent', $ttl, function () {
            return Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get()
            ->map(function ($product) {
                if ($product->photo) {
                    // Determine image size folders based on orientation
                    if ($product->image_width > $product->image_height) {
                        $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                    } elseif ($product->image_height > $product->image_width) {
                        $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                    } else {
                        $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                    }
                    $directory = dirname($product->photo);
                    $filename = basename($product->photo);
                    $imagePaths = [];
                    foreach ($sizes as $key => $folder) {
                        // Build URL
                        $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                    }

                    $product->images = $imagePaths;
                    $product->photo = $imagePaths['s'];  // already full URL here
                    return $product;
                }
            });
        });
        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')->with('products', $products->products)->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')->with('products', $products->products)->with('recent_products', $recent_products);
        }
    }
    public function productCat(Request $request, RedisCacheService $cache)
    {
        $ttl = 60 * 60 * 24;
        $products = $cache->remember('product_listing_category_'.$request->slug, $ttl, function () use($request) {
            return Category::getProductByCat($request->slug);
        });
        // return $request->slug;
        $recent_products = $cache->remember('product_listing_recent', $ttl, function () {
            return Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get()
            ->map(function ($product) {
                if ($product->photo) {
                    // Determine image size folders based on orientation
                    if ($product->image_width > $product->image_height) {
                        $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                    } elseif ($product->image_height > $product->image_width) {
                        $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                    } else {
                        $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                    }
                    $directory = dirname($product->photo);
                    $filename = basename($product->photo);
                    $imagePaths = [];
                    foreach ($sizes as $key => $folder) {
                        // Build URL
                        $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                    }

                    $product->images = $imagePaths;
                    $product->photo = $imagePaths['s'];  // already full URL here
                    return $product;
                }
            });
        });

        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')->with('products', $products->products)->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')->with('products', $products->products)->with('recent_products', $recent_products);
        }
    }
    public function productSubCat(Request $request, RedisCacheService $cache)
    {
        $ttl = 60 * 60 * 24;
        $products = $cache->remember('product_listing_subcategory_'.$request->slug, $ttl, function () use($request) {
            return Category::getProductBySubCat($request->sub_slug);
        });
        // return $products;
        $recent_products = $cache->remember('product_listing_recent', $ttl, function () {
            return Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get()
            ->map(function ($product) {
                if ($product->photo) {
                    // Determine image size folders based on orientation
                    if ($product->image_width > $product->image_height) {
                        $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                    } elseif ($product->image_height > $product->image_width) {
                        $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                    } else {
                        $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                    }
                    $directory = dirname($product->photo);
                    $filename = basename($product->photo);
                    $imagePaths = [];
                    foreach ($sizes as $key => $folder) {
                        // Build URL
                        $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                    }

                    $product->images = $imagePaths;
                    $product->photo = $imagePaths['s'];  // already full URL here
                    return $product;
                }
            });
        });

        if (request()->is('e-shop.loc/product-grids')) {
            return view('frontend.pages.product-grids')->with('products', $products->sub_products)->with('recent_products', $recent_products);
        } else {
            return view('frontend.pages.product-lists')->with('products', $products->sub_products)->with('recent_products', $recent_products);
        }
    }

    public function blog()
    {
        $post = Post::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = PostCategory::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            return $cat_ids;
            $post->whereIn('post_cat_id', $cat_ids);
            // return $post;
        }
        if (!empty($_GET['tag'])) {
            $slug = explode(',', $_GET['tag']);
            // dd($slug);
            $tag_ids = PostTag::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // return $tag_ids;
            $post->where('post_tag_id', $tag_ids);
            // return $post;
        }

        if (!empty($_GET['show'])) {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate($_GET['show']);
        } else {
            $post = $post->where('status', 'active')->orderBy('id', 'DESC')->paginate(9);
        }
        $post->map(function ($post) {
            if ($post->photo) {
                // Determine image size folders based on orientation
                if ($post->image_width > $post->image_height) {
                    $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                } elseif ($post->image_height > $post->image_width) {
                    $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                } else {
                    $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                }
                $directory = dirname($post->photo);
                $filename = basename($post->photo);
                $imagePaths = [];
                foreach ($sizes as $key => $folder) {
                    // Build URL
                    $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                }

                $post->images = $imagePaths;
                $post->photo = $imagePaths['s'];  // already full URL here
                return $post;
            }
        });
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get()
        ->map(function ($post) {
            if ($post->photo) {
                // Determine image size folders based on orientation
                if ($post->image_width > $post->image_height) {
                    $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                } elseif ($post->image_height > $post->image_width) {
                    $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                } else {
                    $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                }
                $directory = dirname($post->photo);
                $filename = basename($post->photo);
                $imagePaths = [];
                foreach ($sizes as $key => $folder) {
                    // Build URL
                    $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                }

                $post->images = $imagePaths;
                $post->photo = $imagePaths['s'];  // already full URL here
                return $post;
            }
        });

        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogDetail($slug, RedisCacheService $cache)
    {
        $ttl = 60 * 60 * 24;
        $post = $cache->remember('post_detail_'.$request->slug, $ttl, function () {
            return Post::getPostBySlug($slug)
            ->map(function ($post) {
                if ($post->photo) {
                    // Determine image size folders based on orientation
                    if ($post->image_width > $post->image_height) {
                        $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                    } elseif ($post->image_height > $post->image_width) {
                        $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                    } else {
                        $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                    }
                    $directory = dirname($post->photo);
                    $filename = basename($post->photo);
                    $imagePaths = [];
                    foreach ($sizes as $key => $folder) {
                        // Build URL
                        $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                    }

                    $post->images = $imagePaths;
                    $post->photo = $imagePaths['s'];  // already full URL here
                    return $post;
                }
            });
        });
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get()
        ->map(function ($post) {
            if ($post->photo) {
                // Determine image size folders based on orientation
                if ($post->image_width > $post->image_height) {
                    $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                } elseif ($post->image_height > $post->image_width) {
                    $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                } else {
                    $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                }
                $directory = dirname($post->photo);
                $filename = basename($post->photo);
                $imagePaths = [];
                foreach ($sizes as $key => $folder) {
                    // Build URL
                    $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                }

                $post->images = $imagePaths;
                $post->photo = $imagePaths['s'];  // already full URL here
                return $post;
            }
        });
        // return $post;
        return view('frontend.pages.blog-detail')->with('post', $post)->with('recent_posts', $rcnt_post);
    }

    public function blogSearch(Request $request)
    {
        // return $request->all();
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
        $posts = Post::orwhere('title', 'like', '%' . $request->search . '%')
            ->orwhere('quote', 'like', '%' . $request->search . '%')
            ->orwhere('summary', 'like', '%' . $request->search . '%')
            ->orwhere('description', 'like', '%' . $request->search . '%')
            ->orwhere('slug', 'like', '%' . $request->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(8);
        $mappedItems = $posts->getCollection()->map(function ($post) {
            if ($post->photo) {
                // Determine image size folders based on orientation
                if ($post->image_width > $post->image_height) {
                    $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                } elseif ($post->image_height > $post->image_width) {
                    $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                } else {
                    $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                }
                $directory = dirname($post->photo);
                $filename = basename($post->photo);
                $imagePaths = [];
                foreach ($sizes as $key => $folder) {
                    // Build URL
                    $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                }

                $post->images = $imagePaths;
                $post->photo = $imagePaths['s'];  // already full URL here
                return $post;
            }
        });
        $posts->setCollection($mappedItems);
        return view('frontend.pages.blog')->with('posts', $posts)->with('recent_posts', $rcnt_post);
    }

    public function blogFilter(Request $request)
    {
        $data = $request->all();
        // return $data;
        $catURL = "";
        if (!empty($data['category'])) {
            foreach ($data['category'] as $category) {
                if (empty($catURL)) {
                    $catURL .= '&category=' . $category;
                } else {
                    $catURL .= ',' . $category;
                }
            }
        }

        $tagURL = "";
        if (!empty($data['tag'])) {
            foreach ($data['tag'] as $tag) {
                if (empty($tagURL)) {
                    $tagURL .= '&tag=' . $tag;
                } else {
                    $tagURL .= ',' . $tag;
                }
            }
        }
        // return $tagURL;
        // return $catURL;
        return redirect()->route('blog', $catURL . $tagURL);
    }

    public function blogByCategory(Request $request, RedisCacheService $cache)
    {
        $ttl = 60 * 60 * 24;
        $post = $cache->remember('post_listing_category_'.$request->slug, $ttl, function () {
            return PostCategory::getBlogByCategory($request->slug);
        });
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get()
        ->map(function ($post) {
            if ($post->photo) {
                // Determine image size folders based on orientation
                if ($post->image_width > $post->image_height) {
                    $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                } elseif ($post->image_height > $post->image_width) {
                    $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                } else {
                    $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                }
                $directory = dirname($post->photo);
                $filename = basename($post->photo);
                $imagePaths = [];
                foreach ($sizes as $key => $folder) {
                    // Build URL
                    $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                }

                $post->images = $imagePaths;
                $post->photo = $imagePaths['s'];  // already full URL here
                return $post;
            }
        });
        return view('frontend.pages.blog')->with('posts', $post->post)->with('recent_posts', $rcnt_post);
    }

    public function blogByTag(Request $request, RedisCacheService $cache)
    {
        $ttl = 60 * 60 * 24;
        // dd($request->slug);
        $post = $cache->remember('post_listing_tag_'.$request->slug, $ttl, function () {
            return Post::getBlogByTag($request->slug);
        });
        // return $post;
        $rcnt_post = Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get()
        ->map(function ($post) {
            if ($post->photo) {
                // Determine image size folders based on orientation
                if ($post->image_width > $post->image_height) {
                    $sizes = ['s' => '300X200', 'm' => '900X600', 'l' => '1200X800'];
                } elseif ($post->image_height > $post->image_width) {
                    $sizes = ['s' => '200X300', 'm' => '600X900', 'l' => '800X1200'];
                } else {
                    $sizes = ['s' => '300X300', 'm' => '600X600', 'l' => '800X800'];
                }
                $directory = dirname($post->photo);
                $filename = basename($post->photo);
                $imagePaths = [];
                foreach ($sizes as $key => $folder) {
                    // Build URL
                    $imagePaths[$key] = asset($directory . '/' . $folder . '/' . $filename);
                }

                $post->images = $imagePaths;
                $post->photo = $imagePaths['s'];  // already full URL here
                return $post;
            }
        });
        return view('frontend.pages.blog')->with('posts', $post)->with('recent_posts', $rcnt_post);
    }

    // Login
    public function login()
    {
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request)
    {
        $data = $request->all();

        // Attempt to authenticate
        if (Auth::attempt([
            'email' => $data['email'],
            'password' => $data['password'],
            'status' => 'active'
        ])) {
            $user = Auth::user();

            // Check if email is verified
            if (!$user->email_verified) {
                Auth::logout();
                Session::put('email', $user->email);
                request()->session()->flash('error', 'Please verify your email address before logging in.');
                return redirect('/verify/code');
            }

            // Store session and redirect
            Session::put('user', $data['email']);
            request()->session()->flash('success', 'Successfully logged in');
            return redirect()->route('home');
        } else {
            request()->session()->flash('error', 'Invalid email or password. Please try again!');
            return redirect()->back();
        }
    }


    public function logout()
    {
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success', 'Logout successfully');
        return back();
    }

    public function register()
    {
        return view('frontend.pages.register');
    }
    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $verification_code = rand(100000, 999999);



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_code' => $verification_code,
        ]);





        if ($user) {
            // Logout to prevent auto-login if using Auth::guard('web')->login($user) somewhere
            Auth::logout();

            // Send verification code email
            Mail::to($user->email)->send(new VerificationCodeMail($user));

            // Store email in session for verification use
            Session::put('email', $user->email);

            return redirect()->route('verification.form')->with('success', 'Registered successfully! Please enter the verification code sent to your email.');
        } else {
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => 'active'
        ]);
    }
    // Reset password
    public function showResetForm()
    {
        return view('auth.passwords.old-reset');
    }

    public function subscribe(Request $request)
    {
        if (! Newsletter::isSubscribed($request->email)) {
            Newsletter::subscribePending($request->email);
            if (Newsletter::lastActionSucceeded()) {
                request()->session()->flash('success', 'Subscribed! Please check your email');
                return redirect()->route('home');
            } else {
                Newsletter::getLastError();
                return back()->with('error', 'Something went wrong! please try again');
            }
        } else {
            request()->session()->flash('error', 'Already Subscribed');
            return back();
        }
    }
}
