<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class MillRegistrationSubscriber extends BaseSubscriber{



    public function __construct(){
        parent::__construct();
    }



    public function subscribe($events){

        $events->listen('mill_reg.destroy', 'App\Core\Subscribers\MillRegistrationSubscriber@onDestroy');

    }



    public function onDestroy($mill_reg){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:mills:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:mills:findBySlug:'. optional($mill_reg->mill)->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:mill_registrations:isExistInCY:'.$mill_reg->crop_year_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:mill_registrations:isLicenseExistInCY:'.$mill_reg->crop_year_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:mill_registrations:isBillingExistInCY:'.$mill_reg->crop_year_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:mill_registrations:isMillShareExistInCY:'.$mill_reg->crop_year_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:mill_registrations:fetchByMillId:'. $mill_reg->mill_id .':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:mill_registrations:findBySlug:'. $mill_reg->slug);

        $this->session->flash('MILL_REG_DELETE_SUCCESS', 'The Mill License has been successfully deleted!');
        $this->session->flash('MILL_REG_DELETE_SUCCESS_SLUG', $mill_reg->slug);

    }




}