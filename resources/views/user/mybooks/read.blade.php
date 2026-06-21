<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membaca: {{ $ebook->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #1a1a1a; }
        .no-select {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            user-select: none;
        }
        #pdf-container canvas {
            display: block;
            margin: 20px auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
            max-width: 100%;
        }
        .loader {
            border-top-color: #E2793D;
            animation: spinner 1.5s linear infinite;
        }
        @keyframes spinner { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        @media print { body { display: none; } }
        
        .zoom-controls {
            position: fixed;
            bottom: 30px;
            right: 30px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            z-index: 100;
        }
    </style>
</head>
<body class="flex flex-col h-screen no-select">

    <nav class="fixed top-0 left-0 right-0 bg-black/90 text-white p-4 flex justify-between items-center z-50">
        <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 hover:text-orange-400 transition">
            <i class="fas fa-arrow-left"></i>
            <span class="hidden md:inline text-sm">Kembali</span>
        </a>
        <h1 class="text-sm md:text-lg font-bold truncate px-4">{{ $ebook->title }}</h1>
        <div class="flex items-center gap-4">
            <span id="zoom-percent" class="text-xs md:text-sm bg-white/20 px-3 py-1 rounded-full">100%</span>
        </div>
    </nav>

    <main class="flex-grow overflow-y-auto mt-16 p-2 md:p-8">
        <div id="loading-overlay" class="fixed inset-0 z-40 flex flex-col items-center justify-center bg-gray-900 text-white">
            <div class="loader w-12 h-12 border-4 border-gray-600 rounded-full mb-4"></div>
            <p id="load-status">Mengunduh Dokumen...</p>
        </div>

        <div id="pdf-container" class="flex flex-col items-center"></div>
    </main>

    <div class="zoom-controls">
        <button onclick="changeZoom(0.2)" class="bg-orange-600 hover:bg-orange-700 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center transition">
            <i class="fas fa-plus"></i>
        </button>
        <button onclick="changeZoom(-0.2)" class="bg-orange-600 hover:bg-orange-700 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center transition">
            <i class="fas fa-minus"></i>
        </button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>

    <script>
        const pdfUrl = "{{ asset($ebook->file) }}";
        const pdfjsLib = window['pdfjs-dist/build/pdf'];
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

        let pdfDoc = null;
        let currentScale = window.innerWidth < 768 ? 0.9 : (window.innerWidth < 1024 ? 1.2 : 1.5);
        let isRendering = false;
        const container = document.getElementById('pdf-container');

        // Hanya render ulang halaman yang ada di viewport (lazy render)
        async function renderPage(pageNum) {
            const page = await pdfDoc.getPage(pageNum);
            const viewport = page.getViewport({ scale: currentScale });
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            canvas.dataset.page = pageNum;
            await page.render({ canvasContext: context, viewport: viewport }).promise;
            return canvas;
        }

        async function renderPages() {
            if (isRendering) return;
            isRendering = true;
            container.innerHTML = '<div class="text-white text-center py-4">Memuat halaman...</div>';
            const fragment = document.createDocumentFragment();
            for (let i = 1; i <= pdfDoc.numPages; i++) {
                const canvas = await renderPage(i);
                fragment.appendChild(canvas);
            }
            container.innerHTML = '';
            container.appendChild(fragment);
            document.getElementById('zoom-percent').innerText = Math.round((currentScale / 1.5) * 100) + '%';
            isRendering = false;
        }

        async function changeZoom(delta) {
            if (isRendering) return;
            const newScale = currentScale + delta;
            if (newScale >= 0.4 && newScale <= 3.0) {
                currentScale = newScale;
                await renderPages();
            }
        }

        async function initReader() {
            try {
                const loadingTask = pdfjsLib.getDocument(pdfUrl);
                pdfDoc = await loadingTask.promise;
                document.getElementById('loading-overlay').classList.add('hidden');
                await renderPages();
            } catch (error) {
                document.getElementById('load-status').innerText = 'Gagal memuat dokumen. Pastikan file tersedia.';
            }
        }

        document.addEventListener('DOMContentLoaded', initReader);
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('keydown', e => {
            if (e.ctrlKey && (e.key === 'p' || e.key === 's' || e.key === 'u' || (e.shiftKey && e.key === 'I')) || e.key === 'F12') {
                e.preventDefault();
            }
        });

        // Pinch-to-zoom untuk mobile
        let initialDistance = null;
        let initialScale = null;
        document.addEventListener('touchstart', function(e) {
            if (e.touches.length === 2) {
                initialDistance = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
                initialScale = currentScale;
            }
        }, { passive: true });
        document.addEventListener('touchend', function(e) {
            initialDistance = null;
            initialScale = null;
        }, { passive: true });
        document.addEventListener('touchmove', function(e) {
            if (e.touches.length === 2 && initialDistance) {
                const dist = Math.hypot(
                    e.touches[0].clientX - e.touches[1].clientX,
                    e.touches[0].clientY - e.touches[1].clientY
                );
                const ratio = dist / initialDistance;
                const newScale = Math.min(3.0, Math.max(0.4, initialScale * ratio));
                currentScale = Math.round(newScale * 10) / 10;
            }
        }, { passive: true });
    </script>
</body>
</html>