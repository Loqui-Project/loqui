<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\Handler;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GeneralController extends Handler
{
    /**
     * Search for a resource
     */
    public function search(Request $request): JsonResponse
    {
        try {
            if ($request->has('search_key')) {
                $searchKey = $request->input('search_key');
                // search for users by name or username
                $users = User::where(function ($q) use ($searchKey) {
                    $q->where('name', 'like', "%$searchKey%")
                        ->orWhere('username', 'like', "%$searchKey%");
                })->where('id', '!=', $request->user()->id)
                    ->get();

                return $this->responseSuccess(UserResource::collection($users->load('follower')));
            } else {
                return $this->responseError('Search key is required', 400);
            }
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 500);
        }
    }
}
