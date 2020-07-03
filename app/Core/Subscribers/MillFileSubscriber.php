<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class MillFileSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('mill_file.store', 'App\Core\Subscribers\MillFileSubscriber@onStore');
        $events->listen('mill_file.update', 'App\Core\Subscribers\MillFileSubscriber@onUpdate');
        $events->listen('mill_file.destroy', 'App\Core\Subscribers\MillFileSubscriber@onDestroy');

    }




    public function onStore($mill){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:mill_files:fetchByMillId:'.$mill->mill_id.':*');

        $this->session->flash('MILL_FILE_CREATE_SUCCESS', 'The File(s) has been successfully created!');

    }





    public function onUpdate($mill_file){


        $this->__cache->deletePattern(''. config('app.name') .'_cache:mill_files:fetchByMillId:'.$mill_file->mill_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:mill_files:findBySlug:'. $mill_file->slug);

        $this->session->flash('MILL_FILE_UPDATE_SUCCESS', 'The File has been successfully updated!');
        $this->session->flash('MILL_FILE_UPDATE_SUCCESS_SLUG', $mill_file->slug);

    }



    public function onDestroy($mill_file){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:mill_files:fetchByMillId:'.$mill_file->mill_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:mill_files:findBySlug:'. $mill_file->slug);

        $this->session->flash('MILL_FILE_DELETE_SUCCESS', 'The File has been successfully deleted!');
        $this->session->flash('MILL_FILE_DELETE_SUCCESS_SLUG', $mill_file->slug);

    }





}