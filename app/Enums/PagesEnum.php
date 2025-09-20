<?php

namespace App\Enums;

enum PagesEnum: string
{
    case Home = 'home';
    case Blogs = 'blogs';
    case AboutUs = 'about_us';
    case ContactUs = 'contact_us';
    case SubCategory = 'sub_category';
    case Trips = 'trips';
    case TouristTrips = 'tourist_trips';
    case HajjUmrah = 'hajj_umrah';
    case Flights = 'flights';
    case Transport = 'transport';
    case Hotels = 'hotels';

    public function label(): string
    {
        return match ($this) {
            self::Home => __('Home'),
            self::Blogs => __('Blogs'),
            self::AboutUs => __('About Us'),
            self::ContactUs => __('Contact Us'),
            self::SubCategory => __('Sub Category'),
            self::Trips => __('Trips'),
            self::TouristTrips => __('رحلات سياحية'),
            self::HajjUmrah => __('حج وعمرة'),
            self::Flights => __('تذاكر الطيران'),
            self::Transport => __('نقل سياحي'),
            self::Hotels => __('حجز فنادق'),
        };
    }
}
