<?php

namespace Menvel\SettingMenu\Models;

use Menvel\SettingMenu\Scopes\MenuStrictScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

abstract class AbstractMenu extends Model
{
    use \Awobaz\Compoships\Compoships;

    const CREATED_AT = null;
    const UPDATED_AT = 'updated_at';

    /**
     * @var string
     */
    protected $table = 'settings';

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
    protected $primaryKey = 'key';

    /**
     * @var array
     */
    protected $fillable = [ 'key', 'value', ];

    /**
     * @var array
     */
    protected $hidden = [];

    /**
     * @var array
     */
    protected $appends = [ 'menus_count', ];

    /**
     * @var array
     */
    protected $with = [ 'menus', 'detail', ];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new MenuStrictScope());
    }

    /**
     * @return int
     */
    public function getMenusCountAttribute()
    {
        return $this->menus()->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function menus()
    {
        $provider = Auth::guard()->getProvider()->createModel()->getTable();
        $key = Str::of($provider)->singular() . '_' . 'id';

        return $this->hasMany(static::class, [ 'value', $key, ], [ 'key', $key, ])->withoutGlobalScope(MenuStrictScope::class)->with('menus');
    }
}