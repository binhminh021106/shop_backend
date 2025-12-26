<?php

namespace App\Http\Controllers\Api\admin;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();

        return response()->json($category);
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
                    Rule::unique('categories', 'name')->whereNull('deleted_at')
                ],
                'parent_id' => 'nullable|integer|exists:categories,id',
                'order_number' => [
                    'required',
                    'integer',
                    'min:0',
                    Rule::unique('categories', 'order_number')->whereNull('deleted_at')
                ],
                'description' => 'nullable|string',
                'status' => 'required|string|in:active,inactive',
                'icon' => 'required|string|max:50'
            ],
            [
                'required' => ':attribute không được để trống',

                'name.unique' => "Tên danh mục đã được sử dụng",
                'order_number.unique' => "Số thứ tự đã bị trùng với số trước",
                'status.in' => 'Trạng thái không hợp lệ',
                'exists'      => ':attribute không tồn tại trong hệ thống',
                'integer'     => ':attribute phải là số'
            ],
            [
                'name' => 'Tên danh mục',
                'status' => 'Trạng thái',
                'order_number' => 'Số thứ tự',
                'parent_id' => 'Danh mục cha'
            ]
        );

        try {
            $category = Category::create($validated);

            return response()->json([
                'status' => true,
                'message' => 'Thêm danh mục thành công',
                'data' => $category
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
        $category_detail = Category::findOrFail($id);

        return response()->json($category_detail);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate(
            [
                'name' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('categories', 'name')->ignore($id)->whereNull('deleted_at')
                ],
                'description' => 'nullable|string',
                'order_number' => [
                    'sometimes',
                    'required',
                    'integer',
                    'min:0',
                    Rule::unique('categories', 'order_number')->ignore($id)->whereNull('deleted_at')
                ],
                'status' => 'sometimes|required|string|max:50|in:active,inactive',
                'icon' => 'sometimes|required|string|max:50|',
                'parent_id' => 'nullable|integer|exists:categories,id'
            ],
            [
                'required' => ':attribute không được để trống',
                'name.unique' => 'Tên danh mục đã được sử dụng',
                'order_number.unique' => 'Số thứ tự đã bị trùng với số trước',
                'status.in' => 'Trạng thái không hợp lệ',
                'exists'      => ':attribute không tồn tại trong hệ thống',
                'integer'     => ':attribute phải là số'
            ],
            [
                'name' => 'Tên danh mục',
                'status' => 'Trạng thái',
                'order_number' => 'Số thứ tự',
                'parent_id' => 'Danh mục cha'
            ]
        );

        try {
            $category->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Đã cập nhật danh mục thành công',
                'data' => $category
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);

        $isParent = Category::where('parent_id', $id)->exists();

        try {
            if ($isParent) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không thể xóa! Danh mục này đang chứa các danh mục con.'
                ], 400);
            }

            $category->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xoá danh mục thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ], 500);
        }
    }
}
