<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repository\UserRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\DataObjectTransfert\UserData;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $repository)
    {
        $this->userRepository = $repository;
    }

    public function register(UserRequest $userRequest)
    {
        $data = $userRequest->validated();

        $userData = new UserData(
            email: $data[User::EMAIL],
            name: $data[User::NAME],
            password: bcrypt($data[User::PASSWORD]),
            role: 'user',
        );
        $user = $this->userRepository->store($userData->toArray());

        $result = [
            'user' => UserResource::make($user),
            'token' => $user->createToken('authToken')->accessToken,
        ];

        return $this->success($result, "Utilisateur créé avec succès");
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            User::EMAIL => 'required|string',
            User::PASSWORD => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 422);
        }

        $credentials = $request->only([User::EMAIL, User::PASSWORD]);

        $token = Auth::attempt($credentials);

        if ($token) {
            $user = User::find(Auth::id());
            return $this->success([
                'user' => UserResource::make($user->load("projects")),
                'token' => $user->createToken('authToken')->accessToken,
            ]);
        }

        return $this->error("Identifiants incorrects", 422);
    }

    public function logout() {
        $user = $this->userRepository->getUser(Auth::id());
        $user->tokens()->delete();

        return $this->success([], "Utilisateur déconnecté avec succès");
    }

    public function profile() {
        $user = $this->userRepository->getUser(Auth::id());
        return $this->success(UserResource::make($user), "Utilisateur récupérer avec succès");
    }
}
