<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Resources\Auth\UserResource;
use App\Services\User\UserServiceInterface;
use App\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected UserServiceInterface $userService
    ) {}

    public function index(): JsonResponse
    {
        $users = $this->userService->getAll();

        return $this->success(
            UserResource::collection($users),
            'Kullanıcılar listelendi'
        );
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->create(
                $request->validated(),
                $request->user()
            );

            return $this->success(
                new UserResource($user),
                'Kullanıcı oluşturuldu',
                201
            );
        } catch (AuthorizationException $e) {
            return $this->error($e->getMessage(), 403);
        }
    }

    public function creatableRoles(Request $request): JsonResponse
    {
        $roles = $this->userService->getCreatableRoles($request->user());

        $rolesArray = array_map(function ($role) {
            return [
                'value' => $role->value,
                'label' => $role->label(),
            ];
        }, $roles);

        return $this->success($rolesArray, 'Oluşturulabilir roller');
    }
}
