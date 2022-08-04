<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdvertisementCollection;
use App\Models\Advertisement;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;

class AdvertisementsController  extends Controller
{
    use GeneralTrait;

    
    public function getAdvs(Request $request)
    {
        try {

        if ($request->has('tags_ids') || $request->tags_ids != null || $request->tags_ids != '') {
            $tags_ids = explode(',', $request->tags_ids);
            $request['tags_ids'] = $tags_ids;
        }

        $validate = Validator::make($request->all(),  [
            'tags_ids.*' => 'nullable|exists:tags,id',
            'category_id' => 'nullable|exists:categories,id',
        ], []);

        if ($validate->fails()) {
            $code = $this->returnCodeAccordingToInput($validate);
            return $this->returnValidationError($code, $validate);
        }


        $tags_ids_filter = $request->tags_ids;

        $advs = Advertisement::query()
            ->when($request->category_id, function ($q) use ($request) {
                return $q->where('category_id', $request->category_id);
            })
            ->when($tags_ids_filter != '', function ($query) use ($tags_ids_filter) {
                $query->whereHas('advertisements_tags', function ($query) use ($tags_ids_filter) {
                    $query->whereIn('advertisements_tags.tag_id', $tags_ids_filter);
                });
            })
            ->paginate($this->getPaginationPerPage());

        return $this->returnData('advertisements', new AdvertisementCollection($advs));
        } catch (\Exception $ex) {
            return $this->returnError('301', 'An error occurred, please try again later');
        }
    }
}
