@extends('layouts.template')

@section('styles')
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <style>
        body {
            margin: 0;
            font-family: 'Fredoka', sans-serif;
            background: linear-gradient(to bottom, #fcebd4 0%, #fff8f5 60%, #fffdfb 100%);
            color: #3b3a30;
        }

        /* Animasi */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .sarekene-hero,
        .features,
        .feature-card {
            animation: fadeInUp 0.8s ease-out both;
        }

        .feature-card:nth-child(2) {
            animation-delay: 0.15s;
        }

        .feature-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .sarekene-hero {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 10px 10px 10px 10px;
            text-align: center;
        }

        .sarekene-hero h1 {
            font-size: 3rem;
            font-weight: 700;
            padding-top: 40px;
            margin-bottom: 10px;
            color: #A26769;
            letter-spacing: 1px;
        }

        .sarekene-tagline {
            font-size: 1.6rem;
            font-weight: 600;
            color: #5E3D2B;
            margin-bottom: 20px;
        }

        .sarekene-description {
            font-size: 1.1rem;
            max-width: 720px;
            color: #3B2F2F;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .btn-sarekene {
            background-color: #A26769;
            color: #fff;
            padding: 14px 30px;
            font-size: 1.2rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-sarekene:hover {
            background-color: #8C5B5C;
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            padding: 60px 20px;
            max-width: 1000px;
            margin: 0 auto;
            background: transparent;
        }

        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: all 0.3s ease;
            transform: translateY(0);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
            border: 1px solid #e3c1ba;
        }

        .feature-card img {
            width: 70px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .feature-card:hover img {
            transform: scale(1.1);
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: #4b3832;
        }

        .feature-desc {
            font-size: 1rem;
            color: #6b5e52;
            line-height: 1.6;
        }

        .testimonials {
            padding: 80px 20px;
            background: transparent;
            text-align: center;
        }

        .testimonial-title {
            font-size: 2rem;
            font-weight: 700;
            color: #A26769;
            margin-bottom: 40px;
        }

        .swiper {
            width: 100%;
            max-width: 1000px;
            padding-bottom: 50px;
        }

        .testimonial-card {
            background-color: #e3c1ba;
            border-radius: 16px;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.05);
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-6px);
        }

        .testimonial-card img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 12px;
        }

        .testimonial-card p {
            font-size: 1rem;
            color: #5E3D2B;
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .testimonial-card strong {
            font-weight: 600;
            color: #A26769;
        }

        .footer {
            text-align: center;
            padding: 40px 20px;
            font-size: 0.9rem;
            color: #999;
        }

        .sarekene-logo {
            width: 160px;
            height: auto;
            margin-top: 10px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
            animation: zoomFadeIn 0.8s ease-out forwards;
        }


        .sarekene-logo:hover {
            transform: scale(1.05);
        }

        .custom-navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background-color: #e5d3bd !important;
    border-bottom: 1px solid #d8bba6;
    font-family: 'Fredoka', sans-serif;
    font-weight: 500;
    padding: 12px 20px;
    z-index: 1050; /* pastikan di atas elemen lain */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

/* Brand/logo */
.custom-navbar .navbar-brand {
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #3B2F2F;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-decoration: none;
}

.custom-navbar .navbar-brand img {
    height: 32px; /* sedikit lebih besar agar lebih terlihat */
}

/* Link navbar */
.custom-navbar .nav-link {
    color: #3B2F2F !important;
    font-weight: 500;
    transition: color 0.3s ease;
}

.custom-navbar .nav-link:hover {
    color: #8C5B5C !important;
}

/* Search input */
.custom-navbar .form-control {
    border-radius: 20px 0 0 20px;
    background-color: #fdf7f0;
    border: 1px solid #e5d3bd;
    color: #3B2F2F;
    padding: 6px 14px;
    box-shadow: none;
}

.custom-navbar .form-control::placeholder {
    color: #b79c84;
}

/* Tombol pencarian */
.btn-cari {
    background-color: #A26769;
    color: white;
    font-weight: 600;
    border: none;
    transition: all 0.3s ease;
    border-radius: 0 20px 20px 0;
    padding: 6px 16px;
    box-shadow: none;
}

.btn-cari:hover {
    background-color: #8C5B5C;
    color: #fff;
}

/* Icon pencarian */
.custom-navbar i.fa-search {
    color: white;
}


        @media (max-width: 768px) {
            .sarekene-hero h1 {
                font-size: 3rem;
                padding-top: 40px;
            }

            .sarekene-tagline {
                font-size: 1.4rem;
            }

            .sarekene-description {
                font-size: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="sarekene-hero">
        <img src="{{ asset('build/assets/icon/logo_web2.png') }}" alt="Sare Kene Icon" class="sarekene-logo">
        <h1>Sare Kene</h1>
        <p class="sarekene-tagline">Cari Hotel? <strong>Sare Kene Aja.</strong></p>
        <p class="sarekene-description">
            Selamat datang di <strong>Sare Kene</strong>, panduan visual dan interaktif untuk menemukan tempat menginap
            terbaik di Kota Yogyakarta.<br>
            Dari review jujur pengguna, hingga foto dan rating, semua bisa kamu lihat langsung dari peta.<br>
            <em>Yuk, sare kene wae.</em>
        </p>
        <a href="/map" class="btn-sarekene">Lihat Peta Sekarang</a>
    </div>

    <!-- Divider Gradasi Halus -->
    <div style="height: 40px; background: linear-gradient(to bottom, #f5f0ec00, #f5f0ec);"></div>

    <div class="features">
        <div class="feature-card">
            <img src="{{ asset('build/assets/icon/search.svg') }}" alt="Search">
            <h3 class="feature-title">Cari Mudah</h3>
            <p class="feature-desc">Filter dan temukan hotel sesuai keinginanmu dalam hitungan detik.</p>
        </div>
        <div class="feature-card">
            <img src="{{ asset('build/assets/icon/review.svg') }}" alt="Review">
            <h3 class="feature-title">Ulasan Asli</h3>
            <p class="feature-desc">Lihat ulasan jujur dari pengunjung yang sudah mencoba.</p>
        </div>
        <div class="feature-card">
            <img src="{{ asset('build/assets/icon/map.svg') }}" alt="Map">
            <h3 class="feature-title">Peta Interaktif</h3>
            <p class="feature-desc">Tampilkan lokasi hotel secara akurat langsung di peta.</p>
        </div>
    </div>

    <!-- TESTIMONI SECTION -->
    <div class="testimonials">
        <h2 class="testimonial-title">Foto Hotel dari Pengguna</h2>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @forelse ($fotos as $foto)
                    <div class="swiper-slide testimonial-card">
                        <img src="{{ asset($foto) }}" alt="Foto Hotel">
                    </div>
                @empty
                    <div class="swiper-slide testimonial-card">
                        <p>Belum ada foto yang diunggah pengguna.</p>
                    </div>
                @endforelse
            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <div class="footer">
        © 2025 Sare Kene · Semua hak cipta dilindungi
    </div>
@endsection

@section('scripts')
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>
@endsection
