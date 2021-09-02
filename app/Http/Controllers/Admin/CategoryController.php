<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use App\Model\Question;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /*
     * qsCategoryList
     *
     * List of question category
     *
     *
     *
     *
     */
    public function qsCategoryList()
    {
        $data['pageTitle'] = __('Category List');
        $data['menu'] = 'category';
        $data['categories'] = Category::orderBy('serial', 'ASC')->whereNull('parent_id')->get();

        return view('admin.category.list', $data);
    }
    /*
     * qsSubCategoryList
     *
     * List of question sub category
     *
     *
     *
     *
     */
    public function qsSubCategoryList($id)
    {
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            return redirect()->back();
        }
        $category = Category::findOrFail($id);
        if (isset($category)) {
            $data['pageTitle'] = __('Sub Category Of ').$category->name;
            $data['menu'] = 'category';
            $data['parentId'] = $category;
            $data['categories'] = Category::orderBy('serial', 'ASC')->where(['parent_id'=>$id])->get();

            return view('admin.category.list', $data);
        } else {
            return redirect()->back();
        }

    }

    /*
     * qsCategoryCreate
     *
     * Question category create page
     *
     *
     *
     *
     */

    public function qsCategoryCreate()
    {
        $data['pageTitle'] = __('Add Category');
        $data['menu'] = 'category';
        $data['parentCategories'] = Category::whereNull('parent_id')->get();

        return view('admin.category.add', $data);
    }

    /*
     * qsSubCategoryCreate
     *
     * Question sub category create page
     *
     *
     *
     *
     */

    public function qsSubCategoryCreate($id)
    {
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            return redirect()->back();
        }
        $category = Category::findOrFail($id);
        if (isset($category)) {
            $data['pageTitle'] = __('Add Sub Category Of ').$category->name;
            $data['menu'] = 'category';
            $data['parentCategories'] = Category::whereNull('parent_id')->get();
            $data['parentId'] = $category;

            return view('admin.category.add', $data);
        } else {
            return redirect()->back();
        }
    }

    /*
     * qsCategorySave
     *
     * Question category saving process
     *
     *
     *
     *
     */

    public function qsCategorySave(Request $request)
    {
        $rules = [
            'name' => ['required', Rule::unique('categories')->ignore($request->edit_id, 'id')],
            'serial' => ['required', Rule::unique('categories')->ignore($request->edit_id, 'id')],
            'qs_limit' => 'required|numeric|between:1,100',
            'max_limit' => 'required|numeric|min:1',
            'time_limit' => 'required|numeric|between:0,20',
        ];

        $messages = [
            'name.required' => __('Title field can not be empty'),
            'name.unique' => __('This name already taken'),
            'serial.unique' => __('This serial already taken'),
            'qs_limit.required' => __('Quiz limit field can not be empty'),
            'qs_limit.numeric' => __('Quiz limit must be a number'),
            'max_limit.required' => __('Max limit field can not be empty'),
            'time_limit.required' => __('Time limit field can not be empty'),
            'serial.required' => __('Serial field can not be empty'),
        ];

        if (!empty($request->image)) {
            $rules['image'] = 'mimes:jpeg,jpg,JPG,png,PNG,gif|max:4000';
        }
        if (!empty($request->coin)) {
            $rules['coin'] = 'numeric|between:1,1000';
        }
        $this->validate($request, $rules, $messages);
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'qs_limit' => $request->qs_limit,
                'time_limit' => $request->time_limit,
                'max_limit' => $request->max_limit,
                'serial' => $request->serial,
                'status' => $request->status,
                'parent_id' => $request->parent_id,
            ];
            if (!empty($request->coin)) {
                $data['coin'] = $request->coin;
            } else {
                $data['coin'] = 0;
            }
            if (!empty($request->edit_id)) {
                $cat = Category::where('id', $request->edit_id)->first();
                $alreadyParent = Category::where('parent_id',$request->edit_id)->get();
                if (isset($request->parent_id) && isset($alreadyParent[0])) {
                    return redirect()->back()->withInput()->with('dismiss', __('This category is already a parent '));
                }
            }
            if (!empty($request['image'])) {
                $old_img = '';
                if (!empty($cat->image)) {
                    $old_img = $cat->image;
                }
                $data['image'] = fileUpload($request['image'], path_category_image(), $old_img);
            }
            if (!empty($request->edit_id)) {
                $update = Category::where(['id' => $request->edit_id])->update($data);
                if ($update) {
                    if (isset($data['parent_id'])) {
                        return redirect()->back()->with('success', __('Sub Category Updated Successfully'));
                    } else {
                        return redirect()->back()->with('success', __('Category Updated Successfully'));
                    }
                } else {
                    return redirect()->back()->with('dismiss', __('Update Failed'));
                }
            } else {
                $insert = Category::create($data);
                if ($insert) {
                    $data_id = $insert->id;
                    $ids = User::where(['active_status'=> 1, 'role'=> 2])->select('device_id', 'device_type')->get();
                    //   $ids = array_filter($ids->toArray());
                    $count = 1;
                    // $count_ios =1;

                    if (isset($ids[0])) {
                        define('API_ACCESS_KEY', 'AAAA8P9G7Gc:APA91bEsV8U52EHrZC-okzl8gn4eTaUpinlwE6cZYgQUKZSbhBoKThueD034diTevllNzv5m_-mYzLkL9OqEUpwqtiWlGa4cSwcpCAAcxF3PPpuyYFPR1lZ32_m1XzNq7Gl6zMq7PwVQ');

                        foreach ($ids as $key => $id) {
                            if (!empty($id->device_type)) {
                                if ($id->device_type == 1) {

                                    pushNotification($id->device_id, $id->device_type, $data_id, $count);
                                    $count++;
                                }
                            }
                        }
                    }
                    if (isset($insert->parent_id)) {
                        return redirect()->route('qsSubCategoryList', encrypt($insert->parent_id))->with('success', __('Sub Category Created Successfully'));
                    } else {
                        return redirect()->route('qsCategoryList')->with('success', __('Category Created Successfully'));
                    }
                } else {
                    return redirect()->route('qsCategoryList')->with('dismiss', __('Save Failed'));
                }
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss',$e->getMessage());
//            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }

    }

    /*
     * qsCategoryEdit
     *
     * Edit the question category
     *
     *
     *
     *
     */

    public function qsCategoryEdit($id)
    {
        $data['menu'] = 'category';
        if (!empty($id) && is_numeric($id)) {
            $data['category'] = Category::findOrFail($id);
        }
        $data['parentCategories'] = Category::whereNull('parent_id')->get();
        if (isset($data['category']->parent_id)) {
            $data['pageTitle'] = __('Edit Sub Category');
        } else {
            $data['pageTitle'] = __('Edit Category');
        }
        return view('admin.category.add', $data);
    }

    /*
     * qsCategoryDelete
     *
     * Delete the question category
     *
     *
     *
     *
     */

    public function qsCategoryDelete($id)
    {

        if(isset($id) && is_numeric($id)){
            $qsCategory = Question::where('category_id',$id)->orWhere('sub_category_id',$id)->get();
            $checkSubCategory = Category::where(['parent_id' => $id])->get();
            if(isset($checkSubCategory[0])) {
                return redirect()->back()->with(['dismiss' => __("Under this category has some sub category.You can't delete this category")]);
            }
            if((!$qsCategory->isEmpty())) {
                return redirect()->back()->with(['dismiss' => __("Under this category has some question.You can't delete this category")]);
            }
            $item = Category::where('id', $id)->first();
            $destroy = $item->delete();
            if ($destroy) {
                if (isset($item->parent_id)) {
                    return redirect()->back()->with('success', __('Sub Category Deleted successfully'));
                } else {
                    return redirect()->back()->with('success', __('Category Deleted successfully'));
                }
            } else {
                return redirect()->back()->with('dismiss', __('Something went wrong!'));
            }
        } else {
            return redirect()->back()->with(['success'=>__('Category not found')]);
        }
    }

    /*
     * qsCategoryActivate
     *
     * Activate the question category
     *
     *
     *
     *
     */

    public function qsCategoryActivate($id) {
        $affected_row = Category::where('id', $id)
            ->update(['status' => STATUS_ACTIVE]);

        if (!empty($affected_row)) {
            return redirect()->back()->with('success', 'Activated successfully.');
        }

        return redirect()->back()->with('dismiss', 'Operation failed !');
    }

    /*
     * qsCategoryDeactivate
     *
     * Deactivate the question category
     *
     *
     *
     *
     */

    public function qsCategoryDeactivate($id) {
        $affected_row = Category::where('id', $id)
            ->update(['status' => STATUS_INACTIVE]);

        if (!empty($affected_row)) {
            return redirect()->back()->with('success', 'Deactivated successfully.');
        }

        return redirect()->back()->with('dismiss', 'Operation failed !');
    }
}
