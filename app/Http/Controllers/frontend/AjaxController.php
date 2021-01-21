<?php


namespace App\Http\Controllers\frontend;


use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AjaxController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param $userId
     * @return User|User[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getUser(Request $request)
    {
        if($request->ajax()){
            return User::find(Auth()->user()->id);
        }

        return null;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getCommentsUser(Request $request)
    {
        if($request->ajax()){

            return Comment::where('user_id', Auth()->user()->id)->get();
        }
    }
}
