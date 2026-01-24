/**
 * Product Inquiry Modal - WhatsApp QR Code Integration
 * 
 * Handles device-specific WhatsApp inquiry flow:
 * - Desktop: Opens modal with QR code
 * - Mobile: Redirects directly to WhatsApp
 * 
 * Dependencies: QRious library (already loaded in app.blade.php)
 */

(function() {
    'use strict';

    // Configuration
    const CONFIG = {
        modalId: 'whatsapp-inquiry-modal',
        mobileBreakpoint: 768,
        qrCodeSize: 200,
        buttonSelector: '[data-product-inquiry]'
    };

    /**
     * Device Detection
     * Checks both user agent and screen width for mobile devices
     */
    function isMobileDevice() {
        const mobileUserAgents = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i;
        const isMobileUA = mobileUserAgents.test(navigator.userAgent);
        const isMobileWidth = window.innerWidth < CONFIG.mobileBreakpoint;
        return isMobileUA || isMobileWidth;
    }

    /**
     * Create WhatsApp URL with pre-filled message
     * @param {Object} productData - Product information
     * @returns {string} - WhatsApp URL
     */
    function createWhatsAppUrl(productData) {
        const { name, sku, url, whatsappNumber } = productData;
        
        // Ensure we have a valid URL
        const productUrl = url && url.startsWith('http') ? url : window.location.href;

        // Construct message in specified format
        // Removed Price field as requested
        const message = `Hello 👋

I am interested in the following product:

📌 Product Name: ${name || 'N/A'}
🆔 Product Code: ${sku || 'N/A'}
🔗 Product Link: ${productUrl}

Please share more details.`;

        // Encode message for URL
        const encodedMessage = encodeURIComponent(message);
        
        // Clean phone number (remove non-digits)
        const cleanNumber = whatsappNumber.replace(/[^0-9]/g, '');
        
        // Return WhatsApp URL
        return `https://wa.me/${cleanNumber}?text=${encodedMessage}`;
    }

    /**
     * Create and render modal DOM
     * @returns {HTMLElement} - Modal element
     */
    function createModalElement() {
        const modal = document.createElement('div');
        modal.id = CONFIG.modalId;
        modal.className = 'whatsapp-modal-overlay';
        modal.setAttribute('role', 'dialog');
        modal.setAttribute('aria-modal', 'true');
        modal.setAttribute('aria-labelledby', 'modal-title');
        
        modal.innerHTML = `
            <div class="whatsapp-modal-content">
                <button class="whatsapp-modal-close" aria-label="Close modal">
                    <i class="bi bi-x-lg"></i>
                </button>
                
                <div class="whatsapp-modal-body">
                    <h3 id="modal-title" class="whatsapp-modal-title">
                        <i class="bi bi-whatsapp text-green-500"></i>
                        WhatsApp Inquiry
                    </h3>
                    
                    <p class="whatsapp-modal-subtitle">
                        Scan the QR code to chat with us on WhatsApp
                    </p>
                    
                    <div class="whatsapp-qr-container">
                        <canvas id="whatsapp-qr-code"></canvas>
                    </div>
                    
                    <p class="whatsapp-modal-hint">
                        Open WhatsApp on your phone and scan this code
                    </p>
                </div>
            </div>
        `;
        
        return modal;
    }

    /**
     * Generate QR Code using QRious
     * @param {string} url - URL to encode in QR
     */
    function generateQRCode(url) {
        const canvas = document.getElementById('whatsapp-qr-code');
        
        if (!canvas) {
            console.error('QR code canvas not found');
            return;
        }

        // Check if QRious is loaded
        if (typeof QRious === 'undefined') {
            console.error('QRious library not loaded');
            canvas.parentElement.innerHTML = '<p class="text-red-500 text-sm">QR code library not available</p>';
            return;
        }

        try {
            new QRious({
                element: canvas,
                value: url,
                size: CONFIG.qrCodeSize,
                level: 'H', // High error correction
                foreground: '#000000',
                background: '#ffffff'
            });
        } catch (error) {
            console.error('Error generating QR code:', error);
        }
    }

    /**
     * Open modal with product information
     * @param {Object} productData - Product information
     */
    function openInquiryModal(productData) {
        // Check if modal already exists, remove if so
        const existingModal = document.getElementById(CONFIG.modalId);
        if (existingModal) {
            existingModal.remove();
        }

        // Create WhatsApp URL
        const whatsappUrl = createWhatsAppUrl(productData);

        // Create and append modal
        const modal = createModalElement();
        const container = document.getElementById('whatsapp-modal-container') || document.body;
        container.appendChild(modal);

        // Generate QR code after modal is in DOM
        setTimeout(() => {
            generateQRCode(whatsappUrl);
        }, 50);

        // Prevent body scroll
        document.body.style.overflow = 'hidden';

        // Setup close handlers
        setupModalCloseHandlers(modal);

        // Fade in animation
        setTimeout(() => {
            modal.classList.add('active');
        }, 10);
    }

    /**
     * Setup modal close event handlers
     * @param {HTMLElement} modal - Modal element
     */
    function setupModalCloseHandlers(modal) {
        const closeButton = modal.querySelector('.whatsapp-modal-close');
        const overlay = modal;

        // Close on button click
        if (closeButton) {
            closeButton.addEventListener('click', () => closeModal(modal));
        }

        // Close on overlay click (not modal content)
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                closeModal(modal);
            }
        });

        // Close on Escape key
        const escapeHandler = (e) => {
            if (e.key === 'Escape') {
                closeModal(modal);
                document.removeEventListener('keydown', escapeHandler);
            }
        };
        document.addEventListener('keydown', escapeHandler);
    }

    /**
     * Close and remove modal
     * @param {HTMLElement} modal - Modal element
     */
    function closeModal(modal) {
        // Fade out animation
        modal.classList.remove('active');
        
        // Restore body scroll
        document.body.style.overflow = '';

        // Remove modal after transition
        setTimeout(() => {
            if (modal.parentNode) {
                modal.remove();
            }
        }, 300);
    }

    /**
     * Redirect to WhatsApp (mobile flow)
     * @param {string} url - WhatsApp URL
     */
    function redirectToWhatsApp(url) {
        window.open(url, '_blank');
    }

    /**
     * Extract product data from button element
     * @param {HTMLElement} button - Inquiry button
     * @returns {Object} - Product data
     */
    function extractProductData(button) {
        return {
            name: button.dataset.productName || 'Product',
            sku: button.dataset.productSku || 'N/A',
            price: button.dataset.productPrice || 'N/A',
            url: button.dataset.productUrl || window.location.href,
            whatsappNumber: button.dataset.whatsappNumber || '919928154903'
        };
    }

    /**
     * Handle inquiry button click
     * @param {Event} e - Click event
     */
    function handleInquiryClick(e) {
        e.preventDefault();
        e.stopPropagation();

        const button = e.currentTarget;
        const productData = extractProductData(button);

        if (isMobileDevice()) {
            // Mobile: Direct redirect
            const whatsappUrl = createWhatsAppUrl(productData);
            redirectToWhatsApp(whatsappUrl);
        } else {
            // Desktop: Open modal with QR
            openInquiryModal(productData);
        }
    }

    /**
     * Initialize product inquiry functionality
     */
    function initProductInquiry() {
        // Find all inquiry buttons
        const inquiryButtons = document.querySelectorAll(CONFIG.buttonSelector);

        if (inquiryButtons.length === 0) {
            console.log('No product inquiry buttons found');
            return;
        }

        // Attach event listeners
        inquiryButtons.forEach(button => {
            button.addEventListener('click', handleInquiryClick);
        });

        console.log(`Initialized ${inquiryButtons.length} product inquiry buttons`);
    }

    /**
     * Initialize on DOM ready
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProductInquiry);
    } else {
        initProductInquiry();
    }

    // Re-initialize on dynamic content changes (for AJAX-loaded products)
    window.reinitProductInquiry = initProductInquiry;

})();
