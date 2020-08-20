<?php 

namespace App\Core\Subscribers;


use App\Core\BaseClasses\BaseSubscriber;



class RefinerySubscriber extends BaseSubscriber{




    public function __construct(){

        parent::__construct();

    }




    public function subscribe($events){

        $events->listen('refinery.store', 'App\Core\Subscribers\RefinerySubscriber@onStore');
        $events->listen('refinery.update', 'App\Core\Subscribers\RefinerySubscriber@onUpdate');
        $events->listen('refinery.destroy', 'App\Core\Subscribers\RefinerySubscriber@onDestroy');
        $events->listen('refinery.renew_license', 'App\Core\Subscribers\RefinerySubscriber@onRenewLicense');

    }




    public function onStore(){
        
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refineries:fetch:*');

        $this->session->flash('REFINERY_CREATE_SUCCESS', 'The Refinery has been successfully created!');

    }





    public function onUpdate($refinery){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:refineries:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refineries:findBySlug:'. $refinery->slug .'');

        $this->session->flash('REFINERY_UPDATE_SUCCESS', 'The Refinery has been successfully updated!');
        $this->session->flash('REFINERY_UPDATE_SUCCESS_SLUG', $refinery->slug);

    }



    public function onDestroy($refinery){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:refineries:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refineries:findBySlug:'. $refinery->slug .'');

        $this->session->flash('REFINERY_DELETE_SUCCESS', 'The Refinery has been successfully deleted!');
        $this->session->flash('REFINERY_DELETE_SUCCESS_SLUG', $refinery->slug);

    }



    public function onRenewLicense($refinery, $refinery_reg, $request){

        $this->__cache->deletePattern(''. config('app.name') .'_cache:refineries:fetch:*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refineries:findBySlug:'. $refinery->slug .'');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refinery_registrations:isRefineryExistInCY:'.$refinery_reg->crop_year_id.':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refinery_registrations:fetchByRefineryId:'. $refinery_reg->refinery_id .':*');
        $this->__cache->deletePattern(''. config('app.name') .'_cache:refinery_registrations:findBySlug:'. $refinery_reg->slug);

        if (isset($request->ft)) {

            if($request->ft == 'rl') {
                $this->session->flash('RENEW_LICENSE_SUCCESS', 'The Refinery has been successfully registered!');
            }elseif ($request->ft == 'rc') {
                $this->session->flash('RATED_CAPACITY_SUCCESS', 'The Rated Capacity has been successfully created!');
            }

            $this->session->flash('REFINERY_RENEW_LICENSE_SUCCESS_SLUG', $refinery->slug);
            $this->session->flash('REFINERY_RENEW_LICENSE_SUCCESS_RR_SLUG', $refinery_reg->slug);

        }else{

            $this->session->flash('REFINERY_RENEW_LICENSE_SUCCESS', 'The Renewal Details has been successfully updated!');
            $this->session->flash('REFINERY_RENEW_LICENSE_SUCCESS_SLUG', $refinery->slug);
            $this->session->flash('REFINERY_RENEW_LICENSE_SUCCESS_RR_SLUG', $refinery_reg->slug);

        }
        
    }





}