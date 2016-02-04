<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 14.09.14
 * Time: 18:06
 */

namespace Triggerdesign\Hermes\Models;


class EloquentBase extends \Eloquent {
    protected $table = "";


    public static function userClass(){

        return \Config::get('hermes::userClass', '\App\User');
    }

    public static function tableName($name){
    	if($name == 'users'){
    		return \Config::get('hermes::usersTable', 'users');
    	}    	
    	
        $prefix = \Config::get('hermes::tablePrefix', '');

      
        
        return $prefix . $name;
    }
    
    public static function modelPath($classname){
    	//This function is used so a developer can decide if he wants to extend 
    	//his own models or if he wants to use the original hermes models only
    	
    	if(class_exists($classname) )    	
    		return $classname;
    	else
    		return "\\Triggerdesign\\Hermes\\Models\\" . $classname;
    }


    function __construct(){
        //Table name is set as a protected value und the models
        $baseTableName = $this->table;

        //Rewrite with the correct prefix
        $this->table = static::tableName($baseTableName);
    }

    protected function getUser($user = null){
        if(!$user) {
            $getAuthUserMethod = \Config::get('hermes.getAuthUserMethod', '\Auth::user');
            eval('$user = '.$getAuthUserMethod.'();');
        }

        if(!$user){
            throw new \Exception('It is not possible to add a message without a valid user or login.');
        }

        return $user;
    }
} 