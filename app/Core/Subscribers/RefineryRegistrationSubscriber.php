<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class RefineryRegistrationSubscriber extends BaseSubscriber{



    public function __construct(){
        parent::__construct();
    }



    public function subscribe($events){

        $events->listen('refinery_reg.destroy', 'App\Core\Subscribers\RefineryRegistrationSubscriber@onDestroy');

    }



    public function onDestroy($refinery_reg){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:refineries:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refineries:findBySlug:'. optional($refinery_reg->refinery)->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refinery_registrations:isRefineryExistInCY:'.$refinery_reg->crop_year_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refinery_registrations:fetchByRefineryId:'. $refinery_reg->refinery_id .':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refinery_registrations:findBySlug:'. $refinery_reg->slug);

        $this->session->flash('REFINERY_REG_DELETE_SUCCESS', 'The Refinery License has been successfully deleted!');
        $this->session->flash('REFINERY_REG_DELETE_SUCCESS_SLUG', $refinery_reg->slug);

    }




}