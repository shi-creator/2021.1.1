<?php

namespace app\exam\model;

use think\Model;
use traits\model\SoftDelete;

class Exam extends Model
{
    protected $table="type";
    protected $resultSetType = 'collection';
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}
