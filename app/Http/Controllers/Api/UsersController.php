<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementCollection;
use App\Jobs\SendMails;
use App\Mail\TestMail;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UsersController  extends Controller
{
    use GeneralTrait;


    public function getUserAdvs($id)
    {
        try {

            $user = User::find($id);

            if (!$user)
                return $this->returnError('404', 'Not found this category');

            $user_ads = $user->advertisements()->paginate($this->getPaginationPerPage());

            $user['advertisements'] = new AdvertisementCollection($user_ads);

            return $this->returnData('user', ($user));
        } catch (\Exception $ex) {
            return $this->returnError('301', 'An error occurred, please try again later');
        }
    }

    public function send()
    {
        // return User::join('advertisements' , 'advertisements.user_id' , 'users.id')
        // ->select('email')
        // ->where('advertisements.start_date' , Carbon::now()->addDay(1)->toDateString())
        // ->get();

        $users = User::join('advertisements' , 'advertisements.user_id' , 'users.id')
        ->where('advertisements.start_date' , Carbon::now()->addDay(1)->toDateString())
        ->chunk(50 , function($data){
            dispatch(new SendMails($data));
        });

        return 'sending in background';


        //   Mail::to('ramadankhalefa798@gmail.com')->send(new TestMail);

        // return 'sending';
    }
}
