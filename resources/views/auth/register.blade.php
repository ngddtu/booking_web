<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #007bff 0%, #6610f2 100%);
            font-family: 'Segoe UI', sans-serif;
        }

        .register-card {
            width: 100%;
            max-width: 450px;
            border-radius: 15px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
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

    <div class="card register-card border-0">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h4 class="fw-bold text-primary">Tạo tài khoản mới</h4>
                <p class="text-muted small">Điền thông tin để đăng ký hệ thống</p>
            </div>
            {{ $message ?? null }}
            <form method="POST" action="/register">
                @csrf

                <!-- Họ tên -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Họ và tên</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user text-muted"></i></span>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                            placeholder="Nguyễn Văn A">
                    </div>
                    @error('name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                            placeholder="email@example.com">
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Số điện thoại -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Số điện thoại</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone text-muted"></i></span>
                        <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}"
                            placeholder="0123 456 789">
                    </div>
                    @error('phone')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mật khẩu -->
                <div class="mb-3">
                    <label class="form-label small fw-bold text-secondary">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="Tối thiểu 6 ký tự">
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nhập lại mật khẩu -->
                <div class="mb-4">
                    <label class="form-label small fw-bold text-secondary">Nhập lại mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-check-circle text-muted"></i></span>
                        <input type="password" class="form-control" name="password_confirmation"
                            placeholder="Xác nhận mật khẩu">
                    </div>
                    @error('password_confirmation')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                    Đăng ký <i class="fas fa-user-plus ms-2"></i>
                </button>
            </form>

        </div>
        <div class="card-footer bg-white text-center py-3">
            <small class="text-muted">Đã có tài khoản? <a href="/login" class="fw-bold text-decoration-none">Đăng
                    nhập</a></small>
        </div>
    </div>

</body>

</html>
