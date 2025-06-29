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
class Flow extends WebPayload
{
    /*
        Initialize session with config params
    */
    public function init
    (
        /* SSL key for session web.session.ssl.key */
        string $web__session__ssl_key = '',
        /* SSession time to life at seconds */
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



    /*
        Builds dynamyc content.
        It gets `index.html` and builds it using the URI and templates.
    */
    public function postprocessing()
    {
        $this -> setResult('sdf');
//print_r('!!!!!!!!!!!!!');
//exit(1);
//        if( !$this -> isOk()  )
//        {
////            $this
////            -> setContent( 'ERROR' )
////            -> setContentType( Mime::HTML );
//        }
        return $this;
    }
}
