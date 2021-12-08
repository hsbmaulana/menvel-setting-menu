<?php

namespace Menvel\SettingMenu\Models;

use Menvel\SettingMenu\Models\Admin\Detailmenu;

class Footernavbar extends AbstractMenu
{
    /**
     * @var string
     */
    public $space = 'footernavbar';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function detail()
    {
        return $this->morphOne(Detailmenu::class, 'menuable');
    }
}