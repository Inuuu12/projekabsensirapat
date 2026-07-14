<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-5">
          <div class="card shadow-sm">
            <div class="card-body">
              <h3 class="card-title mb-4">Admin Login</h3>
              @if ($errors->any())
                <div class="alert alert-danger py-2">
                  <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              <form method="POST" action="/admin/login">
                @csrf
                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input name="email" type="email" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label class="form-label">Password</label>
                  <input name="password" type="password" class="form-control" required>
                </div>
                <button class="btn btn-primary">Masuk</button>
              </form>
            </div>
          </div>
        </div>

    </div>

</body>
</html>