<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends SocialAuthController
{

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function redirectToProvider(Request $request)
    {
        if ($request->register == "true") {
            Session::put('register', 'true');
        }
        Socialite::driver('google')->stateless();

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @param Request $request
     * @return Response
     */
    public function handleProviderCallback()
    {
        $redirect = redirect('auth/login');
        if (Session::has('register')) {
            $redirect = redirect('auth/register');
            Session::forget('register');
        }
        try {
            Socialite::driver('google')->stateless();
            $user = Socialite::with('google')->user();
            $authUser = $this->findOrCreateUser($user, 'google');
            Auth::login($authUser, true);
        } catch (QueryException $queryException) {
            //Mail Repetido
            if ($queryException->errorInfo[1] == 1062) {
                return $redirect->withErrors(['exception' => 'El mail asociado a la red social ya está en uso']);
            }
        } catch
        (\Exception $ex) {
            return $redirect->withErrors(['exception' => 'Ha ocurrido un error inesperado']);
        }

        return redirect(property_exists($this, 'redirectPath') ? $this->redirectPath : '/');
    }
}
