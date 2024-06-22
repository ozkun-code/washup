<?php

namespace App\Http\Controllers;

use App\Enums\TokenAbility;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register()
{
    $data = request()->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);
    User::create($data);

    return ['message' => 'Registrasi Anda berhasil.'];
}
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            // Cari user berdasarkan email
            $user = User::where('email', $credentials['email'])->first();

            // Verifikasi password
            if ($user && Hash::check($credentials['password'], $user->password)) {
                $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
                $refreshToken = $user->createToken('refresh_token', [TokenAbility::REFRESH_TOKEN->value], Carbon::now()->addMinutes(config('sanctum.rt_expiration')));

                // Simpan token dan expiret at ke Redis
                Redis::set('access_token:' . $user->id, $accessToken->plainTextToken);
                Redis::set('access_token_expiry:' . $user->id, $accessToken->accessToken->expires_at->timestamp);
                
                Redis::set('refresh_token:' . $user->id, $refreshToken->plainTextToken);
                Redis::set('refresh_token_expiry:' . $user->id, $refreshToken->accessToken->expires_at->timestamp);

                return response()->json([
                    'message' => 'Login successful',
                    'access_token' => $accessToken->plainTextToken,
                    'refresh_token' => $refreshToken->plainTextToken,
                ]);
            }

            return response()->json(['message' => 'Invalid credentials'], 401);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred during the login process'], 500);
        }
    }
    public function refreshToken(Request $request)
    {
        $accessToken = $request->user()->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addMinutes(config('sanctum.ac_expiration')));
        return response(['message' => "Acess Token", 'token' => $accessToken->plainTextToken]);
    }
    public function logout(Request $request)
    {
        // Mendapatkan pengguna yang sedang login
        $user = $request->user();
    
        // Menghapus semua token yang terkait dengan pengguna tersebut
        $user->tokens->each(function ($token, $key) {
            $token->delete();
        });
    
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}