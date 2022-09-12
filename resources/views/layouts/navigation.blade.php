<!---Site Header-->
@php $user = Auth::user() @endphp
<header id="site-header" class="site-header">
    <div class="container site-header-container">

        <div id="site-logo" class="site-logo">
            <a href="{{ url('/home') }}" rel="home"><img src="{{ asset('uploads/logo/logo1.png') }}" class="mg-r-15" alt="logo"></a>
        </div>
        <div class="wrap-site-nav">
            <input type="checkbox" id="mobile-menu-cb" name="mobile-menu-cb">
            <label class="hamburger-button" for="mobile-menu-cb">
                <span class="hamburger-icon"></span>
            </label>
            <label class="hamburger-menu-mask la la-times" for="mobile-menu-cb"></label>
            <nav id="site-nav" class="site-nav">
                <ul class="site-menu none-list heading-font">
                    @if (Auth::user())
                        <li class="menu-item home {{request()->segment(1) == 'home' ? 'active' : '' }}">
                            <a class="" href="{{ url('/home') }}" title="Home">
                                <i class="las la-home"></i>  Home
                            </a>
                        </li>
                        <!-- Display appropriate links based on the user's role -->
                        @if (Auth::user()->role == 'teacher')
                            <li class="menu-item home {{request()->segment(1) == 'class' ? 'active' : '' }}">
                                <a class="" href="{{ url('/class/create') }}" title="Add Class">
                                    <i class="las la-home"></i>  Add Class
                                </a>
                            </li>
                        @endif
                        <li class="menu-item list-slots {{request()->segment(1) == 'list-subject' ? 'active' : '' }}">
                            <a class="" href="{{url('/list-subject')}}" title="Subjects">
                                <i class="las la-book"></i> Subjects
                            </a>
                        </li>
                        <li class="menu-item list-assignments {{request()->segment(2) == 'assignments' ? 'active' : '' }}">
                            <a class="" href="{{ $user->role == 'student' ? route('student.assignment.index') : route('teacher.assignment.index') }}" title="Assignments">
                                <i class="las la-book"></i> Assignments
                            </a>
                        </li>
                        <li class="menu-item list-assignments user-support-link">
                            <a class="support" data-toggle="modal" data-target="#userSupportModal" title="Support">
                                <i class="la la-support"></i> Support
                            </a>
                        </li>
                        <li class="menu-item user-guide-link">
                            <a class="" href="https://faistatic.edunext.vn/assets/attachments/Huong_dan_KTXH_tren_EduNext_Sp22_Sinh_Vien.pdf" target="_blank" title="User Guide"><i class="las la-school"></i> User Guide</a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
        <ul class="header-account none-list">
            <li class="user-support-link">
                <a class="support" data-toggle="modal" data-target="#userSupportModal" title="Support">
                    <h3 class="fs-16 mg-b-0 mg-r-4">Support</h3>
                </a>
            </li>
            <li class="user-guide-link">
                <a class="" href="https://faistatic.edunext.vn/assets/attachments/Huong_dan_KTXH_tren_EduNext_Sp22_Sinh_Vien.pdf" target="_blank" title="User Guide">User Guide</a>
            </li>

            <li class="user-chat {{request()->segment(1) == 'message' ? 'active' : '' }}">
                <div class="chat-icon">
                    <a href="{{ url('/message') }}">
                        <span class="total-message"></span>
                        <i class="las la-comments"></i> Chat
                    </a>
                </div>
            </li>
            <li class="user-notify">
                <input type="checkbox" id="user-notify-cb" class="hidden" />
                <div class="overlay-notify"><i class="las la-times"></i></div>
                <label for="user-notify-cb" class="account-notify has-notify"><i class="la la-bell"></i><span class="total-notify" style="display:none"></span></label>
                <div class="wrap-user-notify-content">
                    <div class="heading-user-notify">
                        <div class="wrap-actions text-semibold text-uppercase">
                            <a href="#" class="not-read" title="Unread">Unread</a>
                            <a href="#" class="all-notify" title="All">All</a>
                        </div>
                    </div>
                    <ul class="list-user-notify">
                    </ul>
                    <span class="notify-load-more" style="display:none">Load more</span>
                </div>
            </li>
            <li class="user-section">
                <div class="user-acc">
                    <input style="display:none;" type="checkbox" id="toggle-user-block" name="toggle-user-block" />
                    <label class="label-user" for="toggle-user-block">
                        <span class="avatar-place-holder v4">
                            <img src="{{(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('uploads/avatar/user-default.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                        </span>
                    </label>
                    <ul class="user-action-box ui-v4">
                        <li class="overlay">
                            <i class="la la-times"></i>
                        </li>
                        <li>
                            <a href="{{ url('/profile') }}" title="{{ Auth::user()->email }}">
                                <div class="user-box">
                                    <span class="avatar-place-holder in-action-box">
                                        <img src="{{(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('uploads/avatar/user-default.png') }}"
                                             alt class="w-px-40 h-auto rounded-circle"
                                        />
                                    </span>
                                    <div class="right">
                                        <p class="user-name">
                                            <span>{{ Auth::user()->email }}</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="break-line-item"></li>
                        <li>
                            <a class="item logout-site" href="" title="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="la la-sign-in-alt"></i>Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-none">
                                @csrf
                                @method("post")
                            </form>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</header>
<!---End Site Header-->

<div class="modal fade" id="userSupportModal" role="dialog" tabindex="-1" aria-labelledby="supportModal">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Email: </label>
                        <input type="text" class="form-control" id="email" placeholder="Enter your email here">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" value="Accept" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
