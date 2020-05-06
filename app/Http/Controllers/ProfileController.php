<?php

namespace App\Http\Controllers;

use Hash;
use App\Core\Interfaces\ProfileInterface;
use App\Http\Requests\Profile\ProfileUpdateAccountUsernameRequest;
use App\Http\Requests\Profile\ProfileUpdateAccountPasswordRequest;
use App\Http\Requests\Profile\ProfileUpdateAccountColorRequest;


class ProfileController extends Controller{


    protected $profile_repo;


    public function __construct(ProfileInterface $profile_repo){

        $this->profile_repo = $profile_repo;
        parent::__construct();

    }




	public function details(){
        return view('dashboard.profile.details');
    }




    public function updateAccountUsername(ProfileUpdateAccountUsernameRequest $request, $slug){

        $user = $this->profile_repo->updateUsername($request, $slug);
        $this->session->flush();
        $this->auth->logout();
        $this->event->fire('profile.update_account_username', $user);
        return redirect('/');
        
    }




    public function updateAccountPassword(ProfileUpdateAccountPasswordRequest $request, $slug){

        if(Hash::check($request->old_password, $this->auth->user()->password)){

            $user = $this->profile_repo->updatePassword($request, $slug);
            $this->session->flush();
            $this->auth->logout();
            $this->event->fire('profile.update_account_password', $user);
            return redirect('/');

        }

        $this->session->flash('PROFILE_OLD_PASSWORD_FAIL', 'The old password you provided does not match.');
        return redirect()->back();
        
    }


    

    public function updateAccountColor(ProfileUpdateAccountColorRequest $request, $slug){

        $user = $this->profile_repo->updateColor($request, $slug);
        $this->event->fire('profile.update_account_color', $user);
        return redirect()->back();
        
    }




}
