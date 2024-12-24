<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;

class Order extends Model
{
    public function user() {
        return $this->hasOne('App\Models\User','id','user_id');
    }

    public function product() {
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    // Order.php

    protected $fillable = ['user_id', 'name', 'address', 'phone', 'total_value', 'status', 'days'];


}
