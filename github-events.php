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

class GithubScore
{
    private $events;

    public function __construct($events)
    {
        $this->events=$events;
    }

    public static function score($events)
    {
        return (new static($events))->scoreEvents();
    }

    private function scoreEvents()
    {
        return $this->events->pluck('type')
        ->map(function ($eventType) {
            return $this->lookupEventScore($eventType);
        })->sum();
    }

    private function lookupEventScore($eventType)
    {
        // 1 is the default if not found the key
        return collect([
            'PushEvent'=> 5,
            'CreateEvent'=> 4,
            'IssuesEvent'=> 3,
            'CommitCommentEvent' => 2,
        ])->get($eventType, 1);
    }
}


$events = collect(load_json('data/events.json'));

dd(GithubScore::score($events));//132
