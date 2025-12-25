<?php

namespace App\Http\Controllers\Api\admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class AdminBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brand = Brand::all();

        return response()->json($brand);
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
                    'max:100',
                    Rule::unique('brands', 'name')->whereNull('deleted_at')
                ],
                'slug' => [
                    'required',
                    'string',
                    'max:50',
                ],
                'description' => [
                    'nullable',
                    'string',
                ],
                'logo_url' => [
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,gif,svg',
                    'max:5120'
                ],
                'order_number' => [
                    'required',
                    'integer',
                    'min:0',
                    Rule::unique('brands', 'order_number')->whereNull('deleted_at')
                ],
                'status' => [
                    'required',
                    'string',
                    'max:50',
                    'in:active,inactive'
                ],
            ],
            [
                'required' => ':attribute không được để trống',
                'name.unique' => 'Tên thương hiệu đã tồn tại',
                'order_number.unique' => "Số thứ tự đã bị trùng với số trước",
                'status.in' => 'Trạng thái không hợp lệ',
                'exists' => ':attribute không tồn tại trong hệ thống',
                'integer' => ':attribute phải là số',
                'image' => ':attribute không phải là định dạng hình ảnh',
                'mimes' => ':attribute chỉ chấp nhận định dạng: jpeg, png, jpg, gif, svg',
                'max' => ':attribute chỉ chấp nhận file dưới hoặc 5MB'
            ],
            [
                'name' => 'Thương hiệu',
                'slug' => 'Đường dẫn',
                'logo_url' => 'Hình ảnh',
                'order_number' => 'Số thứ tự',
                'status' => 'Trạng thái'
            ]
        );

        try {
            if ($request->hasFile('logo_url')) {
                $file = $request->file('logo_url');

                $path = $file->store('brand', 'public');
                $validated['logo_url'] = $path;
            }

            $brand = Brand::create($validated);

            $brand->logo_full_url = Storage::url($brand->logo_url);

            return response()->json([
                'status' => true,
                'message' => 'Thêm thương hiệu thành công',
                'data' => $brand
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::findOrFail($id);

        return response()->json($brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::findOrFail($id);

        $validated = $request->validate(
            [
                'name' => [
                    'sometime',
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('brands', 'name')->ignore($id)->whereNull('deleted_at')
                ],
                ''
            ],
            [
                'required' => ':attribute không được để trống',
                'name.unique' => 'Tên thương hiệu đã tồn tại',
                'order_number.unique' => "Số thứ tự đã bị trùng với số trước",
                'status.in' => 'Trạng thái không hợp lệ',
                'exists' => ':attribute không tồn tại trong hệ thống',
                'integer' => ':attribute phải là số',
                'image' => ':attribute không phải là định dạng hình ảnh',
                'mimes' => ':attribute chỉ chấp nhận định dạng: jpeg, png, jpg, gif, svg',
                'max' => ':attribute chỉ chấp nhận file dưới hoặc 5MB'
            ],
            [
                'name' => 'Thương hiệu',
                'slug' => 'Đường dẫn',
                'logo_url' => 'Hình ảnh',
                'order_number' => 'Số thứ tự',
                'status' => 'Trạng thái'
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
