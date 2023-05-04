@extends('main')
@section('sidebar')
<!--  BEGIN SIDEBAR  -->
<nav id="sidebar">

<ul class="navbar-nav theme-brand flex-row  text-center">
    <li class="nav-item theme-logo">
        <a href="/member">
            <img src="/logo.png" class="navbar-logo" alt="logo">
        </a>
    </li>
    <li class="nav-item theme-text">
        <a href="/member" class="nav-link"> <span class="text-info">MEMBER</span> </a>
    </li>
</ul>

<ul class="list-unstyled menu-categories" id="accordionExample">
    <li class="menu active">
        <a href="/member" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span> HOME </span>
            </div>
        </a>
    </li>

    <li class="menu">
        <a href="#budget" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
            <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                <span>PROJECT DESC.</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </div>
        </a>
        <ul class="collapse submenu recent-submenu mini-recent-submenu list-unstyled show" id="budget" data-parent="#accordionExample">
            <li class="">
                <a href="/member/budget_list"> Project List </a>
            </li>
        </ul>
    </li>
    
</ul>
</nav>
<!--  END SIDEBAR  -->
@endsection
@section('content')
<home-member />
@endsection