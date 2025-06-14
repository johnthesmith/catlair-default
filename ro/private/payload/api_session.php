<?php
/*
    API methods for session
*/



namespace catlair;



/* Load web payload library */
require_once LIB . '/web/web_payload.php';
include_once LIB . '/web/web_builder.php';



/*
    Api session class declaration
*/
class ApiSession extends WebPayload
{
    /*
        Hello world method
    */
    public function hello_world()
    {
        return $this
        -> setContent( 'hellow world' );
    }



    /*
        Return authorization form content
    */
    public function auth_form()
    {
        return
        $this -> setContent
        (
            $this -> getTemplate
            (
                $this -> getApp() -> getSession() -> isGuest()
                ? 'session/login.html'
                : 'session/logout.html'
            ) . $this -> getApp() -> getSession() -> getLogin()
        );
    }



    /*
        Log out
        Resets session and redirects to given URL (default '/').
        http://localhost/api-session/logout
    */
    public function logout
    (
        string $redirect = '/'
    )
    {
        /* Reset session */
        $this -> getApp() -> getSession() -> reset();
        /* Redirect */
        $this -> getApp() -> addHeader( 'Location: ' . $redirect );
        return $this;
    }



    /*
        Log in
        Sets login in session and redirects to given URL (default '/').
        http://localhost/api-session/logout
    */
    public function login
    (
        string $login = '',
        string $password = '',
        string $redirect = '/'
    )
    {
        /* Reset session */
        $this -> getApp() -> getSession() -> setLogin( $login );
        /* Redirect */
        $this -> getApp() -> addHeader( 'Location: ' . $redirect );
        return $this;
    }
}
