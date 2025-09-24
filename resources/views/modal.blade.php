<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal Bootstrap Example</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/modal.css') }}">
</head>

<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

    <!-- Trigger Button -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cookiesModal">
        Open Modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="cookiesModal" tabindex="-1" aria-labelledby="cookiesModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4" style="border-radius: 20px;">
                <img src="{{ asset('assets/img/warning.png') }}" alt="warning" width="80" class=" m-auto mb-3">
                <h5 class="mb-3">We use cookies</h5>
                <p class="mb-4">We use cookies for improving user experience, analytics and marketing.</p>
                <button type="button" class="btn btn-success w-100" data-bs-dismiss="modal">That's fine!</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (Popper + Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
