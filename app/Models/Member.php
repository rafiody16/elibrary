<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'members';

    protected $primaryKey = 'id_member';

    protected $fillable = [
        'id_user',
        'id_card',
        'name_member',
        'photo_member',
        'address',
        'place_of_birth',
        'date_of_birth',
        'phone_number',
        'job',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}