<?php

namespace Menvel\SettingMenu\Repositories\Eloquent;

use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Menvel\Repository\AbstractRepository;
use Menvel\SettingMenu\Events\Placing;
use Menvel\SettingMenu\Events\Placed;
use Menvel\SettingMenu\Contracts\Repository\ISettingMenuRepository;
use Menvel\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository;

class SettingMenuRepository extends AbstractRepository implements ISettingMenuRepository
{
    /**
     * @var \Menvel\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository
     */
    protected $menudetail;

    /**
     * @param \Menvel\SettingMenu\Contracts\Repository\Admin\ISettingMenuDetailRepository $menudetail
     * @return void
     */
    public function __construct(ISettingMenuDetailRepository $menudetail)
    {
        $this->menudetail = $menudetail;
    }

    /**
     * @return void
     */
    public function __destruct()
    {}

    /**
     * @param array $querystring
     * @return mixed
     */
    public function all($querystring = [])
    {
        $user = $this->user; $content = null;

        $content = $user->load([ 'menusHeadernavbar', 'menusFooternavbar', 'menusSidenavbar', ])->loadCount([ 'menusHeadernavbar', 'menusFooternavbar', 'menusSidenavbar', ]);

        return $content;
    }

    /**
     * @param string $type
     * @param int|string $oldparent
     * @param int|string $oldchild
     * @param int|string $newparent
     * @param int|string $newchild
     * @return mixed
     */
    public function modify($type, $oldparent, $oldchild, $newparent, $newchild)
    {
        $type = $this->menudetail->type($type);
        $content = null;

        DB::beginTransaction();

        try {

            $content = [ 'user_id' => $this->user->id, ];

            call_user_func($type . '::' . 'withoutGlobalScopes')->where(array_merge($content, [ 'key' => $oldchild, 'value' => $oldparent, ]))->delete();
            call_user_func($type . '::' . 'forceCreate', array_merge($content, [ 'key' => $newchild, 'value' => $newparent, ]));

            DB::commit();

            event(new Placed($content));

        } catch (Exception $exception) {

            DB::rollback();
        }

        return $content;
    }
}