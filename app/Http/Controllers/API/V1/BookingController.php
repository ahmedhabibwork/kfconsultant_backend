<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\CarTypeEnum;
use App\Enums\ClassTypeEnum;
use App\Enums\RoleTypeEnum;
use App\Enums\RoomTypeEnum;
use App\Enums\TicketTypeEnum;
use App\Http\Requests\API\BookingRequest;
use App\Http\Requests\API\ContactUsRequest;
use App\Http\Requests\API\FlightBookingRequest;

use App\Http\Requests\API\TailorMadeRequestRequest;
use App\Http\Requests\API\TransportBookingRequest;
use App\Models\FlightBooking;
use App\Models\HotelBooking;

use App\Models\TailorMadeRequest;
use App\Models\Trip;
use App\Services\API\BlogService;
use App\Services\API\MovementService;
use App\Services\API\RangeService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\HotelBookingRequest;
use App\Models\Blog;
use App\Models\Booking;
use App\Models\ContactUs;
use App\Models\TransportBooking;
use App\Services\API\CategoryService;
use App\Services\API\HomeService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;


class BookingController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */

    public function submitContactUsTrip(BookingRequest $request, $slug)
    {
        try {
            $trip =  Trip::where('slug', $slug)->first();
            if (!$trip) {
                return $this->badRequestResponse('Trip not found');
            }
            $request->merge(['trip_id' => $trip->id]);
            return $this->okResponse(__('Booking successfully.'), Booking::create($request->all()));
        } catch (\Exception $e) {
            return $this->exceptionFailed($e);
        }
    }
    public function transportBooking(TransportBookingRequest $request)
    {
        try {
            return  $this->okResponse(__('Booking successfully.'), TransportBooking::create($request->all()));
        } catch (\Exception $e) {
            return $this->exceptionFailed($e);
        }
    }
    public function transportBookingOptions()
    {
        try {
            return  $this->okResponse(__('Options successfully.'),  [
                'room_types' => CarTypeEnum::toArray(),
            ]);
        } catch (\Exception $e) {
            return $this->exceptionFailed($e);
        }
    }
    public function hotelBooking(HotelBookingRequest $request)
    {
        try {
            return  $this->okResponse(__('Booking successfully.'), HotelBooking::create($request->all()));
        } catch (\Exception $e) {
            return $this->exceptionFailed($e);
        }
    }
    public function hotelBookingOptions()
    {
        try {
            return  $this->okResponse(__('Options successfully.'),  [
                'room_types' => RoomTypeEnum::toArray(),
            ]);
        } catch (\Exception $e) {
            return $this->exceptionFailed($e);
        }
    }
    public function fightBooking(FlightBookingRequest $request)
    {
        try {

            return  $this->okResponse(__('Booking successfully.'), FlightBooking::create($request->all()));
        } catch (\Exception $e) {
            return $this->exceptionFailed($e);
        }
    }

    public function fightBookingOptions()
    {
        try {
            return  $this->okResponse(__('Options successfully.'),        [
                'ticket_types' => TicketTypeEnum::toArray(),
                'class_types'  => ClassTypeEnum::toArray(),
            ]);
        } catch (\Exception $e) {
            return $this->exceptionFailed($e);
        }
    }
    public function tailorMadeRequest(TailorMadeRequestRequest $request)
    {
        try {

            return  $this->okResponse(__('Tailor Made Request successfully.'), TailorMadeRequest::create($request->all()));
        } catch (\Exception $e) {
            return $this->exceptionFailed($e);
        }
    }
    
}
