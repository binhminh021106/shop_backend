<?php

namespace App\Http\Controllers\Api\admin;

use App\Models\Category_New;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

class AdminCategoryNewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category_new = Category_New::all();

        return response()->json($category_new);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('category_news', 'name')->whereNull('deleted_at')
                ]
            ],
            [
                'required' => 'Tên danh mục không được để trống',
                'name.unique' => 'Tên danh mục đã tồn tại'
          ],
        );

        try {
            $category_new = Category_New::Create($validate);

            return response()->json([
                'status' => true,
                'message' => 'Thêm danh mục thành công',
                'data' => $category_new
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
        $category_new = Category_New::findOrFail($id);

        return response()->json($category_new);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category_new = Category_New::findOrFail($id);

        $validated = $request->validate(
            [
                'name' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('category_news', 'name')->ignore($id)->whereNull('deleted_at')
                ]
            ],
            [
                'required' => 'Tên danh mục không được để trống',
                'name.unique' => 'Tên danh mục đã tồn tại'
            ]
        );

        try {
            $category_new->update($validated);

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật danh mục thành công',
                'data' => $category_new
            ], 201);
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
        $category_new = Category_New::findOrFail($id);

        try {
            $category_new->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xoá danh mục thành công',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ], 500);
        }
    }
}
