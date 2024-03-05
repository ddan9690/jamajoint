<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('frontend/img/jamajoint-logo.png') }}"
            alt="JamaJoint Logo">
        </div>
        <div class="sidebar-brand-text mx-3">Home</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('cyberpapers.index') }}">
            <i class="fas fa-fw fa-pencil-alt"></i>
            <span>Cyber Exam papers</span>
        </a>
    </li>




    <li class="nav-item">
        <a class="nav-link" href="{{ route('schools.index') }}">
            <i class="fas fa-fw fa-chalkboard-teacher"></i>
            <span>Schools</span>
        </a>
    </li>
    @can('admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('exams.index') }}">
            <i class="fas fa-fw fa-book"></i>
            <span>Exams</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('markSubmissionStatus') }}">
            <i class="fas fa-fw fa-check"></i>
            <span>Mark Submission</span>
        </a>
    </li>

    @endcan
    @can('super')
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('gradings.index') }}">
            <i class="fas fa-fw fa-water"></i>
            <span>Grading System</span>
        </a>
    </li> --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('users.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Manage Users</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('news.index') }}">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Manage News</span>
        </a>
    </li>

    {{-- <!-- Add the following code for the Invoice Index link -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('invoices.index') }}">
            <i class="fas fa-fw fa-file-invoice"></i>
            <span>Invoices</span>
        </a>
    </li> --}}
    @endcan

</ul>
