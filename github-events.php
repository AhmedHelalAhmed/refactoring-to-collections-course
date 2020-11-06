<?php

require_once 'vendor/autoload.php';

function load_json($path)
{
    // https://api.github.com/users/ahmedhelalahmed/events
    return json_decode(file_get_contents(__DIR__.'/'.$path), true);
}




// way one
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


$events = collect(load_json('data/events.json'));

dd(github_score($events));//132
