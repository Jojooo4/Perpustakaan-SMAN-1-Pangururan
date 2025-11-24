<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem Perpustakaan SMAN 1 Pangururan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/logo-side.png') }}" type="image/x-icon">
    <style>
        :root {
            /* Exact palette values taken from your sample image */
            --navy: #2b3458;       /* deep navy */
            --navy-dark: #232a4a;  /* darker navy */
            --coral: #e84b63;      /* primary coral */
            --coral-2: #ff7b84;    /* lighter coral */
            --cream: #fbf9e7;      /* warm cream */
            --light-blue: #c7e1f2; /* pale blue */

           
            --primary-color: var(--navy);
            --primary-dark: var(--navy-dark);
            --secondary-color: var(--light-blue);
            /* Darker blue accent (from your palette) */
            --accent-color: #4aa0c9; /* darker blue */
            --accent-2: #2b7cae; /* deeper blue for gradients/shadows */

            --light-color: var(--cream);
            --dark-color: var(--navy);
            --success-color: #28a745;
            --warning-color: #ffc107;
            --card-bg: rgba(255, 255, 255, 0.95);
            --text-dark: #2c3e50;
            --text-light: #7f8c8d;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            padding: 15px;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('assets/bg-image.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: -2;
        }

        body::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, var(--primary-color) 30%, rgba(1, 116, 123, 0) 100%);
            z-index: -1;
        }

        .background-animation { position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; overflow: hidden; }
        .floating-shapes { position: absolute; width: 100%; height: 100%; }
        .shape { position: absolute; opacity: 0.5; border-radius: 50%; background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); animation: float 15s infinite ease-in-out; }
        .shape:nth-child(1) { width: 80px; height: 80px; top: 10%; left: 10%; animation-delay: 0s; }
        .shape:nth-child(2) { width: 120px; height: 120px; top: 70%; left: 80%; animation-delay: 2s; }
        .shape:nth-child(3) { width: 60px; height: 60px; top: 20%; left: 85%; animation-delay: 4s; }
        .shape:nth-child(4) { width: 100px; height: 100px; top: 80%; left: 15%; animation-delay: 6s; }
        .shape:nth-child(5) { width: 50px; height: 50px; top: 60%; left: 5%; animation-delay: 8s; }
        @keyframes float { 0%,100%{ transform: translateY(0) rotate(0deg); } 50%{ transform: translateY(-20px) rotate(10deg); } }

        .container-main { max-width: 1400px; margin: 0 auto; padding: 20px; }
        .hero-section { display:flex; flex-direction:column; align-items:center; justify-content:center; min-height:80vh; text-align:center; padding:40px 0; }
        .logo-container { position:relative; display:flex; flex-direction:column; align-items:center; justify-content:center; }
        .logo-image { max-height:150px; width:auto; }
        .title { color:white; font-weight:700; margin-bottom:15px; font-size:2.8rem; text-shadow:0 2px 10px rgba(0,0,0,0.2); }
        .subtitle { color:rgba(255,255,255,0.9); font-size:1.3rem; margin-bottom:40px; font-weight:400; max-width:600px; text-align:center; }
        .cta-buttons { display:flex; gap:20px; margin-bottom:18px; flex-wrap:wrap; justify-content:center; }
        .btn-login { 
            background: linear-gradient(90deg, var(--accent-color), var(--accent-2));
            color: #fff; 
            border: none; 
            padding: 16px 40px; 
            min-width: 200px;
            border-radius: 40px; 
            font-weight: 700; 
            font-size: 1.05rem; 
            transition: var(--transition); 
            box-shadow: 0 8px 30px rgba(0,0,0,0.18); 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            gap: 12px; 
        }
        .btn-visitor { background:rgba(255,255,255,0.15); backdrop-filter: blur(10px); color:white; border:2px solid white; padding:14px 40px; border-radius:50px; font-weight:600; font-size:1.1rem; transition:var(--transition); display:inline-flex; align-items:center; justify-content:center; gap:10px; }
        .features { display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:25px; margin-top:40px; width:100%; max-width:1000px; }
        .feature { background:rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius:20px; padding:25px; text-align:center; transition:var(--transition); border:1px solid rgba(255,255,255,0.2); color:white; cursor:pointer; transform-origin: center; }

        /* Interactive hover/focus for feature cards: scale, lift, stronger shadow and icon grow */
        .feature:focus { outline: none; }
        .feature:hover, .feature:focus {
            transform: translateY(-8px) scale(1.04);
            box-shadow: 0 18px 40px rgba(0,0,0,0.18);
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(6px);
            border-color: rgba(255,255,255,0.28);
        }

        .feature i {
            display:inline-block;
            font-size:1.6rem;
            margin-bottom:12px;
            transition:var(--transition);
            color: rgba(255,255,255,0.95);
        }

        .feature:hover i, .feature:focus i {
            transform: scale(1.25);
            color: var(--accent-color);
        }

        /* Stronger override to ensure .card default doesn't make it opaque */
        .card.pengunjung-card {
            /* make the card more transparent so background shows through clearly */
            background: rgba(255,255,255,0.06) !important;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 20px;
            padding: 12px;
            border: 1px solid rgba(255,255,255,0.10);
            color: white;
            box-shadow: 0 8px 22px rgba(0,0,0,0.10);
            transition: var(--transition);
            text-align: center;
        }

        /* ensure inner card body is transparent so the outer background shows */
        .card.pengunjung-card .card-body { background: transparent !important; padding: 12px 10px; }

        .card.pengunjung-card .fa-users {
            display: inline-block;
            width: 56px;
            height: 56px;
            line-height: 56px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            color: var(--accent-color);
            font-size: 1.4rem;
            margin-bottom: 10px;
            transition: var(--transition);
        }

        .card.pengunjung-card h6 { color: rgba(255,255,255,0.95); font-weight:700; margin-bottom:6px; }
        .card.pengunjung-card h2 { color: #ffffff; font-weight:800; margin:0; font-size:2rem; }
        .card.pengunjung-card p { color: rgba(255,255,255,0.9); margin-top:8px; }

        .card.pengunjung-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 16px 38px rgba(0,0,0,0.14);
            border-color: rgba(255,255,255,0.16);
        }

        .card.pengunjung-card:hover .fa-users { transform: scale(1.08); background: rgba(255,255,255,0.06); }

        .card { background:var(--card-bg); border-radius:20px; box-shadow:var(--shadow); border:none; transition:var(--transition); overflow:hidden; backdrop-filter: blur(10px); }

        .card-header { background: linear-gradient(135deg, var(--primary-dark), var(--primary-color)); color:white; font-weight:600; padding:20px 25px; border-bottom:none; display:flex; align-items:center; gap:10px; }

        .visitor-count { background: linear-gradient(135deg, var(--accent-color), var(--accent-2)); color:white; border-radius:15px; padding:25px; text-align:center; margin-bottom:25px; box-shadow:0 5px 15px rgba(74,160,201,0.18); position:relative; overflow:hidden; }

        .footer { margin-top:50px; color:white; text-align:center; font-size:0.9rem; opacity:0.8; padding:20px 0; }
    </style>
</head>

<body>
    <div class="background-animation">
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
    </div>

    <div class="container-main">
        <section class="hero-section fade-in">
            <div class="logo-container">
                <div class="logo-wrapper">
                    <img src="{{ asset('assets/logo-website.png') }}" class="logo-image" alt="Logo SMAN 1 Pangururan">
                </div>
                <h4 class="fw-medium text-white">Perpustakaan</h4>
                <h1 class="title fw-bolder text-uppercase">SMAN 1 Pangururan</h1>
                <p class="subtitle slide-up">Untuk memasuki sistem harap login terlebih dahulu</p>
            </div>

            <div class="cta-buttons slide-up">
                <a href="{{ route('login') }}" class="btn btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </a>
            </div>

            <div class="features slide-up">
                <div class="feature" tabindex="0" role="button">
                    <i class="fas fa-search"></i>
                    <h5>Cari Buku</h5>
                    <p>Temukan koleksi buku dengan mudah dan cepat</p>
                </div>
                <div class="feature" tabindex="0" role="button">
                    <i class="fas fa-book-open"></i>
                    <h5>Pinjam Buku</h5>
                    <p>Proses peminjaman yang cepat dan efisien</p>
                </div>
                <!-- Statistik card removed as requested; only two feature cards remain -->
            </div>

            <div class="mt-4 slide-up" style="max-width:420px;margin:30px auto 0;">
                <!-- Use the same translucent/interactable style as feature cards -->
                <div class="feature pengunjung-card text-center" tabindex="0" role="button">
                    <div class="card-body">
                        <i class="fas fa-users"></i>
                        <h6 class="mb-2 fw-semibold">Jumlah Pengunjung Hari Ini</h6>
                        <h2 id="totalPengunjung" class="mb-0">0</h2>
                    </div>
                </div>
            </div>
        </section>

        <!-- Visitor list removed -->

        <div class="footer fade-in">
            <p>&copy; {{ date('Y') }} Perpustakaan SMAN 1 PANGURURAN. All rights reserved.</p>
        </div>
    </div>

    <!-- Visitor modal removed as requested -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /* Visitor-related UI and JS removed as requested. Remaining scripts below. */

        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('slide-up'); observer.unobserve(entry.target); } });
            }, observerOptions);

            document.querySelectorAll('.card, .feature').forEach(el => { observer.observe(el); });

            // Load today's pengunjung count and update UI
            async function loadPengunjungCount() {
                try {
                    const res = await fetch('/pengunjung/hari-ini', { headers: { 'Accept': 'application/json' } });
                    if (!res.ok) return;
                    const data = await res.json();
                    const el = document.getElementById('totalPengunjung');
                    if (el && typeof data.count !== 'undefined') {
                        el.textContent = data.count;
                    }
                } catch (e) {
                    console.error('Failed to load pengunjung count', e);
                }
            }

            loadPengunjungCount();
        });
    </script>
</body>

</html>
