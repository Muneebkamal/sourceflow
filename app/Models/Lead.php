<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $fillable = [
        'source_id',
        'url',
        'date',
        'image',
        'type',
        'tags',
        'name',
        'asin',
        'supplier',
        'brand',
        'cost',
        'sell_price',
        'net_profit',
        'roi',
        'bsr',
        'category',
        'promo',
        'coupon',
        'notes',
        'new_offers',
        'tags',
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
