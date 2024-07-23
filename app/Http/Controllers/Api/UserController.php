<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Repository\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Response\CollectionResponse;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    protected UserRepository $userRepository;

    public function __construct(UserRepository $repository)
    {
        $this->userRepository = $repository;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $authUser = $this->userRepository->getUser(Auth::id());
        $users = User::where(User::EMAIL, 'LIKE', "%$query%")->where(User::EMAIL, '<>', $authUser->email)->get(['id', 'email']);

        return new CollectionResponse($users);
    }

    
}
