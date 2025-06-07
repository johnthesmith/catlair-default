<?php
/*
    Default payload api
*/



namespace catlair;



/* Load web payload library */
include LIB . '/web/web_payload.php';
include LIB . '/web/web_builder.php';



/*
    Api class declaration
*/
class Api extends WebPayload
{
    /*
        Builds dynamyc content.
        It gets `index.html` and builds it using the URI and templates.
    */
    public function page()
    {
        return $this
        /* Set default content index.html */
        -> setContent( $this -> getTemplate( 'index.html' ))
        /* Set content type */
        -> setContentType( Mime::HTML )
        /* Start building with arguments from uri-path */
        -> buildContent
        (
            self::getPathKeyValue( $this -> getUrl() -> getPath())
        );
    }



    /*
        Content builder
    */
    public function make()
    {
        /* Prepare path */
        $uriPath = $this -> getUrl() -> getPath();
        /* Remove `make` from uri path */
        array_shift( $uriPath );
        /* Use other part of path */
        $path = \implode( '/', $uriPath );

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
        /* Get path */
        $path = $this -> getUrl() -> getPath();
        /* Remove first element 'file' */
        array_shift( $path );
        /* Use other part of path */
        $path = implode( '/', $path );
        /* Get file */
        $file = $this -> getContentFileAny( $path );

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
                'content-not-found',
                [ 'path' => $path ]
            );
        }
        return $this;
    }



    /*
        Log out
    */
    public function logout()
    {
        $this -> getApp() -> setDefaultUrl() -> getSession() -> reset();
        $this -> page();

        return $this;
    }



    /**************************************************************************
        Protected utility methods
    */


    /*
        Content builder
    */
    protected function buildContent
    (
        array $aArgs = []
    )
    {
        /* Build params from path */
        $builder =
        WebBuilder::create( $this )
        -> setContent( $this -> getContent())
        -> setContentType( $this -> getContentType() )
        -> setIncome
        (
            array_merge
            (
                $aArgs,
                $_COOKIE,
                $_GET,
                $_POST,
            )
        )
        -> build();

        return $this
        -> setContentType( $builder -> getContentType())
        -> setContent( $builder -> getContent());
    }
}
