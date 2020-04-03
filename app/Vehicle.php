<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    //
    public function item(){
		return $this->belongsTo(Items::class);
    }


    // MUTATOR

    public function getIsSellingAttribute($value) {
        switch($value) {
            case 1 : return 'Selling'; break;
            case 2 : return 'Renting'; break;
        }
        return null ;
    }

    public function getCanOffroadAttribute($value) {
        switch($value) {
            case 1 : return 'Yes'; break;
            case 2 : return 'No'; break;
        }
        return null ;
    }

    public function getFuelAttribute($value) {
        switch($value) {
            case 1 : return 'Gasoline'; break;
            case 2 : return 'Steam'; break;
            case 3 : return 'Diesel'; break;
            case 4 : return 'Liquified Petroleum'; break;
            case 5 : return 'Compressed Natural Gas'; break;
            case 6 : return 'Ethanol'; break;
            case 7 : return 'Bio-diesel'; break;
        }
    }

    public function getTypeAttribute($value) {
        switch($value) {
            case 1 : return 'CARS'; break;
            case 2 : return 'BICYCLES & TRICYCLES'; break;
            case 3 : return 'SUBWAY TRANSPORTATION'; break;
            case 4 : return 'MOTORCYCLES'; break;
            case 5 : return 'SEA TRANSPORTATION'; break;
            case 6 : return 'AIR TRANSPORTATION'; break;
        }
    }

    public function getTypesTypeAttribute($value) {
        $type = $this->type;
        if($type === 'CARS'){
            switch($value) {
                case 1 : return 'Microcar'; break;
                case 2 : return 'Economy hatchback'; break;
                case 3 : return 'Sedan'; break;
                case 4 : return 'Coupe'; break;
                case 5 : return 'Sports cars'; break;
                case 6 : return 'Convertibles'; break;
                case 7 : return 'SUVs'; break;
                case 8 : return 'Luxury cars'; break;
                case 9 : return 'Pickup'; break;
                case 10 : return 'Crossover'; break;
                case 11 : return 'Estate cars'; break;
                case 12 : return 'Limousine'; break;
                case 13 : return 'Modified cars'; break;
                case 14 : return 'Hybrid cars'; break;
            }
        }  

        if($type === 'BICYCLES & TRICYCLES'){
            return null ;
        }

        if($type === 'SUBWAY TRANSPORTATION'){
            switch($value) {
                case 1 : return 'High speed trains'; break;
                case 2 : return 'Inter-city trains'; break;
                case 3 : return 'Commuter/regional trains'; break;
                case 4 : return 'Rapid transit'; break;
                case 5 : return 'Light rail'; break;
                case 6 : return 'Modern streetcar'; break;
            }
        } 

        if($type === 'MOTORCYCLES'){
            switch($value) {
                case 1 : return 'Sportbikes'; break;
                case 2 : return 'Naked Motorcycles'; break;
                case 3 : return 'Touring Motorcycles'; break;
                case 4 : return 'Sport Touring Motorcycles'; break;
                case 5 : return 'Adventure Motorcycles'; break;
                case 6 : return 'Dirt Bikes'; break;
                case 7 : return 'Dual Sport Motorcycles'; break;
                case 8 : return 'Supermoto'; break;
                case 9 : return 'Cruiser Motorcycles'; break;
                case 10 : return 'Power Cruiser Motorcycles'; break;
                case 11 : return 'Standard Motorcycles'; break;
                case 12 : return 'Cafe Racer'; break;
                case 13 : return 'Scrambler Motorcycles'; break;
                case 14 : return 'Scooters'; break;
            }
        } 

        if($type === 'SEA TRANSPORTATION'){
            switch($value) {
                case 1 : return 'Cruise ships'; break;
                case 2 : return 'Racing boats'; break;
                case 3 : return 'Off-road riding boats'; break;
                case 4 : return 'Windsurfer boats'; break;
                case 5 : return 'Riverboats'; break;
                case 6 : return 'Jet skis'; break;
                case 7 : return 'Battleships'; break;
                case 8 : return 'Raft boats'; break;
                case 9 : return 'Canoes'; break;
                case 10 : return 'Ferries'; break;
                case 11 : return 'Yachts'; break;
                case 12 : return 'Submarines'; break;
                case 13 : return 'Tugboats'; break;
            }
        } 

        if($type === 'AIR TRANSPORTATION'){
            switch($value) {
                case 1 : return 'Blimps'; break;
                case 2 : return 'Zeppelins'; break;
                case 3 : return 'Airplanes'; break;
                case 4 : return 'Helicopters'; break;
                case 5 : return 'Personal Air Transportation'; break;
                case 6 : return 'Rockets'; break;
            }
        } 

        return 'undecided'  ;
    }
}
