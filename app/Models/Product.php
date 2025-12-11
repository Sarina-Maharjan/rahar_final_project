<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->photo) {
                $photoPath = ltrim(str_replace('/storage/', '', $model->photo), '/');

                if (Storage::disk('public')->exists($photoPath)) {
                    try {
                        $fullPath = Storage::disk('public')->path($photoPath);
                        $image = Image::make($fullPath);

                        $model->image_width = $image->width();
                        $model->image_height = $image->height();
                    } catch (\Exception $e) {
                        // You can log the error if needed
                        // Log::warning("Image read failed: " . $e->getMessage());
                    }
                }
            }
        });
    }
    protected $fillable=['title','slug','summary','description','cat_id','child_cat_id','price','brand_id','discount','status','photo','size','stock','is_featured','condition'];

    public function cat_info(){
        return $this->hasOne('App\Models\Category','id','cat_id');
    }
    public function sub_cat_info(){
        return $this->hasOne('App\Models\Category','id','child_cat_id');
    }
    public static function getAllProduct(){
        return Product::with(['cat_info','sub_cat_info'])->orderBy('id','desc')->paginate(10);
    }
    public function rel_prods(){
        return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('status','active')->orderBy('id','DESC')->limit(8);
    }
    public function getReview(){
        return $this->hasMany('App\Models\ProductReview','product_id','id')->with('user_info')->where('status','active')->orderBy('id','DESC');
    }
    public static function getProductBySlug($slug){
        return Product::with(['cat_info','rel_prods','getReview'])->where('slug',$slug)->first();
    }
    public static function countActiveProduct(){
        $data=Product::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }

    public function carts(){
        return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }

    public function wishlists(){
        return $this->hasMany(Wishlist::class)->whereNotNull('cart_id');
    }

    public function brand(){
        return $this->hasOne(Brand::class,'id','brand_id');
    }

}
