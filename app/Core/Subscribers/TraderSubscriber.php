<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class TraderSubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('trader.store', 'App\Core\Subscribers\TraderSubscriber@onStore');
        $events->listen('trader.update', 'App\Core\Subscribers\TraderSubscriber@onUpdate');
        $events->listen('trader.destroy', 'App\Core\Subscribers\TraderSubscriber@onDestroy');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:traders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:traders:getAll');

        $this->session->flash('TRADER_CREATE_SUCCESS', 'The Trader has been successfully created!');

    }





    public function onUpdate($trader){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:traders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:traders:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:traders:getByTraderId:'.$trader->trader_id.'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:traders:findBySlug:'. $trader->slug .'');

        $this->session->flash('TRADER_UPDATE_SUCCESS', 'The Trader has been successfully updated!');
        $this->session->flash('TRADER_UPDATE_SUCCESS_SLUG', $trader->slug);

    }



    public function onDestroy($trader){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:traders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:traders:getAll');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:traders:getByTraderId:'.$trader->trader_id.'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:traders:findBySlug:'. $trader->slug .'');

        $this->session->flash('TRADER_DELETE_SUCCESS', 'The Trader has been successfully deleted!');
        $this->session->flash('TRADER_DELETE_SUCCESS_SLUG', $trader->slug);

    }





}