<?php
/**
 * Created by PhpStorm.
 * User: rana
 * Date: 8/3/17
 * Time: 4:52 PM
 */

namespace App\Services;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class MailService
{
    protected $defaultEmail;
    protected $defaultName;

    public function __construct()
    {
        $default = $data['adm_setting'] = allsetting();
        $this->defaultEmail = "ico@email.com";
        $this->defaultName = allsetting()['app_title'];
    }


    public function send($template = '', $data = [], $to = '', $name = '', $subject = '')
    {
        try {
            Mail::send($template, $data, function ($message) use ($name, $to, $subject) {
                $message->to($to, $name)->subject($subject)->replyTo(
                    $this->defaultEmail, $this->defaultName
                );
                $message->from($this->defaultEmail, $this->defaultName);

            });
            return true;
        }catch (\Exception $e){
            return $e->getMessage();
//            Session::flash('dismiss', 'Unavailable email service!');
        }
    }

}