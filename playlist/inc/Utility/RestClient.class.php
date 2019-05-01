<?php

class RestClient    {

    //This function calls the restAPI
    static function call($method, $callData)    {
            
        //Assemble an array with the request type
        $requestHeader = array('requesttype' => $method);

        $data = array_merge($requestHeader, $callData);
        

        //Assemble the options to pass to the stream creation
        $options = array('http' => array(
                                        'header' => 'Content-Type: application/x-www-form-urlencoded\r\n',
                                        'method' => $method,
                                        'content' => http_build_query($data)
                                    )
        );

        //Generate Context
        $context = stream_context_create($options);
        $result = file_get_contents(API_URL, false, $context);

        return $result;
    }

}