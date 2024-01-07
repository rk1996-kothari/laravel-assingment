@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Upload Image') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('images.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="image" class="form-label">Choose Image</label>
                            <input type="file" class="form-control" id="imageInput" name="image" accept="image/*" required>
                        </div>

                        <input type="hidden" id="croppedImageInput" name="croppedImage">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>

                    <div class="mt-4">
                        <h3>Image Preview</h3>
                        <!-- Add an img element for preview -->
                        <img id="previewImage" class="img-fluid" alt="Image Preview">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageInput = document.getElementById('imageInput');
        const previewImage = document.getElementById('previewImage');
        const croppedImageInput = document.getElementById('croppedImageInput');

        const cropper = new Cropper(previewImage, {
            aspectRatio: 16 / 9,
            viewMode: 2,
            autoCropArea: 1,
            checkOrientation: false,
            responsive: true,
            cropBoxResizable: false,
            minContainerWidth: 300,
            minContainerHeight: 200,
        });

        imageInput.addEventListener('change', function (e) {
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function (event) {
                    previewImage.src = event.target.result;
                    cropper.replace(event.target.result);
                };

                reader.readAsDataURL(file);
            }
        });
         // Add a listener to update the hidden input with cropped image data
         document.getElementById('imageInput').addEventListener('change', function () {
            const canvas = cropper.getCroppedCanvas();
            const croppedImageData = canvas.toDataURL(); // Get base64-encoded data
            croppedImageInput.value = croppedImageData; // Set value of the hidden input
        });
    });
</script>
@endsection
