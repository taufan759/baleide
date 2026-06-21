@extends('master')

@section('title', 'Asisten AI - Rekomendasi Buku')

@push('styles')
<style>
    .chat-container {
        max-width: 1000px;
        margin: 0 auto;
        height: calc(100vh - 200px);
        display: flex;
        flex-direction: column;
    }
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .message {
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        animation: fadeIn 0.3s;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .message.user {
        justify-content: flex-end;
    }
    .message.ai {
        justify-content: flex-start;
    }
    .message-bubble {
        max-width: 70%;
        padding: 12px 18px;
        border-radius: 18px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .message.user .message-bubble {
        background: #6366f1;
        color: white;
        border-bottom-right-radius: 4px;
    }
    .message.ai .message-bubble {
        background: white;
        color: #333;
        border-bottom-left-radius: 4px;
    }
    .message-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin: 0 10px;
        flex-shrink: 0;
    }
    .message.user .message-avatar {
        background: #6366f1;
        color: white;
        order: 2;
    }
    .message.ai .message-avatar {
        background: #10b981;
        color: white;
    }
    .book-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 10px;
        margin-top: 10px;
        display: flex;
        gap: 10px;
        background: #f9fafb;
        transition: all 0.2s;
    }
    .book-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .book-card img {
        width: 60px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
    }
    .book-info {
        flex: 1;
    }
    .book-info h6 {
        margin: 0 0 5px 0;
        font-size: 14px;
        font-weight: 600;
    }
    .book-info p {
        margin: 0;
        font-size: 12px;
        color: #666;
    }
    .book-price {
        color: #10b981;
        font-weight: 600;
        font-size: 13px;
    }
    .chat-input-wrapper {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .chat-input {
        flex: 1;
        border: 2px solid #e0e0e0;
        border-radius: 25px;
        padding: 12px 20px;
        font-size: 14px;
        transition: border 0.2s;
    }
    .chat-input:focus {
        border-color: #6366f1;
        outline: none;
    }
    .btn-send {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #6366f1;
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-send:hover:not(:disabled) {
        background: #4f46e5;
        transform: scale(1.05);
    }
    .btn-send:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }
    .typing-indicator {
        display: none;
        padding: 10px 15px;
    }
    .typing-indicator.active {
        display: block;
    }
    .typing-indicator span {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #9ca3af;
        margin: 0 2px;
        animation: typing 1.4s infinite;
    }
    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-10px); }
    }
    .quick-prompts {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
    }
    .quick-prompt-btn {
        padding: 8px 16px;
        border: 1px solid #6366f1;
        background: white;
        color: #6366f1;
        border-radius: 20px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .quick-prompt-btn:hover {
        background: #6366f1;
        color: white;
    }
    @media (max-width: 768px) {
        .message-bubble { max-width: 85%; }
        .book-card { flex-direction: column; }
        .book-card img { width: 100%; height: 150px; }
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><i class="fas fa-robot"></i> Asisten AI - Rekomendasi E-Book</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></div>
                <div class="breadcrumb-item active">Chatbot</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-magic"></i> Temukan Buku Sesuai Mood Kamu</h4>
                    <div class="card-header-action">
                        <button class="btn btn-light btn-sm" onclick="clearChat()">
                            <i class="fas fa-trash"></i> Hapus Chat
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="chat-container">
                        <div class="chat-messages" id="chatMessages">
                            <div class="message ai">
                                <div class="message-avatar">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <div class="message-bubble">
                                    <p class="mb-0">👋 Hai! Saya <strong>Baleide Assistant</strong>, asisten AI yang siap membantu kamu menemukan e-book yang tepat!</p>
                                    <p class="mb-0 mt-2">Ceritakan mood atau kebutuhan baca kamu hari ini. Misalnya:</p>
                                    <ul class="mb-0 mt-2">
                                        <li>"Aku lagi butuh buku santai buat weekend"</li>
                                        <li>"Pengen belajar tentang teknologi"</li>
                                        <li>"Lagi mood baca novel romantis"</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="px-3">
                            <div class="quick-prompts">
                                <button class="quick-prompt-btn" onclick="sendQuickPrompt('Rekomendasikan buku santai untuk weekend')">
                                    📚 Buku Santai
                                </button>
                                <button class="quick-prompt-btn" onclick="sendQuickPrompt('Buku teknologi atau programming')">
                                    💻 Teknologi
                                </button>
                                <button class="quick-prompt-btn" onclick="sendQuickPrompt('Novel romantis yang seru')">
                                    ❤️ Romantis
                                </button>
                                <button class="quick-prompt-btn" onclick="sendQuickPrompt('Buku motivasi dan pengembangan diri')">
                                    ⭐ Motivasi
                                </button>
                                <button class="quick-prompt-btn" onclick="sendQuickPrompt('Buku bisnis atau keuangan')">
                                    💰 Bisnis
                                </button>
                            </div>

                            <div class="chat-input-wrapper">
                                <input 
                                    type="text" 
                                    class="chat-input" 
                                    id="chatInput" 
                                    placeholder="Ketik mood atau kebutuhan baca kamu..."
                                    maxlength="500"
                                    onkeypress="if(event.key==='Enter') sendMessage()"
                                >
                                <button class="btn-send" id="sendBtn" onclick="sendMessage()">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    const chatMessages = document.getElementById('chatMessages');
    const chatInput = document.getElementById('chatInput');
    const sendBtn = document.getElementById('sendBtn');

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addMessage(content, type = 'ai', books = []) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}`;
        
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = type === 'user' ? '<i class="fas fa-user"></i>' : '<i class="fas fa-robot"></i>';
        
        const bubble = document.createElement('div');
        bubble.className = 'message-bubble';
        
        // Format content dengan line breaks
        const formattedContent = content.replace(/\n/g, '<br>');
        bubble.innerHTML = `<p class="mb-0">${formattedContent}</p>`;
        
        // Tambahkan kartu buku jika ada rekomendasi
        if (books && books.length > 0) {
            books.forEach(book => {
                const bookCard = `
                    <div class="book-card">
                        <img src="${book.cover}" alt="${book.title}">
                        <div class="book-info">
                            <h6>${book.title}</h6>
                            <p>${book.author} • ${book.category}</p>
                            <p class="book-price">${book.price_formatted}</p>
                            <a href="${book.url}" class="btn btn-sm btn-primary mt-2" target="_blank">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                `;
                bubble.innerHTML += bookCard;
            });
        }
        
        messageDiv.appendChild(avatar);
        messageDiv.appendChild(bubble);
        chatMessages.appendChild(messageDiv);
        scrollToBottom();
    }

    function showTyping() {
        const typingDiv = document.createElement('div');
        typingDiv.className = 'message ai typing-indicator active';
        typingDiv.id = 'typingIndicator';
        typingDiv.innerHTML = `
            <div class="message-avatar"><i class="fas fa-robot"></i></div>
            <div class="message-bubble">
                <span></span><span></span><span></span>
            </div>
        `;
        chatMessages.appendChild(typingDiv);
        scrollToBottom();
    }

    function hideTyping() {
        const typing = document.getElementById('typingIndicator');
        if (typing) typing.remove();
    }

    async function sendMessage() {
        const message = chatInput.value.trim();
        if (!message) return;

        // Tampilkan pesan user
        addMessage(message, 'user');
        chatInput.value = '';
        sendBtn.disabled = true;
        chatInput.disabled = true;

        // Tampilkan typing indicator
        showTyping();

        try {
            const response = await fetch("{{ route('chatbot.chat') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();
            hideTyping();

            if (data.success) {
                addMessage(data.message, 'ai', data.recommended_books);
            } else {
                addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', 'ai');
            }
        } catch (error) {
            hideTyping();
            addMessage('Maaf, koneksi bermasalah. Silakan coba lagi.', 'ai');
            console.error('Error:', error);
        }

        sendBtn.disabled = false;
        chatInput.disabled = false;
        chatInput.focus();
    }

    function sendQuickPrompt(prompt) {
        chatInput.value = prompt;
        sendMessage();
    }

    function clearChat() {
        if (confirm('Hapus semua riwayat chat?')) {
            chatMessages.innerHTML = `
                <div class="message ai">
                    <div class="message-avatar"><i class="fas fa-robot"></i></div>
                    <div class="message-bubble">
                        <p class="mb-0">Chat telah dihapus. Mulai percakapan baru!</p>
                    </div>
                </div>
            `;
        }
    }

    // Auto focus input saat load
    chatInput.focus();
</script>
@endpush
