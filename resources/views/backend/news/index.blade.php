@extends('backend.layout.master')

@section('title', 'News Index')

@section('content')
    <style>
        /* Prevent text wrapping */
        .table td,
        .table th {
            white-space: nowrap;
        }
    </style>
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Manage News</h6>
                <a href="{{ route('news.create') }}" class="btn btn-primary btn-sm">Compose</a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (count($news) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover" id="newsTable">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    {{-- <th>Author</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($news as $index => $item)
                                    <tr>
                                        <td><a
                                                href="{{ route('news.show', ['id' => $item->id, 'slug' => $item->slug]) }}">{{ $item->title }}</a>
                                        </td>
                                        {{-- <td>{{ $item->user->name }}</td> --}}
                                        <td class="d-flex ">
                                            <a href="{{ route('news.edit', $item->id) }}"
                                                class="btn mr-1 btn-sm btn-success">Edit</a>
                                            <form method="POST" action="{{ route('news.destroy', $item->id) }}"
                                                class="delete-news-form"
                                                onsubmit="return confirm('Are you sure you want to delete this news item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>No news item. Click <span class="text-primary">compose</span> to create</p>
                @endif

            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            // $('#newsTable').DataTable();
            // Handle Delete News with AJAX and SweetAlert
            $('.delete-news').click(function() {
                var newsId = $(this).data('id');
                var deleteUrl = '{{ route('news.destroy', '') }}/' + newsId;

                // Show SweetAlert confirmation
                swal({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this news!',
                    icon: 'warning',
                    buttons: ['Cancel', 'Delete'],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        // Send AJAX DELETE request to delete the news
                        $.ajax({
                            type: 'DELETE',
                            url: deleteUrl,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                // Remove the deleted news row from the table
                                $('tr[data-id="' + newsId + '"]').remove();
                                swal('News deleted successfully! Refresh the Page', {
                                    icon: 'success',
                                });
                                // location.reload();
                            },
                            error: function(error) {
                                swal('Error!', error.responseJSON.message, 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
