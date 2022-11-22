<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'responsibleUserId',
        'createdBy',
        'updatedBy',
        'createdAt',
        'updatedAt',
        'closestTaskAt'
    ];

    public function leads(){
        return $this->hasMany(Lead::class, 'companyId');
    }
}
