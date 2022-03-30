<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\ProductReviewResource;
class Items extends Model
{
    //
    protected $fillable = ['title', 'price', 'stock', 'total_purchase' , 'is_sold', 'client_id', 'category_id', 'status_id',
        'subcategory_id', 'description', 'location'];
    // protected $guarded = [];
    // scopes
    public function scopeTitleSearch($query , $searchTerm)
    {
        return $query->where('title', 'like', "%" . $searchTerm . "%");
    }

    // relations
    public function client(){
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function clients_fav(){
        return $this->belongsToMany(Client::class , 'favorites' , 'item_id' , 'user_id' );
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function subcategory(){
        return $this->belongsTo(Subcategory::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }
    public function apartment(){
        return $this->belongsTo(Apartment::class);
    }
    public function vehicle(){
        return $this->belongsTo(Vehicle::class);
    }

    public function photos(){
        return $this->hasMany(Photos::class);
    }

    public function sessions(){
        return $this->hasMany(Session::class);
    }
    public function solds(){
        return $this->hasMany(Sold::class, 'item_id', 'seller_id');
    }
    public function solds_group(){
        return $this->hasMany(Sold::class, 'item_id', 'seller_id');
    }
    public function reviews(){
        return $this->hasMany(ProductReview::class);
    }

    public function reviews1(){
        return $this->reviews()->sum('rating');
    }
     public function itemReport(){
         return $this->belongsToMany(Report::class);
     }

    // protected $appends = [
    //     'average-rating'
    // ];

   

    //mutator
    public function getCreatedatAttribute($value) {
        return date('d F Y H:i', strtotime($value)) ; 
    }

    // public function getUpdatedatAttribute($value) {
    //     return date('d F Y H:i', strtotime($value)) ; 
    // }
    public function getTitleAttribute($value) {
        return ucwords($value) ; 
    }
    public function getShownumberAttribute($value) {
        return $value == 1 ? 'true' :'false' ; 
    }

    


}
