<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>e-Agenda - Daftar Agenda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
      :root {
        --primary-green: #2D5E55;
        --light-green: #E8F0EE;
        --accent-gold: #D4A34F;
        
      }
      body {
        background-color: #F8F9FA;
        font-family: 'Segoe UI', sans-serif;
      }
      /* Sidebar Styling */
      .sidebar {
        background-color: var(--primary-green);
        min-height: 100vh;
        color: white;
      }
      .sidebar .nav-link {
        color: rgba(255,255,255,0.75);
        border-radius: 8px;
        margin-bottom: 5px;
        padding: 10px 15px;
      }
      .sidebar .nav-link.active {
        background-color: rgba(255,255,255,0.15);
        color: white;
        font-weight: 600;
      }
      .sidebar .nav-link:hover {
        color: white;
        background-color: rgba(255,255,255,0.1);
      }
      /* Top Card Metrics */
      .metric-card {
        border: none;
        border-radius: 12px;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
      }
      .metric-icon-box {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      /* Table Customization */
      .table-container {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
      }
      .custom-table th {
        background-color: var(--primary-green) !important;
        color: white !important;
        font-weight: 500;
        border: none;
      }
      .custom-table td {
        vertical-align: middle;
      }
      .badge-ongoing {
        background-color: #FFF3CD;
        color: #856404;
        border: 1px solid #FFEBAA;
      }
    </style>
  </head>
  <body>

    <div class="container-fluid">
      <div class="row">
        
        <div class="col-md-3 col-lg-2 sidebar p-3 d-flex flex-column justify-content-between">
          <div>
            <div class="d-flex align-items-center mb-4 px-2">
              <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Coat_of_arms_of_Bogor_Regency.svg" alt="Logo" style="width: 35px;" class="me-2">
              <div>
                <h6 class="m-0 fw-bold tracking-wide">BAPPENDAS</h6>
                <small style="font-size: 10px; opacity: 0.6;">KABUPATEN BOGOR</small>
              </div>
            </div>
            
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link text-white-50" href="#"><i class="fa-solid fa-chart-pie me-2"></i> Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="/admin/agenda/lihat"><i class="fa-solid fa-calendar-days me-2"></i> Agenda</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white-50" href="#"><i class="fa-solid fa-users me-2"></i> Data Pengguna</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-white-50" href="/admin/aduan/lihat"><i class="fa-solid fa-comments me-2"></i> Aduan</a>
              </li>
            </ul>
          </div>

          <div class="px-2">
            <form method="POST" action="/admin/logout">
              @csrf
              <button class="btn btn-link nav-link w-100 text-start p-0 text-white-50" type="submit">
                <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar
              </button>
            </form>
          </div>
        </div>

        <div class="col-md-9 col-lg-10 p-4">
          
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <h4 class="fw-bold m-0 text-dark">Daftar Agenda</h4>
              <small class="text-muted">Selamat datang kembali, {{ session('admin_name', 'Admin') }}!</small>
            </div>
            <div class="d-flex align-items-center bg-white p-2 rounded-5 shadow-sm px-3">
              <div class="text-end me-2">
                <p class="m-0 small fw-bold text-dark">{{ session('admin_name', 'Admin') }}</p>
                <small class="text-muted" style="font-size: 11px;">Super Admin</small>
              </div>
              <img src="https://ui-avatars.com/api/?name=Admin&background=2D5E55&color=fff" alt="User" class="rounded-circle" style="width: 35px;">
            </div>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-6 col-lg-3">
              <div class="card metric-card p-3">
                <div class="d-flex align-items-center">
                  <div class="metric-icon-box bg-light text-dark me-3"><i class="fa-solid fa-layer-group"></i></div>
                  <div>
                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Total Agenda</small>
                    <h4 class="m-0 fw-bold">124</h4>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3">
              <div class="card metric-card p-3">
                <div class="d-flex align-items-center">
                  <div class="metric-icon-box text-warning me-3" style="background-color: #FFF3CD;"><i class="fa-solid fa-clock"></i></div>
                  <div>
                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Akan Datang</small>
                    <h4 class="m-0 fw-bold">8</h4>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3">
              <div class="card metric-card p-3">
                <div class="d-flex align-items-center">
                  <div class="metric-icon-box text-success me-3" style="background-color: #D1E7DD;"><i class="fa-solid fa-circle-check"></i></div>
                  <div>
                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Selesai</small>
                    <h4 class="m-0 fw-bold">86</h4>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-6 col-lg-3">
              <div class="card metric-card p-3">
                <div class="d-flex align-items-center">
                  <div class="metric-icon-box text-danger me-3" style="background-color: #F8D7DA;"><i class="fa-solid fa-calendar-xmark"></i></div>
                  <div>
                    <small class="text-muted text-uppercase fw-semibold" style="font-size: 11px;">Planned</small>
                    <h4 class="m-0 fw-bold">30</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="table-container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-2">
              <div class="input-group style-search" style="max-width: 300px;">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" class="form-control bg-light border-start-0 ps-0" placeholder="Cari agenda...">
              </div>
              <div>
                <button class="btn btn-success px-3 me-2" style="background-color: #2D5E55; border:none;">
                  <i class="fa-solid fa-plus me-1"></i> Tambah Agenda
                </button>
                <button class="btn btn-outline-secondary px-3">
                  <i class="fa-solid fa-filter me-1"></i> Filter Tanggal
                </button>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table custom-table table-hover align-middle">
                <thead>
                  <tr>
                    <th>Nama Agenda</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Asal Surat</th>
                    <th>Ditugaskan</th>
                    <th>Tempat</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($data as $agenda)
                  <tr>
                    <td>
                      <strong class="text-dark d-block">{{ $agenda->nama_agenda }}</strong>
                      <span class="text-muted small" style="font-size: 11px;">Internal Dept. Revenue</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($agenda->tanggal)->format('M d, Y') }}</td>
                    <td>{{ $agenda->waktu }} WIB</td>
                    <td><span class="text-muted">Dinas Kehutanan</span></td>
                    <td><span class="badge bg-light text-dark border p-2">BP Bambang P.</span></td>
                    <td><i class="fa-solid fa-video text-muted me-1"></i> {{ $agenda->lokasi }}</td>
                    <td><span class="badge badge-ongoing rounded-pill px-3 py-2">Ongoing</span></td>
                    <td class="text-center">
                      <div class="btn-group btn-group-sm">
                        <a href="#" class="btn btn-link text-success p-1"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="#" class="btn btn-link text-danger p-1"><i class="fa-solid fa-trash"></i></a>
                        <a href="#" class="btn btn-link text-primary p-1"><i class="fa-solid fa-circle-info"></i></a>
                      </div>
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="8" class="text-center py-4 text-muted">Belum ada data agenda yang tersedia.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

          </div>

        </div>

      </div>
    </div>

  </body>
</html>