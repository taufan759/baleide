{{-- Floating Chatbot Widget --}}
<style>
    .chatbot-widget {
        position: fixed;
        bottom: 20px;
        left: 20px;
        z-index: 9998;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .chatbot-toggle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: all 0.3s;
        animation: pulse 2s infinite;
        position: relative;
    }
    
    .chatbot-toggle:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
    }
    
    @keyframes pulse {
        0%, 100% { box-shadow: 0 4px 15px rgba(0,0,0,0.3); }
        50% { box-shadow: 0 4px 15px rgba(102, 126, 234, 0.6), 0 0 20px rgba(102, 126, 234, 0.4); }
    }
    
    .chatbot-window {
        position: fixed;
        bottom: 90px;
        left: 20px;
        width: 400px;
        max-width: calc(100vw - 40px);
        height: 600px;
        max-height: calc(100vh - 140px);
        background: white;
        border-radius: 18px;
        box-shadow: 0 15px 45px rgba(0,0,0,0.25);
        display: none;
        flex-direction: column;
        overflow: hidden;
        animation: slideUp 0.3s ease-out;
    }
    
    .chatbot-window.active {
        display: flex;
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .chatbot-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 3px solid rgba(255,255,255,0.1);
    }
    
    .chatbot-header-info {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
    }
    
    .chatbot-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }
    
    .chatbot-title {
        flex: 1;
    }
    
    .chatbot-title h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
    }
    
    .chatbot-title p {
        margin: 2px 0 0 0;
        font-size: 12px;
        opacity: 0.95;
    }
    
    .chatbot-close {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
        flex-shrink: 0;
    }
    
    .chatbot-close:hover {
        background: rgba(255,255,255,0.35);
    }
    
    .chatbot-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f8f9fa;
    }
    
    .chatbot-message {
        margin-bottom: 15px;
        display: flex;
        align-items: flex-start;
        animation: fadeIn 0.3s;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .chatbot-message.user {
        justify-content: flex-end;
    }
    
    .chatbot-message-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    
    .chatbot-message.bot .chatbot-message-avatar {
        background: #f0f0f0;
        color: #667eea;
        margin-right: 10px;
    }
    
    .chatbot-message.user .chatbot-message-avatar {
        background: #10b981;
        color: white;
        margin-left: 10px;
        order: 2;
    }
    
    .chatbot-message-bubble {
        max-width: 75%;
        padding: 12px 16px;
        border-radius: 18px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        line-height: 1.5;
        font-size: 14px;
        word-wrap: break-word;
    }
    
    .chatbot-message.bot .chatbot-message-bubble {
        background: white;
        color: #333;
        border-bottom-left-radius: 4px;
        border: 1px solid #e0e0e0;
    }
    
    .chatbot-message.user .chatbot-message-bubble {
        background: #667eea;
        color: white;
        border-bottom-right-radius: 4px;
    }
    
    .chatbot-book-card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 12px;
        margin-top: 10px;
        display: flex;
        gap: 12px;
        background: linear-gradient(135deg, #f8fafb 0%, #f0f1f5 100%);
        transition: all 0.2s;
        text-decoration: none;
        color: inherit;
    }
    
    .chatbot-book-card:hover {
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
        transform: translateY(-2px);
        border-color: #667eea;
    }
    
    .chatbot-book-card img {
        width: 55px;
        height: 75px;
        object-fit: cover;
        border-radius: 6px;
        flex-shrink: 0;
    }
    
    .chatbot-book-info {
        flex: 1;
        min-width: 0;
    }
    
    .chatbot-book-info h6 {
        margin: 0 0 4px 0;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #333;
    }
    
    .chatbot-book-info p {
        margin: 0;
        font-size: 11px;
        color: #666;
    }
    
    .chatbot-book-price {
        color: #10b981;
        font-weight: 700;
        font-size: 12px;
        margin-top: 4px;
    }
    
    .chatbot-quick-replies {
        padding: 12px 20px;
        background: white;
        border-top: 1px solid #e0e0e0;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        max-height: 90px;
        overflow-y: auto;
    }
    
    .chatbot-quick-reply {
        padding: 8px 14px;
        border: 1.5px solid #667eea;
        background: white;
        color: #667eea;
        border-radius: 20px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
        font-weight: 500;
    }
    
    .chatbot-quick-reply:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
    }
    
    .chatbot-input-area {
        padding: 15px 20px;
        background: white;
        border-top: 1px solid #e0e0e0;
        display: flex;
        gap: 10px;
        flex-shrink: 0;
    }
    
    .chatbot-input {
        flex: 1;
        border: 2px solid #e0e0e0;
        border-radius: 25px;
        padding: 10px 16px;
        font-size: 14px;
        outline: none;
        transition: border 0.2s;
        font-family: inherit;
    }
    
    .chatbot-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
    
    .chatbot-send {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #667eea;
        border: none;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        flex-shrink: 0;
        font-weight: 600;
    }
    
    .chatbot-send:hover:not(:disabled) {
        background: #5568d3;
        transform: scale(1.08);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    
    .chatbot-send:disabled {
        background: #9ca3af;
        cursor: not-allowed;
    }
    
    .chatbot-typing {
        display: none;
        padding: 10px 16px;
        background: white;
        border-radius: 18px;
        max-width: fit-content;
    }
    
    .chatbot-typing.active {
        display: block;
    }
    
    .chatbot-typing span {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #9ca3af;
        margin: 0 3px;
        animation: typing 1.4s infinite;
    }
    
    .chatbot-typing span:nth-child(2) { animation-delay: 0.2s; }
    .chatbot-typing span:nth-child(3) { animation-delay: 0.4s; }
    
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-8px); }
    }
    
    .chatbot-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        animation: bounce 2s infinite;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-8px); }
        60% { transform: translateY(-4px); }
    }
    
    @media (max-width: 768px) {
        .chatbot-window {
            width: calc(100vw - 20px);
            height: 70vh;
            bottom: 80px;
            left: 10px;
            right: auto;
            border-radius: 16px;
        }
        
        .chatbot-toggle {
            width: 56px;
            height: 56px;
            font-size: 22px;
        }
    }
    
    @media (max-width: 480px) {
        .chatbot-window {
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 100%;
            max-height: 100vh;
            border-radius: 0;
        }
        
        .chatbot-toggle {
            width: 56px;
            height: 56px;
            font-size: 22px;
            bottom: 20px;
            left: 20px;
        }
        
        .chatbot-message-bubble {
            max-width: 85%;
        }
    }
</style>

<div class="chatbot-widget">
    {{-- Toggle Button --}}
    <button class="chatbot-toggle" id="chatbotToggle" onclick="toggleChatbot()">
        <i class="fas fa-robot"></i>
        <span class="chatbot-badge" id="chatbotBadge" style="display: none;">1</span>
    </button>
    
    {{-- Chat Window --}}
    <div class="chatbot-window" id="chatbotWindow">
        {{-- Header --}}
        <div class="chatbot-header">
            <div class="chatbot-header-info">
                <div class="chatbot-avatar" style="width: 50px; height: 50px; background: white; padding: 0; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.15); border: 3px solid #667eea;">
                    <i class="fas fa-robot" style="font-size: 24px; color: #667eea;"></i>
                </div>
                <div class="chatbot-title">
                    <h3>Asisten Baleide</h3>
                    <p>Cari buku impianmu 📚</p>
                </div>
            </div>
            <button class="chatbot-close" onclick="toggleChatbot()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        {{-- Messages --}}
        <div class="chatbot-messages" id="chatbotMessages">
            <div class="chatbot-message bot">
                <div class="chatbot-message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="chatbot-message-bubble">
                    <strong>Halo, Chief! 👋</strong><br>
                    Saya <strong>Asisten Baleide</strong>, siap bantu kamu nemuin buku yang pas!<br><br>
                    <strong>Bingung mau baca buku apa?</strong> Cukup ceritain aja mood atau preferensi kamu, dan saya akan rekomendasikan buku terbaik untuk kamu!
                </div>
            </div>
        </div>
        
        {{-- Quick Replies --}}
        <div class="chatbot-quick-replies">
        </div>
        
        {{-- Input Area --}}
        <div class="chatbot-input-area">
            <input 
                type="text" 
                class="chatbot-input" 
                id="chatbotInput" 
                placeholder="Ketik pesan..."
                maxlength="500"
                onkeypress="if(event.key==='Enter') sendMessage()"
            >
            <button class="chatbot-send" id="chatbotSend" onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<script>
    let chatbotOpen = false;
    let firstOpen = true;
    
    function toggleChatbot() {
        const window = document.getElementById('chatbotWindow');
        const badge = document.getElementById('chatbotBadge');
        chatbotOpen = !chatbotOpen;
        
        if (chatbotOpen) {
            window.classList.add('active');
            badge.style.display = 'none';
            document.getElementById('chatbotInput').focus();
            scrollToBottom();
        } else {
            window.classList.remove('active');
        }
    }
    
    function scrollToBottom() {
        const messages = document.getElementById('chatbotMessages');
        messages.scrollTop = messages.scrollHeight;
    }
    
    function addMessage(content, type = 'bot', books = []) {
        const messages = document.getElementById('chatbotMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatbot-message ${type}`;
        
        const avatar = document.createElement('div');
        avatar.className = 'chatbot-message-avatar';
        avatar.innerHTML = type === 'user' ? '<i class="fas fa-user"></i>' : '<i class="fas fa-robot"></i>';
        
        const bubble = document.createElement('div');
        bubble.className = 'chatbot-message-bubble';
        bubble.innerHTML = content.replace(/\n/g, '<br>');
        
        // Tambahkan book cards jika ada
        if (books && books.length > 0) {
            books.forEach(book => {
                const bookCard = document.createElement('a');
                bookCard.href = book.url;
                bookCard.className = 'chatbot-book-card';
                bookCard.target = '_blank';
                bookCard.innerHTML = `
                    <img src="${book.cover}" alt="${book.title}">
                    <div class="chatbot-book-info">
                        <h6>${book.title}</h6>
                        <p>${book.author}</p>
                        <div class="chatbot-book-price">${book.price_formatted}</div>
                    </div>
                `;
                bubble.appendChild(bookCard);
            });
        }
        
        messageDiv.appendChild(avatar);
        messageDiv.appendChild(bubble);
        messages.appendChild(messageDiv);
        scrollToBottom();
    }
    
    function showTyping() {
        const messages = document.getElementById('chatbotMessages');
        const typingDiv = document.createElement('div');
        typingDiv.className = 'chatbot-message bot';
        typingDiv.id = 'typingIndicator';
        typingDiv.innerHTML = `
            <div class="chatbot-message-avatar"><i class="fas fa-robot"></i></div>
            <div class="chatbot-typing active">
                <span></span><span></span><span></span>
            </div>
        `;
        messages.appendChild(typingDiv);
        scrollToBottom();
    }
    
    function hideTyping() {
        const typing = document.getElementById('typingIndicator');
        if (typing) typing.remove();
    }
    
    async function sendMessage() {
        const input = document.getElementById('chatbotInput');
        const sendBtn = document.getElementById('chatbotSend');
        const message = input.value.trim();
        
        if (!message) return;
        
        // Tampilkan pesan user
        addMessage(message, 'user');
        input.value = '';
        sendBtn.disabled = true;
        input.disabled = true;
        
        // Tampilkan typing
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
                addMessage(data.message, 'bot', data.recommended_books);
            } else {
                addMessage('Maaf, terjadi kesalahan. Silakan coba lagi.', 'bot');
            }
        } catch (error) {
            hideTyping();
            addMessage('Maaf, koneksi bermasalah. Silakan coba lagi.', 'bot');
            console.error('Error:', error);
        }
        
        sendBtn.disabled = false;
        input.disabled = false;
        input.focus();
    }
    
    function sendQuickReply(text) {
        document.getElementById('chatbotInput').value = text;
        sendMessage();
    }
    
    // Show badge on first load
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            if (!chatbotOpen && firstOpen) {
                document.getElementById('chatbotBadge').style.display = 'flex';
            }
        }, 3000);
    });
</script>
