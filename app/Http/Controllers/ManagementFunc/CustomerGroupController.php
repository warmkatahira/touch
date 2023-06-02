<?php

namespace App\Http\Controllers\ManagementFunc;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CustomerGroup;
use App\Services\ManagementFunc\CustomerGroupService;

class CustomerGroupController extends Controller
{
    public function index()
    {
        // インスタンス化
        $CustomerGroupService = new CustomerGroupService;
        // 自拠点の荷主グループを取得
        $customer_groups = CustomerGroup::getSpecifyBase(Auth::user()->base_id)->get();
        return view('management_func.customer_group.index')->with([
            'customer_groups' => $customer_groups,
        ]);
    }

    public function detail(Request $request)
    {
        // インスタンス化
        $CustomerGroupService = new CustomerGroupService;
        // 指定した荷主グループに関連する情報を取得
        $customer_group = $CustomerGroupService->getCustomerGroupDetail($request->customer_group_id);
        // 自拠点の荷主情報を取得
        $customers = $CustomerGroupService->getCustomers();
        return view('management_func.customer_group.detail')->with([
            'customer_groups' => $customer_group['customer_groups'],
            'customer_group' => $customer_group['customer_group'],
            'customers' => $customers,
        ]);
    }

    public function update_customer_group_id(Request $request)
    {
        // インスタンス化
        $CustomerGroupService = new CustomerGroupService;
        // 指定した荷主の荷主グループを更新
        $CustomerGroupService->updateCustomerGroupId($request->customer, $request->customer_group_id);
        return back();
    }

    public function delete_customer_group_id(Request $request)
    {
        // インスタンス化
        $CustomerGroupService = new CustomerGroupService;
        // 指定した荷主のグループを更新
        $CustomerGroupService->updateCustomerGroupId($request->customer_id, null);
        return back();
    }

    public function register_group(Request $request)
    {
        // インスタンス化
        $CustomerGroupService = new CustomerGroupService;
        // 荷主グループを追加
        $CustomerGroupService->registerCustomerGroup($request->customer_group_name);
        return back();
    }

    public function delete_group(Request $request)
    {
        // インスタンス化
        $CustomerGroupService = new CustomerGroupService;
        // 荷主グループを削除
        $CustomerGroupService->deleteCustomerGroup($request->customer_group_id);
        return back();
    }

    public function modify_group(Request $request)
    {
        // インスタンス化
        $CustomerGroupService = new CustomerGroupService;
        // 荷主グループ設定を変更
        $CustomerGroupService->modifyCustomerGroup($request);
        return back();
    }
}
