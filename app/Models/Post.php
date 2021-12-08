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
        'cat_id',
        'title',
        'content',
        'img',
        'created_by',
        'updated_by',
        'enable',
        'created_at',
        'updated_at',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, "cat_id",'cat_id');
    }
}
