<?php

namespace App\Services\API;;

use App\Enums\CongestionLevelEnum;
use App\Enums\MovementTypeEnum;
use App\Enums\RoleTypeEnum;

use App\Filament\Resources\CategoryResource;
use App\Http\Requests\API\MovementRequest;
use App\Http\Resources\AboutUsResource;
use App\Http\Resources\BannerResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\CategoryResource as ResourcesCategoryResource;
use App\Http\Resources\ClientResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\MovementResource;
use App\Http\Resources\OptionsRangeResource;
use App\Http\Resources\PointResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\RangeResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\ReviewStandardResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TagResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\TripResource;
use App\Http\Resources\WhyUsResource;
use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\City;
use App\Models\Client;
use App\Models\Comment;
use App\Models\ContactInfo;
use App\Models\Movement;
use App\Models\OurService;
use App\Models\Point;
use App\Models\Project;
use App\Models\Range;
use App\Models\Review;
use App\Models\ReviewStandard;
use App\Models\Tag;
use App\Models\Team;
use App\Models\Trip;
use App\Models\WhyUs;
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
            $banner = Banner::first();
            $aboutUs = AboutUs::first();
            return $this->okResponse(
                __('Returned Home page successfully.'),
                [
                    'banner' => $banner ? new BannerResource($banner) : null,
                    'project' => ProjectResource::collection(Project::latest()->take(5)->get()),
                    'clients' => ClientResource::collection(Client::latest()->get()),
                    'whyUs' => $aboutUs ? new AboutUsResource($aboutUs) : null,
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
