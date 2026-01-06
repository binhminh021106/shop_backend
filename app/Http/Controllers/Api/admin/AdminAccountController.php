<?php

namespace App\Http\Controllers\Api\admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = Admin::all();

        return response()->json($admin);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'fullname' => [
                    'required',
                    'string',
                    'max:100',
                ],
                'email' => [
                    'required',
                    'email',
                    'string',
                    'max:100',
                    Rule::unique('admins', 'email')->whereNull('deleted_at')
                ],
                'password' => [
                    'required',
                    'string',
                    'max:255',
                    'min:8',
                    'regex:/^(?=.*[A-Z])(?=.*\d).+$/'
                ],
                'role_id' => [
                    'required',
                    'integer',
                    'min:0',
                    'exists:roles,id'
                ],
                'phone' => [
                    'required',
                    'string',
                    'max:20',
                    'regex:/^[0-9]+$/',
                    Rule::unique('admins', 'phone')->whereNull('deleted_at')
                ],
                'avatar_url' => [
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,svg,gif',
                    'max:5120'
                ],
                'status' => [
                    'required',
                    'string',
                    'max:30',
                ],
                'address' => [
                    'nullable',
                    'string',
                    'max:255'
                ]
            ],
            [
                'required' => ':attribute không được để trống',
                'email.unique' => 'Email bạn nhập đã tồn tại',
                'email.email' => 'Email không đúng định dạng',
                'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ hoa và 1 số',
                'phone.unique' => 'Số điện thoại đã tồn tại',
                'phone.regex' => 'Số điện thoại chỉ được chứa ký tự số',
                'exists' => ':attribute không tồn tại trong hệ thống',
                'integer' => ':attribute phải là số',
                'image' => ':attribute không phải là định dạng hình ảnh',
                'mimes' => ':attribute chỉ chấp nhận định dạng: jpeg, png, jpg, gif, svg',
                'max' => [
                    'numeric' => ':attribute không được lớn hơn :max',
                    'file' => ':attribute chỉ chấp nhận file dưới hoặc :max KB',
                    'string' => ':attribute không được vượt quá :max ký tự',
                ],
                'min' => [
                    'string' => ':attribute phải có ít nhất :min ký tự',
                ]
            ],
            [
                'fullname' => 'Họ và tên',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'role_id' => 'Vai trò',
                'phone' => 'Số điện thoại',
                'avatar_url' => 'Ảnh đại diện',
                'status' => 'Trạng thái',
                'address' => 'Địa chỉ',
            ]
        );

        try {
            $validated['password'] = Hash::make($validated['password']);

            if ($request->hasFile('avatar_url')) {
                $file = $request->file('avatar_url');

                $path = $file->store('Avatar_Admin', 'public');
                $validated['avatar_url'] = $path;
            }

            $admin = Admin::create($validated);
            $admin->avatar_full_url = Storage::url($admin->avatar_url);

            return response()->json([
                'status' => true,
                'message' => 'Thêm tài khoản quản trị thành công',
                'data' => $admin
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
        $admin = Admin::findOrFail($id);

        return response()->json($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate(
            [
                'fullname' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:100',
                ],
                'email' => [
                    'sometimes',
                    'required',
                    'email',
                    'string',
                    'max:100',
                    Rule::unique('admins', 'email')->ignore($id)->whereNull('deleted_at')
                ],
                'password' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255',
                    'min:8',
                    'regex:/^(?=.*[A-Z])(?=.*\d).+$/'
                ],
                'role_id' => [ 
                    'sometimes',
                    'required',
                    'integer',
                    'min:0',
                    'exists:roles,id'
                ],
                'phone' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:20',
                    'regex:/^[0-9]+$/',
                    Rule::unique('admins', 'phone')->ignore($id)->whereNull('deleted_at')
                ],
                'avatar_url' => [
                    'sometimes',
                    'required',
                    'image',
                    'mimes:jpeg,png,jpg,svg,gif',
                    'max:5120'
                ],
                'status' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:30',
                ],
                'address' => [
                    'nullable',
                    'string',
                    'max:255'
                ]
            ],
            [
                'required' => ':attribute không được để trống',
                'email.unique' => 'Email bạn nhập đã tồn tại',
                'email.email' => 'Email không đúng định dạng',
                'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ hoa và 1 số',
                'phone.unique' => 'Số điện thoại đã tồn tại',
                'phone.regex' => 'Số điện thoại chỉ được chứa ký tự số',
                'exists' => ':attribute không tồn tại trong hệ thống',
                'integer' => ':attribute phải là số',
                'image' => ':attribute không phải là định dạng hình ảnh',
                'mimes' => ':attribute chỉ chấp nhận định dạng: jpeg, png, jpg, gif, svg',
                'max' => [
                    'numeric' => ':attribute không được lớn hơn :max',
                    'file' => ':attribute chỉ chấp nhận file dưới hoặc :max KB',
                    'string' => ':attribute không được vượt quá :max ký tự',
                ],
                'min' => [
                    'string' => ':attribute phải có ít nhất :min ký tự',
                ]
            ],
            [
                'fullname' => 'Họ và tên',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'role_id' => 'Vai trò',
                'phone' => 'Số điện thoại',
                'avatar_url' => 'Ảnh đại diện',
                'status' => 'Trạng thái',
                'address' => 'Địa chỉ',
            ]
        );

        try {
            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            if ($request->hasFile('avatar_url')) {
                if ($admin->avatar_url && Storage::disk('public')->exists($admin->avatar_url)) {
                    Storage::disk('public')->delete($admin->avatar_url);
                }

                $path = $request->file('avatar_url')->store('Avatar_Admin', 'public');
                $validated['avatar_url'] = $path;
            }

            $admin->update($validated);

            $admin->avatar_full_url = Storage::url($admin->avatar_url);

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thông tin tài khoản thành công',
                'data' => $admin
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
        $admin = Admin::findOrFail($id);

        try {
            if ($admin->avatar_url && Storage::disk('public')->exists($admin->avatar_url)) {
                Storage::disk('public')->delete($admin->avatar_url);
            }

            $admin->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xóa tài khoản thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ], 500);
        }
    }
}
