@extends('layouts.app')

@section('title', 'Scan QR Barang')

@section('content')

<div class="card shadow border-0">
    <div class="card-header bg-primary text-white">
        Scan QR Barang
    </div>

    <div class="card-body text-center">

        <div id="reader" style="width: 100%; max-width: 400px; margin: auto;"></div>

        <div class="alert alert-info mt-3">
            Arahkan kamera ke QR barang.
        </div>

    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    function onScanSuccess(decodedText) {
        window.location.href = decodedText;
    }

    const html5QrCode = new Html5QrcodeScanner(
        "reader",
        {
            fps: 10,
            qrbox: 250
        }
    );

    html5QrCode.render(onScanSuccess);
</script>

@endsection