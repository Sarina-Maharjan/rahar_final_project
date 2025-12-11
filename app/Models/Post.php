<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Product;
use App\Models\Category;
use App\Models\PostComment;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model
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
    protected $fillable=['title','tags','summary','slug','description','photo','quote','post_cat_id','post_tag_id','added_by','status'];


    public function cat_info(){
        return $this->hasOne('App\Models\PostCategory','id','post_cat_id');
    }
    public function tag_info(){
        return $this->hasOne('App\Models\PostTag','id','post_tag_id');
    }

    public function author_info(){
        return $this->hasOne('App\User','id','added_by');
    }
    public static function getAllPost(){
        return Post::with(['cat_info','author_info'])->orderBy('id','DESC')->paginate(10);
    }
    // public function get_comments(){
    //     return $this->hasMany('App\Models\PostComment','post_id','id');
    // }
    public static function getPostBySlug($slug){
        return Post::with(['tag_info','author_info'])->where('slug',$slug)->where('status','active')->first();
    }

    public function comments(){
        return $this->hasMany(PostComment::class)->whereNull('parent_id')->where('status','active')->with('user_info')->orderBy('id','DESC');
    }
    public function allComments(){
        return $this->hasMany(PostComment::class)->where('status','active');
    }


    // public static function getProductByCat($slug){
    //     // dd($slug);
    //     return Category::with('products')->where('slug',$slug)->first();
    //     // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    // }

    // public static function getBlogByCategory($id){
    //     return Post::where('post_cat_id',$id)->paginate(8);
    // }
    public static function getBlogByTag($slug){
        // dd($slug);
        return Post::where('tags',$slug)->paginate(8);
    }

    public static function countActivePost(){
        $data=Post::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
