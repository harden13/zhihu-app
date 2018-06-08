<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use App\Repositories\UserRepository;

/**
 * Class FollowersController
 * @package App\Http\Controllers
 */
class FollowersController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * FollowersController constructor.
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * 判断用户是否关注了某用户
     */
    public function index($id)
    {
        $user = $this->user->byId($id);
        $followers = $user->followersUser()->pluck('follower_id')->toArray();
        if (in_array(user('api')->id, $followers)) {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * 关注用户
     */
    public function follow()
    {
        $userToFollow = $this->user->byId(request('user'));
        $user =  user('api');
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
