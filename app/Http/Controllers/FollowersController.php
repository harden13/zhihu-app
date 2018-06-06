<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use Auth;
use App\Repositories\UserRepository;

class FollowersController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index($id)
    {
        $user = $this->user->byId($id);
        $followers = $user->followersUser()->pluck('follower_id')->toArray();
        if (in_array(Auth::guard('api')->user()->id, $followers)) {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function follow()
    {
        $userToFollow = $this->user->byId(request('user'));
        $user =  Auth::guard('api')->user();
        $followed = $user->followThisUser($userToFollow->id);
        if (count($followed['attached']) > 0) {
            $userToFollow->notify(new NewUserFollowNotification());
            $userToFollow->increment('followers_count');
            $user->increment('followings_count');
            return response()->json(['followed' => true]);
        }
        $userToFollow->decrement('followers_count');
        $user->decrement('followings_count');
        return response()->json(['followed' => false]);
    }
}
