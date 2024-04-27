<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        try {
            $subscriptions = Subscription::all();
            return response()->json($subscriptions);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Произошла ошибка при загрузке подписок'], 500);
        }
    }
}
