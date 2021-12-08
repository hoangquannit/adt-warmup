<?php

namespace App\Models;

use App\Models\BaseModel as Model;


class Category extends Model
{
    protected $table = 'categories';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'cat_id';

    /**
     * The name field respectively in table account
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'created_by',
        'updated_by',
        'enable',
        'created_at',
        'updated_at',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, "cat_id",'cat_id');
    }

}
