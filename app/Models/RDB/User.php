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
 * @property string stores
 * @property string services
 * @property string password
 * @property string api_token
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
        'graph_id', 'name', 'email', 'stores', 'services', 'password', 'api_token', 'ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'stores', 'services', 'password', 'api_token', 'ip'
    ];

    /**
     * Check if user has store
     *
     * @param int $storeId
     * @return bool
     */
    public function hasStore(int $storeId): bool
    {
        return array_has(json_decode($this->stores), $storeId);
    }

    /**
     * Add store id to user
     *
     * @param int $storeId
     */
    public function addStore(int $storeId)
    {
        if (!$this->hasStore($storeId)) {
            $stores = json_decode($this->stores);
            $stores[] = $storeId;
            $this->stores = json_encode($stores);
            $this->save();
        }
    }

    /**
     * Check if user has service
     *
     * @param int $serviceId
     * @return bool
     */
    public function hasService(int $serviceId): bool
    {
        return array_has(json_decode($this->services), $serviceId);
    }

    /**
     * Add service id to user
     *
     * @param int $serviceId
     */
    public function addService(int $serviceId)
    {
        if (!$this->hasService($serviceId)) {
            $services = json_decode($this->services);
            $services[] = $serviceId;
            $this->services = json_encode($services);
            $this->save();
        }
    }
}
