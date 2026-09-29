<?php

namespace App\Http\Controllers;


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

use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $theme = '';

    public function __construct()
    {
        $selectedTheme = Theme::select('name')->inRandomOrder()->first();
        $this->theme=$selectedTheme->name ??'theme1';

        // $this->theme='theme4';
    }

    public function index(Request $request)
    {
        return view('website.index');
    }

    protected function sharedData(): array
    {
        return [
            'settings' => Setting::first(),
            'user'     => User::with('profile')->first(),
        ];
    }

    public function home()
    {
        $data = $this->sharedData();

        $data['skills']       = Skill::latest()->get();
        $data['services']     = Service::latest()->take(5)->get();
        $data['projects']     = Project::latest()->take(5)->get();
        $data['blogs']        = Blog::where('status', 'published')->latest('published_at')->take(5)->get();
        $data['testimonials'] = Testimonial::latest()->get();

        return view('website.themes.' . $this->theme . '.home', $data);
    }

    public function projects()
    {
        $data = $this->sharedData();
        $data['projects'] = Project::latest()->paginate(9);

        return view('website.themes.' . $this->theme . '.projects', $data);
    }

    public function projectShow(string $slug)
    {
        $data = $this->sharedData();
        $data['project'] = Project::where('slug', $slug)->firstOrFail();

        return view('website.themes.' . $this->theme . '.project-details', $data);
    }

    public function blogs()
    {
        $data = $this->sharedData();
        $data['blogs'] = Blog::where('status', 'published')->latest('published_at')->paginate(9);

        return view('website.themes.' . $this->theme . '.blogs', $data);
    }

    public function blogShow(string $slug)
    {
        $data = $this->sharedData();
        $data['blog'] = Blog::where('slug', $slug)->where('status', 'published')->firstOrFail();

        return view('website.themes.' . $this->theme . '.blog-details', $data);
    }

    public function services()
    {
        $data = $this->sharedData();
        $data['services'] = Service::latest()->get();

        return view('website.themes.' . $this->theme . '.services', $data);
    }

    public function testimonials()
    {
        $data = $this->sharedData();
        $data['testimonials'] = Testimonial::latest()->paginate(9);

        return view('website.themes.' . $this->theme . '.testimonials', $data);
    }

    public function experience()
    {
        $data = $this->sharedData();
        $data['experiences']   = Experience::orderBy('start_date', 'desc')->get();
        $data['qualifications'] = Qualification::latest()->get();

        return view('website.themes.' . $this->theme . '.experience', $data);
    }

    public function contact()
    {
        $data = $this->sharedData();

        return view('website.themes.' . $this->theme . '.contact', $data);
    }

    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'mobile'  => 'nullable|string|max:20',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Thanks for reaching out! I will get back to you soon.');
    }
}
