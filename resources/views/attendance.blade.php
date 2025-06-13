<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Absensi | Swarfa Farma</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen text-gray-800">
    <div class="bg-white shadow-lg rounded-xl w-full max-w-xl p-8 text-center">
        <h1 class="text-4xl font-bold text-slate-700 mb-2">Sistem Absensi</h1>
        <div class="text-blue-500 mb-6">
            Selamat datang, <span id="employee-name">{{ Auth::user()->name }}</span>!
        </div>

        <!-- Status Lokasi -->
        <div id="location-status" class="text-gray-600 font-medium mb-4">
            Mengecek lokasi...
        </div>

        <!-- Waktu -->
        <div id="current-time" class="text-3xl font-semibold text-gray-800 my-4">--:--:--</div>

        <!-- Info Absensi -->
        <div class="bg-gray-50 rounded-lg p-4 mb-4 text-left space-y-3">
            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Hari/Tanggal:</span>
                <span id="current-date" class="text-gray-800">-</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Jam Masuk:</span>
                <span id="check-in-time" class="text-gray-800">-</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Jam Keluar:</span>
                <span id="check-out-time" class="text-gray-800">-</span>
            </div>
            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Status:</span>
                <span id="attendance-status" class="font-semibold">-</span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Keterlambatan:</span>
                <span id="late-info" class="font-semibold">-</span>
            </div>
        </div>

        <!-- Lokasi -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-left space-y-3">
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-600 mb-1">Lokasi Masuk:</label>
                <select id="check-in-location" name="checkInLocation_id" class="border rounded px-3 py-2">
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-600 mb-1">Lokasi Keluar:</label>
                <select id="check-out-location" name="checkOutLocation_id" class="border rounded px-3 py-2">
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Tombol -->
        <div class="flex gap-4">
            <form id="check-in-form" class="w-full" action="{{ route('checkin') }}" method="POST">
                @csrf
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lng" id="lng">
                <button id="check-in-btn"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded" disabled>
                    Absen Masuk
                </button>
            </form>
            <form id="check-out-form" class="w-full" action="{{ route('checkout') }}" method="POST">
                @csrf
                <input type="hidden" name="lat" id="lat2">
                <input type="hidden" name="lng" id="lng2">
                <button id="check-out-btn"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 rounded" disabled>
                    Absen Keluar
                </button>
            </form>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button type="submit"
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded w-full">
                Logout
            </button>
        </form>
    </div>

    <!-- JavaScript -->
    <script>
        const validLocations = {!! json_encode(
            $locations->map(function ($location) {
                    return [
                        'id' => $location->id,
                        'name' => $location->name,
                        'lat' => $location->latitude,
                        'lng' => $location->longitude,
                        'radius' => $location->radius_km ?? 0.1,
                    ];
                })->values()->all(),
        ) !!};

        function haversine(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) ** 2 +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) ** 2;
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function validateUserLocation() {
            const statusText = document.getElementById('location-status');
            navigator.geolocation.getCurrentPosition(function(pos) {
                const userLat = pos.coords.latitude;
                const userLng = pos.coords.longitude;

                document.getElementById('lat').value = userLat;
                document.getElementById('lng').value = userLng;
                document.getElementById('lat2').value = userLat;
                document.getElementById('lng2').value = userLng;

                let found = false;
                for (const loc of validLocations) {
                    const dist = haversine(userLat, userLng, loc.lat, loc.lng);
                    if (dist <= loc.radius) {
                        found = true;
                        break;
                    }
                }

                if (found) {
                    statusText.textContent = "✅ Anda berada di lokasi absensi.";
                    statusText.className = "text-green-600 font-semibold mb-2";
                    document.getElementById('check-in-btn').disabled = false;
                    document.getElementById('check-out-btn').disabled = false;
                } else {
                    statusText.textContent = "❌ Anda berada di luar lokasi absensi.";
                    statusText.className = "text-red-600 font-semibold mb-2";
                    document.getElementById('check-in-btn').disabled = true;
                    document.getElementById('check-out-btn').disabled = true;
                }
            }, function(error) {
                statusText.textContent = "Gagal mendapatkan lokasi: " + error.message;
                statusText.className = "text-red-600 font-semibold mb-2";
            });
        }

        function updateClock() {
            const now = new Date();
            document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID');
            document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            setTimeout(updateClock, 1000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            updateClock();
            validateUserLocation();
            setInterval(validateUserLocation, 15000); // update lokasi tiap 15 detik
        });

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius bumi dalam km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function checkLocationStatus(userLat, userLng) {
            let foundMatch = false;

            validLocations.forEach((loc) => {
                const distance = calculateDistance(userLat, userLng, loc.lat, loc.lng);
                const inRange = distance <= loc.radius;

                if (inRange && !foundMatch) {
                    foundMatch = true;

                    // Otomatis pilih lokasi masuk/keluar jika masih kosong
                    const checkInSelect = document.getElementById('check-in-location');
                    const checkOutSelect = document.getElementById('check-out-location');

                    if (!checkInSelect.value) checkInSelect.value = loc.id;
                    if (!checkOutSelect.value) checkOutSelect.value = loc.id;

                    showStatus(`Berada di dalam lokasi: ${loc.name}`, true);
                }
            });

            if (!foundMatch) {
                showStatus("Anda berada di luar lokasi yang diizinkan.", false);
            }
        }

        function showStatus(message, inside) {
            let statusEl = document.getElementById('location-status');
            if (!statusEl) {
                statusEl = document.createElement('div');
                statusEl.id = 'location-status';
                statusEl.className = 'text-sm mt-2 font-medium';
                document.querySelector('#check-in-location').parentElement.appendChild(statusEl);
            }
            statusEl.textContent = message;
            statusEl.className = 'text-sm mt-2 font-medium ' + (inside ? 'text-green-600' : 'text-red-600');
        }

        function detectLocationAndUpdate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        checkLocationStatus(lat, lng);
                    },
                    (err) => {
                        showStatus("Gagal mendapatkan lokasi. Izinkan akses lokasi di browser.", false);
                    }
                );
            } else {
                showStatus("Browser tidak mendukung Geolocation.", false);
            }
        }

        // Jalankan saat halaman siap
        window.addEventListener('DOMContentLoaded', () => {
            updateClock();
            detectLocationAndUpdate();
        });
    </script>
</body>

</html>
