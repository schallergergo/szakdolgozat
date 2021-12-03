<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Result;
use App\Models\Event;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {$user=Auth::User();
        if ($user->role=="rider") return $this->riderIndex($user);
        if ($user->role=="office") return $this->officeIndex($user);
        if ($user->role=="admin") return $this->adminIndex($user);
        if ($user->role=="penciler") return $this->pencilerIndex($user);
        return view("home");
    }

    //the home screen for riders
    private function riderIndex(User $user){
        $toMatch=[
            "rider_id"=>$user->username,
            "completed"=>1,
            "public"=>1,
            ];
        $results=Result::where($toMatch)->orderBy('created_at','desc')->paginate(10); 
        return view("result.index.rider",["results"=>$results]);
    }

        //the home screen for office
    private function officeIndex(User $user){
        $toMatch=[
            "office"=>$user->id,
            "active"=>1,
            ];
        $events=Event::where($toMatch)->orderBy('date','desc')->paginate(10); 
        return view("event.index",["events"=>$events]);
    }
    //the home screen for penciler
    private function pencilerIndex(User $user){
        $toMatch=[
            "penciler"=>$user->id,
            "active"=>1,
            ];
        $events=Event::where($toMatch)->orderBy('date','desc')->paginate(10); 
        return view("event.index",["events"=>$events]);
    }

    //the home screen for admin
    private function adminIndex(User $user){
        $events=Event::orderBy('date','desc')->paginate(10); 
        return view("event.index",["events"=>$events]);
    }
}
