<?php

namespace App\Enums;

enum PagesEnum: string
{
    case Home = 'home';
    case Blogs = 'blogs';
    case AboutUs = 'about_us';
    case ContactUs = 'contact_us';
    case Trips = 'trips';
    case FAQ = 'faq';
    


    public function label(): string
    {
        return match ($this) {
            self::Home => __('Home'),
            self::Blogs => __('Blogs'),
            self::AboutUs => __('About Us'),
            self::ContactUs => __('Contact Us'),
            self::Trips => __('Trips'),
            self::FAQ => __('FAQ'),
        };
    }
}
