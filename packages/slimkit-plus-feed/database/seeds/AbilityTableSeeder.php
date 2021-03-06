<?php

/*
 * +----------------------------------------------------------------------+
 * |                          ThinkSNS Plus                               |
 * +----------------------------------------------------------------------+
 * | Copyright (c) 2017 Chengdu ZhiYiChuangXiang Technology Co., Ltd.     |
 * +----------------------------------------------------------------------+
 * | This source file is subject to version 2.0 of the Apache license,    |
 * | that is bundled with this package in the file LICENSE, and is        |
 * | available through the world-wide-web at the following url:           |
 * | http://www.apache.org/licenses/LICENSE-2.0.html                      |
 * +----------------------------------------------------------------------+
 * | Author: Slim Kit Group <master@zhiyicx.com>                          |
 * | Homepage: www.thinksns.com                                           |
 * +----------------------------------------------------------------------+
 */

namespace SlimKit\Plus\Packages\Feed\Seeds;

use Zhiyi\Plus\Models\Ability;
use Illuminate\Database\Seeder;

class AbilityTableSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * @return void
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function run()
    {
        foreach ($this->perms() as $name => $items) {
            $this->validateOr($name, function (Ability $perm) use ($items) {
                foreach ($items as $key => $value) {
                    $perm->$key = $value;
                }
                $perm->save();
            });
        }
    }

    /**
     * 验证是否存在，不存在则执行回调.
     *
     * @param string $name
     * @param callable $call
     * @return void
     * @author Seven Du <shiweidu@outlook.com>
     */
    protected function validateOr(string $name, callable $call)
    {
        Ability::where('name', $name)->firstOr(function () use ($name, $call) {
            $perm = new Ability();
            $perm->name = $name;
            call_user_func_array($call, [$perm]);
        });
    }

    /**
     * Get all perms.
     *
     * @return array
     * @author Seven Du <shiweidu@outlook.com>
     */
    protected function perms(): array
    {
        return [
            'feed-post' => [
                'display_name' => '发送分享',
                'description' => '用户发送分享权限',
            ],
            'feed-comment' => [
                'display_name' => '评论分享',
                'description' => '用户评论分享权限',
            ],
            'feed-digg' => [
                'display_name' => '点赞分享',
                'description' => '用户点赞分享权限',
            ],
            'feed-collection' => [
                'display_name' => '收藏分享',
                'description' => '用户收藏分享权限',
            ],
        ];
    }
}
