<?php

namespace App\Http\Controllers;

use App\Services\SearchService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /**
     * Show search page
     */
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $category = $request->get('category');
        $level = $request->get('level');
        $type = $request->get('type', 'all');

        $results = [
            'tracks' => collect(),
            'lessons' => collect(),
            'quizzes' => collect(),
            'reviews' => collect(),
        ];

        $totalResults = 0;

        // Perform search if query exists or filters are applied
        if (!empty($query) || $category || $level) {
            $results = $this->searchService->search([
                'query' => $query,
                'category' => $category,
                'level' => $level,
                'type' => $type,
            ]);

            $totalResults = $results['tracks']->count() +
                          $results['lessons']->count() +
                          $results['quizzes']->count() +
                          $results['reviews']->count();
        }

        $categories = $this->searchService->getCategories();
        $levels = $this->searchService->getLevels();

        return view('search.index', compact(
            'query',
            'category',
            'level',
            'type',
            'results',
            'totalResults',
            'categories',
            'levels'
        ));
    }

    /**
     * API endpoint for AJAX search
     */
    public function api(Request $request)
    {
        $query = $request->get('q', '');
        $category = $request->get('category');
        $level = $request->get('level');
        $type = $request->get('type', 'all');

        $results = $this->searchService->search([
            'query' => $query,
            'category' => $category,
            'level' => $level,
            'type' => $type,
        ]);

        $totalResults = $results['tracks']->count() +
                      $results['lessons']->count() +
                      $results['quizzes']->count() +
                      $results['reviews']->count();

        return response()->json([
            'results' => $results,
            'total' => $totalResults,
            'query' => $query,
        ]);
    }
}

