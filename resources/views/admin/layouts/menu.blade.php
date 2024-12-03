<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                {{-- User Profile --}}
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Personal</span>
                </li>

                {{-- Home --}}
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('super_admin.dashboard') }}">
                        <i class="mdi mdi-layers"></i>
                        <span>Home</span>
                    </a>
                </li>

                {{-- Insurances --}}
                <li class="sidebar-item">
                    <a href="{{ route('super_admin.insurances-index') }}" class="sidebar-link">
                        <i class="mdi mdi-view-carousel"></i>
                        <span class="hide-menu">Insurances ({!! isset($insurances) && $insurances->count() > 0 ? $insurances->count() : 0 !!})</span>
                    </a>
                </li>
             
                {{-- Insurance Requests --}}
                <li class="sidebar-item">
                    <a href="{{ route('super_admin.insurance_requests-index') }}" class="sidebar-link">
                        <i class="mdi mdi-view-carousel"></i>
                        <span class="hide-menu">Insurance Requests ({!! isset($insuranceRequests) && $insuranceRequests->count() > 0 ? $insuranceRequests->count() : 0 !!})</span>
                    </a>
                </li>
            </ul>
        </nav>

    </div>

</aside>
