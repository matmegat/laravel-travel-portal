<?php

class AwardAdminController extends BaseAdminController
{
    protected $upload_dir;
    protected $upload_uri;

    public function __construct()
    {
        $this->upload_uri = '/uploads/award/';
        $this->upload_dir = public_path($this->upload_uri);

        View::share('upload_dir', $this->upload_dir);
        View::share('upload_uri', $this->upload_uri);
    }

    protected function getAwardItem($id)
    {
        $news = Award::where('id', $id)->withTrashed()->first();

        if (!$news) {
            App::abort(404, 'Award not found');
        }

        return $news;
    }

    protected function getAwardList()
    {
        $query = Award::query();

        return $query;
    }

    public function manageAll()
    {
        $news = $this->getAwardList()->withTrashed()->orderBy('created_at', 'desc')->paginate(15);

        return View::make('admin.award.manage', ['award' => $news, 'award_show_all' => true]);
    }

    public function manage()
    {
        $news = $this->getAwardList()->orderBy('created_at', 'desc')->paginate(15);

        //var_dump($news); exit;
        return View::make('admin.award.manage', ['award' => $news]);
    }

    public function postSaveSettings()
    {
        $post = Input::all();

        if (array_key_exists('dbsettings', $post)) {
            DBconfig::setGroup($post['dbsettings']);
        }

        if (isset($post['award_background_delete'])) {
            @unlink(public_path($this->upload_uri.'header.png'));
        }

        if (isset($post['award_background']) && !is_null($post['award_background'])) {
            $rules = [
                'award_background' => ['max:10000', 'image', 'mimes:jpeg,gif,png'],
            ];
            $validator = Validator::make($post, $rules);

            if ($validator->passes()) {
                // upload the file
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $post['award_background'];
                $file->move($this->upload_dir, 'header.png');

                return Redirect::back()
                    ->withSuccess('Saved');
            } else {
                return Redirect::back()
                    ->withInput()
                    ->withErrors($validator->errors());
            }
        }

        return Redirect::back();
    }

    public function restore($id)
    {
        $item = $this->getAwardItem($id);

        $item->restore();

        return Redirect::back();
    }

    public function delete($id)
    {
        $item = $this->getAwardItem($id);

        $item->delete();

        return Redirect::back();
    }

    public function add()
    {
        return View::make('admin.award.add');
    }

    public function addProcess()
    {
        $attributes = Input::get('award');

        $validate = $this->_validateImage(Input::get('main_image'));

        if (!$validate->passes()) {
            return Redirect::back()->withErrors($validate)->withInput();
        }

        $attributes['user_id'] = Sentry::getUser()->id;

        $attributes['slug'] = Str::slug($attributes['title']);
        $item = Award::create($attributes);

        $this->_uploadImageForPost($item, Input::file('main_image'));

        return Redirect::action('AwardAdminController@edit', ['id' => $item->id]);
    }

    public function edit($id)
    {
        $item = \services\Award::getAwardData($id);
        //$item = $this->getNewsItem($id);

        return View::make('admin.award.edit', [
            'item' => $item,
        ]);
    }

    public function editProcess($id)
    {
        if (!$newsData = \services\Award::getAwardData($id)) {
            App::abort(404, 'News not found');
        }

        $newsData = array_merge((array) $newsData, Input::get('award'));

        if ($photosCaptions = Input::get('photos_captions')) {
            $newsData['photosCaptions'] = $photosCaptions;
        }

        if ($photo = Input::file('photo')) {
            //$validate = $this->_validateImage(Input::get('photo'));
            //if (!$validate->passes()) {
            //    return Redirect::back()->withErrors($validate)->withInput();
            //}

            $newsData['photo'] = $photo;
        }

        if ($removePhotos = Input::get('remove_photos')) {
            \services\Award::removePhotos($id, array_keys($removePhotos));
        }

        \services\Award::setAwardData($id, $newsData);

        return Redirect::back();
    }

    private function _validateImage($image)
    {
        $images = [
            'main_image' => $image,
        ];

        $rules = [
            'main_image' => 'image',
        ];

        $messages = [];

        return Validator::make($images, $rules, $messages);
    }

    private function _uploadImageForPost($postItem, $imageFile)
    {
        if (empty($imageFile)) {
            return false;
        }

        // TODO: optimize storage for images. Remove this simplified uploader
        $destinationPath = $this->upload_dir.$postItem->id.'/'; // The destination were you store the image.
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath);
        }

        return $imageFile->move($destinationPath, 'main_image.jpg'); // Now we move the file to its new home.
    }
}
