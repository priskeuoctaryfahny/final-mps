<?php

namespace App\Models;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WebSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'web_logo',
        'web_favicon',
        'web_title',
        'web_description',
        'web_keywords',
        'web_author',
        'web_email',
        'web_phone',
        'web_address',
        'web_default_user_role',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class, 'web_default_user_role');
    }
}
