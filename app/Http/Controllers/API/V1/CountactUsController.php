<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\RoleTypeEnum;
use App\Http\Requests\API\BookingRequest;
use App\Http\Requests\API\ContactUsRequest;
use App\Http\Requests\API\MovementRequest;
use App\Http\Requests\API\SubscriptionRequest;
use App\Http\Requests\API\TransportBookingRequest;
use App\Models\booking;
use App\Models\Subscription;
use App\Models\Trip;
use App\Services\API\BlogService;
use App\Services\API\MovementService;
use App\Services\API\RangeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\JobApplicationRequest;
use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\JobApplication;
use App\Models\TransportBooking;
use App\Services\API\CategoryService;
use App\Services\API\HomeService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;


class CountactUsController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function submitContactUs(ContactUsRequest $request)
    {
        try {
            return  $this->okResponse(__('Contact Us successfully.'), ContactUs::create($request->all()));
        } catch (\Exception $e) {
            return $this->exceptionFailed($e->getMessage());
        }
    }
    public function submitSubscription(SubscriptionRequest $request)
    {
        try {
            return  $this->okResponse(__('Subscription successfully.'), Subscription::create($request->all()));
        } catch (\Exception $e) {
            return $this->exceptionFailed($e->getMessage());
        }
    }


    public function submitContactUsTrip(BookingRequest $request, $slug)
    {
        try {
            $trip =  Trip::where('slug', $slug)->first();
            if (!$trip) {
                return $this->badRequestResponse('Trip not found');
            }
            return  $request->merge(['trip_id' => $trip->id]);
            $this->okResponse(__('Trip Booking successfully.'), booking::create($request->all()));
        } catch (\Exception $e) {
            return $this->exceptionFailed($e);
        }
    }
    public function getFormJobApplication()
    {
        try {
            return $this->okResponse(__('success'),  collect(\App\Enums\JobTitleEnum::cases())
                ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                ->toArray());
        } catch (\Exception $e) {
            dd($e);
            return $this->exceptionFailed($e->getMessage());
        }
    }
    public function submitJobApplication(JobApplicationRequest $request)
    {
        try {
            $data = $request->all();

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('job_applications', 'public');
                $data['image'] = $path;
            }

            $jobApplication = JobApplication::create($data);

            return $this->okResponse(__('Add Job Application successfully.'), $jobApplication);
        } catch (\Exception $e) {
            dd($e);
            return $this->exceptionFailed($e->getMessage());
        }
    }
}
