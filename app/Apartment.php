<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    //
    public function item(){
		return $this->belongsTo(Items::class);
    }
    
    public function getIsSellingAttribute($value) {
        return $value == 1 ? 'Selling' :'Renting' ; 
    }

    public function getTypeAttribute($value) {
        return $value == 1 ? 'Residential' :'Commercial' ; 
    }

    public function getIsFarFromCityAttribute($value) {
        return $value == 1 ? 'Yes' :'No' ; 
    }
    public function getTypesTypeAttribute($value) {
        $type = $this->type;
        if($type === 'Residential'){
            switch($value) {
                case 1 : return 'Single family homes'; break;
                case 2 : return 'Condominiums'; break;
                case 3 : return 'Townhomes'; break;
                case 4 : return 'Cooperative (co-op)'; break;
                case 5 : return 'Duplex'; break;
                case 6 : return 'Triplex'; break;
                case 7 : return 'Fourplex'; break;
                case 8 : return 'Individual mobile homes'; break;
            }
        }  
        if($type === 'Commercial'){
            switch($value) {
                case 1 : return 'Office space'; break;
                case 2 : return 'Hotel and lodging'; break;
                case 3 : return 'Self-storage or mini-storage'; break;
                case 4 : return 'Multifamily'; break;
                case 5 : return 'Retail'; break;
                case 6 : return 'Industrial'; break;
                case 7 : return 'Health care'; break;
                case 8 : return 'Special purpose'; break;
            }
        }
        return "undecided" ;
    }
}
