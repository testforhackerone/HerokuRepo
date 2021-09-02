<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ExcelUploadRequest;
use App\Http\Requests\Admin\QuestionAddRequest;
use App\Model\Category;
use App\Model\Question;
use App\Model\QuestionOption;
use App\Services\CommonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class QuestionController extends Controller
{
    /*
     * questionList
     *
     * List of question
     *
     *
     *
     *
     */
    public function questionList()
    {
        $data['pageTitle'] = __('Question List');
        $data['menu'] = 'question';
        $data['items'] = Question::orderBy('id', 'DESC')->get();

        return view('admin.question.list', $data);
    }
    /*
     * categoryQuestionList
     *
     * List of categorise question
     *
     *
     *
     *
     */
    public function categoryQuestionList($cat_id)
    {
        $data['pageTitle'] = __('Category Question List');
        $data['catName'] = Category::where('id', $cat_id)->first()->name;
        $data['menu'] = 'category';
        $data['items'] = Question::orderBy('id', 'DESC')->where('category_id', $cat_id)->get();

        return view('admin.question.cat-qs-list', $data);
    }

    /*
     * questionCreate
     *
     * Question create page
     *
     *
     *
     *
     */

    public function questionCreate(Request $request)
    {
        $data['pageTitle'] = __('Add Question');
        $data['menu'] = 'question';
        $data['categories'] = Category::where('status', STATUS_ACTIVE)->orderBy('id','ASC')->whereNull('parent_id')->get();

        if ($request->ajax()) {
            $data_genetare = '<option value="">' . __('Select Sub Category') . '</option>';
            if (!empty($request->val)) {
                $sub_cat = Category::orderBy('id', 'DESC')->where(['status' => STATUS_ACTIVE,'parent_id'=>$request->val])->get();
                if (isset($sub_cat[0])) {
                    foreach ($sub_cat as $sc) {
                        $data_genetare .= '<option value="' . $sc->id . '">' . $sc->name . '</option>';
                    }
                }
            }
            return response()->json($data_genetare);
        }
        return view('admin.question.add', $data);
    }

    /*
     * questionSave
     *
     * Question saving process
     *
     *
     *
     *
     */

    public function questionSave(QuestionAddRequest $request)
    {

        if ($request->category_id && empty($request->sub_category_id)) {
            $subcategory = Category::where('parent_id',$request->category_id)->get();
            if (isset($subcategory[0])) {
                return redirect()->back()->withInput()->with('dismiss', __('Must be select a sub category of category'));
            }
        }
        if (empty($request->edit_id)) {

            if(empty($request->title) && empty($request->image)) {
                return redirect()->back()->withInput($request->input())->with('dismiss', __('Must be input title or upload image or add video link'));
            }
            $text = $this->preg_grep_keys_values('~option_text~i', $request->all());
            $image = $this->preg_grep_keys_values('~option_image~i', $request->all());
            $textCount = count(array_filter($text));
            $imgCount = count(array_filter($image));

            if($textCount + $imgCount < 2) {
                return redirect()->back()->withInput($request->input())->with('dismiss', __('At least two options are required'));
            }
        }
//        if(!empty($request->image) && !empty($request->video_link)) {
//            return redirect()->back()->withInput($request->input())->with('dismiss', __('At a time you can not upload image and add video link'));
//        }

        if ((!empty($request->option_text1) && !empty($request->option_image1)) || (!empty($request->option_text2) && !empty($request->option_image2)) ||
            (!empty($request->option_text3) && !empty($request->option_image3)) || (!empty($request->option_text4) && !empty($request->option_image4)) ||
            (!empty($request->option_text5) && !empty($request->option_image5))) {

            return redirect()->back()->withInput()->with('dismiss', __('At a time only text or only image sholud be a option'));
        }
        if (!in_array(1,[$request->ans_type1,$request->ans_type2,$request->ans_type3,$request->ans_type4, $request->ans_type5])) {
            return redirect()->back()->withInput()->with('dismiss', __('At least one answer must be right. '));
        }

        try {
            $data = [
                'title' => $request->title,
                'category_id' => $request->category_id,
                'type' => $request->type,
                'time_limit' => $request->time_limit,
                'answer' => $request->answer,
                'point' => $request->point,
                'serial' => $request->serial,
                'status' => $request->status,
                'skip_coin' => $request->skip_coin,
                'hints' => $request->hints,
                'sub_category_id' => $request->sub_category_id,
            ];

            if (!empty($request->coin)) {
                $data['coin'] = $request->coin;
            } else {
                $data['coin'] = 0;
            }
            if (!empty($request->edit_id)) {
                $qs = Question::where('id', $request->edit_id)->first();
            }
            if (!empty($request['image'])) {
                $old_img = '';
                if (!empty($qs->image)) {
                    $old_img = $qs->image;
                }
                $data['image'] = fileUpload($request['image'], path_question_image(), $old_img);
                $data['video_link'] = '';
            }
            if(!empty($request->video_link)) {
                $data['video_link'] = $request->video_link;
                $data['image'] = '';
            }
            if (!empty($request->edit_id)) {
                $update = Question::where(['id' => $request->edit_id])->update($data);
                if ($update) {
                    app(CommonService::class)->saveOptions($request, $request->edit_id);

                    return redirect()->back()->with('success', __('Question Updated Successfully'));
                } else {
                    return redirect()->back()->with('dismiss', __('Update Failed'));
                }
            } else {
                $categoryLimit = Category::where('id', $request->category_id)->first()->max_limit;
                $addedQuestion = Question::where('category_id', $request->category_id)->count();
                if ($categoryLimit <= $addedQuestion) {
                    return redirect()->route('questionList')->withInput($request->input())->with('dismiss', __('Questions limit exceeded'));
                }
                $insert = Question::create($data);
                if ($insert) {
                    app(CommonService::class)->saveOptions($request,$insert->id);

                    return redirect()->route('questionList')->with('success', __('Question Created Successfully'));
                } else {
                    return redirect()->route('questionList')->with('dismiss', __('Save Failed'));
                }
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss', $e->getMessage());
//            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }

    public function preg_grep_keys_values($pattern, $input, $flags = 0) {
        return array_merge(
            array_intersect_key($input, array_flip(preg_grep($pattern, array_keys($input), $flags))),
            preg_grep($pattern, $input, $flags)
        );
    }

    /*
     * questionEdit
     *
     * Edit the question
     *
     *
     *
     *
     */

    public function questionEdit($id)
    {
        $data['pageTitle'] = __('Edit Question');
        $data['menu'] = 'question';
        $data['categories'] = Category::where('status', STATUS_ACTIVE)->orderBy('id','ASC')->whereNull('parent_id')->get();

        if (!empty($id) && is_numeric($id)) {
            $data['question'] = Question::findOrFail($id);
            $data['sub_categories'] = Category::orderBy('id', 'DESC')->where(['status' => STATUS_ACTIVE,'parent_id'=>$data['question']->category_id])->get();
            $data['qsOptions'] = QuestionOption::where('question_id', $id)->get();
        }
        return view('admin.question.add', $data);
    }

    /*
     * questionDelete
     *
     * Delete the question
     *
     *
     *
     *
     */

    public function questionDelete($id)
    {
        $item = Question::where('id', $id)->first();
        $destroy = $item->delete();
        if ($destroy) {
            QuestionOption::where('question_id', $id)->delete();
            return redirect()->back()->with('success', __('Question Deleted successfully'));
        } else {
            return redirect()->back()->with('dismiss', __('Something went wrong!'));
        }
    }

    /*
     * questionActivate
     *
     * Activate the question
     *
     *
     *
     *
     */

    public function questionActivate($id) {
        $affected_row = Question::where('id', $id)
            ->update(['status' => STATUS_ACTIVE]);

        if (!empty($affected_row)) {
            return redirect()->back()->with('success', 'Activated successfully.');
        }
        return redirect()->back()->with('dismiss', 'Operation failed !');
    }

    /*
     * questionDectivate
     *
     * Deactivate the question
     *
     *
     *
     *
     */

    public function questionDectivate($id) {
        $affected_row = Question::where('id', $id)
            ->update(['status' => STATUS_INACTIVE]);

        if (!empty($affected_row)) {
            return redirect()->back()->with('success', 'Deactivated successfully.');
        }
        return redirect()->back()->with('dismiss', 'Operation failed !');
    }
    /*
     * qsExcelUpload
     *
     * question excel upload
     *
     */
    public function qsExcelUpload()
    {
        $data['pageTitle'] = __('Upload Questions');
        $data['menu'] = 'question';

        return view('admin.question.upload-excel', $data);
    }
    /*
     * qsExcelUploadProcess
     *
     * question excel upload process
     */
    //upload excel file
    public function qsExcelUploadProcess(ExcelUploadRequest $request)
    {
        try {
            $extensions = array("xls","xlsx","xlm","xla","xlc","xlt","xlw","csv");

            $result = array($request->file('excelfile')->getClientOriginalExtension());

            if(in_array($result[0],$extensions)){
                if ($request->hasFile('excelfile')) {
                    $path = $request->file('excelfile')->getRealPath();
                    $data = Excel::load($path)->get();

                    if ($data->count()) {
                        foreach ($data as $key => $row) {
                            $already_save = Question::where('status', STATUS_ACTIVE)
                                ->where(['title'=> $row->title])
                                ->first();

                            if ($already_save) {
                                continue;
                            }
                            if(!empty($row->category_id)) {
                                $category = Category::where(['id'=> $row->category_id, 'status'=> STATUS_ACTIVE])->first();
                                if(empty($category)) {
                                    continue;
                                }

                            }

                            if (!empty($row->category_id) && (!empty($row->sub_category_id))) {
                                $sub_category = Category::where(['id'=>$row->sub_category_id,'parent_id'=> $row->category_id, 'status'=> STATUS_ACTIVE])->first();
                                if(empty($sub_category)) {
                                    continue;
                                }
                            }
                            if (!empty($row->point) && !is_numeric($row->point)) {
                                return redirect()->back()->with('dismiss', __('The given point must be number'));
                            }
                            if (!empty($row->skip_coin) && !is_numeric($row->skip_coin)) {
                                return redirect()->back()->with('dismiss', __('The given skip coin must be number'));
                            }
                            if (!empty($row->coin) && !is_numeric($row->coin)) {
                                return redirect()->back()->with('dismiss', __('The given coin must be number'));
                            }
                            if (!empty($row->time_limit) && !is_numeric($row->time_limit)) {
                                return redirect()->back()->with('dismiss', __('The given time limit must be number'));
                            }
                            if (!in_array(intval($row->ans_type1),[0,1])) {
                                return redirect()->back()->with('dismiss', __('The given ans_type must be 0 or 1'));
                            }
                            if (!in_array(intval($row->ans_type2),[0,1])) {
                                return redirect()->back()->with('dismiss', __('The given ans_type must be 0 or 1'));
                            }
                            if (!in_array(intval($row->ans_type3),[0,1])) {
                                return redirect()->back()->with('dismiss', __('The given ans_type must be 0 or 1'));
                            }
                            if (!in_array(intval($row->ans_type4),[0,1])) {
                                return redirect()->back()->with('dismiss', __('The given ans_type must be 0 or 1'));
                            }
                            if (!in_array(intval($row->ans_type5),[0,1])) {
                                return redirect()->back()->with('dismiss', __('The given ans_type must be 0 or 1'));
                            }
                            $data_list = [
                                'title' => $row->title,
                                'category_id' => intval($row->category_id),
                                'type' => 1,
                                'time_limit' => !empty($row->time_limit) ? intval($row->time_limit) : null,
                                'point' => intval($row->point),
                                'skip_coin' => intval($row->skip_coin),
                                'hints' => !empty($row->hints) ? $row->hints : null,
                                'sub_category_id' => !empty($row->sub_category_id) ? intval($row->sub_category_id) : null,
                                'coin' => !empty($row->coin) ? intval($row->coin) : 0,
                            ];


                            if (!empty($row->title) && (!empty($row->category_id)) && (!empty($row->point) && (!empty($row->skip_coin)))) {
                                if (!in_array(1,[$row->ans_type1,$row->ans_type2,$row->ans_type3,$row->ans_type4, $row->ans_type5])) {
                                    return redirect()->back()->withInput()->with('dismiss', __('At least one answer must be right. '));
                                }
                                $text = $this->preg_grep_keys_values('~option_text~i', $row->all());
                                $textCount = count(array_filter($text));

                                if($textCount < 2) {
                                    return redirect()->back()->withInput()->with('dismiss', __('At least two options are required'));
                                }
                                $categoryLimit = Category::where('id', $row->category_id)->first()->max_limit;
                                $addedQuestion = Question::where('category_id', $row->category_id)->count();
                                if ($categoryLimit <= $addedQuestion) {
                                    return redirect()->back()->with('dismiss', __('Questions limit exceeded'));
                                }
                                $save = Question::create($data_list);
                                if ($save) {
                                    app(CommonService::class)->saveOptions($row,$save->id);
                                }
                            } else {
                                return redirect()->back()->with('dismiss', __('Data not found'));
                            }
                        }
                        if (empty($save)) {
                            return redirect()->back()->with('dismiss', __('No new row created'));
                        }
                    }
                } else {
                    return redirect()->back()->with('dismiss', __('File not found'));
                }
            } else {
                return redirect()->back()->with('dismiss', __('The excel file must be a file of type: xlsx, xls, csv.'));
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('dismiss', $e->getMessage());
//            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }

        return redirect()->route('questionList')->with('success',__('Upload successful'));
    }
}
