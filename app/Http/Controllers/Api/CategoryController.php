<?php

namespace App\Http\Controllers\Api;

use App\Model\Category;
use App\Model\CategoryUnlock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //unlock category for a user
    public function categoryUnlock(Request $request)
    {
        $data = ['success' => false, 'message' => __('Something Went wrong !')];

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = [];
            $e = $validator->errors()->all();
            foreach ($e as $error) {
                $errors[] = $error;
            }
            $data['message'] = $errors;

            return response()->json($data);
        }

        try {
            $category = Category::where('id', $request->category_id)->first();
            if (isset($category)) {
                if ($category->coin > 0) {
                    $alreadyUnlock = CategoryUnlock::where(['user_id'=> Auth::user()->id, 'category_id' => $request->category_id, 'status' => 0])->first();
                    if (isset($alreadyUnlock)) {
                        $data = [
                            'success' => false,
                            'message' => __('This category already unlock'),
                        ];
                    } else {
                        $unlock = CategoryUnlock::create(['user_id'=> Auth::user()->id, 'category_id' => $request->category_id, 'status' => 0]);
                        if ($unlock) {
                            $data = [
                                'success' => true,
                                'message' => __('Category unlock successfully'),
                            ];
                        } else {
                            $data = [
                                'success' => false,
                                'message' => __('Category unlock failed'),
                            ];
                        }
                    }
                } else {
                    $data = [
                        'success' => false,
                        'message' => __('There is a no coin in this category for unlock'),
                    ];
                }
            } else {
                $data = [
                    'success' => false,
                    'message' => __('Category not found'),
                ];
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again!',
            ]);
        }

        return response()->json($data);
    }
}
