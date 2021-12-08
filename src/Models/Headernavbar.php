<?php

namespace Menvel\SettingMenu\Models;

use Menvel\SettingMenu\Models\Admin\Detailmenu;

class Headernavbar extends AbstractMenu
{
    /**
     * @var string
     */
    public $space = 'headernavbar';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function detail()
    {
        return $this->morphOne(Detailmenu::class, 'menuable');
    }
}