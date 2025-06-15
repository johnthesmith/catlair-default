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
//коротким вызвом или сделать сборку операцией веба после получения результата
//Файлы не читаются нет кота.
//И менюшки не октрываются нормально - нет контента и нет ошибки - надо понять причину


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
        Log out
        Set guest login for session and redirects to given URL (default '/').
        http://localhost/api-session/logout
    */
    public function logout
    (
        string $redirect = '/'
    )
    {
        /* Reset session */
        $this -> getApp() -> getSession() -> setLogin();
        /* Redirect */
        $this -> getApp() -> addHeader( 'Location: ' . $redirect );
        return $this;
    }



    /*
        Log in
        Sets login in session and redirects to given URL (default '/').
        http://localhost/api-session/login
        WARNING!!! this is example, method doesn't check the password.
        You need to override this method.
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
