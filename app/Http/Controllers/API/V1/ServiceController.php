<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\RoleTypeEnum;
use App\Http\Requests\API\MovementRequest;
use App\Services\API\BlogService;
use App\Services\API\MovementService;
use App\Services\API\RangeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\OurService;
use App\Services\API\HomeService;
use App\Services\API\OurServiceService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;


class ServiceController extends Controller
{

    use ResponseTrait;

    protected OurServiceService $our_service;

    public function __construct(OurServiceService $our_service)
    {
        $this->our_service = $our_service;
    }
    /**
     * Display a listing of the resource.
     */
    public function getAllServices()
    {
        return $this->our_service->getAllServices();
    }
    public function getServicesSiteMap()
    {
        return $this->our_service->getServicesSiteMap();
    }

    public function getAllServicesForNavBar()
    {
        return $this->our_service->getAllServicesForNavBar();
    }
    public function getServiceBySlug($slug)
    {
        return $this->our_service->getServiceBySlug($slug);
    }
    public function getSubServices()
    {
        return $this->our_service->getSubServices();
    }
    public function getSubServiceBySlug($slug)
    {
        return $this->our_service->getSubServiceBySlug($slug);
    }
    public function getSubServicesForService($slug)
    {
        return $this->our_service->getSubServicesForService($slug);
    }

    public function getAllWorks(Request $request)
    {
        return $this->our_service->getAllWorks($request);
    }
    public function getAllJobs()
    {
        return $this->our_service->getAllJobs();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
