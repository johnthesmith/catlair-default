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
        Builds static content.
        It gets `index.html` and builds it using the URI and templates.
    */
    public function pageСontent()
    {
        /* Get path */
        $path = self::getPathKeyValue( $this -> getApp() -> getPath());
        return $this
        /* Set default content */
        -> setContent( $this -> getTemplate( 'index.html' ))
        /* Build content from loaded index.html */
        -> buildContent( $path );
    }



    /*
        Content builder
    */
    public function makeContent()
    {
        /* Get path */
        $path = $this -> getApp() -> getPath();
        array_shift( $path );
        $path = \implode( '/', $path );

        return
        $this
        -> setContent( $this -> getTemplate( $path ))
        -> buildContent();
    }



    /*
        Read and return static content
    */
    public function readСontent()
    {
        /* Get path */
        $path = $this -> getApp() -> getPath();
        /* Remove first element */
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
        }
        else
        {
            /* File not found */
            $this -> setResult( 'content-not-found', [ 'path' => $path ]);
        }
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
