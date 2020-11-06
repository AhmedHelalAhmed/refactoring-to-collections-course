<?php

require_once 'vendor/autoload.php';

function load_json($path)
{
    // https://api.github.com/users/ahmedhelalahmed/events
    return json_decode(file_get_contents(__DIR__.'/'.$path), true);
}



/*
function github_score($events)
{
    $eventTypes=[];


    foreach ($events as $event) {
        $eventTypes[]=$event['type'];
    }


    $scope=0;

    foreach ($eventTypes as $eventType) {
        switch ($eventType) {
            case 'PushEvent':
                $scope+=5;
                break;
            case 'CreateEvent':
                $scope+=4;
                break;
            case 'IssuesEvent':
                $scope+=3;
                break;
            case 'CommitCommentEvent':
                $scope+=2;
                break;
            default:
                $scope+=1;
                break;
        }
    }

    return $scope;
}
*/


// global function
function github_score($events)
{
    return $events->pluck('type')
    ->map(function ($eventType) {
        return lookup_event_score($eventType);
    })->sum();
}

// global function
function lookup_event_score($eventType)
{
    // 1 is the default if not found the key
    return collect([
            'PushEvent'=> 5,
            'CreateEvent'=> 4,
            'IssuesEvent'=> 3,
            'CommitCommentEvent' => 2,
        ])->get($eventType, 1);
}

$events = collect(load_json('data/events.json'));

dd(github_score($events));//132
