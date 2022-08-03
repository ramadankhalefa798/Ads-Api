<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryCollection;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use stdClass;

class CategoryController  extends Controller
{
    use GeneralTrait;

    // All Categories
    public function getCats()
    {
        try {

            $cats = Category::select('id', 'name')->orderBy('id' , 'DESC')->paginate($this->getPaginationPerPage());

            return $this->returnData('cats', new CategoryCollection($cats));
        } catch (\Exception $ex) {
            return $this->returnError('301', 'An error occurred, please try again later');
        }
    }


    public function addCategory(Request $request)
    {
        try {

            $validate = Validator::make($request->all(),  [
                'name' => 'required|unique:categories,name|max:190|min:3',
                'description' => 'required|max:200|min:3',
            ], []);

            if ($validate->fails()) {
                $code = $this->returnCodeAccordingToInput($validate);
                return $this->returnValidationError($code, $validate);
            }

            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            return $this->returnData('category', $category, 'Category has been Added');
        } catch (\Exception $ex) {
            return $this->returnError('301', 'An error occurred, please try again later');
        }
    }


    public function updateCategory(Request $request)
    {
        try {

            $validate = Validator::make($request->all(),  [
                'id' => 'required|numeric|exists:categories,id|min:1',
                'name' => 'required|max:190|min:3|unique:categories,name,' . $request->id,
                'description' => 'required|max:200|min:3',
            ], []);

            if ($validate->fails()) {
                $code = $this->returnCodeAccordingToInput($validate);
                return $this->returnValidationError($code, $validate);
            }

            $category = Category::find($request->id);
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();

            return $this->returnData('category', $category, 'Category has been Updated');
        } catch (\Exception $ex) {
            return $this->returnError('301', 'An error occurred, please try again later');
        }
    }


    public function destroy(Request $request)
    {
        try {

            $validate = Validator::make($request->all(),  [
                'id' => 'required|numeric|min:1',
            ], []);

            if ($validate->fails()) {
                $code = $this->returnCodeAccordingToInput($validate);
                return $this->returnValidationError($code, $validate);
            }


            $category = Category::find($request->id);

            if (!$category)
                return $this->returnError('404', 'Not found this category');

            $category->delete();

            return $this->returnSuccessMessage('Category has been Deleted', '200');
        } catch (\Exception $ex) {
            return $this->returnError('301', 'An error occurred, please try again later');
        }
    }
}
