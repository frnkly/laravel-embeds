<?php

namespace Frnkly\Spec\MockModels;

use Frnkly\Traits\Embedable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Embedable;

    /**
     * @var array
     */
    public $embedable = [
        'author'        => [],
        'uri'           => [],
        'commentCount'  => ['comments'],
    ];
}
