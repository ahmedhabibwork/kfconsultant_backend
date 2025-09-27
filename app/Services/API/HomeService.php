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
use App\Http\Resources\CommentResource;
use App\Http\Resources\MovementResource;
use App\Http\Resources\OptionsRangeResource;
use App\Http\Resources\PointResource;
use App\Http\Resources\RangeResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\ReviewStandardResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\TripResource;
use App\Http\Resources\WhyUsResource;
use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\City;
use App\Models\Comment;
use App\Models\ContactInfo;
use App\Models\Movement;
use App\Models\OurService;
use App\Models\Point;
use App\Models\Range;
use App\Models\Review;
use App\Models\ReviewStandard;
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
            return $this->okResponse(
                __('Returned Home page successfully.'),
                [
                    'banner' => new BannerResource(Banner::first()),
                    'recommended_trips' => TripResource::collection(Trip::bestSaller()->inRandomOrder()->take(8)->get()),
                    // 'whyUs' => new WhyUsResource(
                    //     WhyUs::first()
                    // ),
                    'luxury_trips' => TripResource::collection(Trip::leftJoin('cities', 'trips.id', '=', 'cities.trip_id')->where('cities.slug', 'luxury')->inRandomOrder()->take(8)->get()),
                    'cairo_trips' => TripResource::collection(Trip::leftJoin('cities', 'trips.id', '=', 'cities.trip_id')->where('cities.slug', 'cairo')->inRandomOrder()->take(8)->get()),

                    'comments' => CommentResource::collection(
                        Comment::inRandomOrder()->take(8)->get()
                    ),
                    'blog' => BlogResource::collection(
                        Blog::latest()->take(3)->get()
                    )

                ]
            );
        } catch (\Throwable $exception) {
            Log::error('Home endpoint failed: ' . $exception->getMessage(), [
                'trace' => $exception->getTraceAsString(),
            ]);

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
}
