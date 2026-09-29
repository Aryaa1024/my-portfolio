<!-- BEGIN #sidebar -->
<div id="sidebar" class="app-sidebar">
    <!-- BEGIN scrollbar -->
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <!-- BEGIN menu -->
        <div class="menu mt-3">
            <div class="menu-item">
                <a href="{{ route('admin.dashboard') }}" class="menu-link">
                    <span class="menu-icon"><i class="bi bi-house"></i></span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.profile') }}" class="menu-link">
                    <span class="menu-icon"><i class="bi bi-person-square"></i></span>
                    <span class="menu-text">My Profile</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.qualification') }}" class="menu-link">
                    <span class="menu-icon"><i class="bi bi-mortarboard"></i></span>
                    <span class="menu-text">My Qualifications</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.skill') }}" class="menu-link">
                    <span class="menu-icon"><i class="bi bi-code-slash"></i></span>
                    <span class="menu-text">My Skills</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.experience') }}" class="menu-link">
                    <span class="menu-icon"><i class="bi bi-briefcase-fill"></i></span>
                    <span class="menu-text">My Experiences</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.project') }}" class="menu-link">
                    <span class="menu-icon"><i class="bi bi-collection"></i></span>
                    <span class="menu-text">My Projects</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.blog') }}" class="menu-link">
                    <span class="menu-icon"><i class="bi bi-pencil-square"></i></span>
                    <span class="menu-text">My Blogs</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.service') }}" class="menu-link">
                    <span class="menu-icon"><i class="bi bi-tools"></i></span>
                    <span class="menu-text">Our Services</span>
                </a>
            </div>
            <div class="menu-item">
                <a href="{{ route('admin.testimonial') }}" class="menu-link">
                    <span class="menu-icon"><i class="bi bi-chat-left-quote"></i></span>
                    <span class="menu-text">Our Testimonials</span>
                </a>
            </div>

            <div class="menu-item has-sub">
                <a href="#" class="menu-link">
                    <span class="menu-icon">
                        <i class="bi bi-collection"></i>
                    </span>
                    <span class="menu-text">Others</span>
                    <span class="menu-caret"><b class="caret"></b></span>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item">
                        <a href="{{ route('admin.contact') }}" class="menu-link">
                            <span class="menu-icon"><i class="bi bi-envelope"></i></span>
                            <span class="menu-text">Contacts</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a href="{{ route('admin.setting') }}" class="menu-link">
                            <span class="menu-icon"><i class="bi bi-gear"></i></span>
                            <span class="menu-text">Setting</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END menu -->
        <div class="p-3 px-4 mt-auto">
            <button target="_blank" class="btn d-block w-100 btn-outline-theme">
                <i class="fa fa-code-branch me-2 ms-n2 opacity-5"></i> Version: v1.0.0
            </button>
        </div>
    </div>
    <!-- END scrollbar -->
</div>
<!-- END #sidebar -->

<!-- BEGIN mobile-sidebar-backdrop -->
<button class="app-sidebar-mobile-backdrop" data-toggle-target=".app"
    data-toggle-class="app-sidebar-mobile-toggled"></button>
<!-- END mobile-sidebar-backdrop -->
