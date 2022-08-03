<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementCollection;
use App\Models\Advertisement;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
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
}
