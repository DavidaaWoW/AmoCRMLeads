<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'price',
        'status',
        'responsibleUserId',
        'createdBy',
        'updatedBy',
        'pipelineId',
        'companyId',
        'createdAt',
        'updatedAt'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function company(){
        return $this->belongsTo(Company::class, 'companyId');
    }
}
