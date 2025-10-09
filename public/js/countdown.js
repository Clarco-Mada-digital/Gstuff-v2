document.addEventListener('DOMContentLoaded', function() {
    // Vérifier quand la popup a été affichée pour la dernière fois
    const lastShown = getCookie('popupLastShown');
    const today = new Date().toDateString();

    // Fonctions de gestion des cookies
    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }

    // Fonction pour afficher la popup
    function showCountdownPopup(daysLeft, startDate) {
        const overlay = document.createElement('div');
        overlay.className = 'countdown-overlay';
        
        const popup = document.createElement('div');
        popup.className = 'countdown-popup';
        popup.innerHTML = `
            <div class="countdown-content">
                <span class="close-btn">&times;</span>
                <div class="popup-header">
                    <div class="icon-wrapper">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 8V12L15 15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h2>🎉 Offre Spéciale Limitée !</h2>
                </div>
                
                <div class="countdown-display">
                    <div class="countdown-box">
                        <div id="countdown-number">${daysLeft}</div>
                        <div class="countdown-label">JOURS RESTANTS</div>
                    </div>
                </div>
                
                <p class="offer-description">
                    Profitez de la <strong>gratuité totale</strong> pour publier vos annonces !
                </p>
                
                <div class="date-info">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="3" y="6" width="18" height="15" rx="2" stroke="currentColor" stroke-width="2"/>
                        <path d="M3 10H21M7 3V6M17 3V6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <span>Début de l'offre: ${new Date(startDate).toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' })}</span>
                </div>
                
                <div class="popup-actions">
                    <button id="dont-show-again" class="secondary-btn">
                        Ne plus afficher aujourd'hui
                    </button>
                </div>
            </div>
        `;
        
        // Styles améliorés
        const style = document.createElement('style');
        style.textContent = `
            .countdown-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.6) 100%);
                backdrop-filter: blur(5px);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1000;
                animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
            
            @keyframes slideIn {
                from { 
                    transform: translateY(-30px) scale(0.95); 
                    opacity: 0; 
                }
                to { 
                    transform: translateY(0) scale(1); 
                    opacity: 1; 
                }
            }
            
            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
            
            .countdown-popup {
                background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
                padding: 0;
                border-radius: 20px;
                text-align: center;
                max-width: 90%;
                width: 450px;
                position: relative;
                animation: slideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                overflow: hidden;
            }
            
            .countdown-content {
                padding: 2.5rem 2rem 2rem;
            }
            
            .popup-header {
                margin-bottom: 2rem;
            }
            
            .icon-wrapper {
                width: 70px;
                height: 70px;
                margin: 0 auto 1.5rem;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
                animation: pulse 2s ease-in-out infinite;
            }
            
            .icon-wrapper svg {
                width: 35px;
                height: 35px;
                color: white;
            }
            
            .popup-header h2 {
                font-size: 1.8rem;
                font-weight: 800;
                background: linear-gradient(135deg, #FDA5D6 0%,rgb(247, 143, 200) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                margin: 0;
                letter-spacing: -0.5px;
            }
            
            .countdown-display {
                margin: 2rem 0;
            }
            
            .countdown-box {
                background: linear-gradient(135deg, #FDA5D6 0%,rgb(212, 92, 158) 100%);
                border-radius: 15px;
                padding: 2rem;
                box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
                display: inline-block;
                min-width: 200px;
            }
            
            #countdown-number {
                font-size: 5rem;
                font-weight: 900;
                color: #ffffff;
                margin: 0;
                line-height: 1;
                text-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
                font-family: 'Arial Black', sans-serif;
            }
            
            .countdown-label {
                color: rgba(255, 255, 255, 0.9);
                font-size: 0.9rem;
                font-weight: 700;
                letter-spacing: 2px;
                margin-top: 0.5rem;
            }
            
            .offer-description {
                font-size: 1.1rem;
                color: #2d3748;
                margin: 1.5rem 0;
                line-height: 1.6;
            }
            
            .offer-description strong {
                color: #FDA5D6;
                font-weight: 700;
            }
            
            .date-info {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                background: #f7fafc;
                padding: 1rem;
                border-radius: 10px;
                margin: 1.5rem 0;
                border: 1px solid #e2e8f0;
            }
            
            .date-info svg {
                width: 20px;
                height: 20px;
                color: #FDA5D6;
            }
            
            .date-info span {
                color: #4a5568;
                font-size: 0.95rem;
            }
            
            .popup-actions {
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 1px solid #e2e8f0;
            }
            
            .secondary-btn {
                background: transparent;
                border: 2px solid #e2e8f0;
                color: #718096;
                padding: 0.75rem 1.5rem;
                border-radius: 10px;
                cursor: pointer;
                font-size: 0.95rem;
                font-weight: 600;
                transition: all 0.3s ease;
            }
            
            .secondary-btn:hover {
                background: #f7fafc;
                border-color: #cbd5e0;
                color: #4a5568;
                transform: translateY(-2px);
            }
            
            .close-btn {
                position: absolute;
                right: 20px;
                top: 20px;
                font-size: 28px;
                cursor: pointer;
                transition: all 0.3s ease;
                background: #f7fafc;
                border: none;
                width: 40px;
                height: 40px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #718096;
                line-height: 1;
                z-index: 10;
            }
            
            .close-btn:hover {
                background: #FDA5D6;
                color: white;
                transform: rotate(90deg);
            }
            
            @media (max-width: 500px) {
                .countdown-popup {
                    width: 95%;
                    margin: 1rem;
                }
                
                .countdown-content {
                    padding: 2rem 1.5rem 1.5rem;
                }
                
                .popup-header h2 {
                    font-size: 1.5rem;
                }
                
                #countdown-number {
                    font-size: 4rem;
                }
                
                .countdown-box {
                    min-width: 150px;
                    padding: 1.5rem;
                }
            }
        `;
        
        document.head.appendChild(style);
        overlay.appendChild(popup);
        document.body.appendChild(overlay);
        
        // Gestion de la fermeture
        const closeBtn = popup.querySelector('.close-btn');
        closeBtn.addEventListener('click', () => {
            overlay.style.animation = 'fadeOut 0.3s ease-in-out';
            setTimeout(() => document.body.removeChild(overlay), 300);
        });

        // Bouton "Ne plus afficher"
        const dontShowAgainBtn = popup.querySelector('#dont-show-again');
        dontShowAgainBtn.addEventListener('click', () => {
            setCookie('hideCountdown', 'true', 1);
            overlay.style.animation = 'fadeOut 0.3s ease-in-out';
            setTimeout(() => document.body.removeChild(overlay), 300);
        });
        
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.style.animation = 'fadeOut 0.3s ease-in-out';
                setTimeout(() => document.body.removeChild(overlay), 300);
            }
        });
    }

    // Vérifier si on doit afficher la popup
    if (!getCookie('hideCountdown') || lastShown !== today) {
        setTimeout(() => {
            fetch('/get-remaining-days', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.daysLeft > 0) {
                    setCookie('popupLastShown', today, 1);
                    showCountdownPopup(data.daysLeft, data.startDate);
                }
            })
            .catch(error => console.error('Erreur:', error));
        }, 20000);
    }
});