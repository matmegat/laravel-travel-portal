<?php


class UserController extends BaseController
{
    public function __construct()
    {
        $data = DB::select('select * from page_social');
        View::share('social', $data[0]);
        View::share('active_tab', 'user');
    }

    public function delete($id)
    {
        $user = Sentry::findUserById($id);

        if (!$user) {
            App::abort(404, 'User not found');
        }

        $user->delete();

        return Redirect::back()->with('message', 'User deleted');
    }

    public function create()
    {
        $groups = Sentry::findAllGroups();

        $groupsSelect = [];
        foreach ($groups as $group) {
            $groupsSelect[ $group->id ] = $group->name;
        }

        return View::make('users.create', ['groups' => $groupsSelect]);
    }

    public function createProcess()
    {
        try {
            // Let's register a user.
            $user = Sentry::register([
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
            ]);

            $userGroup = Sentry::findGroupById(Input::get('group'));
            $user->addGroup($userGroup);

            // Let's get the activation code
            $activationCode = $user->getActivationCode();

            //and activate the user immediately
            if (!$user->attemptActivation($activationCode)) {
                throw new Exception('Unable to activate the user');
            }
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return Redirect::back()->with('error', 'Login field is required')->withInput();
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            return Redirect::back()->with('error', 'Password field is required.')->withInput();
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            return Redirect::back()->with('error', 'User with this login already exists.')->withInput();
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage())->withInput();
        }

        return Redirect::action('UserController@edit', ['id' => $user->id]);
    }

    public function edit($id)
    {
        $user = Sentry::findUserById($id);

        if (!$user) {
            App::abort(404, 'User not found');
        }

        $groups = Sentry::findAllGroups();

        $groupsSelect = [];
        foreach ($groups as $group) {
            $groupsSelect[ $group->id ] = $group->name;
        }

        $userGroup = 0;
        foreach ($user->groups as $group) {
            $userGroup = $group->id;
        }

        return View::make('users.edit', ['user' => $user, 'groups' => $groupsSelect, 'userGroup' => $userGroup]);
    }

    public function activated()
    {
        return View::make('users.activated');
    }

    public function activate($id, $code)
    {
        try {
            // Find the user using the user id
            $user = Sentry::findUserById($id);

            // Attempt to activate the user
            if ($user->attemptActivation($code)) {
                return Redirect::to('user/activated');
            } else {
                // User activation failed
                $error = 'User activation failed';
            }
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $error = 'User was not found.';
        } catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e) {
            $error = 'User is already activated.';
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        return View::make('users.activate-error', ['error' => $error]);
    }

    public function reset()
    {
        return View::make('users.reset');
    }

    public function resetContinue($id, $code)
    {
        try {
            // Find the user using the user id
            $user = Sentry::findUserById($id);

            // Check if the reset password code is valid
            if ($user->checkResetPasswordCode($code)) {
                // Attempt to reset the user password
                if ($user->attemptResetPassword($code, Input::get('password'))) {
                    return Redirect::action('UserController@login')->with('message', 'Password has been reset successfully');
                } else {
                    throw new Exception('Password reset failed');
                }
            } else {
                throw new Exception('Reset code is invalid');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        return Redirect::back()->with('error', $error);
    }

    public function resetCode($id, $code)
    {
        try {
            // Find the user using the user id
            $user = Sentry::findUserById($id);

            // Check if the reset password code is valid
            if ($user->checkResetPasswordCode($code)) {
                return View::make('users.reset-continue', [
                    'user_id' => $id,
                    'code' => $code,
                ]);
                // Attempt to reset the user password
                /*if ($user->attemptResetPassword($code, 'new_password'))
                {
                    // Password reset passed
                }
                else
                {
                    // Password reset failed
                }*/
            } else {
                throw new Exception('Reset code is invalid');
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        return View::make('users.reset-error', ['error' => $error]);
    }

    public function resetEmailed()
    {
        return View::make('users.reset-emailed');
    }

    public function resetProcess()
    {
        try {
            $user = Sentry::findUserByLogin(Input::get('email'));

            // Get the password reset code
            $resetCode = $user->getResetPasswordCode();

            Mail::send('emails.users.reset', [
                'reset_code' => $resetCode,
                'user' => $user,
            ], function ($message) use ($user) {
                $message
                    ->to($user->email, $user->first_name.' '.$user->last_name)
                    ->subject('Password Reset');
            });
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage())->withInput();
        }

        return Redirect::action('UserController@resetEmailed');
    }

    public function register()
    {
        return View::make('users.register');
    }

    public function registerProcess()
    {
        try {
            // Let's register a user.
            $user = Sentry::register([
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
            ]);

            $userGroup = Sentry::findGroupByName('user');
            $user->addGroup($userGroup);

            // Let's get the activation code
            $activationCode = $user->getActivationCode();

            Mail::send('emails.users.activate', [
                'activation_code' => $activationCode,
                'user' => $user,
            ], function ($message) {
                $message
                    ->to(Input::get('email'), Input::get('first_name').' '.Input::get('last_name'))
                    ->subject('Account Activation');
            });
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return Redirect::back()->with('error', 'Login field is required')->withInput();
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            return Redirect::back()->with('error', 'Password field is required.')->withInput();
        } catch (Cartalyst\Sentry\Users\UserExistsException $e) {
            return Redirect::back()->with('error', 'User with this login already exists.')->withInput();
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage())->withInput();
        }

        return Redirect::to('user/confirm');
    }

    public function confirm()
    {
        return View::make('users.register-confirm');
    }

    public function manage()
    {
        $users = Sentry::with('groups')->orderBy('created_at', 'desc')->paginate(30);
        //var_dump($users); exit;
        return View::make('users.manage', ['users' => $users]);
    }

    public function profile()
    {
        return View::make('users.profile', ['user' => Sentry::getUser()]);
    }

    public function updatePassword($id = null)
    {
        $user = Sentry::getUser();

        if ($id) {
            if (!$user->hasAccess('admin')) {
                App::abort(401, 'Access denied');
            }

            $user = Sentry::findUserById($id);

            if (!$user) {
                App::abort(404, 'User not found');
            }
        }

        if ($id || $user->checkPassword(Input::get('old_password'))) {
            $user->password = Input::get('password');

            try {
                $user->save();

                return Redirect::back()->with('message', 'Password updated');
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        } else {
            $error = 'Old password incorrect';
        }

        return Redirect::back()->with('error', $error);
    }

    public function saveProfile($id = null)
    {
        $user = Sentry::getUser();

        if ($id) {
            if (!$user->hasAccess('admin')) {
                App::abort(401, 'Access denied');
            }

            $user = Sentry::findUserById($id);

            if (!$user) {
                App::abort(404, 'User not found');
            }
        }

        try {
            $group = Input::get('group', null);

            if ($group && Sentry::getUser()->hasAccess('admin')) {
                $user->groups()->sync([$group]);
            }

            $user->update(Input::except(['group']));

            return Redirect::back()->with('message', 'Profile updated');
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        return Redirect::back()->with('error', $error);
    }

    public function logout()
    {
        Sentry::logout();

        return Redirect::to('/');
    }

    public function login()
    {
        if (Sentry::check()) {
            return Redirect::to('/');
        }

        return View::make('users.login');
    }

    public function loginProcess()
    {
        try {
            // Set login credentials
            $credentials = [
                'email' => Input::get('email'),
                'password' => Input::get('password'),
            ];

            // Try to authenticate the user
            Sentry::authenticate($credentials, Input::get('remember') == 'yes');

            if (Input::get('back', 0) == '1') {
                return Redirect::back();
            } else {
                return Redirect::intended('/admin');
            }
        } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
            $error = 'Login field is required.';
        } catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            $error = 'Password field is required.';
        } catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
            $error = 'Wrong password, try again.';
        } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
            $error = 'User was not found.';
        } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            $error = 'User is not activated.';
        } catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            $error = 'User is suspended.';
        } catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
            $error = 'User is banned.';
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        return Redirect::back()->with('error', $error)->withInput();
    }
}
