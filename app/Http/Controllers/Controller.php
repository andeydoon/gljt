<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user_types = [1 => 'member.', 2 => 'master.', 3 => 'dealer.'];
    protected $product_statuses = [-1 => '未提审', 0 => '待审核', 1 => '已上架', 2 => '被拒审', 3 => '已下架'];

    protected $order_part1_ratio = 0.3;
}
