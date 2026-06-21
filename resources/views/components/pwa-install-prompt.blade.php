<!-- PWA Install Prompt Modal -->
<div id="pwaInstallModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2);">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 20px 20px 0 0;">
                <div class="d-flex align-items-center" style="width: 100%;">
                    <i class="fas fa-mobile-alt" style="font-size: 28px; color: white; margin-right: 15px;"></i>
                    <h5 class="modal-title" style="color: white; margin: 0; font-weight: 700;">Akses Lebih Cepat</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px; text-align: center;">
                <div style="margin-bottom: 20px;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="80" height="80" style="margin-bottom: 15px;">
                        <circle cx="50" cy="50" r="45" fill="#f0f0f0"/>
                        <rect x="30" y="20" width="40" height="55" rx="5" fill="#667eea" stroke="#5568d3" stroke-width="2"/>
                        <rect x="35" y="25" width="30" height="35" fill="white"/>
                        <circle cx="50" cy="68" r="3" fill="#667eea"/>
                    </svg>
                </div>
                
                <h4 style="font-weight: 700; margin-bottom: 10px; color: #333;">Instal Aplikasi Baleide</h4>
                <p style="color: #666; margin-bottom: 20px; line-height: 1.6;">
                    Dapatkan akses lebih cepat ke Baleide langsung dari layar utama perangkat kamu. Tidak perlu buka browser setiap kali!
                </p>
                
                <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; margin-bottom: 20px; text-align: left;">
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px; font-size: 18px;"></i>
                        <span style="color: #333;">Akses instant tanpa perlu download</span>
                    </div>
                    <div style="display: flex; align-items: center; margin-bottom: 10px;">
                        <i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px; font-size: 18px;"></i>
                        <span style="color: #333;">Bekerja offline untuk beberapa fitur</span>
                    </div>
                    <div style="display: flex; align-items: center;">
                        <i class="fas fa-check-circle" style="color: #10b981; margin-right: 10px; font-size: 18px;"></i>
                        <span style="color: #333;">Ukuran kecil, hemat storage</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid #e0e0e0; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; padding: 10px 25px;">
                    Nanti Dulu
                </button>
                <button type="button" id="pwaInstallBtn" class="btn" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 10px; padding: 10px 25px; font-weight: 600;">
                    <i class="fas fa-download"></i> Instal Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let deferredPrompt = null;
const pwaInstallModal = new bootstrap.Modal(document.getElementById('pwaInstallModal'), { backdrop: 'static', keyboard: false });
const pwaInstallBtn = document.getElementById('pwaInstallBtn');

// Listen untuk beforeinstallprompt event
window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent the mini-infobar from appearing
    e.preventDefault();
    // Stash the event for later use
    deferredPrompt = e;
    
    // Check apakah user sudah pernah skip install prompt (localStorage)
    const hasSkipped = localStorage.getItem('pwaInstallSkipped');
    const skipTime = localStorage.getItem('pwaInstallSkipTime');
    const now = Date.now();
    
    // Show modal jika belum skip atau sudah 7 hari lewat
    if (!hasSkipped || (skipTime && now - parseInt(skipTime) > 7 * 24 * 60 * 60 * 1000)) {
        // Delay 2 detik untuk UX yang lebih baik
        setTimeout(() => {
            pwaInstallModal.show();
        }, 2000);
    }
});

// Handle install button click
pwaInstallBtn.addEventListener('click', async () => {
    if (deferredPrompt) {
        // Show the install prompt
        deferredPrompt.prompt();
        
        // Wait for user to respond to the prompt
        const { outcome } = await deferredPrompt.userChoice;
        
        if (outcome === 'accepted') {
            console.log('User accepted the install prompt');
            localStorage.removeItem('pwaInstallSkipped');
            localStorage.removeItem('pwaInstallSkipTime');
        } else {
            console.log('User dismissed the install prompt');
        }
        
        // Clear the deferred prompt after use
        deferredPrompt = null;
        pwaInstallModal.hide();
    }
});

// Handle "Nanti Dulu" button (dismiss modal)
document.querySelector('[data-bs-dismiss="modal"]').addEventListener('click', () => {
    // Set flag untuk tidak show modal lagi dalam 7 hari
    localStorage.setItem('pwaInstallSkipped', 'true');
    localStorage.setItem('pwaInstallSkipTime', Date.now().toString());
});

// Show install success message
window.addEventListener('appinstalled', () => {
    console.log('Baleide app installed successfully!');
    pwaInstallModal.hide();
});
</script>

<style>
/* Improve modal appearance */
#pwaInstallModal .modal-content {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#pwaInstallBtn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    transition: all 0.2s;
}
</style>
