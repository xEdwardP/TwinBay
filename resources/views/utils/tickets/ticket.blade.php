<style>
    .ticket-card {
        position: relative;
        background: #fff;
        border: 2px dashed #ccc;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        height: 180px;
        transition: transform 0.2s ease;
    }

    .ticket-card:hover {
        transform: scale(1.02);
    }

    .ticket-status {
        position: absolute;
        top: -10px;
        right: -10px;
        background: #fff;
        border-radius: 50%;
        padding: 0.5rem;
        box-shadow: 0 0 0 2px #ccc;
    }

    .ticket-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .ticket-label {
        font-weight: bold;
        font-size: 1rem;
    }

    .ticket-action {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
    }
</style>
