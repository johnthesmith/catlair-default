<?php
/*
    Custom work with sessions
*/



namespace catlair;



/* Load web payload library */
require_once LIB . '/web/web_payload.php';



/*
    Api class declaration
*/
class SessionManager extends WebPayload
{
    /*
        Hello world method
    */
    public function hello_world()
    :self
    {
        return $this
        -> setContent( 'hellow world' );
    }



    /*
        Initialize session with config params
    */
    public function initSession
    (
        string $web__session__ssl_key = '',
        int $web__session__ttl_sec = 0,
    )
    : self
    {
        $this -> getApp() -> getSession()
        -> setTtlSec( $web__session__ttl_sec )
        -> setSslKey( $web__session__ssl_key )
        ;
        return $this;
    }
}
