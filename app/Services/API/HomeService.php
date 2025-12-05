<?php

namespace App\Services\API;;

use App\Http\Resources\AboutUsResource;
use App\Http\Resources\BannerResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\HomePage\ProjectResource;
use App\Http\Resources\HomePage\ServiceResource;
use App\Http\Resources\TagResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\TripResource;
use App\Http\Resources\WhyUsResource;
use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\Client;
use App\Models\ContactInfo;
use App\Models\OurService;
use App\Models\Project;

use App\Models\Tag;
use App\Models\Team;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Pest\Laravel\call;
use function Symfony\Component\String\s;


class HomeService
{
    const SORT_DIRECTIONS = ['asc', 'desc'];
    use ResponseTrait;

    public function home()
    {
        try {
            $banner = Banner::take(4)->get();
            $aboutUs = AboutUs::first();
            return $this->okResponse(
                __('Returned Home page successfully.'),
                [
                    'banner' => $banner ?  BannerResource::collection($banner) : null,
                    'project' => ProjectResource::collection(Project::latest()->take(5)->get()),
                    'clients' => ClientResource::collection(Client::latest()->get()),
                    'about_us' => $aboutUs ? new AboutUsResource($aboutUs) : null,
                    'services' => ServiceResource::collection(OurService::take(5)->get()),
                    // 'blog' => BlogResource::collection(
                    //     Blog::latest()->take(3)->get()
                    // )

                ]
            );
        } catch (\Throwable $exception) {
            Log::error('Home endpoint failed: ' . $exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
            ]);
            dd($exception);

            return $this->exceptionFailed($exception, __('Failed to load home page.'));
        }
    }
    public function contactinfo()
    {
        try {
            return $this->okResponse(
                __('Returned Contact Info successfully.'),
                ContactInfo::first(),
            );
        } catch (\Throwable $exception) {
            Log::error('Home endpoint failed: ' . $exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
            ]);

            return $this->exceptionFailed($exception, __('Failed to load home page.'));
        }
    }


    public function getAboutUs()
    {
        try {
            return $this->okResponse(
                __('Returned Range Details successfully.'),
                [
                    'about_us' => new AboutUsResource(AboutUs::first()),
                    'team' => TeamResource::collection(Team::all()),
                ]
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            //            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getAllTags()
    {
        try {
            $tags = Tag::get();
            return $this->okResponse(
                __('Returned Tags successfully.'),
                TagResource::collection($tags),
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            //  dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getTagTrips($slug)
    {
        try {
            $trips = Tag::with('trips')->where('slug', $slug)->trips()->get();
            return $this->okResponse(
                __('Returned Trips For Tag successfully.'),
                TripResource::collection($trips),
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            //  dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
}
