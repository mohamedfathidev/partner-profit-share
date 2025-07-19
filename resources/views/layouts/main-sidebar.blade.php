<div class="container-fluid">
    <div class="row">
        <!-- Left Sidebar start-->
        <div class="side-menu-fixed">
            <div class="scrollbar side-menu-bg">
                <ul class="nav navbar-nav side-menu" id="sidebarnav">

                    <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">لوحة التحكم </li>
                    <li>
                        <a href="{{ route('partners.index') }}"><i class="ti-user"></i><span class="right-nav-text">الشركاء</span></a>
                    </li>
                    <li>
                        <a href="{{ route('transactions.index') }}"><i class="ti-exchange-vertical"></i><span class="right-nav-text">المعاملات</span></a>
                    </li>
                    <li>
                        <a href="{{ route('managers.index') }}"><i class="ti-briefcase"></i><span class="right-nav-text">المديرين</span></a>
                    </li>
                    <li class="side-nav-item">
                        <a href="javascript: void(0);" class="side-nav-link">
                            <i class="ti-money"></i>
                            <span class="right-nav-text">الأرباح الشهرية</span>
                            <span class="menu-arrow"><i class="mdi mdi-chevron-left"></i></span>
                        </a>
                        <ul class="side-nav-second-level" aria-expanded="false">
                            <li>
                                <a href="{{ route('month-profits.create') }}"><i class="ti-plus"></i>إضافة ربح شهري</a>
                            </li>
                            <li>
                                <a href="{{ route('month-profits.index') }}"><i class="ti-bar-chart"></i>الأرباح الشهرية</a>
                            </li>
                        </ul>
                    </li>
                    <li class="side-nav-item">
                        <a href="javascript: void(0);" class="side-nav-link">
                            <i class="ti-paragraph"></i>
                            <span class="right-nav-text">التقارير</span>
                            <span class="menu-arrow"><i class="mdi mdi-chevron-left"></i></span>
                        </a>
                        <ul class="side-nav-second-level" aria-expanded="false">
                            <li>
                                <a href="{{ route('report.general.month') }}"><i class="ti-calendar"></i> التقرير الشهري العام</a>
                            </li>
                            <li>
                                <a href="{{ route('report.general.annual') }}"><i class="ti-target"></i> التقرير السنوي العام</a>
                            </li>
                            <li>
                                <a href="{{ route('report.partner.monthly') }}"><i class="ti-pie-chart"></i>  التقرير الشهري المفصل</a>
                            </li>
                            <li>
                                <a href="{{ route('report.partner.annual') }}"><i class="ti-stats-up"></i>  التقرير السنوي المفصل</a>
                            </li>
                            <li>
                                <a href="{{ route('report.partners.history') }}"><i class="ti-stats-up"></i>سجل الشركاء</a>
                            </li>
                        </ul>
                    </li>
                    
                       
                    <ul class="side-nav-second-level" aria-expanded="false">
                            <li>
                                <a href="{{ route('backup.to.drive') }}"><i class="ti-calendar"></i>نسخ لدرايف أونلاين</a>
                            </li>
                            <li>
                                <a href="{{ route('settings.index') }}"><i class="ti-calendar"></i>الإعدادات</a>
                            </li>
                            <li>
                                <a href="{{ route('show.migration') }}"><i class="ti-calendar"></i>ترحيل</a>
                            </li>
                    </ul>
                    

                    {{--                            <li>--}}
                    {{--                                <a href="javascript:void(0);" data-toggle="collapse" data-target="#error">level--}}
                    {{--                                    item 2<div class="pull-right"><i class="ti-plus"></i></div>--}}
                    {{--                                    <div class="clearfix"></div>--}}
                    {{--                                </a>--}}
                    {{--                                <ul id="error" class="collapse">--}}
                    {{--                                    <li> <a href="#">level item 2.1</a> </li>--}}
                    {{--                                    <li> <a href="#">level item 2.2</a> </li>--}}
                    {{--                                </ul>--}}
                    {{--                            </li>--}}
                    {{--                        </ul>--}}
                    {{--                    </li>--}}
                </ul>
            </div>
        </div>

        <!-- Left Sidebar End-->

        <!--=================================
