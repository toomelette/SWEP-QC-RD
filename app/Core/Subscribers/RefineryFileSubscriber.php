<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class RefineryFileSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('refinery_file.store', 'App\Core\Subscribers\RefineryFileSubscriber@onStore');
        $events->listen('refinery_file.update', 'App\Core\Subscribers\RefineryFileSubscriber@onUpdate');
        $events->listen('refinery_file.destroy', 'App\Core\Subscribers\RefineryFileSubscriber@onDestroy');

    }




    public function onStore($refinery){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refinery_files:fetchByRefineryId:'.$refinery->refinery_id.':*');

        $this->session->flash('REFINERY_FILE_CREATE_SUCCESS', 'The File(s) has been successfully created!');

    }





    public function onUpdate($refinery_file){


        $this->__cache->deletePattern(''. config('app.name') .'_cache:refinery_files:fetchByRefineryId:'.$refinery_file->refinery_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refinery_files:findBySlug:'. $refinery_file->slug);

        $this->session->flash('REFINERY_FILE_UPDATE_SUCCESS', 'The File has been successfully updated!');
        $this->session->flash('REFINERY_FILE_UPDATE_SUCCESS_SLUG', $refinery_file->slug);

    }



    public function onDestroy($refinery_file){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:refinery_files:fetchByRefineryId:'.$refinery_file->refinery_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refinery_files:findBySlug:'. $refinery_file->slug);

        $this->session->flash('REFINERY_FILE_DELETE_SUCCESS', 'The File has been successfully deleted!');
        $this->session->flash('REFINERY_FILE_DELETE_SUCCESS_SLUG', $refinery_file->slug);

    }





}