<?php

namespace Menvel\SettingMenu\Traits;

use Menvel\SettingMenu\Models\Headernavbar;
use Menvel\SettingMenu\Models\Footernavbar;
use Menvel\SettingMenu\Models\Sidenavbar;

trait MenuTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function menusHeadernavbar()
    {
        return $this->hasMany(Headernavbar::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function menusFooternavbar()
    {
        return $this->hasMany(Footernavbar::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function menusSidenavbar()
    {
        return $this->hasMany(Sidenavbar::class);
    }
}