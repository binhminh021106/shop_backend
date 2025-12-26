<?php

namespace App\Http\Controllers\Api\admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;


class AdminCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupon = Coupon::all();

        return response()->json($coupon);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'code' => [
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('coupons', 'code')->whereNull('deleted_at')
                ],
                'min_spend' => [
                    'required',
                    'numeric',
                    'min:0'
                ],
                'type' => [
                    'required',
                    'string',
                    'max:20',
                    'in:percent,fixed'
                ],
                'value' => [
                    'required',
                    'numeric',
                    'min:0',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->type === 'percent' && $value > 100) {
                            $fail('Giá trị giảm giá không được vượt quá 100%.');
                        }
                    },
                ],
                'usage_limit' => [
                    'nullable',
                    'integer',
                    'min:0',
                ],
                'usage_limit_per_user' => [
                    'nullable',
                    'integer',
                    'min:0',
                    function ($attribute, $value, $fail) use ($request) {
                        if (!is_null($request->usage_limit) && $value > $request->usage_limit) {
                            $fail('Giới hạn mỗi người dùng không được lớn hơn tổng số lượng mã.');
                        }
                    },
                ],
                'expires_at' => [
                    'nullable',
                    'date',
                    'after:now',
                    'date_format:Y-m-d H:i:s'
                ]
            ],
            [
                'required' => ':attribute không được để trống',
                'integer' => ':attribute phải là số nguyên',
                'numeric' => ':attribute phải là số',
                'code.unique' => 'Mã giảm giá này đã tồn tại',
            ],
            [
                'name' => 'Tên mã giảm giá',
                'code' => 'Mã code',
                'min_spend' => 'Chi tiêu tối thiểu',
                'value' => 'Giá trị giảm',
                'expires_at' => 'Ngày hết hạn',
                'usage_limit' => 'Giới hạn lượt dùng',
                'usage_limit_per_user' => 'Giới hạn dùng mỗi người'
            ]
        );

        try {
            $validated['code'] = strtoupper($validated['code']);

            $coupon = Coupon::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Tạo mã giảm giá thành công',
                'data' => $coupon
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $coupon = Coupon::findOrFail($id);

        return response()->json($coupon);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $coupon = Coupon::findOrFail($id);

        $validated = $request->validate(
            [
                'name' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255'
                ],
                'code' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:50',
                    Rule::unique('coupons', 'code')->ignore($id)->whereNull('deleted_at')
                ],
                'min_spend' => [
                    'sometimes',
                    'required',
                    'numeric',
                    'min:0'
                ],
                'type' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:20',
                    'in:percent,fixed'
                ],
                'value' => [
                    'sometimes',
                    'numeric',
                    'min:0',
                    function ($attribute, $value, $fail) use ($request, $coupon) {
                        $type = $request->type ?? $coupon->type;
                        if ($type === 'percent' && $value > 100) {
                            $fail('Giá trị giảm giá không được vượt quá 100%.');
                        }
                    }
                ],
                'usage_limit' => [
                    'nullable',
                    'integer',
                    'min:0',
                    function ($attribute, $value, $fail) use ($request, $coupon) {
                        $usageLimit = $request->usage_limit ?? $coupon->usage_limit;
                        if (!is_null($usageLimit) && $value > $usageLimit) {
                            $fail('Giới hạn mỗi người dùng không được lớn hơn tổng số lượt dùng.');
                        }
                    },
                ],
                'expires_at' => [
                    'nullable',
                    'date',
                    'after:now',
                    'date_format:Y-m-d H:i:s'
                ]
            ],
            [
                'required' => ':attribute không được để trống',
                'integer' => ':attribute phải là số nguyên',
                'numeric' => ':attribute phải là số',
                'code.unique' => 'Mã giảm giá này đã tồn tại',
            ],
            [
                'name' => 'Tên mã giảm giá',
                'code' => 'Mã code',
                'min_spend' => 'Chi tiêu tối thiểu',
                'value' => 'Giá trị giảm',
                'expires_at' => 'Ngày hết hạn',
                'usage_limit' => 'Giới hạn lượt dùng',
                'usage_limit_per_user' => 'Giới hạn dùng mỗi người'
            ]
        );

        try {

            if (isset($validated['code'])) {
                $validated['code'] = strtoupper($validated['code']);
            }

            $coupon->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật mã giảm giá thành công',
                'data' => $coupon
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::findOrFail($id);

        try {
            $coupon->delete();

            return response()->json([
                'status' => true,
                'message' => 'Đã xoá mã giảm giá thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ], 500);
        }
    }
}
