<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeBackgroundSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeBackgroundController extends Controller
{
    /**
     * Show the form for editing the home background
     */
    public function edit()
    {
        $setting = HomeBackgroundSetting::getActive() ?? new HomeBackgroundSetting();
        return view('admin.home-background.edit', compact('setting'));
    }

    /**
     * Update the home background settings
     */
    public function update(Request $request)
    {
        // Debug: Log request data
        \Log::info('Home Background Update Request:', [
            'type' => $request->type,
            'has_image' => $request->hasFile('image'),
            'has_video' => $request->hasFile('video'),
            'all_files' => $request->allFiles(),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'image_size' => $request->hasFile('image') ? $request->file('image')->getSize() : null,
        ]);

        // Dynamic validation based on type
        $rules = [
            'type' => 'required|in:image,video,animated',
            'overlay_color' => 'nullable|string|max:50',
            'overlay_opacity' => 'nullable|integer|min:0|max:100',
        ];

        // Add file validation based on type
        if ($request->type === 'image') {
            // For image type, require image if no existing image
            $setting = HomeBackgroundSetting::getActive();
            if (!$setting || !$setting->image_path) {
                $rules['image'] = 'required|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg,ico,tiff,tif,heic,heif|max:20480';
            } else {
                $rules['image'] = 'nullable|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg,ico,tiff,tif,heic,heif|max:20480';
            }
        } else {
            $rules['image'] = 'nullable|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg,ico,tiff,tif,heic,heif|max:20480';
        }

        if ($request->type === 'video') {
            $setting = HomeBackgroundSetting::getActive();
            if (!$setting || !$setting->video_path) {
                $rules['video'] = 'required|mimes:mp4,webm,ogg,avi,mov,wmv,flv,3gp|max:102400';
            } else {
                $rules['video'] = 'nullable|mimes:mp4,webm,ogg,avi,mov,wmv,flv,3gp|max:102400';
            }
        } else {
            $rules['video'] = 'nullable|mimes:mp4,webm,ogg,avi,mov,wmv,flv,3gp|max:102400';
        }

        if ($request->type === 'animated') {
            $rules['animated_type'] = 'nullable|string|max:255';
            if ($request->animated_type === 'gif') {
                $setting = HomeBackgroundSetting::getActive();
                if (!$setting || !$setting->image_path) {
                    $rules['image'] = 'required|image|mimes:gif|max:20480';
                } else {
                    $rules['image'] = 'nullable|image|mimes:gif|max:20480';
                }
            }
        }

        $request->validate($rules);

        // Get or create setting
        $setting = HomeBackgroundSetting::getActive() ?? new HomeBackgroundSetting();
        
        \Log::info('Current Setting:', [
            'id' => $setting->id,
            'type' => $setting->type,
            'image_path' => $setting->image_path,
            'is_active' => $setting->is_active,
        ]);
        
        $data = [
            'type' => $request->type,
            'is_active' => true,
            'overlay_color' => $request->overlay_color ?? 'rgba(0,0,0,0.5)',
            'overlay_opacity' => $request->overlay_opacity ?? 50,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                $file = $request->file('image');
                \Log::info('File received:', [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                ]);
                
                // Delete old image if exists
                if ($setting->image_path && Storage::disk('public')->exists($setting->image_path)) {
                    Storage::disk('public')->delete($setting->image_path);
                }
                
                $imagePath = $file->store('home-backgrounds', 'public');
                $data['image_path'] = $imagePath;
                
                // Verify file was saved
                if (Storage::disk('public')->exists($imagePath)) {
                    \Log::info('Image uploaded and verified successfully: ' . $imagePath);
                } else {
                    \Log::error('Image upload failed - file not found after save: ' . $imagePath);
                    return redirect()->back()
                        ->with('error', 'Failed to save image. Please try again.')
                        ->withInput();
                }
            } catch (\Exception $e) {
                \Log::error('Failed to upload image: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString()
                ]);
                return redirect()->back()
                    ->with('error', 'Failed to upload image: ' . $e->getMessage())
                    ->withInput();
            }
        } elseif ($request->type === 'image') {
            // If type is image but no new file uploaded, keep the old image_path
            if ($setting->image_path) {
                $data['image_path'] = $setting->image_path;
                \Log::info('Keeping existing image: ' . $setting->image_path);
            } else {
                // If no image exists and type is image, don't set image_path (will use default)
                \Log::info('No image provided for image type, will use default background');
            }
        } else {
            // If switching away from image type, keep the old path but it won't be used
            if ($setting->image_path) {
                $data['image_path'] = $setting->image_path;
            }
        }

        // Handle video upload
        if ($request->hasFile('video')) {
            // Delete old video if exists
            if ($setting->video_path && Storage::disk('public')->exists($setting->video_path)) {
                Storage::disk('public')->delete($setting->video_path);
            }
            
            $videoPath = $request->file('video')->store('home-backgrounds', 'public');
            $data['video_path'] = $videoPath;
        } elseif ($request->type === 'video') {
            // If type is video but no new file uploaded, keep the old video_path
            if ($setting->video_path) {
                $data['video_path'] = $setting->video_path;
            }
        } else {
            // If switching away from video type, keep the old path but it won't be used
            if ($setting->video_path) {
                $data['video_path'] = $setting->video_path;
            }
        }

        // Handle animated type
        if ($request->type === 'animated') {
            $data['animated_type'] = $request->animated_type ?? 'css-gradient';
            // For GIF animated type, we need image_path
            if ($request->animated_type === 'gif' && $request->hasFile('image')) {
                // Delete old image if exists
                if ($setting->image_path && Storage::disk('public')->exists($setting->image_path)) {
                    Storage::disk('public')->delete($setting->image_path);
                }
                $imagePath = $request->file('image')->store('home-backgrounds', 'public');
                $data['image_path'] = $imagePath;
            } elseif ($request->animated_type === 'gif' && $setting->image_path) {
                // Keep old GIF if exists
                $data['image_path'] = $setting->image_path;
            }
        }

        // Deactivate all other settings
        HomeBackgroundSetting::where('id', '!=', $setting->id ?? 0)->update(['is_active' => false]);

        // Debug: Log data before saving
        \Log::info('Data to save:', $data);

        // Save the setting
        $setting->fill($data);
        $setting->save();

        // Debug: Log after saving
        \Log::info('Setting saved:', [
            'id' => $setting->id,
            'type' => $setting->type,
            'image_path' => $setting->image_path,
            'video_path' => $setting->video_path,
            'is_active' => $setting->is_active,
        ]);

        return redirect()->route('admin.home-background.edit')
            ->with('success', 'Home background settings updated successfully.');
    }

    /**
     * Remove background (deactivate)
     */
    public function destroy()
    {
        $setting = HomeBackgroundSetting::getActive();
        if ($setting) {
            $setting->update(['is_active' => false]);
        }

        return redirect()->route('admin.home-background.edit')
            ->with('success', 'Home background deactivated successfully.');
    }
}
