<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class VehicleEquipment extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;

    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(Vehicle::class,'equipment_vehicles','equipment_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(VehicleEquipmentGroup::class);
    }
}
