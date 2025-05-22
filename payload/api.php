<?php
/*
    Default payload api
*/


namespace catlair;



/* Load web payload library */
include LIB . '/web/web_payload.php';
include LIB . '/web/builder.php';



/*
    Api class declaration
*/
class Api extends WebPayload
{
    /*
        Default content
    */
    public function default_content()
    {
        $this -> setContent
        (
            $this -> getTemplate( 'index.html' )
        );
        return $this;
    }



    /*
        Read and return static content
    */
    public function read_content()
    {
        $path = implode( '/', $this -> getApp() -> getPath());
        $file = $this -> getFileAny( $path );
        $content = @file_get_contents( $file );
        $this -> setContent( $content );
    }



    /*
        Build dynamic content
    */
    public function make_content()
    {
        $index = $this -> getApp() -> getParam( ['web','index'], 'index.html' );

        $content = $this -> getTemplate( $index );

        ;
        $this -> setContent( Builder::create() -> buildContent( $content ) );
//
//        $tempalte = $this -> getTemplate
//        (
//            implode( '/', $this -> getApp() -> getPath())
//        );
//        $this -> setContent( $tempalte );
    }
}
