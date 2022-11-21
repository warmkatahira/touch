<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\CustomerGroup;
use App\Models\Customer;

class CustomerGroupService
{
    public function getCustomerGroups()
    {
        // 自拠点の荷主グループを取得
        $customer_groups = CustomerGroup::where('base_id', Auth::user()->base_id)
                            ->orderBy('customer_group_order', 'asc')
                            ->get();
        return $customer_groups;
    }

    public function getCustomers()
    {
        // 自拠点の荷主を取得（荷主グループが設定されていないもののみ）
        $customers = Customer::where('control_base_id', Auth::user()->base_id)
                        ->whereNull('customer_group_id')
                        ->get();
        return $customers;
    }

    public function getCustomerGroupDetail($customer_group_id)
    {
        // 指定した荷主グループに関連する情報を取得
        $customer_groups = CustomerGroup::where('customer_groups.customer_group_id', $customer_group_id)
                            ->join('customers', 'customers.customer_group_id', 'customer_groups.customer_group_id')
                            ->get();
        // 指定した荷主グループを取得
        $customer_group = CustomerGroup::where('customer_groups.customer_group_id', $customer_group_id)->first();
        return compact('customer_groups','customer_group');
    }

    public function updateCustomerGroupSetting($customer_id, $value)
    {
        // レコードを更新
        Customer::where('customer_id', $customer_id)->update([
            'customer_group_id' => $value,
        ]);
        return;
    }

    public function registerCustomerGroup($customer_group_name)
    {
        // レコードを追加
        CustomerGroup::create([
            'base_id' => Auth::user()->base_id,
            'customer_group_name' => $customer_group_name,
            'customer_group_order' => 99,
        ]);
        return back();
    }

    public function deleteCustomerGroup($customer_group_id)
    {
        // 削除前にcustomersテーブルのcustomer_group_idをNullに更新
        Customer::where('customer_group_id', $customer_group_id)->update([
            'customer_group_id' => Null,
        ]);
        // レコードを削除
        CustomerGroup::where('customer_group_id', $customer_group_id)->delete();
        return;
    }

    public function modifyCustomerGroup($request)
    {
        // グループ名と表示順を変更
        CustomerGroup::where('customer_group_id', $request->customer_group_id)->update([
            'customer_group_name' => $request->customer_group_name,
            'customer_group_order' => $request->customer_group_order,
        ]);
        return;
    }
}