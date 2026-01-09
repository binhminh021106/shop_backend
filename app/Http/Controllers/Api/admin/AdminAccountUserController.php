<?php

namespace App\Http\Controllers\Api\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminAccountUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();

        return response()->json($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'fullName' => [
                    'required',
                    'string',
                    'max:150',
                ],
                'email' => [
                    'required',
                    'string',
                    'max:150',
                    'email',
                    Rule::unique('users', 'email')->whereNull('deleted_at'),
                ],
                'phone' => [
                    'nullable',
                    'string',
                    'max:20',
                    'regex:/^[0-9]+$/',
                    Rule::unique('users', 'phone')->whereNull('deleted_at')
                ],
                'password' => [
                    'nullable',
                    'string',
                    'max:255',
                    'min:8',
                    'regex:/^(?=.*[A-Z])(?=.*\d).+$/'
                ],
                'avatar_url' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,svg,gif',
                    'max:5120'
                ],
                'status' => [
                    'required',
                    'string',
                    'max:20',
                ],
                'birthday' => [
                    'nullable',
                    'date'
                ],
                'sex' => [
                    'nullable',
                    'string',
                    'max:10'
                ]
            ],
            [
                'required' => ':attribute không được để trống',
                'email.unique' => 'Email bạn nhập đã tồn tại',
                'email.email' => 'Email bạn nhập không đúng định dạng',
                'phone.unique' => 'Số điện thoại bạn nhập đã tồn tại',
                'phone.regex' => 'Số điện thoại chỉ được chứa ký tự số',
                'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ hoa và 1 số',
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
                $file = $request->file('avatar_url');

                $path = $file->store('Avatar_user', 'public');
                $validated['avatar_url'] = $path;
            }

            $user = User::create($validated);
            $user->avatar_full_url = Storage::url($user->avatar_url);

            return response()->json([
                'status' => true,
                'message' => 'Thêm tài khoản khách hàng thành công',
                'data' => $user
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
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate(
            [
                'fullName' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:150',
                ],
                'email' => [
                    'sometimes',
                    'required',
                    'email',
                    'string',
                    'max:150',
                    Rule::unique('users', 'email')->ignore($id)->whereNull('deleted_at')
                ],
                'phone' => [
                    'nullable',
                    'string',
                    'max:20',
                    'regex:/^[0-9]+$/',
                    Rule::unique('users', 'phone')->ignore($id)->whereNull('deleted_at')
                ],
                'password' => [
                    'nullable',
                    'string',
                    'max:255',
                    'min:8',
                    'regex:/^(?=.*[A-Z])(?=.*\d).+$/'
                ],
                'avatar_url' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,svg,gif',
                    'max:5120'
                ],
                'status' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:20',
                ],
                'birthday' => [
                    'nullable',
                    'date',
                ],
                'sex' => [
                    'nullable',
                    'string',
                    'max:10'
                ]
            ],
            [
                'required' => ':attribute không được để trống',
                'email.unique' => 'Email bạn nhập đã tồn tại',
                'email.email' => 'Email bạn nhập không đúng định dạng',
                'phone.unique' => 'Số điện thoại bạn nhập đã tồn tại',
                'phone.regex' => 'Số điện thoại chỉ được chứa ký tự số',
                'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ hoa và 1 số',
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
                if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
                    Storage::disk('public')->delete($user->avatar_url);
                }

                $path = $request->file('avatar_url')->store('Avatar_user', 'public');
                $validated['avatar_url'] = $path;
            }

            $user->update($validated);
            $user->avatar_full_url = Storage::url($user->avatar_url);

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật thông tin tài khoản thành công',
                'data' => $user
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
        $user = User::findOrFail($id);

        try {
            if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
                Storage::disk('public')->delete($user->avatar_url);
            }

            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xóa tài khoản khách hàng thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ], 500);
        }
    }
}
