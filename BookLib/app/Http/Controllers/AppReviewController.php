<?php

namespace App\Http\Controllers;

use App\Models\App_review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AppReviewController extends Controller
{

    public function sendReview(Request $request)
    {
        try {
            $user = Auth::user();

            $data = $request->validate([
                "content" => "nullable|string",
                "count_star" => "nullable"
            ]);

            $app_review = App_review::query()->create([
                'content' => $data['content'],
                'count_star' => $data['count_star'],
                'user_id' => $user->id,
            ]);

            $app = App_review::where('user_id', $user->id)->first();

            return response()->json($app);
        } catch (\Exception $e) {
            Log::error('Ошибка при отправке отзыва: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при отправке отзыва'], 500);
        }
    }

    public function updateReview($id, Request $request)
    {
        try {
            $review = App_review::findOrFail($id);

            $data = $request->validate([
                "content" => "nullable|string",
                "count_star" => "max:5|min:1",
            ]);

            $review->update(['content' => $data['content']]);
            $review->update(['count_star' => $data['count_star']]);
            $review->save();

            return response()->json($review);
        } catch (\Exception $e) {
            Log::error('Ошибка при обновлении отзыва: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при обновлении отзыва'], 500);
        }
    }

    public function deleteReview()
    {
        try {
            $user = Auth::user();
            $app = App_review::where('user_id', $user->id)->delete();
            return response()->json("success");
        } catch (\Exception $e) {
            Log::error('Ошибка при удалении отзыва: ' . $e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при удалении отзыва'], 500);
        }
    }
}
