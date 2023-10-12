<?php

namespace App\Http\Controllers;

use App\Http\Requests\Message\MessageStoreRequest;
use App\Http\Resources\Message\MessageResource;
use App\Models\Message;
use App\Models\MessageStatus;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function store(MessageStoreRequest $request): JsonResponse|array
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();
            $message = Message::query()->create([
                'chat_id' => $data['chat_id'],
                'user_id' => $data['user_id'],
                'body' => $data['body'],
            ]);

            foreach ($data['user_ids'] as $id) {
                MessageStatus::query()->create([
                    'chat_id' => $data['chat_id'],
                    'message_id' => $message->id,
                    'user_id' => $id,
                ]);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }

        return MessageResource::make($message)->resolve();


    }
}
