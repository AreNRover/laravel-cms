<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateUsersRequest;
use App\Http\Requests\Users\UpdateUsersRequest;
use App\User;
use Faker\Provider\Image;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth:api');
    }

    public function index()
    {
//        if ( \Gate::allows('isAdmin') || \Gate::allows('isAuthor') ){

            return User::all();

//        }
    }


    public function store(CreateUsersRequest $request)
    {
        User::create ([
            'name' => $request['name'] ,
            'email' => $request['email'],
            'password' => Hash::make($request['password'])  ,
            'type' => $request['type'] ,
            'photo' => $request['photo'] ,
            'bio' => $request['bio'],
        ]);

        return redirect(route('home'));
    }


    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request )
    {
        $user = auth('api')->user();

        $currentPhoto = $user->photo ;

        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id ,
            'password' => 'sometimes|required'
        ]);


        if ($request->photo != $currentPhoto){
            $name = time().'.' . explode('/' , explode(':' , substr($request->photo , 0 , strpos($request->photo , ';')))[1])[1] ;
            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            $request->merge(['photo' => $name]);

            $userPhoto = public_path('img/profile/').$currentPhoto;

            if (file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }

        if (!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());


    }


    public function update( UpdateUsersRequest $request , $id)
    {
        $user = User::findOrFail($id);

        $request->merge(['password' => Hash::make($request['password'])]);

        $user->update($request->all());


    }

    public function destroy($id)
    {
        $this->authorize('isAdmin');

        return User::findOrFail($id)->delete();
    }


    public function search()
    {
        if ($search = \Request::get('q')){
            $users = User::where(function ($query) use ( $search){

                $query->where('name' , 'LIKE' , "%$search%")
                    ->orWhere('email' , 'LIKE' , "%$search%")
                    ->orWhere('type' , 'LIKE' , "%$search%");
            })->paginate(5);
        }else{
            $users = User::oldest()->paginate(5);
        }

        return $users ;
    }

}
