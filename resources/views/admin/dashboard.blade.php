<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin</a>
        <div class="d-flex">
          <form method="POST" action="/admin/logout">
            @csrf
            <button class="btn btn-outline-light btn-sm">Logout</button>
          </form>
        </div>
      </div>
    </nav>

    <div class="container py-4">
      <h1>Selamat datang, {{ $admin->nama ?? $admin->username }}</h1>
      <p>Ini dashboard sederhana untuk testing autentikasi admin.</p>

      <div class="card mt-4">
        <div class="card-body">
          <h5 class="card-title">Quick links</h5>
          <ul>
            <li><a href="/admin/agenda/lihat">Lihat Agenda</a></li>
            <li><a href="/admin/aduan/lihat">Lihat Aduan</a></li>
          </ul>
        </div>
      </div>
    </div>
  </body>
</html>
