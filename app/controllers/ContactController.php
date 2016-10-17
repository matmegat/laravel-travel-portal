<?php

class ContactController extends BaseController
{
    protected $pageId = 8;

    public function __construct()
    {
        //page ID = 8

        $data = DB::select('select * from page_social');
        View::share('social', $data[0]);
        View::share('active_tab', 'contact');
        View::share('weekday', strtoupper(date('l')));
    }
    public function index()
    {
        $page = Contact::all();

        return View::make('contact.index', ['page' => $page[0]]);
    }

    public function sendContactForm()
    {
        $data = Input::all();

        // input validator with its rules
        $validator = Validator::make(
            [
                'lastname' => $data['lastname'],
                'firstname' => $data['firstname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ],
            [
                'lastname' => 'required|min:3',
                'firstname' => 'required|min:3',
                'email' => 'required|email',
                'phone' => 'required|min:5',
            ]
        );

        if ($validator->passes()) {
            // data is valid
            Mail::send('emails.contact.form', [
                'data' => $data,
            ], function ($message) use ($data) {
                $message
                    ->to($data['send_email'])
                    ->subject('CONTACT FORM [visits]');
            });

            //Redirect to contact page
            return Redirect::to('/contact')->with('success', true)->with('message', 'That was great!');
        } else {
            // data is invalid

            $errors = $validator->errors()->getMessages();
            $errorMessage = '';
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    if (isset($error[0]) && is_string($error[0])) {
                        $errorMessage .= $error[0].'<br>';
                    }
                }
            }

            return Redirect::to('/contact')->with('error', true)->with('message', $errorMessage);
        }
    }

    public function editProcess($id)
    {
        $data = Input::all();
        $page = Contact::find(1);

        $page->text_preview = $data['text_preview'];
        $page->phone = $data['phone'];
        $page->add_phone = $data['add_phone'];
        $page->country = $data['country'];
        $page->city = $data['city'];
        $page->address = $data['address'];
        $page->email = $data['email'];

        $page->save();

        $page = PageContent::where('page_id', '=', $id)->get();
        $page = PageContent::find($page[0]->id);

        $page->keywords = $data['page']['keywords'];
        $page->description = $data['page']['description'];
        $page->save();

        return Redirect::back();
    }
}
