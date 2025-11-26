<?php

namespace App\Services\API;;

use App\Enums\CongestionLevelEnum;
use App\Enums\MovementTypeEnum;
use App\Enums\RoleTypeEnum;

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\SubServiceResource;
use App\Http\Requests\API\MovementRequest;
use App\Http\Resources\BannerResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CategoryResource as ResourcesCategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\JobResource;
use App\Http\Resources\MovementResource;
use App\Http\Resources\NavBar\OurServiceResource as NavBarOurServiceResource;
use App\Http\Resources\OptionsRangeResource;
use App\Http\Resources\OurServiceResource;
use App\Http\Resources\OurWorkResource;
use App\Http\Resources\PointResource;
use App\Http\Resources\RangeResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\ReviewStandardResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SubServiceResource as ResourcesSubServiceResource;
use App\Http\Resources\TripResource;
use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\City;
use App\Models\Comment;
use App\Models\ContactInfo;
use App\Models\EnsignJobs;
use App\Models\Movement;
use App\Models\OurService;
use App\Models\OurWork;
use App\Models\Point;
use App\Models\Range;
use App\Models\Review;
use App\Models\ReviewStandard;
use App\Models\SubService;
use App\Models\Trip;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Pest\Laravel\call;
use function Symfony\Component\String\s;


class OurServiceService
{
    const SORT_DIRECTIONS = ['asc', 'desc'];
    use ResponseTrait;

    public function getAllServices()
    {
        try {

            return $this->okResponse(
                __('Returned Our Services successfully.'),

                OurServiceResource::collection(OurService::orderBy('created_at', 'desc')->get() ?? []),

            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    // public function getAllServicesForNavBar()
    // {
    //     try {
    //         return $this->okResponse(
    //             __('Returned Our Services successfully.'),
    //             NavBarOurServiceResource::collection(OurService::orderBy('created_at', 'desc')->get() ?? []),
    //         );
    //     } catch (\Exception $exception) {
    //         Log::error($exception->getMessage());
    //         dd($exception);
    //         return $this->exceptionFailed($exception);
    //     }
    // }
    public function getServiceBySlug($slug)
    {
        try {
            $service = OurService::where('slug->en', $slug)
                ->orWhere('slug->ar', $slug)->first();
            if (!$service) {
                return $this->notFoundResponse('Service');
            }


            return $this->okResponse(
                __('Returned Our Service successfully.'),

                new OurServiceResource($service),
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getServicesSiteMap()
    {
        try {
            $Services = OurService::latest()->select('id', 'title', 'slug', 'created_at')->get();
            return $this->okResponse(
                __('Returned Our Services successfully.'),
                $Services
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getSubServiceBySlug($slug)
    {
        try {

            $sub_service = SubService::where('slug->en', $slug)
                ->orWhere('slug->ar', $slug)
                ->first();
            if (!$sub_service) {
                return $this->notFoundResponse('Sub Service');
            }

            return $this->okResponse(
                __('Returned Sub Service successfully.'),
                new ResourcesSubServiceResource($sub_service)

            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getSubServicesForService($slug)
    {
        try {

            $service = OurService::where('slug->en', $slug)
                ->orWhere('slug->ar', $slug)
                ->first();
            if (!$service) {
                return $this->notFoundResponse('Service');
            }
            $sub_services = $service->subServices;
            return $this->okResponse(
                __('Returned Sub Service successfully.'),
                ResourcesSubServiceResource::collection($sub_services)

            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }



    public function getSubServices()
    {
        try {
            return $this->okResponse(
                __('Returned Sub Services successfully.'),

                ResourcesSubServiceResource::collection(SubService::orderBy('created_at', 'desc')->get() ?? []),

            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getAllWorks($request)
    {
        try {
            $perPage = request()->input('per_page', 15);
            $currentPage = request()->input('page', 1);
            $ourWorks = OurWork::query();


            if (!empty($request->service_slug)) {
                $ourWorks->whereHas('service', function ($q) use ($request) {
                    $q->where('slug->en', $request->service_slug)->orWhere('slug->ar', $request->service_slug);
                });
            }

            $ourWorks = $ourWorks->paginate($perPage, ['*'], 'page', $currentPage);
            $options = OurService::all()->mapWithKeys(function ($service) {
                return [$service->slug => $service->getTranslation('title', 'en')];
            })->toArray();
            return $this->paginateResponseWithFilters(OurWorkResource::collection($ourWorks), $options);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getAllJobs()
    {
        try {
            return $this->okResponse(
                __('Returned Jobs successfully.'),

                JobResource::collection(EnsignJobs::orderBy('created_at', 'desc')->get() ?? []),

            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
}
