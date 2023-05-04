@extends('main')
@section('sidebar')
<!--  BEGIN SIDEBAR  -->
<nav id="sidebar">

<ul class="navbar-nav theme-brand flex-row  text-center">
    <li class="nav-item theme-logo">
        <a href="/admin">
            <img src="/logo.png" class="navbar-logo" alt="logo">
        </a>
    </li>
    <li class="nav-item theme-text">
        <a href="/admin" class="nav-link"> <span class="text-info">ADMIN</span> </a>
    </li>
</ul>

<ul class="list-unstyled menu-categories" id="accordionExample">
    <li class="menu active">
        <a href="/admin" aria-expanded="false" class="dropdown-toggle">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span> HOME </span>
            </div>
        </a>
    </li>

    <li class="menu">
        <a href="#member" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
            <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span>MEMBER</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </div>
        </a>
        <ul class="collapse submenu recent-submenu mini-recent-submenu list-unstyled show" id="member" data-parent="#accordionExample">
            <li>
                <a href="/admin/member_list"> Member List </a>
            </li>
        </ul>
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
            <li>
                <a href="/admin/budget_list"> Project List </a>
            </li>
        </ul>
    </li>

    <li class="menu">
        <a href="#promo" data-toggle="collapse" aria-expanded="true" class="dropdown-toggle">
            <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tag"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                <span>PROMO</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </div>
        </a>
        <ul class="collapse submenu recent-submenu mini-recent-submenu list-unstyled show" id="promo" data-parent="#accordionExample">
            <li class="">
                <a href="/admin/list_promo"> Promo List </a>
            </li>
        </ul>
    </li>
    
</ul>
</nav>
<!--  END SIDEBAR  -->
@endsection
@section('content')
<home-admin />
@endsection