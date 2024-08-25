<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        .full-height {
            min-height: 100vh;
        }

        .wrapper {
            background-color: #dcfeff;
            padding: 20px;
            width: fit-content;
            border-radius: 50px;
        }
        .wrapper h1,
        .wrapper h5,
        .wrapper p{
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container-fluid d-flex flex-column justify-content-center align-items-center full-height">
        <div class="wrapper d-flex flex-column justify-content-center align-items-center">
            <img src="{{ asset('assets/images/error.png') }}" alt="Error Image" class="img-fluid" style="max-width: 20%;">
            <h1 class="mt-4">Error {{ $code }}</h1>
            <h5 class="mt-2">{{ $message }}</h5>
            <p class="mt-2">Silahkan kembali ke halaman home untuk melanjutkan pekerjaan kamu</p>
            <form action="/" method="GET" style="display:inline;">
                @csrf
                @method('GET')
                <button type="submit" class="btn btn-info mt-3">Kembali</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>