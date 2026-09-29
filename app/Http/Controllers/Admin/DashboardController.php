<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Contact;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Qualification;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\Theme;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $userId = Auth::id();

        // 1. Fetch aggregate statistics
        $stats = [
            'projects'     => Project::where('user_id', $userId)->count(),
            'blogs'        => Blog::where('user_id', $userId)->count(),
            'skills'       => Skill::where('user_id', $userId)->count(),
            'services'     => Service::where('user_id', $userId)->count(),
            'testimonials' => Testimonial::count(), // Global table
            'contacts'     => Contact::count(),     // Global table
        ];

        // 2. Fetch recent activity for data tables
        $recentContacts = Contact::latest()->take(5)->get();
        $recentProjects = Project::where('user_id', $userId)->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentContacts', 'recentProjects'));
    }

    public function profile(Request $request)
    {
        $user = User::with('profile')->findOrFail(Auth::id());
        if ($request->ajax()) {
            // 1. AJAX Profile Picture Upload
            if ($request->formType === 'profile_image') {
                $request->validate([
                    'profile_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
                ]);

                $imageService = new ImageService();

                if ($user->profile_image) {
                    $imageService->delete($user->profile_image);
                }

                $path = $imageService->store($request->file('profile_image'), 'profiles');
                $user->update(['profile_image' => $path]);

                return response()->json([
                    'success'   => true,
                    'message'   => 'Profile picture updated successfully!',
                    'image_url' => asset('storage/' . $path),
                ]);
            }

            // 2. AJAX Main Profile Form Submit
            $request->validate([
                'name'                   => 'required|string|max:255',
                'job_title'              => 'required|string|max:255',
                'personal_email'         => 'required|email|max:255|unique:users,email,' . $user->id,
                'personal_mobile_code'   => 'required|string|max:10',
                'personal_mobile_number' => 'required|string|max:15',
                'pro_email'              => 'nullable|email|max:255',
                'pro_mobile_code'        => 'nullable|string|max:10',
                'pro_mobile_number'      => 'nullable|string|max:15',
                'excerpt'                => 'nullable|string|max:1000',
                'description'            => 'nullable|string',
                'linkedin_url'           => 'nullable|url|max:255',
                'github_url'             => 'nullable|url|max:255',
                'facebook_url'           => 'nullable|url|max:255',
                'x_url'                  => 'nullable|url|max:255',
                'youtube_url'            => 'nullable|url|max:255',
                'resume_file'            => 'nullable|file|mimes:pdf|max:300', // Max 300KB
                'hero_image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:300', // Max 300KB
            ]);

            // Update User Main Table
            $user->update([
                'name'          => $request->name,
                'email'         => $request->personal_email,
                'mobile_code'   => $request->personal_mobile_code,
                'mobile_number' => $request->personal_mobile_number,
            ]);

            $profileData = [
                'title'                  => $request->job_title,
                'official_email'         => $request->pro_email,
                'official_mobile_code'   => $request->pro_mobile_code,
                'official_mobile_number' => $request->pro_mobile_number,
                'excerpt'                => $request->excerpt,
                'description'            => $request->description,
                'linkedin_url'           => $request->linkedin_url,
                'github_url'             => $request->github_url,
                'facebook_url'           => $request->facebook_url,
                'x_url'                  => $request->x_url,
                'youtube_url'            => $request->youtube_url,
            ];

            $imageService = new ImageService();

            // Handle Resume File Upload
            if ($request->hasFile('resume_file')) {
                if ($user->profile && $user->profile->resume_file) {
                    Storage::disk('public')->delete($user->profile->resume_file);
                }
                $profileData['resume_file'] = $request->file('resume_file')->store('resumes', 'public');
            }

            // Handle Hero Image Upload
            if ($request->hasFile('hero_image')) {
                if ($user->profile && $user->profile->hero_image) {
                    $imageService->delete($user->profile->hero_image);
                }
                $profileData['hero_image'] = $imageService->store($request->file('hero_image'), 'hero_images');
            }

            // Save or Update Profile Relation
            $profile = $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'data'    => [
                    'hero_image_url'  => $profile->hero_image ? asset('storage/' . $profile->hero_image) : null,
                    'resume_file_url' => $profile->resume_file ? asset('storage/' . $profile->resume_file) : null,
                ]
            ]);
        }

        return view('admin.profile', compact('user'));
    }

    public function qualification(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            // 1. Single Qualification Delete Action
            if ($request->action === 'delete') {
                $qualification = Qualification::where('user_id', $user->id)
                    ->where('id', $request->qualification_id)
                    ->firstOrFail();

                $qualification->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Qualification deleted successfully!'
                ]);
            }

            // 2. Bulk/Multiple Qualifications Create or Update Action
            $request->validate([
                'qualifications'                         => 'required|array|min:1',
                'qualifications.*.id'                    => 'nullable|exists:qualifications,id',
                'qualifications.*.course_name'           => 'required|string|max:255',
                'qualifications.*.board_or_university'   => 'required|string|max:255',
                'qualifications.*.college'               => 'required|string|max:255',
                'qualifications.*.course_start'          => 'required|string|max:50',
                'qualifications.*.course_end'            => 'required|string|max:50',
                'qualifications.*.type'                  => 'required|in:percentage,grade,cgpa',
                'qualifications.*.type_value'            => 'required|string|max:50',
            ], [
                'qualifications.*.course_name.required'         => 'Course/Degree is required.',
                'qualifications.*.board_or_university.required' => 'Board/University is required.',
                'qualifications.*.college.required'             => 'College/Institute is required.',
                'qualifications.*.course_start.required'        => 'Start Year is required.',
                'qualifications.*.course_end.required'          => 'End Year is required.',
                'qualifications.*.type.required'                => 'Score Type is required.',
                'qualifications.*.type_value.required'          => 'Score Value is required.',
            ]);

            $savedQualifications = [];

            foreach ($request->qualifications as $item) {
                $data = [
                    'user_id'             => $user->id,
                    'board_or_university' => $item['board_or_university'],
                    'college'             => $item['college'],
                    'course_name'         => $item['course_name'],
                    'course_start'        => $item['course_start'],
                    'course_end'          => $item['course_end'],
                    'type'                => $item['type'],
                    'type_value'          => $item['type_value'],
                ];

                if (!empty($item['id'])) {
                    $qualification = Qualification::where('user_id', $user->id)
                        ->where('id', $item['id'])
                        ->first();
                    if ($qualification) {
                        $qualification->update($data);
                    }
                } else {
                    $qualification = Qualification::create($data);
                }

                if ($qualification) {
                    $savedQualifications[] = $qualification;
                }
            }

            return response()->json([
                'success'        => true,
                'message'        => 'Qualifications saved successfully!',
                'qualifications' => $savedQualifications,
            ]);
        }

        $qualifications = Qualification::where('user_id', $user->id)->latest()->get();

        return view('admin.qualification', compact('qualifications'));
    }

    public function skill(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            // 1. Single Skill Delete Action
            if ($request->action === 'delete') {
                $skill = Skill::where('user_id', $user->id)
                    ->where('id', $request->skill_id)
                    ->firstOrFail();

                $skill->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Skill deleted successfully!'
                ]);
            }

            // 2. Bulk/Multiple Skills Create or Update Action
            $request->validate([
                'skills'          => 'required|array|min:1',
                'skills.*.id'     => 'nullable|exists:skills,id',
                'skills.*.name'   => 'required|string|max:255',
                'skills.*.icon'   => 'nullable|string|max:255',
            ], [
                'skills.*.name.required' => 'Skill name is required.',
            ]);

            $savedSkills = [];

            foreach ($request->skills as $item) {
                $data = [
                    'user_id' => $user->id,
                    'name'    => $item['name'],
                    'icon'    => $item['icon'] ?? null,
                ];

                if (!empty($item['id'])) {
                    $skill = Skill::where('user_id', $user->id)
                        ->where('id', $item['id'])
                        ->first();
                    if ($skill) {
                        $skill->update($data);
                    }
                } else {
                    $skill = Skill::create($data);
                }

                if ($skill) {
                    $savedSkills[] = $skill;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Skills saved successfully!',
                'skills'  => $savedSkills,
            ]);
        }

        $skills = Skill::where('user_id', $user->id)->latest()->get();

        return view('admin.skill', compact('skills'));
    }
    public function experience(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            // 1. Single Experience Delete Action
            if ($request->action === 'delete') {
                $experience = Experience::where('user_id', $user->id)
                    ->where('id', $request->experience_id)
                    ->firstOrFail();

                $experience->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Experience deleted successfully!'
                ]);
            }

            // 2. Bulk/Multiple Experiences Create or Update Action
            $request->validate([
                'experiences'                   => 'required|array|min:1',
                'experiences.*.id'              => 'nullable|exists:experiences,id',
                'experiences.*.role'            => 'required|string|max:255',
                'experiences.*.company'         => 'required|string|max:255',
                'experiences.*.employment_type' => 'required|in:internship,part_time,full_time,freelance,contract',
                'experiences.*.start_date'      => 'required|date',
                'experiences.*.end_date'        => 'nullable|date|after_or_equal:experiences.*.start_date',
                'experiences.*.description'     => 'nullable|string',
            ], [
                'experiences.*.role.required'            => 'Role/Title is required.',
                'experiences.*.company.required'         => 'Company name is required.',
                'experiences.*.employment_type.required' => 'Employment type is required.',
                'experiences.*.start_date.required'      => 'Start date is required.',
                'experiences.*.end_date.after_or_equal'  => 'End date must be after or equal to the start date.',
            ]);

            $savedExperiences = [];

            foreach ($request->experiences as $item) {
                $data = [
                    'user_id'         => $user->id,
                    'role'            => $item['role'],
                    'company'         => $item['company'],
                    'employment_type' => $item['employment_type'],
                    'start_date'      => $item['start_date'],
                    'end_date'        => $item['end_date'] ?? null,
                    'description'     => $item['description'] ?? null,
                ];

                if (!empty($item['id'])) {
                    $experience = Experience::where('user_id', $user->id)
                        ->where('id', $item['id'])
                        ->first();
                    if ($experience) {
                        $experience->update($data);
                    }
                } else {
                    $experience = Experience::create($data);
                }

                if ($experience) {
                    $savedExperiences[] = $experience;
                }
            }

            return response()->json([
                'success'     => true,
                'message'     => 'Experiences saved successfully!',
                'experiences' => $savedExperiences,
            ]);
        }

        // Get experiences ordered by the most recent start date
        $experiences = Experience::where('user_id', $user->id)
            ->orderBy('start_date', 'desc')
            ->get();

        return view('admin.experience', compact('experiences'));
    }

    public function project(Request $request)
    {
        $user = Auth::user();
        $imageService = new ImageService();

        if ($request->ajax()) {
            // 1. Single Project Delete Action
            if ($request->action === 'delete') {
                $project = Project::where('user_id', $user->id)
                    ->where('id', $request->project_id)
                    ->firstOrFail();

                // Delete associated images from storage using ImageService
                if (is_array($project->images)) {
                    foreach ($project->images as $img) {
                        $imageService->delete($img);
                    }
                }

                $project->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Project deleted successfully!'
                ]);
            }

            // 2. Bulk/Multiple Projects Create or Update Action
            $request->validate([
                'projects'                   => 'required|array|min:1',
                'projects.*.id'              => 'nullable|exists:projects,id',
                'projects.*.title'           => 'required|string|max:255',
                'projects.*.excerpt'         => 'nullable|string|max:255',
                'projects.*.description'     => 'nullable|string',
                'projects.*.live_url'        => 'nullable|url|max:255',
                'projects.*.existing_images' => 'nullable|array',
                'projects.*.images'          => 'nullable|array',
                'projects.*.images.*'        => 'image|mimes:jpg,jpeg,png,webp|max:5120', // 5MB max per image
            ], [
                'projects.*.title.required' => 'Project title is required.',
                'projects.*.live_url.url'   => 'Please enter a valid URL (e.g., https://...).',
                'projects.*.images.*.max'   => 'Each new image must not exceed 5MB in size.',
            ]);

            foreach ($request->projects as $key => $item) {
                $project = null;
                if (!empty($item['id'])) {
                    $project = Project::where('user_id', $user->id)
                        ->where('id', $item['id'])
                        ->first();
                }

                // 1. Handle Existing Images (Keep vs Delete)
                $oldImages = $project ? (is_array($project->images) ? $project->images : (json_decode($project->images, true) ?? [])) : [];
                $keptImages = $item['existing_images'] ?? [];

                // Delete images that were removed by the user in the UI
                $imagesToDelete = array_diff($oldImages, $keptImages);
                foreach ($imagesToDelete as $imgToDelete) {
                    $imageService->delete($imgToDelete);
                }

                // 2. Handle New Uploads
                $newImages = [];
                if ($request->hasFile("projects.{$key}.images")) {
                    foreach ($request->file("projects.{$key}.images") as $image) {
                        $newImages[] = $imageService->store($image, 'projects');
                    }
                }

                // Combine kept existing images with newly uploaded ones
                $finalImages = array_merge($keptImages, $newImages);

                // Manual Check: Prevent saving if total exceeds 5 images
                if (count($finalImages) > 5) {
                    return response()->json([
                        'errors' => [
                            "projects.{$key}.images" => ["Maximum 5 images allowed in total (existing + new)."]
                        ]
                    ], 422);
                }

                $data = [
                    'user_id'     => $user->id,
                    'title'       => $item['title'],
                    'excerpt'     => $item['excerpt'] ?? null,
                    'description' => $item['description'] ?? null,
                    'live_url'    => $item['live_url'] ?? null,
                    'images'      => $finalImages, // Automatic casting handles json_encode
                ];

                if ($project) {
                    // Update slug ONLY if title changed
                    if ($project->title !== $item['title']) {
                        $baseSlug = Str::slug($item['title']);
                        $slug = $baseSlug;
                        $counter = 2;

                        while (Project::where('slug', $slug)->where('id', '!=', $project->id)->exists()) {
                            $slug = $baseSlug . '-' . $counter;
                            $counter++;
                        }
                        $data['slug'] = $slug;
                    }
                    $project->update($data);
                } else {
                    // Unique Slug for new projects
                    $baseSlug = Str::slug($item['title']);
                    $slug = $baseSlug;
                    $counter = 2;

                    while (Project::where('slug', $slug)->exists()) {
                        $slug = $baseSlug . '-' . $counter;
                        $counter++;
                    }
                    $data['slug'] = $slug;
                    Project::create($data);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Projects saved successfully!',
            ]);
        }

        $projects = Project::where('user_id', $user->id)->latest()->get();
        return view('admin.project', compact('projects'));
    }

    public function blog(Request $request)
    {
        $user = Auth::user();
        $imageService = new ImageService();

        if ($request->ajax()) {
            // 1. Delete Action
            if ($request->action === 'delete') {
                $blog = Blog::where('user_id', $user->id)
                    ->where('id', $request->blog_id)
                    ->firstOrFail();

                // Delete image if exists
                if ($blog->featured_image) {
                    $imageService->delete($blog->featured_image);
                }

                $blog->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Blog deleted successfully!'
                ]);
            }

            // 2. Single Blog Save / Update Action
            $request->validate([
                'id'             => 'nullable|exists:blogs,id',
                'title'          => 'required|string|max:255',
                'excerpt'        => 'nullable|string|max:255',
                'keywords'       => 'nullable|string|max:255',
                'status'         => 'required|in:draft,published,archived',
                'description'    => 'nullable|string',
                'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB max
            ], [
                'featured_image.max' => 'The featured image must not exceed 2MB in size.'
            ]);

            $blog = null;
            if ($request->filled('id')) {
                $blog = Blog::where('user_id', $user->id)->where('id', $request->id)->first();
            }

            $imagePath = $blog ? $blog->featured_image : null;

            // Handle New Image Upload
            if ($request->hasFile('featured_image')) {
                // Delete old image if updating
                if ($imagePath) {
                    $imageService->delete($imagePath);
                }
                // Store new image using your service
                $imagePath = $imageService->store($request->file('featured_image'), 'blogs');
            } else if ($request->remove_image == '1') {
                // If user clicked the cut/remove button on an existing image
                if ($imagePath) {
                    $imageService->delete($imagePath);
                    $imagePath = null;
                }
            }

            $data = [
                'user_id'        => $user->id,
                'title'          => $request->title,
                'excerpt'        => $request->excerpt,
                'description'    => $request->description,
                'keywords'       => $request->keywords,
                'status'         => $request->status,
                'featured_image' => $imagePath,
            ];

            // Handle published_at timestamp
            if ($request->status === 'published' && (!$blog || !$blog->published_at)) {
                $data['published_at'] = now();
            } elseif (!$blog) {
                // Fallback for creation if migration doesn't allow nullable
                $data['published_at'] = now();
            }

            if ($blog) {
                // Update slug ONLY if title changed
                if ($blog->title !== $request->title) {
                    $baseSlug = Str::slug($request->title);
                    $slug = $baseSlug;
                    $counter = 2;

                    while (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                        $slug = $baseSlug . '-' . $counter;
                        $counter++;
                    }
                    $data['slug'] = $slug;
                }

                $blog->update($data);
                $message = 'Blog updated successfully!';
            } else {
                // Unique Slug for new blog
                $baseSlug = Str::slug($request->title);
                $slug = $baseSlug;
                $counter = 2;

                while (Blog::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                $data['slug'] = $slug;

                Blog::create($data);
                $message = 'Blog created successfully!';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }

        $blogs = Blog::where('user_id', $user->id)->latest()->get();
        return view('admin.blog', compact('blogs'));
    }
    public function service(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {
            // 1. Single Service Delete Action
            if ($request->action === 'delete') {
                $service = Service::where('user_id', $user->id)
                    ->where('id', $request->service_id)
                    ->firstOrFail();

                $service->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Service deleted successfully!'
                ]);
            }

            // 2. Bulk/Multiple Services Create or Update Action
            $request->validate([
                'services'               => 'required|array|min:1',
                'services.*.id'          => 'nullable|exists:services,id',
                'services.*.title'       => 'required|string|max:255',
                'services.*.icon'        => 'nullable|string|max:255',
                'services.*.description' => 'nullable|string',
            ], [
                'services.*.title.required' => 'Service title is required.',
            ]);

            $savedServices = [];

            foreach ($request->services as $item) {
                $data = [
                    'user_id'     => $user->id,
                    'title'       => $item['title'],
                    'icon'        => $item['icon'] ?? null,
                    'description' => $item['description'] ?? null,
                ];

                if (!empty($item['id'])) {
                    $service = Service::where('user_id', $user->id)
                        ->where('id', $item['id'])
                        ->first();
                    if ($service) {
                        $service->update($data);
                    }
                } else {
                    $service = Service::create($data);
                }

                if ($service) {
                    $savedServices[] = $service;
                }
            }

            return response()->json([
                'success'  => true,
                'message'  => 'Services saved successfully!',
                'services' => $savedServices,
            ]);
        }

        $services = Service::where('user_id', $user->id)->latest()->get();

        return view('admin.service', compact('services'));
    }

    public function testimonial(Request $request)
    {
        $imageService = new ImageService();

        if ($request->ajax()) {
            // 1. Single Testimonial Delete Action
            if ($request->action === 'delete') {
                $testimonial = Testimonial::findOrFail($request->testimonial_id);

                if ($testimonial->user_image) {
                    $imageService->delete($testimonial->user_image);
                }

                $testimonial->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Testimonial deleted successfully!'
                ]);
            }

            // 2. Bulk/Multiple Testimonials Create or Update Action
            $request->validate([
                'testimonials'              => 'required|array|min:1',
                'testimonials.*.id'         => 'nullable|exists:testimonials,id',
                'testimonials.*.name'       => 'required|string|max:255',
                'testimonials.*.rating'     => 'required|integer|min:1|max:5',
                'testimonials.*.comment'    => 'nullable|string',
                'testimonials.*.user_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // 2MB Max
            ], [
                'testimonials.*.name.required'   => 'Client name is required.',
                'testimonials.*.rating.required' => 'Please select a rating.',
            ]);

            $savedTestimonials = [];

            foreach ($request->testimonials as $key => $item) {
                $testimonial = null;
                if (!empty($item['id'])) {
                    $testimonial = Testimonial::find($item['id']);
                }

                $imagePath = $testimonial ? $testimonial->user_image : null;

                // Handle Image Upload specific to this row index
                if ($request->hasFile("testimonials.{$key}.user_image")) {
                    if ($imagePath) {
                        $imageService->delete($imagePath);
                    }
                    $imagePath = $imageService->store($request->file("testimonials.{$key}.user_image"), 'testimonials');
                }

                $data = [
                    'name'       => $item['name'],
                    'rating'     => $item['rating'],
                    'comment'    => $item['comment'] ?? null,
                    'user_image' => $imagePath,
                ];

                if ($testimonial) {
                    $testimonial->update($data);
                } else {
                    $testimonial = Testimonial::create($data);
                }

                if ($testimonial) {
                    $savedTestimonials[] = $testimonial;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Testimonials saved successfully!',
                'data'    => $savedTestimonials,
            ]);
        }

        // Fetch all testimonials globally
        $testimonials = Testimonial::latest()->get();

        return view('admin.testimonial', compact('testimonials'));
    }
    public function contact(Request $request)
    {
        if ($request->ajax()) {
            // 1. Single Contact Delete Action
            if ($request->action === 'delete') {
                $contact = Contact::findOrFail($request->contact_id);
                $contact->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Contact deleted successfully!'
                ]);
            }

            // 2. Bulk/Multiple Contacts Create or Update Action
            $request->validate([
                'contacts'             => 'required|array|min:1',
                'contacts.*.id'        => 'nullable|exists:contacts,id',
                'contacts.*.name'      => 'required|string|max:255',
                'contacts.*.email'     => 'required|email|max:255',
                'contacts.*.mobile'    => 'nullable|string|max:20',
                'contacts.*.message'   => 'required|string',
            ], [
                'contacts.*.name.required'    => 'Name is required.',
                'contacts.*.email.required'   => 'Email is required.',
                'contacts.*.email.email'      => 'Please enter a valid email address.',
                'contacts.*.message.required' => 'Message is required.',
            ]);

            $savedContacts = [];

            foreach ($request->contacts as $item) {
                $data = [
                    'name'    => $item['name'],
                    'email'   => $item['email'],
                    'mobile'  => $item['mobile'] ?? null,
                    'message' => $item['message'],
                ];

                if (!empty($item['id'])) {
                    $contact = Contact::find($item['id']);
                    if ($contact) {
                        $contact->update($data);
                    }
                } else {
                    $contact = Contact::create($data);
                }

                if ($contact) {
                    $savedContacts[] = $contact;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Contacts saved successfully!',
                'data'    => $savedContacts,
            ]);
        }

        // Fetch all contacts globally
        $contacts = Contact::latest()->get();

        return view('admin.contact', compact('contacts'));
    }

    public function setting(Request $request)
    {
        $setting = Setting::first() ?? new Setting();
        $themes = Theme::latest()->get();

        if ($request->ajax()) {
            $imageService = new ImageService();

            // 1. Handle Theme Deletion
            if ($request->action === 'delete_theme') {
                $theme = Theme::findOrFail($request->theme_id);
                if ($theme->image) {
                    $imageService->delete($theme->image);
                }
                $theme->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Theme deleted successfully!'
                ]);
            }

            // 2. Handle Theme Activation
            if ($request->action === 'activate_theme') {
                Theme::query()->update(['is_active' => false]);
                Theme::where('id', $request->theme_id)->update(['is_active' => true]);

                return response()->json([
                    'success' => true,
                    'message' => 'Theme activated successfully!'
                ]);
            }

            // 3. Handle Theme Form (Create/Update)
            if ($request->form_type === 'theme_modal') {
                $isUpdate = !empty($request->theme_id);

                $rules = [
                    'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                ];

                // Name is only required and validated on creation
                if (!$isUpdate) {
                    $rules['name'] = 'required|string|max:255|unique:themes,name';
                }

                $request->validate($rules);

                $theme = $isUpdate ? Theme::findOrFail($request->theme_id) : new Theme();

                // Only set the name if creating a new theme
                if (!$isUpdate) {
                    $theme->name = $request->name;
                }

                if ($request->hasFile('image')) {
                    if ($theme->image) {
                        $imageService->delete($theme->image);
                    }
                    $theme->image = $imageService->store($request->file('image'), 'themes');
                }

                $theme->save();

                return response()->json([
                    'success' => true,
                    'message' => $isUpdate ? 'Theme updated successfully!' : 'Theme added successfully!'
                ]);
            }

            // 4. Handle General Settings Update
            if ($request->form_type === 'general_setting') {
                $request->validate([
                    'site_title'       => 'nullable|string|max:255',
                    'site_description' => 'nullable|string|max:1000',
                    'light_logo'       => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
                    'dark_logo'        => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
                    'light_favicon'    => 'nullable|image|mimes:jpg,jpeg,png,webp,ico,svg|max:512',
                    'dark_favicon'     => 'nullable|image|mimes:jpg,jpeg,png,webp,ico,svg|max:512',
                ]);

                $data = $request->only(['site_title', 'site_description']);

                if ($request->hasFile('light_logo')) {
                    if ($setting->light_logo) $imageService->delete($setting->light_logo);
                    $data['light_logo'] = $imageService->store($request->file('light_logo'), 'settings');
                }
                if ($request->hasFile('dark_logo')) {
                    if ($setting->dark_logo) $imageService->delete($setting->dark_logo);
                    $data['dark_logo'] = $imageService->store($request->file('dark_logo'), 'settings');
                }
                if ($request->hasFile('light_favicon')) {
                    if ($setting->light_favicon) $imageService->delete($setting->light_favicon);
                    $data['light_favicon'] = $imageService->store($request->file('light_favicon'), 'settings');
                }
                if ($request->hasFile('dark_favicon')) {
                    if ($setting->dark_favicon) $imageService->delete($setting->dark_favicon);
                    $data['dark_favicon'] = $imageService->store($request->file('dark_favicon'), 'settings');
                }

                if ($setting->exists) {
                    $setting->update($data);
                } else {
                    Setting::create($data);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Settings updated successfully!',
                ]);
            }
        }

        return view('admin.setting', compact('setting', 'themes'));
    }
}
