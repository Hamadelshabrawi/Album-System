@extends('layouts.app')
@section('title')
    Albums
@endsection

@section('page title')
    Albums
@endsection

@section('content')

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAlbumModal">
        Create Album
    </button>

    <div class="container">

        <!-- Modal -->
        <div class="modal fade" id="createAlbumModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Album</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Album Name Input -->
                        <form action="{{ route('albums.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="albumName">Album Name</label>
                                <input type="text" class="form-control" id="albumName" name="albumName" value="{{ old('albumName') }}">
                            </div>

                            <!-- Input to Add Extra Images -->
                            <div class="form-group">
                                <label for="additionalImages">Add Images</label>
                                <input type="file" id="image-input" accept="image/*" name="images[]" multiple>
                            </div>

                            <!-- Display Input Fields for New Image Titles -->
                            <div id="additional-images-titles">
                                <!-- Input fields for new image titles will be added here -->
                            </div>

                            <!-- Display Preview of Uploaded Images -->
                            <div id="image-preview"></div>
                            <!-- New image previews will be displayed here -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <table class="table" id="tableid">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Number of image</th>
                <th>Created By</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @php $i = 1 ; @endphp
            @foreach ($albums as $album)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $album->name }}</td>
                    <td>{{ $album->pictures->count() }}</td>
                    <td>{{ $album->user->name }}</td>
                    <td>{{ $album->created_at }}</td>
                    <td>
                        <!-- Button trigger modal -->

{{--                        <a href="{{url('show_albbum',$album->id)}}" class="btn btn-warning">--}}
{{--                            Show--}}
{{--                        </a>--}}

                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#viewAlbumModal-{{$album->id}}">
                            View
                        </button>
                        <div class="modal fade" id="viewAlbumModal-{{$album->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteAlbumModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteAlbumModalLabel">Show Album</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="slider">

                                            @if($album->pictures->count() !== 0)
                                            <div class="slides">
                                                @foreach( $album->pictures as $index => $fileImages )
                                                <div id="slide-{{$index}}">
                                                    <img src="{{ asset('storage/pictures/' . $fileImages->name) }}" alt="" srcset="">
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                            Album Is Empty
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <a href="{{url('album_edit',$album->id)}}" class="btn btn-warning">
                            Edit
                        </a>
                        @if( $album->pictures->count() >= 1 )

                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAlbumModal-{{$album->id}}">
                            Delete or transfer images
                        </button>
                        <div class="modal fade" id="deleteAlbumModal-{{$album->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteAlbumModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteAlbumModalLabel">Delete Album</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete this album?</p>
                                            <p>If you want to transfer images from this album to another, select the target album below:</p>

                                            <form action="{{ route('albums.remove', $album->id) }}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="targetAlbum">Transfer To Album</label>
                                                    <select class="form-control" id="targetAlbum" name="targetAlbum">
                                                        <option name="targetAlbum" value="">Select an album</option>
                                                        @foreach($albums as $otherAlbum)
                                                            <option value="{{ $otherAlbum->id }}" {{ $otherAlbum->id == $album->id ? 'disabled' : '' }} >{{ $otherAlbum->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Transfer Images and Delete</button>
                                            </form>
                                            <br>
                                            <a class="btn btn-danger" href="{{ route('albumsRemove', $album->id) }}">Delete Album And Images</a>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a class="btn btn-danger" href="{{ route('albumsRemove', $album->id) }}">Delete</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
