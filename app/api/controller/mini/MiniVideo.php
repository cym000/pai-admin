<?php


namespace app\api\controller\mini;

use app\api\model\mini\MiniVideoRecord;
use app\Request;
use learn\services\UtilService as Util;
use app\api\model\mini\MiniVideo as vModel;
/**
 * Class MiniVideo
 * @package app\api\controller\mini
 */
class MiniVideo
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function info(Request $request)
    {
        $where = Util::postMore([
            ['vid','']
        ]);
        if ($where['vid'] == "") return app("json")->fail("视频ID为空！");
        $data = vModel::getVideoInfo($where['vid']);
        return $data ? app("json")->success($data) : app("json")->fail("获取失败");
    }

    /**
     * 获取视频链接
     * @param Request $request
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function url(Request $request)
    {
        $where = Util::postMore([
            ['vid',''],
            ['xid','']
        ]);
        if ($where['vid'] == "") return app("json")->fail("视频ID为空！");
        $url = vModel::getUrlByVid($where['vid'],$where['xid']);
        return $url ? app("json")->success(compact("url")) : app("json")->fail("获取失败");
    }
}