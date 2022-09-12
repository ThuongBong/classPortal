@extends('layouts.app')

@section('title', 'Subjects')

@section('content')
    <div class="course-detail-overlay" style="height: 220px;"></div>
    <div class="container course-detail-site">
        <ul class="breadcrumb none-list mg-0 mg-b-25 fs-16 text-normal">
            <li>
                <a href="/en/home" class="text-decoration-none" title="Home">Home</a>
            </li>
            <li class="separator">/</li>
            <li>
                <span title="Information System Analysis">Information System Analysis</span>
            </li>
        </ul>
        <article class="course-detail-content">
            <div class="row">
                <div class="col-12 col-lg-8 course-detail-content__main">
                    <section class="top-bar-courseDetail mg-b-16">
                        <h1 class="course-name text-bold fs-34 white-space-pre-wrap">Information System Analysis</h1>
                    </section>
                    <p class="course-code-title">Course code: <span class="code">7023-ISA</span></p>
                    <div class="wrap-course-detail-content_main">
                        <div id="course-detail-main-content">
                            <!---Guide lines---->
                            <section id="guide-lines">
                                <!---lessons content--->
                                <div id="lessons-content" class="edn-tabs ui-tabs ui-widget ui-widget-content">
                                    <div id="list-lessons" class="edn-tab-content ui-tabs-panel ui-widget-content" aria-labelledby="list-slots-tab" role="tabpanel" aria-hidden="false">
                                        <ul class="list-slots none-list mg-0">
                                            <!--foreach()-->
                                            <li class="slot-item">
                                                <div class="slot-item__thumb">
                                                    <div class="top-head-slot mg-b-12">
                                                        <div class="left-top-head-slot">
                                                            <a class="slot-label text-bold text-decoration-none" href="/en/session/detail?sessionId=1261">Slot 1</a>
                                                            <time class="fs-14"><i class="la la-calendar fs-18"></i>08:00 30/05/2022 - 10:00 30/05/2022 (GMT+07)</time>
                                                        </div>
                                                        <div class="right-top-head-slot">
                                                            <a href="/en/session/detail?sessionId=1261" class="text-decoration-none text-lightbold">View detail</a>
                                                        </div>
                                                    </div>
                                                    <div class="wrap-slot-name">
                                                        <div class="slot-name text-bold">Introduction to Information Systems Analysis. Hard Approaches, Soft Approaches and Combined</div></div>
                                                </div>
                                            </li>
                                            <!--end-foreach()-->
                                        </ul>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>

                <!--tab-panel-->
                <aside class="col-12 col-lg-4 col-xl-4 course-sidebar hide-on-992">
                    <div class="wrap-course-sidebar course-sidebar-sticky">
                        <div class="top">
                            <div class="course-thumb-wrap">
                            </div>
                            <div class="course-sumary-desktop pd-15">
                                <div class="mg-b-16 filter-class">
                                    <span class="pd-r-5">Class</span>
                                    <select class="slot-by-class">
                                        <option value="66" selected="">T2108M-APHL-Year2022</option>
                                        <option value="66" selected="">T2108M-APHL-Year2022</option>
                                        <option value="66" selected="">T2108M-APHL-Year2022</option>
                                    </select>
                                </div>
                                <div class="course-sumary">
                                    <div class="lectures-section mg-t-20">
                                        <div class="heading-lectures-section mg-b-20">
                                            <h4 class="fs-16 mg-0">Lecturer (1)</h4>
                                        </div>
                                        <ul class="none-list mg-0">
                                            <li class="lecture-item mg-b-16">
                                                <div class="user-acc">
                                                    <img src=" {{ asset('uploads/avatar/user-default.png') }}" alt="HOATQ4@FPT.EDU.VN" class="user-avatar">
                                                    <div class="acc-content-right">
                                                        <div class="wrap-user-name">
                                                            <span class="user-name text-semibold fs-14 is-email" title="HOATQ4@FPT.EDU.VN">HOATQ4@FPT.EDU.VN</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="heading-lectures-section mg-b-20">
                                            <h4 class="fs-16 mg-0">Students (10)</h4>
                                        </div>
                                        <!--foreach()-->
                                        <ul class="none-list mg-0">
                                            <li class="lecture-item mg-b-16">
                                                <div class="user-acc">
                                                    <img src=" {{ asset('uploads/avatar/user-default.png') }}" alt="THAONXTH2108014@FPT.EDU.VN" class="user-avatar">
                                                    <div class="acc-content-right">
                                                        <div class="wrap-user-name">
                                                            <span class="user-name text-semibold fs-14 is-email" title="THAONXTH2108014@FPT.EDU.VN">THAONXTH2108014@FPT.EDU.VN</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <!--end-foreach()-->
                                    </div>
                                </div>

                                <div class="row mg-t-10 update-button-detail" style="display: none;"></div>
                                <div class="row mg-t-10 export-class-activity" style="display: none;"></div>
                            </div>
                            <!--End Case studying-->
                        </div>
                        <div id="meeting-area" class="pd-t-15 pd-15 meeting-area mg-t-20 " style="display:none;">
                            <h3 class="title">Class meeting</h3>
                            <ul class="none-list meeting-list mg-0">
                                <li class="meeting-list__item join-ggmeet no-link" title="No meeting url">
                                    <a target="_blank" href="#">
                                        <img src="https://faistatic.edunext.vn/assets/images/meetings/gg-meet.png" alt="Google meet">
                                        Google Meet
                                    </a>
                                </li>
                            </ul>
                        </div></div>
                </aside>
            </div>
        </article>
    </div>

    {{--@if (count(Auth::user()->classes()->subjects()->get()) > 0)--}}
    {{--@else
            <div class="alert alert-danger col-xs-12 col-md-12" role="alert">The teacher has not added any subjects to this class yet.</div>
    @endif--}}
@endsection

