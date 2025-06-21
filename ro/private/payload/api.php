<?php
/*
    Default Payload API

    Provides methods:
        page — dynamic content from index.html
        make — generate content from any template
        read — send file without any modifications
*/



namespace catlair;



/* Load web payload library */
require_once LIB . '/web/web_payload.php';



/*
    Api class declaration
*/
class Api extends WebPayload
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
    public function page()
    {
        /* Prepare path */
        $uriPath = $this -> getUrl() -> getPath();
        /* Remove `api` from uri path */
        array_shift( $uriPath );

        $this
        /* Set default content index.html */
        -> setContent( $this -> getTemplate( 'index.html' ))
        /* Set content type */
        -> setContentType( Mime::HTML )
        /* Start building with arguments from uri-path */
        -> buildContent( self::getPathKeyValue( $uriPath ))
        ;

        return $this;
    }



    /*
        Content builder
    */
    public function make()
    {
        /* Remove `api/method` from uri path */
        $path = array_slice( $this -> getUrl() -> getPath(), 2 );
        /* Use other part of path */
        $path = \implode( '/', $path );

        return
        $this
        /* Set start template */
        -> setContent( $this -> getTemplate( $path ))
        /* Set content type */
        -> setContentType
        (
            Mime::fromExt( pathinfo( $path, PATHINFO_EXTENSION) )
        )
        -> buildContent();
    }



    /*
        Read and return static content
    */
    public function read()
    {
        /* Remove `api/method` from uri path */
        $path = array_slice( $this -> getUrl() -> getPath(), 2 );
        /* Use other part of path */
        $path = implode( '/', $path );

        /* Get file */
        $file = $this -> getFileAny( $path );

        if( !empty( $file ))
        {
            /* Read content file  and return it */
            $content = @file_get_contents( $file );
            $this -> setContent( $content );
            $this -> setContentType
            (
                Mime::fromExt( pathinfo( $file, PATHINFO_EXTENSION))
            );
        }
        else
        {
            /* File not found */
            $this -> setResult
            (
                'file-not-found',
                [ 'path' => $path ]
            );
        }
        return $this;
    }
}
