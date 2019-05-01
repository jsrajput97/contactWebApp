<header>
    <nav class="navbar navbar-default" style="margin-bottom: 0">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ route('dashboard') }}">Home</a>
                @if (Auth::check() && !(\Request::is('account')) && !(route::is('about.me')))
                    <a class="navbar-brand" href="#" >Add Contact</a>
                @endif
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    @if(route::is('userhome'))
                        <li><a href="{{ route('signupUser') }}">Signup</a></li>
                    @endif
                    @if(route::is('signupUser') || route::is('about.me') && !(Auth::check()))
                        <li><a href="{{ route('userhome') }}">Signin</a></li>
                    @endif
                    @if (Auth::check())
                        @if(!(route::is('account')) && !(route::is('about.me')))
                                <div class="form-group navbar-form navbar-left">
                                    <input type="text" class="form-control" placeholder="Search Contact" id="search_contact" name="search_contact">
                                </div>
                        @endif
                    @endif
                        <li><a href="{{ route('about.me') }}">About Me</a></li>
                    @if(Auth::check())
                            <li class="dropdown">
                            <a href="#" id="dropdown-toggle" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                {{ Auth::user()->first_name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('account') }}">Account</a>
                                    @if(!(route::is('about.me')))
                                    <a href="{{ route('user.contacts') }}">Export Contacts</a>
                                    <a href="#" id="conimport">Import Contacts</a>
                                    <a href="#" id="changePassword">Change Password</a>
                                    @endif
                                    <a href="{{ route('logingout') }}">Logout</a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</header>