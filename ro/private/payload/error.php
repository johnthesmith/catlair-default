<?php
/*
    Error payload
*/



namespace catlair;



/* Load web payload library */
require_once LIB . '/web/web_payload.php';



/*
    Api class declaration
*/
class Error extends WebPayload
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
        Builds dynamyc content.
        It gets `index.html` and builds it using the URI and templates.
    */
    public function postprocessing()
    {
        exit(1);
        if( !$this -> getApp() -> isOk() )
        {
            $this
            -> setContent( 'ERROR' )
            -> setContentType( Mime::HTML );
        }
        return $this;
    }
}
