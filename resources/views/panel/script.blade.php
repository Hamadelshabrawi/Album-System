<!-- jQuery -->
{{--<script src="{{asset('/panel/js/jquery.min.js')}}"></script>--}}

<!-- Bootstrap Core JavaScript -->
<script src="{{asset('/panel/js/bootstrap.min.js')}}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{asset('/panel/js/metisMenu.min.js')}}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{asset('/panel/js/startmin.js')}}"></script>

<!-- images Preview   -->

<script>

    // close alert afer 4 second
    $(".alert").delay(8000).slideUp(200, function() {
        $(this).alert('close');
    });


</script>

<script>
    // datatable

    $(document).ready( function () {
        $('#tableid').DataTable();
    } );
</script>


<script>
    function handleFileSelect(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('image-preview');

        previewContainer.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function (event) {
                // Create a div to hold each image and its title input
                const imageDiv = document.createElement('div');
                imageDiv.classList.add('image-with-title');

                // Create an image element
                const img = document.createElement('img');
                img.src = event.target.result;
                img.classList.add('preview-image');
                imageDiv.appendChild(img);

                // Create an input field for the image title
                const titleInput = document.createElement('input');
                titleInput.type = 'text';
                titleInput.placeholder = 'Image Title';
                titleInput.name = `imageTitles[${i}]`;
                titleInput.className = `form-control`;
                imageDiv.appendChild(titleInput);

                previewContainer.appendChild(imageDiv);
            };

            reader.readAsDataURL(file);
        }
    }
    const imageInput = document.getElementById('image-input');
    imageInput.addEventListener('change', handleFileSelect);
</script>

{{--edit perview --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editForm = document.getElementById('editAlbumForm');
        const imageInput = editForm ? editForm.querySelector('#additionalImages') : null;

        if (imageInput) {
            imageInput.addEventListener('change', handleFileSelect);
        }

        function handleFileSelect(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('image-preview');

            previewContainer.innerHTML = '';

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function (event) {
                    // Create a div to hold each image and its title input
                    const imageDiv = document.createElement('div');
                    imageDiv.classList.add('image-with-title');

                    // Create an image element
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    img.classList.add('preview-image');
                    imageDiv.appendChild(img);

                    // Create an input field for the image title
                    const titleInput = document.createElement('input');
                    titleInput.type = 'text';
                    titleInput.placeholder = 'Image Title';
                    titleInput.name = `imageTitles[${i}]`;
                    titleInput.className = `form-control`;
                    imageDiv.appendChild(titleInput);

                    previewContainer.appendChild(imageDiv);
                };

                reader.readAsDataURL(file);
            }
        }
    });
</script>


