<?php
/**
 * Authorize - A Controller for managing the User Authentication.
 *
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 */

namespace App\Modules\Users\Controllers;

use Nova\Helpers\ReCaptcha;

use App\Core\BackendController;
use App\Models\Role;
use App\Models\User;

use Auth;
use Config;
use Hash;
use Input;
use Mailer;
use Redirect;
use Session;
use Validator;
use View;


class Registrar extends BackendController
{
    protected $layout   = 'default';


    protected function validate(array $data)
    {
        // Validation rules.
        $rules = array(
            'realname' => 'required|valid_name',
            'username' => 'required|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed'
        );

        $messages = array(
            'valid_name'      => __d('users', 'Le champ :attribute n\'est pas valide'),
            'strong_password' => __d('users', 'Le champ :attribute n\'est pas assez fort'),
            'required' => __d('users', 'Le champ :attribute est requis'),
            'confirmed' => __d('users', 'Les deux mots de passe ne correspondent pas'),
            'email' => __d('users', 'Le format de l\'e-mail est invalide'),
            'unique' => __d('users', 'Le :attribute est déjà pris')
        );

        $attributes = array(
            'username' => __d('users', 'Nom d\'utilisateur'),
            'realname' => __d('users', 'Nom et Prénom'),
            'email'    => __d('users', 'E-mail'),
            'password' => __d('users', 'Mot de passe'),
        );

        // Add the custom Validation Rule commands.
        Validator::extend('valid_name', function($attribute, $value, $parameters)
        {
            $pattern = '~^(?:[\p{L}\p{Mn}\p{Pd}\'\x{2019}]+(?:$|\s+)){2,}$~u';

            return (preg_match($pattern, $value) === 1);
        });

        Validator::extend('strong_password', function($attribute, $value, $parameters)
        {
            $pattern = "/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/";

            return (preg_match($pattern, $value) === 1);
        });

        return Validator::make($data, $rules, $messages, $attributes);
    }

    /**
     * Display the register view.
     *
     * @return \Core\View
     */
    public function create()
    {
        return $this->getView()
            ->shares('title', __d('users', 'User Registration'));
    }

    /**
     * Handle a POST request to login the User.
     *
     * @return Response
     *
     * @throws \RuntimeException
     */
    public function store()
    {
        $input = Input::only(
            'username',
            'realname',
            'email',
            'password',
            'password_confirmation'
        );

        // Verify the submitted reCAPTCHA
        if(! ReCaptcha::check()) {
            $status = __d('users', 'Invalid reCAPTCHA submitted.');

            return Redirect::back()->withStatus($status, 'danger');
        }

        // Create a Validator instance.
        $validator = $this->validate($input);

        if ($validator->fails()) {
            // Errors occurred on Validation.
            $status = $validator->errors();

            return Redirect::back()->withInput()->withStatus($status, 'danger');
        }

        // Encrypt the given Password.
        $password = Hash::make($input['password']);

        // Create the Activation code.
        $email = $input['email'];

        $token = $this->createNewToken($email);

        // Retrieve the default 'user' Role.
        $role = Role::where('slug', 'user')->first();

        if($role === null) {
            throw new \RuntimeException('Default Role not found.');
        }

        // Create the User record.
        $user = User::create(array(
            'username'        => $input['username'],
            'realname'        => $input['realname'],
            'email'           => $email,
            'password'        => $password,
            'activation_code' => $token,
            'role_id'         => $role->getKey(),
        ));

        // Send the associated Activation E-mail.
        Mailer::send('Emails/Auth/Activate', array('token' => $token), function($message) use ($user)
        {
            $subject = __d('users', 'Activate your Account!');

            $message->to($user->email, $user->realname);

            $message->subject($subject);
        });

        // Prepare the flash message.
        $status = __d('users', 'Your Account has been created. We have sent you an E-mail to activate your Account.');
        $msg = "<br><a href=\"".site_url("/register/verify/".$token)."\" class=\"btn btn-primary\" role=\"button\">Activate your Account</a>";
        return Redirect::to('register/status')->withStatus($status.$msg);
    }

    /**
     * Display the password reminder view.
     *
     * @return Response
     */
    public function verify($token)
    {
        $user = User::where('activation_code', $token)->where('active', '=', 0);

        // If the User is available.
        if ($user->count()) {
            $user = $user->first();

            // Update the User status to active.
            $user->active = 1;

            $user->activation_code = null;

            if ($user->save()) {
                // Prepare the flash message.
                $status = __d('users', 'Activated! You can now Sign in!');

                return Redirect::to('login')->withStatus($status);
            }
        }

        $status = __d('users', 'We could not activate your Account. Try again later.');

        return Redirect::to('register/status')->withStatus($status);
    }

    public function status()
    {
        return $this->getView()
            ->shares('title', __d('users', 'Registration Status'));
    }

    /**
     * Create a new Token for the User.
     *
     * @param  string $email
     * @return string
     */
    public function createNewToken($email)
    {
        $value = str_shuffle(sha1($email .spl_object_hash($this) .microtime(true)));

        return hash_hmac('sha256', $value, Config::get('app.key'));
    }
}
