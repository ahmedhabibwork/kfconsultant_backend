<?php

namespace App\Services\API;;

use App\Enums\CongestionLevelEnum;
use App\Enums\MovementTypeEnum;
use App\Enums\RoleTypeEnum;

use App\Filament\Resources\CategoryResource;
use App\Http\Requests\API\MovementRequest;
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
use App\Http\Resources\TripResource;
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


class BlogService
{
    const SORT_DIRECTIONS = ['asc', 'desc'];
    use ResponseTrait;

    public function getAllBlogs($request)
    {
        try {
            $blogs = Blog::query();
            if ($request->search) {
                $blogs->where('title', 'like', '%' . $request->search . '%');
            }
            if ($request->category) {
                $blogs->join('categories', 'blogs.category_id', '=', 'categories.id')->where('categories.slug', $request->category);
            }

            $blogs = $blogs->orderBy('blogs.created_at', 'desc')->get();

            return $this->okResponse(
                __('Returned Home page successfully.'),
                [
                    BlogResource::collection($blogs),
                ]
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
    public function getblogDetails($slug)
    {
        try {
            $blog = Blog::where('slug', $slug)->first();
            if (!$blog) {
                return $this->notFoundResponse('Blog');
            }
            return $this->okResponse(
                __('Returned Blog Details successfully'),
                [
                    'latest_blogs' => BlogResource::collection(Blog::latest()->take(3)->get()),
                    'blog' => new BlogResource(resource: $blog),
                    'why_choose_us' =>  WhyUs::first(),
                ]


            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return $this->exceptionFailed($exception);
        }
    }
    public function getBlogOrTripBySlug($slug)
    {
        try {
            $blog = Blog::where('slug', $slug)->first();
            if ($blog) {
                return $this->okResponse(
                    __('Returned Blog Details successfully'),
                    [
                        'latest_blogs' => BlogResource::collection(Blog::latest()->take(3)->get()),
                        'blog' => new BlogResource(resource: $blog),
                        'why_choose_us' =>  WhyUs::first(),
                    ]
                );
            }

            $trip = Trip::where('slug', $slug)->first();
            if ($trip) {
                return $this->okResponse(
                    __('Returned Trip Details successfully'),
                    [
                        'trip' => new TripResource($trip),
                        'popular_trips' => TripResource::collection(Trip::popular()->limit(4)->get()),
                    ]
                );
            }
            return $this->notFoundResponse('No Blog or Trip found for this slug.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return $this->exceptionFailed($exception);
        }
    }
}
