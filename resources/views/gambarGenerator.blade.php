<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Partner KV Generator - Helmi Sugara Promotions</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen p-4 sm:p-6 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <header class="mb-6 text-center">
            <h1 class="text-2xl sm:text-3xl font-bold text-amber-400">Media Partner KV Generator</h1>
            <p class="text-slate-400 text-sm mt-1">Otomatisasi penggabungan materi promotor dan logo media partner dengan rapi.</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Panel Kontrol (Kolom Kiri) -->
            <div class="lg:col-span-5 bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-xl space-y-4">
                <h2 class="text-lg font-semibold text-slate-200 border-b border-slate-700 pb-2">1. Unggah Gambar & Logo</h2>
                
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Materi Utama / KV Promotor</label>
                    <input type="file" id="bgInput" accept="image/*" class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400 cursor-pointer">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-1">Logo Media Partner (PNG Transparan)</label>
                    <input type="file" id="logoInput" accept="image/*" class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-500 cursor-pointer">
                </div>

                <div class="pt-2 border-t border-slate-700 space-y-3">
                    <h2 class="text-sm font-semibold text-slate-300">2. Pengaturan Teks & Posisi</h2>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Label Teks Pengantar</label>
                        <input type="text" id="labelText" value="MEDIA PARTNER :" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-sm text-slate-200 focus:outline-none focus:border-amber-400">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Ukuran Logo (% dari lebar gambar)</label>
                        <input type="range" id="logoSize" min="10" max="60" value="22" class="w-full accent-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Efek Khusus Logo Gelap di Background Hitam</label>
                        <select id="logoEffect" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-sm text-slate-200 focus:outline-none focus:border-amber-400">
                            <option value="normal">Normal (Asli)</option>
                            <option value="glow" selected>Glow / Bayangan Putih (Rekomendasi)</option>
                            <option value="white">Ubah Logo Jadi Putih Polos</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Geser Posisi Vertikal (Sesuaikan ke Bawah/Atas)</label>
                        <input type="range" id="posYSlider" min="-50" max="50" step="1" value="15" class="w-full accent-amber-500">
                    </div>
                </div>

                <button id="downloadBtn" disabled class="w-full mt-4 py-3 px-4 bg-emerald-600 hover:bg-emerald-500 disabled:bg-slate-700 disabled:text-slate-500 text-white font-semibold rounded-xl shadow transition duration-200 cursor-pointer disabled:cursor-not-allowed">
                    Download Hasil Poster (HD)
                </button>
            </div>

            <!-- Panel Preview (Kolom Kanan) -->
            <div class="lg:col-span-7 bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-xl flex flex-col items-center justify-center">
                <h2 class="text-lg font-semibold text-slate-200 border-b border-slate-700 pb-2 w-full mb-4">Live Preview</h2>
                <!-- Container dengan background kontras untuk melihat batas bawah gambar utama -->
                <div id="previewContainer" class="relative w-full h-[650px] flex items-center justify-center bg-zinc-950 rounded-lg overflow-hidden border-2 border-dashed border-slate-600 p-2 shadow-inner">
                    <p id="placeholderText" class="text-slate-400 text-sm text-center p-8">Silakan unggah KV Promotor dan Logo Media Partner terlebih dahulu.</p>
                    <canvas id="canvas" class="max-w-full max-h-full object-contain hidden shadow-2xl ring-1 ring-slate-700"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script>
        const bgInput = document.getElementById('bgInput');
        const logoInput = document.getElementById('logoInput');
        const labelText = document.getElementById('labelText');
        const logoSizeSlider = document.getElementById('logoSize');
        const logoEffectSelect = document.getElementById('logoEffect');
        const posYSlider = document.getElementById('posYSlider');
        const downloadBtn = document.getElementById('downloadBtn');
        const canvas = document.getElementById('canvas');
        const placeholderText = document.getElementById('placeholderText');
        const ctx = canvas.getContext('2d');

        let bgImage = null;
        let logoImage = null;

        function loadImages() {
            if (bgInput.files && bgInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        bgImage = img;
                        checkReady();
                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(bgInput.files[0]);
            }

            if (logoInput.files && logoInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        logoImage = img;
                        checkReady();
                    }
                    img.src = e.target.result;
                }
                reader.readAsDataURL(logoInput.files[0]);
            }
        }

        function checkReady() {
            if (bgImage) {
                placeholderText.classList.add('hidden');
                canvas.classList.remove('hidden');
                drawCanvas();
                downloadBtn.disabled = false;
            }
        }

        function drawCanvas() {
            if (!bgImage) return;

            canvas.width = bgImage.naturalWidth;
            canvas.height = bgImage.naturalHeight;

            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(bgImage, 0, 0);

            if (logoImage) {
                // Formula posisi bawah berbasis proporsi tinggi gambar asli yang akurat & rapi
                const baseDistanceFromBottom = canvas.height * 0.022; // ~2.2% dari tepi bawah
                const userOffset = parseInt(posYSlider.value); // Nilai slider penyesuaian

                const fontSize = Math.max(12, canvas.width * 0.016);
                ctx.font = `bold ${fontSize}px sans-serif`;
                ctx.fillStyle = '#FFFFFF';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                const text = labelText.value.trim();
                
                const maxLogoWidth = canvas.width * (logoSizeSlider.value / 100);
                const scale = maxLogoWidth / logoImage.naturalWidth;
                const logoWidth = logoImage.naturalWidth * scale;
                const logoHeight = logoImage.naturalHeight * scale;

                const spacing = 15; 
                const textWidth = text ? ctx.measureText(text).width + spacing : 0;
                const totalWidth = textWidth + logoWidth;

                const startX = (canvas.width - totalWidth) / 2;
                
                // Menghitung posisi vertikal persis di area bawah
                const maxItemHeight = Math.max(logoHeight, fontSize);
                const centerY = canvas.height - baseDistanceFromBottom - (maxItemHeight / 2) - userOffset;

                // Render Teks
                if (text) {
                    ctx.fillText(text, startX + (textWidth / 2), centerY);
                }

                // Render Logo dengan Efek Visibilitas (Glow / Putih Polos / Normal)
                const effect = logoEffectSelect.value;
                const renderX = startX + textWidth;
                const renderY = centerY - (logoHeight / 2);

                ctx.save();
                if (effect === 'glow') {
                    ctx.shadowColor = 'rgba(255, 255, 255, 0.9)';
                    ctx.shadowBlur = 12;
                    ctx.drawImage(logoImage, renderX, renderY, logoWidth, logoHeight);
                } else if (effect === 'white') {
                    ctx.drawImage(logoImage, renderX, renderY, logoWidth, logoHeight);
                    ctx.globalCompositeOperation = 'source-in';
                    ctx.fillStyle = '#FFFFFF';
                    ctx.fillRect(renderX - 5, renderY - 5, logoWidth + 10, logoHeight + 10);
                } else {
                    ctx.drawImage(logoImage, renderX, renderY, logoWidth, logoHeight);
                }
                ctx.restore();
            }
        }

        bgInput.addEventListener('change', loadImages);
        logoInput.addEventListener('change', loadImages);
        labelText.addEventListener('input', drawCanvas);
        logoSizeSlider.addEventListener('input', drawCanvas);
        logoEffectSelect.addEventListener('change', drawCanvas);
        posYSlider.addEventListener('input', drawCanvas);

        downloadBtn.addEventListener('click', function() {
            if (!bgImage) return;
            drawCanvas();
            const link = document.createElement('a');
            link.download = `KV-MediaPartner-${Date.now()}.png`;
            link.href = canvas.toDataURL('image/png', 1.0);
            link.click();
        });
    </script>
</body>
</html>