<?php
/*
    API methods for session

    Реализует UI для авторизации включая:
    - вывод формы авториацзии
*/



namespace catlair;



/* Load web payload library */
require_once LIB . '/web/web_payload.php';
include_once LIB . '/web/web_builder.php';



/*
    Api session class declaration
*/
class Auth extends WebPayload
{
    /*
        Return authorization form content
    */
    public function login_form()
    {
        return $this
        -> setContent
        (
            $this -> getTemplate
            (
                $this -> getApp() -> getSession() -> isGuest()
                ? 'session/login.html'
                : 'session/logout.html'
            )
        )
        -> buildContent
        (
            [ 'login' => $this -> getApp() -> getSession() -> getLogin()]
        );
    }


    /*
        Log in
        Sets login in session and redirects to given URL (default '/').
        http://localhost/api-session/login

        Example:
        размести в контенте вызов данной формы
        <cl payload="api-session" redirect="/">
    */
    public function login
    (
        /* Login from get | post */
        string $login = '',
        string $password = '',
        /* Redirect url after succesful login */
        string $redirect = '/'
    )
    {
        /* Reset session */
        $this -> getApp() -> getSession() -> setLogin( $login );
        /* Redirect */
        $this -> getApp() -> addHeader( 'Location: ' . $redirect );
        return $this;
    }



    /*
        Log out
        Set guest login for session and redirects to given URL (default '/').
        http://localhost/api-session/logout
    */
    public function logout
    (
        /* Redirect url after logout */
        string $redirect = '/'
    )
    {
        /* Reset session */
        $this -> getApp() -> getSession() -> setLogin();
        /* Redirect */
        $this -> getApp() -> addHeader( 'Location: ' . $redirect );
        return $this;
    }

}
