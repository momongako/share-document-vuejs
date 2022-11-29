<div style="border-bottom: 1px solid #ddd;" id="header" class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div  class="custom-header">
        <a class="" href="{{ url('/') }}">
            <img class="img-logo" src="{{ asset('assets/logo/Logo_edoc_1.svg') }}">
            &nbsp;
            <span class="text-logo">Share Document</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="col-md-10 collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class=" align-items-center user-info">
{{--                <span class="language">ENG</span>--}}
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item button-login">
                            <a class="nav-link text-login" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown avatar-logout">
                        @if (Auth::user()->image != '')
                            <img class="img-avatar" src="<?php echo "http://apisso.ldcc.vn". Auth::user()->image ?>">
                        @else
                            {{--<img class="img-avatar" src="{{asset('assets/logo/logo_page.ico')}}">--}}
                            <img class="img-avatar" src="http://sso.ldcc.vn/images/profile.png">
                        @endif


                        <div class="dropdown-menu dropdown-menu-right custom-dropdown-logout" aria-labelledby="navbarDropdown">
                            <a href="http://sso.ldcc.vn/user/sso/profile" target="_blank" rel="noopener noreferrer">
                                <div class="info-user d-flex" style="width: 150px;">
                                    <div class="name-email-user">

                                        <div style="max-width: 150px;word-wrap: break-word;">
                                            <span class="name-user">{{ Auth::user()->name }}</span><br/>
                                        </div>
                                        <div style="max-width: 100px" class="text-truncate">
                                            <span class="email-user ">{{ Auth::user()->email }}</span>
                                        </div>

                                    </div>
                                </div>
                            </a>
                          <hr/>
                           <div class="logout d-flex">
                               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                   <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                                   <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                               </svg>
                               <a class="dropdown-item css-dropdown-logout" href="{{ route('logout') }}"
                                  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                   {{ __('Logout') }}
                               </a>

                               <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                   @csrf
                               </form>
                           </div>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</div>
