@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><i class="fa fa-list"></i> {{ __('Posts List') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div id="notification"></div>

                        <p><strong>Create New Post</strong></p>
                        <form method="post" action="{{ route('posts.store') }}">
                            @csrf
                            <div class="form-group">
                                <label>Title:</label>
                                <input type="text" name="title" class="form-control" />
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Body:</label>
                                <textarea class="form-control" name="body"></textarea>
                                @error('body')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-success btn-block"><i class="fa fa-save"></i>
                                    Submit</button>
                            </div>
                        </form>

                        <p class="mt-4"><strong>Post List:</strong></p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Body</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr>
                                        <td>{{ $post->id }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->body }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">There are no posts.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="module">
        window.Echo.channel('posts')
            .listen('.create', (data) => {
                var notificationDiv = document.getElementById('notification');
                notificationDiv.insertAdjacentHTML('beforeend',
                    '<div class="alert alert-success alert-dismissible fade show"><span><i class="fa fa-circle-check"></i> ' +
                    data.message + '</span></div>');
            });
    </script>
@endsection
