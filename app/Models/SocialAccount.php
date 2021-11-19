<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class SocialAccount extends Model
{
    protected $table = 'social_accounts';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The name field respectively in table account
     *
     * @var array
     */
    protected $fillable = [
        'provider_admin_id',
        'provider',
        'admin_id',
        'created_by',
        'updated_by',
        'enable',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function adminAccount()
    {
        return $this->hasOne('App\Models\AdminAccount', 'id', 'admin_id');
    }


}
