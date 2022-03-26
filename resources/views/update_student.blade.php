<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center">
        <div class="row">
            <form id="update-form">
                @csrf
                <input value="{{ $student->id }}" style="display: none;" name="id" class="form-control">

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Name</label>
                    <input name="name" value="{{ $student->name }}" class="form-control"
                        id="exampleFormControlInput1">
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input name="image" type="file" class="form-control">
                </div>

                <div class="mb-3">
                    <button type="button" id="submit-btn" class="btn btn-primary">Submit</button>
                </div>

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                @endif
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $("#submit-btn").on("click", function() {
            console.log('asd');
            let formData = new FormData(document.getElementById('update-form'));
            $.ajax({
                url: "/students/update",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                type: "POST",
                success: async function(result) {
                    alert("Student data updated successfully");
                    window.location.href = "/students";

                },
                error: function(response, textStatus, errorMessage) {
                    if (response.status === 422) {
                        var errors = JSON.parse(response.responseText);
                        $.each(errors, function(key, val) {
                            alert(val);
                        });
                    }
                },
                complete: function() {}
            })
        })
    </script>
</body>

</html>
