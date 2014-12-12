<?php
// src/Blogger/BlogBundle/Twig/Extensions/BloggerBlogExtension.php

namespace Locator\LocationBundle\Twig\Extensions;

class LocatorLocationExtension extends \Twig_Extension
{
    const MILEFACTOR = 0.621371192;

    public function getFilters()
    {
        return array(
            'created_ago' => new \Twig_Filter_Method($this, 'createdAgo'),
            'milize' => new \Twig_Filter_Method($this, 'milize'),
            'distance_notation' => new \Twig_Filter_Method($this, 'distanceNotation')
        );
    }

    public function distanceNotation($input = null)
    {
        if(!$input) return null;

        $distance = (float) $input;

        return str_replace('.', ',', round($input, 2)) . ' km';
    }

    public function milize($input)
    {
        return $this::MILEFACTOR * $input;
    }

    public function createdAgo(\DateTime $dateTime)
    {
        $delta = time() - $dateTime->getTimestamp();
        if ($delta < 0)
            throw new \InvalidArgumentException("createdAgo is unable to handle dates in the future");

        $duration = "";
        if ($delta < 60)
        {
            // Seconds
            $time = $delta;
            $duration = $time . " second" . (($time > 1) ? "s" : "") . " ago";
        }
        else if ($delta <= 3600)
        {
            // Mins
            $time = floor($delta / 60);
            $duration = $time . " minute" . (($time > 1) ? "s" : "") . " ago";
        }
        else if ($delta <= 86400)
        {
            // Hours
            $time = floor($delta / 3600);
            $duration = $time . " hour" . (($time > 1) ? "s" : "") . " ago";
        }
        else if ($delta <= 2592000)
        {
            // Days
            $time = floor($delta / 86400);
            $duration = $time . " day" . (($time > 1) ? "s" : "") . " ago";
        } else if ($delta <= 31104000)
        {
            // Months
            $time = floor($delta / 2592000);
            $duration = $time . " month" . (($time > 1) ? "s" : "") . " ago";
        } else if ($delta <= 311040000)
        {
            // Years
            $time = floor($delta / 31104000);
            $duration = $time . " year" . (($time > 1) ? "s" : "") . " ago";
        } else {
            // Years
            $time = floor($delta / 311040000);
            $duration = $time . " decade" . (($time > 1) ? "s" : "") . " ago";
        }

        return $duration;
    }

    public function getName()
    {
        return 'locator_location_extension';
    }
}
