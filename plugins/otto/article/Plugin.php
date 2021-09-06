<?php namespace Otto\Article;

use Otto\Article\Models\Article;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }


    public function boot()
    {
        \Event::listen('offline.sitesearch.query', function ($query) {
            // Nekunk name és description keresés kell, ezert ezt adunk meg az argban.
            $items = Models\Article::where('title', 'like', "%${query}%")
                                            ->orWhere('description', 'like', "%${query}%")
                                            ->get();

            $results = $items->map(function ($item) use ($query) {

                // Ha a query a comben van, akkor a relevanciaja legyen nagyobb.
                $relevance = mb_stripos($item->title, $query) !== false ? 2 : 1;
                
                // Optional: Add an age penalty to older results. This makes sure that
                // newer results are listed first.
                // if ($relevance > 1 && $item->published_at) {
                //     $relevance -= $this->getAgePenalty($item->published_at->diffInDays(Carbon::now()));
                // }
                if($item->categories->count()>0){
                	$sub_url = $item->categories->first()->slug;
                } else {
                	$sub_url = "kategoria";
                }

                return [
                    'title'     => $item->title,
                    'text'      => $item->description,
                    //'url'       => "/referencia/". $item->slug,
                    'url'       => "blog/{$sub_url}/". $item->slug,

                	'thumb'     => $item->cover_image ? $item->cover_image  : null, // Instance of System\Models\File
                    'relevance' => $relevance, // higher relevance results in a higher
                ];
            });

            return [
                'provider' => 'Blog cikk', // Ez jelenik meg a keresés mellett, hogy filmkent lett megtalalva.
                'results'  => $results,
            ];
        });
    }

}
