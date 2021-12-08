<?php

namespace Menvel\SettingMenu\Repositories\Eloquent\Admin;

use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Menvel\SettingMenu\Models\Headernavbar;
use Menvel\SettingMenu\Models\Footernavbar;
use Menvel\SettingMenu\Models\Sidenavbar;
use Menvel\SettingMenu\Models\Admin\Detailmenu;
use Menvel\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository;

class SettingMenuDetailRepository implements ISettingMenuDetailRepository
{
    /**
     * @param string $menu
     * @return string
     * @throws \InvalidArgumentException
     */
    public function type($menu)
    {
        $menus =
        [
            (app(Headernavbar::class)->space) => Headernavbar::class,
            (app(Footernavbar::class)->space) => Footernavbar::class,
            (app(Sidenavbar::class)->space) => Sidenavbar::class,
        ];

        $type = @$menus[$menu] ?: null;

        if ($type) {

            return $type;

        } else {

            throw new \InvalidArgumentException("Menu type is not valid.");
        }
    }

    /**
     * @param int|string $type
     * @param array $querystring
     * @return mixed
     */
    public function all($type, $querystring = [])
    {
        $type = $this->type($type);
        $querystring =
        [
            'menu_limit' => $querystring['menu_limit'] ?? 10,
            'menu_current_page' => $querystring['menu_current_page'] ?? 1,
            'menu_sort' => $querystring['menu_sort'] ?? null,
            'menu_search' => $querystring['menu_search'] ?? null,
        ];
        extract($querystring);

        $content = Detailmenu::query()->
        where('menuable_type', $type)->
        when($menu_sort, $menu_sort)->
        when($menu_search, $menu_search)->
        paginate($menu_limit, '*', 'menu_current_page', $menu_current_page)->appends($querystring);

        return $content;
    }

    /**
     * @param int|string $type
     * @param int|string $identifier
     * @param array $querystring
     * @return mixed
     */
    public function get($type, $identifier, $querystring = [])
    {
        $type = $this->type($type);
        $identifier = $identifier;
        $content = Detailmenu::where([ 'menuable_type' => $type, 'menuable_id' => $identifier, ])->firstOrFail();

        return $content;
    }

    /**
     * @param int|string $type
     * @param int|string $identifier
     * @param array $data
     * @return mixed
     */
    public function modify($type, $identifier, $data)
    {
        $type = $this->type($type);
        $identifier = $identifier;
        $content = Detailmenu::where([ 'menuable_type' => $type, 'menuable_id' => $identifier, ])->firstOrFail();

        DB::beginTransaction();

        try {

            $content = $content->forceFill($data);

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $type
     * @param int|string $identifier
     * @param array $data
     * @return mixed
     */
    public function add($type, $identifier, $data)
    {
        $type = $this->type($type);
        $identifier = $identifier;
        $content = null;

        DB::beginTransaction();

        try {

            $content = Detailmenu::firstOrCreate(array_merge($data, [ 'menuable_type' => $type, 'menuable_id' => $identifier, ]));

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }

    /**
     * @param int|string $type
     * @param int|string $identifier
     * @return mixed
     */
    public function remove($type, $identifier)
    {
        $type = $this->type($type);
        $identifier = $identifier;
        $content = Detailmenu::where([ 'menuable_type' => $type, 'menuable_id' => $identifier, ])->firstOrFail();

        DB::beginTransaction();

        try {

            $content->delete();

            DB::commit();

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }
}