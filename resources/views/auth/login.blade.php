<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>{{$title}}</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    
    <!-- Core CSS -->
    <link href="{{asset('assets/dashboard/css/vendor.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/dashboard/css/facebook/app.min.css')}}" rel="stylesheet" />
    
    <!-- Custom Modern Styling -->
    <style>
        :root {
            --primary-color: #2a93d5;
            --primary-hover: #1f82c4;
            --text-main: #1e214e;
            --text-muted: #64748b;
            --bg-input: #f8fafc;
            --border-color: rgba(148, 163, 184, 0.25);
        }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            color: #334155;
            overflow-x: hidden;
        }

        /* Layout Utama Modern Split-Screen */
        .auth-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100vw;
            background-color: #ffffff;
        }

        /* Sisi Kiri: Background / News Feed */
        .auth-sidebar {
            flex: 1;
            position: relative;
            background-size: cover;
            background-position: center;
            display: none;
        }

        @media (min-width: 992px) {
            .auth-sidebar {
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                padding: 60px;
            }
        }

        .auth-sidebar-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(30, 33, 78, 0.75) 0%, rgba(42, 147, 213, 0.65) 100%);
        }

        .auth-sidebar-content {
            position: relative;
            z-index: 2;
            color: #ffffff;
        }

        .auth-sidebar-content h2 {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.03em;
            margin-bottom: 12px;
            color: #ffffff;
        }

        .auth-sidebar-content p {
            font-size: 16px;
            opacity: 0.9;
            margin: 0;
            line-height: 1.5;
        }

        /* Sisi Kanan: Form Container */
        .auth-form-container {
            width: 100%;
            max-width: 520px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px 30px;
            margin: auto;
        }

        @media (min-width: 992px) {
            .auth-form-container {
                padding: 60px 80px;
                max-width: 600px;
            }
        }

        .auth-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.03em;
            margin-bottom: 8px;
        }

        .auth-header p {
            color: var(--text-muted);
            font-size: 15px;
            margin-bottom: 32px;
        }

        /* Styling Input Form Modern */
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            background-color: var(--bg-input);
            font-size: 15px;
            color: #334155;
            transition: all 0.2s ease;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(42, 147, 213, 0.12) !important;
            outline: none;
        }

        /* Tombol Modern */
        .btn-auth-submit {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 14px;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(42, 147, 213, 0.25);
        }

        .btn-auth-submit:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(42, 147, 213, 0.35);
        }

        /* Alert error */
        .alert-danger {
            border-radius: 12px;
            font-size: 14px;
            border: none;
            background-color: #fef2f2;
            color: #991b1b;
            padding: 14px 16px;
            margin-bottom: 24px;
        }

        .text-danger-msg {
            font-size: 13px;
            color: #dc2626;
            margin-top: 6px;
            display: block;
        }
    </style>
</head>
<body class="pace-top">

    <div id="app" class="app">
        <div class="auth-wrapper">
            
            <!-- Sisi Kiri (Ilustrasi / Background Dinamis) -->
            <div class="auth-sidebar" style="background-image: url({{asset('storage/' . App\Models\Content::where('name', 'slider_background')->first()->description)}})">
                <div class="auth-sidebar-overlay"></div>
                <div class="auth-sidebar-content">
                    <h2>{{App\Models\Content::where('name', 'name')->first()->description}}</h2>
                    <p>Welcome back! Please sign in to access your dashboard and manage your account seamlessly.</p>
                </div>
            </div>

            <!-- Sisi Kanan (Form Login) -->
            <div class="auth-form-container">
                <div class="auth-header">
                    <h1>Sign In</h1>
                    <p>Enter your credentials to access your account.</p>
                </div>

                @if (session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        <i class="fa fa-exclamation-circle me-2"></i> {{session('error')}}
                    </div>
                @endif

                <form action="/auth/login" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="name@example.com" autocomplete="email" />
                        @error('email')
                            <span class="text-danger-msg">{{$message}}</span>
                        @enderror
                    </div>
                
                    <div class="mb-4">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" />
                        @error('password')
                            <span class="text-danger-msg">{{$message}}</span>
                        @enderror
                    </div>
                
                    <div class="mb-4 pt-2">
                        <button type="submit" class="btn btn-auth-submit d-block w-100">Sign In</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    
</body>
</html>