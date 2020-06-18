<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class TraderRegistrationSubscriber extends BaseSubscriber{



    public function __construct(){
        parent::__construct();
    }



    public function subscribe($events){

        $events->listen('trader_reg.destroy', 'App\Core\Subscribers\TraderRegistrationSubscriber@onDestroy');

    }



    public function onDestroy($trader_reg){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:traders:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:trader_registrations:isTraderExistInCY_CAT:'.$trader_reg->crop_year_id.':'.$trader_reg->trader_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:trader_registrations:findBySlug:'. $trader_reg->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:trader_registrations:fetchByTraderId:'. $trader_reg->trader_id .':*');

        $this->session->flash('TRADER_REG_DELETE_SUCCESS', 'The Trader License has been successfully deleted!');
        $this->session->flash('TRADER_REG_DELETE_SUCCESS_SLUG', $trader_reg->slug);

    }



}