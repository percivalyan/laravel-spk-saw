<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ url('') }}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <img src="{{ url('') }}/assets/images/logo-dark.svg" class="img-fluid logo-lg" alt="logo">
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                @php
                    $PermissionUser = App\Models\PermissionRole::getPermission('User', Auth::user()->role_id);
                    $PermissionRole = App\Models\PermissionRole::getPermission('Role', Auth::user()->role_id);
                    $PermissionCategory = App\Models\PermissionRole::getPermission('Category', Auth::user()->role_id);
                    $PermissionSubCategory = App\Models\PermissionRole::getPermission(
                        'Sub Category',
                        Auth::user()->role_id,
                    );
                    $PermissionProduct = App\Models\PermissionRole::getPermission('Product', Auth::user()->role_id);
                    $PermissionSetting = App\Models\PermissionRole::getPermission('Setting', Auth::user()->role_id);
                @endphp

                <li class="pc-item">
                    <a href="{{ url('panel/dashboard') }}"
                        class="pc-link @if (Request::segment(2) != 'dashboard') collapsed @endif">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                @if (!empty($PermissionUser))
                    <li class="pc-item">
                        <a href="{{ url('panel/user') }}"
                            class="pc-link @if (Request::segment(2) != 'user') collapsed @endif">
                            <span class="pc-micon"><i class="ti ti-user"></i></span>
                            <span class="pc-mtext">User</span>
                        </a>
                    </li>
                @endif

                @if (!empty($PermissionRole))
                    <li class="pc-item">
                        <a href="{{ url('panel/role') }}"
                            class="pc-link @if (Request::segment(2) != 'role') collapsed @endif">
                            <span class="pc-micon"><i class="ti ti-shield-lock"></i></span>
                            <span class="pc-mtext">Role</span>
                        </a>
                    </li>
                @endif

                @if (!empty($PermissionCategory))
                    <li class="pc-item">
                        <a href="{{ route('categories.index') }}"
                            class="pc-link @if (Request::segment(2) != 'category') collapsed @endif">
                            <span class="pc-micon"><i class="ti ti-tag"></i></span>
                            <span class="pc-mtext">Category</span>
                        </a>
                    </li>
                @endif

                @if (!empty($PermissionSubCategory))
                    <li class="pc-item">
                        <a href="{{ url('panel/subcategory') }}"
                            class="pc-link @if (Request::segment(2) != 'subcategory') collapsed @endif">
                            <span class="pc-micon"><i class="ti ti-list-numbers"></i></span>
                            <span class="pc-mtext">Sub Category</span>
                        </a>
                    </li>
                @endif

                @if (!empty($PermissionProduct))
                    <li class="pc-item">
                        <a href="{{ url('panel/product') }}"
                            class="pc-link @if (Request::segment(2) != 'product') collapsed @endif">
                            <span class="pc-micon"><i class="ti ti-box"></i></span>
                            <span class="pc-mtext">Product</span>
                        </a>
                    </li>
                @endif

                @if (!empty($PermissionSetting))
                    <li class="pc-item">
                        <a href="{{ url('panel/setting') }}"
                            class="pc-link @if (Request::segment(2) != 'setting') collapsed @endif">
                            <span class="pc-micon"><i class="ti ti-settings"></i></span>
                            <span class="pc-mtext">Setting</span>
                        </a>
                    </li>
                @endif

                <li class="pc-item">
                    <a href="{{ route('kriteria.index') }}"
                        class="pc-link @if (!Request::is('kriteria*')) collapsed @endif">
                        <span class="pc-micon"><i class="ti ti-clipboard-list"></i></span> {{-- Ikon clipboard list untuk kriteria --}}
                        <span class="pc-mtext">Kriteria</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="{{ route('alternatif.index') }}"
                        class="pc-link @if (!Request::is('alternatif*')) collapsed @endif">
                        <span class="pc-micon"><i class="ti ti-adjustments-horizontal"></i></span> {{-- Ikon pengaturan/slider horizontal untuk alternatif --}}
                        <span class="pc-mtext">Alternatif</span>
                    </a>
                </li>

                <li class="pc-item">
                    <a href="{{ route('nilai-alternatif.index') }}"
                        class="pc-link @if (!Request::is('nilai-alternatif*')) collapsed @endif">
                        <span class="pc-micon"><i class="ti ti-calculator"></i></span> {{-- Ikon kalkulator untuk nilai alternatif --}}
                        <span class="pc-mtext">Nilai Alternatif</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Other</label>
                    <i class="ti ti-brand-chrome"></i>
                </li>
                <li class="pc-item pc-hasmenu">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-menu"></i></span><span
                            class="pc-mtext">Menu
                            levels</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu">
                        <li class="pc-item"><a class="pc-link" href="#!">Level 2.1</a></li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link">Level 2.2<span class="pc-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                                <li class="pc-item pc-hasmenu">
                                    <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i
                                                data-feather="chevron-right"></i></span></a>
                                    <ul class="pc-submenu">
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="pc-item pc-hasmenu">
                            <a href="#!" class="pc-link">Level 2.3<span class="pc-arrow"><i
                                        data-feather="chevron-right"></i></span></a>
                            <ul class="pc-submenu">
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.1</a></li>
                                <li class="pc-item"><a class="pc-link" href="#!">Level 3.2</a></li>
                                <li class="pc-item pc-hasmenu">
                                    <a href="#!" class="pc-link">Level 3.3<span class="pc-arrow"><i
                                                data-feather="chevron-right"></i></span></a>
                                    <ul class="pc-submenu">
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.1</a></li>
                                        <li class="pc-item"><a class="pc-link" href="#!">Level 4.2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
