<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\PackageComponent;
use App\Models\PackageLevel;
use Illuminate\Http\Request;

class PageController extends Controller
{
    //
    public function home()
    {
        $packages = Package::query()->where('status', true)->with([
            'levels' => function ($query) {
                $query->where('status', true)
                    ->orderBy('level');
            },

            'components' => function ($query) {
                $query->where('status', true)
                    ->orderBy('sort_order');
            },
        ])
            ->orderBy('sort_order')
            ->get();

        $featuredPackage = $packages
            ->where('is_featured', true)
            ->first();

        if (!$featuredPackage) {
            $featuredPackage = $packages->first();
        }
        // dd($packages->toArray());
        return view('website.home', compact(
            'packages',
            'featuredPackage'
        ));
    }

    public function about()
    {
        return view('website.about');
    }
    public function packages()
    {
        $packages = Package::query()
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return view('website.packages', compact('packages'));
    }
    public function packageDetails($slug)
    {
        $package = Package::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $components = PackageComponent::where('package_id', $package->id)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        $levels = PackageLevel::where('package_id', $package->id)
            ->where('status', 1)
            ->orderBy('level')
            ->get();

        return view('website.package-details', compact(
            'package',
            'components',
            'levels'
        ));
    }

    public function howItWorks()
    {
        return view('website.how-it-works');
    }
    public function faq()
    {
        $faqs = [
            [
                'question' => 'What is this platform?',
                'answer' => 'Our platform provides structured packages and a community-based opportunity system. Members can choose a package and participate according to the configured package rules.'
            ],
            [
                'question' => 'How do I create an account?',
                'answer' => 'Enter your mobile number on the login page. Your mobile number will be checked automatically. If you are an existing member, you can login using OTP. If you are a new member, you can complete the registration process after OTP verification.'
            ],
            [
                'question' => 'How does mobile OTP login work?',
                'answer' => 'Enter your registered mobile number and request an OTP. After successfully verifying the OTP, you will be logged into your account.'
            ],
            [
                'question' => 'How do I choose a package?',
                'answer' => 'Go to the Packages page and explore the available packages. Each package has its own joining amount, renewal amount and configured benefits. You can open the package details page to see the complete information.'
            ],
            [
                'question' => 'How many levels are available?',
                'answer' => 'The platform supports configurable package levels. Currently, packages can be configured with Level 1 through Level 6. The actual configuration depends on the selected package.'
            ],
            [
                'question' => 'What are package components?',
                'answer' => 'Package components define the different components configured for a package. These can include Direct, Company, Expense, Sharing and Bonus.'
            ],
            [
                'question' => 'Are all packages the same?',
                'answer' => 'No. Each package can have different amounts, levels, components and calculation rules. Please check the individual package details before choosing a package.'
            ],
            [
                'question' => 'Can package levels have different calculations?',
                'answer' => 'Yes. Each package level can have its own calculation type, amount, percentage, minimum business and maximum income based on the package configuration.'
            ],
            [
                'question' => 'Where can I see package details?',
                'answer' => 'Open the Packages page and click View Package on the package you are interested in. The package details page contains the configured package information, components and levels.'
            ],
            [
                'question' => 'How do I get started?',
                'answer' => 'Start by entering your mobile number, verify your OTP, complete your registration if you are a new member, and then explore the available packages.'
            ],
        ];

        return view('website.faq', compact('faqs'));
    }

    public function contact()
    {
        return view('website.contact');
    }
    public function contactStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // For now you can process/store/send the enquiry here.

        return redirect()
            ->route('contact')
            ->with('success', 'Thank you for contacting us. Our team will get back to you soon.');
    }
}
