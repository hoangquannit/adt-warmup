<?php

namespace App\Models;

use App\Models\BaseModel as Model;


class Post extends Model
{
    protected $table = 'posts';

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
        'title',
        'content',
        'created_by',
        'updated_by',
        'enable',
        'created_at',
        'updated_at',
    ];

}
