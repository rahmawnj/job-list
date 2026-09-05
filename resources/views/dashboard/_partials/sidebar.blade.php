<!-- BEGIN #sidebar -->
<div id="sidebar" class="app-sidebar" style="background-color: aliceblue" >
    <!-- BEGIN scrollbar -->
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <!-- BEGIN menu -->
        <div class="menu">
            <div class="menu-profile">
                <a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile" data-target="#appSidebarProfileMenu">
                    <div class="menu-profile-cover with-shadow"></div>
                    <div class="menu-profile-image d-flex justify-content-center">
                        <img src="{{asset('storage/' . auth()->user()->image)}}" alt="" />
                    </div>
                    <div class="menu-profile-info">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                @auth
                                    {{auth()->user()->name}}
                                @endauth
                            </div>
                            <div class="menu-caret ms-auto"></div>
                        </div>
                        {{-- <small>Front end developer</small> --}}
                    </div>
                </a>
            </div>
            <div id="appSidebarProfileMenu" class="collapse">
             
                <div class="menu-item {{($title == 'Profile') ? 'active' : ''}}">
                    <a href="{{asset('profile')}}" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-user-circle"></i></div>
                        <div class="menu-text"> Profile</div>
                    </a>
                </div>
                <div class="menu-divider m-0"></div>
            </div>
            <div class="menu-header">Data Master</div>
            <div class="menu-item {{($title == 'Dashboard') ? 'active' : ''}}">
                <a href="/dashboard" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-tachometer-alt"></i>
                    </div>
                    <div class="menu-text">Dashboard</div>
                </a>
            </div>
            <div class="menu-item {{($title == 'Users') ? 'active' : ''}}">
                <a href="/dashboard/users" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-user"></i>
                    </div>
                    <div class="menu-text">Users</div>
                </a>
            </div>
            <div class="menu-item {{($title == 'Companies') ? 'active' : ''}}">
                <a href="/dashboard/companies" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <div class="menu-text">Companies</div>
                </a>
            </div>
            <div class="menu-item {{($title == 'Candidates') ? 'active' : ''}}">
                <a href="/dashboard/candidates" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-user-check"></i>
                    </div>
                    <div class="menu-text">Candidates</div>
                </a>
            </div>
            <div class="menu-item {{($title == 'Jobs') ? 'active' : ''}}">
                <a href="/dashboard/jobs" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-id-badge"></i>
                    </div>
                    <div class="menu-text">Jobs</div>
                </a>
            </div>
            <div class="menu-item {{($title == 'Job Categories') ? 'active' : ''}}">
                <a href="/dashboard/jobcategories" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-fax"></i>
                    </div>
                    <div class="menu-text">Job Categories</div>
                </a>
            </div>
            <div class="menu-item {{($title == 'Locations') ? 'active' : ''}}">
                <a href="/dashboard/locations" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-map-marker-alt"></i>
                    </div>
                    <div class="menu-text">Locations</div>
                </a>
            </div>

            <div class="menu-header">Content</div>
            <div class="menu-item {{($title == 'Content') ? 'active' : ''}}">
                <a href="{{asset('dashboard/content')}}" class="menu-link">
                    <div class="menu-icon"><i class="fa fa-sliders-h"></i></div>
                    <div class="menu-text"> Content</div>
                </a>
            </div>
            <div class="menu-item {{($title == 'Apply Process') ? 'active' : ''}}">
                <a href="{{asset('dashboard/applyprocess')}}" class="menu-link">
                    <div class="menu-icon"><i class="fa fa-sort-amount-down"></i></div>
                    <div class="menu-text"> Apply Process</div>
                </a>
            </div>
            <div class="menu-item {{($title == 'Media Socials') ? 'active' : ''}}">
                <a href="{{asset('dashboard/mediasocials')}}" class="menu-link">
                    <div class="menu-icon"><i class="fa fa-comment-alt"></i></div>
                    <div class="menu-text"> Media Socials</div>
                </a>
            </div>
            
            <div class="menu-header">Inbox</div>
            <div class="menu-item has-sub {{($title == 'Message' || $title == 'Email' ) ? 'active' : ''}}">
                <a href="javascript:;" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <div class="menu-text">Messages</div>
                    <div class="menu-badge">{{App\Models\Message::where('status', 'unread')->count()}}</div>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item {{($title == 'Message') ? 'active' : ''}}">
                        <a href="/dashboard/messages" class="menu-link">
                            <div class="menu-text">Message</div>
                        </a>
                    </div>
                    <div class="menu-item {{($title == 'Email') ? 'active' : ''}}">
                        <a href="/dashboard/emails" class="menu-link">
                            <div class="menu-text">Email</div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="menu-header">Data Dump</div>

            <div class="menu-item has-sub {{($title == 'Jobs Dump') ? 'active' : ''}}">
                <a href="javascript:;" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-trash"></i>
                    </div>
                    <div class="menu-text">Data Dump</div>
                    <div class="menu-caret"></div>
                </a>
                <div class="menu-submenu">
                    <div class="menu-item {{($title == 'Jobs Dump') ? 'active' : ''}}">
                        <a href="/dashboard/jobs/dump" class="menu-link">
                            <div class="menu-text">Jobs</div>
                        </a>
                    </div>
                </div>
            </div>
       
            <!-- BEGIN minify-button -->
            <div class="menu-item d-flex">
                <a href="javascript:;" class="app-sidebar-minify-btn ms-auto" data-toggle="app-sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
            </div>
            <!-- END minify-button -->
        </div>
        <!-- END menu -->
    </div>
    <!-- END scrollbar -->
</div>

<div class="app-sidebar-bg"></div>
		<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>
		<!-- END #sidebar -->