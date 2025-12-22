<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\Request;

class PageSectionController extends Controller
{
    /**
     * Display a listing of sections for a page.
     */
    public function index(Page $page)
    {
        $sections = $page->sections()->ordered()->get();
        return view('admin.pages.sections.index', compact('page', 'sections'));
    }

    /**
     * Show the form for creating a new section.
     */
    public function create(Page $page)
    {
        return view('admin.pages.sections.create', compact('page'));
    }

    /**
     * Store a newly created section.
     */
    public function store(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'content' => 'nullable|string',
            'section_type' => 'required|string|in:content,hero,features,testimonials,cta,image,code,table',
            'metadata' => 'nullable|array',
            'order' => 'nullable|integer|min:0',
            'published' => 'boolean',
        ]);

        $data['page_id'] = $page->id;
        $data['published'] = $request->has('published');
        
        // Auto-generate slug if not provided
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']);
        }

        PageSection::create($data);

        return redirect()->route('admin.pages.sections.index', $page)
            ->with('success', 'Section created successfully.');
    }

    /**
     * Show the form for editing the specified section.
     */
    public function edit(Page $page, PageSection $section)
    {
        return view('admin.pages.sections.edit', compact('page', 'section'));
    }

    /**
     * Update the specified section.
     */
    public function update(Request $request, Page $page, PageSection $section)
    {
        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'content' => 'nullable|string',
            'section_type' => 'required|string|in:content,hero,features,testimonials,cta,image,code,table',
            'metadata' => 'nullable|array',
            'order' => 'nullable|integer|min:0',
            'published' => 'boolean',
        ]);

        $data['published'] = $request->has('published');
        
        // Auto-generate slug if not provided
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = \Illuminate\Support\Str::slug($data['title']);
        }

        $section->update($data);

        return redirect()->route('admin.pages.sections.index', $page)
            ->with('success', 'Section updated successfully.');
    }

    /**
     * Remove the specified section.
     */
    public function destroy(Page $page, PageSection $section)
    {
        $section->delete();

        return redirect()->route('admin.pages.sections.index', $page)
            ->with('success', 'Section deleted successfully.');
    }

    /**
     * Update section order.
     */
    public function updateOrder(Request $request, Page $page)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:page_sections,id',
            'sections.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->sections as $item) {
            PageSection::where('id', $item['id'])
                ->where('page_id', $page->id)
                ->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true, 'message' => 'Order updated successfully.']);
    }
}
