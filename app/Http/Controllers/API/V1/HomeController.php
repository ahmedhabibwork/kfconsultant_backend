<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\RoleTypeEnum;
use App\Http\Requests\API\MovementRequest;
use App\Services\API\MovementService;
use App\Services\API\RangeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\API\HomeService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    use ResponseTrait;

    protected HomeService $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function home()
    {
        return $this->homeService->home();
    }
    public function contactinfo()
    {
        return $this->homeService->contactinfo();
    }
    public function getAboutUs()
    {
        return $this->homeService->getAboutUs();
    }
    public function getAllTags()
    {
        return $this->homeService->getAllTags();

    }
    public function getTagTrips()
    {
        return $this->homeService->getTagTrips();
    }



}
