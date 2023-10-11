<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\ChatStoreRequest;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Resources\User\UserResource;
use App\Models\Chat;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ChatController extends Controller
{
    public function index(Request $request): Response
    {
        $allUsers = User::query()
            ->where('id', '!=', auth()->id())
            ->get();
        $users = UserResource::collection($allUsers)
            ->resolve();

        $chats = auth()->user()
                        ->chats()
                        ->get();

        $chats = ChatResource::collection($chats)->resolve();

        return Inertia::render(
            'Chat/Index',
            compact(
                'users',
                'chats'
            ));
    }

    public function store(ChatStoreRequest $request): Response
    {
        $data = $request->validated();

        $userIds = array_merge($data['users'], (array)auth()->id());

        sort($userIds);

        $userIdsString = implode('-', $userIds);

        try {
            DB::beginTransaction();

            $chat = Chat::query()->firstOrCreate([
                'users' => $userIdsString
            ], [
                'title' => $data['title']
            ]);

            $chat->users()->sync($userIds);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
        }

        $chat = ChatResource::make($chat)->resolve();

        return Inertia::render('Chat/Show', compact('chat'));
    }

    public function show(Chat $chat): Response
    {
        $chat = ChatResource::make($chat)->resolve();

        return Inertia::render('Chat/Show');
    }
}
