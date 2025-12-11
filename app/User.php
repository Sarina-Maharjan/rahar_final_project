<?php

namespace App;

use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','photo','status','provider','provider_id',"verification_code"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
}
