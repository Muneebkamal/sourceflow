<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = [
        'publish_date',
        'image',
        'type',
        'tags',
        'product_title',
        'asin',
        'supplier',
        'brand',
        'cost',
        'sale_price',
        'net_profit',
        'roi',
        'bsr_90_d_avg',
        'category',
        'promo',
        'coupon_code',
        'lead_note',
        'new_offers',
        'rating',
        'bsr_current',
        'lead_source',
        'variations',
        'created_by',
        'updated_by',
        'created_from',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }
    public function getLeadTagsAttribute(){
        $tagsss = explode(',', $this->tags); // Get tag IDs as an array
        $tags = Tag::whereIn( 'id', $tagsss)->get();
        return $tags;
    }
    public function getBundlesAttribute(){
        $bundles = Item::where('lead_id',$this->id)->get();
        return $bundles;
    }
    public function createdBy()
    {
        return $this->hasOne(User::class,'id','created_by');
    }

}
