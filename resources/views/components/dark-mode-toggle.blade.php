<button id="dark-mode-toggle" class="dark-mode-toggle" title="Toggle Dark Mode">
    <span class="toggle-icon">🌙</span>
    <span class="toggle-text">Dark Mode</span>
</button>

<style>
    .dark-mode-toggle {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        background-color: #333;
        color: #ffd700;
        border: none;
        font-size: 1rem;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        z-index: 1000;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .dark-mode-toggle:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
    }

    html.dark-mode .dark-mode-toggle {
        background-color: #ffd700;
        color: #1a1a1a;
    }
</style>