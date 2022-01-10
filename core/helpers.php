<?php


if(!function_exists('view'))
{
    function view($path, $data = null)
    {
        if(count(func_get_args()) === 0){
            return throw new Exception("View name is required.", 1);
        }

        if(count(func_get_args()) > 1){
            
            if($data && is_array($data)){
                extract($data);
            }
            
            ob_start();
        }

        if($data){
            ob_get_clean();
        }

        try{
            if(file_exists(_VIEW_DIR_ . '/' . $path . '.php') && is_file(_VIEW_DIR_ . '/' . $path . '.php')){
                require _VIEW_DIR_ . '/' . $path . '.php';
            }else{
                echo "<p>View <code>{$path}.php</code> not found.<p>";
            }
        }catch(Exception $e){
            echo "<p>View <code>{$path}.php</code> not found.<p> ". $e->getMessage();
        }
    }
}

/**
 * simple function to load env variables
 */

 if(!function_exists('env'))
 {
     function env($key = null, $default = "")
     {
        $path = _BASE_DIR_ . '/.env';
        $env = [];
        foreach(parse_ini_file($path) as $k => $value) {
            $env[$k] = $value;
        }

        return $env[$key] ?? $default;
     }
 }

 if(!function_exists('edit_env'))
 {
     function edit_env($key = "", $value = null)
     {
         if(count(func_get_args()) === 0) {
             return ;
         }
        
        $path = _BASE_DIR_ . '/.env';

        file_put_contents($path, str_replace(
            $key.'='.env($key), $key.'='.$value, file_get_contents($path)
        ));

        return true;
     }
 }
