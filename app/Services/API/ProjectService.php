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
use App\Http\Resources\ProjectResource;
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
use App\Models\Project;
use App\Models\Range;
use App\Models\Review;
use App\Models\ReviewStandard;
use App\Models\Scale;
use App\Models\Scope;
use App\Models\Status;
use App\Models\Trip;
use App\Models\Year;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Pest\Laravel\call;
use function Symfony\Component\String\s;


class ProjectService
{
    const SORT_DIRECTIONS = ['asc', 'desc'];
    use ResponseTrait;
    public function getProjectBySlug(string $slug)
    {
        try {
            $project = Project::where('slug', $slug)->where('is_active', 1)->first();
            if (!$project) {
                return $this->notFoundResponse('Project');
            }
            return $this->okResponse(
                __('Returned Trip Details successfully'),
                [
                    'project' => new ProjectResource($project),


                ]
            );
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return $this->exceptionFailed($exception);
        }
    }

    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 15);
            $currentPage = $request->input('page', 1);

            // ✅ Validate sort field & direction
            $allowedSortFields = ['created_at', 'sort_order'];
            $allowedDirections = ['asc', 'desc'];

            $sortField = $request->input('sort_field', 'sort_order');
            $sortDirection = strtolower($request->input('sort_direction', 'desc'));

            if (!in_array($sortField, $allowedSortFields)) {
                $sortField = 'sort_order';
            }

            if (!in_array($sortDirection, $allowedDirections)) {
                $sortDirection = 'desc';
            }

            // ✅ Start query
            $projectsQuery = Project::with(['category', 'scale', 'scope', 'status', 'year'])
                ->where('is_active', 1);

            // ✅ Search filter
            if ($search = $request->query('search')) {
                $projectsQuery->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('short_description', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%")
                        ->orWhere('location', 'LIKE', "%{$search}%")
                        ->orWhere('owner', 'LIKE', "%{$search}%")
                        ->orWhereHas('category', fn($q) =>
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('slug', 'LIKE', "%{$search}%"))
                        ->orWhereHas('scope', fn($q) =>
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('slug', 'LIKE', "%{$search}%"))
                        ->orWhereHas('status', fn($q) =>
                        $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('slug', 'LIKE', "%{$search}%"));
                });
            }

            // ✅ Filter by relationships safely
            if ($category = $request->query('category')) {
                $projectsQuery->whereHas('category', fn($q) => $q->where('slug', $category));
            }

            if ($scale = $request->query('scale')) {
                $projectsQuery->whereHas('scale', fn($q) => $q->where('slug', $scale));
            }

            if ($scope = $request->query('scope')) {
                $projectsQuery->whereHas('scope', fn($q) => $q->where('slug', $scope));
            }

            if ($status = $request->query('status')) {
                $projectsQuery->whereHas('status', fn($q) => $q->where('slug', $status));
            }

            if ($year = $request->query('year')) {
                $projectsQuery->whereHas('year', fn($q) => $q->where('slug', $year));
            }

            // ✅ Apply sorting
            $projectsQuery->orderBy($sortField, $sortDirection);

            // ✅ Paginate
            $projects = $projectsQuery->paginate($perPage, ['*'], 'page', $currentPage);
            $filters = [
                'category' => Category::pluck('name', 'slug'),
                'scale' => Scale::pluck('name', 'slug'),
                'scope' => Scope::pluck('name', 'slug'),
                'year' => Year::pluck('name', 'slug'),
                'status' => Status::pluck('name', 'slug'),
            ];

            return $this->paginateResponseWithFilters(ProjectResource::collection($projects), $filters);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), ['trace' => $exception->getTraceAsString()]);
            dd($exception);
            return $this->exceptionFailed($exception);
        }
    }
}
