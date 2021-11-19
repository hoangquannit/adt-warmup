<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;


class AdminAccount extends Model implements Authenticatable
{
    use AuthenticableTrait;

    protected $table = 'admin_accounts';

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
        'full_name',
        'phone_number',
        'avatar',
        'email',
        'password',
        'remember_token',
        'created_by',
        'updated_by',
        'enable',
        'created_at',
        'updated_at',
    ];

}
