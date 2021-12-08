<?php

namespace Menvel\SettingMenu\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Detailmenu extends Model
{
    /**
     * @var string
     */
    protected $table = 'menus';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string
     */
    protected $primaryKey = 'menuable_id';

    /**
     * @var array
     */
    protected $hidden = [ 'menuable_type', 'menuable_id', ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function menuable()
    {
        return $this->morphTo();
    }
}