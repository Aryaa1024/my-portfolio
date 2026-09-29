@extends('website.layouts.app')
@push('page-style')
@endpush
@section('page-content')
    <!-- BEGIN #home -->
    <div id="home" class="py-5 position-relative bg-body bg-opacity-50" data-bs-theme="dark">
        <!-- BEGIN container -->
        <div class="container-xxl p-3 p-lg-5 mb-0">
            <!-- BEGIN div-hero-content -->
            <div class="div-hero-content z-3 position-relative">
                <!-- BEGIN row -->
                <div class="row">
                    <!-- BEGIN col-8 -->
                    <div class="col-lg-6">
                        <!-- BEGIN hero-title-desc -->
                        <h1 class="display-6 fw-600 mb-2 mt-4">
                            Built with HUD Template
                        </h1>
                        <div class="fs-18px text-body text-opacity-75 mb-4">
                            Join thousands of users worldwide who rely on HUD Template <span
                                class="d-xl-inline d-none"><br></span>
                            to kickstart their startups, enhance company projects, hone creative skills, <span
                                class="d-xl-inline d-none"><br></span>
                            or tackle freelance tasks.
                        </div>
                        <!-- END hero-title-desc -->

                        <div class="text-body text-opacity-35 text-center2 mb-4">
                            <i class="fab fa-bootstrap fa-2x fa-fw"></i>
                            <i class="fab fa-node-js fa-2x fa-fw"></i>
                            <i class="fab fa-vuejs fa-2x fa-fw"></i>
                            <i class="fab fa-angular fa-2x fa-fw"></i>
                            <i class="fab fa-react fa-2x fa-fw"></i>
                            <i class="fab fa-laravel fa-2x fa-fw"></i>
                            <i class="fab fa-npm fa-2x fa-fw"></i>
                        </div>

                        <div class="mb-2">
                            <a href="index.html" class="btn btn-lg btn-outline-white px-3">Discover Our Template <i
                                    class="fa fa-arrow-right ms-2 opacity-5"></i></a>
                        </div>

                        <hr class="my-4" />

                        <!-- BEGIN row -->
                        <div class="row text-body mt-4 mb-4">
                            <!-- BEGIN col-4 -->
                            <div class="col-6 mb-3 mb-lg-0">
                                <div class="d-flex align-items-center">
                                    <div class="h1 text-body text-opacity-25 me-3"><iconify-icon
                                            icon="bi:download"></iconify-icon></div>
                                    <div>
                                        <div class="fw-500 mb-0 h3">1.8k+</div>
                                        <div class="fw-500 text-body text-opacity-75">Downloads / Purchases</div>
                                    </div>
                                </div>
                            </div>
                            <!-- END col-4 -->
                            <!-- BEGIN col-4 -->
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="h1 text-body text-opacity-25 me-3"><iconify-icon
                                            icon="bi:bootstrap"></iconify-icon></div>
                                    <div>
                                        <div class="fw-500 mb-0 h3">5.3.7</div>
                                        <div class="fw-500 text-body text-opacity-75">Bootstrap Version</div>
                                    </div>
                                </div>
                            </div>
                            <!-- END col-4 -->
                        </div>
                        <!-- END row -->
                    </div>
                    <!-- END col-8 -->
                </div>
                <!-- END row -->
            </div>
            <!-- END div-hero-content -->

            <div
                class="position-absolute top-0 bottom-0 end-0 w-50 p-5 z-2 overflow-hidden d-lg-flex align-items-center d-none">
                <img class="w-100 d-block shadow-lg" alt="HUD" src="assets/img/landing/mockup-1.jpg">
            </div>
        </div>
        <!-- END container -->
        <div class="position-absolute bg-size-cover bg-position-center d-none2 bg-no-repeat top-0 start-0 w-100 h-100"
            style="background-image: url(assets/img/landing/cover.jpg);"></div>
        <div class="position-absolute top-0 start-0 d-none2 w-100 h-100 opacity-95"
            style="background: var(--bs-body-bg-gradient);"></div>
        <div class="position-absolute top-0 start-0 d-none2 w-100 h-100 opacity-95"
            style="background-image: url(assets/css/images/pattern-dark.png); background-size: var(--bs-body-bg-image-size);">
        </div>
    </div>
    <!-- END #home -->

    <!-- BEGIN #about -->
    <div id="about" class="py-5 bg-component">
        <div class="container-xxl p-3 p-lg-5 text-center">
            <h1 class="mb-3">About HUD</h1>
            <p class="fs-16px text-body text-opacity-50 mb-5">HUD Template crafts high-performance web applications for
                <br>developers, designers, and entrepreneurs, enabling effortless unleashing of creativity.</p>
            <div class="row text-start g-3 gx-lg-5 gy-lg-4">
                <div class="col-xl-3 col-lg-4 col-sm-6 d-flex">
                    <div
                        class="w-50px h-50px bg-theme bg-opacity-15 text-theme fs-32px d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:monitor-smartphone-line-duotone"></iconify-icon>
                    </div>
                    <div class="flex-1 ps-3">
                        <h4>Responsive Design</h4>
                        <p class="mb-0">Optimized for all devices, ensuring a seamless and exceptional user experience
                            everywhere.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 d-flex">
                    <div
                        class="w-50px h-50px bg-theme bg-opacity-15 text-theme fs-32px d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:settings-line-duotone"></iconify-icon>
                    </div>
                    <div class="flex-1 ps-3">
                        <h4>Highly Customizable</h4>
                        <p class="mb-0">Modify layouts, colors, and more with ease. HUD Template offers unparalleled
                            flexibility to adapt to your specific needs.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 d-flex">
                    <div
                        class="w-50px h-50px bg-theme bg-opacity-15 text-theme fs-32px d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:bolt-line-duotone"></iconify-icon>
                    </div>
                    <div class="flex-1 ps-3">
                        <h4>High Performance</h4>
                        <p class="mb-0">Fast loading times and efficient coding practices ensure a smooth user experience,
                            even under heavy traffic.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 d-flex">
                    <div
                        class="w-50px h-50px bg-theme bg-opacity-15 text-theme fs-32px d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:lock-keyhole-line-duotone"></iconify-icon>
                    </div>
                    <div class="flex-1 ps-3">
                        <h4>Secure</h4>
                        <p class="mb-0">Built with security in mind, protecting your data and ensuring your complete peace
                            of mind.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 d-flex">
                    <div
                        class="w-50px h-50px bg-theme bg-opacity-15 text-theme fs-32px d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:dialog-2-line-duotone"></iconify-icon>
                    </div>
                    <div class="flex-1 ps-3">
                        <h4>Community Support</h4>
                        <p class="mb-0">Join our vibrant community of developers and designers, sharing insights and
                            support.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 d-flex">
                    <div
                        class="w-50px h-50px bg-theme bg-opacity-15 text-theme fs-32px d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:help-line-duotone"></iconify-icon>
                    </div>
                    <div class="flex-1 ps-3">
                        <h4>24/7 Support</h4>
                        <p class="mb-0">Our dedicated support team is always here to assist you with any questions or
                            issues you encounter.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 d-flex">
                    <div
                        class="w-50px h-50px bg-theme bg-opacity-15 text-theme fs-32px d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:tuning-line-duotone"></iconify-icon>
                    </div>
                    <div class="flex-1 ps-3">
                        <h4>Scalable Infrastructure</h4>
                        <p class="mb-0">Flexible and scalable infrastructure to meet diverse business needs, ensuring
                            reliability and performance.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 d-flex">
                    <div
                        class="w-50px h-50px bg-theme bg-opacity-15 text-theme fs-32px d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:widget-5-line-duotone"></iconify-icon>
                    </div>
                    <div class="flex-1 ps-3">
                        <h4>Intuitive User Interface</h4>
                        <p class="mb-0">Streamlined, intuitive interface designed for enhanced productivity and
                            creativity.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END #about -->

    <!-- BEGIN divider -->
    <div class="container-xxl px-3 px-lg-5">
        <hr class="opacity-4 m-0" />
    </div>
    <!-- END divider -->

    <!-- BEGIN #features -->
    <div id="features" class="py-5 position-relative">
        <div class="container-xxl p-3 p-lg-5 z-2 position-relative">
            <div class="text-center mb-5">
                <h1 class="mb-3">Our Unique Features</h1>
                <p class="fs-16px text-body text-opacity-50 mb-5">
                    Explore HUD Admin Template's standout features. <br>
                    With advanced customization and seamless integration, create powerful and stunning <br>
                    admin interfaces, enhancing productivity and user satisfaction.
                </p>
            </div>
            <div class="row g-3 g-lg-5">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="assets/img/landing/mockup-1.jpg" data-lity class="shadow d-block"><img
                            src="assets/img/landing/mockup-1-thumb.jpg" alt="" class="mw-100"></a>
                    <div class="text-center my-3 text-body fw-bold">Theme Dashboard</div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="assets/img/landing/mockup-2.jpg" data-lity class="shadow d-block"><img
                            src="assets/img/landing/mockup-2-thumb.jpg" alt="" class="mw-100"></a>
                    <div class="text-center my-3 text-body fw-bold">POS System UI</div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="assets/img/landing/mockup-3.jpg" data-lity class="shadow d-block"><img
                            src="assets/img/landing/mockup-3-thumb.jpg" alt="" class="mw-100"></a>
                    <div class="text-center my-3 text-body fw-bold">Email Inbox</div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="assets/img/landing/mockup-4.jpg" data-lity class="shadow d-block"><img
                            src="assets/img/landing/mockup-4-thumb.jpg" alt="" class="mw-100"></a>
                    <div class="text-center my-3 text-body fw-bold">Pricing Page</div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="assets/img/landing/mockup-5.jpg" data-lity class="shadow d-block"><img
                            src="assets/img/landing/mockup-5-thumb.jpg" alt="" class="mw-100"></a>
                    <div class="text-center my-3 text-body fw-bold">User Profile</div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="assets/img/landing/mockup-6.jpg" data-lity class="shadow d-block"><img
                            src="assets/img/landing/mockup-6-thumb.jpg" alt="" class="mw-100"></a>
                    <div class="text-center my-3 text-body fw-bold">Analytics Page</div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="assets/img/landing/mockup-7.jpg" data-lity class="shadow d-block"><img
                            src="assets/img/landing/mockup-7-thumb.jpg" alt="" class="mw-100"></a>
                    <div class="text-center my-3 text-body fw-bold">HUD Widgets</div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="assets/img/landing/mockup-8.jpg" data-lity class="shadow d-block"><img
                            src="assets/img/landing/mockup-8-thumb.jpg" alt="" class="mw-100"></a>
                    <div class="text-center my-3 text-body fw-bold">Kitchen Order Page</div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="assets/img/landing/mockup-9.jpg" data-lity class="shadow d-block"><img
                            src="assets/img/landing/mockup-9-thumb.jpg" alt="" class="mw-100"></a>
                    <div class="text-center my-3 text-body fw-bold">Order Details Page</div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="assets/img/landing/mockup-10.jpg" data-lity class="shadow d-block"><img
                            src="assets/img/landing/mockup-10-thumb.jpg" alt="" class="mw-100"></a>
                    <div class="text-center my-3 text-body fw-bold">Messenger</div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="assets/img/landing/mockup-11.jpg" data-lity class="shadow d-block"><img
                            src="assets/img/landing/mockup-11-thumb.jpg" alt="" class="mw-100"></a>
                    <div class="text-center my-3 text-body fw-bold">Table Control Page</div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <a href="assets/img/landing/mockup-12.jpg" data-lity class="shadow d-block"><img
                            src="assets/img/landing/mockup-12-thumb.jpg" alt="" class="mw-100"></a>
                    <div class="text-center my-3 text-body fw-bold">Customer Order Page</div>
                </div>
            </div>
        </div>
    </div>
    <!-- END #features -->

    <!-- BEGIN divider -->
    <div class="container-xxl px-3 px-lg-5">
        <hr class="opacity-4 m-0" />
    </div>
    <!-- END divider -->

    <!-- BEGIN #pricing -->
    <div id="pricing" class="py-5 text-body text-opacity-75">
        <div class="container-xxl p-3 p-lg-5">
            <h1 class="mb-3 text-center">Our Pricing Plans</h1>
            <p class="fs-16px text-body text-opacity-50 text-center mb-0">Choose the perfect plan that suits your needs.
                <br>Our pricing is designed to be flexible and affordable, providing value for businesses of all sizes.
                <br>Explore our plans to find the best fit for your requirements.</p>

            <div class="row g-3 py-3 gx-lg-5 pt-lg-5">
                <div class="col-xl-3 col-md-4 col-sm-6 py-xl-5">
                    <div class="card h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center">
                                <div class="flex-1">
                                    <div class="h6 font-monospace">Starter Plan</div>
                                    <div class="h1 fw-semibold mb-0">$5 <small
                                            class="h6 fw-semibold text-body text-opacity-50">/month*</small></div>
                                </div>
                                <div>
                                    <iconify-icon icon="solar:usb-bold-duotone"
                                        class="display-6 text-body text-opacity-50"></iconify-icon>
                                </div>
                            </div>
                            <hr class="my-20px">
                            <div class="mb-5 text-body text-opacity-75 flex-1">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Storage:</span> <b
                                            class="text-body">10 GB</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Bandwidth:</span> <b
                                            class="text-body">100 GB</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Domain Names:</span> <b
                                            class="text-body">1</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">SSL Certificate:</span> <b
                                            class="text-body"> Shared</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Email Accounts:</span> <b
                                            class="text-body"> 5</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">24/7 Support:</span> <b
                                            class="text-body"> Yes</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Backup:</span> <b
                                            class="text-body"> Daily</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Uptime Guarantee:</span>
                                        <b class="text-body"> 99.9%</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">FTP Access:</span> <b
                                            class="text-body"> Yes</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Control Panel:</span> <b
                                            class="text-body"> cPanel</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Free Domain:</span> <b
                                            class="text-body"> No</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Firewall:</span> <b
                                            class="text-body"> No</b></div>
                                </div>
                            </div>
                            <div class="mx-n2">
                                <a href="#" class="btn btn-outline-default btn-lg w-100 font-monospace">Get Started
                                    <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 py-3 py-xl-5">
                    <div class="card h-100">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center">
                                <div class="flex-1">
                                    <div class="h6 font-monospace">Booster Plan</div>
                                    <div class="h1 fw-semibold mb-0">$10 <small
                                            class="h6 fw-semibold text-body text-opacity-50">/month*</small></div>
                                </div>
                                <div>
                                    <iconify-icon icon="solar:map-arrow-up-bold-duotone"
                                        class="display-6 text-body text-opacity-50"></iconify-icon>
                                </div>
                            </div>
                            <hr class="my-20px">
                            <div class="mb-5 text-body text-opacity-75 flex-1">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Storage:</span> <b
                                            class="text-body">20 GB</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Bandwidth:</span> <b
                                            class="text-body">200 GB</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Domain Names:</span> <b
                                            class="text-body">2</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">SSL Certificate:</span> <b
                                            class="text-body"> Free</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Email Accounts:</span> <b
                                            class="text-body"> 10</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">24/7 Support:</span> <b
                                            class="text-body"> Yes</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Backup:</span> <b
                                            class="text-body"> Daily</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Uptime Guarantee:</span>
                                        <b class="text-body"> 99.9%</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">FTP Access:</span> <b
                                            class="text-body"> Yes</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Control Panel:</span> <b
                                            class="text-body"> cPanel</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Free Domain:</span> <b
                                            class="text-body"> No</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Firewall:</span> <b
                                            class="text-body"> No</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-times fa-lg text-body text-opacity-25"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">45-Day Money-Back
                                            Guarantee</span></div>
                                </div>
                            </div>
                            <div class="mx-n2">
                                <a href="#" class="btn btn-outline-default btn-lg w-100 font-monospace">Get Started
                                    <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 py-3 py-xl-0">
                    <div class="card border-theme h-100">
                        <div class="card-body p-30px h-100 d-flex flex-column">
                            <div class="d-flex align-items-center">
                                <div class="flex-1">
                                    <div class="h6 font-monospace text-theme">Premium Plan</div>
                                    <div class="display-6 fw-bold mb-0 text-theme">$15 <small
                                            class="h6 text-body text-opacity-50">/month*</small></div>
                                </div>
                                <div>
                                    <iconify-icon icon="solar:cup-first-bold-duotone"
                                        class="display-5 text-theme"></iconify-icon>
                                </div>
                            </div>
                            <hr class="my-20px">
                            <div class="mb-5 text-body flex-1">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">Storage:</span> <b
                                            class="text-body">50 GB</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">Bandwidth:</span> <b
                                            class="text-body">500 GB</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">Domain Names:</span> <b
                                            class="text-body">Unlimited</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">SSL Certificate:</span>
                                        <b class="text-body">Free</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">Email Accounts:</span>
                                        <b class="text-body">Unlimited</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">24/7 Support:</span> <b
                                            class="text-body">Yes</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">Backup:</span> <b
                                            class="text-body">Daily</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">Uptime Guarantee:</span>
                                        <b class="text-body">99.9%</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">FTP Access:</span> <b
                                            class="text-body">Yes</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">Control Panel:</span> <b
                                            class="text-body">cPanel</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">Free Domain:</span> <b
                                            class="text-body">No</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">Firewall:</span> <b
                                            class="text-body">Yes</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">E-commerce
                                            Support</span></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span
                                            class="font-monospace text-body text-opacity-50 small">45-Day Money-Back
                                            Guarantee</span></div>
                                </div>
                            </div>
                            <a href="#" class="btn btn-theme btn-lg w-100 text-black font-monospace">Get Started <i
                                    class="fa fa-arrow-right"></i></a>
                        </div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 py-3 py-xl-5">
                    <div class="card h-100">
                        <div class="card-body p-30px d-flex flex-column">
                            <div class="d-flex align-items-center">
                                <div class="flex-1">
                                    <div class="h6 font-monospace">Business Plan</div>
                                    <div class="display-6 fw-bold mb-0">$99<small
                                            class="h6 text-body text-opacity-50">/month*</small></div>
                                </div>
                                <div>
                                    <iconify-icon icon="solar:buildings-bold-duotone"
                                        class="display-6 text-white text-opacity-50"></iconify-icon>
                                </div>
                            </div>
                            <hr class="my-20px">
                            <div class="mb-5 text-body text-opacity-75 flex-1">
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Storage:</span> <b
                                            class="text-body">1 TB</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Bandwidth:</span> <b
                                            class="text-body">20 TB</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Domain Names:</span> <b
                                            class="text-body">Unlimited</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">SSL Certificate:</span> <b
                                            class="text-body">Free</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Email Accounts:</span> <b
                                            class="text-body">Unlimited</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check fa-lg text-theme"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">24/7 Support:</span> <b
                                            class="text-body">Yes</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Backup:</span> <b
                                            class="text-body"> Daily</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Uptime Guarantee:</span>
                                        <b class="text-body">99.9%</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">FTP Access:</span> <b
                                            class="text-body">Yes</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Control Panel:</span> <b
                                            class="text-body">cPanel</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Free Domain:</span> <b
                                            class="text-body">Yes</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">Firewall:</span> <b
                                            class="text-body">Yes</b></div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">E-commerce Support</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fa fa-check text-theme fa-lg"></i>
                                    <div class="flex-1 ps-3"><span class="font-monospace small">45-Day Money-Back
                                            Guarantee</span></div>
                                </div>
                            </div>
                            <div class="mx-n2">
                                <a href="#" class="btn btn-outline-default btn-lg w-100 font-monospace">Get Started
                                    <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END #pricing -->

    <!-- BEGIN divider -->
    <div class="container-xxl px-3 px-lg-5">
        <hr class="opacity-4 m-0" />
    </div>
    <!-- END divider -->

    <!-- BEGIN #testimonials -->
    <div id="testimonials" class="py-5 text-body text-opacity-75">
        <div class="container-xxl p-3 p-lg-5">
            <div class="text-center mb-5">
                <h1 class="mb-3 text-center">What Our Clients Say</h1>
                <p class="fs-16px text-body text-opacity-50 text-center mb-0">
                    Read testimonials from our satisfied customers. <br>
                    Discover how HUD Admin Template enhances productivity and exceeds expectations <br>
                    with its ease of use, advanced features, and exceptional support.
                </p>
            </div>
            <div class="row g-3 g-lg-4 mb-4">
                <div class="col-xl-4 col-md-6">
                    <div class="card p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="assets/img/user/user.jpg" class="rounded-circle me-3 w-50px" alt="Client 1">
                            <div>
                                <h5 class="mb-0">John Doe</h5>
                                <small class="text-muted">CEO, Company</small>
                            </div>
                        </div>
                        <div class="d-flex">
                            <i class="fa fa-quote-left fa-2x text-body text-opacity-15"></i>
                            <div class="p-3">
                                <div class="text-warning d-flex mb-2">
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                </div>
                                HUD Admin Template transformed our workflow.
                                The customization options are unparalleled, and the support team is incredibly responsive.
                            </div>
                            <div class="d-flex align-items-end">
                                <i class="fa fa-quote-right fa-2x text-body text-opacity-15"></i>
                            </div>
                        </div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="assets/img/user/user-7.jpg" class="rounded-circle me-3 w-50px" alt="Client 1">
                            <div>
                                <h5 class="mb-0">Michael Brown</h5>
                                <small class="text-muted">CTO, Innovate Corp</small>
                            </div>
                        </div>
                        <div class="d-flex">
                            <i class="fa fa-quote-left fa-2x text-body text-opacity-15"></i>
                            <div class="p-3">
                                <div class="text-warning d-flex mb-2">
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                </div>
                                Our productivity has soared since adopting this template.
                                The features are top-notch, and the user experience is outstanding.
                            </div>
                            <div class="d-flex align-items-end">
                                <i class="fa fa-quote-right fa-2x text-body text-opacity-15"></i>
                            </div>
                        </div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="assets/img/user/user-10.jpg" class="rounded-circle me-3 w-50px" alt="Client 1">
                            <div>
                                <h5 class="mb-0">Emily Johnson</h5>
                                <small class="text-muted">Project Manager, Creative Agency</small>
                            </div>
                        </div>
                        <div class="d-flex">
                            <i class="fa fa-quote-left fa-2x text-body text-opacity-15"></i>
                            <div class="p-3">
                                <div class="text-warning d-flex mb-2">
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                </div>
                                This template is a game-changer.
                                It's intuitive, flexible, and the seamless integration
                                has made our projects run smoother than ever.
                            </div>
                            <div class="d-flex align-items-end">
                                <i class="fa fa-quote-right fa-2x text-body text-opacity-15"></i>
                            </div>
                        </div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 d-none d-xl-block"></div>
                <div class="col-xl-4 col-md-6">
                    <div class="card p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="assets/img/user/user-8.jpg" class="rounded-circle me-3 w-50px" alt="Client 1">
                            <div>
                                <h5 class="mb-0">David Lee</h5>
                                <small class="text-muted">Founder, Startup Hub</small>
                            </div>
                        </div>
                        <div class="d-flex">
                            <i class="fa fa-quote-left fa-2x text-body text-opacity-15"></i>
                            <div class="p-3">
                                <div class="text-warning d-flex mb-2">
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                </div>
                                HUD Admin Template has exceeded all our expectations.
                                The advanced features and excellent support make it a standout choice.
                            </div>
                            <div class="d-flex align-items-end">
                                <i class="fa fa-quote-right fa-2x text-body text-opacity-15"></i>
                            </div>
                        </div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card p-4 h-100">
                        <div class="d-flex align-items-center mb-3">
                            <img src="assets/img/user/user.jpg" class="rounded-circle me-3 w-50px" alt="Client 1">
                            <div>
                                <h5 class="mb-0">John Doe</h5>
                                <small class="text-muted">CEO, Company</small>
                            </div>
                        </div>
                        <div class="d-flex">
                            <i class="fa fa-quote-left fa-2x text-body text-opacity-15"></i>
                            <div class="p-3">
                                <div class="text-warning d-flex mb-2">
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                    <iconify-icon icon="ic:baseline-star" class="fs-18px"></iconify-icon>
                                </div>
                                HUD Admin Template transformed our workflow.
                                The customization options are unparalleled, and the support team is incredibly responsive.
                            </div>
                            <div class="d-flex align-items-end">
                                <i class="fa fa-quote-right fa-2x text-body text-opacity-15"></i>
                            </div>
                        </div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END #testimonials -->

    <!-- BEGIN divider -->
    <div class="container-xxl px-3 px-lg-5">
        <hr class="opacity-4 m-0" />
    </div>
    <!-- END divider -->

    <!-- BEGIN #blog -->
    <div id="blog" class="py-5 bg-component">
        <div class="container-xxl p-3 p-lg-5">
            <div class="text-center mb-5">
                <h1 class="mb-3 text-center">Our Latest Insights</h1>
                <p class="fs-16px text-body text-opacity-50 text-center mb-0">
                    Dive into our blog for the latest trends, tips, and updates <br>
                    on web development, design, and industry best practices. Stay informed and inspired <br>
                    with expert insights and valuable resources.
                </p>
            </div>
            <div class="row g-3 g-xl-4 mb-5">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="card d-flex flex-column h-100 mb-5 mb-lg-0">
                        <div class="card-body">
                            <img src="assets/img/landing/blog-1.jpg" alt=""
                                class="object-fit-cover h-200px w-100 d-block">
                        </div>
                        <div class="flex-1 px-3 pb-0">
                            <div class="mb-2">
                                <span class="bg-theme bg-opacity-15 text-theme px-2 py-1 rounded small fw-bold">Web
                                    Design</span>
                            </div>
                            <h5>Mastering Responsive Design: A Guide for Beginners</h5>
                            <p>Explore the fundamentals of responsive web design and learn essential tips to create websites
                                that look great on any device.</p>
                        </div>
                        <div class="p-3 pt-0 text-body text-opacity-50">July 15, 2025</div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="card d-flex flex-column h-100 mb-5 mb-lg-0">
                        <div class="card-body">
                            <img src="assets/img/landing/blog-2.jpg" alt=""
                                class="object-fit-cover h-200px w-100 d-block">
                        </div>
                        <div class="flex-1 p-3 pb-0">
                            <div class="mb-2">
                                <span class="bg-theme bg-opacity-15 text-theme px-2 py-1 rounded small fw-bold">UXUI
                                    Design</span>
                            </div>
                            <h5>The Future of UI/UX Trends in 2025</h5>
                            <p>Discover the latest trends shaping user interface and experience design in the digital
                                landscape this year.</p>
                        </div>
                        <div class="p-3 pt-0 text-body text-opacity-50">July 11, 2025</div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="card d-flex flex-column h-100 mb-5 mb-lg-0">
                        <div class="card-body">
                            <img src="assets/img/landing/blog-3.jpg" alt=""
                                class="object-fit-cover h-200px w-100 d-block">
                        </div>
                        <div class="flex-1 p-3 pb-0">
                            <div class="mb-2">
                                <span class="bg-theme bg-opacity-15 text-theme px-2 py-1 rounded small fw-bold">Search
                                    Engine</span>
                            </div>
                            <h5>Effective SEO Strategies for 2025</h5>
                            <p>Dive into actionable SEO strategies and tips to boost your website’s visibility and drive
                                organic traffic.</p>
                        </div>
                        <div class="p-3 pt-0 text-body text-opacity-50">June 29, 2025</div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="card d-flex flex-column h-100 mb-5 mb-lg-0">
                        <div class="card-body">
                            <img src="assets/img/landing/blog-4.jpg" alt=""
                                class="object-fit-cover h-200px w-100 d-block">
                        </div>
                        <div class="flex-1 p-3 pb-0">
                            <div class="mb-2">
                                <span class="bg-theme bg-opacity-15 text-theme px-2 py-1 rounded small fw-bold">Cyber
                                    Security</span>
                            </div>
                            <h5>Security Essentials: Protecting Your Website from Cyber Threats</h5>
                            <p>Essential security measures and best practices to safeguard your website and user data from
                                cyber threats.</p>
                        </div>
                        <div class="p-3 pt-0 text-body text-opacity-50">June 27, 2025</div>
                        <div class="card-arrow">
                            <div class="card-arrow-top-left"></div>
                            <div class="card-arrow-top-right"></div>
                            <div class="card-arrow-bottom-left"></div>
                            <div class="card-arrow-bottom-right"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="#" class="text-decoration-none text-body text-opacity-50 h6">See More Company Stories <i
                        class="fa fa-arrow-right ms-3"></i></a>
            </div>
        </div>
    </div>
    <!-- END #blog -->

    <!-- BEGIN divider -->
    <div class="container-xxl px-3 px-lg-5">
        <hr class="opacity-4 m-0" />
    </div>
    <!-- END divider -->

    <!-- BEGIN #contact -->
    <div id="contact" class="py-5 text-body text-opacity-75">
        <div class="container-xl p-3 p-lg-5">
            <div class="text-center mb-5">
                <h1 class="mb-3 text-center">Get in Touch</h1>
                <p class="fs-16px text-body text-opacity-50 text-center mb-0">
                    Contact us today to explore how our team can assist you. <br>
                    Whether you have inquiries, need support, or want to discuss a partnership, <br>
                    we're here to help. Reach out to us and let's start a conversation!
                </p>
            </div>
            <div class="row gx-3 gx-lg-5">
                <div class="col-lg-6">
                    <h4>Contact Us to Discuss Your Project</h4>
                    <p>
                        Do you have a project in mind? We’re eager to discuss it with you. Whether you’re looking for
                        advice, have questions, or want to share your ideas, feel free to reach out.
                    </p>
                    <p>
                        <span class="fw-bolder">SeanTheme HUD, Inc</span><br>
                        795 Folsom Ave, Suite 600<br>
                        San Francisco, CA 94107<br><br>

                        Monday - Friday: 9:00 AM - 6:00 PM<br>
                        Saturday - Sunday: Closed<br> <br>

                        Phone: <a href="#" class="text-theme">(123) 456-7890</a><br>
                        International: <a href="#" class="text-theme">+11 (0) 123 456 78</a><br>
                        Email:
                        <a href="#" class="text-theme"><span class="__cf_email__"
                                data-cfemail="681b1d1818071a1c281b0d09061c000d050d460b0705">[email&#160;protected]</span></a>
                    </p>
                </div>
                <div class="col-lg-6">
                    <form action="https://seantheme.com/hud/index.html" method="GET" name="form_contact_us">
                        <div class="row gy-3 mb-3">
                            <div class="col-6">
                                <label class="form-label">First Name <span class="text-theme">*</span></label>
                                <input type="text" class="form-control form-control-lg fs-15px">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Last Name <span class="text-theme">*</span></label>
                                <input type="text" class="form-control form-control-lg fs-15px">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Email <span class="text-theme">*</span></label>
                                <input type="text" class="form-control form-control-lg fs-15px">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Phone <span class="text-theme">*</span></label>
                                <input type="text" class="form-control form-control-lg fs-15px">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Message <span class="text-theme">*</span></label>
                                <textarea class="form-control form-control-lg fs-15px" rows="8"></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-outline-theme btn-lg btn-block px-4 fs-15px">Send
                                    Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- END #contact -->
@endsection
@push('page-script')
@endpush
