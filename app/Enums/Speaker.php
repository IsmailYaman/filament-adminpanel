<?php

namespace App\Enums;

enum SpeakerQualification: string
{
    case BusinessLeader = 'business-leader';
    case Charisma = 'charisma';
    case FirstTimeSpeaker = 'first-time';
    case HometownHero = 'hometown-hero';
    case LaracastsContributor = 'laracasts-contributor';
    case TwitterInfluencer = 'twitter-influencer';
    case YoutubeInfluencer = 'youtube-influencer';
    case OpenSource = 'open-source';
    case UniquePerspective = 'unique-perspective';
}

enum SpeakerQualificationDescription: string
{
    case BusinessLeader = 'Business Leader';
    case Charisma = 'Charisma';
    case FirstTimeSpeaker = 'First Time Speaker';
    case HometownHero = 'Hometown Hero';
    case LaracastsContributor = 'Laracasts Contributor';
    case TwitterInfluencer = 'Twitter Influencer';
    case YoutubeInfluencer = 'Youtube Influencer';
}