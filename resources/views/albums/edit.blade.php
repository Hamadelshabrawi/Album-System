@extends('layouts.app')
@section('title')
    Edit albums
@endsection

@section('page title')
    Edit albums
@endsection

@section('content')
    <form action="{{ route('albums.update', $albums->id) }}" method="POST" enctype="multipart/form-data" id="editAlbumForm">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="albumName">Album Name</label>
            <input type="text" class="form-control" id="albumName" name="albumName" value="{{ $albums->name }}">
        </div>

        <div class="form-group">
            <label for="additionalImages">Add Images</label>
            <input type="file" class="form-control" id="additionalImages" name="additionalImages[]" multiple>
        </div>

        <h4>Existing Images:</h4>
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Download</th>
                    <th>Remove</th>
                </tr>
                </thead>
                <tbody>
                @foreach($albums->pictures as $index => $files)

                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <input type="text" class="form-control" id="imageNames[{{ $files->id }}]" name="imageNames[{{ $files->id }}]" value="{{ pathinfo($files->name, PATHINFO_FILENAME) }}">
                    </td>
                    <td><a> <img class="imageTitle" src="{{ asset('storage/pictures/' . $files->name) }}" alt=""></a></td>
                    <td><a href="{{ asset('storage/pictures/' . $files->name) }}" download><i class="fa fa-download"></i></a></td>
                    <td><input type="checkbox" name="removeImages[]" value="{{ $files->id }}"> Remove</td>
                </tr>
                @endforeach

                </tbody>
            </table>


        <!-- Display Input Fields for New Image Titles -->
        @if ($errors->has('newImageTitles'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('newImageTitles') }}
            </div>
        @endif

        <div id="additional-images-titles">
        </div>

        <!-- Display Preview of Uploaded Images -->
        <div id="image-preview">
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>


@endsection

