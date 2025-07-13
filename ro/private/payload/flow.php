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
        $this -> getApp()
        -> getSession()
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
        if( !$this -> isOk()  )
        {
            $code = $this -> getCode();

            http_response_code( 500 );
            header( "X-App-Error-Code: " . $code );

            $this
            /* Set default content index.html */
            -> setContent( $this -> getTemplate( 'index.html' ))
            /* Set content type */
            -> setContentType( Mime::HTML )
            /* Set result code */
            -> setOk()

            -> buildContent([ 'page' => 'errors/500.html', 'code' => $code ])
            ;
        }
        return $this;
    }
}
