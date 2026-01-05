<?php

namespace App\Http\Controllers\Api\admin;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class AdminNewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $new = News::with('CategoryNew')->latest()->get();

        return response()->json($new);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'category_id' => [
                    'required',
                    'integer',
                    'min:0',
                    'exists:category_news,id'
                ],
                'excerpt' => [
                    'nullable',
                    'string'
                ], // Đoạn trích
                'content' => [
                    'required',
                    'string',
                ],
                'image_url' => [
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,svg,gif',
                    'max:5120'
                ],
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'status' => [
                    'required',
                    'string',
                    'max:50',
                    'in:published,pending,hidden'
                ],
                'author_name' => [
                    'required',
                    'string',
                    'max:100',
                ],
                'meta_title' => [
                    'nullable',
                    'string',
                    'max:255'
                ],
                'meta_description' => [
                    'nullable',
                    'string'
                ],
                'meta_keywords' => [
                    'nullable',
                    'string',
                    'max:255'
                ]
            ],
            [
                'required' => ':attribute không được để trống',
                'status.in' => 'Trạng thái không hợp lệ',
                'exists' => ':attribute không tồn tại trong hệ thống',
                'integer' => ':attribute không phải là số',
                'image' => '"attribute không phải là định dạng hình ảnh',
                'mimes' => ':attribute chỉ chấp nhận định dạng: jpeg, png, jpg, gif, svg',
                'max' => ':attribute chỉ chấp nhận file dưới hoặc 5MB'
            ],
            [
                'title' => 'Tiêu đề tin tức',
                'category_id' => 'Danh mục',
                'excerpt' => 'Đoạn trích',
                'content' => 'Nội dung bài viết',
                'image_url' => 'Hình ảnh đại diện',
                'slug' => 'Đường dẫn (Slug)',
                'status' => 'Trạng thái',
                'author_name' => 'Tên tác giả',
                'meta_title' => 'Tiêu đề SEO',
                'meta_description' => 'Mô tả SEO',
                'meta_keywords' => 'Từ khóa SEO',
            ]
        );

        try {
            if ($request->hasFile('image_url')) {
                $file = $request->file('image_url');

                $path = $file->store('New', 'public');
                $validated['image_url'] = $path;
            }

            $new = News::create($validated);
            $new->image_full_url = Storage::url($new->image_url);

            return response()->json([
                'status' => true,
                'message' => 'Thêm tin tức thành công',
                'data' => $new
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
        $new = News::with('CategoryNew')->findOrFail($id);

        $new->increment('views');

        return response()->json($new);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $new = News::findOrFail($id);

        $validated = $request->validate(
            [
                'title' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255',
                ],
                'category_id' => [
                    'sometimes',
                    'required',
                    'integer',
                    'min:0',
                    'exists:category_news,id'
                ],
                'excerpt' => [
                    'nullable',
                    'string'
                ], // Đoạn trích
                'content' => [
                    'sometimes',
                    'required',
                    'string',
                ],
                'image_url' => [
                    'sometimes',
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,svg,gif',
                    'max:5120'
                ],
                'slug' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255',
                ],
                'status' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:50',
                    'in:published,pending,hidden'
                ],
                'author_name' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:100',
                ],
                'meta_title' => [
                    'nullable',
                    'string',
                    'max:255'
                ],
                'meta_description' => [
                    'nullable',
                    'string'
                ],
                'meta_keywords' => [
                    'nullable',
                    'string',
                    'max:255'
                ]
            ],
            [
                'required' => ':attribute không được để trống',
                'status.in' => 'Trạng thái không hợp lệ',
                'exists' => ':attribute không tồn tại trong hệ thống',
                'integer' => ':attribute không phải là số',
                'image' => '"attribute không phải là định dạng hình ảnh',
                'mimes' => ':attribute chỉ chấp nhận định dạng: jpeg, png, jpg, gif, svg',
                'max' => ':attribute chỉ chấp nhận file dưới hoặc 5MB'
            ],
            [
                'title' => 'Tiêu đề tin tức',
                'category_id' => 'Danh mục',
                'excerpt' => 'Đoạn trích',
                'content' => 'Nội dung bài viết',
                'image_url' => 'Hình ảnh đại diện',
                'slug' => 'Đường dẫn (Slug)',
                'status' => 'Trạng thái',
                'author_name' => 'Tên tác giả',
                'meta_title' => 'Tiêu đề SEO',
                'meta_description' => 'Mô tả SEO',
                'meta_keywords' => 'Từ khóa SEO',
            ]
        );

        try {
            if ($request->hasFile('image_url')) {
                if ($new->image_url && Storage::disk('public')->exists($new->image_url)) {
                    Storage::disk('public')->delete($new->image_url);
                }

                $path = $request->file('image_url')->store('New', 'public');
                $validated['image_url'] = $path;
            }

            $new->update($validated);

            $new->image_full_url = Storage::url($new->image_url);

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật tin tức thành công',
                'data' => $new
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
        $new = News::findOrFail($id);

        try {
            if ($new->image_url && Storage::disk('public')->exists($new->image_url)) {
                Storage::disk('public')->delete($new->image_url);
            }

            $new->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xóa tin tức thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ], 500);
        };
    }
}
