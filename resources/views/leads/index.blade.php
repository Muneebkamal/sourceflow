@extends('layouts.app')

@section('title', 'My Leads')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">My Leads</h4>
                </div>
                <div class="mt-3 mt-sm-0">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body py-2 px-1">
                    <div class="d-flex flex-wrap">
                        <button class="btn btn-primary w-100">Upload File <i class="ti ti-cloud-up fs-4 ms-1"></i></button>
                        <button class="btn btn-primary w-100 mt-2">View/Edit Template</button>
                        <button class="btn btn-outline-primary w-100 mt-2">Add Lead <i class="ti ti-plus fs-4 ms-1"></i></button>
                    </div>
                    <hr>
                    <button class="btn btn-soft-primary w-100 mb-2">Lead List Sources</button>
                    <div class="column-list ps-2">
                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">ANN - NOVEMBER</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">ANN - SEPTEMBER</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Ailyn -NEW</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Ailyn TA List</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Ann</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">August 2024</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Elite List 3 - August</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Elite List 3 - July</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">HERNAN - NOVEMBER</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">HERNAN - OCTOBER</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Jacquelyn</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Kamal 1</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Kamal Finding</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Kamal2025</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">MIXED LIST 4 - NOVEMBER</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">MIXED LIST 4 - OCTOBER</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">MIXED LIST 4 - SEPTEMBER</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">MIXED LIST 5 - SEPTEMBER</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">MIXED LIST 6 - NOVEMBER</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">MIXED LIST 6 - OCTOBER</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">MIXED LIST 6 - SEPTEMBER</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed Lead List Elite 1</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed Lead List Elite 1 - August</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed Lead List Elite 1 - July</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed Lead List Elite 3</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List -October</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - April</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - August</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - Dec 2022</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - Feb</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - January</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - July</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - June</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - March</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - May</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - Nov 2022</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - November</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - Oct 2022</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - September</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 4 - Week of 7_4-7_8</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 5 - April</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 5 - August</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 5 - Feb</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 5 - July</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 5 - June</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 5 - March</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed List 5 - May</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed list 4 - October</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed list 4 - nov 21-25 2022</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Mixed list 4- November</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">NAJNIN</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">NIDA</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">NIDA  - SEPTEMBER</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">OA LEADS KAMAL</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">OA MEGA LIST</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">OA Mixed List</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">OAMANAGE</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">October 2024</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">One Time Beauty List - July 13th 2022</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">One Time List September 24th 2022</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">Rabbit trail</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">September 2024</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">TERESO</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">TSF APRIL</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">TSF AUGUST</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">TSF Dec 2022</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">TSF FEB 2023</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">TSF JAN 2023</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">TSF JULY</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">TSF JUNE</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">TSF MARCH</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">TSF MAY</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">TSF Nov 2022</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">TSF Oct 2022</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">ailyn</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">kashif test 2</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center my-2 column-item position-relative">
                            <span class="fw-bold">zee1</span>
                            <div class="column-actions d-none">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-md-10">
            <div class="row align-items-end mb-3">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-1">
                        <div class="d-flex gap-1">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="ti ti-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Search...">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-flex align-items-end justify-content-end">
                        <button class="btn btn-soft-primary me-1"><i class="ti ti-download fs-4 me-1"></i>Export</button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-soft-primary dropdown-toggle drop-arrow-none" data-bs-auto-close="outside" data-bs-toggle="dropdown" aria-expanded="true">
                                <i class="ti ti-adjustments-horizontal"></i> Customize
                            </button>

                            <div class="dropdown-menu dropdown-menu-md p-0 shadow">
                                <div class="card border-0 mb-0">
                                    <div class="card-header bg-light py-2">
                                        <h5 class="mb-0 fw-semibold text-center">Displayed Order Columns</h5>
                                    </div>

                                    <div class="card-body p-2">
                                        <!-- ✅ Sortable list -->
                                        <div class="column-list-draggable">

                                            <div class="d-flex justify-content-between align-items-center draggable-item">
                                                <div>
                                                    <input class="form-check-input" type="checkbox" id="col-oac_id">
                                                    <label class="form-check-label" for="col-oac_id">Oac ID</label>
                                                </div>
                                                <i class="ti ti-grip-vertical grip-icon"></i>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center draggable-item">
                                                <div>
                                                    <input class="form-check-input" type="checkbox" id="col-name" checked>
                                                    <label class="form-check-label" for="col-name">Name</label>
                                                </div>
                                                <i class="ti ti-grip-vertical grip-icon"></i>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center draggable-item">
                                                <div>
                                                    <input class="form-check-input" type="checkbox" id="col-status" checked>
                                                    <label class="form-check-label" for="col-status">Status</label>
                                                </div>
                                                <i class="ti ti-grip-vertical grip-icon"></i>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center draggable-item">
                                                <div>
                                                    <input class="form-check-input" type="checkbox" id="col-shipped" checked>
                                                    <label class="form-check-label" for="col-shipped">Shipped Date</label>
                                                </div>
                                                <i class="ti ti-grip-vertical grip-icon"></i>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-1 opacity-75 draggable-item">
                                                <div>
                                                    <input class="form-check-input" type="checkbox" id="col-items" checked disabled>
                                                    <label class="form-check-label" for="col-items"># Items</label>
                                                </div>
                                                <i class="ti ti-grip-vertical grip-icon"></i>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center mb-1 opacity-75 draggable-item">
                                                <div>
                                                    <input class="form-check-input" type="checkbox" id="col-tracking" checked disabled>
                                                    <label class="form-check-label" for="col-tracking">Tracking #</label>
                                                </div>
                                                <i class="ti ti-grip-vertical grip-icon"></i>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center draggable-item">
                                                <div>
                                                    <input class="form-check-input" type="checkbox" id="col-note" checked>
                                                    <label class="form-check-label" for="col-note">Note</label>
                                                </div>
                                                <i class="ti ti-grip-vertical grip-icon"></i>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="table-section" class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="leads-table" class="table align-middle w-100 mb-0 table-hover">
                                    <thead class="table-light">
                                    <tr class="text-nowrap small">
                                        <th><input type="checkbox" class="form-check-input"></th>
                                        <th>Order Date</th>
                                        <th>Order #</th>
                                        <th>Image</th>
                                        <th>Product</th>
                                        <th>Status</th>
                                        <th>Supplier</th>
                                        <th>Order Total</th>
                                        <th>Quantity</th>
                                        <th>Category</th>
                                        <th>Note</th>
                                        <th class="sticky-col text-center">Actions</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <!-- Row 1 -->
                                    <tr class="small">
                                        <td><input type="checkbox" class="form-check-input"></td>
                                        <td>2025/09/20</td>
                                        <td>B09XYZ123</td>
                                        <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                        <td>Wireless Headphones</td>
                                        <td><span class="badge bg-primary">Hot</span> <span class="badge bg-success">New</span></td>
                                        <td>Supplier A</td>
                                        <td>$789</td>
                                        <td>12,345</td>
                                        <td>Electronics</td>
                                        <td>Good margin</td>
                                        <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            <button class="btn btn-sm btn-light"><i class="ti ti-eye"></i></button>
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                
                                                <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                            </ul>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <!-- Row 2 -->
                                    <tr class="small">
                                        <td><input type="checkbox" class="form-check-input"></td>
                                        <td>2025/09/18</td>
                                        <td>B07ABC456</td>
                                        <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                        <td>Vacuum Cleaner</td>
                                        <td><span class="badge bg-info">Trending</span></td>
                                        <td>Supplier B</td>
                                        <td>$599</td>
                                        <td>8,765</td>
                                        <td>Home Appliances</td>
                                        <td>High Demand</td>
                                        <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            
                                            <button class="btn btn-sm btn-light"><i class="ti ti-eye"></i></button>
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                
                                                <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                            </ul>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <!-- Row 3 -->
                                    <tr class="small">
                                        <td><input type="checkbox" class="form-check-input"></td>
                                        <td>2025/09/10</td>
                                        <td>B08LMN789</td>
                                        <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                        <td>Football Shoes</td>
                                        <td><span class="badge bg-warning">Seasonal</span></td>
                                        <td>Supplier C</td>
                                        <td>$249</td>
                                        <td>6,540</td>
                                        <td>Sports</td>
                                        <td>Good performance</td>
                                        <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            
                                            <button class="btn btn-sm btn-light"><i class="ti ti-eye"></i></button>
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                
                                                <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                            </ul>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>

                                    <!-- Row 4 -->
                                    <tr class="small">
                                        <td><input type="checkbox" class="form-check-input"></td>
                                        <td>2025/09/05</td>
                                        <td>B06PQR321</td>
                                        <td><img src="https://images-na.ssl-images-amazon.com/images/I/61lABmqUxRL.jpg" class="img-thumbnail" width="50" alt=""></td>
                                        <td>Smart Watch</td>
                                        <td><span class="badge bg-secondary">Limited</span></td>
                                        <td>Supplier D</td>
                                        <td>$399</td>
                                        <td>4,230</td>
                                        <td>Wearables</td>
                                        <td>Battery efficient</td>
                                        <td class="text-center sticky-col">
                                        <div class="d-flex justify-content-center gap-1">
                                            
                                            <button class="btn btn-sm btn-light"><i class="ti ti-eye"></i></button>
                                            <div class="dropdown">
                                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                
                                                <li><a class="dropdown-item" href="#"><i class="ti ti-edit me-2"></i>Edit</a></li>
                                                <li><a class="dropdown-item text-danger" href="#"><i class="ti ti-trash me-2"></i>Delete</a></li>
                                            </ul>
                                            </div>
                                        </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#leads-table').DataTable({
            scrollY: '40vh',
            searching: false,
            lengthChange: false,
            ordering: false,
            scrollX: true,
            scrollCollapse: true,
            paging: true,
        });
    });
</script>
@endsection