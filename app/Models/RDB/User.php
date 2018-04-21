<?php

namespace App\Models\RDB;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App\Models\MySQL
 * @property int id
 * @property int graph_id
 * @property string name
 * @property string email
 * @property string password
 * @property string access_token
 * @property string ip
 * @property string created_at
 * @property string updated_at
 * @property string deleted_at
 */
class User extends Authenticatable
{
    use Notifiable, softDeletes;

    public const ACCESS_TOKEN_LENGTH = 190;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'graph_id', 'name', 'email', 'password', 'access_token', 'ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'access_token', 'ip'
    ];
}
