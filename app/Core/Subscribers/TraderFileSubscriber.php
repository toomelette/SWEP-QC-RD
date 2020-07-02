<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class TraderFileSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('trader_file.store', 'App\Core\Subscribers\TraderFileSubscriber@onStore');
        $events->listen('trader_file.update', 'App\Core\Subscribers\TraderFileSubscriber@onUpdate');
        $events->listen('trader_file.destroy', 'App\Core\Subscribers\TraderFileSubscriber@onDestroy');

    }




    public function onStore($trader){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:trader_files:fetchByTraderId:'.$trader->trader_id.':*');

        $this->session->flash('TRADER_FILE_CREATE_SUCCESS', 'The File(s) has been successfully created!');

    }





    public function onUpdate($trader_file){


        $this->__cache->deletePattern(''. config('app.name') .'_cache:trader_files:fetchByTraderId:'.$trader_file->trader_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:trader_files:findBySlug:'. $trader_file->slug);

        $this->session->flash('TRADER_FILE_UPDATE_SUCCESS', 'The File has been successfully updated!');
        $this->session->flash('TRADER_FILE_UPDATE_SUCCESS_SLUG', $trader_file->slug);

    }



    public function onDestroy($trader_file){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:trader_files:fetchByTraderId:'.$trader_file->trader_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:trader_files:findBySlug:'. $trader_file->slug);

        $this->session->flash('TRADER_FILE_DELETE_SUCCESS', 'The File has been successfully deleted!');
        $this->session->flash('TRADER_FILE_DELETE_SUCCESS_SLUG', $trader_file->slug);

    }





}