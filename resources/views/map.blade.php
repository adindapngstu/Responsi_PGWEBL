@extends('layouts.template')
@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

<main style="margin-top: 80px;">
    @yield('content')
</main>

@section('styles')
    <!-- Leaflet & Leaflet Draw -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

    <!-- Google Fonts: Fredoka -->
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Map size */
        #map {
            width: 100%;
            height: calc(100vh - 56px);
        }

        /* Navbar style agar sama seperti landing page */
        .custom-navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #e5d3bd;
            border-bottom: 1px solid #e3c1ba;
            font-family: 'Fredoka', sans-serif;
            z-index: 1050;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 12px 20px;
        }

        /* Brand/logo */
        .custom-navbar .navbar-brand {
            color: #3B2F2F;
            font-weight: 600;
            font-size: 1.2rem;
        }

        /* Nav link */
        .custom-navbar .nav-link {
            color: #3B2F2F;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .custom-navbar .nav-link:hover {
            color: #8C5B5C;
        }

        /* Search input */
        .custom-navbar .form-control {
            background-color: #fdf7f0;
            border: 1px solid #e5d3bd;
            color: #3B2F2F;
            border-radius: 20px 0 0 20px;
        }

        .custom-navbar .form-control::placeholder {
            color: #b79c84;
        }

        /* Tombol cari */
        .btn-cari {
            background-color: #A26769;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 0 20px 20px 0;
            transition: background-color 0.3s ease;
            padding: 0 16px;
        }

        .btn-cari:hover {
            background-color: #8C5B5C;
            color: #fff;
        }

        /* Normalisasi font seluruh halaman agar konsisten dengan landing */
        body {
            font-family: 'Fredoka', sans-serif !important;
            background-color: #fff8ef;
            margin: 0;
            padding: 0;
        }

        /* Ukuran dan tinggi navbar disamakan */
        .custom-navbar {
            height: 64px;
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 1rem;
            line-height: 1.5rem;
        }
    </style>
@endsection


@section('content')
    <div class="map-container">
        <div id="map"></div>
    </div>

    <style>
        .popup-container {
            font-family: 'Segoe UI', sans-serif;
            background-color: #FAF3E0;
            padding: 12px;
            border-radius: 10px;
            max-width: 260px;
            color: #3B2F2F;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .popup-container strong {
            color: #6B4C3B;
            font-size: 16px;
        }

        .popup-container em {
            color: #5E3D2B;
            font-style: italic;
            font-size: 14px;
        }

        .star-rating-input .star {
            font-size: 20px;
            color: #ccc;
            cursor: pointer;
        }

        .star-rating-input .star.selected {
            color: #F4A261;
        }

        .review-text-area {
            width: 100%;
            height: 60px;
            margin-top: 6px;
            border-radius: 6px;
            border: 1px solid #BFA980;
            padding: 5px;
            font-size: 0.9rem;
        }

        .kirim-review-btn {
            background-color: #A26769;
            color: white;
            border: none;
            padding: 8px;
            margin-top: 6px;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .kirim-review-btn:hover {
            background-color: #8C5B5C;
        }

        .button-group {
            display: flex;
            gap: 6px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .button-group button {
            flex: 1;
            padding: 6px;
            font-size: 12px;
            cursor: pointer;
            border-radius: 6px;
            border: none;
        }

        .website-btn {
            background-color: #6B4C3B;
            color: white;
        }

        .route-btn {
            background-color: #BFA980;
            color: white;
        }

        .btn-warning {
            background-color: #DAA06D;
            color: #fff;
        }

        .btn-danger {
            background-color: #B85C5C;
            color: #fff;
        }

        .review-section {
            background-color: #FFF8EF;
            padding: 10px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .leaflet-tooltip.custom-admin-tooltip {
            background-color: #FDF7F0;
            border: 1px solid #D9CBB6;
            color: #5E3D2B;
            font-family: 'Segoe UI', sans-serif;
            font-size: 12px;
            padding: 4px 10px;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Fredoka', sans-serif;
            background-color: #fff8ef;
        }


        #map {
            width: 100%;
            height: calc(100vh - 56px);
            z-index: 1;
        }

        .text-primary {
            color: #A26769 !important;
        }

        .map-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px 24px 40px;
            background-color: #fffaf5;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0dfd2;
            box-sizing: border-box;
            transition: all 0.3s ease-in-out;
        }


        #map {
            width: 100%;
            height: 80vh;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
    </style>


    <div id="map"></div>
@endsection
@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/@terraformer/wkt"></script>

    <script>
        // ======= Basemap Layer Definitions =======
        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        var positron = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '© CartoDB',
            subdomains: 'abcd',
            maxZoom: 19
        });

        var darkMatter = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '© CartoDB',
            subdomains: 'abcd',
            maxZoom: 19
        });

        var tonerLite = L.tileLayer('https://stamen-tiles.a.ssl.fastly.net/toner-lite/{z}/{x}/{y}.png', {
            attribution: '© Stamen',
            maxZoom: 20
        });

        var googleSat = L.tileLayer('http://mt1.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            attribution: '© Google',
            maxZoom: 20
        });

        // ======= Inisialisasi Peta =======
        var map = L.map('map', {
            center: [-7.802251680532236, 110.36506490961503],
            zoom: 15,
            layers: [positron] // default basemap
        });

        // ======= Basemap Dropdown Control =======
        var baseMaps = {
            "OpenStreetMap": osm,
            "CartoDB Positron (Abu-abu)": positron,
            "CartoDB Dark Matter": darkMatter,
            "Stamen Toner Lite": tonerLite,
            "Google Satellite": googleSat
        };

        L.control.layers(baseMaps, null, {
            collapsed: false,
            position: 'topright'
        }).addTo(map);

        // ======= Drawing Feature Group & Controls =======
        var drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        var drawControl = new L.Control.Draw({
            draw: {
                position: 'topleft',
                polyline: true,
                polygon: true,
                rectangle: true,
                circle: false,
                marker: true,
                circlemarker: false
            },
            edit: false
        });


        // LAYER HOTEL
        var hotelLayer = L.geoJSON(null, {
            onEachFeature: function(feature, layer) {
                const props = feature.properties;

                const name = props.name || "Nama Hotel Tidak Tersedia";
                const averageRating = props.average_rating || 0;
                const totalReviews = props.total_reviews || 0;
                const ratingDisplay = totalReviews > 0 ?
                    `⭐ ${averageRating} / 5 dari ${totalReviews} review` :
                    "Belum ada review";

                const alamat = props.Alamat || "-";
                const kontak = props.Kontak || "-";
                const website = props.website || "";
                const userReview = props.user_review || "Belum ada review";
                const userRating = props.user_rating || 0;
                const hotelId = props.id;

                const popupContent = `
<div class="popup-container">
    <strong>${name}</strong><br>
    <em>${ratingDisplay}</em><br>
    <p><strong>Alamat:</strong> ${alamat}</p>
    <p><strong>Kontak:</strong> ${kontak}</p>
    <p><strong>Review Anda:</strong>
        <span id="review-${hotelId}" data-rating="${userRating}">${userReview}</span>
    </p>

    <form class="review-upload-form" data-id="${hotelId}" enctype="multipart/form-data">
        <div class="review-section">
            <strong>Tambah Review & Foto:</strong><br>
            <div class="star-rating-input">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>
            <textarea class="review-text-area" name="review" placeholder="Tulis ulasan Anda..."></textarea>
            <input type="file" name="foto" accept="image/*" required><br>
            <button type="submit" class="kirim-review-btn">Kirim Review & Foto</button>
        </div>
    </form>

    <div class="button-group mt-2">
        ${website ? `<button class="website-btn" data-url="${website}">Website</button>` : ""}
        <button class="route-btn" data-lat="${feature.geometry.coordinates[1]}" data-lng="${feature.geometry.coordinates[0]}">Rute</button>
        <button class="btn btn-sm btn-warning" onclick="editReview(${hotelId})">Edit</button>
        <button class="btn btn-sm btn-danger" onclick="deleteReview(${hotelId})">Hapus</button>
    </div>
</div>
`;


                layer.bindPopup(popupContent);

                layer.on('popupopen', function() {
                    const stars = document.querySelectorAll('.star-rating-input .star');
                    let selectedRating = 0;

                    stars.forEach(star => {
                        star.classList.remove('selected');
                        star.addEventListener('click', function() {
                            selectedRating = parseInt(this.dataset.value);
                            stars.forEach((s, i) => {
                                s.classList.toggle('selected', i <
                                    selectedRating);
                            });
                        });
                    });

                    const form = document.querySelector('.review-upload-form');
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const hotelId = this.dataset.id;
                            const formData = new FormData(this);
                            formData.append('rating', selectedRating);

                            fetch(`/api/hotels/${hotelId}/review-foto`, {

                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').getAttribute(
                                            'content')
                                    },
                                    body: formData
                                })
                                .then(async res => {
                                    if (!res.ok) {
                                        const text = await res.text();
                                        console.error("Error Response:", text);
                                        alert(
                                            "Terjadi kesalahan saat mengirim review/foto."
                                        );
                                        return;
                                    }
                                    const data = await res.json();
                                    alert("Review dan foto berhasil dikirim!");
                                    map.closePopup();
                                    refreshHotelMarker(hotelId);
                                })
                                .catch(error => {
                                    console.error("Error:", error);
                                    alert("Terjadi kesalahan saat mengirim review/foto.");
                                });
                        });
                    }

                    // Website Button
                    const websiteBtn = document.querySelector('.website-btn');
                    if (websiteBtn) {
                        websiteBtn.addEventListener('click', function() {
                            const url = this.dataset.url;
                            if (url) window.open(url, '_blank');
                        });
                    }

                    // Route Button
                    const routeBtn = document.querySelector('.route-btn');
                    if (routeBtn) {
                        routeBtn.addEventListener('click', function() {
                            const lat = this.dataset.lat;
                            const lng = this.dataset.lng;
                            window.open(
                                `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`,
                                '_blank');
                        });
                    }
                });


                layer.bindTooltip(name, {
                    direction: "top",
                    offset: [0, -10],
                    permanent: false,
                    opacity: 0.9
                });
            },
            pointToLayer: function(feature, latlng) {
                return L.marker(latlng, {
                    icon: L.icon({
                        iconUrl: "{{ asset('build/assets/icon/marker_hotel.png') }}",
                        iconSize: [20, 22],
                        iconAnchor: [16, 32],
                        popupAnchor: [0, -32]
                    })
                });
            }
        });

        // Load Data Awal
        $.getJSON("/api/hotels", function(data) {
            hotelLayer.addData(data);
            map.addLayer(hotelLayer);
        });

        // Fungsi Refresh Marker
        function refreshHotelMarker(hotelId) {
            hotelLayer.eachLayer(function(layer) {
                if (layer.feature.properties.id == hotelId) {
                    const latlng = layer.getLatLng();
                    hotelLayer.clearLayers();
                    $.getJSON("/api/hotels", function(newData) {
                        hotelLayer.addData(newData);
                        hotelLayer.eachLayer(function(l) {
                            if (l.feature.properties.id == hotelId) {
                                l.openPopup();
                                map.setView(latlng, map.getZoom());
                            }
                        });
                    });
                }
            });
        }

        // Edit Review
        function editReview(hotelId) {
            const reviewSpan = document.getElementById(`review-${hotelId}`);
            if (!reviewSpan) return;

            const previousReview = reviewSpan.innerText || "";
            const textarea = document.querySelector('.review-text-area');
            if (textarea) {
                textarea.value = previousReview;
            }

            const previousRating = reviewSpan.dataset.rating ? parseInt(reviewSpan.dataset.rating) : 0;
            const stars = document.querySelectorAll('.star-rating-input .star');
            stars.forEach((star, index) => {
                star.classList.toggle('selected', index < previousRating);
            });
        }

        // Delete Review
        function deleteReview(hotelId) {
            if (confirm("Yakin ingin menghapus review Anda?")) {
                fetch(`/api/hotels/${hotelId}/review`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert("Review berhasil dihapus!");
                        refreshHotelMarker(hotelId);
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        alert("Gagal menghapus review.");
                    });
            }
        }

        // GeoJSON Batas Administrasi - Styled UI
        var batasAdminLayer = L.geoJSON(null, {
            style: function(feature) {
                return {
                    color: "#8D6A5D", // Earthy brown line
                    weight: 2,
                    opacity: 0.9,
                    fillColor: "#EBD9C6", // Soft beige fill
                    fillOpacity: 0.25 // Transparan agar tidak menutupi marker
                };
            },
            onEachFeature: function(feature, layer) {
                if (feature.properties && feature.properties.name) {
                    layer.bindTooltip(`<strong>${feature.properties.name}</strong>`, {
                        permanent: false,
                        direction: 'center',
                        opacity: 0.9,
                        className: 'custom-admin-tooltip'
                    });
                }
            }
        });

        // Load data Batas Kota
        $.getJSON("{{ asset('geojson/Batas_Kota.geojson') }}", function(data) {
            console.log("Data Batas Admin:", data);
            batasAdminLayer.addData(data);
            map.addLayer(batasAdminLayer);
        });

        document.querySelector('form[role="search"]').addEventListener('submit', function(e) {
            e.preventDefault(); // Stop default form submit
            const query = this.query.value;

            fetch(`/search?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    if (!data.features || data.features.length === 0) {
                        alert("Hotel tidak ditemukan.");
                        return;
                    }

                    // Hapus layer hotel sebelumnya
                    hotelLayer.clearLayers();

                    // Tambah data baru hasil pencarian
                    hotelLayer.addData(data);

                    // Zoom ke marker pertama hasil
                    const coords = data.features[0].geometry.coordinates;
                    const latlng = [coords[1], coords[0]];
                    map.setView(latlng, 18); // zoom level bisa disesuaikan
                })
                .catch(err => {
                    console.error(err);
                    alert("Terjadi kesalahan saat mencari hotel.");
                });
        });
    </script>
@endsection
