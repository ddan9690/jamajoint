@extends('backend.layout.master')
@section('title', 'Exam Results')
@section('content')
    <div class="container">
        <h5 class="text-warning text-uppercase">{{ $exam->name }} Form {{ $exam->form->name }} Term {{ $exam->term }}
            {{ $exam->year }}</h5>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
            <div class="col mb-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('results.myschool', ['exam_id' => $exam->id, 'form_id' => $exam->form->id, 'slug' => Str::slug($exam->name)]) }}"
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-school"></i> My School Results
                        </a>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('results.all-school', ['id' => $exam->id, 'slug' => Str::slug($exam->name)]) }}"
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-trophy"></i> School Ranking
                        </a>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('results.overall-students-results', ['id' => $exam->id, 'form_id' => $exam->form->id, 'slug' => $exam->slug]) }}"
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-graduation-cap"></i> Overall Student Ranking
                        </a>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('results.stream-ranking', ['id' => $exam->id, 'form_id' => $exam->form->id, 'slug' => $exam->slug]) }}"
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-chart-bar"></i> Stream Ranking
                        </a>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('results.top-performances', ['exam_id' => $exam->id, 'form_id' => $exam->form->id, 'slug' => $exam->slug]) }}"
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-star"></i> Top Performances
                        </a>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('results.paper1Analysis', ['exam_id' => $exam->id, 'form_id' => $exam->form_id, 'slug' => $exam->slug]) }}"
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-file-alt"></i> PAPER 1 ANALYSIS
                        </a>
                    </div>
                </div>
            </div>

            <div class="col mb-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('results.paper2Analysis', ['exam_id' => $exam->id, 'form_id' => $exam->form->id, 'slug' => $exam->slug]) }}"
                            class="btn btn-sm btn-primary">
                            <i class="fas fa-file-alt"></i> PAPER 2 ANALYSIS
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
