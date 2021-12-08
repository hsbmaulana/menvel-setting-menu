<?php

namespace Menvel\SettingMenu;

use Menvel\Repository\RepositoryServiceProvider as ServiceProvider;

class SettingMenuServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $map =
    [
        \Menvel\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository::class => \Menvel\SettingMenu\Repositories\Eloquent\Admin\SettingMenuDetailRepository::class,
        \Menvel\SettingMenu\Contracts\Repository\ISettingMenuRepository::class => \Menvel\SettingMenu\Repositories\Eloquent\SettingMenuRepository::class,
    ];

    /**
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}