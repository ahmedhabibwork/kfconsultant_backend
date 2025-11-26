<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\RoleTypeEnum;
use App\Http\Requests\API\MovementRequest;
use App\Services\API\MovementService;
use App\Services\API\ProjectService;
use App\Services\API\RangeService;
use App\Services\API\TripService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\API\HomeService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;


class ProjectController extends Controller
{
    use ResponseTrait;

    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->projectService->index($request);
    }




    /**
     * Display the specified resource.
     */
    public function show($slug, Request $request)
    {
        return $this->projectService->getProjectBySlug($slug);
    }

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
