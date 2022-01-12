<?php

namespace App\Http\Controllers;

use App\Models\Flux;
use SimpleXMLElement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FluxController extends Controller
{
    public function index()
    {

        $urls = DB::table('fluxes')->pluck('url');
        $tableau = [];
        foreach ($urls as $url) {

            $content = file_get_contents($url);
            $a = new SimpleXMLElement($content);
            foreach ($a->channel->item as $entry) {
                $ent = json_encode($entry, JSON_FORCE_OBJECT);
                $ent = json_decode($ent);

                $enclosure = json_encode($entry->enclosure[0]['url'], JSON_FORCE_OBJECT);
                $enclosure = json_decode($enclosure, true);

                if ($entry->content) {
                    $obj = ['title' => $ent->title, 'content' => $ent->content, 'url' => $ent->link, 'imageUrl' => $entry->enclosure[0]['url']];
                    array_push($tableau, $obj);
                } else {
                    $obj = ['title' => $ent->title, 'content' => $ent->description, 'url' => $ent->link, 'imageUrl' => $enclosure[0]];
                    array_push($tableau, $obj);
                }
            }
        }
        return $tableau;
    }

    public function show($id)
    {
        $url = DB::table('fluxes')->where('id','like',$id)->pluck('url');
        $tableau = [];
        $content = file_get_contents($url[0]);
        $a = new SimpleXMLElement($content);
        foreach ($a->channel->item as $entry) {
            $ent = json_encode($entry, JSON_FORCE_OBJECT);
            $ent = json_decode($ent);

            $enclosure = json_encode($entry->enclosure[0]['url'], JSON_FORCE_OBJECT);
            $enclosure = json_decode($enclosure, true);

            if ($entry->content) {
                $obj = ['title' => $ent->title, 'content' => $ent->content, 'url' => $ent->link, 'imageUrl' => $entry->enclosure[0]['url']];
                array_push($tableau, $obj);
            } else {
                $obj = ['title' => $ent->title, 'content' => $ent->description, 'url' => $ent->link, 'imageUrl' => $enclosure[0]];
                array_push($tableau, $obj);
            }
        }
        return $tableau;
    }

    public function showFlux()
    {
        return Flux::all();
    }
}
