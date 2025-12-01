<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Hotel PMS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
            /* Màu nền Gradient */
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: white;
            border-bottom: none;
            padding-top: 30px;
            text-align: center;
        }

        .btn-login {
            padding: 10px;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }
    </style>
</head>

<body>

    <div class="card login-card border-0">
        <div class="card-header">
            <div class="mb-3">
                <i class="fas fa-hotel fa-3x text-primary"></i>
            </div>
            <h4 class="fw-bold text-dark">PMS Login</h4>
            <p class="text-muted small">Hệ thống quản lý khách sạn</p>
        </div>
        <div class="card-body p-4 pt-2">
            <!-- Form giả lập submit -->
            @if (session()->has('success'))
                <div class="container container--narrow">
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
            <form method="POST" action="/login">
                @csrf
                <div class="mb-3">
                    <label class="form-label text-secondary small fw-bold">Email / Tên đăng nhập</label>
                    <div class="input-group">
                        <span class="input-group-text text-muted"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="admin@hotel.com" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label text-secondary small fw-bold">Mật khẩu</label>
                        <a href="#" class="small text-decoration-none">Quên mật khẩu?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text text-muted"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="nhập mật khẩu">
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label small text-muted" for="remember">Ghi nhớ đăng nhập</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-login shadow-sm">
                    Đăng nhập <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </form>

        </div>
        <div class="card-footer bg-white text-center py-3 border-top-0">
            <small class="text-muted">Chưa có tài khoản? <a href="/register"
                    class="fw-bold text-decoration-none">Đăng ký ngay</a></small>
        </div>
    </div>



</body>

</html>
