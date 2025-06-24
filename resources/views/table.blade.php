@extends('layouts.template')

@section('content')
    <div class="container mt-4 mb-5">
        <div class="card shadow-sm border-0" style="background-color: #FAF3E0; color: #3B2F2F;">
            <div class="card-header" style="background-color: #A26769; color: white; border-bottom: 2px solid #BFA980;">
                <h4 class="mb-0">Review Hotel</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle" id="hoteltable"
                    style="background-color: #FFF8EF;">
                    <thead style="background-color: #FDF7F0; color: #5E3D2B;">
                        <tr>
                            <th>No</th>
                            <th>Nama Hotel</th>
                            <th>Rating</th>
                            <th>Review</th>
                            <th>Foto</th>
                            <th>Waktu Submit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hotels as $index => $h)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong style="color: #6B4C3B">{{ $h->name }}</strong></td>
                                <td>
                                    <span class="badge" style="background-color: #F4A261; color: white;">
                                        {{ $h->rating ?? '-' }} / 5
                                    </span>
                                </td>
                                <td><em style="color: #5E3D2B">{{ $h->review ?? '-' }}</em></td>
                                <td>
                                    @if ($h->foto)
                                        <img src="{{ asset($h->foto) }}" alt="Foto Hotel" width="80"
                                            class="rounded shadow-sm border" style="border-color: #BFA980;">
                                    @else
                                        <span class="text-muted"><em>Tidak ada foto</em></span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($h->created_at)->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        table img {
            object-fit: cover;
            max-height: 60px;
        }

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            table img {
                max-width: 100%;
                height: auto;
            }
        }

        /* Gaya untuk search box & pagination */
        .dataTables_wrapper .dataTables_filter input {
            background-color: #FFF8EF;
            border: 1px solid #BFA980;
            border-radius: 6px;
            padding: 4px 8px;
            color: #3B2F2F;
        }

        .dataTables_wrapper .dataTables_length select {
            background-color: #FFF8EF;
            border: 1px solid #BFA980;
            border-radius: 6px;
            color: #3B2F2F;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #BFA980 !important;
            color: white !important;
            border-radius: 4px;
            padding: 3px 6px;
            margin: 0 2px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #A26769 !important;
        }

        /* Navbar Styling */
        .custom-navbar {
            background-color: #f4dacb;
            /* Lebih gelap dikit dari #fcebd4 */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            font-family: 'Fredoka', sans-serif;
        }

        /* Brand */
        .custom-navbar .navbar-brand {
            font-size: 1.3rem;
            color: #5E3D2B;
            font-weight: 600;
        }

        /* Link Style */
        .custom-navbar .nav-link {
            color: #5E3D2B;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .custom-navbar .nav-link:hover,
        .custom-navbar .nav-link.active {
            color: #A26769;
        }

        /* Search Input */
        .custom-navbar .form-control {
            border-radius: 30px 0 0 30px;
            border: 1px solid #d3b4a3;
        }

        /* Search Button */
        .custom-navbar .btn-outline-success {
            background-color: #A26769;
            color: #fff;
            border-radius: 0 30px 30px 0;
            border: none;
            transition: background-color 0.3s ease;
        }

        .custom-navbar .btn-outline-success:hover {
            background-color: #8C5B5C;
            color: #fff;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#hoteltable').DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "›",
                        previous: "‹"
                    },
                    zeroRecords: "Tidak ditemukan review",
                }
            });
        });
    </script>
@endsection
