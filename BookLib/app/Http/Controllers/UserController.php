<?php

namespace App\Http\Controllers;

use App\Models\App_review;
use App\Models\Book_review;
use App\Models\User;
use App\Models\Book;
use App\Models\User_subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    public function index(Request $request)
    {
        try {
            $user = $request->user();

            $books = Book::where('type', 'book')->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('isLike', true);
            })->get();

            $audiobooks = Book::where('type', 'audio')->whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('isLike', true);
            })->get();

            $review = App_review::where('user_id', $user->id)->first();

            $continueBook = Book::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->whereNotNull('last_page');
            })->get();

            $continueAudio = Book::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->whereNotNull('last_time');
            })->get();

            $userBookReview = Book_review::where('user_id', $user->id)->get();

            return response()->json(['user' => $user, 'review' => $review, 'books' => $books, 'audiobooks' => $audiobooks, 'continueBook' => $continueBook, 'continueAudio' => $continueAudio, 'userBookReview' => $userBookReview]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при загрузке данных пользователя'], 500);
        }
    }

    public function indexEdit(Request $request)
    {
        try {
            $user = $request->user();
            $subscr = User_subscription::with('subscription')->where('user_id', $user->id)->first();
            if ($subscr) {
                return response()->json(['user' => $user, 'subscription_name' => $subscr->subscription->name]);
            } else {
                return response()->json(['user' => $user, 'subscription_name' => null]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при загрузке данных пользователя для редактирования'], 500);
        }
    }
    public function profileUpdate(Request $request)
    {
        try {
            $user = Auth::user();

            $data = $request->validate([
                "nickname" => "nullable|string",
                "description" => "nullable|string",
                "oldPassword" => "nullable|string",
                "newPassword" => ['nullable', Password::min(8)->letters()->numbers()]
            ]);

            if (isset($data['nickname'])) {
                $user->nickname = $data['nickname'];
                $user->update(["nickname" => $user->nickname]);
            }

            if (isset($data['description'])) {
                $user->description = $data['description'];
                $user->update(["description" => $user->description]);
            }

            if (isset($data['oldPassword']) && isset($data['newPassword']) && Hash::check($data['oldPassword'], $user->password)) {
                $user->password = $data['newPassword'];
            } else {
                echo $user->password;
            }

            $user->save();
            return response()->json("success");
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при обновлении профиля пользователя'], 500);
        }
    }

    public function imageUpdate(Request $request)
    {
        try {
            $user = Auth::user();
            $user_path_delete = str_replace('http://localhost:8000/storage/', 'public/', $user->path_to_photo);
            Storage::delete($user_path_delete);
            $data = $request->validate([
                "path_to_photo" => "required|image|mimes:png,jpeg,jpg|max:2048",
            ]);
            if ($request->hasFile('path_to_photo')) {
                $imagePath = $request->file('path_to_photo')->store('public/images');
                $data['path_to_photo'] = url(\Storage::url($imagePath));
                $user->path_to_photo = $data['path_to_photo'];
                $user->update(['path_to_photo' => $user->path_to_photo]);
                $user->save();
            }

            return response()->json($user->path_to_photo);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при обновлении изображения пользователя'], 500);
        }
    }

    public function updateSubscription($id_subscription)
    {
        try {
            $user = Auth::user();
            $subscr = User_subscription::where('user_id', $user->id)->first();
            Log::info('user', ['user' => $user->id]);
            if ($subscr) {
                $subscr->delete();
            }
            $subscr2 = User_subscription::query()->create([
                'user_id' => $user->id,
                'subscription_id' => $id_subscription
            ]);
            $subscr2_name = User_subscription::with('subscription')->where('user_id', $user->id)->first();

            try {
                $user->update(['id_subscription' => $id_subscription]);
                $user->save();
            } catch (\Exception $e) {
                return $e->getMessage();
            }

            return response()->json($subscr2->subscription->name);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при обновлении подписки пользователя', $e->getMessage()], 500);
        }
    }

    public function getAvatar()
    {
        try {
            $user = Auth::user();
            return $user->path_to_photo;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при получении изображения пользователя'], 500);
        }
    }

    public function deleteUser($userId)
    {
        try {
            $user = User::findOrFail($userId)->delete();
            $user_path_delete = str_replace('http://localhost:8000/storage/', 'public/', $user->path_to_photo);
            Storage::delete($user_path_delete);
            Log::info('user', ['iser' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при удалении пользователя'], 500);
        }
    }
}
